@extends('layouts.owner')

@section('title', 'Detail Pembayaran - KostMudah')

@section('content')
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50">
        <!-- Modal Container -->
        <div class="bg-white w-full max-w-4xl max-h-[90vh] rounded-xl shadow-2xl flex flex-col overflow-hidden">
            <!-- Header -->
            <div class="flex items-center justify-between px-6 py-4 border-b border-[#C3C7CD] bg-white">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-[#06283D] flex items-center justify-center text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-semibold text-[#001220]">Detail Pembayaran</h2>
                    @php
                        $statusLabels = [
                            'verified' => ['label' => 'Lunas', 'class' => 'bg-[#DCFCE7] text-[#15803D]'],
                            'pending' => ['label' => 'Pending', 'class' => 'bg-[#FEF3C7] text-[#92400E]'],
                            'rejected' => ['label' => 'Ditolak', 'class' => 'bg-[#FEE2E2] text-[#991B1B]'],
                        ];
                        $statusLabel = $statusLabels[$payment->status] ?? $statusLabels['pending'];
                    @endphp
                    <span
                        class="inline-block {{ $statusLabel['class'] }} text-[10px] font-bold uppercase px-2 py-1 rounded">
                        {{ $statusLabel['label'] }}
                    </span>
                </div>
                <a href="{{ route('owner.payment.index') }}" class="p-2 hover:bg-gray-200 rounded-full transition-colors">
                    <svg class="w-5 h-5 text-[#42474C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </a>
            </div>

            <!-- Content -->
            <div class="flex-1 overflow-y-auto p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Left Column - Payment Info -->
                    <div class="space-y-4">
                        <h4 class="text-[#42474C] text-xs font-semibold tracking-wide uppercase">Informasi Pembayaran</h4>
                        <div class="bg-[#F2F4F5] p-4 rounded-lg border border-[#C3C7CD] space-y-3">
                            <div class="flex justify-between items-center py-1 border-b border-[#C3C7CD]/50">
                                <span class="text-[#42474C] text-sm">ID Invoice</span>
                                <span
                                    class="text-[#191C1D] text-sm font-medium font-mono">INV-{{ str_pad($payment->id, 4, '0', STR_PAD_LEFT) }}</span>
                            </div>
                            <div class="flex justify-between items-center py-1 border-b border-[#C3C7CD]/50">
                                <span class="text-[#42474C] text-sm">Jumlah</span>
                                <span class="text-[#191C1D] text-sm font-bold">Rp
                                    {{ number_format($payment->amount, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between items-center py-1 border-b border-[#C3C7CD]/50">
                                <span class="text-[#42474C] text-sm">Metode</span>
                                <span class="text-[#191C1D] text-sm font-medium">
                                    @php
                                        $methodLabels = [
                                            'bank_transfer' => 'Transfer Bank',
                                            'qris' => 'QRIS',
                                            'ewallet' => 'E-Wallet',
                                        ];
                                        echo $methodLabels[$payment->method] ?? $payment->method;
                                    @endphp
                                </span>
                            </div>
                            <div class="flex justify-between items-center py-1 border-b border-[#C3C7CD]/50">
                                <span class="text-[#42474C] text-sm">Status</span>
                                <span
                                    class="inline-block {{ $statusLabel['class'] }} text-[10px] font-semibold px-2.5 py-0.5 rounded-full">
                                    {{ $statusLabel['label'] }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center py-1">
                                <span class="text-[#42474C] text-sm">Tanggal</span>
                                <span
                                    class="text-[#191C1D] text-sm font-medium">{{ $payment->created_at->format('d M Y H:i') }}</span>
                            </div>
                            @if ($payment->verified_at)
                                <div class="flex justify-between items-center py-1 border-t border-[#C3C7CD]/50 pt-2">
                                    <span class="text-[#42474C] text-sm">Diverifikasi Pada</span>
                                    <span
                                        class="text-[#15803D] text-sm font-medium">{{ $payment->verified_at->format('d M Y H:i') }}</span>
                                </div>
                            @endif
                            @if ($payment->notes)
                                <div class="flex justify-between items-center py-1 border-t border-[#C3C7CD]/50 pt-2">
                                    <span class="text-[#42474C] text-sm">Catatan</span>
                                    <span class="text-[#191C1D] text-sm font-medium">{{ $payment->notes }}</span>
                                </div>
                            @endif
                        </div>

                        <!-- Bukti Pembayaran (Placeholder) -->
                        @if ($payment->proof_path)
                            <div>
                                <h4 class="text-[#42474C] text-xs font-semibold tracking-wide uppercase mb-2">Bukti
                                    Pembayaran</h4>
                                <div
                                    class="bg-[#F2F4F5] p-4 rounded-lg border border-[#C3C7CD] flex items-center justify-center">
                                    <img src="{{ Storage::url($payment->proof_path) }}" alt="Bukti Pembayaran"
                                        class="max-h-48 rounded-lg">
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Right Column - Tenant Info -->
                    <div class="space-y-4">
                        <h4 class="text-[#42474C] text-xs font-semibold tracking-wide uppercase">Informasi Penyewa</h4>
                        <div class="bg-[#CCE5FF] p-4 rounded-lg border border-[#2D4A60] space-y-3">
                            @php
                                $user = $payment->rental->tenant->user ?? null;
                            @endphp
                            <div class="flex items-center gap-3 pb-3 border-b border-[#2D4A60]/30">
                                @if ($user)
                                    @php
                                        $initials = collect(explode(' ', $user->name))
                                            ->map(fn($word) => strtoupper(substr($word, 0, 1)))
                                            ->take(2)
                                            ->implode('');
                                        $genderColor =
                                            $payment->rental->tenant->gender === 'P'
                                                ? 'bg-[#ADCAE5] text-[#001220]'
                                                : 'bg-[#CFE6EF] text-[#4C6269]';
                                    @endphp
                                    <div
                                        class="w-10 h-10 {{ $genderColor }} rounded-full flex items-center justify-center font-bold text-sm flex-shrink-0">
                                        {{ $initials }}
                                    </div>
                                    <div>
                                        <p class="text-[#001E31] font-semibold text-sm">{{ $user->name ?? '-' }}</p>
                                        <p class="text-[#004B72] text-xs">ID:
                                            TEN-{{ str_pad($payment->rental->tenant->id ?? 0, 4, '0', STR_PAD_LEFT) }}</p>
                                    </div>
                                @else
                                    <div class="text-[#004B72] text-sm">Data penyewa tidak tersedia</div>
                                @endif
                            </div>
                            <div class="space-y-2">
                                <div class="flex justify-between items-center">
                                    <span class="text-[#004B72] text-sm">Email</span>
                                    <span class="text-[#001E31] text-sm font-medium">{{ $user->email ?? '-' }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-[#004B72] text-sm">Telepon</span>
                                    <span class="text-[#001E31] text-sm font-medium">{{ $user->phone ?? '-' }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-[#004B72] text-sm">Properti</span>
                                    <span
                                        class="text-[#001E31] text-sm font-medium">{{ $payment->rental->boardingHouse->name ?? '-' }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-[#004B72] text-sm">Kamar</span>
                                    <span
                                        class="text-[#001E31] text-sm font-medium">{{ $payment->rental->room_number ?? '-' }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-[#004B72] text-sm">Periode Sewa</span>
                                    <span class="text-[#001E31] text-sm font-medium">
                                        {{ $payment->rental->start_date ? $payment->rental->start_date->format('d M Y') : '-' }}
                                        -
                                        {{ $payment->rental->end_date ? $payment->rental->end_date->format('d M Y') : '-' }}
                                    </span>
                                </div>
                                <div class="flex justify-between items-center pt-2 border-t border-[#2D4A60]/30">
                                    <span class="text-[#004B72] text-sm">Status Sewa</span>
                                    <span class="text-[#001E31] text-sm font-medium">
                                        @if ($payment->rental->status == 'paid')
                                            <span class="text-[#15803D]">Aktif</span>
                                        @elseif($payment->rental->status == 'pending')
                                            <span class="text-[#F59E0B]">Pending</span>
                                        @else
                                            <span class="text-[#42474C]">{{ ucfirst($payment->rental->status) }}</span>
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        @if ($payment->status == 'pending')
                            <div class="flex flex-col sm:flex-row gap-3">
                                <form action="{{ route('owner.payment.verify', $payment->id) }}" method="POST"
                                    class="flex-1">
                                    @csrf
                                    @method('POST')
                                    <button type="submit"
                                        class="w-full px-6 py-3 bg-[#0194DC] text-white rounded-lg font-bold hover:bg-[#0179b8] transition-colors shadow-md"
                                        onclick="return confirm('Yakin ingin memverifikasi pembayaran ini?')">
                                        <span class="flex items-center justify-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                            Verifikasi Pembayaran
                                        </span>
                                    </button>
                                </form>
                                <form action="{{ route('owner.payment.reject', $payment->id) }}" method="POST"
                                    class="flex-1">
                                    @csrf
                                    @method('POST')
                                    <button type="submit"
                                        class="w-full px-6 py-3 border-2 border-[#BA1A1A] text-[#BA1A1A] rounded-lg font-bold hover:bg-[#BA1A1A] hover:text-white transition-colors"
                                        onclick="return confirm('Yakin ingin menolak pembayaran ini?')">
                                        <span class="flex items-center justify-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            Tolak Pembayaran
                                        </span>
                                    </button>
                                </form>
                            </div>
                        @elseif($payment->status == 'verified')
                            <div class="bg-[#DCFCE7] p-4 rounded-lg border border-[#15803D]/20 text-center">
                                <p class="text-[#15803D] font-semibold">✓ Pembayaran telah diverifikasi</p>
                            </div>
                        @elseif($payment->status == 'rejected')
                            <div class="bg-[#FEE2E2] p-4 rounded-lg border border-[#991B1B]/20 text-center">
                                <p class="text-[#991B1B] font-semibold">✗ Pembayaran ditolak</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="px-6 py-4 border-t border-[#C3C7CD] bg-[#ECEEEF] flex justify-end">
                <a href="{{ route('owner.payment.index') }}"
                    class="px-6 py-2 text-[#42474C] font-medium hover:text-[#001220] transition-colors">
                    Tutup
                </a>
            </div>
        </div>
    </div>
@endsection
