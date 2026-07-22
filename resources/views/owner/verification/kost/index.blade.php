@extends('layouts.owner')

@section('title', 'Verifikasi Data Kost - KostMudah')

@push('styles')
    <style>
        .document-card {
            transition: all 0.3s ease;
        }

        .document-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        }
    </style>
@endpush

@section('content')
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
            <div>
                <h1 class="text-[#001220] text-3xl md:text-4xl font-bold leading-10">Verifikasi Data Kost</h1>
                <p class="text-[#42474C] text-base mt-1">Upload dokumen legalitas properti Anda untuk verifikasi admin.</p>
            </div>
            <button onclick="document.getElementById('uploadModal').classList.remove('hidden')"
                class="mt-4 md:mt-0 px-6 py-3 bg-[#06283D] text-white rounded-lg font-semibold hover:bg-[#001220] transition-colors flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Upload Dokumen
            </button>
        </div>

        @if (session('success'))
            <div class="mb-6 p-4 bg-green-100 text-green-800 rounded-lg border border-green-300">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 p-4 bg-red-100 text-red-800 rounded-lg border border-red-300">
                {{ session('error') }}
            </div>
        @endif

        <!-- Statistics Cards -->
        <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
            <div class="bg-white p-5 rounded-xl border border-[#C3C7CD] shadow-sm">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-[#42474C] text-xs font-semibold tracking-wide uppercase">Total Dokumen</p>
                        <p class="text-[#001220] text-2xl font-bold mt-1">{{ $totalDocuments }}</p>
                    </div>
                    <div class="w-10 h-10 bg-[#06283D]/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-[#06283D]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl border border-[#C3C7CD] shadow-sm">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-[#42474C] text-xs font-semibold tracking-wide uppercase">Pending</p>
                        <p class="text-[#F59E0B] text-2xl font-bold mt-1">{{ $pendingDocuments }}</p>
                    </div>
                    <div class="w-10 h-10 bg-[#F59E0B]/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-[#F59E0B]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl border border-[#C3C7CD] shadow-sm">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-[#42474C] text-xs font-semibold tracking-wide uppercase">Terverifikasi</p>
                        <p class="text-[#15803D] text-2xl font-bold mt-1">{{ $verifiedDocuments }}</p>
                    </div>
                    <div class="w-10 h-10 bg-[#15803D]/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-[#15803D]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl border border-[#C3C7CD] shadow-sm">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-[#42474C] text-xs font-semibold tracking-wide uppercase">Ditolak</p>
                        <p class="text-[#BA1A1A] text-2xl font-bold mt-1">{{ $rejectedDocuments }}</p>
                    </div>
                    <div class="w-10 h-10 bg-[#BA1A1A]/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-[#BA1A1A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl border border-[#C3C7CD] shadow-sm">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-[#42474C] text-xs font-semibold tracking-wide uppercase">Properti Terverifikasi</p>
                        <p class="text-[#0194DC] text-2xl font-bold mt-1">{{ $verifiedProperties }} /
                            {{ $properties->count() }}</p>
                    </div>
                    <div class="w-10 h-10 bg-[#0194DC]/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-[#0194DC]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Trust Score -->
        <div class="bg-[#06283D] p-6 rounded-xl relative overflow-hidden mb-8">
            <div class="absolute right-0 top-0 opacity-10">
                <svg class="w-48 h-48 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z" />
                </svg>
            </div>
            <div class="relative z-10">
                <h3 class="text-white text-3xl font-bold leading-10">Tingkat Kepercayaan Properti {{ $trustScore }}%</h3>
                <p class="text-[#7390A9] text-base mt-2 max-w-[280px]">
                    @if ($trustScore >= 80)
                        Properti Anda sudah terverifikasi dengan baik. Tingkat kepercayaan tinggi meningkatkan visibilitas
                        properti Anda.
                    @elseif($trustScore >= 50)
                        Properti Anda hampir selesai terverifikasi. Lengkapi dokumen untuk meningkatkan kepercayaan.
                    @else
                        Lengkapi verifikasi dokumen properti untuk meningkatkan kepercayaan penyewa.
                    @endif
                </p>
                @if ($trustScore < 100)
                    <button onclick="document.getElementById('uploadModal').classList.remove('hidden')"
                        class="mt-4 px-6 py-3 bg-[#0194DC] text-white text-xs font-semibold tracking-wide rounded-lg hover:bg-[#0179b8] transition-colors">
                        Lengkapi Dokumen Properti
                    </button>
                @endif
            </div>
        </div>

        <!-- Document Cards -->
        @if ($documents->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach ($documents as $document)
                    <a href="{{ route('owner.verification.kost.show', $document->id) }}"
                        class="document-card bg-white p-6 rounded-xl border border-[#C3C7CD] shadow-sm hover:shadow-md transition-all block">
                        <div class="flex justify-between items-start">
                            <div class="p-3 rounded-lg"
                                style="background: {{ $document->status == 'verified' ? '#DCFCE7' : ($document->status == 'pending' ? '#FEF3C7' : '#FEE2E2') }}">
                                @if ($document->document_type == 'imb')
                                    <svg class="w-5 h-5 text-[#52686F]" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                @elseif($document->document_type == 'pbb')
                                    <svg class="w-5 h-5 text-[#52686F]" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                    </svg>
                                @elseif($document->document_type == 'sertifikat')
                                    <svg class="w-5 h-5 text-[#52686F]" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                @else
                                    <svg class="w-5 h-5 text-[#52686F]" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                @endif
                            </div>
                            <span
                                class="{{ $document->getStatusLabelAttribute()['class'] }} text-[10px] font-bold uppercase tracking-wide px-2.5 py-0.5 rounded-full">
                                {{ $document->getStatusLabelAttribute()['label'] }}
                            </span>
                        </div>
                        <div class="mt-4">
                            <h3 class="text-[#001220] text-xl font-semibold">{{ $document->document_type_label }}</h3>
                            @if ($document->boardingHouse)
                                <p class="text-[#42474C] text-sm mt-1">{{ $document->boardingHouse->name }}</p>
                            @endif
                            @if ($document->document_number)
                                <p class="text-[#42474C] text-sm">No: {{ $document->document_number }}</p>
                            @endif
                            <p class="text-[#42474C] text-sm mt-1">Diupload: {{ $document->created_at->format('d M Y') }}
                            </p>
                            @if ($document->expired_date)
                                <p class="text-[#42474C] text-sm">Berlaku hingga:
                                    {{ $document->expired_date->format('d M Y') }}</p>
                            @endif
                            @if ($document->rejection_reason)
                                <p class="text-[#BA1A1A] text-xs mt-2 bg-[#FEE2E2] p-2 rounded-lg">
                                    <strong>Alasan ditolak:</strong> {{ $document->rejection_reason }}
                                </p>
                            @endif
                            <div class="flex items-center gap-2 mt-3 text-[#0194DC] text-xs font-semibold">
                                <span>Klik untuk detail</span>
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white p-12 rounded-xl border-2 border-dashed border-[#C3C7CD] text-center mb-8">
                <div class="flex flex-col items-center">
                    <div class="w-20 h-20 bg-[#F2F4F5] rounded-full flex items-center justify-center mb-4">
                        <svg class="w-10 h-10 text-[#C3C7CD]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <h3 class="text-[#001220] text-xl font-semibold">Belum Ada Dokumen Properti</h3>
                    <p class="text-[#42474C] text-sm mt-1">Upload dokumen legalitas properti Anda untuk verifikasi admin.
                    </p>
                    <button onclick="document.getElementById('uploadModal').classList.remove('hidden')"
                        class="mt-4 px-6 py-3 bg-[#06283D] text-white rounded-lg font-semibold hover:bg-[#001220] transition-colors">
                        Upload Dokumen Sekarang
                    </button>
                </div>
            </div>
        @endif
    </div>

    <!-- Upload Modal -->
    <div id="uploadModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-black/50">
        <div class="bg-white rounded-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center px-6 py-4 border-b border-[#C3C7CD]">
                <h2 class="text-[#001220] text-xl font-semibold">Upload Dokumen Properti</h2>
                <button onclick="document.getElementById('uploadModal').classList.add('hidden')"
                    class="p-2 hover:bg-gray-100 rounded-full transition-colors">
                    <svg class="w-5 h-5 text-[#42474C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form action="{{ route('owner.verification.kost.store') }}" method="POST" enctype="multipart/form-data"
                class="p-6 space-y-5">
                @csrf

                <!-- Jenis Dokumen -->
                <div>
                    <label class="block text-[#42474C] text-xs font-semibold tracking-wide uppercase mb-1.5">Jenis Dokumen
                        <span class="text-[#BA1A1A]">*</span></label>
                    <select name="document_type" id="documentType" required
                        class="w-full px-4 py-3 bg-white border border-[#C3C7CD] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#06283D] text-[#191C1D] transition-shadow">
                        <option value="">Pilih Jenis Dokumen</option>
                        <option value="imb">IMB (Izin Mendirikan Bangunan)</option>
                        <option value="pbb">PBB (Pajak Bumi Bangunan)</option>
                        <option value="sertifikat">Sertifikat Properti</option>
                        <option value="akta">Akta Tanah</option>
                        <option value="other">Lainnya</option>
                    </select>
                    @error('document_type')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Custom Type -->
                <div id="customTypeField" class="hidden">
                    <label class="block text-[#42474C] text-xs font-semibold tracking-wide uppercase mb-1.5">Jenis Dokumen
                        Lainnya</label>
                    <input type="text" name="custom_type"
                        class="w-full px-4 py-3 bg-white border border-[#C3C7CD] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#06283D] text-[#191C1D] transition-shadow"
                        placeholder="Masukkan jenis dokumen">
                </div>

                <!-- Nomor Dokumen -->
                <div>
                    <label class="block text-[#42474C] text-xs font-semibold tracking-wide uppercase mb-1.5">Nomor
                        Dokumen</label>
                    <input type="text" name="document_number"
                        class="w-full px-4 py-3 bg-white border border-[#C3C7CD] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#06283D] text-[#191C1D] transition-shadow"
                        placeholder="Masukkan nomor dokumen">
                </div>

                <!-- Properti -->
                <div>
                    <label class="block text-[#42474C] text-xs font-semibold tracking-wide uppercase mb-1.5">Properti
                        Terkait</label>
                    <select name="boarding_house_id"
                        class="w-full px-4 py-3 bg-white border border-[#C3C7CD] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#06283D] text-[#191C1D] transition-shadow">
                        <option value="">Tidak terkait properti</option>
                        @foreach ($properties as $property)
                            <option value="{{ $property->id }}">{{ $property->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Tanggal Kadaluarsa -->
                <div>
                    <label class="block text-[#42474C] text-xs font-semibold tracking-wide uppercase mb-1.5">Tanggal
                        Kadaluarsa</label>
                    <input type="date" name="expired_date"
                        class="w-full px-4 py-3 bg-white border border-[#C3C7CD] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#06283D] text-[#191C1D] transition-shadow">
                </div>

                <!-- Catatan -->
                <div>
                    <label class="block text-[#42474C] text-xs font-semibold tracking-wide uppercase mb-1.5">Catatan
                        (Opsional)</label>
                    <textarea name="notes" rows="2"
                        class="w-full px-4 py-3 bg-white border border-[#C3C7CD] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#06283D] text-[#191C1D] transition-shadow resize-none"
                        placeholder="Tambahkan catatan untuk dokumen ini"></textarea>
                </div>

                <!-- File Upload -->
                <div>
                    <label class="block text-[#42474C] text-xs font-semibold tracking-wide uppercase mb-1.5">File Dokumen
                        <span class="text-[#BA1A1A]">*</span></label>
                    <div class="border-2 border-dashed border-[#C3C7CD] rounded-lg p-8 text-center hover:border-[#06283D] transition-colors cursor-pointer"
                        onclick="document.getElementById('fileInput').click()">
                        <div class="flex flex-col items-center">
                            <svg class="w-10 h-10 text-[#73777D] mb-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            <p class="text-[#42474C] text-sm font-medium">Klik untuk pilih file</p>
                            <p class="text-[#73777D] text-xs mt-1">PDF, JPG, PNG (Maks 5MB)</p>
                        </div>
                        <input type="file" name="document" id="fileInput" accept=".pdf,.jpg,.jpeg,.png" required
                            class="hidden" onchange="previewDocument(this)">
                    </div>

                    <div id="filePreview" class="mt-3 hidden">
                        <div class="flex items-center gap-4 p-3 bg-[#F2F4F5] rounded-lg border border-[#C3C7CD]">
                            <div id="filePreviewImage"
                                class="w-16 h-16 rounded-lg overflow-hidden flex-shrink-0 bg-white border border-[#C3C7CD] hidden">
                                <img id="previewImg" src="#" alt="Preview" class="w-full h-full object-cover">
                            </div>
                            <div id="filePreviewIcon"
                                class="w-16 h-16 rounded-lg flex items-center justify-center flex-shrink-0 bg-[#06283D]/10">
                                <svg class="w-8 h-8 text-[#06283D]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p id="fileNameDisplay" class="text-[#191C1D] text-sm font-medium">nama-file.pdf</p>
                                <p id="fileSizeDisplay" class="text-[#42474C] text-xs">1.2 MB</p>
                            </div>
                            <button type="button" onclick="removeFile()"
                                class="p-1.5 hover:bg-gray-200 rounded-full transition-colors">
                                <svg class="w-4 h-4 text-[#BA1A1A]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    @error('document')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-[#C3C7CD]">
                    <button type="button" onclick="document.getElementById('uploadModal').classList.add('hidden')"
                        class="px-6 py-2.5 text-[#42474C] font-semibold hover:bg-gray-100 rounded-lg transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-6 py-2.5 bg-[#06283D] text-white font-semibold rounded-lg hover:bg-[#001220] transition-colors">
                        Upload Dokumen
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            function previewDocument(input) {
                const previewContainer = document.getElementById('filePreview');
                const fileNameDisplay = document.getElementById('fileNameDisplay');
                const fileSizeDisplay = document.getElementById('fileSizeDisplay');
                const previewImage = document.getElementById('filePreviewImage');
                const previewImg = document.getElementById('previewImg');
                const previewIcon = document.getElementById('filePreviewIcon');

                if (input.files && input.files[0]) {
                    const file = input.files[0];
                    const fileType = file.type;

                    fileNameDisplay.textContent = file.name;
                    const fileSize = (file.size / 1024 / 1024).toFixed(2);
                    fileSizeDisplay.textContent = fileSize + ' MB';

                    if (fileType.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            previewImg.src = e.target.result;
                            previewImage.classList.remove('hidden');
                            previewIcon.classList.add('hidden');
                        };
                        reader.readAsDataURL(file);
                    } else {
                        previewImage.classList.add('hidden');
                        previewIcon.classList.remove('hidden');
                    }

                    previewContainer.classList.remove('hidden');
                }
            }

            function removeFile() {
                const fileInput = document.getElementById('fileInput');
                const previewContainer = document.getElementById('filePreview');
                const previewImage = document.getElementById('filePreviewImage');
                const previewIcon = document.getElementById('filePreviewIcon');

                fileInput.value = '';
                previewContainer.classList.add('hidden');
                previewImage.classList.add('hidden');
                previewIcon.classList.remove('hidden');
            }

            // Toggle custom type field
            document.getElementById('documentType').addEventListener('change', function() {
                const customField = document.getElementById('customTypeField');
                if (this.value === 'other') {
                    customField.classList.remove('hidden');
                } else {
                    customField.classList.add('hidden');
                }
            });

            // Close modal on outside click
            document.getElementById('uploadModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    this.classList.add('hidden');
                }
            });

            // Close modal on escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    document.getElementById('uploadModal').classList.add('hidden');
                }
            });
        </script>
    @endpush
@endsection
