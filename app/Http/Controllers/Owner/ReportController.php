<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BoardingHouse;
use App\Models\Rental;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    /**
     * Display a listing of the reports.
     */
    public function index(Request $request)
    {
        // Ambil semua kost milik owner yang login
        $boardingHouseIds = BoardingHouse::where('user_id', Auth::id())->pluck('id');
        
        // Filter bulan dan tahun
        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);
        
        // Total Pendapatan berdasarkan filter
        $totalRevenue = Payment::whereHas('rental', function($q) use ($boardingHouseIds) {
                $q->whereIn('boarding_house_id', $boardingHouseIds);
            })
            ->where('status', 'verified')
            ->whereMonth('verified_at', $month)
            ->whereYear('verified_at', $year)
            ->sum('amount');
        
        // Target Pendapatan (contoh: 50.000.000)
        $revenueTarget = 50000000;
        
        // Pembayaran Tertunda (pending) berdasarkan filter
        $pendingPayments = Payment::whereHas('rental', function($q) use ($boardingHouseIds) {
                $q->whereIn('boarding_house_id', $boardingHouseIds);
            })
            ->where('status', 'pending')
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->count();
        
        $pendingAmount = Payment::whereHas('rental', function($q) use ($boardingHouseIds) {
                $q->whereIn('boarding_house_id', $boardingHouseIds);
            })
            ->where('status', 'pending')
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->sum('amount');
        
        // Total Unit (tidak berubah berdasarkan filter)
        $totalUnits = BoardingHouse::where('user_id', Auth::id())->sum('total_rooms');
        
        // Total Terisi
        $totalOccupied = BoardingHouse::where('user_id', Auth::id())->sum('total_rooms') - 
                         BoardingHouse::where('user_id', Auth::id())->sum('available_rooms');
        
        // Tingkat Okupansi
        $occupancyRate = $totalUnits > 0 ? round(($totalOccupied / $totalUnits) * 100) : 0;
        
        // Kamar tersedia
        $availableRooms = BoardingHouse::where('user_id', Auth::id())->sum('available_rooms');
        
        // Distribusi Properti berdasarkan tipe
        $distribution = BoardingHouse::where('user_id', Auth::id())
            ->select('type', \DB::raw('count(*) as total'))
            ->groupBy('type')
            ->get();
        
        // Data untuk chart (6 bulan terakhir berdasarkan filter tahun)
        $chartData = [];
        $currentMonth = $month;
        $currentYear = $year;
        
        for ($i = 5; $i >= 0; $i--) {
            $chartMonth = $currentMonth - $i;
            $chartYear = $currentYear;
            
            if ($chartMonth <= 0) {
                $chartMonth += 12;
                $chartYear -= 1;
            }
            
            $monthName = date('M', mktime(0, 0, 0, $chartMonth, 1, $chartYear));
            
            $revenue = Payment::whereHas('rental', function($q) use ($boardingHouseIds) {
                    $q->whereIn('boarding_house_id', $boardingHouseIds);
                })
                ->where('status', 'verified')
                ->whereMonth('verified_at', $chartMonth)
                ->whereYear('verified_at', $chartYear)
                ->sum('amount');
            
            $chartData[] = [
                'month' => $monthName,
                'revenue' => $revenue,
                'year' => $chartYear,
                'month_num' => $chartMonth,
            ];
        }
        
        // Pembayaran Tertunda (untuk table) berdasarkan filter
        $latePayments = Payment::with(['rental.tenant.user', 'rental.boardingHouse'])
            ->whereHas('rental', function($q) use ($boardingHouseIds) {
                $q->whereIn('boarding_house_id', $boardingHouseIds);
            })
            ->where('status', 'pending')
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Daftar tahun untuk filter (tahun dari data yang ada)
        $years = Payment::whereHas('rental', function($q) use ($boardingHouseIds) {
                $q->whereIn('boarding_house_id', $boardingHouseIds);
            })
            ->selectRaw('DISTINCT EXTRACT(YEAR FROM created_at) as year')
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();
        
        // Jika tidak ada data, tambahkan tahun sekarang
        if (empty($years)) {
            $years = [now()->year];
        }
        
        // Daftar bulan
        $months = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];
        
        return view('owner.report', compact(
            'totalRevenue',
            'revenueTarget',
            'pendingPayments',
            'pendingAmount',
            'totalUnits',
            'totalOccupied',
            'occupancyRate',
            'availableRooms',
            'distribution',
            'chartData',
            'latePayments',
            'month',
            'year',
            'years',
            'months'
        ));
    }
}