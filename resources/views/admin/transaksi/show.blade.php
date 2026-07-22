@extends('layouts.admin')

@section('title', 'Detail Transaksi - KostMudah')

@section('content')
    <div class="modal-overlay">
        <div class="modal-container">
            <!-- Header -->
            <div class="sticky-top bg-white px-6 pt-6 pb-4 border-b border-[#C3C7CD]">
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-[#06283D] flex items-center justify-center text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v1m0 1V9m0 1v1m0 1V9m0 1v1M12 8v1m0 1V9m0 1v1m0 1V9m0 1v1m0 0v1M9 15h6" />
                            </svg>
                        </div>
                        <h2 class="text-[#001220] text-xl font-semibold">Detail Transaksi</h2>
                        @php
                            $statusColors = [
                                'paid' => 'bg-[#E8F5E9] text-[#2E7D32]',
                                'pending' => 'bg-[#FFF3E0] text-[#E65100]',
                                'cancelled' => 'bg-[#FFDAD6] text-[#BA1A1A]',
                                'completed' => 'bg-[#CCE5FF] text-[#004B72]',
                            ];
                            $statusLabels = [
                                'paid' => 'Paid',
                                'pending' => 'Pending',
                                'cancelled' => 'Cancelled',
                                'completed' => 'Completed',
                            ];
                            $color = $statusColors[$transaction->status] ?? 'bg-[#F2F4F5] text-[#42474C]';
                            $label = $statusLabels[$transaction->status] ?? ucfirst($transaction->status);
                        @endphp
                        <span
                            class="inline-block {{ $color }} text-[10px] font-bold uppercase px-2.5 py-0.5 rounded-full">
                            {{ $label }}
                        </span>
                    </div>
                    <a href="{{ route('admin.transaksi.index') }}"
                        class="p-2 hover:bg-gray-100 rounded-full transition-colors">
                        <svg class="w-5 h-5 text-[#42474C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Content -->
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Left Column -->
                    <div class="space-y-4">
                        <div>
                            <p class="text-[#42474C] text-xs font-semibold tracking-wide uppercase">ID Transaksi</p>
                            <p class="text-[#191C1D] text-base font-semibold mt-1">
                                #{{ $transaction->unique_code ?? 'KM-' . str_pad($transaction->id, 5, '0', STR_PAD_LEFT) }}
                            </p>
                        </div>

                        <div>
                            <p class="text-[#42474C] text-xs font-semibold tracking-wide uppercase">Penyewa</p>
                            <p class="text-[#191C1D] text-base font-semibold mt-1">
                                {{ $transaction->tenant && $transaction->tenant->user ? $transaction->tenant->user->name : '-' }}
                            </p>
                            <p class="text-[#42474C] text-sm">
                                {{ $transaction->tenant && $transaction->tenant->user ? $transaction->tenant->user->email : '-' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-[#42474C] text-xs font-semibold tracking-wide uppercase">Properti</p>
                            <p class="text-[#191C1D] text-base font-semibold mt-1">
                                {{ $transaction->boardingHouse ? $transaction->boardingHouse->name : '-' }}</p>
                            <p class="text-[#42474C] text-sm">Room {{ $transaction->room_number ?? '-' }}</p>
                        </div>

                        <div>
                            <p class="text-[#42474C] text-xs font-semibold tracking-wide uppercase">Periode Sewa</p>
                            <p class="text-[#191C1D] text-base mt-1">
                                {{ $transaction->start_date ? $transaction->start_date->format('d M Y') : '-' }} -
                                {{ $transaction->end_date ? $transaction->end_date->format('d M Y') : '-' }}</p>
                            <p class="text-[#42474C] text-sm">{{ $transaction->duration_months ?? 0 }} bulan</p>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-4">
                        <div>
                            <p class="text-[#42474C] text-xs font-semibold tracking-wide uppercase">Total Harga</p>
                            <p class="text-[#191C1D] text-2xl font-bold mt-1">Rp
                                {{ number_format($transaction->total_price, 0, ',', '.') }}</p>
                        </div>

                        <div>
                            <p class="text-[#42474C] text-xs font-semibold tracking-wide uppercase">Status</p>
                            <span
                                class="inline-block {{ $color }} text-xs font-bold uppercase px-3 py-1 rounded-full mt-1">
                                {{ $label }}
                            </span>
                        </div>

                        <div>
                            <p class="text-[#42474C] text-xs font-semibold tracking-wide uppercase">Tanggal Transaksi</p>
                            <p class="text-[#191C1D] text-base mt-1">
                                {{ $transaction->created_at ? $transaction->created_at->format('d M Y H:i') : '-' }}</p>
                        </div>

                        @if ($transaction->payments && $transaction->payments->count() > 0)
                            <div>
                                <p class="text-[#42474C] text-xs font-semibold tracking-wide uppercase">Riwayat Pembayaran
                                </p>
                                <div class="mt-2 space-y-2">
                                    @foreach ($transaction->payments as $payment)
                                        <div class="bg-[#F2F4F5] rounded-lg p-3">
                                            <div class="flex justify-between items-center">
                                                <div>
                                                    <p class="text-[#191C1D] text-sm font-semibold">Rp
                                                        {{ number_format($payment->amount, 0, ',', '.') }}</p>
                                                    <p class="text-[#42474C] text-xs">
                                                        {{ $payment->created_at ? $payment->created_at->format('d M Y H:i') : '-' }}
                                                    </p>
                                                    <p class="text-[#42474C] text-xs">Metode: {{ $payment->method_label }}
                                                    </p>
                                                </div>
                                                <span
                                                    class="text-[#42474C] text-xs bg-white px-2 py-1 rounded-full 
                    {{ $payment->status == 'verified'
                        ? 'text-[#15803D]'
                        : ($payment->status == 'pending'
                            ? 'text-[#F59E0B]'
                            : 'text-[#BA1A1A]') }}">
                                                    {{ ucfirst($payment->status) }}
                                                </span>
                                            </div>
                                            @if ($payment->verified_by && $payment->verifiedBy)
                                                <p class="text-[#42474C] text-xs mt-1">Diverifikasi oleh:
                                                    {{ $payment->verifiedBy->name }}</p>
                                            @endif
                                            @if ($payment->rejection_reason)
                                                <p class="text-[#BA1A1A] text-xs mt-1 bg-[#FEE2E2] p-2 rounded-lg">
                                                    <strong>Alasan ditolak:</strong> {{ $payment->rejection_reason }}
                                                </p>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if ($transaction->status === 'cancelled' && $transaction->payments->where('status', 'rejected')->first())
                            <div>
                                <p class="text-[#42474C] text-xs font-semibold tracking-wide uppercase">Alasan Dibatalkan
                                </p>
                                @php
                                    $rejectedPayment = $transaction->payments->where('status', 'rejected')->first();
                                @endphp
                                @if ($rejectedPayment && $rejectedPayment->rejection_reason)
                                    <p class="text-[#BA1A1A] text-sm mt-1 bg-[#FEE2E2] p-3 rounded-lg">
                                        {{ $rejectedPayment->rejection_reason }}</p>
                                @else
                                    <p class="text-[#BA1A1A] text-sm mt-1 bg-[#FEE2E2] p-3 rounded-lg">Transaksi dibatalkan
                                    </p>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Footer -->
                <div class="flex justify-end pt-4 mt-4 border-t border-[#C3C7CD]">
                    <a href="{{ route('admin.transaksi.index') }}"
                        class="px-6 py-2 border border-[#C3C7CD] rounded-lg text-[#42474C] font-semibold hover:bg-gray-50 transition-colors">
                        Tutup
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
