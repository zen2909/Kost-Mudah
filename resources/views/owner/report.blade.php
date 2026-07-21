@extends('layouts.owner')

@section('title', 'Laporan Finansial & Okupansi - KostMudah')

@section('content')
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8">
            <div>
                <h1 class="text-[#001220] text-3xl md:text-4xl font-bold leading-10">Laporan Finansial & Okupansi</h1>
                <p class="text-[#42474C] text-base mt-1">Ringkasan performa seluruh properti Anda.</p>
            </div>
            <div class="flex flex-wrap items-center gap-2 mt-4 md:mt-0">
                <!-- Filter Form -->
                <form action="{{ route('owner.report.index') }}" method="GET" class="flex items-center gap-2">
                    <!-- Filter Bulan -->
                    <div>
                        <select name="month"
                            class="px-3 py-1.5 text-sm border border-[#C3C7CD] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#06283D] bg-white min-w-[120px] cursor-pointer hover:border-[#06283D] transition-colors">
                            @foreach ($months as $key => $monthName)
                                <option value="{{ $key }}" {{ $month == $key ? 'selected' : '' }}>
                                    {{ $monthName }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filter Tahun -->
                    <div>
                        <select name="year"
                            class="px-2 py-1.5 text-sm border border-[#C3C7CD] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#06283D] bg-white min-w-[80px] cursor-pointer hover:border-[#06283D] transition-colors">
                            @foreach ($years as $yearItem)
                                <option value="{{ $yearItem }}" {{ $year == $yearItem ? 'selected' : '' }}>
                                    {{ $yearItem }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit"
                        class="px-4 py-1.5 bg-[#06283D] text-white rounded-lg text-sm font-semibold hover:bg-[#001220] transition-colors whitespace-nowrap">
                        Tampilkan
                    </button>
                </form>

                <!-- Tombol Ekspor -->
                <button
                    class="flex items-center px-4 py-1.5 bg-[#001220] rounded-lg gap-1.5 hover:bg-[#06283D] transition-colors">
                    <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    <span class="text-white text-sm font-semibold">Ekspor</span>
                </button>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <!-- Total Pendapatan -->
            <div class="bg-white p-6 rounded-xl border border-[#C3C7CD] shadow-sm">
                <div class="flex justify-between items-start">
                    <div class="p-2 bg-[#CFE6EF] rounded-lg">
                        <svg class="w-[19px] h-[18px] text-[#52686F]" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v4m0 4v4m-6-6h2m6 0h2" />
                        </svg>
                    </div>
                    <div class="flex items-center gap-1">
                        <svg class="w-3 h-2 text-[#16A34A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 10l7-7m0 0l7 7m-7-7v18" />
                        </svg>
                        <span class="text-[#16A34A] text-base">+12.5%</span>
                    </div>
                </div>
                <div class="mt-3">
                    <p class="text-[#42474C] text-base uppercase tracking-wider">TOTAL PENDAPATAN ({{ $months[$month] }}
                        {{ $year }})</p>
                </div>
                <div>
                    <span class="text-[#001220] text-3xl font-bold leading-9">Rp
                        {{ number_format($totalRevenue, 0, ',', '.') }}</span>
                </div>
                <div class="mt-1">
                    <p class="text-[#42474C] text-base">Target: Rp {{ number_format($revenueTarget, 0, ',', '.') }}</p>
                </div>
            </div>

            <!-- Pembayaran Tertunda -->
            <div class="bg-white p-6 rounded-xl border border-[#C3C7CD] shadow-sm">
                <div class="flex justify-between items-start">
                    <div class="p-2 bg-[#FFDAD6] rounded-lg">
                        <svg class="w-[19px] h-[21px] text-[#93000A]" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="text-[#42474C] text-base">{{ $pendingPayments }} Penyewa</span>
                </div>
                <div class="mt-3">
                    <p class="text-[#42474C] text-base uppercase tracking-wider">PEMBAYARAN TERTUNDA ({{ $months[$month] }}
                        {{ $year }})</p>
                </div>
                <div>
                    <span class="text-[#BA1A1A] text-3xl font-bold leading-9">Rp
                        {{ number_format($pendingAmount, 0, ',', '.') }}</span>
                </div>
                <div class="mt-2">
                    <div class="w-full h-1.5 bg-[#E6E8E9] rounded-full overflow-hidden">
                        @php
                            $total = $totalRevenue + $pendingAmount;
                            $progress = $total > 0 ? ($pendingAmount / $total) * 100 : 0;
                        @endphp
                        <div class="h-1.5 bg-[#BA1A1A] rounded-full" style="width: {{ min($progress, 100) }}%"></div>
                    </div>
                </div>
            </div>

            <!-- Tingkat Okupansi -->
            <div class="bg-white p-6 rounded-xl border border-[#C3C7CD] shadow-sm">
                <div class="flex justify-between items-start">
                    <div class="p-2 bg-[#CCE5FF] rounded-lg">
                        <svg class="w-4 h-5 text-[#001E31]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <span class="text-[#0194DC] text-base">{{ $occupancyRate }}% Terisi</span>
                </div>
                <div class="mt-3">
                    <p class="text-[#42474C] text-base uppercase tracking-wider">TINGKAT OKUPANSI</p>
                </div>
                <div>
                    <span class="text-[#001220] text-3xl font-bold leading-9">{{ $totalOccupied }} /
                        {{ $totalUnits }}</span>
                </div>
                <div class="mt-1">
                    <p class="text-[#42474C] text-base">{{ $availableRooms }} Kamar tersedia untuk disewa</p>
                </div>
            </div>
        </div>

        <!-- Chart & Distribution -->
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 mb-8">
            <!-- Chart Pertumbuhan Pendapatan (3 bagian) -->
            <div class="lg:col-span-3 bg-white p-6 rounded-xl border border-[#C3C7CD] shadow-sm">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
                    <div>
                        <p class="text-[#001220] text-base font-semibold">Pertumbuhan Pendapatan</p>
                        <p class="text-[#42474C] text-sm">Visualisasi performa 6 bulan terakhir</p>
                    </div>
                    <div class="flex gap-4 mt-3 md:mt-0">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 bg-[#001220] rounded-full"></div>
                            <span class="text-[#42474C] text-sm">Terbayar</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 bg-[#ADCAE5] rounded-full"></div>
                            <span class="text-[#42474C] text-sm">Proyeksi</span>
                        </div>
                    </div>
                </div>
                <div class="relative h-60 border-b border-[#C3C7CD]">
                    <div class="flex justify-between items-end h-full pb-6">
                        @php
                            $maxRevenue = max(array_column($chartData, 'revenue')) ?: 1;
                        @endphp
                        @foreach ($chartData as $index => $data)
                            @php
                                $height = $data['revenue'] > 0 ? round(($data['revenue'] / $maxRevenue) * 100) : 5;
                                $height = max($height, 5);
                                $isLast = $index === count($chartData) - 1;
                            @endphp
                            <div class="flex flex-col items-center w-[65px] relative">
                                <!-- Proyeksi -->
                                <div class="w-10 rounded-t absolute bottom-7"
                                    style="height: {{ $height + 15 }}px; background: #ADCAE5; opacity: 0.3;">
                                </div>
                                <!-- Bar utama -->
                                <div class="w-10 rounded-t relative z-10"
                                    style="height: {{ $height }}px; background: #001220; opacity: {{ $isLast ? 1 : 0.6 }};">
                                </div>
                                <span class="text-[#42474C] text-sm mt-2">{{ $data['month'] }}</span>
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
            </div>

            <!-- Distribusi Properti (2 bagian) -->
            <div
                class="lg:col-span-2 bg-white rounded-xl border border-[#C3C7CD] shadow-sm p-5 flex flex-col justify-center">
                <div class="mb-3">
                    <p class="text-[#001220] text-base font-semibold">Distribusi Properti</p>
                    <p class="text-[#42474C] text-sm">Status hunian per tipe kamar</p>
                </div>

                <div class="flex flex-row items-center gap-6">
                    <!-- Donut Chart sedang -->
                    <div class="relative w-[150px] h-[150px] flex-shrink-0">
                        <svg viewBox="0 0 150 150" class="w-full h-full -rotate-90">
                            @php
                                $colors = ['#06283D', '#4C6269', '#E6E8E9'];
                                $total = $distribution->sum('total') ?: 1;
                                $startAngle = 0;
                                $index = 0;
                            @endphp
                            @foreach ($distribution as $item)
                                @php
                                    $percentage = ($item->total / $total) * 100;
                                    $circumference = 2 * pi() * 60;
                                    $dashArray = ($percentage / 100) * $circumference;
                                    $dashOffset = -$startAngle;
                                    $startAngle += $dashArray;
                                @endphp
                                <circle cx="75" cy="75" r="60" fill="none"
                                    stroke="{{ $colors[$index % count($colors)] }}" stroke-width="24"
                                    stroke-dasharray="{{ $dashArray }} {{ $circumference }}"
                                    stroke-dashoffset="{{ $dashOffset }}" stroke-linecap="round" />
                                @php $index++; @endphp
                            @endforeach
                        </svg>
                        <div class="absolute inset-0 flex flex-col items-center justify-center">
                            <span class="text-[#001220] text-2xl font-bold">{{ $totalUnits }}</span>
                            <span class="text-[#42474C] text-xs">Total Unit</span>
                        </div>
                    </div>

                    <!-- Legend -->
                    <div class="flex-1 space-y-2">
                        @php
                            $colors = ['#06283D', '#4C6269', '#E6E8E9'];
                            $labels = ['Premium Suites', 'Standard Plus', 'Basic Room'];
                        @endphp
                        @foreach ($distribution as $index => $item)
                            <div class="flex justify-between items-center py-1 border-b border-[#F2F4F5] last:border-0">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-3 h-3 rounded-full flex-shrink-0"
                                        style="background: {{ $colors[$index % count($colors)] }}"></div>
                                    <span class="text-[#191C1D] text-sm">{{ $labels[$index % count($labels)] }}</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="text-[#42474C] text-sm font-medium">{{ $item->total }} Unit</span>
                                    @php
                                        $total = $distribution->sum('total') ?: 1;
                                        $percent = round(($item->total / $total) * 100);
                                    @endphp
                                    <span
                                        class="text-[#42474C] text-[10px] bg-[#F2F4F5] px-2 py-0.5 rounded-full">{{ $percent }}%</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Pembayaran Tertunda Table -->
        <div class="bg-white rounded-xl border border-[#C3C7CD] shadow-sm overflow-hidden">
            <div class="flex justify-between items-center p-6 border-b border-[#C3C7CD]">
                <span class="text-[#001220] text-base font-semibold">Pembayaran Tertunda ({{ $months[$month] }}
                    {{ $year }})</span>
                <a href="{{ route('owner.payment.index', ['status' => 'pending']) }}"
                    class="text-[#0194DC] text-base hover:underline">Lihat Semua</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full min-w-[800px]">
                    <thead class="bg-[#F2F4F5]">
                        <tr>
                            <th class="text-left text-[#42474C] text-base font-bold py-4 px-6 w-[230px]">Penyewa</th>
                            <th class="text-left text-[#42474C] text-base font-bold py-4 px-6 w-[172px]">Nomor Kamar</th>
                            <th class="text-left text-[#42474C] text-base font-bold py-4 px-6 w-[165px]">Jatuh Tempo</th>
                            <th class="text-left text-[#42474C] text-base font-bold py-4 px-6 w-[168px]">Jumlah</th>
                            <th class="text-left text-[#42474C] text-base font-bold py-4 px-6 w-[138px]">Status</th>
                            <th class="text-right text-[#42474C] text-base font-bold py-4 px-6 w-[97px]">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($latePayments as $payment)
                            @php
                                $user = $payment->rental->tenant->user ?? null;
                                $initials = $user
                                    ? collect(explode(' ', $user->name))
                                        ->map(fn($word) => strtoupper(substr($word, 0, 1)))
                                        ->take(2)
                                        ->implode('')
                                    : '??';
                                $dueDate = $payment->created_at->addDays(7);
                            @endphp
                            <tr class="border-b border-[#C3C7CD] last:border-b-0">
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 bg-[#CBE6FF] rounded-full flex items-center justify-center text-[#001E30] text-base font-semibold flex-shrink-0">
                                            {{ $initials }}
                                        </div>
                                        <div>
                                            <p class="text-[#191C1D] text-base font-semibold">{{ $user->name ?? '-' }}</p>
                                            <p class="text-[#42474C] text-xs">
                                                {{ $payment->rental->boardingHouse->name ?? '-' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-[#191C1D] text-base">{{ $payment->rental->room_number ?? '-' }}
                                </td>
                                <td class="py-4 px-6 text-[#191C1D] text-base">{{ $dueDate->format('d M Y') }}</td>
                                <td class="py-4 px-6">
                                    <span class="text-[#191C1D] text-base font-bold">Rp
                                        {{ number_format($payment->amount, 0, ',', '.') }}</span>
                                </td>
                                <td class="py-4 px-6">
                                    <span
                                        class="inline-block bg-[#FFDAD6] text-[#BA1A1A] text-[10px] font-bold uppercase px-2 py-1 rounded-full">TERLAMBAT</span>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('owner.payment.show', $payment->id) }}"
                                            class="p-2 hover:bg-gray-100 rounded-full transition-colors">
                                            <svg class="w-[19px] h-4 text-[#0194DC]" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('owner.payment.verify', $payment->id) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('POST')
                                            <button type="submit"
                                                class="p-2 hover:bg-gray-100 rounded-full transition-colors"
                                                onclick="return confirm('Yakin ingin memverifikasi pembayaran ini?')">
                                                <svg class="w-[19px] h-4 text-[#15803D]" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 13l4 4L19 7" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-[#42474C]">
                                    Tidak ada pembayaran tertunda
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
