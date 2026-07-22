<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Rental;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    public function index(Request $request)
    {
        // Ambil semua user dengan role tenant
        $query = User::query()
            ->where('role', 'tenant')
            ->orWhereHas('roles', function ($q) {
                $q->where('name', 'tenant');
            });

        // Filter by search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('phone', 'LIKE', "%{$search}%");
            });
        }

        // Filter by gender
        if ($request->filled('gender')) {
            $query->whereHas('tenant', function ($q) use ($request) {
                $q->where('gender', $request->gender);
            });
        }

        $tenants = $query->with(['tenant', 'rentals' => function ($q) {
            $q->with(['boardingHouse'])->where('status', 'paid');
        }])
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        // Hitung statistik
        $totalTenants = User::where('role', 'tenant')
            ->orWhereHas('roles', function ($q) {
                $q->where('name', 'tenant');
            })
            ->count();

        $activeTenants = User::where('role', 'tenant')
            ->orWhereHas('roles', function ($q) {
                $q->where('name', 'tenant');
            })
            ->whereHas('rentals', function ($q) {
                $q->where('status', 'paid');
            })
            ->count();

        $inactiveTenants = $totalTenants - $activeTenants;

        $dueSoon = Rental::where('status', 'paid')
            ->whereDate('end_date', '<=', now()->addDays(7))
            ->whereDate('end_date', '>=', now())
            ->count();

        $waitingPayment = Rental::where('status', 'pending')->count();

        return view('admin.penyewa.index', compact(
            'tenants',
            'totalTenants',
            'activeTenants',
            'inactiveTenants',
            'dueSoon',
            'waitingPayment'
        ));
    }

    public function show($id)
    {
        $tenant = User::with(['tenant', 'rentals' => function ($q) {
            $q->with(['boardingHouse']);
        }])
            ->whereHas('roles', function ($q) {
                $q->where('name', 'tenant');
            })
            ->findOrFail($id);

        return view('admin.penyewa.show', compact('tenant'));
    }
}