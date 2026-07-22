@extends('layouts.admin')

@section('title', 'Detail Kost - KostMudah')

@section('content')
    <div class="modal-overlay">
        <div class="modal-container">
            <!-- Header -->
            <div class="sticky-top bg-white px-6 pt-6 pb-4 border-b border-[#C3C7CD]">
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-[#06283D] flex items-center justify-center text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <h2 class="text-[#001220] text-xl font-semibold">Detail Kost</h2>
                        @if ($kost->status == 'active')
                            <span
                                class="inline-block bg-[#CCE5FF] text-[#004B72] text-[10px] font-bold uppercase px-2.5 py-0.5 rounded-full">Active</span>
                        @else
                            <span
                                class="inline-block bg-[#F2F4F5] text-[#42474C] text-[10px] font-bold uppercase px-2.5 py-0.5 rounded-full border border-[#C3C7CD]">Inactive</span>
                        @endif
                    </div>
                    <a href="{{ route('admin.kost.index') }}" class="p-2 hover:bg-gray-100 rounded-full transition-colors">
                        <svg class="w-5 h-5 text-[#42474C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Content -->
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Left Column -->
                    <div class="space-y-4">
                        <!-- Foto Utama -->
                        <div>
                            @php
                                $primaryPhoto = $kost->photos->where('is_primary', true)->first();
                            @endphp
                            @if ($primaryPhoto && $primaryPhoto->path)
                                <div class="rounded-lg overflow-hidden border border-[#C3C7CD]">
                                    <img src="{{ Storage::url($primaryPhoto->path) }}" alt="{{ $kost->name }}"
                                        class="w-full h-48 object-cover">
                                </div>
                            @else
                                <div
                                    class="rounded-lg border border-[#C3C7CD] bg-[#F2F4F5] h-48 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-[#C3C7CD]" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span class="text-[#42474C] text-sm ml-2">Tidak ada foto</span>
                                </div>
                            @endif
                        </div>

                        <div>
                            <p class="text-[#42474C] text-xs font-semibold tracking-wide uppercase">Nama Kost</p>
                            <p class="text-[#191C1D] text-base font-semibold mt-1">{{ $kost->name }}</p>
                        </div>

                        <div>
                            <p class="text-[#42474C] text-xs font-semibold tracking-wide uppercase">Pemilik</p>
                            <p class="text-[#191C1D] text-base mt-1">{{ $kost->user ? $kost->user->name : '-' }}</p>
                            <p class="text-[#42474C] text-sm">{{ $kost->user ? $kost->user->email : '-' }}</p>
                        </div>

                        <div>
                            <p class="text-[#42474C] text-xs font-semibold tracking-wide uppercase">Alamat</p>
                            <p class="text-[#191C1D] text-base mt-1">{{ $kost->address ?? '-' }}</p>
                            <p class="text-[#42474C] text-sm">{{ $kost->kelurahan ?? '' }}</p>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-4">
                        <div>
                            <p class="text-[#42474C] text-xs font-semibold tracking-wide uppercase">Tipe Kost</p>
                            <p class="text-[#191C1D] text-base mt-1">{{ ucfirst($kost->type ?? '-') }}</p>
                        </div>

                        <div>
                            <p class="text-[#42474C] text-xs font-semibold tracking-wide uppercase">Harga per Bulan</p>
                            <p class="text-[#191C1D] text-xl font-bold mt-1">Rp
                                {{ number_format($kost->price_per_month, 0, ',', '.') }}</p>
                        </div>

                        <div>
                            <p class="text-[#42474C] text-xs font-semibold tracking-wide uppercase">Kamar</p>
                            <div class="grid grid-cols-2 gap-4 mt-1">
                                <div class="bg-[#F2F4F5] rounded-lg p-3 text-center">
                                    <p class="text-[#42474C] text-xs">Total Kamar</p>
                                    <p class="text-[#191C1D] text-xl font-bold">{{ $kost->total_rooms ?? 0 }}</p>
                                </div>
                                <div class="bg-[#F2F4F5] rounded-lg p-3 text-center">
                                    <p class="text-[#42474C] text-xs">Kamar Tersedia</p>
                                    <p class="text-[#191C1D] text-xl font-bold">{{ $kost->available_rooms ?? 0 }}</p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <p class="text-[#42474C] text-xs font-semibold tracking-wide uppercase">Status</p>
                            <span
                                class="inline-block px-3 py-1 mt-1 {{ $kost->status == 'active' ? 'bg-[#CCE5FF] text-[#004B72]' : 'bg-[#F2F4F5] text-[#42474C]' }} text-xs font-bold uppercase rounded-full">
                                {{ $kost->status == 'active' ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </div>

                        @if ($kost->description)
                            <div>
                                <p class="text-[#42474C] text-xs font-semibold tracking-wide uppercase">Deskripsi</p>
                                <p class="text-[#191C1D] text-sm mt-1 bg-[#F2F4F5] p-3 rounded-lg">{{ $kost->description }}
                                </p>
                            </div>
                        @endif

                        @if ($kost->facilities)
                            <div>
                                <p class="text-[#42474C] text-xs font-semibold tracking-wide uppercase">Fasilitas</p>
                                <div class="flex flex-wrap gap-2 mt-1">
                                    @foreach ($kost->facilities as $facility)
                                        <span
                                            class="px-2 py-1 bg-[#F2F4F5] text-[#42474C] text-xs rounded-full">{{ $facility }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Foto Lainnya -->
                @php
                    $otherPhotos = $kost->photos->where('is_primary', false);
                @endphp
                @if ($otherPhotos->count() > 0)
                    <div class="mt-6 pt-6 border-t border-[#C3C7CD]">
                        <p class="text-[#42474C] text-xs font-semibold tracking-wide uppercase mb-3">Foto Lainnya</p>
                        <div class="grid grid-cols-3 gap-3">
                            @foreach ($otherPhotos as $photo)
                                <div class="rounded-lg overflow-hidden border border-[#C3C7CD] h-24">
                                    <img src="{{ Storage::url($photo->path) }}" alt="{{ $kost->name }}"
                                        class="w-full h-full object-cover">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Footer -->
                <div class="flex justify-end pt-4 mt-4 border-t border-[#C3C7CD]">
                    <a href="{{ route('admin.kost.index') }}"
                        class="px-6 py-2 border border-[#C3C7CD] rounded-lg text-[#42474C] font-semibold hover:bg-gray-50 transition-colors">
                        Tutup
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
