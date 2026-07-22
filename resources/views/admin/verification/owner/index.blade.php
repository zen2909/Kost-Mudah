@extends('layouts.admin')

@section('title', 'Verifikasi Pemilik - KostMudah')

@section('content')
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
            <div>
                <h1 class="text-[#001220] text-2xl md:text-3xl font-bold">Verifikasi Pemilik</h1>
                <p class="text-[#42474C] text-sm mt-1">Verifikasi data diri pemilik (KTP) untuk meningkatkan kepercayaan.</p>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
            <!-- Total Menunggu -->
            <div class="bg-white p-6 rounded-xl border border-[#C3C7CD] shadow-sm hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start">
                    <p class="text-[#42474C] text-xs font-semibold tracking-wider uppercase">TOTAL MENUNGGU</p>
                    <div class="w-8 h-8 bg-[#FFDAD6] rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-[#BA1A1A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <p class="text-[#191C1D] text-3xl font-bold">{{ $totalPending }}</p>
                    <p class="text-[#42474C] text-sm mt-1">Pemilik menunggu verifikasi</p>
                </div>
            </div>

            <!-- Baru Hari Ini -->
            <div class="bg-white p-6 rounded-xl border border-[#C3C7CD] shadow-sm hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start">
                    <p class="text-[#42474C] text-xs font-semibold tracking-wider uppercase">BARU HARI INI</p>
                    <div class="w-8 h-8 bg-[#CCE5FF] rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-[#004B72]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <p class="text-[#191C1D] text-3xl font-bold">{{ $newToday }}</p>
                    <p class="text-[#42474C] text-sm mt-1">Diajukan dalam 24 jam terakhir</p>
                </div>
            </div>

            <!-- Status Keamanan Sistem -->
            <div class="bg-[#06283D] p-6 rounded-xl border border-[#C3C7CD] shadow-sm relative overflow-hidden">
                <div class="absolute -right-4 -top-4 opacity-10">
                    <svg class="w-28 h-28 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z" />
                    </svg>
                </div>
                <div class="relative z-10">
                    <h3 class="text-white text-xl font-semibold">Status Keamanan Sistem</h3>
                    <p class="text-[#7390A9] text-sm mt-2 max-w-sm">
                        Seluruh dokumen identitas dienkripsi dan disimpan sesuai standar perlindungan data terbaru.
                    </p>
                    <button
                        class="mt-4 px-4 py-2 bg-[#0194DC] text-white text-sm font-semibold rounded-lg hover:bg-[#0179b8] transition-colors">
                        Lihat Log Audit
                    </button>
                </div>
            </div>
        </div>

        <!-- Daftar Pengajuan -->
        <div class="bg-white rounded-xl border border-[#C3C7CD] shadow-sm overflow-hidden">
            <!-- Header -->
            <div
                class="px-6 py-5 bg-[#F8FAFB] border-b border-[#C3C7CD] flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <h3 class="text-[#001220] text-xl font-semibold">Daftar Pengajuan KTP</h3>
                <div class="flex flex-wrap items-center gap-3">
                    <!-- Search -->
                    <div class="relative">
                        <svg class="w-3.5 h-3.5 absolute left-3 top-1/2 -translate-y-1/2 text-[#42474C]" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input id="searchInput"
                            class="pl-8 pr-4 py-2 border border-[#C3C7CD] rounded-lg bg-[#F8FAFB] text-sm focus:outline-none focus:ring-2 focus:ring-[#06283D] w-full sm:w-64"
                            placeholder="Cari nama pemilik..." type="text">
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full min-w-[800px]">
                    <thead class="bg-[#F2F4F5] border-b border-[#C3C7CD]">
                        <tr>
                            <th class="text-left text-[#42474C] text-xs font-semibold tracking-wider py-4 px-6 w-[246px]">
                                NAMA PEMILIK</th>
                            <th class="text-left text-[#42474C] text-xs font-semibold tracking-wider py-4 px-6 w-[166px]">
                                TANGGAL DAFTAR</th>
                            <th class="text-left text-[#42474C] text-xs font-semibold tracking-wider py-4 px-6 w-[229px]">
                                DOKUMEN</th>
                            <th class="text-left text-[#42474C] text-xs font-semibold tracking-wider py-4 px-6 w-[163px]">
                                STATUS</th>
                            <th class="text-right text-[#42474C] text-xs font-semibold tracking-wider py-4 px-6 w-[146px]">
                                AKSI</th>
                        </tr>
                    </thead>
                    <tbody id="documentTableBody">
                        @forelse($pendingDocuments as $document)
                            <tr class="border-b border-[#C3C7CD] hover:bg-gray-50/30 transition-colors"
                                data-document-id="{{ $document->id }}">
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 bg-[#06283D]/10 rounded-full flex items-center justify-center text-[#001220] font-bold text-sm">
                                            {{ $document->user ? strtoupper(substr($document->user->name, 0, 2)) : 'N/A' }}
                                        </div>
                                        <div>
                                            <p class="text-[#191C1D] text-base font-semibold">
                                                {{ $document->user ? $document->user->name : 'Tidak diketahui' }}</p>
                                            <p class="text-[#42474C] text-xs">
                                                {{ $document->user ? $document->user->email : '-' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    <p class="text-[#191C1D] text-sm">
                                        {{ $document->created_at ? $document->created_at->format('d M Y') : '-' }}</p>
                                    <p class="text-[#42474C] text-xs">
                                        {{ $document->created_at ? $document->created_at->format('H:i A') : '-' }}</p>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex flex-wrap gap-2">
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#F8FAFB] border border-[#C3C7CD] rounded-lg text-xs font-medium">
                                            <svg class="w-3.5 h-3.5 text-[#42474C]" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                            </svg>
                                            KTP
                                        </span>
                                        @if ($document->document_number)
                                            <span
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#F8FAFB] border border-[#C3C7CD] rounded-lg text-xs font-medium">
                                                <svg class="w-3 h-3.5 text-[#42474C]" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                                </svg>
                                                {{ $document->document_number }}
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    <span
                                        class="inline-flex items-center gap-1.5 px-3 py-1 bg-[#FFDAD6] rounded-full text-[#BA1A1A] text-xs font-semibold">
                                        <span class="w-1.5 h-1.5 bg-[#BA1A1A] rounded-full"></span>
                                        {{ ucfirst($document->status) }}
                                    </span>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex justify-end gap-2">
                                        <button onclick="viewDocument('{{ $document->id }}')"
                                            class="px-4 py-2 bg-[#06283D] text-white text-sm font-semibold rounded-lg hover:bg-[#001220] transition-colors shadow-sm">
                                            Review
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-8 text-[#42474C]">
                                    <svg class="w-16 h-16 mx-auto text-[#C3C7CD] mb-4" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p class="text-lg font-semibold">Tidak ada pengajuan</p>
                                    <p class="text-sm">Semua KTP telah diverifikasi</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div
                class="px-6 py-4 bg-[#F8FAFB] border-t border-[#C3C7CD] flex flex-col sm:flex-row justify-between items-center gap-4">
                <span class="text-[#42474C] text-sm">Menampilkan
                    {{ $pendingDocuments->firstItem() ?? 0 }}-{{ $pendingDocuments->lastItem() ?? 0 }} dari
                    {{ $pendingDocuments->total() }} entri</span>
                <div class="flex gap-2">
                    {{ $pendingDocuments->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail Dokumen -->
    <div id="documentModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                <div class="bg-white px-6 pt-6 pb-4">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-xl font-bold text-[#001220]" id="modalTitle">Detail KTP</h3>
                        <button onclick="closeModal()" class="text-[#42474C] hover:text-[#191C1D]">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div id="modalContent">
                        <div class="flex justify-center py-8">
                            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-[#06283D]"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Search functionality
        document.getElementById('searchInput')?.addEventListener('keyup', function(e) {
            const query = this.value;
            if (query.length >= 2 || query.length === 0) {
                searchDocuments(query);
            }
        });

        function searchDocuments(query) {
            const url = '/admin/verification/owner/search?q=' + encodeURIComponent(query);

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    const tbody = document.getElementById('documentTableBody');
                    tbody.innerHTML = '';

                    if (data.data.length === 0) {
                        tbody.innerHTML = `
                        <tr>
                            <td colspan="5" class="text-center py-8 text-[#42474C]">
                                <svg class="w-16 h-16 mx-auto text-[#C3C7CD] mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <p class="text-lg font-semibold">Tidak ditemukan</p>
                                <p class="text-sm">Coba dengan kata kunci lain</p>
                            </td>
                        </tr>
                    `;
                        return;
                    }

                    data.data.forEach(document => {
                        const row = `
                        <tr class="border-b border-[#C3C7CD] hover:bg-gray-50/30 transition-colors" data-document-id="${document.id}">
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-[#06283D]/10 rounded-full flex items-center justify-center text-[#001220] font-bold text-sm">
                                        ${document.user ? document.user.name.substring(0, 2).toUpperCase() : 'N/A'}
                                    </div>
                                    <div>
                                        <p class="text-[#191C1D] text-base font-semibold">${document.user ? document.user.name : 'Tidak diketahui'}</p>
                                        <p class="text-[#42474C] text-xs">${document.user ? document.user.email : '-'}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <p class="text-[#191C1D] text-sm">${document.created_at ? new Date(document.created_at).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' }) : '-'}</p>
                                <p class="text-[#42474C] text-xs">${document.created_at ? new Date(document.created_at).toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }) : '-'}</p>
                            </td>
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#F8FAFB] border border-[#C3C7CD] rounded-lg text-xs font-medium">
                                    <svg class="w-3.5 h-3.5 text-[#42474C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                    </svg>
                                    KTP
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-[#FFDAD6] rounded-full text-[#BA1A1A] text-xs font-semibold">
                                    <span class="w-1.5 h-1.5 bg-[#BA1A1A] rounded-full"></span>
                                    ${document.status.charAt(0).toUpperCase() + document.status.slice(1)}
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex justify-end gap-2">
                                    <button onclick="viewDocument('${document.id}')" class="px-4 py-2 bg-[#06283D] text-white text-sm font-semibold rounded-lg hover:bg-[#001220] transition-colors shadow-sm">
                                        Review
                                    </button>
                                </div>
                            </td>
                        </tr>
                    `;
                        tbody.innerHTML += row;
                    });
                })
                .catch(error => console.error('Error:', error));
        }

        // View document detail
        function viewDocument(documentId) {
            const modal = document.getElementById('documentModal');
            const content = document.getElementById('modalContent');

            modal.classList.remove('hidden');
            content.innerHTML = `
            <div class="flex justify-center py-8">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-[#06283D]"></div>
            </div>
        `;

            const url = '/admin/verification/owner/documents/' + documentId;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    content.innerHTML = `
                    <div class="space-y-6">
                        <!-- Informasi Pemilik -->
                        <div class="border-b border-[#C3C7CD] pb-4">
                            <h4 class="text-sm font-semibold text-[#42474C] uppercase tracking-wide mb-3">Informasi Pemilik</h4>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-xs text-[#42474C]">Nama</p>
                                    <p class="text-sm font-semibold text-[#191C1D]">${data.user ? data.user.name : '-'}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-[#42474C]">Email</p>
                                    <p class="text-sm font-semibold text-[#191C1D]">${data.user ? data.user.email : '-'}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-[#42474C]">Telepon</p>
                                    <p class="text-sm font-semibold text-[#191C1D]">${data.user ? data.user.phone || '-' : '-'}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-[#42474C]">Tanggal Daftar</p>
                                    <p class="text-sm font-semibold text-[#191C1D]">${data.created_at ? new Date(data.created_at).toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' }) : '-'}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Informasi KTP -->
                        <div class="border-b border-[#C3C7CD] pb-4">
                            <h4 class="text-sm font-semibold text-[#42474C] uppercase tracking-wide mb-3">Informasi KTP</h4>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-xs text-[#42474C]">Tipe Dokumen</p>
                                    <p class="text-sm font-semibold text-[#191C1D]">Kartu Tanda Penduduk (KTP)</p>
                                </div>
                                <div>
                                    <p class="text-xs text-[#42474C]">Nomor KTP</p>
                                    <p class="text-sm font-semibold text-[#191C1D]">${data.document_number || '-'}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-[#42474C]">Status</p>
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-[#FFDAD6] rounded-full text-[#BA1A1A] text-xs font-semibold">
                                        <span class="w-1.5 h-1.5 bg-[#BA1A1A] rounded-full"></span>
                                        ${data.status.charAt(0).toUpperCase() + data.status.slice(1)}
                                    </span>
                                </div>
                            </div>
                            ${data.notes ? `
                                    <div class="mt-3">
                                        <p class="text-xs text-[#42474C]">Catatan</p>
                                        <p class="text-sm text-[#191C1D]">${data.notes}</p>
                                    </div>
                                ` : ''}
                        </div>

                        <!-- Preview KTP -->
                        ${data.file_path ? `
                                <div>
                                    <h4 class="text-sm font-semibold text-[#42474C] uppercase tracking-wide mb-3">Preview KTP</h4>
                                    <div class="border border-[#C3C7CD] rounded-lg p-4 bg-[#F8FAFB]">
                                        <div class="flex items-center gap-3">
                                            <svg class="w-8 h-8 text-[#42474C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                            </svg>
                                            <div class="flex-1">
                                                <p class="text-sm font-semibold text-[#191C1D]">${data.file_path.split('/').pop()}</p>
                                                <p class="text-xs text-[#42474C]">Klik untuk melihat dokumen</p>
                                            </div>
                                            <a href="{{ asset('storage') }}/${data.file_path}" target="_blank" class="px-4 py-2 bg-[#06283D] text-white text-sm font-semibold rounded-lg hover:bg-[#001220] transition-colors">
                                                Lihat
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            ` : ''}

                        <!-- Action Buttons -->
                        <div class="flex justify-end gap-3 pt-4 border-t border-[#C3C7CD]">
                            <button onclick="closeModal()" class="px-6 py-2 border border-[#C3C7CD] rounded-lg text-[#42474C] font-semibold hover:bg-gray-50 transition-colors">
                                Tutup
                            </button>
                            <button onclick="verifyDocument('${data.id}', 'rejected')" class="px-6 py-2 bg-[#BA1A1A] text-white font-semibold rounded-lg hover:bg-[#991B1B] transition-colors">
                                Tolak
                            </button>
                            <button onclick="verifyDocument('${data.id}', 'verified')" class="px-6 py-2 bg-[#2E7D32] text-white font-semibold rounded-lg hover:bg-[#1B5E20] transition-colors">
                                Verifikasi
                            </button>
                        </div>
                    </div>
                `;
                })
                .catch(error => {
                    content.innerHTML = `
                    <div class="text-center py-8 text-[#BA1A1A]">
                        <p class="text-lg font-semibold">Gagal memuat data</p>
                        <p class="text-sm">${error.message}</p>
                    </div>
                `;
                });
        }

        function closeModal() {
            document.getElementById('documentModal').classList.add('hidden');
        }

        function verifyDocument(documentId, status) {
            if (!confirm(`Apakah Anda yakin ingin ${status === 'verified' ? 'memverifikasi' : 'menolak'} KTP ini?`)) {
                return;
            }

            const formData = new FormData();
            formData.append('status', status);
            if (status === 'rejected') {
                const reason = prompt('Masukkan alasan penolakan:');
                if (!reason) return;
                formData.append('rejection_reason', reason);
            }

            const url = '/admin/verification/owner/documents/' + documentId + '/verify';

            fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        closeModal();
                        location.reload();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    alert('Terjadi kesalahan: ' + error.message);
                });
        }

        // Close modal on outside click
        document.getElementById('documentModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>
@endpush
