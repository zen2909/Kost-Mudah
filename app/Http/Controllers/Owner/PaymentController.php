<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rental;
use App\Models\Payment;
use App\Models\BoardingHouse;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * Display a listing of the payments.
     */
    public function index(Request $request)
    {
        // Ambil semua kost milik owner yang login
        $boardingHouseIds = BoardingHouse::where('user_id', Auth::id())->pluck('id');
        
        // Query untuk mendapatkan semua payment dari rental yang terkait
        $query = Payment::with(['rental.tenant.user', 'rental.boardingHouse'])
            ->whereHas('rental', function($q) use ($boardingHouseIds) {
                $q->whereIn('boarding_house_id', $boardingHouseIds);
            });
        
        // Filter berdasarkan status pembayaran
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        // Filter berdasarkan metode pembayaran
        if ($request->has('method') && $request->method != '') {
            $query->where('method', $request->method);
        }
        
        // Filter berdasarkan tanggal
        if ($request->has('date') && $request->date != '') {
            $query->whereDate('created_at', $request->date);
        }
        
        // Filter berdasarkan pencarian
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('rental.tenant.user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        
        // Ambil data dengan pagination
        $payments = $query->latest()->paginate(10);
        
        // Hitung statistik
        $totalPayments = Payment::whereHas('rental', function($q) use ($boardingHouseIds) {
            $q->whereIn('boarding_house_id', $boardingHouseIds);
        })->count();
        
        $pendingPayments = Payment::whereHas('rental', function($q) use ($boardingHouseIds) {
            $q->whereIn('boarding_house_id', $boardingHouseIds);
        })->where('status', 'pending')->count();
        
        $verifiedPayments = Payment::whereHas('rental', function($q) use ($boardingHouseIds) {
            $q->whereIn('boarding_house_id', $boardingHouseIds);
        })->where('status', 'verified')->count();
        
        $totalRevenue = Payment::whereHas('rental', function($q) use ($boardingHouseIds) {
            $q->whereIn('boarding_house_id', $boardingHouseIds);
        })->where('status', 'verified')->sum('amount');
        
        // Tagihan mendatang (rental yang end_date <= 7 hari)
        $upcomingInvoices = Rental::with(['tenant.user', 'boardingHouse'])
            ->whereIn('boarding_house_id', $boardingHouseIds)
            ->where('status', 'paid')
            ->where('end_date', '<=', now()->addDays(7))
            ->where('end_date', '>=', now())
            ->limit(5)
            ->get();
        
        // Ambil daftar properti untuk filter (opsional bisa ditambahkan)
        $properties = BoardingHouse::where('user_id', Auth::id())->get();
        
        return view('owner.payment', compact(
            'payments',
            'totalPayments',
            'pendingPayments',
            'verifiedPayments',
            'totalRevenue',
            'upcomingInvoices',
            'properties'
        ));
    }

    /**
     * Verify payment (approve payment).
     */
    public function verify(Request $request, string $id)
    {
        $payment = Payment::with(['rental'])
            ->whereHas('rental.boardingHouse', function($q) {
                $q->where('user_id', Auth::id());
            })
            ->findOrFail($id);
        
        // Update status payment
        $payment->update([
            'status' => 'verified',
            'verified_at' => now(),
        ]);
        
        // Update status rental menjadi paid
        $payment->rental->update([
            'status' => 'paid',
        ]);
        
        return redirect()->route('owner.payment.index')
            ->with('success', 'Pembayaran berhasil diverifikasi!');
    }

    /**
     * Reject payment.
     */
    public function reject(Request $request, string $id)
    {
        $payment = Payment::with(['rental'])
            ->whereHas('rental.boardingHouse', function($q) {
                $q->where('user_id', Auth::id());
            })
            ->findOrFail($id);
        
        $payment->update([
            'status' => 'rejected',
            'verified_at' => null,
        ]);
        
        return redirect()->route('owner.payment.index')
            ->with('success', 'Pembayaran ditolak!');
    }

    /**
     * Display the specified payment.
     */
    public function show(string $id)
    {
        $payment = Payment::with(['rental.tenant.user', 'rental.boardingHouse'])
            ->whereHas('rental.boardingHouse', function($q) {
                $q->where('user_id', Auth::id());
            })
            ->findOrFail($id);
        
        return view('owner.payment.show', compact('payment'));
    }
}