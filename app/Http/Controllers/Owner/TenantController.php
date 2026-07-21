<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rental;
use App\Models\BoardingHouse;
use Illuminate\Support\Facades\Auth;

class TenantController extends Controller
{
    public function index(Request $request)
    {
        $boardingHouseIds = BoardingHouse::where('user_id', Auth::id())->pluck('id');
        
        $query = Rental::with(['tenant.user', 'boardingHouse', 'payment'])
            ->whereIn('boarding_house_id', $boardingHouseIds)
            ->whereIn('status', ['paid', 'pending']);
        
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('tenant.user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        
        if ($request->has('property') && $request->property != '') {
            $query->where('boarding_house_id', $request->property);
        }
        
        if ($request->has('rental_status') && $request->rental_status != '') {
            $query->where('status', $request->rental_status);
        }
        
        if ($request->has('payment_status') && $request->payment_status != '') {
            $query->whereHas('payment', function($q) use ($request) {
                $q->where('status', $request->payment_status);
            });
        }
        
        $rentals = $query->paginate(10);
        
        $totalRentals = Rental::whereIn('boarding_house_id', $boardingHouseIds)
            ->whereIn('status', ['paid', 'pending'])
            ->count();
        
        $paidRentals = Rental::whereIn('boarding_house_id', $boardingHouseIds)
            ->where('status', 'paid')
            ->whereHas('payment', function($q) {
                $q->where('status', 'verified');
            })
            ->count();
        
        $pendingRentals = Rental::whereIn('boarding_house_id', $boardingHouseIds)
            ->where('status', 'pending')
            ->count();
        
        $expiringSoon = Rental::whereIn('boarding_house_id', $boardingHouseIds)
            ->whereIn('status', ['paid', 'pending'])
            ->where('end_date', '<=', now()->addDays(30))
            ->where('end_date', '>=', now())
            ->count();
        
        $properties = BoardingHouse::where('user_id', Auth::id())->get();
        
        return view('owner.tenant', compact(
            'rentals',
            'totalRentals',
            'paidRentals',
            'pendingRentals',
            'expiringSoon',
            'properties'
        ));
    }

    public function show(string $id)
    {
        $rental = Rental::with(['tenant.user', 'boardingHouse', 'payment'])
            ->whereHas('boardingHouse', function($q) {
                $q->where('user_id', Auth::id());
            })
            ->findOrFail($id);
        
        return view('owner.penyewa.show', compact('rental'));
    }
}