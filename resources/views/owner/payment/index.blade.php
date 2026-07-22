@extends('layouts.owner')

@section('title', 'Manajemen Pembayaran - KostMudah')

@section('content')
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
            <div>
                <h1 class="text-[#001220] text-2xl md:text-3xl font-bold">Manajemen Pembayaran</h1>
                <p class="text-[#42474C] text-sm mt-1">Pantau arus kas dan kelola tagihan sewa properti Anda.</p>
            </div>
            <div class="flex items-center gap-2 mt-3 md:mt-0">
                <button
                    class="flex items-center gap-2 px-4 py-2 bg-[#001220] text-white rounded-lg text-sm hover:bg-[#06283D] transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Ekspor Laporan
                </button>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="bg-white rounded-xl border border-[#C3C7CD] shadow-sm p-4 mb-6">
            <form action="{{ route('owner.payment.index') }}" method="GET">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
                    <!-- Search -->
                    <div class="lg:col-span-1">
                        <label class="block text-[#42474C] text-xs font-semibold tracking-wide mb-1">Cari</label>
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-[#73777D]" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Cari penyewa..."
                                class="w-full pl-9 pr-3 py-2 border border-[#C3C7CD] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#06283D] text-sm">
                        </div>
                    </div>

                    <!-- Filter Status Pembayaran -->
                    <div>
                        <label class="block text-[#42474C] text-xs font-semibold tracking-wide mb-1">Status
                            Pembayaran</label>
                        <select name="status"
                            class="w-full px-3 py-2 border border-[#C3C7CD] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#06283D] text-sm appearance-none bg-white">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Lunas</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak
                            </option>
                        </select>
                    </div>

                    <!-- Filter Metode Pembayaran -->
                    <div>
                        <label class="block text-[#42474C] text-xs font-semibold tracking-wide mb-1">Metode
                            Pembayaran</label>
                        <select name="method"
                            class="w-full px-3 py-2 border border-[#C3C7CD] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#06283D] text-sm appearance-none bg-white">
                            <option value="">Semua Metode</option>
                            <option value="bank_transfer" {{ request('method') == 'bank_transfer' ? 'selected' : '' }}>
                                Transfer Bank</option>
                            <option value="qris" {{ request('method') == 'qris' ? 'selected' : '' }}>QRIS</option>
                            <option value="ewallet" {{ request('method') == 'ewallet' ? 'selected' : '' }}>E-Wallet</option>
                        </select>
                    </div>

                    <!-- Filter Tanggal -->
                    <div>
                        <label class="block text-[#42474C] text-xs font-semibold tracking-wide mb-1">Tanggal</label>
                        <input type="date" name="date" value="{{ request('date') }}"
                            class="w-full px-3 py-2 border border-[#C3C7CD] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#06283D] text-sm">
                    </div>

                    <!-- Actions -->
                    <div class="flex items-end gap-2">
                        <button type="submit"
                            class="flex-1 px-4 py-2 bg-[#06283D] text-white rounded-lg text-sm font-semibold hover:bg-[#001220] transition-colors">
                            Filter
                        </button>
                        <a href="{{ route('owner.payment.index') }}"
                            class="px-4 py-2 border border-[#C3C7CD] rounded-lg text-sm font-semibold hover:bg-gray-50 transition-colors whitespace-nowrap">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <!-- Menunggu Pembayaran -->
            <div class="bg-white p-5 rounded-xl border border-[#C3C7CD] shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-[#42474C] text-xs font-semibold tracking-wide uppercase">MENUNGGU PEMBAYARAN</p>
                        <p class="text-[#001220] text-2xl font-bold mt-1">{{ $pendingPayments }} Tagihan</p>
                    </div>
                    <div class="w-10 h-10 bg-[#93000A]/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-[#93000A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-2 flex items-center gap-2">
                    <span class="text-[#93000A] text-xs font-medium">Perlu Tindakan</span>
                </div>
            </div>

            <!-- Jatuh Tempo -->
            <div class="bg-white p-5 rounded-xl border border-[#C3C7CD] shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-[#42474C] text-xs font-semibold tracking-wide uppercase">JATUH TEMPO (7 HARI)</p>
                        <p class="text-[#001220] text-2xl font-bold mt-1">{{ $upcomingInvoices->count() }} Properti</p>
                    </div>
                    <div class="w-10 h-10 bg-[#52686F]/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-[#52686F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-2 flex items-center gap-2">
                    <span class="text-[#52686F] text-xs font-medium">Segera kirim pengingat</span>
                </div>
            </div>

            <!-- Tingkat Koleksi -->
            <div class="bg-white p-5 rounded-xl border border-[#C3C7CD] shadow-sm hover:shadow-md transition-shadow"
                style="background: linear-gradient(140deg, white 0%, rgba(207, 230, 239, 0.20) 100%), white;">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-[#42474C] text-xs font-semibold tracking-wide uppercase">TINGKAT KOLEKSI</p>
                        <p class="text-[#001220] text-2xl font-bold mt-1">
                            {{ $totalPayments > 0 ? round(($verifiedPayments / $totalPayments) * 100) : 0 }}%
                        </p>
                    </div>
                    <div class="w-10 h-10 bg-[#0194DC]/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-[#0194DC]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-2">
                    <div class="w-full h-2 bg-[#C3C7CD]/30 rounded-full overflow-hidden">
                        <div class="h-full bg-[#0194DC] rounded-full"
                            style="width: {{ $totalPayments > 0 ? round(($verifiedPayments / $totalPayments) * 100) : 0 }}%">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Pendapatan -->
            <div
                class="bg-white p-5 rounded-xl border border-[#C3C7CD] shadow-sm hover:shadow-md transition-shadow relative overflow-hidden">
                <div class="absolute -right-4 -top-4 opacity-5">
                    <svg class="w-20 h-20 text-[#191C1D]" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1.41 16.09V20h-2.67v-1.93c-1.71-.36-3.16-1.46-3.27-3.4h1.96c.1 1.05.82 1.87 2.65 1.87 1.96 0 2.4-.98 2.4-1.59 0-.83-.44-1.61-2.67-2.14-2.48-.6-4.18-1.62-4.18-3.67 0-1.72 1.39-2.84 3.11-3.21V4h2.67v1.95c1.86.45 2.79 1.86 2.85 3.39H14.3c-.05-1.11-.64-1.87-2.22-1.87-1.5 0-2.4.68-2.4 1.64 0 .84.65 1.39 2.67 1.91s4.18 1.39 4.18 3.91c-.01 1.83-1.38 2.83-3.12 3.16z" />
                    </svg>
                </div>
                <div class="flex items-start justify-between relative z-10">
                    <div>
                        <p class="text-[#42474C] text-xs font-semibold tracking-wide uppercase">TOTAL PENDAPATAN (BULAN
                            INI)</p>
                        <p class="text-[#001220] text-2xl font-bold mt-1">Rp
                            {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                    </div>
                    <div class="w-10 h-10 bg-[#0194DC]/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-[#0194DC]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v4m0 4v4m-6-6h2m6 0h2" />
                        </svg>
                    </div>
                </div>
                <div class="mt-2 relative z-10">
                    <span class="text-[#0194DC] text-xs font-medium">+12.5% dari bulan lalu</span>
                </div>
            </div>
        </div>

        <!-- Riwayat Transaksi -->
        <div class="bg-white rounded-xl border border-[#C3C7CD] shadow-sm overflow-hidden">
            <!-- Filter Tabs -->
            <div
                class="flex flex-col md:flex-row justify-between items-start md:items-center px-4 py-3 border-b border-[#C3C7CD] gap-3">
                <h3 class="text-[#001220] text-sm font-semibold">Riwayat Transaksi</h3>
                <div class="flex gap-1 bg-[#F2F4F5] p-1 rounded-lg">
                    <a href="{{ route('owner.payment.index') }}"
                        class="px-3 py-1 bg-white shadow-sm rounded-md text-[#001220] text-xs font-bold {{ !request('status') ? 'bg-white shadow-sm text-[#001220]' : 'text-[#42474C]' }}">
                        Semua
                    </a>
                    <a href="{{ route('owner.payment.index', ['status' => 'verified']) }}"
                        class="px-3 py-1 rounded-md text-xs font-bold hover:bg-white/50 transition-colors {{ request('status') == 'verified' ? 'bg-white shadow-sm text-[#001220]' : 'text-[#42474C]' }}">
                        Lunas
                    </a>
                    <a href="{{ route('owner.payment.index', ['status' => 'pending']) }}"
                        class="px-3 py-1 rounded-md text-xs font-bold hover:bg-white/50 transition-colors {{ request('status') == 'pending' ? 'bg-white shadow-sm text-[#001220]' : 'text-[#42474C]' }}">
                        Menunggu
                    </a>
                    <a href="{{ route('owner.payment.index', ['status' => 'rejected']) }}"
                        class="px-3 py-1 rounded-md text-xs font-bold hover:bg-white/50 transition-colors {{ request('status') == 'rejected' ? 'bg-white shadow-sm text-[#001220]' : 'text-[#42474C]' }}">
                        Ditolak
                    </a>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full min-w-[800px]">
                    <thead class="bg-[#F2F4F5] border-b border-[#C3C7CD]">
                        <tr>
                            <th class="text-left text-[#42474C] text-xs font-semibold tracking-wider py-3 px-4">ID Invoice
                            </th>
                            <th class="text-left text-[#42474C] text-xs font-semibold tracking-wider py-3 px-4">Penyewa &
                                Unit</th>
                            <th class="text-left text-[#42474C] text-xs font-semibold tracking-wider py-3 px-4">Tanggal
                            </th>
                            <th class="text-left text-[#42474C] text-xs font-semibold tracking-wider py-3 px-4">Jumlah</th>
                            <th class="text-left text-[#42474C] text-xs font-semibold tracking-wider py-3 px-4">Metode</th>
                            <th class="text-left text-[#42474C] text-xs font-semibold tracking-wider py-3 px-4">Status</th>
                            <th class="text-center text-[#42474C] text-xs font-semibold tracking-wider py-3 px-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $payment)
                            @php
                                $rental = $payment->rental;
                                $user = $rental->tenant->user ?? null;
                                $statusLabels = [
                                    'verified' => ['label' => 'Lunas', 'class' => 'bg-[#DCFCE7] text-[#15803D]'],
                                    'pending' => ['label' => 'Pending', 'class' => 'bg-[#FEF3C7] text-[#92400E]'],
                                    'rejected' => ['label' => 'Ditolak', 'class' => 'bg-[#FEE2E2] text-[#991B1B]'],
                                ];
                                $statusLabel = $statusLabels[$payment->status] ?? $statusLabels['pending'];

                                $methodLabels = [
                                    'bank_transfer' => 'Transfer Bank',
                                    'qris' => 'QRIS',
                                    'ewallet' => 'E-Wallet',
                                ];
                                $methodLabel = $methodLabels[$payment->method] ?? $payment->method;
                            @endphp
                            <tr class="border-b border-[#C3C7CD] last:border-b-0 hover:bg-[#F8FAFB] transition-colors">
                                <td class="py-3 px-4">
                                    <span
                                        class="text-[#001220] text-sm font-mono font-semibold">INV-{{ str_pad($payment->id, 4, '0', STR_PAD_LEFT) }}</span>
                                </td>
                                <td class="py-3 px-4">
                                    <p class="text-[#191C1D] text-sm font-semibold">{{ $user->name ?? '-' }}</p>
                                    <p class="text-[#42474C] text-xs">{{ $rental->boardingHouse->name ?? '-' }} • Kamar
                                        {{ $rental->room_number ?? '-' }}</p>
                                </td>
                                <td class="py-3 px-4 text-[#42474C] text-sm">{{ $payment->created_at->format('d M Y') }}
                                </td>
                                <td class="py-3 px-4">
                                    <span class="text-[#191C1D] text-sm font-bold">Rp
                                        {{ number_format($payment->amount, 0, ',', '.') }}</span>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="text-[#42474C] text-sm">{{ $methodLabel }}</span>
                                </td>
                                <td class="py-3 px-4">
                                    <span
                                        class="inline-block {{ $statusLabel['class'] }} text-[10px] font-semibold px-2.5 py-0.5 rounded-full">
                                        {{ $statusLabel['label'] }}
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="flex justify-center gap-1">
                                        <a href="{{ route('owner.payment.show', $payment->id) }}"
                                            class="p-1.5 hover:bg-gray-100 rounded-lg transition-colors" title="Detail">
                                            <svg class="w-5 h-5 text-[#0194DC]" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        @if ($payment->status == 'pending')
                                            <form action="{{ route('owner.payment.verify', $payment->id) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('POST')
                                                <button type="submit"
                                                    class="p-1.5 hover:bg-gray-100 rounded-lg transition-colors"
                                                    title="Verifikasi Pembayaran"
                                                    onclick="return confirm('Yakin ingin memverifikasi pembayaran ini?')">
                                                    <svg class="w-5 h-5 text-[#15803D]" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                </button>
                                            </form>
                                            <form action="{{ route('owner.payment.reject', $payment->id) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('POST')
                                                <button type="submit"
                                                    class="p-1.5 hover:bg-gray-100 rounded-lg transition-colors"
                                                    title="Tolak Pembayaran"
                                                    onclick="return confirm('Yakin ingin menolak pembayaran ini?')">
                                                    <svg class="w-5 h-5 text-[#BA1A1A]" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div
                                            class="w-20 h-20 bg-[#F2F4F5] rounded-full flex items-center justify-center mb-4">
                                            <svg class="w-10 h-10 text-[#C3C7CD]" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                        </div>
                                        <p class="text-[#42474C] text-base font-semibold">Belum ada transaksi</p>
                                        <p class="text-[#42474C] text-sm mt-1">Belum ada riwayat pembayaran</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($payments->hasPages())
                <div
                    class="flex flex-col sm:flex-row justify-between items-center px-4 py-3 bg-[#F8FAFB] border-t border-[#C3C7CD] gap-3">
                    <span class="text-[#42474C] text-sm">
                        Menampilkan {{ $payments->firstItem() ?? 0 }}-{{ $payments->lastItem() ?? 0 }} dari
                        {{ $payments->total() }} transaksi
                    </span>
                    <div class="flex items-center gap-1">
                        @if ($payments->onFirstPage())
                            <span class="px-3 py-1.5 border border-[#C3C7CD] rounded-lg text-[#C3C7CD] cursor-not-allowed">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 19l-7-7 7-7" />
                                </svg>
                            </span>
                        @else
                            <a href="{{ $payments->previousPageUrl() }}"
                                class="px-3 py-1.5 border border-[#C3C7CD] rounded-lg hover:bg-gray-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 19l-7-7 7-7" />
                                </svg>
                            </a>
                        @endif

                        @foreach ($payments->getUrlRange(1, $payments->lastPage()) as $page => $url)
                            @if ($page == $payments->currentPage())
                                <span
                                    class="px-3 py-1.5 bg-[#06283D] text-white rounded-lg text-sm font-semibold">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}"
                                    class="px-3 py-1.5 border border-[#C3C7CD] rounded-lg text-sm hover:bg-gray-50 transition-colors">{{ $page }}</a>
                            @endif
                        @endforeach

                        @if ($payments->hasMorePages())
                            <a href="{{ $payments->nextPageUrl() }}"
                                class="px-3 py-1.5 border border-[#C3C7CD] rounded-lg hover:bg-gray-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        @else
                            <span class="px-3 py-1.5 border border-[#C3C7CD] rounded-lg text-[#C3C7CD] cursor-not-allowed">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </span>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
