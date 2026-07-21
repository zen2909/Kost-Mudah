@extends('layouts.owner')

@section('title', 'Dashboard Owner - KostMudah')

@section('content')
    <div class="max-w-7xl mx-auto">
        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <!-- Card 1 - Jumlah Kost -->
            <div class="bg-white p-6 rounded-xl border border-[#C3C7CD] shadow-sm hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start">
                    <svg class="w-12 h-12 text-[#06283D]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    <span class="bg-green-100 text-[#191C1D] text-[10px] font-bold px-2 py-1 rounded-full">
                        +{{ $totalBoardingHouses }} TOTAL
                    </span>
                </div>
                <div class="mt-4">
                    <p class="text-[#42474C] text-xs font-bold">Jumlah Kost</p>
                    <p class="text-[#001220] text-3xl font-bold">{{ $totalBoardingHouses }}</p>
                </div>
            </div>

            <!-- Card 2 - Total Penyewa Aktif -->
            <div class="bg-white p-6 rounded-xl border border-[#C3C7CD] shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-start gap-4">
                    <svg class="w-12 h-10 text-[#06283D]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span
                        class="flex-1 bg-green-100 text-[#191C1D] text-[10px] font-bold px-2 py-1 rounded-full text-center">
                        {{ $totalTenants > 0 ? round(($totalActiveTenants / max($totalTenants, 1)) * 100) : 0 }}% OCCUPANCY
                    </span>
                </div>
                <div class="mt-4">
                    <p class="text-[#42474C] text-xs font-bold">Total Penyewa Aktif</p>
                    <p class="text-[#001220] text-3xl font-bold">{{ $totalActiveTenants }}</p>
                </div>
            </div>

            <!-- Card 3 - Pendapatan Bulan Ini -->
            <div class="bg-white p-6 rounded-xl border border-[#C3C7CD] shadow-sm hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start">
                    <svg class="w-12 h-10 text-[#06283D]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v4m0 4v4m-6-6h2m6 0h2" />
                    </svg>
                    <span class="bg-[#0012201A] text-[#001220] text-[10px] font-bold px-2 py-1 rounded-full">
                        +Rp {{ number_format($thisMonthRevenue, 0, ',', '.') }}
                    </span>
                </div>
                <div class="mt-4">
                    <p class="text-[#42474C] text-xs font-bold">Pendapatan Bulan Ini</p>
                    <p class="text-[#001220] text-3xl font-bold">Rp {{ number_format($thisMonthRevenue, 0, ',', '.') }}</p>
                </div>
            </div>

            <!-- Card 4 - Pembayaran Pending -->
            <div class="bg-white p-6 rounded-xl border border-[#C3C7CD] shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-start gap-6">
                    <svg class="w-12 h-12 text-[#06283D]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span
                        class="flex-1 bg-amber-200 text-amber-500 text-[10px] font-bold px-2 py-1 rounded-full text-center">
                        NEEDS REVIEW
                    </span>
                </div>
                <div class="mt-4">
                    <p class="text-[#42474C] text-xs font-bold">Pembayaran Pending</p>
                    <p class="text-[#001220] text-3xl font-bold">{{ $pendingPayments }}</p>
                </div>
            </div>
        </div>

        <!-- Charts & Quick Actions -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
            <!-- Chart -->
            <div class="lg:col-span-2 bg-white p-6 rounded-xl border border-[#C3C7CD] shadow-sm">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-3">
                    <div>
                        <h3 class="text-[#001220] text-xl font-bold">Grafik Pendapatan</h3>
                        <p class="text-[#42474C] text-sm">Performance summary for {{ $selectedYear }}</p>
                    </div>
                    <!-- Filter Tahun -->
                    <form action="{{ route('owner.dashboard') }}" method="GET" class="flex items-center gap-2">
                        <div class="relative">
                            <select name="year"
                                class="pl-3 pr-8 py-1.5 border border-[#C3C7CD] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#06283D] text-sm appearance-none bg-white min-w-[100px] cursor-pointer hover:border-[#06283D] transition-colors">
                                @foreach ($years as $year)
                                    <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit"
                            class="px-4 py-1.5 bg-[#06283D] text-white rounded-lg text-sm font-semibold hover:bg-[#001220] transition-colors">
                            Tampilkan
                        </button>
                    </form>
                </div>

                <!-- Cek apakah ada data -->
                @php
                    $hasData = false;
                    foreach ($chartData as $data) {
                        if ($data['revenue'] > 0) {
                            $hasData = true;
                            break;
                        }
                    }
                @endphp

                @if ($hasData)
                    <div class="relative h-64">
                        <div class="flex justify-between items-end h-full pb-6">
                            @php
                                $maxRevenue = max(array_column($chartData, 'revenue')) ?: 1;
                                $monthColors = ['#001220', '#06283D', '#0194DC', '#4C6269', '#7390A9', '#ADCAE5'];
                            @endphp
                            @foreach ($chartData as $index => $data)
                                @php
                                    $height = $data['revenue'] > 0 ? round(($data['revenue'] / $maxRevenue) * 100) : 5;
                                    $height = max($height, 5);
                                    $colorIndex = $index % count($monthColors);
                                    $isCurrentMonth =
                                        $data['month_num'] == now()->month && $selectedYear == now()->year;
                                @endphp
                                <div class="flex flex-col items-center group relative">
                                    <!-- Tooltip hover -->
                                    <div
                                        class="absolute -top-10 left-1/2 -translate-x-1/2 bg-[#001220] text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none z-10">
                                        {{ $data['month'] }}: Rp {{ number_format($data['revenue'], 0, ',', '.') }}
                                    </div>
                                    <!-- Bar -->
                                    <div class="w-8 rounded-t transition-all duration-300 hover:opacity-80 cursor-pointer"
                                        style="height: {{ $height }}px; background: {{ $isCurrentMonth ? '#001220' : $monthColors[$colorIndex] }}; opacity: {{ $data['revenue'] > 0 ? 1 : 0.3 }};">
                                    </div>
                                    <span class="text-[#42474C] text-[10px] font-bold mt-1">{{ $data['month'] }}</span>
                                </div>
                            @endforeach
                        </div>

                        <!-- Grid lines -->
                        <div class="absolute inset-0 flex flex-col justify-between opacity-10 pointer-events-none pb-6">
                            <div class="border-t border-[#191C1D]"></div>
                            <div class="border-t border-[#191C1D]"></div>
                            <div class="border-t border-[#191C1D]"></div>
                            <div class="border-t border-[#191C1D]"></div>
                        </div>
                    </div>

                    <!-- Total Pendapatan Tahun -->
                    @php
                        $totalYearRevenue = array_sum(array_column($chartData, 'revenue'));
                    @endphp
                    <div class="mt-4 pt-4 border-t border-[#C3C7CD] flex justify-between items-center">
                        <span class="text-[#42474C] text-sm">Total Pendapatan {{ $selectedYear }}</span>
                        <span class="text-[#001220] text-xl font-bold">Rp
                            {{ number_format($totalYearRevenue, 0, ',', '.') }}</span>
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="flex flex-col items-center justify-center py-16">
                        <div class="w-20 h-20 bg-[#F2F4F5] rounded-full flex items-center justify-center mb-4">
                            <svg class="w-10 h-10 text-[#C3C7CD]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v4m0 4v4m-6-6h2m6 0h2" />
                            </svg>
                        </div>
                        <h4 class="text-[#001220] text-lg font-semibold">Belum Ada Data Pendapatan</h4>
                        <p class="text-[#42474C] text-sm mt-2 max-w-sm text-center">
                            Belum ada transaksi pendapatan untuk tahun {{ $selectedYear }}.
                            @if ($selectedYear != now()->year)
                                <br>Coba pilih tahun lain atau tambahkan data transaksi.
                            @else
                                <br>Mulai terima pembayaran dari penyewa untuk melihat grafik pendapatan.
                            @endif
                        </p>
                        @if ($selectedYear != now()->year)
                            <div class="flex gap-2 mt-4">
                                <a href="{{ route('owner.dashboard', ['year' => now()->year]) }}"
                                    class="px-4 py-2 bg-[#06283D] text-white rounded-lg text-sm font-semibold hover:bg-[#001220] transition-colors">
                                    Lihat Tahun Ini
                                </a>
                            </div>
                        @else
                            <a href="{{ route('owner.payment.index') }}"
                                class="mt-4 px-4 py-2 bg-[#06283D] text-white rounded-lg text-sm font-semibold hover:bg-[#001220] transition-colors">
                                Kelola Pembayaran
                            </a>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Quick Actions -->
            <div class="bg-white p-6 rounded-xl border border-[#C3C7CD] shadow-sm">
                <h3 class="text-[#001220] text-xl font-bold mb-6">Quick Actions</h3>
                <div class="space-y-3">
                    <a href="{{ route('owner.kost.create') }}"
                        class="w-full flex items-center justify-between bg-[#001220] text-white px-4 py-3 rounded-lg hover:bg-[#06283D] transition-colors">
                        <span class="font-bold">Tambah Kost Baru</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </a>
                    <a href="{{ route('owner.report.index') }}"
                        class="w-full flex items-center justify-between bg-transparent px-4 py-3 rounded-lg border border-[#C3C7CD] hover:bg-gray-50 transition-colors">
                        <span class="text-[#001220] font-bold">Lihat Laporan</span>
                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2" />
                        </svg>
                    </a>
                    <a href="{{ route('owner.tenant.index') }}"
                        class="w-full flex items-center justify-between bg-transparent px-4 py-3 rounded-lg border border-[#C3C7CD] hover:bg-gray-50 transition-colors">
                        <span class="text-[#001220] font-bold">Kelola Penyewa</span>
                        <svg class="w-5 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </a>
                </div>
                <div class="mt-6 p-4 bg-[#CCE5FF] rounded-lg">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#004B72]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-[#004B72] text-sm font-bold">Owner Tip</span>
                    </div>
                    <p class="text-[#004B72] text-xs mt-1">
                        Verifikasi data KTP penyewa baru untuk meningkatkan skor keamanan profil Anda.
                    </p>
                </div>
            </div>
        </div>

        <!-- Manajemen Kost -->
        <div class="bg-white rounded-xl border border-[#C3C7CD] shadow-sm mb-6">
            <div class="flex justify-between items-center p-6 border-b border-gray-100">
                <h3 class="text-[#001220] text-xl font-bold">Manajemen Kost</h3>
                <a href="{{ route('owner.kost.index') }}"
                    class="text-[#0194DC] text-sm font-medium hover:underline transition-colors flex items-center gap-1">
                    Lihat Semua
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-[#F2F4F5]">
                        <tr>
                            <th class="text-left text-[#42474C] text-xs font-bold py-3 px-4">NAME</th>
                            <th class="text-left text-[#42474C] text-xs font-bold py-3 px-4">SUB-DISTRICT</th>
                            <th class="text-left text-[#42474C] text-xs font-bold py-3 px-4">PRICE</th>
                            <th class="text-left text-[#42474C] text-xs font-bold py-3 px-4">STATUS</th>
                            <th class="text-left text-[#42474C] text-xs font-bold py-3 px-4">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($boardingHouses as $kost)
                            <tr class="border-b border-gray-50 hover:bg-gray-50 transition-colors">
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-3">
                                        @if ($kost->primaryPhoto)
                                            <img src="{{ Storage::url($kost->primaryPhoto->path) }}"
                                                alt="{{ $kost->name }}" class="w-10 h-10 rounded-lg object-cover">
                                        @else
                                            <div
                                                class="w-10 h-10 bg-[#F2F4F5] rounded-lg flex items-center justify-center text-[#C3C7CD]">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                        <div>
                                            <p class="text-[#191C1D] font-bold">{{ $kost->name }}</p>
                                            <p class="text-[#42474C] text-xs">ID: {{ Str::limit($kost->slug, 10) }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-[#42474C]">{{ $kost->kelurahan }}</td>
                                <td class="py-4 px-4 text-[#001220] font-bold">Rp
                                    {{ number_format($kost->price_per_month, 0, ',', '.') }} / bln</td>
                                <td class="py-4 px-4">
                                    <span class="bg-green-100 text-green-800 text-xs font-bold px-3 py-1 rounded-full">
                                        {{ ucfirst($kost->status) }}
                                    </span>
                                </td>
                                <td class="py-4 px-4">
                                    <div class="flex gap-2">
                                        <a href="{{ route('owner.kost.show', $kost->id) }}"
                                            class="p-1 hover:bg-gray-100 rounded transition-colors" title="Detail">
                                            <svg class="w-5 h-5 text-[#0194DC]" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('owner.kost.edit', $kost->id) }}"
                                            class="p-1 hover:bg-gray-100 rounded transition-colors" title="Edit">
                                            <svg class="w-5 h-5 text-[#001220]" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-[#42474C]">
                                    Belum ada kost. <a href="{{ route('owner.kost.create') }}"
                                        class="text-[#0194DC] hover:underline">Tambah kost sekarang</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Manajemen Pembayaran -->
        <div class="bg-white rounded-xl border border-[#C3C7CD] shadow-sm mb-6">
            <div class="flex justify-between items-center p-6 border-b border-gray-100">
                <h3 class="text-[#001220] text-xl font-bold">Manajemen Pembayaran</h3>
                <a href="{{ route('owner.payment.index') }}"
                    class="text-[#0194DC] text-sm font-medium hover:underline transition-colors flex items-center gap-1">
                    Lihat Semua
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full min-w-[700px]">
                    <thead class="bg-[#F2F4F5]">
                        <tr>
                            <th class="text-left text-[#42474C] text-xs font-bold py-3 px-4">PENYEWA</th>
                            <th class="text-left text-[#42474C] text-xs font-bold py-3 px-4">PROPERTI / KAMAR</th>
                            <th class="text-left text-[#42474C] text-xs font-bold py-3 px-4">JUMLAH</th>
                            <th class="text-left text-[#42474C] text-xs font-bold py-3 px-4">METODE</th>
                            <th class="text-left text-[#42474C] text-xs font-bold py-3 px-4">STATUS</th>
                            <th class="text-left text-[#42474C] text-xs font-bold py-3 px-4">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentPayments as $payment)
                            @php
                                $user = $payment->rental->tenant->user ?? null;
                                $initials = $user
                                    ? collect(explode(' ', $user->name))
                                        ->map(fn($word) => strtoupper(substr($word, 0, 1)))
                                        ->take(2)
                                        ->implode('')
                                    : '??';

                                $statusColors = [
                                    'verified' => 'bg-green-100 text-green-700',
                                    'pending' => 'bg-amber-100 text-amber-700',
                                    'rejected' => 'bg-red-100 text-red-700',
                                ];
                                $statusLabels = [
                                    'verified' => 'Lunas',
                                    'pending' => 'Pending',
                                    'rejected' => 'Ditolak',
                                ];
                                $statusIcons = [
                                    'verified' =>
                                        '<svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>',
                                    'pending' => '<span class="w-1.5 h-1.5 bg-amber-700 rounded-full"></span>',
                                    'rejected' =>
                                        '<svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>',
                                ];
                                $statusColor = $statusColors[$payment->status] ?? 'bg-gray-100 text-gray-700';
                                $statusLabel = $statusLabels[$payment->status] ?? ucfirst($payment->status);
                                $statusIcon = $statusIcons[$payment->status] ?? '';
                                $methodLabels = [
                                    'bank_transfer' => 'Transfer Bank',
                                    'qris' => 'QRIS',
                                    'ewallet' => 'E-Wallet',
                                ];
                                $methodLabel = $methodLabels[$payment->method] ?? $payment->method;
                            @endphp
                            <tr class="border-b border-gray-50 hover:bg-gray-50 transition-colors">
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-2">
                                        <span
                                            class="bg-[#0012201A] text-[#001220] text-xs font-bold px-3 py-1 rounded-full">{{ $initials }}</span>
                                        <span class="text-[#191C1D] font-bold">{{ $user->name ?? '-' }}</span>
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <div>
                                        <p class="text-[#191C1D] text-sm">
                                            {{ $payment->rental->boardingHouse->name ?? '-' }}</p>
                                        <p class="text-[#0194DC] text-xs">Kamar {{ $payment->rental->room_number ?? '-' }}
                                        </p>
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-[#191C1D] font-bold">Rp
                                    {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                <td class="py-4 px-4 text-[#191C1D] text-sm">{{ $methodLabel }}</td>
                                <td class="py-4 px-4">
                                    <span
                                        class="flex items-center gap-1 {{ $statusColor }} text-xs font-bold px-3 py-1 rounded-full">
                                        {!! $statusIcon !!}
                                        {{ $statusLabel }}
                                    </span>
                                </td>
                                <td class="py-4 px-4">
                                    @if ($payment->status == 'pending')
                                        <form action="{{ route('owner.payment.verify', $payment->id) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('POST')
                                            <button type="submit"
                                                class="bg-[#0194DC] text-white text-xs font-bold px-4 py-2 rounded-lg hover:bg-[#0179b8] transition-colors">
                                                Verifikasi
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('owner.payment.show', $payment->id) }}"
                                            class="inline-block px-4 py-2 rounded-lg border border-[#C3C7CD] text-xs font-bold hover:bg-gray-50 transition-colors">
                                            Detail
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-[#42474C]">
                                    Belum ada transaksi pembayaran.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

        <!-- Profile Card -->
        <div class="bg-white p-6 rounded-xl border border-[#C3C7CD] shadow-sm">
            <div class="flex flex-col md:flex-row items-center gap-6">
                <!-- Avatar -->
                <div
                    class="w-24 h-24 rounded-full overflow-hidden flex-shrink-0 bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white text-3xl font-bold">
                    @php
                        $currentUser = Auth::user();
                    @endphp
                    @if ($currentUser->photo)
                        <img src="{{ Storage::url($currentUser->photo) }}" alt="{{ $currentUser->name }}"
                            class="w-full h-full object-cover">
                    @else
                        {{ Str::upper(substr($currentUser->name ?? 'Owner', 0, 2)) }}
                    @endif
                </div>

                <div class="flex-1">
                    <div class="flex flex-wrap items-center gap-2 mb-2">
                        <!-- Nama -->
                        <h4 class="text-[#001220] text-xl font-bold">{{ $currentUser->name }}</h4>

                        <!-- Role -->
                        @php
                            $role = $currentUser->roles->first();
                            $roleName = $role ? strtoupper($role->name) : 'OWNER';
                        @endphp
                        <span class="bg-[#0012201A] text-[#001220] text-[10px] font-bold px-3 py-1 rounded-full">
                            {{ $roleName }}
                        </span>

                        <!-- Status Verifikasi -->
                        @php
                            $currentOwner = \App\Models\Owner::where('user_id', $currentUser->id)->first();
                        @endphp
                        @if ($currentOwner)
                            @if ($currentOwner->verification_status == 'approved')
                                <span class="bg-[#DCFCE7] text-[#15803D] text-[10px] font-bold px-2 py-1 rounded-full">✓
                                    Terverifikasi</span>
                            @elseif($currentOwner->verification_status == 'pending')
                                <span class="bg-[#FEF3C7] text-[#92400E] text-[10px] font-bold px-2 py-1 rounded-full">⏳
                                    Pending Verifikasi</span>
                            @else
                                <span class="bg-[#FEE2E2] text-[#991B1B] text-[10px] font-bold px-2 py-1 rounded-full">✗
                                    Belum Verifikasi</span>
                            @endif
                        @endif
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        <!-- Email -->
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span class="text-[#42474C] text-sm">{{ $currentUser->email }}</span>
                        </div>

                        <!-- Phone -->
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <span class="text-[#42474C] text-sm">{{ $currentUser->phone ?? '-' }}</span>
                        </div>

                        <!-- Joined Date -->
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="text-[#42474C] text-sm">Joined
                                {{ $currentUser->created_at ? $currentUser->created_at->format('M Y') : '-' }}</span>
                        </div>

                        <!-- Total Properti -->
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            <span class="text-[#42474C] text-sm">{{ $totalBoardingHouses }} Properti</span>
                        </div>
                    </div>
                </div>

                <a href="{{ route('owner.profile.index') }}"
                    class="px-6 py-3 rounded-xl border-2 border-[#001220] font-bold hover:bg-[#001220] hover:text-white transition-colors flex-shrink-0">
                    Edit Profile
                </a>
            </div>
        </div>
    </div>
@endsection
