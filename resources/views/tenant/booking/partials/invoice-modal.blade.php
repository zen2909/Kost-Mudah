{{-- Invoice Modal --}}
<div id="invoiceModalOverlay"
    class="hidden fixed inset-0 z-[60] bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
    <div id="invoiceModal"
        class="w-full max-w-[500px] bg-white rounded-lg shadow-2xl overflow-hidden max-h-[90vh] flex flex-col">

        {{-- Header --}}
        <div class="px-6 py-4 border-b border-neutral-300 flex justify-between items-center flex-shrink-0">
            <h2 class="text-cyan-950 text-base font-normal">Detail Pembayaran / Invoice</h2>
            <button type="button" id="closeInvoiceModal" class="p-1 hover:bg-gray-100 rounded-full transition">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Content --}}
        <div class="px-6 py-6 overflow-y-auto flex-1">

            {{-- Invoice Number & Date --}}
            <div class="flex justify-between items-end mb-4">
                <div>
                    <p class="text-zinc-700 text-xs uppercase tracking-wide">INVOICE NUMBER</p>
                    <p class="text-cyan-950 text-base font-semibold">{{ $rental->unique_code }}</p>
                </div>
                <div>
                    <p class="text-zinc-700 text-sm">{{ $rental->created_at->format('d M Y, H:i') }} WIB</p>
                </div>
            </div>

            {{-- Kost Info --}}
            <div class="p-4 bg-gray-100 rounded-lg outline outline-1 outline-neutral-300">
                <div class="flex items-start gap-4">
                    <div
                        class="w-12 h-12 bg-cyan-950 rounded-sm flex items-center justify-center flex-shrink-0 overflow-hidden">
                        @if ($rental->boardingHouse->primaryPhoto)
                            <img src="{{ asset('storage/' . $rental->boardingHouse->primaryPhoto->path) }}"
                                alt="{{ $rental->boardingHouse->name }}" class="w-full h-full object-cover">
                        @else
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z" />
                            </svg>
                        @endif
                    </div>
                    <div>
                        <p class="text-cyan-950 text-sm font-semibold">{{ $rental->boardingHouse->name }}</p>
                        <p class="text-zinc-700 text-sm">Kamar {{ $rental->boardingHouse->room_number ?? 'Standar' }}
                        </p>
                    </div>
                </div>

                {{-- Date Range --}}
                <div class="mt-4 pt-4 border-t border-neutral-300 flex justify-between">
                    <div>
                        <p class="text-zinc-500 text-[10px] font-bold uppercase">START</p>
                        <p class="text-zinc-900 text-sm font-semibold">{{ $rental->start_date->format('d M Y') }}</p>
                    </div>
                    <div>
                        <p class="text-zinc-500 text-[10px] font-bold uppercase">END</p>
                        <p class="text-zinc-900 text-sm font-semibold">{{ $rental->end_date->format('d M Y') }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-zinc-500 text-[10px] font-bold uppercase">DURATION</p>
                        <p class="text-zinc-900 text-sm font-semibold">{{ $rental->duration_months }} Bulan</p>
                    </div>
                </div>
            </div>

            {{-- Pricing Summary --}}
            <div class="mt-4">
                <p class="text-zinc-700 text-xs uppercase tracking-wide mb-3">PRICING SUMMARY</p>

                <div class="space-y-2">
                    <div class="flex justify-between items-center">
                        <span class="text-zinc-700 text-sm">Harga per Bulan</span>
                        <span
                            class="text-zinc-900 text-sm font-semibold">Rp{{ number_format($rental->boardingHouse->price_per_month, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-zinc-700 text-sm">Biaya Layanan</span>
                        <span class="text-zinc-900 text-sm font-semibold">Rp0</span>
                    </div>
                    <div class="flex justify-between items-center pt-3 border-t-2 border-neutral-300 mt-2">
                        <span class="text-cyan-950 text-base font-semibold">Total Amount</span>
                        <span
                            class="text-cyan-950 text-xl font-bold">Rp{{ number_format($rental->total_price, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            {{-- Status & Method --}}
            <div class="mt-4 grid grid-cols-2 gap-4">
                <div class="p-3 bg-gray-100 rounded-lg outline outline-1 outline-neutral-300">
                    <p class="text-zinc-500 text-[10px] font-bold uppercase">STATUS</p>
                    <div class="flex items-center gap-2 mt-1">
                        <div class="w-2 h-2 bg-yellow-500 rounded-full"></div>
                        <span class="text-yellow-700 text-sm font-semibold">Menunggu Verifikasi</span>
                    </div>
                </div>
                <div class="p-3 bg-gray-100 rounded-lg outline outline-1 outline-neutral-300">
                    <p class="text-zinc-500 text-[10px] font-bold uppercase">METHOD</p>
                    <p class="text-cyan-950 text-sm font-semibold mt-1">
                        @if ($rental->payment)
                            @php
                                $methodLabels = [
                                    'bank_transfer' => 'Transfer Bank',
                                    'qris' => 'QRIS',
                                    'ewallet' => 'E-Wallet',
                                ];
                            @endphp
                            {{ $methodLabels[$rental->payment->method] ?? $rental->payment->method }}
                            @if ($rental->payment->method === 'ewallet' && $rental->payment->ewallet_provider)
                                ({{ strtoupper($rental->payment->ewallet_provider) }})
                            @endif
                        @else
                            -
                        @endif
                    </p>
                </div>
            </div>

            {{-- Bukti Transfer --}}
            @if ($rental->payment && $rental->payment->proof_path)
                <div class="mt-4">
                    <p class="text-zinc-700 text-xs uppercase tracking-wide mb-2">BUKTI TRANSFER</p>
                    <div class="rounded-lg outline outline-1 outline-neutral-300 overflow-hidden">
                        <img src="{{ asset('storage/' . $rental->payment->proof_path) }}" alt="Bukti Transfer"
                            class="w-full max-h-64 object-contain">
                    </div>
                </div>
            @endif

            {{-- Notes --}}
            @if ($rental->payment && $rental->payment->notes)
                <div class="mt-4 p-3 bg-gray-50 rounded-lg outline outline-1 outline-neutral-300">
                    <p class="text-zinc-500 text-[10px] font-bold uppercase">CATATAN</p>
                    <p class="text-zinc-700 text-sm mt-1">{{ $rental->payment->notes }}</p>
                </div>
            @endif

        </div>

        <div class="px-6 py-4 border-t border-neutral-300 flex justify-end items-center gap-3 flex-shrink-0 bg-white">
            <button id="printInvoiceBtn"
                class="px-6 py-2 rounded-lg outline outline-2 outline-cyan-950 text-cyan-950 font-semibold hover:bg-cyan-50 transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                Cetak
            </button>
            <button id="closeInvoiceModalBtn"
                class="px-8 py-2 bg-cyan-950 rounded-lg shadow-sm text-white font-semibold hover:bg-cyan-900 transition">
                Tutup
            </button>
        </div>
    </div>
</div>
