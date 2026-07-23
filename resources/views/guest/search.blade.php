@extends('layouts.guest')

@section('title', 'Hasil Pencarian Kost - KostMudah')

@section('content')
    <div class="max-w-7xl mx-auto px-4 pt-28 pb-12">
        <!-- Search Form -->
        <div class="mb-8">
            <form action="{{ route('guest.search') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1 relative">
                    <svg class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-zinc-500" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 12.414a5 5 0 10-1.414 1.414l4.243 4.243a1 1 0 001.414-1.414zM8 9a1 1 0 011-1h.01a1 1 0 010 2H9a1 1 0 01-1-1z" />
                    </svg>
                    <input type="text" name="location" placeholder="Cari Lokasi..." value="{{ request('location') }}"
                        class="w-full pl-12 pr-4 py-3 bg-white rounded-xl outline outline-1 outline-neutral-300 text-gray-500 focus:outline-sky-500 transition">
                </div>
                <div class="flex-1 relative">
                    <svg class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-zinc-500" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21l-7-5-7 5V5a2 2 0 012-2h10a2 2 0 012 2v16z" />
                    </svg>
                    <input type="text" name="keyword" placeholder="Nama Kost atau Fasilitas..."
                        value="{{ request('keyword') }}"
                        class="w-full pl-12 pr-4 py-3 bg-white rounded-xl outline outline-1 outline-neutral-300 text-gray-500 focus:outline-sky-500 transition">
                </div>
                <button type="submit"
                    class="px-8 py-3 bg-cyan-950 rounded-xl text-white text-base font-bold hover:bg-cyan-900 transition whitespace-nowrap">
                    Cari
                </button>
            </form>
        </div>

        <!-- Results Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-[#001220]">Hasil Pencarian</h1>
            <p class="text-[#42474C] mt-1">Menampilkan {{ $kosts->total() }} kost ditemukan</p>
        </div>

        <!-- Grid Kost -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($kosts as $kost)
                <div
                    class="bg-white rounded-2xl shadow-sm border border-[#C3C7CD] overflow-hidden hover:shadow-lg transition group">
                    <div class="relative h-56 overflow-hidden">
                        @if ($kost->primaryPhoto)
                            <img src="{{ Storage::url($kost->primaryPhoto->path) }}" alt="{{ $kost->name }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        @else
                            <div class="w-full h-full bg-[#F2F4F5] flex items-center justify-center">
                                <svg class="w-16 h-16 text-[#C3C7CD]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                        @if ($kost->status == 'active')
                            <span
                                class="absolute top-4 left-4 px-3 py-1 bg-green-500 rounded-full text-white text-xs font-bold uppercase">VERIFIED</span>
                        @endif
                        @if ($kost->available_rooms > 0)
                            <span
                                class="absolute bottom-4 right-4 px-3 py-1 bg-[#06283D]/80 rounded-full text-white text-xs font-bold">
                                {{ $kost->available_rooms }} Kamar Tersedia
                            </span>
                        @endif
                    </div>
                    <div class="p-5">
                        <div class="flex items-center gap-1 text-[#42474C] text-sm mb-1">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 2a8 8 0 100 16 8 8 0 000-16zm0 14a6 6 0 110-12 6 6 0 010 12z" />
                                <path d="M10 5a1 1 0 011 1v4l3 2a1 1 0 01-1 1l-4-2V6a1 1 0 011-1z" />
                            </svg>
                            {{ $kost->kelurahan }}, {{ explode(',', $kost->address)[0] ?? '' }}
                        </div>
                        <h3 class="text-[#001220] text-xl font-semibold line-clamp-1">{{ $kost->name }}</h3>
                        <div class="flex items-baseline gap-1 mt-1">
                            <span class="text-[#001220] text-lg font-bold">Rp
                                {{ number_format($kost->price_per_month, 0, ',', '.') }}</span>
                            <span class="text-[#42474C] text-sm">/bulan</span>
                        </div>
                        <div class="flex items-center gap-4 mt-2 text-xs text-[#42474C]">
                            <span class="flex items-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                                    <path fill-rule="evenodd"
                                        d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ $kost->total_rooms }} Kamar
                            </span>
                            <span class="flex items-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 2a8 8 0 100 16 8 8 0 000-16zm0 14a6 6 0 110-12 6 6 0 010 12zm-1-8a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ ucfirst($kost->type) }}
                            </span>
                        </div>
                        <a href="{{ route('guest.detail', $kost->slug) }}"
                            class="block mt-4 py-2.5 text-center rounded-xl border-2 border-[#001220] text-[#001220] text-sm font-bold hover:bg-[#001220] hover:text-white transition">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-12">
                    <svg class="w-16 h-16 text-[#C3C7CD] mx-auto mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <p class="text-[#42474C] text-lg font-semibold">Kost tidak ditemukan</p>
                    <p class="text-[#42474C] text-sm mt-1">Coba dengan kata kunci lain</p>
                    <a href="{{ route('guest.home') }}"
                        class="mt-4 inline-block px-6 py-3 bg-[#06283D] text-white rounded-lg hover:bg-[#001220] transition">Kembali
                        ke Beranda</a>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if ($kosts->hasPages())
            <div class="mt-8 flex justify-center">
                {{ $kosts->links() }}
            </div>
        @endif
    </div>
@endsection
