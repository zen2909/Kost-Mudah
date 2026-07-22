@extends('layouts.owner')

@section('title', 'Detail KTP - KostMudah')

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
                                d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                        </svg>
                    </div>
                    <h2 class="text-[#001220] text-xl font-semibold">Detail KTP</h2>
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
                <a href="{{ route('owner.verification.identity.index') }}"
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
                            <p class="text-[#191C1D] text-base font-semibold mt-1">Kartu Tanda Penduduk (KTP)</p>
                        </div>

                        @if ($document->document_number)
                            <div>
                                <p class="text-[#42474C] text-xs font-semibold tracking-wide uppercase">Nomor KTP</p>
                                <p class="text-[#191C1D] text-base font-mono mt-1">{{ $document->document_number }}</p>
                            </div>
                        @endif

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
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-4">
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
                                    onclick="if(confirm('Yakin ingin menghapus dokumen KTP ini?')) { document.getElementById('delete-form').submit(); }"
                                    class="inline-flex items-center gap-2 px-6 py-2.5 border-2 border-[#BA1A1A] text-[#BA1A1A] rounded-lg font-semibold hover:bg-[#BA1A1A] hover:text-white transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Hapus KTP
                                </button>
                                <form id="delete-form"
                                    action="{{ route('owner.verification.identity.destroy', $document->id) }}"
                                    method="POST" style="display: none;">
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
                        <p class="text-[#42474C] text-xs font-semibold tracking-wide uppercase mb-3">Preview KTP</p>
                        <div class="bg-[#F2F4F5] rounded-lg p-4 flex items-center justify-center max-h-96 overflow-hidden">
                            <img src="{{ Storage::url($document->file_path) }}" alt="KTP"
                                class="max-h-full max-w-full object-contain rounded-lg">
                        </div>
                    </div>
                @endif
            </div>

            <!-- Footer -->
            <div class="px-6 py-4 border-t border-[#C3C7CD] bg-[#ECEEEF] flex justify-end">
                <a href="{{ route('owner.verification.identity.index') }}"
                    class="px-6 py-2 text-[#42474C] font-medium hover:text-[#001220] transition-colors">
                    Tutup
                </a>
            </div>
        </div>
    </div>
@endsection
