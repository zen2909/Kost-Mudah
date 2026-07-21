<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\BoardingHouse;
use App\Models\Owner;
use App\Models\Payment;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OwnerController extends Controller
{
    public function index(Request $request)
    {
        // Ambil user yang sedang login
        $user = Auth::user();
        $owner = Owner::where('user_id', $user->id)->first();

        // Ambil semua kost milik owner yang login
        $boardingHouseIds = BoardingHouse::where('user_id', $user->id)->pluck('id');
        $totalBoardingHouses = BoardingHouse::where('user_id', $user->id)->count();

        // Total penyewa aktif
        $totalActiveTenants = Rental::whereIn('boarding_house_id', $boardingHouseIds)
            ->where('status', 'paid')
            ->count();

        $totalTenants = Rental::whereIn('boarding_house_id', $boardingHouseIds)->count();

        // Pendapatan bulan ini
        $thisMonthRevenue = Payment::whereHas('rental', function ($q) use ($boardingHouseIds) {
            $q->whereIn('boarding_house_id', $boardingHouseIds);
        })
            ->where('status', 'verified')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('amount');

        // Pembayaran pending
        $pendingPayments = Payment::whereHas('rental', function ($q) use ($boardingHouseIds) {
            $q->whereIn('boarding_house_id', $boardingHouseIds);
        })
            ->where('status', 'pending')
            ->count();

        // Okupansi
        $totalRooms = BoardingHouse::where('user_id', $user->id)->sum('total_rooms');
        $availableRooms = BoardingHouse::where('user_id', $user->id)->sum('available_rooms');
        $occupiedRooms = $totalRooms - $availableRooms;
        $occupancyRate = $totalRooms > 0 ? round(($occupiedRooms / $totalRooms) * 100) : 0;

        // Filter tahun untuk grafik
        $selectedYear = $request->get('year', now()->year);

        // Data untuk grafik (12 bulan per tahun)
        $chartData = [];
        for ($month = 1; $month <= 12; $month++) {
            $monthName = date('M', mktime(0, 0, 0, $month, 1, $selectedYear));

            $revenue = Payment::whereHas('rental', function ($q) use ($boardingHouseIds) {
                $q->whereIn('boarding_house_id', $boardingHouseIds);
            })
                ->where('status', 'verified')
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $selectedYear)
                ->sum('amount');

            $chartData[] = [
                'month' => $monthName,
                'month_num' => $month,
                'revenue' => $revenue,
            ];
        }

        // Daftar tahun untuk filter - ambil dari data payment
        $years = Payment::whereHas('rental', function ($q) use ($boardingHouseIds) {
            $q->whereIn('boarding_house_id', $boardingHouseIds);
        })
            ->where('status', 'verified')
            ->select(DB::raw('DISTINCT EXTRACT(YEAR FROM created_at) as year'))
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->map(function ($item) {
                return (int) $item;
            })
            ->toArray();

        // Tambahkan tahun secara manual (5 tahun terakhir)
        $currentYear = now()->year;
        for ($i = 0; $i < 5; $i++) {
            $year = $currentYear - $i;
            if (! in_array($year, $years)) {
                $years[] = $year;
            }
        }
        rsort($years);

        // Jika tidak ada data, tambahkan tahun sekarang dan tahun sebelumnya
        if (empty($years)) {
            $years = [now()->year, now()->year - 1, now()->year - 2];
        }

        // Pastikan tahun yang dipilih ada di daftar, jika tidak tambahkan
        if (! in_array($selectedYear, $years)) {
            $years[] = $selectedYear;
            sort($years);
            $years = array_reverse($years);
        }

        // Data kost untuk tabel
        $boardingHouses = BoardingHouse::where('user_id', $user->id)
            ->withCount(['rentals' => function ($q) {
                $q->where('status', 'paid');
            }])
            ->limit(5)
            ->get();

        // Data pembayaran terbaru untuk tabel
        $recentPayments = Payment::with(['rental.tenant.user', 'rental.boardingHouse'])
            ->whereHas('rental', function ($q) use ($boardingHouseIds) {
                $q->whereIn('boarding_house_id', $boardingHouseIds);
            })
            ->latest()
            ->limit(5)
            ->get();

        return view('owner.index', compact(
            'user',
            'owner',
            'totalBoardingHouses',
            'totalActiveTenants',
            'totalTenants',
            'thisMonthRevenue',
            'pendingPayments',
            'occupancyRate',
            'occupiedRooms',
            'totalRooms',
            'availableRooms',
            'chartData',
            'boardingHouses',
            'recentPayments',
            'years',
            'selectedYear'
        ));
    }
}
