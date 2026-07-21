@extends('layouts.owner')

@section('title', 'Data Penyewa - KostMudah')

@section('content')
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
            <div>
                <h1 class="text-[#001220] text-2xl md:text-3xl font-bold">Direktori Penyewa Aktif</h1>
                <p class="text-[#42474C] text-sm mt-1">Kelola data seluruh penghuni kost di properti Anda.</p>
            </div>
            <div class="flex items-center gap-2 mt-3 md:mt-0">
                <span class="text-xs text-[#42474C] bg-[#F2F4F5] px-3 py-1 rounded-full">
                    {{ $totalRentals }} Total Penyewa
                </span>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="bg-white rounded-xl border border-[#C3C7CD] shadow-sm p-4 mb-6">
            <form action="{{ route('owner.tenant.index') }}" method="GET">
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
                                placeholder="Nama atau kontak..."
                                class="w-full pl-9 pr-3 py-2 border border-[#C3C7CD] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#06283D] text-sm">
                        </div>
                    </div>

                    <!-- Filter Properti -->
                    <div>
                        <label class="block text-[#42474C] text-xs font-semibold tracking-wide mb-1">Properti</label>
                        <select name="property"
                            class="w-full px-3 py-2 border border-[#C3C7CD] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#06283D] text-sm appearance-none bg-white">
                            <option value="">Semua Properti</option>
                            @foreach ($properties as $property)
                                <option value="{{ $property->id }}"
                                    {{ request('property') == $property->id ? 'selected' : '' }}>
                                    {{ $property->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filter Status Rental -->
                    <div>
                        <label class="block text-[#42474C] text-xs font-semibold tracking-wide mb-1">Status Sewa</label>
                        <select name="rental_status"
                            class="w-full px-3 py-2 border border-[#C3C7CD] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#06283D] text-sm appearance-none bg-white">
                            <option value="">Semua Status</option>
                            <option value="paid" {{ request('rental_status') == 'paid' ? 'selected' : '' }}>Aktif</option>
                            <option value="pending" {{ request('rental_status') == 'pending' ? 'selected' : '' }}>Pending
                            </option>
                            <option value="completed" {{ request('rental_status') == 'completed' ? 'selected' : '' }}>
                                Selesai</option>
                            <option value="cancelled" {{ request('rental_status') == 'cancelled' ? 'selected' : '' }}>
                                Dibatalkan</option>
                        </select>
                    </div>

                    <!-- Filter Status Pembayaran -->
                    <div>
                        <label class="block text-[#42474C] text-xs font-semibold tracking-wide mb-1">Status Bayar</label>
                        <select name="payment_status"
                            class="w-full px-3 py-2 border border-[#C3C7CD] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#06283D] text-sm appearance-none bg-white">
                            <option value="">Semua Status</option>
                            <option value="verified" {{ request('payment_status') == 'verified' ? 'selected' : '' }}>Lunas
                            </option>
                            <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending
                            </option>
                            <option value="rejected" {{ request('payment_status') == 'rejected' ? 'selected' : '' }}>
                                Ditolak</option>
                        </select>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-end gap-2">
                        <button type="submit"
                            class="flex-1 px-4 py-2 bg-[#06283D] text-white rounded-lg text-sm font-semibold hover:bg-[#001220] transition-colors">
                            Filter
                        </button>
                        <a href="{{ route('owner.tenant.index') }}"
                            class="px-4 py-2 border border-[#C3C7CD] rounded-lg text-sm font-semibold hover:bg-gray-50 transition-colors whitespace-nowrap">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <!-- Total Penyewa -->
            <div class="bg-white p-5 rounded-xl border border-[#C3C7CD] shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-[#42474C] text-xs font-semibold tracking-wide uppercase">Total Penyewa</p>
                        <p class="text-[#001220] text-2xl font-bold mt-1">{{ $totalRentals }}</p>
                    </div>
                    <div class="w-10 h-10 bg-[#06283D]/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-[#06283D]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-2">
                    <span
                        class="text-[#0194DC] text-[10px] font-semibold bg-[#0194DC]/10 px-2 py-0.5 rounded-full">Aktif</span>
                </div>
            </div>

            <!-- Pembayaran Lancar -->
            <div class="bg-white p-5 rounded-xl border border-[#C3C7CD] shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-[#42474C] text-xs font-semibold tracking-wide uppercase">Pembayaran Lancar</p>
                        <p class="text-[#0194DC] text-2xl font-bold mt-1">{{ $paidRentals }}</p>
                    </div>
                    <div class="w-10 h-10 bg-[#0194DC]/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-[#0194DC]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-2">
                    <span class="text-[#0194DC] text-[10px] font-semibold bg-[#0194DC]/10 px-2 py-0.5 rounded-full">
                        {{ $totalRentals > 0 ? round(($paidRentals / $totalRentals) * 100) : 0 }}%
                    </span>
                </div>
            </div>

            <!-- Pending Pembayaran -->
            <div class="bg-white p-5 rounded-xl border border-[#C3C7CD] shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-[#42474C] text-xs font-semibold tracking-wide uppercase">Pending</p>
                        <p class="text-[#F59E0B] text-2xl font-bold mt-1">{{ $pendingRentals }}</p>
                    </div>
                    <div class="w-10 h-10 bg-[#F59E0B]/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-[#F59E0B]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-2">
                    <span class="text-[#F59E0B] text-[10px] font-semibold bg-[#F59E0B]/10 px-2 py-0.5 rounded-full">Perlu
                        Tindakan</span>
                </div>
            </div>

            <!-- Sewa Berakhir -->
            <div class="bg-white p-5 rounded-xl border border-[#C3C7CD] shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-[#42474C] text-xs font-semibold tracking-wide uppercase">Sewa Berakhir < 30 Hari</p>
                                <p class="text-[#BA1A1A] text-2xl font-bold mt-1">{{ $expiringSoon }}</p>
                    </div>
                    <div class="w-10 h-10 bg-[#BA1A1A]/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-[#BA1A1A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-2">
                    <span
                        class="text-[#BA1A1A] text-[10px] font-semibold bg-[#BA1A1A]/10 px-2 py-0.5 rounded-full">Ingatkan</span>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-xl border border-[#C3C7CD] shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full min-w-[1000px]">
                    <thead>
                        <tr class="bg-[#F8FAFB] border-b border-[#C3C7CD]">
                            <th class="text-left text-[#42474C] text-xs font-semibold tracking-wider py-3.5 px-4">Nama
                                Penyewa</th>
                            <th class="text-left text-[#42474C] text-xs font-semibold tracking-wider py-3.5 px-4">Properti
                                / Kamar</th>
                            <th class="text-left text-[#42474C] text-xs font-semibold tracking-wider py-3.5 px-4">Kontak
                            </th>
                            <th class="text-left text-[#42474C] text-xs font-semibold tracking-wider py-3.5 px-4">Status
                                Sewa</th>
                            <th class="text-left text-[#42474C] text-xs font-semibold tracking-wider py-3.5 px-4">Status
                                Bayar</th>
                            <th class="text-left text-[#42474C] text-xs font-semibold tracking-wider py-3.5 px-4">Akhir
                                Sewa</th>
                            <th class="text-center text-[#42474C] text-xs font-semibold tracking-wider py-3.5 px-4">Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rentals as $rental)
                            @php
                                $tenant = $rental->tenant;
                                $user = $tenant->user;
                                $initials = collect(explode(' ', $user->name))
                                    ->map(fn($word) => strtoupper(substr($word, 0, 1)))
                                    ->take(2)
                                    ->implode('');
                                $genderColor =
                                    $tenant->gender === 'P'
                                        ? 'bg-[#ADCAE5] text-[#001220]'
                                        : 'bg-[#CFE6EF] text-[#4C6269]';

                                $rentalStatus = $rental->status;
                                $rentalLabels = [
                                    'paid' => ['label' => 'Aktif', 'class' => 'bg-[#DCFCE7] text-[#15803D]'],
                                    'pending' => ['label' => 'Pending', 'class' => 'bg-[#FEF3C7] text-[#92400E]'],
                                    'completed' => ['label' => 'Selesai', 'class' => 'bg-[#E6E8E9] text-[#42474C]'],
                                    'cancelled' => ['label' => 'Dibatalkan', 'class' => 'bg-[#FEE2E2] text-[#991B1B]'],
                                ];
                                $rentalLabel = $rentalLabels[$rentalStatus] ?? $rentalLabels['pending'];

                                $payment = $rental->payment;
                                $paymentStatus = $payment ? $payment->status : 'pending';
                                $paymentLabels = [
                                    'verified' => ['label' => 'Lunas', 'class' => 'bg-[#DCFCE7] text-[#15803D]'],
                                    'pending' => ['label' => 'Pending', 'class' => 'bg-[#FEF3C7] text-[#92400E]'],
                                    'rejected' => ['label' => 'Ditolak', 'class' => 'bg-[#FEE2E2] text-[#991B1B]'],
                                ];
                                $paymentLabel = $paymentLabels[$paymentStatus] ?? $paymentLabels['pending'];

                                $endDate = $rental->end_date;
                                $daysLeft = $endDate ? now()->diffInDays($endDate) : 0;
                                $endDateText = $endDate ? $endDate->format('d M Y') : '-';
                                $daysText =
                                    $daysLeft > 0
                                        ? "{$daysLeft} hari tersisa"
                                        : ($daysLeft == 0
                                            ? 'Hari ini'
                                            : 'Terlewati');
                                $daysColor =
                                    $daysLeft > 30
                                        ? 'text-[#42474C]'
                                        : ($daysLeft > 0
                                            ? 'text-[#BA1A1A]'
                                            : 'text-[#BA1A1A] font-bold');
                            @endphp
                            <tr class="border-b border-[#C3C7CD] last:border-b-0 hover:bg-[#F8FAFB] transition-colors">
                                <td class="py-3.5 px-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-9 h-9 {{ $genderColor }} rounded-full flex items-center justify-center font-bold text-sm flex-shrink-0">
                                            {{ $initials }}
                                        </div>
                                        <div>
                                            <p class="text-[#191C1D] font-semibold text-sm">{{ $user->name }}</p>
                                            <p class="text-[#42474C] text-[10px]">
                                                TEN-{{ str_pad($tenant->id, 4, '0', STR_PAD_LEFT) }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4">
                                    <p class="text-[#191C1D] text-sm">{{ $rental->boardingHouse->name ?? '-' }}</p>
                                    <p class="text-[#0194DC] text-[10px] font-semibold">Kamar
                                        {{ $rental->room_number ?? '-' }}</p>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-3 h-3 text-[#0194DC]" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                        <span class="text-[#191C1D] text-sm">{{ $user->phone ?? '-' }}</span>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4">
                                    <span
                                        class="inline-block {{ $rentalLabel['class'] }} text-[10px] font-semibold px-2.5 py-0.5 rounded-full">
                                        {{ $rentalLabel['label'] }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4">
                                    <span
                                        class="inline-block {{ $paymentLabel['class'] }} text-[10px] font-semibold px-2.5 py-0.5 rounded-full">
                                        {{ $paymentLabel['label'] }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4">
                                    <p class="text-[#191C1D] text-sm">{{ $endDateText }}</p>
                                    @if ($endDate)
                                        <p class="text-[10px] italic {{ $daysColor }}">{{ $daysText }}</p>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="flex justify-center">
                                        <a href="{{ route('owner.tenant.show', $rental->id) }}"
                                            class="p-1.5 hover:bg-gray-100 rounded-lg transition-colors"
                                            title="Detail Penyewa">
                                            <svg class="w-5 h-5 text-[#0194DC]" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div
                                            class="w-20 h-20 bg-[#F2F4F5] rounded-full flex items-center justify-center mb-4">
                                            <svg class="w-10 h-10 text-[#C3C7CD]" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </div>
                                        <p class="text-[#42474C] text-base font-semibold">Belum ada penyewa</p>
                                        <p class="text-[#42474C] text-sm mt-1">Belum ada penyewa aktif di properti Anda</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($rentals->hasPages())
                <div
                    class="flex flex-col sm:flex-row justify-between items-center px-4 py-3 bg-[#F8FAFB] border-t border-[#C3C7CD] gap-3">
                    <span class="text-[#42474C] text-sm">
                        Menampilkan {{ $rentals->firstItem() ?? 0 }}-{{ $rentals->lastItem() ?? 0 }} dari
                        {{ $rentals->total() }} penyewa
                    </span>
                    <div class="flex items-center gap-1">
                        @if ($rentals->onFirstPage())
                            <span class="px-3 py-1.5 border border-[#C3C7CD] rounded-lg text-[#C3C7CD] cursor-not-allowed">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 19l-7-7 7-7" />
                                </svg>
                            </span>
                        @else
                            <a href="{{ $rentals->previousPageUrl() }}"
                                class="px-3 py-1.5 border border-[#C3C7CD] rounded-lg hover:bg-gray-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 19l-7-7 7-7" />
                                </svg>
                            </a>
                        @endif

                        @foreach ($rentals->getUrlRange(1, $rentals->lastPage()) as $page => $url)
                            @if ($page == $rentals->currentPage())
                                <span
                                    class="px-3 py-1.5 bg-[#06283D] text-white rounded-lg text-sm font-semibold">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}"
                                    class="px-3 py-1.5 border border-[#C3C7CD] rounded-lg text-sm hover:bg-gray-50 transition-colors">{{ $page }}</a>
                            @endif
                        @endforeach

                        @if ($rentals->hasMorePages())
                            <a href="{{ $rentals->nextPageUrl() }}"
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
