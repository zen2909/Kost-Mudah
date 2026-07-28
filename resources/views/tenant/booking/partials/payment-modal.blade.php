{{-- Modal Overlay --}}
<div id="modalOverlay"
    class="hidden fixed inset-0 z-50 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
    <div id="paymentModal"
        class="w-full max-w-[500px] bg-white rounded-lg shadow-2xl overflow-hidden max-h-[90vh] flex flex-col">

        {{-- Header --}}
        <div class="px-6 py-4 border-b border-neutral-300 flex justify-between items-center flex-shrink-0">
            <h2 class="text-cyan-950 text-base font-normal">Upload Bukti Pembayaran</h2>
            <button type="button" id="closeModal" class="p-1 hover:bg-gray-100 rounded-full transition">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Content --}}
        <form id="paymentForm" action="{{ route('tenant.booking.store') }}" method="POST" enctype="multipart/form-data"
            class="flex flex-col flex-1 overflow-hidden">
            @csrf

            <div class="px-6 py-6 overflow-y-auto flex-1">

                {{-- HIDDEN INPUTS - Pastikan semua ada dan terisi --}}
                <input type="hidden" name="boarding_house_id" id="modal_boarding_house_id" value="">
                <input type="hidden" name="duration_months" id="modal_duration_months" value="">
                <input type="hidden" name="start_date" id="modal_start_date" value="">
                <input type="hidden" name="total_price" id="modal_total_price" value="">
                <input type="hidden" name="method" id="selectedMethod" value="">
                <input type="hidden" name="ewallet_provider" id="selectedEwallet" value="">

                {{-- Summary --}}
                <div class="p-4 bg-gray-100 rounded-lg outline outline-1 outline-neutral-300">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-zinc-700 text-xs uppercase tracking-wide">TOTAL BAYAR</p>
                            <p id="modalTotalPrice" class="text-slate-950 text-lg font-semibold">Rp 0</p>
                        </div>
                        <span class="px-3 py-1 bg-slate-200 rounded-full text-slate-600 text-xs font-semibold">Menunggu
                            Pembayaran</span>
                    </div>

                    <div class="mt-3 pt-3 border-t border-neutral-300/30 grid grid-cols-2 gap-2 text-sm">
                        <div>
                            <p class="text-zinc-700 text-xs">Durasi</p>
                            <p id="modalDuration" class="text-slate-950 font-semibold">-</p>
                        </div>
                        <div>
                            <p class="text-zinc-700 text-xs">Tanggal Mulai</p>
                            <p id="modalStartDate" class="text-slate-950 font-semibold">-</p>
                        </div>
                    </div>
                </div>

                {{-- METODE PEMBAYARAN --}}
                <div class="mt-4">
                    <p class="text-zinc-700 text-xs uppercase tracking-wide mb-2">METODE PEMBAYARAN</p>
                    <div class="p-1 bg-gray-200 rounded-lg flex gap-2">
                        <button type="button" data-method="bank_transfer"
                            class="method-btn flex-1 px-3 py-2 rounded-md bg-white shadow-sm text-cyan-950 text-sm font-semibold transition">
                            Transfer Bank
                        </button>
                        <button type="button" data-method="qris"
                            class="method-btn flex-1 px-3 py-2 rounded-md text-zinc-700 text-sm font-normal transition">
                            QRIS
                        </button>
                        <button type="button" data-method="ewallet"
                            class="method-btn flex-1 px-3 py-2 rounded-md text-zinc-700 text-sm font-normal transition">
                            E-Wallet
                        </button>
                    </div>
                </div>

                {{-- BANK TRANSFER --}}
                <div id="bankContent" class="mt-4">
                    <div class="pt-4 border-t border-neutral-300/30">
                        <p class="text-zinc-700 text-xs uppercase tracking-wide">TRANSFER KE REKENING:</p>

                        @php
                            $hasBank = isset($owner) && $owner && $owner->bank_account_number;
                        @endphp

                        <div
                            class="mt-3 flex items-center gap-4 p-3 bg-white rounded-lg outline outline-1 outline-neutral-300">
                            <div
                                class="w-12 h-12 {{ isset($owner) && $owner ? $owner->bank_icon ?? 'bg-gray-100' : 'bg-gray-100' }} rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-slate-950 font-semibold">
                                    {{ isset($owner) && $owner ? $owner->bank_name ?? 'Bank' : 'Bank' }}</p>
                                <div class="flex items-center gap-2">
                                    <p class="text-zinc-900 font-mono">
                                        {{ $hasBank ? $owner->bank_account_number : 'Belum diatur' }}</p>
                                    @if ($hasBank)
                                        <button type="button" data-account="{{ $owner->bank_account_number }}"
                                            class="copy-btn text-cyan-950 text-xs font-semibold hover:underline">
                                            Salin
                                        </button>
                                    @endif
                                </div>
                                <p class="text-zinc-700 text-sm">
                                    a.n.
                                    {{ isset($owner) && $owner ? $owner->bank_account_holder ?? ($owner->user->name ?? '') : 'Belum diatur' }}
                                </p>
                            </div>
                        </div>

                        @if (!$hasBank)
                            <div class="mt-3 p-3 bg-yellow-50 rounded-lg border border-yellow-200">
                                <p class="text-xs text-yellow-800 text-center">
                                    ⚠️ Pemilik kost belum mengatur rekening bank. Silakan hubungi pemilik kost.
                                </p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- QRIS --}}
                <div id="qrisContent" class="mt-4 hidden">
                    <div class="pt-4 border-t border-neutral-300/30">
                        <p class="text-zinc-700 text-xs uppercase tracking-wide">SCAN QRIS:</p>

                        <div class="mt-3 flex flex-col items-center">
                            @php
                                // Ambil data QRIS dari owner
                                $qrisEwallet = isset($owner) && $owner ? $owner->qris_ewallet : null;
                                $qrisNumber = isset($owner) && $owner ? $owner->getEwalletNumber($qrisEwallet) : null;
                                $qrisImage = isset($owner) && $owner ? $owner->qris_image : null;

                                $ewalletLabels = [
                                    'ovo' => 'OVO',
                                    'dana' => 'DANA',
                                    'shopeepay' => 'ShopeePay',
                                ];

                                $ewalletColors = [
                                    'ovo' => 'purple',
                                    'dana' => 'blue',
                                    'shopeepay' => 'orange',
                                ];
                            @endphp

                            <div
                                class="w-48 h-48 p-2 bg-white rounded-lg outline outline-1 outline-neutral-300 flex items-center justify-center">
                                @if ($qrisImage && Storage::disk('public')->exists($qrisImage))
                                    <img src="{{ asset('storage/' . $qrisImage) }}"
                                        alt="QRIS {{ $ewalletLabels[$qrisEwallet] ?? 'QRIS' }}"
                                        class="w-full h-full object-contain">
                                @elseif($qrisEwallet && $qrisNumber)
                                    {{-- Tampilkan placeholder QRIS --}}
                                    <div class="text-center">
                                        <div
                                            class="w-40 h-40 bg-gray-100 rounded-lg flex items-center justify-center mx-auto">
                                            <svg class="w-32 h-32 text-gray-400" fill="currentColor"
                                                viewBox="0 0 24 24">
                                                <path d="M3 3h6v6H3V3zm12 0h6v6h-6V3zM3 15h6v6H3v-6zm12 0h6v6h-6v-6z" />
                                                <path d="M9 9h6v6H9V9z" />
                                            </svg>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-2">QRIS untuk
                                            {{ $ewalletLabels[$qrisEwallet] ?? '' }}</p>
                                    </div>
                                @else
                                    <div class="text-center">
                                        <svg class="w-32 h-32 text-gray-300 mx-auto" fill="currentColor"
                                            viewBox="0 0 24 24">
                                            <path d="M3 3h6v6H3V3zm12 0h6v6h-6V3zM3 15h6v6H3v-6zm12 0h6v6h-6v-6z" />
                                        </svg>
                                        <p class="text-sm text-gray-500 mt-2">QRIS belum diatur oleh pemilik kost</p>
                                    </div>
                                @endif
                            </div>

                            @if ($qrisEwallet && $qrisNumber)
                                <div class="mt-3 p-3 bg-gray-50 rounded-lg border border-gray-200 w-full">
                                    <p class="text-xs text-gray-500 text-center">
                                        QRIS ini mengarah ke E-Wallet <span
                                            class="font-semibold">{{ $ewalletLabels[$qrisEwallet] ?? '' }}</span>
                                    </p>
                                    <p class="text-sm text-center font-mono text-gray-700 mt-1">{{ $qrisNumber }}
                                    </p>
                                    <button type="button" data-account="{{ $qrisNumber }}"
                                        class="copy-btn text-cyan-950 text-xs font-semibold hover:underline mx-auto block mt-1">
                                        Salin Nomor
                                    </button>
                                </div>
                            @else
                                <div class="mt-3 p-3 bg-yellow-50 rounded-lg border border-yellow-200 w-full">
                                    <p class="text-xs text-yellow-800 text-center">
                                        ⚠️ Pemilik kost belum mengatur QRIS. Silakan hubungi pemilik kost.
                                    </p>
                                </div>
                            @endif

                            <p class="mt-3 text-zinc-700 text-sm text-center">
                                Scan QRIS melalui aplikasi Mobile Banking atau E-Wallet favorit Anda.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- E-WALLET --}}
                <div id="ewalletContent" class="mt-4 hidden">
                    <div class="pt-4 border-t border-neutral-300/30">
                        <p class="text-zinc-700 text-xs uppercase tracking-wide">PILIH E-WALLET:</p>

                        <div class="mt-3 space-y-2">
                            @php
                                // Definisikan provider E-Wallet
                                $ewalletProviders = [
                                    'ovo' => [
                                        'label' => 'OVO',
                                        'color' => 'purple',
                                        'icon' => 'O',
                                        'number' => isset($owner) && $owner ? $owner->ewallet_ovo : null,
                                    ],
                                    'dana' => [
                                        'label' => 'DANA',
                                        'color' => 'blue',
                                        'icon' => 'D',
                                        'number' => isset($owner) && $owner ? $owner->ewallet_dana : null,
                                    ],
                                    'shopeepay' => [
                                        'label' => 'ShopeePay',
                                        'color' => 'orange',
                                        'icon' => 'SP',
                                        'number' => isset($owner) && $owner ? $owner->ewallet_shopeepay : null,
                                    ],
                                ];
                            @endphp

                            @foreach ($ewalletProviders as $key => $provider)
                                @php
                                    $hasNumber = !empty($provider['number']);
                                @endphp
                                <button type="button" data-provider="{{ $key }}"
                                    data-number="{{ $provider['number'] }}"
                                    class="ewallet-option w-full flex items-center gap-3 px-3 py-3 rounded-lg outline outline-1 outline-neutral-300 cursor-pointer hover:outline-cyan-950 transition text-left {{ !$hasNumber ? 'opacity-50 cursor-not-allowed' : '' }}"
                                    {{ !$hasNumber ? 'disabled' : '' }}>
                                    <div
                                        class="w-8 h-8 bg-{{ $provider['color'] }}-100 rounded-sm flex items-center justify-center flex-shrink-0">
                                        <span
                                            class="font-bold text-sm text-{{ $provider['color'] }}-600">{{ $provider['icon'] }}</span>
                                    </div>
                                    <div class="flex-1">
                                        <span class="text-zinc-900 font-semibold">{{ $provider['label'] }}</span>
                                        @if ($hasNumber)
                                            <p class="text-xs text-gray-500 font-mono">{{ $provider['number'] }}</p>
                                        @else
                                            <p class="text-xs text-red-500">Belum diatur oleh pemilik</p>
                                        @endif
                                    </div>
                                    @if ($hasNumber)
                                        <button type="button" data-account="{{ $provider['number'] }}"
                                            class="copy-btn text-cyan-950 text-xs font-semibold hover:underline">
                                            Salin
                                        </button>
                                    @endif
                                </button>
                            @endforeach
                        </div>

                        @php
                            $hasAnyEwallet =
                                isset($owner) &&
                                $owner &&
                                ($owner->ewallet_ovo || $owner->ewallet_dana || $owner->ewallet_shopeepay);
                        @endphp

                        @if (!$hasAnyEwallet)
                            <div class="mt-3 p-3 bg-yellow-50 rounded-lg border border-yellow-200">
                                <p class="text-xs text-yellow-800 text-center">
                                    ⚠️ Pemilik kost belum mengatur E-Wallet. Silakan hubungi pemilik kost.
                                </p>
                            </div>
                        @else
                            <div class="mt-3 p-3 bg-yellow-50 rounded-lg border border-yellow-200">
                                <p class="text-xs text-yellow-800">
                                    ⚠️ Pastikan transfer ke nomor E-Wallet yang sesuai dengan pilihan Anda.
                                </p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Upload Bukti --}}
                <div class="mt-4">
                    <p class="text-cyan-950 font-semibold">Bukti Transfer</p>
                    <div id="fileDropzone"
                        class="mt-2 p-8 rounded-lg outline outline-2 outline-dashed outline-neutral-300 hover:outline-cyan-950 transition text-center cursor-pointer">
                        <div class="flex flex-col items-center">
                            <svg class="w-11 h-8 text-gray-400 mb-3" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            <p class="text-zinc-900 font-medium">Klik atau seret file ke sini</p>
                            <p class="text-zinc-700 text-sm">PNG, JPG, atau PDF (Max. 5MB)</p>
                            <input type="file" id="proofInput" name="modal_proof" accept=".png,.jpg,.jpeg,.pdf"
                                class="hidden" required>
                            <button type="button" onclick="document.getElementById('proofInput').click()"
                                class="mt-3 px-6 py-2 bg-cyan-950 rounded-lg text-white font-semibold hover:bg-cyan-900 transition">
                                Pilih File
                            </button>
                        </div>
                    </div>
                    <div id="filePreview" class="hidden mt-2 p-3 bg-green-50 rounded-lg border border-green-200">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span id="fileNameDisplay" class="text-sm text-green-700 font-medium"></span>
                        </div>
                    </div>
                </div>

                {{-- Catatan --}}
                <div class="mt-4">
                    <p class="text-cyan-950 font-semibold">Catatan (Opsional)</p>
                    <textarea name="modal_notes" id="modalNotes" rows="3"
                        class="mt-2 w-full px-3 py-2 bg-white rounded-lg outline outline-1 outline-neutral-300 focus:outline-2 focus:outline-cyan-950 transition text-sm placeholder:text-zinc-400"
                        placeholder="Contoh: Pembayaran sewa bulan Januari atas nama Budi"></textarea>
                </div>
            </div>

            {{-- Footer --}}
            <div
                class="px-6 py-4 border-t border-neutral-300 flex justify-end items-center gap-3 flex-shrink-0 bg-white">
                <button type="button" id="cancelPayment"
                    class="px-6 py-2 rounded-lg text-cyan-950 font-semibold hover:bg-gray-100 transition">
                    Batal
                </button>

                <button type="button" id="submitPayment"
                    class="px-8 py-2 bg-cyan-950 rounded-lg shadow-sm text-white font-semibold hover:bg-cyan-900 transition flex items-center gap-2">
                    Kirim Bukti
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>
            </div>
        </form>
    </div>
</div>
