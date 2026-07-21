@extends('layouts.owner')

@section('title', 'Detail Kost - KostMudah')

@section('content')
    <!-- Modal Overlay -->
    <div class="modal-overlay">
        <!-- Modal Container -->
        <div class="modal-container">
            <!-- Header -->
            <div
                class="flex justify-between items-center px-6 py-4 border-b border-[#C3C7CD] sticky-top bg-white rounded-t-xl">
                <div class="flex items-center gap-3">
                    <svg class="w-[22px] h-[18px] text-[#06283D]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    <h2 class="text-[#06283D] text-xl font-semibold">Detail Properti</h2>
                    @if ($boardingHouse->status == 'active')
                        <span
                            class="bg-[#DCFCE7] text-[#15803D] text-[10px] font-bold uppercase px-2 py-1 rounded">AKTIF</span>
                    @elseif($boardingHouse->status == 'inactive')
                        <span
                            class="bg-[#FEE2E2] text-[#991B1B] text-[10px] font-bold uppercase px-2 py-1 rounded">NONAKTIF</span>
                    @else
                        <span
                            class="bg-[#FEF3C7] text-[#92400E] text-[10px] font-bold uppercase px-2 py-1 rounded">PENDING</span>
                    @endif
                </div>
                <a href="{{ route('owner.kost.index') }}" class="p-2 hover:bg-gray-200 rounded-full transition-colors">
                    <svg class="w-3.5 h-3.5 text-[#42474C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </a>
            </div>

            <!-- Photo Gallery -->
            <div class="p-6 bg-[#F2F4F5]">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-[#42474C] text-xs font-semibold tracking-wide">PHOTO GALLERY</span>
                    <div class="flex gap-2">
                        <button onclick="scrollGallery(-1)"
                            class="w-8 h-8 bg-white rounded-full border border-[#C3C7CD] shadow-sm flex items-center justify-center hover:bg-gray-50 transition-colors">
                            <svg class="w-[4.32px] h-[7px] text-black" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                        <button onclick="scrollGallery(1)"
                            class="w-8 h-8 bg-white rounded-full border border-[#C3C7CD] shadow-sm flex items-center justify-center hover:bg-gray-50 transition-colors">
                            <svg class="w-[4.32px] h-[7px] text-black" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div id="galleryContainer" class="gallery-scroll">
                    @forelse($boardingHouse->photos as $photo)
                        <div class="gallery-item">
                            <img src="{{ Storage::url($photo->path) }}" alt="{{ $boardingHouse->name }}">
                        </div>
                    @empty
                        <div class="gallery-item-empty">
                            <span>Tidak ada foto</span>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Tabs -->
            <div class="flex gap-8 px-6 border-b border-[#C3C7CD]">
                <div class="py-4 border-b-2 border-[#06283D]">
                    <span class="text-[#06283D] text-xs font-bold tracking-wide">INFORMASI PROPERTI</span>
                </div>
                <div class="py-4">
                    <span class="text-[#42474C] text-xs font-semibold tracking-wide">STATISTIK KINERJA</span>
                </div>
            </div>

            <!-- Content -->
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Left Column -->
                    <div class="space-y-5">
                        <!-- Nama Kost -->
                        <div>
                            <p class="text-[#42474C] text-xs font-semibold tracking-wide">NAMA KOST</p>
                            <p class="text-[#001220] text-base font-bold mt-1">{{ $boardingHouse->name }}</p>
                        </div>

                        <!-- Alamat -->
                        <div>
                            <p class="text-[#42474C] text-xs font-semibold tracking-wide">ALAMAT LENGKAP</p>
                            <p class="text-[#001220] text-sm mt-1">{{ $boardingHouse->address }}</p>
                        </div>

                        <!-- Kelurahan -->
                        <div>
                            <p class="text-[#42474C] text-xs font-semibold tracking-wide">KELURAHAN</p>
                            <p class="text-[#001220] text-sm mt-1">{{ $boardingHouse->kelurahan }}</p>
                        </div>

                        <!-- Jenis Kost -->
                        <div>
                            <p class="text-[#42474C] text-xs font-semibold tracking-wide">JENIS KOST</p>
                            <div class="mt-1">
                                <span
                                    class="inline-flex items-center gap-1 bg-[#CFE6EF] text-[#52686F] text-xs font-semibold px-3 py-1 rounded-full">
                                    <svg class="w-3 h-2 text-[#52686F]" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    {{ ucfirst($boardingHouse->type) }}
                                </span>
                            </div>
                        </div>

                        <!-- Fasilitas -->
                        <div>
                            <div class="flex items-center gap-2">
                                <svg class="w-2.5 h-2.5 text-[#42474C]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                                <span class="text-[#42474C] text-xs font-semibold tracking-wide">FASILITAS UTAMA</span>
                            </div>
                            <div class="grid grid-cols-2 gap-3 mt-2">
                                @php
                                    $facilities = $boardingHouse->facilities ?? [];
                                @endphp
                                @forelse($facilities as $facility)
                                    <div
                                        class="flex items-center gap-2 p-3 bg-[#F8FAFB] rounded-lg border border-[#C3C7CD]">
                                        <svg class="w-5 h-4 text-[#06283D]" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        <span class="text-[#191C1D] text-sm">{{ $facility }}</span>
                                    </div>
                                @empty
                                    <div class="col-span-2 text-[#42474C] text-sm">Tidak ada fasilitas</div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-5">
                        <!-- Harga & Statistik -->
                        <div class="p-4 bg-[#F2F4F5] rounded-lg border border-[#C3C7CD]">
                            <div>
                                <p class="text-[#42474C] text-xs font-semibold tracking-wide">HARGA SEWA / BULAN</p>
                                <p class="text-[#06283D] text-3xl font-bold mt-1">Rp
                                    {{ number_format($boardingHouse->price_per_month, 0, ',', '.') }}</p>
                            </div>
                            <div class="grid grid-cols-2 gap-4 mt-4 pt-4 border-t border-[#C3C7CD]">
                                <div>
                                    <p class="text-[#42474C] text-xs font-semibold tracking-wide">TOTAL KAMAR</p>
                                    <p class="text-[#001220] text-xl font-semibold mt-1">{{ $boardingHouse->total_rooms }}
                                        Unit</p>
                                </div>
                                <div>
                                    <p class="text-[#42474C] text-xs font-semibold tracking-wide">TERSEDIA</p>
                                    <p class="text-[#15803D] text-xl font-semibold mt-1">
                                        {{ $boardingHouse->available_rooms }} Unit</p>
                                </div>
                            </div>
                        </div>

                        <!-- Peraturan Kost -->
                        <div class="p-4 bg-[#06283D] rounded-lg">
                            <div class="flex items-center gap-2">
                                <svg class="w-[10.5px] h-3 text-[#7390A9]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                <span class="text-[#7390A9] text-xs font-semibold tracking-wide">PERATURAN KOST</span>
                            </div>
                            <div class="space-y-2 mt-2">
                                @php
                                    $rules = $boardingHouse->rules
                                        ? explode("\n", $boardingHouse->rules)
                                        : ['Belum ada peraturan yang ditambahkan'];
                                @endphp
                                @foreach ($rules as $rule)
                                    @if (trim($rule))
                                        <div class="flex gap-3">
                                            <svg class="w-3 h-3 text-green-400 mt-0.5" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                            <span class="text-white text-sm">{{ trim($rule) }}</span>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>

                        <!-- Statistik Kinerja -->
                        <div>
                            <div class="flex items-center gap-2 mb-3">
                                <svg class="w-[10.5px] h-[10.5px] text-[#42474C]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                                <span class="text-[#42474C] text-xs font-semibold tracking-wide">STATISTIK KINERJA (BULAN
                                    INI)</span>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="p-4 bg-[#CFE6EF] rounded-lg border border-[#B4CAD3]">
                                    <p class="text-[#354A51] text-xs font-semibold tracking-wide">PENYEWA AKTIF</p>
                                    <p class="text-[#081E25] text-2xl font-black mt-1">{{ $totalTenants ?? 0 }} Orang</p>
                                </div>
                                <div class="p-4 bg-[#CCE5FF] rounded-lg border border-[#2D4A60]">
                                    <p class="text-[#004B72] text-xs font-semibold tracking-wide">TOTAL PENDAPATAN</p>
                                    <p class="text-[#001E31] text-2xl font-black mt-1">{{ $totalRevenue ?? 'Rp 0' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div
                class="flex flex-col sm:flex-row justify-between items-center gap-4 px-6 py-4 bg-[#ECEEEF] border-t border-[#C3C7CD]">
                <a href="{{ route('owner.kost.index') }}"
                    class="px-6 py-2 text-[#42474C] text-xs font-semibold tracking-wide hover:text-[#001220] transition-colors">
                    TUTUP
                </a>
                <div class="flex flex-wrap justify-center gap-3">
                    <a href="{{ route('owner.tenant.index') }}"
                        class="flex items-center gap-2 px-6 py-3 border-2 border-[#06283D] rounded-lg text-[#06283D] text-xs font-bold tracking-wide hover:bg-[#06283D] hover:text-white transition-colors">
                        <svg class="w-3 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        LIHAT PENYEWA
                    </a>
                    <a href="{{ route('owner.kost.edit', $boardingHouse->id) }}"
                        class="flex items-center gap-2 px-8 py-3 bg-[#06283D] rounded-lg text-white text-xs font-bold tracking-wide shadow-sm hover:bg-[#001220] transition-colors">
                        <svg class="w-[10.5px] h-[10.5px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        EDIT KOST
                    </a>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Gallery scroll function
            function scrollGallery(direction) {
                const container = document.getElementById('galleryContainer');
                const scrollAmount = 320;
                container.scrollBy({
                    left: direction * scrollAmount,
                    behavior: 'smooth'
                });
            }
        </script>
    @endpush
@endsection
