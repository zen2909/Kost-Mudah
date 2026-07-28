@extends('layouts.tenant')

@section('search-placeholder', 'Cari kost...')

@section('content')

    <div class="max-w-3xl mx-auto py-8">

        @include('tenant.booking.partials.header')

        @include('tenant.booking.partials.kost-info')

        @include('tenant.booking.partials.duration')

        @include('tenant.booking.partials.start-date')

        @include('tenant.booking.partials.summary')

        {{-- Hidden inputs untuk menyimpan data booking --}}
        <input type="hidden" name="booking_boarding_house_id" id="booking_boarding_house_id" value="{{ $kost->id }}">
        <input type="hidden" name="booking_duration_months" id="booking_duration_months" value="1">
        <input type="hidden" name="booking_start_date" id="booking_start_date" value="{{ date('Y-m-d') }}">
        <input type="hidden" name="booking_total_price" id="booking_total_price" value="{{ $kost->price_per_month }}">

        {{-- Tombol Lanjutkan ke Pembayaran --}}
        <div class="mt-6">
            <button id="proceedToPayment" type="button"
                class="w-full bg-cyan-950 hover:bg-cyan-900 text-white py-4 rounded-xl font-semibold transition flex items-center justify-center gap-2">
                Lanjutkan ke Pembayaran
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </button>
        </div>

    </div>

    {{-- Modal Payment --}}
    @include('tenant.booking.partials.payment-modal')

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            console.log('DOM loaded - booking page');

            // ===========================
            // Harga & Durasi
            // ===========================

            const priceElement = document.getElementById('price');
            if (!priceElement) {
                console.log('Price element not found');
                return;
            }

            const price = Number(priceElement.dataset.price);
            const durationText = document.getElementById('durationText');
            const totalPriceDisplay = document.getElementById('totalPrice');
            const durationInput = document.getElementById('booking_duration_months');
            const totalInput = document.getElementById('booking_total_price');
            const startDateInputBooking = document.getElementById('booking_start_date');
            const boardingHouseIdInput = document.getElementById('booking_boarding_house_id');

            console.log('Price:', price);
            console.log('Boarding House ID:', boardingHouseIdInput ? boardingHouseIdInput.value : 'Not found');

            // Pilihan durasi
            document.querySelectorAll('.duration-btn').forEach(function(button) {
                button.addEventListener('click', function() {
                    document.querySelectorAll('.duration-btn').forEach(function(btn) {
                        btn.classList.remove('border-cyan-950', 'bg-cyan-50');
                        btn.classList.add('border');
                    });

                    this.classList.remove('border');
                    this.classList.add('border-cyan-950', 'bg-cyan-50');

                    const month = parseInt(this.dataset.month);
                    if (durationText) durationText.innerText = month + ' Bulan';

                    let total = price * month;
                    if (month === 3) total *= 0.98;
                    else if (month === 6) total *= 0.95;
                    else if (month === 12) total *= 0.90;

                    const totalRounded = Math.round(total);

                    if (totalPriceDisplay) {
                        totalPriceDisplay.innerText = 'Rp' + totalRounded.toLocaleString('id-ID');
                    }
                    if (durationInput) durationInput.value = month;
                    if (totalInput) totalInput.value = totalRounded;

                    console.log('Duration selected:', month, 'Total:', totalRounded);
                });
            });

            // ===========================
            // Tanggal Mulai Sewa
            // ===========================

            const startDate = document.getElementById('start_date');
            const startDateText = document.getElementById('startDateText');
            const calendarButton = document.getElementById('calendarButton');

            if (calendarButton && startDate) {
                calendarButton.addEventListener('click', function() {
                    if (startDate.showPicker) {
                        startDate.showPicker();
                    } else {
                        startDate.focus();
                        startDate.click();
                    }
                });
            }

            if (startDate && startDateText) {
                function formatTanggal(tanggal) {
                    if (!tanggal) return '';
                    return new Date(tanggal).toLocaleDateString('id-ID', {
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric'
                    });
                }

                // Set default date
                const today = new Date();
                const year = today.getFullYear();
                const month = String(today.getMonth() + 1).padStart(2, '0');
                const day = String(today.getDate()).padStart(2, '0');
                const defaultDate = year + '-' + month + '-' + day;

                if (!startDate.value) {
                    startDate.value = defaultDate;
                    if (startDateInputBooking) {
                        startDateInputBooking.value = defaultDate;
                    }
                }

                startDateText.innerText = formatTanggal(startDate.value);

                startDate.addEventListener('change', function() {
                    startDateText.innerText = formatTanggal(this.value);
                    if (startDateInputBooking) {
                        startDateInputBooking.value = this.value;
                    }
                    console.log('Start date changed:', this.value);
                });
            }

            // ===========================
            // MODAL PAYMENT - Toggle
            // ===========================

            const modalOverlay = document.getElementById('modalOverlay');
            const closeModalBtn = document.getElementById('closeModal');
            const cancelPaymentBtn = document.getElementById('cancelPayment');
            const proceedBtn = document.getElementById('proceedToPayment');

            console.log('Modal elements:', {
                modalOverlay: !!modalOverlay,
                closeModalBtn: !!closeModalBtn,
                cancelPaymentBtn: !!cancelPaymentBtn,
                proceedBtn: !!proceedBtn
            });

            function updatePaymentModal() {
                console.log('Updating payment modal...');

                // Ambil data dari hidden inputs di halaman booking
                const boardingHouseId = boardingHouseIdInput ? boardingHouseIdInput.value : '';
                const month = durationInput ? parseInt(durationInput.value) || 1 : 1;
                const total = totalInput ? parseInt(totalInput.value) || (price * month) : (price * month);
                const startDateVal = startDateInputBooking ? startDateInputBooking.value : (startDate ? startDate
                    .value : '');

                console.log('Data untuk modal:', {
                    boardingHouseId,
                    month,
                    total,
                    startDateVal
                });

                // Update hidden inputs di modal
                const modalBoardingHouseId = document.getElementById('modal_boarding_house_id');
                const modalDurationMonths = document.getElementById('modal_duration_months');
                const modalStartDateInput = document.getElementById('modal_start_date');
                const modalTotalPriceInput = document.getElementById('modal_total_price');

                if (modalBoardingHouseId) {
                    modalBoardingHouseId.value = boardingHouseId;
                    console.log('Set modal_boarding_house_id:', boardingHouseId);
                }
                if (modalDurationMonths) {
                    modalDurationMonths.value = month;
                    console.log('Set modal_duration_months:', month);
                }
                if (modalStartDateInput) {
                    modalStartDateInput.value = startDateVal;
                    console.log('Set modal_start_date:', startDateVal);
                }
                if (modalTotalPriceInput) {
                    modalTotalPriceInput.value = total;
                    console.log('Set modal_total_price:', total);
                }

                // Update tampilan di modal
                const modalTotalPriceDisplay = document.getElementById('modalTotalPrice');
                const modalDurationDisplay = document.getElementById('modalDuration');
                const modalStartDateDisplay = document.getElementById('modalStartDate');

                if (modalTotalPriceDisplay) {
                    modalTotalPriceDisplay.textContent = 'Rp' + total.toLocaleString('id-ID');
                }

                if (modalDurationDisplay) {
                    modalDurationDisplay.textContent = month + ' Bulan';
                }

                if (modalStartDateDisplay) {
                    var dateFormatted = startDateVal ? new Date(startDateVal).toLocaleDateString('id-ID', {
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric'
                    }) : '-';
                    modalStartDateDisplay.textContent = dateFormatted;
                }

                console.log('Modal updated successfully');
            }

            function showPaymentModal() {
                console.log('Showing payment modal...');
                updatePaymentModal();
                if (modalOverlay) {
                    modalOverlay.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                    console.log('Modal shown');
                } else {
                    console.error('Modal overlay not found!');
                }
            }

            function hidePaymentModal() {
                console.log('Hiding payment modal...');
                if (modalOverlay) {
                    modalOverlay.classList.add('hidden');
                    document.body.style.overflow = '';
                    console.log('Modal hidden');
                }
            }

            if (proceedBtn) {
                proceedBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    console.log('Proceed button clicked');

                    var selectedDuration = document.querySelector('.duration-btn.border-cyan-950');
                    if (!selectedDuration) {
                        alert('Silakan pilih durasi sewa terlebih dahulu.');
                        return;
                    }

                    if (startDate && !startDate.value) {
                        alert('Silakan pilih tanggal mulai sewa.');
                        return;
                    }

                    showPaymentModal();
                });
                console.log('Proceed button listener attached');
            } else {
                console.error('Proceed button not found!');
            }

            if (closeModalBtn) {
                closeModalBtn.addEventListener('click', hidePaymentModal);
                console.log('Close button listener attached');
            }

            if (cancelPaymentBtn) {
                cancelPaymentBtn.addEventListener('click', hidePaymentModal);
                console.log('Cancel button listener attached');
            }

            if (modalOverlay) {
                modalOverlay.addEventListener('click', function(e) {
                    if (e.target === this) {
                        hidePaymentModal();
                    }
                });
                console.log('Overlay click listener attached');
            }

            // ===========================
            // Payment Method Selection
            // ===========================

            const methodButtons = document.querySelectorAll('.method-btn');
            const bankContent = document.getElementById('bankContent');
            const qrisContent = document.getElementById('qrisContent');
            const ewalletContent = document.getElementById('ewalletContent');

            methodButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    methodButtons.forEach(function(btn) {
                        btn.classList.remove('bg-white', 'shadow-sm', 'text-cyan-950',
                            'font-semibold');
                        btn.classList.add('text-zinc-700', 'font-normal');
                    });

                    this.classList.remove('text-zinc-700', 'font-normal');
                    this.classList.add('bg-white', 'shadow-sm', 'text-cyan-950', 'font-semibold');

                    if (bankContent) bankContent.classList.add('hidden');
                    if (qrisContent) qrisContent.classList.add('hidden');
                    if (ewalletContent) ewalletContent.classList.add('hidden');

                    var method = this.dataset.method;
                    if (method === 'bank_transfer' && bankContent) {
                        bankContent.classList.remove('hidden');
                    } else if (method === 'qris' && qrisContent) {
                        qrisContent.classList.remove('hidden');
                    } else if (method === 'ewallet' && ewalletContent) {
                        ewalletContent.classList.remove('hidden');
                    }

                    console.log('Method selected:', method);
                });
            });

            // ===========================
            // E-Wallet Selection
            // ===========================

            const ewalletOptions = document.querySelectorAll('.ewallet-option');
            ewalletOptions.forEach(function(option) {
                option.addEventListener('click', function() {
                    if (this.disabled) {
                        alert('E-Wallet ini belum diatur oleh pemilik kost.');
                        return;
                    }

                    ewalletOptions.forEach(function(opt) {
                        opt.classList.remove('outline-2', 'outline-cyan-950');
                        opt.classList.add('outline-1', 'outline-neutral-300');
                    });

                    this.classList.remove('outline-1', 'outline-neutral-300');
                    this.classList.add('outline-2', 'outline-cyan-950');

                    console.log('E-wallet selected:', this.dataset.provider);
                });
            });

            // ===========================
            // File Upload Preview
            // ===========================

            const fileInput = document.getElementById('proofInput');
            const fileDropzone = document.getElementById('fileDropzone');
            const filePreview = document.getElementById('filePreview');
            const fileNameDisplay = document.getElementById('fileNameDisplay');

            if (fileInput) {
                fileInput.addEventListener('change', function() {
                    var file = this.files[0];
                    if (file) {
                        if (fileNameDisplay) fileNameDisplay.textContent = file.name;
                        if (fileDropzone) {
                            fileDropzone.classList.add('border-cyan-950', 'bg-cyan-50');
                        }
                        if (filePreview) filePreview.classList.remove('hidden');
                        console.log('File selected:', file.name);
                    }
                });
            }

            // ===========================
            // COPY BUTTON
            // ===========================

            const copyButtons = document.querySelectorAll('.copy-btn');
            copyButtons.forEach(function(btn) {
                btn.addEventListener('click', function() {
                    var accountNumber = this.dataset.account;
                    if (!accountNumber) return;

                    navigator.clipboard.writeText(accountNumber).then(function() {
                        var originalText = this.textContent;
                        this.textContent = '✓ Disalin';
                        setTimeout(function() {
                            this.textContent = originalText;
                        }.bind(this), 2000);
                    }.bind(this)).catch(function(err) {
                        console.error('Failed to copy:', err);
                        alert('Gagal menyalin nomor. Silakan salin secara manual.');
                    });
                });
            });

            // ===========================
            // SUBMIT PAYMENT - FIXED VERSION
            // ===========================

            const paymentForm = document.getElementById('paymentForm');
            const submitBtn = document.getElementById('submitPayment');

            if (paymentForm && submitBtn) {
                submitBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    console.log('Submit button clicked');

                    // 1. Validasi file
                    const fileInput = document.getElementById('proofInput');
                    const file = fileInput ? fileInput.files[0] : null;
                    if (!file) {
                        alert('Silakan upload bukti pembayaran.');
                        return;
                    }
                    console.log('File valid:', file.name, file.size, 'bytes');

                    // 2. Validasi metode pembayaran
                    const activeMethod = document.querySelector('.method-btn.bg-white');
                    if (!activeMethod) {
                        alert('Silakan pilih metode pembayaran.');
                        return;
                    }

                    const method = activeMethod.dataset.method;
                    console.log('Method selected:', method);

                    // 3. Ambil data dari modal
                    const boardingHouseId = document.getElementById('modal_boarding_house_id')?.value || '';
                    const durationMonths = document.getElementById('modal_duration_months')?.value || '';
                    const startDate = document.getElementById('modal_start_date')?.value || '';
                    const totalPrice = document.getElementById('modal_total_price')?.value || '';

                    console.log('Data dari modal:', {
                        boardingHouseId,
                        durationMonths,
                        startDate,
                        totalPrice
                    });

                    // 4. Validasi data
                    if (!boardingHouseId || !durationMonths || !startDate || !totalPrice) {
                        alert('Data booking tidak lengkap. Silakan kembali ke halaman booking.');
                        console.error('Missing data:', {
                            boardingHouseId,
                            durationMonths,
                            startDate,
                            totalPrice
                        });
                        return;
                    }

                    // 5. Buat FormData
                    const formData = new FormData();

                    // Tambahkan semua data
                    formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
                    formData.append('boarding_house_id', boardingHouseId);
                    formData.append('duration_months', durationMonths);
                    formData.append('start_date', startDate);
                    formData.append('total_price', totalPrice);
                    formData.append('method', method);
                    formData.append('modal_proof', file);

                    // Tambahkan notes jika ada
                    const notes = document.getElementById('modalNotes')?.value || '';
                    if (notes) {
                        formData.append('modal_notes', notes);
                    }

                    // Tambahkan ewallet_provider jika metode ewallet
                    if (method === 'ewallet') {
                        const selectedEwallet = document.querySelector('.ewallet-option.outline-2');
                        if (selectedEwallet) {
                            formData.append('ewallet_provider', selectedEwallet.dataset.provider);
                        } else {
                            alert('Silakan pilih provider E-Wallet.');
                            return;
                        }
                    }

                    // 6. Tampilkan loading
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = 'Mengirim...';

                    // 7. Submit menggunakan fetch
                    fetch(paymentForm.action, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(async response => {
                            console.log('Response status:', response.status);

                            let data;
                            try {
                                const text = await response.text();
                                console.log('Raw response:', text);
                                data = JSON.parse(text);
                            } catch (e) {
                                data = {
                                    error: 'Invalid JSON response'
                                };
                            }

                            // Reset button
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = 'Kirim Bukti';

                            if (response.ok && data.success) {
                                console.log('Success:', data);

                                // Tutup modal payment
                                const modalOverlay = document.getElementById('modalOverlay');
                                if (modalOverlay) {
                                    modalOverlay.classList.add('hidden');
                                    document.body.style.overflow = '';
                                }

                                // Tampilkan invoice modal
                                if (data.invoice_html) {
                                    // Cari atau buat container untuk invoice
                                    let invoiceContainer = document.getElementById(
                                        'invoiceModalContainer');
                                    if (!invoiceContainer) {
                                        invoiceContainer = document.createElement('div');
                                        invoiceContainer.id = 'invoiceModalContainer';
                                        document.body.appendChild(invoiceContainer);
                                    }
                                    invoiceContainer.innerHTML = data.invoice_html;

                                    // Tampilkan modal invoice
                                    const invoiceOverlay = document.getElementById(
                                        'invoiceModalOverlay');
                                    if (invoiceOverlay) {
                                        invoiceOverlay.classList.remove('hidden');
                                        document.body.style.overflow = 'hidden';
                                    }

                                    // Event listener untuk tutup invoice
                                    const closeInvoiceBtn = document.getElementById(
                                        'closeInvoiceModalBtn');
                                    const closeInvoiceBtn2 = document.getElementById(
                                        'closeInvoiceModal');

                                    function closeInvoice() {
                                        if (invoiceOverlay) {
                                            invoiceOverlay.classList.add('hidden');
                                            document.body.style.overflow = '';
                                        }
                                        // Redirect ke invoice page atau riwayat
                                        if (data.redirect) {
                                            window.location.href = data.redirect;
                                        } else {
                                            window.location.href =
                                                '{{ route('tenant.riwayat.index') }}';
                                        }
                                    }

                                    if (closeInvoiceBtn) {
                                        closeInvoiceBtn.addEventListener('click', closeInvoice);
                                    }
                                    if (closeInvoiceBtn2) {
                                        closeInvoiceBtn2.addEventListener('click', closeInvoice);
                                    }

                                    // Tutup saat klik overlay
                                    if (invoiceOverlay) {
                                        invoiceOverlay.addEventListener('click', function(e) {
                                            if (e.target === this) {
                                                closeInvoice();
                                            }
                                        });
                                    }
                                } else {
                                    // Fallback: redirect ke invoice page
                                    if (data.redirect) {
                                        window.location.href = data.redirect;
                                    } else {
                                        alert(data.message || 'Pembayaran berhasil dikirim!');
                                        window.location.href =
                                        '{{ route('tenant.riwayat.index') }}';
                                    }
                                }
                            } else {
                                // Error handling
                                console.error('Error response:', data);

                                if (response.status === 422 && data.errors) {
                                    let errorMsg = 'Validasi gagal:\n';
                                    for (let key in data.errors) {
                                        errorMsg += '- ' + data.errors[key].join('\n') + '\n';
                                    }
                                    alert(errorMsg);
                                } else {
                                    alert(data.message || 'Terjadi kesalahan: ' + response.status);
                                }
                            }
                        })
                        .catch(error => {
                            console.error('Fetch error:', error);
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = 'Kirim Bukti';
                            alert('Terjadi kesalahan koneksi. Silakan coba lagi.\nError: ' + error
                                .message);
                        });
                });
            }

            // ===========================
            // Drag and Drop File
            // ===========================

            if (fileDropzone) {
                fileDropzone.addEventListener('dragover', function(e) {
                    e.preventDefault();
                    this.classList.add('border-cyan-950', 'bg-cyan-50');
                });

                fileDropzone.addEventListener('dragleave', function(e) {
                    e.preventDefault();
                    this.classList.remove('border-cyan-950', 'bg-cyan-50');
                });

                fileDropzone.addEventListener('drop', function(e) {
                    e.preventDefault();
                    this.classList.remove('border-cyan-950', 'bg-cyan-50');

                    var files = e.dataTransfer.files;
                    if (files.length > 0 && fileInput) {
                        fileInput.files = files;
                        var event = new Event('change');
                        fileInput.dispatchEvent(event);
                    }
                });
            }

            // Set default method (Bank Transfer)
            setTimeout(function() {
                if (methodButtons.length > 0) {
                    methodButtons[0].click();
                }
            }, 100);

            console.log('Booking page initialized successfully');

        });
    </script>
@endpush
