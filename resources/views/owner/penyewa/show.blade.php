@extends('layouts.owner')

@section('title', 'Detail Penyewa - KostMudah')

@section('content')
    <!-- Modal Overlay -->
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50">
        <!-- Modal Container -->
        <div class="bg-white w-full max-w-4xl max-h-[90vh] rounded-xl shadow-2xl flex flex-col overflow-hidden">
            <!-- Header -->
            <div class="flex items-center justify-between px-6 py-4 border-b border-[#C3C7CD] bg-white">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-[#06283D] flex items-center justify-center text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-semibold text-[#001220]">Detail Penyewa</h2>
                    @if ($rental->status == 'paid')
                        <span
                            class="bg-[#DCFCE7] text-[#15803D] text-[10px] font-bold uppercase px-2 py-1 rounded">AKTIF</span>
                    @elseif($rental->status == 'pending')
                        <span
                            class="bg-[#FEF3C7] text-[#92400E] text-[10px] font-bold uppercase px-2 py-1 rounded">PENDING</span>
                    @else
                        <span
                            class="bg-[#FEE2E2] text-[#991B1B] text-[10px] font-bold uppercase px-2 py-1 rounded">{{ strtoupper($rental->status) }}</span>
                    @endif
                </div>
                <a href="{{ route('owner.tenant.index') }}" class="p-2 hover:bg-gray-100 rounded-full transition-colors">
                    <svg class="w-5 h-5 text-[#42474C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </a>
            </div>

            <!-- Modal Content -->
            <div class="flex-1 overflow-y-auto p-6 space-y-6">

                <!-- ============================================================ -->
                <!-- TOP SECTION: Profile + Rental Info -->
                <!-- ============================================================ -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                    <!-- Left: Profile -->
                    <div
                        class="lg:col-span-7 bg-[#F2F4F5] border border-[#C3C7CD] rounded-xl p-6 flex flex-col sm:flex-row gap-6 items-start">
                        @php
                            $user = $rental->tenant->user;
                            $tenant = $rental->tenant;
                            $initials = collect(explode(' ', $user->name))
                                ->map(fn($word) => strtoupper(substr($word, 0, 1)))
                                ->take(2)
                                ->implode('');
                            $genderColor =
                                $tenant->gender === 'P' ? 'bg-[#ADCAE5] text-[#001220]' : 'bg-[#CFE6EF] text-[#4C6269]';
                        @endphp

                        <div
                            class="w-24 h-24 {{ $genderColor }} rounded-full flex items-center justify-center text-3xl font-bold border-4 border-white shadow-sm flex-shrink-0">
                            {{ $initials }}
                        </div>

                        <div class="space-y-3 flex-1">
                            <div>
                                <h3 class="text-xl font-semibold text-[#001220]">{{ $user->name }}</h3>
                                <p class="text-sm text-[#42474C] flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Bergabung sejak {{ $user->created_at->format('d M Y') }}
                                </p>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-2 gap-x-4">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-[#73777D]" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    <span class="text-[#191C1D] text-sm">{{ $user->email }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-[#73777D]" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    <span class="text-[#191C1D] text-sm">{{ $user->phone ?? '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Rental Info -->
                    <div class="lg:col-span-5 bg-[#06283D] rounded-xl p-6 relative overflow-hidden">
                        <div class="absolute -right-4 -top-4 opacity-10">
                            <svg class="w-32 h-32 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <div class="relative z-10 space-y-4">
                            <div class="flex justify-between items-start">
                                <span
                                    class="px-3 py-1 bg-white/10 text-white rounded text-[10px] font-bold uppercase tracking-wider">
                                    @if ($rental->status == 'paid')
                                        ✓ Sewa Aktif
                                    @elseif($rental->status == 'pending')
                                        ⏳ Menunggu Verifikasi
                                    @else
                                        {{ strtoupper($rental->status) }}
                                    @endif
                                </span>
                                <span class="text-2xl font-bold text-white">
                                    Rp {{ number_format($rental->total_price / $rental->duration_months, 0, ',', '.') }}
                                    <span class="text-sm font-normal text-[#7390A9]">/bln</span>
                                </span>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-white">{{ $rental->boardingHouse->name ?? '-' }}</h4>
                                <p class="text-[#7390A9] text-sm flex items-center gap-2">
                                    <span class="inline-block w-2 h-2 bg-[#0194DC] rounded-full"></span>
                                    Kamar {{ $rental->room_number ?? '-' }}
                                </p>
                            </div>
                            <div class="grid grid-cols-2 gap-2 pt-3 border-t border-white/10">
                                <div>
                                    <p class="text-[10px] uppercase font-semibold text-[#7390A9]/60">Mulai Sewa</p>
                                    <p class="text-sm font-medium text-white">
                                        {{ $rental->start_date ? $rental->start_date->format('d M Y') : '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] uppercase font-semibold text-[#7390A9]/60">Akhir Sewa</p>
                                    <p class="text-sm font-medium text-white">
                                        {{ $rental->end_date ? $rental->end_date->format('d M Y') : '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ============================================================ -->
                <!-- STATISTICS CARDS -->
                <!-- ============================================================ -->
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Durasi Sewa -->
                    <div class="bg-white border border-[#C3C7CD] rounded-xl p-4 shadow-sm">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-full bg-[#CFE6EF] flex items-center justify-center text-[#52686F]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-semibold text-[#42474C] uppercase tracking-wide">Durasi Sewa</p>
                                <p class="text-xl font-black text-[#001220]">{{ $rental->duration_months ?? 0 }} Bulan</p>
                            </div>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="bg-white border border-[#C3C7CD] rounded-xl p-4 shadow-sm">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-full bg-[#CFE6EF] flex items-center justify-center text-[#52686F]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-semibold text-[#42474C] uppercase tracking-wide">Status Sewa</p>
                                <p class="text-xl font-black">
                                    @if ($rental->status == 'paid')
                                        <span class="text-[#15803D]">✓ Aktif</span>
                                    @elseif($rental->status == 'pending')
                                        <span class="text-[#F59E0B]">⏳ Pending</span>
                                    @else
                                        <span class="text-[#BA1A1A]">{{ ucfirst($rental->status) }}</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Total Biaya -->
                    <div class="bg-white border border-[#C3C7CD] rounded-xl p-4 shadow-sm">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-full bg-[#CFE6EF] flex items-center justify-center text-[#52686F]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v4m0 4v4m-6-6h2m6 0h2" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-semibold text-[#42474C] uppercase tracking-wide">Total Biaya</p>
                                <p class="text-xl font-black text-[#001220]">Rp
                                    {{ number_format($rental->total_price, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Sisa Sewa -->
                    <div class="bg-white border border-[#C3C7CD] rounded-xl p-4 shadow-sm">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-full bg-[#CFE6EF] flex items-center justify-center text-[#52686F]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-semibold text-[#42474C] uppercase tracking-wide">Sisa Sewa</p>
                                @php
                                    $daysLeft = $rental->end_date ? now()->diffInDays($rental->end_date) : 0;
                                @endphp
                                <p class="text-xl font-black">
                                    @if ($daysLeft > 30)
                                        <span class="text-[#0194DC]">{{ $daysLeft }} Hari</span>
                                    @elseif($daysLeft > 0)
                                        <span class="text-[#F59E0B]">{{ $daysLeft }} Hari</span>
                                    @else
                                        <span class="text-[#BA1A1A]">Berakhir</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ============================================================ -->
                <!-- DETAIL INFORMATION -->
                <!-- ============================================================ -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Personal Info -->
                    <div class="bg-[#F2F4F5] p-5 rounded-xl border border-[#C3C7CD]">
                        <div class="flex items-center gap-2 mb-4">
                            <svg class="w-4 h-4 text-[#42474C]" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <h4 class="text-[#42474C] text-xs font-semibold tracking-wide">INFORMASI PRIBADI</h4>
                        </div>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center py-2 border-b border-[#C3C7CD]/50">
                                <span class="text-[#42474C] text-sm">Pekerjaan</span>
                                <span class="text-[#191C1D] text-sm font-medium">{{ $tenant->occupation ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2">
                                <span class="text-[#42474C] text-sm">Jenis Kelamin</span>
                                <span
                                    class="text-[#191C1D] text-sm font-medium">{{ $tenant->gender === 'P' ? 'Perempuan' : 'Laki-laki' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Rental Detail -->
                    <div class="bg-[#CCE5FF] p-5 rounded-xl border border-[#2D4A60]">
                        <div class="flex items-center gap-2 mb-4">
                            <svg class="w-4 h-4 text-[#001E31]" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            <h4 class="text-[#001E31] text-xs font-semibold tracking-wide">DETAIL SEWA</h4>
                        </div>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center py-2 border-b border-[#2D4A60]/30">
                                <span class="text-[#004B72] text-sm">Properti</span>
                                <span
                                    class="text-[#001E31] text-sm font-medium">{{ $rental->boardingHouse->name ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-[#2D4A60]/30">
                                <span class="text-[#004B72] text-sm">Nomor Kamar</span>
                                <span class="text-[#001E31] text-sm font-medium">{{ $rental->room_number ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-[#2D4A60]/30">
                                <span class="text-[#004B72] text-sm">Kode Unik</span>
                                <span
                                    class="text-[#001E31] text-sm font-mono font-medium">{{ $rental->unique_code ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2">
                                <span class="text-[#004B72] text-sm">Status Pembayaran</span>
                                @php
                                    $payment = $rental->payment;
                                    $paymentStatus = $payment ? $payment->status : 'pending';
                                    $paymentLabels = [
                                        'verified' => ['label' => '✅ Lunas', 'class' => 'text-[#15803D]'],
                                        'pending' => ['label' => '⏳ Pending', 'class' => 'text-[#92400E]'],
                                        'rejected' => ['label' => '❌ Ditolak', 'class' => 'text-[#BA1A1A]'],
                                    ];
                                    $paymentLabel = $paymentLabels[$paymentStatus] ?? $paymentLabels['pending'];
                                @endphp
                                <span
                                    class="text-sm font-medium {{ $paymentLabel['class'] }}">{{ $paymentLabel['label'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div
                class="px-6 py-4 border-t border-[#C3C7CD] bg-[#ECEEEF] flex flex-col sm:flex-row items-center justify-between gap-4">
                <a href="https://wa.me/{{ $user->phone ?? '62' }}" target="_blank"
                    class="flex items-center justify-center gap-2 px-6 py-3 bg-[#06283D] text-white rounded-lg font-bold hover:bg-[#001220] transition-all shadow-md w-full sm:w-auto">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                    </svg>
                    Hubungi via WA
                </a>
                <a href="{{ route('owner.tenant.index') }}"
                    class="px-8 py-3 text-[#42474C] font-medium hover:text-[#001220] transition-colors text-center w-full sm:w-auto">
                    Tutup
                </a>
            </div>
        </div>
    </div>
@endsection
