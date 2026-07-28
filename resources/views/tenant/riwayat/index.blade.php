@extends('layouts.tenant')

@section('search-placeholder', 'Riwayat Penyewaan')

@section('content')

    @include('tenant.riwayat.partials.header')

    @include('tenant.riwayat.partials.summary')

    @include('tenant.riwayat.partials.table')

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mt-8">
        <div class="lg:col-span-3">
            @include('tenant.riwayat.partials.helpdesk')
        </div>
        <div>
            @include('tenant.riwayat.partials.security')
        </div>
    </div>

    {{-- Container untuk Invoice Modal --}}
    <div id="invoiceModalContainer"></div>

@endsection

@push('scripts')
    <script>
        // Fungsi untuk menampilkan invoice modal dari riwayat
        function showInvoiceModal(rentalId) {
            // Tampilkan loading
            const container = document.getElementById('invoiceModalContainer');
            container.innerHTML = `
            <div id="invoiceModalOverlay" class="fixed inset-0 z-[60] bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
                <div class="bg-white rounded-lg p-8 max-w-md w-full">
                    <div class="flex items-center justify-center">
                        <div class="w-12 h-12 border-4 border-cyan-950 border-t-transparent rounded-full animate-spin"></div>
                    </div>
                    <p class="text-center mt-4 text-gray-600">Memuat invoice...</p>
                </div>
            </div>
        `;

            // Fetch data invoice
            fetch(`/tenant/invoice/${rentalId}/json`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success && data.invoice_html) {
                        container.innerHTML = data.invoice_html;

                        // Tampilkan modal
                        const invoiceOverlay = document.getElementById('invoiceModalOverlay');
                        if (invoiceOverlay) {
                            invoiceOverlay.classList.remove('hidden');
                            document.body.style.overflow = 'hidden';
                        }

                        // Event listener untuk tutup invoice
                        const closeInvoiceBtn = document.getElementById('closeInvoiceModalBtn');
                        const closeInvoiceBtn2 = document.getElementById('closeInvoiceModal');

                        function closeInvoice() {
                            if (invoiceOverlay) {
                                invoiceOverlay.classList.add('hidden');
                                document.body.style.overflow = '';
                            }
                            // Bersihkan container setelah animasi selesai
                            setTimeout(() => {
                                container.innerHTML = '';
                            }, 300);
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

                        // Handle tombol Cetak
                        const printBtn = document.querySelector('#invoiceModal button[onclick="window.print()"]');
                        if (printBtn) {
                            printBtn.addEventListener('click', function() {
                                window.print();
                            });
                        }
                    } else {
                        alert('Gagal memuat invoice: ' + (data.message || 'Unknown error'));
                        container.innerHTML = '';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat memuat invoice');
                    container.innerHTML = '';
                });
        }
    </script>
@endpush
