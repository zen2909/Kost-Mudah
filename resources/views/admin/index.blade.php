@extends('layouts.admin')

@section('title', 'Dashboard Admin - KostMudah')

@section('content')
    <div class="max-w-7xl mx-auto space-y-6">
        <!-- Hero Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Total Users Card -->
            <div
                class="bg-white p-5 rounded-xl border border-[#C3C7CD] shadow-sm flex flex-col gap-3 transition-all hover:shadow-md">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-[#42474C] text-[10px] font-semibold tracking-wider uppercase">Total Users</p>
                        <h3 class="text-2xl font-bold text-[#001220]">1,284</h3>
                    </div>
                    <div class="p-2 rounded-lg bg-[#06283D]/5 text-[#06283D]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                </div>
                <div class="flex items-end justify-between mt-auto">
                    <div class="flex items-center gap-1 text-green-600 text-xs font-bold">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                        +12.5%
                    </div>
                    <div class="flex items-end gap-[2px] h-6">
                        <div class="w-1 bg-[#06283D]/20 h-2 rounded-full"></div>
                        <div class="w-1 bg-[#06283D]/20 h-4 rounded-full"></div>
                        <div class="w-1 bg-[#06283D]/20 h-3 rounded-full"></div>
                        <div class="w-1 bg-[#06283D]/20 h-5 rounded-full"></div>
                        <div class="w-1 bg-[#06283D] h-6 rounded-full"></div>
                    </div>
                </div>
            </div>

            <!-- Pending Verifications Card -->
            <div
                class="bg-white p-5 rounded-xl border border-[#C3C7CD] shadow-sm flex flex-col gap-3 transition-all hover:shadow-md relative overflow-hidden">
                <div class="absolute top-0 right-0 w-1.5 h-full bg-[#BA1A1A]"></div>
                <div class="flex justify-between items-start pr-4">
                    <div>
                        <p class="text-[#42474C] text-[10px] font-semibold tracking-wider uppercase">Pending Verifications
                        </p>
                        <h3 class="text-2xl font-bold text-[#001220]">23</h3>
                    </div>
                    <div class="p-2 rounded-lg bg-[#FFDAD6] text-[#93000A]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                </div>
                <p class="text-[11px] text-[#BA1A1A] font-medium flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    Action required immediately
                </p>
            </div>

            <!-- Active Listings Card -->
            <div
                class="bg-white p-5 rounded-xl border border-[#C3C7CD] shadow-sm flex flex-col gap-3 transition-all hover:shadow-md">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-[#42474C] text-[10px] font-semibold tracking-wider uppercase">Active Listings</p>
                        <h3 class="text-2xl font-bold text-[#001220]">452</h3>
                    </div>
                    <div class="p-2 rounded-lg bg-[#CFE6EF] text-[#4C6269]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                </div>
                <div class="space-y-1">
                    <div class="flex justify-between text-[10px] text-[#42474C] font-medium">
                        <span>Putri: 210</span>
                        <span>Putra: 150</span>
                        <span>Mix: 92</span>
                    </div>
                    <div class="w-full h-1.5 bg-[#F2F4F5] rounded-full overflow-hidden flex">
                        <div class="bg-[#06283D] w-[46%]"></div>
                        <div class="bg-[#4C6269] w-[33%]"></div>
                        <div class="bg-[#73777D] w-[21%]"></div>
                    </div>
                </div>
            </div>

            <!-- Revenue Card -->
            <div
                class="bg-white p-5 rounded-xl border border-[#C3C7CD] shadow-sm flex flex-col gap-3 transition-all hover:shadow-md">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-[#42474C] text-[10px] font-semibold tracking-wider uppercase">Total Revenue (MTD)</p>
                        <h3 class="text-2xl font-bold text-[#001220]">Rp 45.2M</h3>
                    </div>
                    <div class="p-2 rounded-lg bg-green-50 text-green-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v4m0 4v4m-6-6h2m6 0h2" />
                        </svg>
                    </div>
                </div>
                <div class="space-y-1 mt-auto">
                    <div class="flex justify-between text-[10px]">
                        <span class="font-bold text-[#001220]">90% of target</span>
                        <span class="text-[#42474C]">Target: 50M</span>
                    </div>
                    <div class="w-full h-2 bg-[#F2F4F5] rounded-full">
                        <div class="bg-green-500 h-full rounded-full" style="width: 90%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Revenue & Activity -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            <!-- Data Visualization Section -->
            <div class="lg:col-span-2 space-y-4">
                <div class="bg-white p-6 rounded-xl border border-[#C3C7CD] shadow-sm">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-[#001220] text-xl font-semibold">Revenue & Growth Trends</h3>
                        <select
                            class="text-xs bg-[#F2F4F5] border border-[#C3C7CD] rounded-lg py-1 pl-2 pr-8 focus:outline-none focus:ring-2 focus:ring-[#06283D] appearance-none">
                            <option>Last 6 Months</option>
                            <option>Last 12 Months</option>
                        </select>
                    </div>
                    <div
                        class="h-64 w-full bg-[#F2F4F5] rounded-lg relative flex items-end justify-between px-8 py-4 overflow-hidden border border-dashed border-[#C3C7CD]/30">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="text-[#42474C] text-sm flex flex-col items-center gap-2">
                                <svg class="w-10 h-10 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                                [ Trend Analysis Visualization Placeholder ]
                            </span>
                        </div>
                        <div class="flex items-end gap-2 h-full z-10">
                            <div class="w-8 bg-[#06283D]/30 rounded-t" style="height: 40%"></div>
                            <div class="w-8 bg-[#06283D]/40 rounded-t" style="height: 55%"></div>
                            <div class="w-8 bg-[#06283D]/50 rounded-t" style="height: 30%"></div>
                            <div class="w-8 bg-[#06283D]/60 rounded-t" style="height: 70%"></div>
                            <div class="w-8 bg-[#06283D]/70 rounded-t" style="height: 45%"></div>
                            <div class="w-8 bg-[#06283D] rounded-t" style="height: 85%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity Feed -->
            <div class="bg-white p-6 rounded-xl border border-[#C3C7CD] shadow-sm">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-[#001220] text-xl font-semibold">Aktivitas Terkini</h3>
                    <button class="text-[#0194DC] text-[11px] font-bold hover:underline">Lihat Semua</button>
                </div>
                <div class="space-y-6">
                    <div class="flex gap-4">
                        <div
                            class="mt-1 w-8 h-8 rounded-full bg-[#06283D]/10 text-[#06283D] flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-[#191C1D]"><span class="font-bold">Budi Santoso</span> baru saja
                                mendaftarkan <span class="text-[#0194DC] font-medium">Kost Abadi</span></p>
                            <p class="text-[10px] text-[#42474C] mt-1">2 menit yang lalu</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div
                            class="mt-1 w-8 h-8 rounded-full bg-green-100 text-green-700 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-[#191C1D]">Verifikasi KTP <span class="font-bold">Andi Mahendra</span>
                                disetujui</p>
                            <p class="text-[10px] text-[#42474C] mt-1">45 menit yang lalu</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div
                            class="mt-1 w-8 h-8 rounded-full bg-[#FFDAD6] text-[#93000A] flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-[#191C1D]">Laporan baru: <span class="font-medium">Fasilitas tidak
                                    sesuai</span> di Kost Cemara</p>
                            <p class="text-[10px] text-[#42474C] mt-1">3 jam yang lalu</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div
                            class="mt-1 w-8 h-8 rounded-full bg-[#CFE6EF] text-[#4C6269] flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-[#191C1D]">Transaksi pencairan dana <span class="font-bold">Kost
                                    Melati</span> selesai</p>
                            <p class="text-[10px] text-[#42474C] mt-1">5 jam yang lalu</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Verification Table -->
        <div class="bg-white rounded-xl border border-[#C3C7CD] shadow-sm overflow-hidden">
            <div
                class="px-6 py-4 border-b border-[#C3C7CD] flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h3 class="text-[#001220] text-xl font-semibold">Quick Verification</h3>
                    <p class="text-xs text-[#42474C]">Review status verifikasi pemilik properti</p>
                </div>
                <div class="flex gap-2">
                    <div class="relative">
                        <svg class="w-4 h-4 absolute left-2.5 top-1/2 -translate-y-1/2 text-[#42474C]" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input
                            class="pl-8 pr-4 py-1.5 border border-[#C3C7CD] rounded-lg bg-[#F2F4F5] text-xs focus:outline-none focus:ring-2 focus:ring-[#06283D] w-full sm:w-48"
                            placeholder="Cari..." type="text">
                    </div>
                    <button
                        class="flex items-center gap-1.5 px-3 py-1.5 border border-[#C3C7CD] rounded-lg text-xs font-semibold hover:bg-[#F2F4F5] transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        Filter
                    </button>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-[#F2F4F5] border-b border-[#C3C7CD]">
                        <tr>
                            <th class="px-6 py-3 text-[#42474C] text-[10px] font-semibold tracking-wider uppercase">Nama
                                Pemilik</th>
                            <th class="px-6 py-3 text-[#42474C] text-[10px] font-semibold tracking-wider uppercase">Email
                            </th>
                            <th class="px-6 py-3 text-[#42474C] text-[10px] font-semibold tracking-wider uppercase">Dokumen
                            </th>
                            <th class="px-6 py-3 text-[#42474C] text-[10px] font-semibold tracking-wider uppercase">Status
                            </th>
                            <th
                                class="px-6 py-3 text-[#42474C] text-[10px] font-semibold tracking-wider uppercase text-right">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#C3C7CD]">
                        <!-- Row 1 - Pending -->
                        <tr class="hover:bg-[#F2F4F5]/30 transition-colors">
                            <td class="px-6 py-3">
                                <div class="flex items-center gap-2">
                                    <div
                                        class="w-7 h-7 rounded-full bg-[#06283D]/10 text-[#06283D] flex items-center justify-center font-bold text-[10px]">
                                        BP</div>
                                    <span class="text-xs font-semibold text-[#001220]">Budi Pratama</span>
                                </div>
                            </td>
                            <td class="px-6 py-3 text-xs text-[#42474C]">budi.pratama@email.com</td>
                            <td class="px-6 py-3">
                                <button
                                    class="text-[#0194DC] hover:underline text-[11px] font-bold inline-flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    View KTP
                                </button>
                            </td>
                            <td class="px-6 py-3">
                                <span
                                    class="px-2 py-0.5 rounded-full bg-amber-50 text-amber-700 text-[10px] font-bold border border-amber-200 uppercase">Pending</span>
                            </td>
                            <td class="px-6 py-3 text-right">
                                <div class="flex justify-end gap-1.5">
                                    <button class="p-1.5 text-[#0194DC] hover:bg-[#F2F4F5] rounded-lg transition-colors"
                                        title="Detail">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </button>
                                    <button class="p-1.5 text-green-600 hover:bg-green-50 rounded-lg transition-colors"
                                        title="Approve">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </button>
                                    <button class="p-1.5 text-[#BA1A1A] hover:bg-[#FFDAD6]/50 rounded-lg transition-colors"
                                        title="Reject">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Row 2 - Verified -->
                        <tr class="hover:bg-[#F2F4F5]/30 transition-colors">
                            <td class="px-6 py-3">
                                <div class="flex items-center gap-2">
                                    <div
                                        class="w-7 h-7 rounded-full bg-[#CFE6EF] text-[#4C6269] flex items-center justify-center font-bold text-[10px]">
                                        AW</div>
                                    <span class="text-xs font-semibold text-[#001220]">Ani Wijaya</span>
                                </div>
                            </td>
                            <td class="px-6 py-3 text-xs text-[#42474C]">ani.wijaya@webmail.id</td>
                            <td class="px-6 py-3">
                                <button
                                    class="text-[#0194DC] hover:underline text-[11px] font-bold inline-flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    View KTP
                                </button>
                            </td>
                            <td class="px-6 py-3">
                                <span
                                    class="px-2 py-0.5 rounded-full bg-green-50 text-green-700 text-[10px] font-bold border border-green-200 uppercase">Verified</span>
                            </td>
                            <td class="px-6 py-3 text-right">
                                <div class="flex justify-end gap-1.5 opacity-30 pointer-events-none">
                                    <button class="p-1.5">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </button>
                                    <button class="p-1.5">
                                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Row 3 - Pending -->
                        <tr class="hover:bg-[#F2F4F5]/30 transition-colors">
                            <td class="px-6 py-3">
                                <div class="flex items-center gap-2">
                                    <div
                                        class="w-7 h-7 rounded-full bg-[#E6E8E9] text-[#001220] flex items-center justify-center font-bold text-[10px]">
                                        RS</div>
                                    <span class="text-xs font-semibold text-[#001220]">Rudi Santoso</span>
                                </div>
                            </td>
                            <td class="px-6 py-3 text-xs text-[#42474C]">rudi_santoso@example.com</td>
                            <td class="px-6 py-3">
                                <button
                                    class="text-[#0194DC] hover:underline text-[11px] font-bold inline-flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    View KTP
                                </button>
                            </td>
                            <td class="px-6 py-3">
                                <span
                                    class="px-2 py-0.5 rounded-full bg-amber-50 text-amber-700 text-[10px] font-bold border border-amber-200 uppercase">Pending</span>
                            </td>
                            <td class="px-6 py-3 text-right">
                                <div class="flex justify-end gap-1.5">
                                    <button class="p-1.5 text-[#0194DC] hover:bg-[#F2F4F5] rounded-lg transition-colors"
                                        title="Detail">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </button>
                                    <button class="p-1.5 text-green-600 hover:bg-green-50 rounded-lg transition-colors"
                                        title="Approve">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </button>
                                    <button class="p-1.5 text-[#BA1A1A] hover:bg-[#FFDAD6]/50 rounded-lg transition-colors"
                                        title="Reject">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-3 border-t border-[#C3C7CD] flex items-center justify-between">
                <p class="text-[10px] font-medium text-[#42474C]">Showing 3 of 23 pending</p>
                <div class="flex gap-1">
                    <button class="p-1.5 border border-[#C3C7CD] rounded-lg disabled:opacity-30" disabled>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button class="w-7 h-7 bg-[#06283D] text-white rounded-lg text-[11px] font-bold">1</button>
                    <button
                        class="w-7 h-7 border border-[#C3C7CD] rounded-lg text-[11px] font-bold hover:bg-[#F2F4F5] transition-colors">2</button>
                    <button class="p-1.5 border border-[#C3C7CD] rounded-lg">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
