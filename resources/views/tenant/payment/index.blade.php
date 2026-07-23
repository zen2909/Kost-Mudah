@extends('layouts.tenant')

@section('title', 'Upload Bukti Pembayaran')

@section('content')
    <div class="max-w-2xl mx-auto py-8">
        <div class="bg-white rounded-lg shadow-xl overflow-hidden">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-neutral-300 flex justify-between items-center">
                <h2 class="text-cyan-950 text-base font-normal">Upload Bukti Pembayaran</h2>
                <button onclick="window.location.href='{{ route('tenant.kost.index') }}'"
                    class="p-2 hover:bg-gray-100 rounded-full transition-colors">
                    <svg class="w-4 h-4 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Body -->
            <div class="max-h-[819px] p-6 overflow-y-auto">
                @if (isset($rental) && $rental)
                    <!-- Total Bayar -->
                    <div class="p-4 bg-gray-100 rounded-lg outline outline-1 outline-offset-[-1px] outline-neutral-300">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-zinc-700 text-base font-normal uppercase tracking-wide">TOTAL BAYAR</p>
                                <p class="text-slate-950 text-base font-normal">Rp
                                    {{ number_format($rental->total_price, 0, ',', '.') }}</p>
                            </div>
                            <span class="px-3 py-1 bg-slate-200 rounded-full text-slate-600 text-xs font-semibold">Menunggu
                                Pembayaran</span>
                        </div>

                        <!-- Metode Pembayaran -->
                        <div class="mt-3">
                            <p class="text-zinc-700 text-base font-normal uppercase tracking-wide">METODE PEMBAYARAN</p>
                            <div class="mt-2 p-1 bg-gray-200 rounded-lg flex gap-2">
                                @foreach ($methods ?? [] as $method)
                                    <button onclick="selectMethod('{{ $method['value'] }}')"
                                        id="method-{{ $method['value'] }}"
                                        class="flex-1 px-3 py-2 rounded-md text-sm font-semibold transition-all
                                        {{ $loop->first ? 'bg-white text-cyan-950 shadow-[0px_1px_2px_0px_rgba(0,0,0,0.05)]' : 'text-zinc-700 font-normal hover:bg-gray-50' }}">
                                        {{ $method['label'] }}
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        <!-- Detail Pembayaran berdasarkan metode -->
                        <div id="payment-details" class="mt-4 pt-4 border-t border-neutral-300/30">
                            <!-- Transfer Bank -->
                            <div id="detail-bank_transfer">
                                <p class="text-zinc-700 text-base font-normal uppercase">TRANSFER KE REKENING:</p>
                                @foreach ($bankAccounts ?? [] as $bank)
                                    <div class="mt-2 flex items-center gap-4">
                                        <div
                                            class="w-12 h-12 bg-white rounded-lg outline outline-1 outline-offset-[-1px] outline-neutral-300 flex items-center justify-center overflow-hidden">
                                            <span
                                                class="text-xs font-bold text-center">{{ substr($bank['name'], 0, 3) }}</span>
                                        </div>
                                        <div>
                                            <p class="text-slate-950 text-base font-semibold">{{ $bank['name'] }}</p>
                                            <div class="flex items-center gap-2">
                                                <span
                                                    class="text-zinc-900 text-base font-normal">{{ $bank['account_number'] }}</span>
                                                <button onclick="copyToClipboard('{{ $bank['account_number'] }}')"
                                                    class="flex items-center gap-1 text-cyan-950 text-xs font-semibold hover:underline">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                                                    </svg>
                                                    Salin
                                                </button>
                                            </div>
                                            <p class="text-zinc-700 text-base font-normal">a.n. {{ $bank['holder'] }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- QRIS -->
                            <div id="detail-qris" class="hidden">
                                <p class="text-zinc-700 text-base font-normal uppercase">SCAN QRIS:</p>
                                <div class="mt-2 flex flex-col items-center gap-3">
                                    <div
                                        class="w-48 h-48 p-2 bg-white rounded-lg outline outline-1 outline-offset-[-1px] outline-neutral-300 flex items-center justify-center overflow-hidden">
                                        <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                            <svg class="w-24 h-24 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                                    d="M4 4h6v6H4V4zm10 0h6v6h-6V4zM4 14h6v6H4v-6zm10 0h6v6h-6v-6z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <p class="text-zinc-700 text-base font-normal text-center">Scan QRIS melalui aplikasi
                                        Mobile Banking atau E-Wallet favorit Anda.</p>
                                </div>
                            </div>

                            <!-- E-Wallet -->
                            <div id="detail-ewallet" class="hidden">
                                <p class="text-zinc-700 text-base font-normal uppercase">PILIH E-WALLET:</p>
                                <div class="mt-2 space-y-2">
                                    @foreach ($ewalletOptions ?? [] as $ewallet)
                                        <div onclick="selectEWallet('{{ $ewallet['value'] }}')"
                                            id="ewallet-{{ $ewallet['value'] }}"
                                            class="flex items-center gap-3 px-3 py-3 rounded-lg outline outline-1 outline-offset-[-1px] outline-neutral-300 cursor-pointer hover:bg-gray-50 transition-colors
                                         {{ $loop->first ? 'outline-2 outline-cyan-950 bg-gray-200' : '' }}">
                                            <div
                                                class="w-8 h-8 bg-white rounded-sm flex items-center justify-center overflow-hidden">
                                                <span
                                                    class="text-xs font-bold">{{ substr($ewallet['label'], 0, 3) }}</span>
                                            </div>
                                            <span
                                                class="text-zinc-900 text-base font-semibold">{{ $ewallet['label'] }}</span>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="mt-3">
                                    <label class="text-zinc-700 text-base font-normal uppercase block">NOMOR
                                        E-WALLET</label>
                                    <input type="text" id="ewallet-number" placeholder="08xx xxxx xxxx"
                                        class="mt-1 w-full px-3 py-2.5 bg-white rounded-lg outline outline-1 outline-offset-[-1px] outline-neutral-300 text-base font-normal focus:outline-2 focus:outline-cyan-950 transition-all" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Upload Bukti -->
                    <div class="mt-4">
                        <p class="text-cyan-950 text-base font-semibold">Bukti Transfer</p>
                        <div id="upload-area"
                            class="mt-2 p-8 rounded-lg outline outline-2 outline-offset-[-2px] outline-neutral-300 text-center cursor-pointer hover:outline-cyan-950 transition-all">
                            <input type="file" id="proof-file" accept=".png,.jpg,.jpeg,.pdf" class="hidden" />
                            <div id="upload-content">
                                <svg class="w-12 h-12 text-zinc-500 mx-auto mb-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p class="text-zinc-900 text-base font-medium">Klik atau seret file ke sini</p>
                                <p class="text-zinc-700 text-base font-normal mt-1">PNG, JPG, atau PDF (Max. 5MB)</p>
                                <button onclick="document.getElementById('proof-file').click()"
                                    class="mt-3 px-6 py-2 bg-cyan-950 rounded-lg text-white text-base font-semibold hover:bg-cyan-900 transition-colors">
                                    Pilih File
                                </button>
                            </div>
                            <div id="upload-preview" class="hidden">
                                <div class="flex items-center justify-between bg-gray-50 p-3 rounded-lg">
                                    <div class="flex items-center gap-3">
                                        <svg class="w-8 h-8 text-cyan-950" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <div>
                                            <p id="file-name" class="text-zinc-900 text-sm font-medium">file.pdf</p>
                                            <p id="file-size" class="text-zinc-500 text-xs">2.5 MB</p>
                                        </div>
                                    </div>
                                    <button onclick="removeFile()" class="text-red-500 hover:text-red-700">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Catatan -->
                    <div class="mt-4">
                        <p class="text-cyan-950 text-base font-semibold">Catatan (Opsional)</p>
                        <textarea id="payment-notes" rows="3" placeholder="Contoh: Pembayaran sewa bulan Januari atas nama Budi"
                            class="mt-2 w-full px-3 pt-2 pb-8 bg-white rounded-lg outline outline-1 outline-offset-[-1px] outline-neutral-300 text-base font-normal focus:outline-2 focus:outline-cyan-950 transition-all resize-none"></textarea>
                    </div>
                @else
                    <div class="text-center py-12">
                        <p class="text-zinc-700 text-base">Data pemesanan tidak ditemukan</p>
                        <a href="{{ route('tenant.kost.index') }}"
                            class="mt-4 inline-block px-6 py-2 bg-cyan-950 text-white rounded-lg">
                            Kembali ke Pencarian
                        </a>
                    </div>
                @endif
            </div>

            <!-- Footer -->
            <div class="px-6 py-4 bg-white border-t border-neutral-300 flex justify-end items-center gap-3">
                <button onclick="cancelPayment({{ $rental->id ?? 0 }})"
                    class="px-6 py-2 rounded-lg text-cyan-950 text-base font-semibold hover:bg-gray-50 transition-colors">
                    Batal
                </button>
                <button onclick="submitPayment({{ $rental->id ?? 0 }})" id="submit-payment-btn"
                    class="px-8 py-2 bg-cyan-950 rounded-lg shadow-[0px_1px_2px_0px_rgba(0,0,0,0.05)] text-white text-base font-semibold flex items-center gap-2 hover:bg-cyan-900 transition-colors">
                    <span>Kirim Bukti</span>
                    <svg class="w-4 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            let selectedMethod = 'bank_transfer';
            let selectedEWallet = 'ovo';
            let selectedFile = null;
            let isSubmitting = false;

            // Select payment method
            function selectMethod(method) {
                selectedMethod = method;

                // Update button styles
                document.querySelectorAll('[id^="method-"]').forEach(el => {
                    if (el) {
                        el.className =
                            'flex-1 px-3 py-2 rounded-md text-sm transition-all text-zinc-700 font-normal hover:bg-gray-50';
                    }
                });
                const btn = document.getElementById('method-' + method);
                if (btn) {
                    btn.className =
                        'flex-1 px-3 py-2 bg-white rounded-md text-cyan-950 text-sm font-semibold shadow-[0px_1px_2px_0px_rgba(0,0,0,0.05)]';
                }

                // Show/hide details
                document.querySelectorAll('[id^="detail-"]').forEach(el => {
                    if (el) {
                        el.classList.add('hidden');
                    }
                });
                const detail = document.getElementById('detail-' + method);
                if (detail) {
                    detail.classList.remove('hidden');
                }
            }

            // Select E-Wallet
            function selectEWallet(wallet) {
                selectedEWallet = wallet;
                document.querySelectorAll('[id^="ewallet-"]').forEach(el => {
                    if (el) {
                        el.className =
                            'flex items-center gap-3 px-3 py-3 rounded-lg outline outline-1 outline-offset-[-1px] outline-neutral-300 cursor-pointer hover:bg-gray-50 transition-colors';
                    }
                });
                const el = document.getElementById('ewallet-' + wallet);
                if (el) {
                    el.className =
                        'flex items-center gap-3 px-3 py-3 rounded-lg outline outline-2 outline-offset-[-2px] outline-cyan-950 cursor-pointer hover:bg-gray-50 transition-colors bg-gray-200';
                }
            }

            // File upload
            const fileInput = document.getElementById('proof-file');
            if (fileInput) {
                fileInput.addEventListener('change', function(e) {
                    if (this.files && this.files[0]) {
                        const file = this.files[0];
                        if (file.size > 5 * 1024 * 1024) {
                            alert('Ukuran file maksimal 5MB');
                            this.value = '';
                            return;
                        }
                        selectedFile = file;
                        const fileName = document.getElementById('file-name');
                        const fileSize = document.getElementById('file-size');
                        if (fileName) fileName.textContent = file.name;
                        if (fileSize) fileSize.textContent = (file.size / 1024 / 1024).toFixed(2) + ' MB';

                        const content = document.getElementById('upload-content');
                        const preview = document.getElementById('upload-preview');
                        if (content) content.classList.add('hidden');
                        if (preview) preview.classList.remove('hidden');
                    }
                });
            }

            function removeFile() {
                selectedFile = null;
                const fileInput = document.getElementById('proof-file');
                if (fileInput) fileInput.value = '';

                const content = document.getElementById('upload-content');
                const preview = document.getElementById('upload-preview');
                if (content) content.classList.remove('hidden');
                if (preview) preview.classList.add('hidden');
            }

            // Drag and drop
            const uploadArea = document.getElementById('upload-area');
            if (uploadArea) {
                uploadArea.addEventListener('dragover', function(e) {
                    e.preventDefault();
                    this.classList.add('outline-cyan-950');
                });
                uploadArea.addEventListener('dragleave', function(e) {
                    e.preventDefault();
                    this.classList.remove('outline-cyan-950');
                });
                uploadArea.addEventListener('drop', function(e) {
                    e.preventDefault();
                    this.classList.remove('outline-cyan-950');
                    if (e.dataTransfer.files && e.dataTransfer.files[0]) {
                        const fileInput = document.getElementById('proof-file');
                        if (fileInput) {
                            fileInput.files = e.dataTransfer.files;
                            fileInput.dispatchEvent(new Event('change'));
                        }
                    }
                });
            }

            // Copy to clipboard
            function copyToClipboard(text) {
                if (text) {
                    navigator.clipboard.writeText(text.replace(/\s/g, '')).then(() => {
                        alert('Nomor rekening telah disalin!');
                    }).catch(() => {
                        // Fallback
                        const input = document.createElement('input');
                        input.value = text.replace(/\s/g, '');
                        document.body.appendChild(input);
                        input.select();
                        document.execCommand('copy');
                        document.body.removeChild(input);
                        alert('Nomor rekening telah disalin!');
                    });
                }
            }

            // Submit payment
            function submitPayment(rentalId) {
                if (!rentalId) {
                    alert('Data pemesanan tidak valid');
                    return;
                }

                if (isSubmitting) return;

                if (!selectedFile) {
                    alert('Silakan pilih file bukti pembayaran terlebih dahulu');
                    return;
                }

                const formData = new FormData();
                formData.append('rental_id', rentalId);
                formData.append('method', selectedMethod);
                formData.append('proof', selectedFile);

                const notes = document.getElementById('payment-notes');
                if (notes) formData.append('notes', notes.value);

                if (selectedMethod === 'ewallet') {
                    const walletNumber = document.getElementById('ewallet-number');
                    if (walletNumber && !walletNumber.value) {
                        alert('Silakan masukkan nomor E-Wallet');
                        return;
                    }
                    if (walletNumber) {
                        formData.append('ewallet_type', selectedEWallet);
                        formData.append('account_number', walletNumber.value);
                    }
                }

                isSubmitting = true;
                const btn = document.getElementById('submit-payment-btn');
                if (btn) {
                    btn.disabled = true;
                    btn.innerHTML = '<span class="inline-block animate-spin mr-2">⏳</span> Mengirim...';
                }

                fetch('{{ route('tenant.payment.upload') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            window.location.href = data.redirect_url || '{{ route('tenant.riwayat.index') }}';
                        } else {
                            alert(data.message || 'Terjadi kesalahan');
                            isSubmitting = false;
                            if (btn) {
                                btn.disabled = false;
                                btn.innerHTML =
                                    '<span>Kirim Bukti</span><svg class="w-4 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>';
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan: ' + error.message);
                        isSubmitting = false;
                        if (btn) {
                            btn.disabled = false;
                            btn.innerHTML =
                                '<span>Kirim Bukti</span><svg class="w-4 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>';
                        }
                    });
            }

            // Cancel payment
            function cancelPayment(rentalId) {
                if (!rentalId || rentalId === 0) {
                    alert('Data pemesanan tidak valid');
                    return;
                }

                if (!confirm('Apakah Anda yakin ingin membatalkan pemesanan ini?')) return;

                // Gunakan method DELETE
                fetch('/tenant/payment/cancel/' + rentalId, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            window.location.href = data.redirect_url || '/tenant/kost';
                        } else {
                            alert(data.message || 'Terjadi kesalahan');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan: ' + error.message);
                    });
            }
        </script>
    @endpush
@endsection
