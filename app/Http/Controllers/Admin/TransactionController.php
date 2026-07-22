<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        // Ambil semua rental dengan relasi yang diperlukan
        $query = Rental::with(['tenant.user', 'boardingHouse', 'payments']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->filled('date_range')) {
            if ($request->date_range === '7_days') {
                $query->where('created_at', '>=', now()->subDays(7));
            } elseif ($request->date_range === '30_days') {
                $query->where('created_at', '>=', now()->subDays(30));
            } elseif ($request->date_range === '90_days') {
                $query->where('created_at', '>=', now()->subDays(90));
            }
        }

        // Filter by search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('unique_code', 'LIKE', "%{$search}%")
                    ->orWhereHas('tenant.user', function ($u) use ($search) {
                        $u->where('name', 'LIKE', "%{$search}%")
                            ->orWhere('email', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('boardingHouse', function ($b) use ($search) {
                        $b->where('name', 'LIKE', "%{$search}%");
                    });
            });
        }

        $transactions = $query->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        // Hitung statistik
        // Total Revenue (dari rental yang statusnya paid)
        $totalRevenue = Rental::where('status', 'paid')->sum('total_price');

        // Pending Payments
        $pendingPayments = Rental::where('status', 'pending')->count();
        $pendingAmount = Rental::where('status', 'pending')->sum('total_price');

        // Successful (paid)
        $successfulCount = Rental::where('status', 'paid')->count();

        // Cancelled
        $cancelledCount = Rental::where('status', 'cancelled')->count();

        return view('admin.transaksi.index', compact(
            'transactions',
            'totalRevenue',
            'pendingPayments',
            'pendingAmount',
            'successfulCount',
            'cancelledCount'
        ));
    }

    public function show($id)
    {
        $transaction = Rental::with([
            'tenant.user',
            'boardingHouse',
            'payments.verifiedBy'
        ])->findOrFail($id);

        return view('admin.transaksi.show', compact('transaction'));
    }
}