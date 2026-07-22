<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BoardingHouse;
use App\Models\User;
use App\Models\Tenant;
use App\Models\Owner;
use App\Models\Rental;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->get('year', date('Y'));
        $previousYear = $year - 1;

        // ============================================
        // STATISTICS CARDS
        // ============================================
        
        // Total Revenue (dari rental yang statusnya paid)
        $totalRevenue = Rental::where('status', 'paid')->sum('total_price');
        
        // Revenue growth (perbandingan dengan tahun lalu)
        $revenueLastYear = Rental::where('status', 'paid')
            ->whereYear('created_at', $previousYear)
            ->sum('total_price');
        
        $revenueGrowth = $revenueLastYear > 0 
            ? round((($totalRevenue - $revenueLastYear) / $revenueLastYear) * 100, 1)
            : 0;

        // New Properties (tahun ini)
        $newProperties = BoardingHouse::whereYear('created_at', $year)->count();
        
        // New Properties growth
        $propertiesLastYear = BoardingHouse::whereYear('created_at', $previousYear)->count();
        $propertiesGrowth = $propertiesLastYear > 0 
            ? round((($newProperties - $propertiesLastYear) / $propertiesLastYear) * 100, 1)
            : 0;

        // Active Tenants (yang memiliki rental aktif)
        $activeTenants = Tenant::whereHas('rentals', function ($q) {
            $q->where('status', 'paid');
        })->count();
        
        // Active Tenants growth
        $tenantsLastYear = Tenant::whereHas('rentals', function ($q) {
            $q->where('status', 'paid');
        })->whereYear('created_at', $previousYear)->count();
        $tenantsGrowth = $tenantsLastYear > 0 
            ? round((($activeTenants - $tenantsLastYear) / $tenantsLastYear) * 100, 1)
            : 0;

        // Churn Rate (persentase tenant yang tidak aktif)
        $totalTenants = Tenant::count();
        $churnRate = $totalTenants > 0 
            ? round((($totalTenants - $activeTenants) / $totalTenants) * 100, 1)
            : 0;

        // ============================================
        // CHART DATA - Revenue Growth
        // ============================================
        $monthlyRevenue = [];
        $monthlyRevenuePrev = [];
        for ($month = 1; $month <= 12; $month++) {
            // Current year
            $revenue = Rental::where('status', 'paid')
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->sum('total_price');
            $monthlyRevenue[] = $revenue;
            
            // Previous year
            $revenuePrev = Rental::where('status', 'paid')
                ->whereYear('created_at', $previousYear)
                ->whereMonth('created_at', $month)
                ->sum('total_price');
            $monthlyRevenuePrev[] = $revenuePrev;
        }
        
        $maxRevenue = max(array_merge($monthlyRevenue, $monthlyRevenuePrev, [1]));
        $chartMaxHeight = 180;

        // ============================================
        // CHART DATA - User Growth (per quarter)
        // ============================================
        $quarters = ['Q1', 'Q2', 'Q3', 'Q4'];
        $ownerGrowth = [];
        $tenantGrowth = [];
        
        for ($q = 1; $q <= 4; $q++) {
            $startMonth = ($q - 1) * 3 + 1;
            $endMonth = $q * 3;
            
            $owners = User::where('role', 'owner')
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', '>=', $startMonth)
                ->whereMonth('created_at', '<=', $endMonth)
                ->count();
            $ownerGrowth[] = $owners * 5; // Scaling for chart
            
            $tenants = User::where('role', 'tenant')
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', '>=', $startMonth)
                ->whereMonth('created_at', '<=', $endMonth)
                ->count();
            $tenantGrowth[] = $tenants * 5; // Scaling for chart
        }

        // ============================================
        // MONTHLY SUMMARY TABLE
        // ============================================
        $monthlySummary = [];
        $months = ['January', 'February', 'March', 'April', 'May', 'June', 
                   'July', 'August', 'September', 'October', 'November', 'December'];
        
        foreach ($months as $index => $monthName) {
            $month = $index + 1;
            
            $revenue = Rental::where('status', 'paid')
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->sum('total_price');
            
            $registrations = User::where('role', 'tenant')
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->count();
            
            // Determine status
            if ($revenue > 15000000) {
                $status = 'GROWING';
                $statusClass = 'bg-[#CCE5FF] text-[#004B72]';
                $statusDot = 'bg-[#004B72]';
            } elseif ($revenue > 10000000) {
                $status = 'STABLE';
                $statusClass = 'bg-[#E8F5E9] text-[#2E7D32]';
                $statusDot = 'bg-[#2E7D32]';
            } else {
                $status = 'DECLINING';
                $statusClass = 'bg-[#FFDAD6] text-[#BA1A1A]';
                $statusDot = 'bg-[#BA1A1A]';
            }
            
            $monthlySummary[] = [
                'month' => $monthName,
                'revenue' => $revenue,
                'registrations' => $registrations,
                'status' => $status,
                'statusClass' => $statusClass,
                'statusDot' => $statusDot,
            ];
        }

        return view('admin.laporan.index', compact(
            'totalRevenue',
            'revenueGrowth',
            'newProperties',
            'propertiesGrowth',
            'activeTenants',
            'tenantsGrowth',
            'churnRate',
            'year',
            'previousYear',
            'monthlyRevenue',
            'monthlyRevenuePrev',
            'monthlySummary',
            'ownerGrowth',
            'tenantGrowth',
            'quarters',  // <-- Tambahkan ini
            'maxRevenue',
            'chartMaxHeight'
        ));
    }
}