@extends('layouts.owner')

@section('title', 'Detail Dokumen Properti - KostMudah')

@section('content')
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50">
        <div class="bg-white rounded-xl max-w-3xl w-full max-h-[90vh] overflow-y-auto modal-document">
            <!-- Header -->
            <div
                class="flex justify-between items-center px-6 py-4 border-b border-[#C3C7CD] sticky top-0 bg-white rounded-t-xl">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-[#06283D] flex items-center justify-center text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h2 class="text-[#001220] text-xl font-semibold">Detail Dokumen Properti</h2>
                    @php
                        $statusColors = [
                            'pending' => 'bg-[#FEF3C7] text-[#92400E]',
                            'verified' => 'bg-[#DCFCE7] text-[#15803D]',
                            'rejected' => 'bg-[#FEE2E2] text-[#991B1B]',
                        ];
                        $statusLabels = [
                            'pending' => 'Pending',
                            'verified' => 'Terverifikasi',
                            'rejected' => 'Ditolak',
                        ];
                    @endphp
                    <span
                        class="inline-block {{ $statusColors[$document->status] ?? 'bg-[#FEF3C7] text-[#92400E]' }} text-[10px] font-bold uppercase px-2.5 py-0.5 rounded-full">
                        {{ $statusLabels[$document->status] ?? 'Pending' }}
                    </span>
                </div>
                <a href="{{ route('owner.verification.kost.index') }}"
                    class="p-2 hover:bg-gray-100 rounded-full transition-colors">
                    <svg class="w-5 h-5 text-[#42474C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </a>
            </div>

            <!-- Content -->
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Left Column -->
                    <div class="space-y-4">
                        <div>
                            <p class="text-[#42474C] text-xs font-semibold tracking-wide uppercase">Jenis Dokumen</p>
                            <p class="text-[#191C1D] text-base font-semibold mt-1">{{ $document->document_type_label }}</p>
                        </div>

                        @if ($document->custom_type)
                            <div>
                                <p class="text-[#42474C] text-xs font-semibold tracking-wide uppercase">Tipe Lainnya</p>
                                <p class="text-[#191C1D] text-base mt-1">{{ $document->custom_type }}</p>
                            </div>
                        @endif

                        @if ($document->document_number)
                            <div>
                                <p class="text-[#42474C] text-xs font-semibold tracking-wide uppercase">Nomor Dokumen</p>
                                <p class="text-[#191C1D] text-base font-mono mt-1">{{ $document->document_number }}</p>
                            </div>
                        @endif

                        @if ($document->boardingHouse)
                            <div>
                                <p class="text-[#42474C] text-xs font-semibold tracking-wide uppercase">Properti Terkait</p>
                                <p class="text-[#191C1D] text-base mt-1">{{ $document->boardingHouse->name }}</p>
                                <p class="text-[#42474C] text-xs">
                                    {{ $document->boardingHouse->address ?? 'Alamat tidak tersedia' }}</p>
                            </div>
                        @endif

                        @if ($document->expired_date)
                            <div>
                                <p class="text-[#42474C] text-xs font-semibold tracking-wide uppercase">Tanggal Kadaluarsa
                                </p>
                                <p class="text-[#191C1D] text-base mt-1">{{ $document->expired_date->format('d M Y') }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-4">
                        <div>
                            <p class="text-[#42474C] text-xs font-semibold tracking-wide uppercase">Status</p>
                            <span
                                class="inline-block {{ $statusColors[$document->status] ?? 'bg-[#FEF3C7] text-[#92400E]' }} text-xs font-bold uppercase px-3 py-1 rounded-full mt-1">
                                {{ $statusLabels[$document->status] ?? 'Pending' }}
                            </span>
                        </div>

                        <div>
                            <p class="text-[#42474C] text-xs font-semibold tracking-wide uppercase">Diupload</p>
                            <p class="text-[#191C1D] text-base mt-1">{{ $document->created_at->format('d M Y H:i') }}</p>
                        </div>

                        @if ($document->verified_at)
                            <div>
                                <p class="text-[#42474C] text-xs font-semibold tracking-wide uppercase">Diverifikasi</p>
                                <p class="text-[#191C1D] text-base mt-1">{{ $document->verified_at->format('d M Y H:i') }}
                                </p>
                            </div>
                        @endif

                        @if ($document->rejection_reason)
                            <div>
                                <p class="text-[#42474C] text-xs font-semibold tracking-wide uppercase">Alasan Ditolak</p>
                                <p class="text-[#BA1A1A] text-sm mt-1 bg-[#FEE2E2] p-3 rounded-lg">
                                    {{ $document->rejection_reason }}</p>
                            </div>
                        @endif

                        @if ($document->notes)
                            <div>
                                <p class="text-[#42474C] text-xs font-semibold tracking-wide uppercase">Catatan</p>
                                <p class="text-[#191C1D] text-sm mt-1 bg-[#F2F4F5] p-3 rounded-lg">{{ $document->notes }}
                                </p>
                            </div>
                        @endif

                        <!-- Tombol Aksi -->
                        <div class="flex flex-wrap gap-3 pt-4 border-t border-[#C3C7CD]">
                            <a href="{{ Storage::url($document->file_path) }}" target="_blank"
                                class="inline-flex items-center gap-2 px-6 py-2.5 bg-[#06283D] text-white rounded-lg font-semibold hover:bg-[#001220] transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Lihat Dokumen
                            </a>

                            @if ($document->status == 'pending')
                                <button
                                    onclick="if(confirm('Yakin ingin menghapus dokumen ini?')) { document.getElementById('delete-form').submit(); }"
                                    class="inline-flex items-center gap-2 px-6 py-2.5 border-2 border-[#BA1A1A] text-[#BA1A1A] rounded-lg font-semibold hover:bg-[#BA1A1A] hover:text-white transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Hapus Dokumen
                                </button>
                                <form id="delete-form"
                                    action="{{ route('owner.verification.kost.destroy', $document->id) }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Preview Dokumen (jika gambar) -->
                @php
                    $extension = pathinfo($document->file_path, PATHINFO_EXTENSION);
                    $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];
                @endphp
                @if (in_array(strtolower($extension), $imageExtensions))
                    <div class="mt-6 pt-6 border-t border-[#C3C7CD]">
                        <p class="text-[#42474C] text-xs font-semibold tracking-wide uppercase mb-3">Preview Dokumen</p>
                        <div class="bg-[#F2F4F5] rounded-lg p-4 flex items-center justify-center max-h-96 overflow-hidden">
                            <img src="{{ Storage::url($document->file_path) }}" alt="{{ $document->document_type_label }}"
                                class="max-h-full max-w-full object-contain rounded-lg">
                        </div>
                    </div>
                @endif
            </div>

            <!-- Footer -->
            <div class="px-6 py-4 border-t border-[#C3C7CD] bg-[#ECEEEF] flex justify-end">
                <a href="{{ route('owner.verification.kost.index') }}"
                    class="px-6 py-2 text-[#42474C] font-medium hover:text-[#001220] transition-colors">
                    Tutup
                </a>
            </div>
        </div>
    </div>
@endsection
