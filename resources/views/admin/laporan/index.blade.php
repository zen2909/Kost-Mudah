@extends('layouts.admin')

@section('title', 'System Analytics - KostMudah')

@section('content')
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
            <div>
                <h1 class="text-[#001220] text-2xl md:text-3xl font-bold">System Analytics</h1>
                <p class="text-[#42474C] text-sm mt-1">Reviewing performance metrics for all managed properties.</p>
            </div>
            <div class="flex items-center gap-3 mt-4 md:mt-0">
                <form method="GET" action="{{ route('admin.laporan.index') }}" class="flex items-center gap-3">
                    <div class="relative">
                        <select name="year"
                            class="px-4 py-2 border border-[#C3C7CD] rounded-lg bg-white text-sm focus:outline-none focus:ring-2 focus:ring-[#06283D] appearance-none pr-8">
                            <option value="{{ date('Y') }}" {{ $year == date('Y') ? 'selected' : '' }}>Yearly
                                {{ date('Y') }}</option>
                            <option value="{{ date('Y') - 1 }}" {{ $year == date('Y') - 1 ? 'selected' : '' }}>Yearly
                                {{ date('Y') - 1 }}</option>
                            <option value="{{ date('Y') - 2 }}" {{ $year == date('Y') - 2 ? 'selected' : '' }}>Yearly
                                {{ date('Y') - 2 }}</option>
                        </select>
                        <svg class="w-3 h-3 absolute right-3 top-1/2 -translate-y-1/2 text-[#42474C]" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                    <button type="submit"
                        class="px-4 py-2 bg-[#06283D] text-white text-sm font-semibold rounded-lg hover:bg-[#001220] transition-colors shadow-sm">
                        Apply
                    </button>
                </form>
                <button
                    class="flex items-center gap-2 px-4 py-2 border border-[#C3C7CD] rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors">
                    <svg class="w-3.5 h-3.5 text-[#191C1D]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Export Report
                </button>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <!-- Total Revenue -->
            <div
                class="bg-white p-6 rounded-xl border border-[#C3C7CD] shadow-sm hover:shadow-md transition-shadow relative overflow-hidden">
                <div class="flex justify-between items-start">
                    <div class="w-10 h-10 bg-[#CCE5FF] rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-[#004B72]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v1m0 1V9m0 1v1m0 1V9m0 1v1M12 8v1m0 1V9m0 1v1m0 1V9m0 1v1m0 0v1M9 15h6" />
                        </svg>
                    </div>
                    <span
                        class="px-2 py-1 {{ $revenueGrowth >= 0 ? 'bg-[#CCE5FF] text-[#004B72]' : 'bg-[#FFDAD6] text-[#BA1A1A]' }} rounded-sm text-xs font-bold">{{ $revenueGrowth >= 0 ? '+' : '' }}{{ $revenueGrowth }}%</span>
                </div>
                <div class="mt-4">
                    <p class="text-[#42474C] text-xs font-bold uppercase tracking-wide">TOTAL REVENUE</p>
                    <p class="text-[#191C1D] text-xl font-extrabold mt-1">Rp
                        {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                </div>
                <div class="absolute -right-8 -bottom-8 opacity-5 rotate-12">
                    <div class="w-40 h-32 bg-zinc-900"></div>
                </div>
            </div>

            <!-- New Properties -->
            <div
                class="bg-white p-6 rounded-xl border border-[#C3C7CD] shadow-sm hover:shadow-md transition-shadow relative overflow-hidden">
                <div class="flex justify-between items-start">
                    <div class="w-10 h-10 bg-[#CCE5FF] rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-[#004B72]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <span
                        class="px-2 py-1 {{ $propertiesGrowth >= 0 ? 'bg-[#CCE5FF] text-[#004B72]' : 'bg-[#FFDAD6] text-[#BA1A1A]' }} rounded-sm text-xs font-bold">{{ $propertiesGrowth >= 0 ? '+' : '' }}{{ $propertiesGrowth }}%</span>
                </div>
                <div class="mt-4">
                    <p class="text-[#42474C] text-xs font-bold uppercase tracking-wide">NEW PROPERTIES</p>
                    <p class="text-[#191C1D] text-xl font-extrabold mt-1">{{ number_format($newProperties) }} Units</p>
                </div>
                <div class="absolute -right-8 -bottom-8 opacity-5 rotate-12">
                    <div class="w-40 h-36 bg-zinc-900"></div>
                </div>
            </div>

            <!-- Active Tenants -->
            <div
                class="bg-white p-6 rounded-xl border border-[#C3C7CD] shadow-sm hover:shadow-md transition-shadow relative overflow-hidden">
                <div class="flex justify-between items-start">
                    <div class="w-10 h-10 bg-[#CCE5FF] rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-[#004B72]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <span
                        class="px-2 py-1 {{ $tenantsGrowth >= 0 ? 'bg-[#CCE5FF] text-[#004B72]' : 'bg-[#FFDAD6] text-[#BA1A1A]' }} rounded-sm text-xs font-bold">{{ $tenantsGrowth >= 0 ? '+' : '' }}{{ $tenantsGrowth }}%</span>
                </div>
                <div class="mt-4">
                    <p class="text-[#42474C] text-xs font-bold uppercase tracking-wide">ACTIVE TENANTS</p>
                    <p class="text-[#191C1D] text-xl font-extrabold mt-1">{{ number_format($activeTenants) }}</p>
                </div>
                <div class="absolute -right-8 -bottom-8 opacity-5 rotate-12">
                    <div class="w-40 h-32 bg-zinc-900"></div>
                </div>
            </div>

            <!-- Churn Rate -->
            <div
                class="bg-white p-6 rounded-xl border border-[#C3C7CD] shadow-sm hover:shadow-md transition-shadow relative overflow-hidden">
                <div class="flex justify-between items-start">
                    <div class="w-10 h-10 bg-[#FFDAD6] rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-[#BA1A1A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                    <span
                        class="px-2 py-1 {{ $churnRate <= 5 ? 'bg-[#CCE5FF] text-[#004B72]' : 'bg-[#FFDAD6] text-[#BA1A1A]' }} rounded-sm text-xs font-bold">{{ $churnRate }}%</span>
                </div>
                <div class="mt-4">
                    <p class="text-[#42474C] text-xs font-bold uppercase tracking-wide">CHURN RATE</p>
                    <p class="text-[#191C1D] text-xl font-extrabold mt-1">{{ $churnRate }}%</p>
                </div>
                <div class="absolute -right-8 -bottom-8 opacity-5 rotate-12">
                    <div class="w-36 h-24 bg-zinc-900"></div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Revenue Growth Chart -->
            <x-admin.revenue-chart :year="$year" :previousYear="$previousYear" :monthlyRevenue="$monthlyRevenue" :monthlyRevenuePrev="$monthlyRevenuePrev" :maxRevenue="$maxRevenue"
                :chartMaxHeight="$chartMaxHeight" />

            <!-- User Growth Chart -->
            <x-admin.user-growth-chart :quarters="$quarters" :ownerGrowth="$ownerGrowth" :tenantGrowth="$tenantGrowth" />
        </div>

        <!-- Monthly Summary Table -->
        <div class="bg-white rounded-xl border border-[#C3C7CD] shadow-sm overflow-hidden">
            <!-- Header -->
            <div
                class="px-6 py-5 bg-[#F8FAFB] border-b border-[#C3C7CD] flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <h3 class="text-[#191C1D] text-xl font-semibold">Ringkasan Bulanan ({{ $year }})</h3>
                <div class="flex items-center gap-2">
                    <button class="p-2 rounded-lg border border-[#C3C7CD] hover:bg-gray-50 transition-colors">
                        <svg class="w-4 h-4 text-[#42474C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                        </svg>
                    </button>
                    <button class="p-2 rounded-lg border border-[#C3C7CD] hover:bg-gray-50 transition-colors">
                        <svg class="w-4 h-4 text-[#42474C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full min-w-[700px]">
                    <thead class="bg-[#F2F4F5] border-b border-[#C3C7CD]">
                        <tr>
                            <th class="text-left text-[#42474C] text-xs font-black tracking-wider py-4 px-6 w-[156px]">
                                MONTH</th>
                            <th class="text-left text-[#42474C] text-xs font-black tracking-wider py-4 px-6 w-[176px]">
                                REVENUE</th>
                            <th class="text-left text-[#42474C] text-xs font-black tracking-wider py-4 px-6 w-[186px]">
                                REGISTRATIONS</th>
                            <th class="text-left text-[#42474C] text-xs font-black tracking-wider py-4 px-6 w-[146px]">
                                STATUS</th>
                            <th class="text-right text-[#42474C] text-xs font-black tracking-wider py-4 px-6 w-[100px]">
                                ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($monthlySummary as $data)
                            <tr class="border-b border-[#C3C7CD] hover:bg-gray-50/30 transition-colors">
                                <td class="py-4 px-6">
                                    <p class="text-[#191C1D] text-base font-bold">{{ $data['month'] }}</p>
                                </td>
                                <td class="py-4 px-6">
                                    <p class="text-[#42474C] text-base">Rp
                                        {{ number_format($data['revenue'], 0, ',', '.') }}</p>
                                </td>
                                <td class="py-4 px-6">
                                    <p class="text-[#42474C] text-base">{{ number_format($data['registrations']) }} Users
                                    </p>
                                </td>
                                <td class="py-4 px-6">
                                    <span
                                        class="inline-flex items-center gap-1.5 px-3 py-1 {{ $data['statusClass'] }} text-[10px] font-bold rounded-full">
                                        <span class="w-1.5 h-1.5 {{ $data['statusDot'] }} rounded-full"></span>
                                        {{ $data['status'] }}
                                    </span>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex justify-end">
                                        <button class="p-2 rounded-lg hover:bg-gray-100 transition-colors">
                                            <svg class="w-4 h-4 text-[#42474C]" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div
                class="px-6 py-4 bg-[#F8FAFB] border-t border-[#C3C7CD] flex flex-col sm:flex-row justify-between items-center gap-4">
                <span class="text-[#42474C] text-sm font-medium">Showing 1-12 of 12 months</span>
                <div class="flex gap-2">
                    <button
                        class="w-8 h-8 flex items-center justify-center rounded border border-[#C3C7CD] opacity-50 cursor-not-allowed"
                        disabled>
                        <svg class="w-2 h-3 text-[#42474C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button
                        class="w-8 h-8 flex items-center justify-center rounded bg-[#06283D] text-white font-bold text-sm">1</button>
                    <button
                        class="w-8 h-8 flex items-center justify-center rounded border border-[#C3C7CD] text-[#42474C] text-sm hover:bg-gray-50 transition-colors">2</button>
                    <button
                        class="w-8 h-8 flex items-center justify-center rounded border border-[#C3C7CD] text-[#42474C] text-sm hover:bg-gray-50 transition-colors">3</button>
                    <button
                        class="w-8 h-8 flex items-center justify-center rounded border border-[#C3C7CD] hover:bg-gray-50 transition-colors">
                        <svg class="w-2 h-3 text-[#42474C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
