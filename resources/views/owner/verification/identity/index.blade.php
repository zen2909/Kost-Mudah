@extends('layouts.owner')

@section('title', 'Verifikasi Data Diri - KostMudah')

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
                <h1 class="text-[#001220] text-3xl md:text-4xl font-bold leading-10">Verifikasi Data Diri</h1>
                <p class="text-[#42474C] text-base mt-1">Upload KTP Anda untuk verifikasi identitas sebagai pemilik properti.
                </p>
            </div>
            @if ($verificationStatus !== 'approved')
                <button onclick="document.getElementById('uploadModal').classList.remove('hidden')"
                    class="mt-4 md:mt-0 px-6 py-3 bg-[#06283D] text-white rounded-lg font-semibold hover:bg-[#001220] transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Upload KTP
                </button>
            @endif
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

        <!-- Status Verifikasi -->
        <div class="bg-white p-6 rounded-xl border border-[#C3C7CD] shadow-sm mb-8">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <p class="text-[#42474C] text-xs font-semibold tracking-wide uppercase">Status Verifikasi Data Diri</p>
                    <div class="flex items-center gap-3 mt-1">
                        <span
                            class="inline-block {{ $statusColors[$verificationStatus] ?? 'bg-[#F2F4F5] text-[#42474C]' }} text-sm font-bold uppercase px-3 py-1 rounded-full">
                            {{ $statusLabels[$verificationStatus] ?? 'Belum Verifikasi' }}
                        </span>
                        @if ($verificationStatus === 'approved')
                            <span class="text-[#15803D] text-sm flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Identitas telah terverifikasi
                            </span>
                        @elseif($verificationStatus === 'pending')
                            <span class="text-[#F59E0B] text-sm flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Menunggu verifikasi admin
                            </span>
                        @elseif($verificationStatus === 'rejected')
                            <span class="text-[#BA1A1A] text-sm flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Verifikasi ditolak, silakan upload ulang KTP
                            </span>
                        @else
                            <span class="text-[#42474C] text-sm flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Belum mengupload KTP
                            </span>
                        @endif
                    </div>
                </div>
                @if ($verificationStatus === 'rejected' || $verificationStatus === 'unverified')
                    <button onclick="document.getElementById('uploadModal').classList.remove('hidden')"
                        class="px-6 py-2 bg-[#06283D] text-white rounded-lg font-semibold hover:bg-[#001220] transition-colors">
                        Upload Ulang KTP
                    </button>
                @endif
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div class="bg-white p-5 rounded-xl border border-[#C3C7CD] shadow-sm">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-[#42474C] text-xs font-semibold tracking-wide uppercase">Total Upload</p>
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
                <h3 class="text-white text-3xl font-bold leading-10">Tingkat Kepercayaan Data Diri {{ $trustScore }}%
                </h3>
                <p class="text-[#7390A9] text-base mt-2 max-w-[280px]">
                    @if ($trustScore >= 100)
                        Data diri Anda sudah terverifikasi dengan baik.
                    @elseif($trustScore >= 50)
                        Data diri Anda sedang dalam proses verifikasi.
                    @else
                        Upload KTP Anda untuk memulai verifikasi data diri.
                    @endif
                </p>
            </div>
        </div>

        <!-- Document Cards -->
        @if ($documents->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach ($documents as $document)
                    <a href="{{ route('owner.verification.identity.show', $document->id) }}"
                        class="document-card bg-white p-6 rounded-xl border border-[#C3C7CD] shadow-sm hover:shadow-md transition-all block">
                        <div class="flex justify-between items-start">
                            <div class="p-3 rounded-lg"
                                style="background: {{ $document->status == 'verified' ? '#DCFCE7' : ($document->status == 'pending' ? '#FEF3C7' : '#FEE2E2') }}">
                                <svg class="w-5 h-5 text-[#52686F]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                </svg>
                            </div>
                            <span
                                class="{{ $document->getStatusLabelAttribute()['class'] }} text-[10px] font-bold uppercase tracking-wide px-2.5 py-0.5 rounded-full">
                                {{ $document->getStatusLabelAttribute()['label'] }}
                            </span>
                        </div>
                        <div class="mt-4">
                            <h3 class="text-[#001220] text-xl font-semibold">Kartu Tanda Penduduk</h3>
                            @if ($document->document_number)
                                <p class="text-[#42474C] text-sm">No: {{ $document->document_number }}</p>
                            @endif
                            <p class="text-[#42474C] text-sm mt-1">Diupload: {{ $document->created_at->format('d M Y') }}
                            </p>
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
                                d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                        </svg>
                    </div>
                    <h3 class="text-[#001220] text-xl font-semibold">Belum Upload KTP</h3>
                    <p class="text-[#42474C] text-sm mt-1">Upload KTP Anda untuk verifikasi data diri sebagai pemilik
                        properti.</p>
                    <button onclick="document.getElementById('uploadModal').classList.remove('hidden')"
                        class="mt-4 px-6 py-3 bg-[#06283D] text-white rounded-lg font-semibold hover:bg-[#001220] transition-colors">
                        Upload KTP Sekarang
                    </button>
                </div>
            </div>
        @endif
    </div>

    <!-- Upload Modal -->
    <div id="uploadModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-black/50">
        <div class="bg-white rounded-xl max-w-lg w-full max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center px-6 py-4 border-b border-[#C3C7CD]">
                <h2 class="text-[#001220] text-xl font-semibold">Upload KTP</h2>
                <button onclick="document.getElementById('uploadModal').classList.add('hidden')"
                    class="p-2 hover:bg-gray-100 rounded-full transition-colors">
                    <svg class="w-5 h-5 text-[#42474C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form action="{{ route('owner.verification.identity.store') }}" method="POST" enctype="multipart/form-data"
                class="p-6 space-y-5">
                @csrf

                <div>
                    <label class="block text-[#42474C] text-xs font-semibold tracking-wide uppercase mb-1.5">Nomor
                        KTP</label>
                    <input type="text" name="document_number"
                        class="w-full px-4 py-3 bg-white border border-[#C3C7CD] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#06283D] text-[#191C1D] transition-shadow"
                        placeholder="Masukkan nomor KTP">
                </div>

                <div>
                    <label class="block text-[#42474C] text-xs font-semibold tracking-wide uppercase mb-1.5">File KTP <span
                            class="text-[#BA1A1A]">*</span></label>
                    <div class="border-2 border-dashed border-[#C3C7CD] rounded-lg p-6 text-center hover:border-[#06283D] transition-colors cursor-pointer"
                        onclick="document.getElementById('fileInput').click()">
                        <div class="flex flex-col items-center">
                            <svg class="w-10 h-10 text-[#73777D] mb-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            <p class="text-[#42474C] text-sm font-medium">Klik untuk pilih file</p>
                            <p class="text-[#73777D] text-xs mt-1">JPG, PNG, PDF (Maks 5MB)</p>
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
                                <p id="fileNameDisplay" class="text-[#191C1D] text-sm font-medium">nama-file.jpg</p>
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
                        Upload KTP
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
