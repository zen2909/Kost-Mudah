@extends('layouts.guest')

@section('title', 'Cari Kost di Surabaya Timur Jadi Lebih Mudah')

@section('content')
    <!-- ============================================================ -->
    <!-- HERO SECTION -->
    <!-- ============================================================ -->
    <section class="w-full h-[870px] relative overflow-hidden mt-[73px]">
        <!-- Background Image -->
        <div class="absolute inset-0">
            <img src="{{ asset('images/hero-image.png') }}" alt="Hero KostMudah" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-r from-slate-950/90 to-slate-950/20"></div>
        </div>

        <!-- Konten Hero -->
        <div class="relative max-w-[896px] h-full mx-auto px-6 flex flex-col justify-center items-start gap-4">
            <h1 class="text-white text-4xl md:text-6xl font-bold leading-[60px]">
                Cari Kost di Surabaya Timur<br />Jadi Lebih Mudah
            </h1>
            <p class="max-w-[672px] text-white/90 text-base font-normal leading-6">
                Temukan hunian nyaman, strategis, dan aman di sekitar Sukolilo, Mulyorejo, dan sekitarnya dengan sistem
                verifikasi terbaik.
            </p>
            <div class="pt-4 flex flex-wrap items-center gap-4">
                <a href="#search-section"
                    class="px-8 py-4 bg-sky-500 rounded-xl text-white text-base font-bold hover:bg-sky-600 transition shadow-lg flex items-center gap-2">
                    Cari Kost Sekarang
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
                @guest
                    <a href="{{ route('register') }}"
                        class="px-8 py-4 bg-white/10 rounded-xl outline outline-1 outline-white/20 backdrop-blur-[6px] text-white text-base font-bold hover:bg-white/20 transition">
                        Daftar Sekarang
                    </a>
                @endguest
            </div>
        </div>
    </section>

    <!-- ============================================================ -->
    <!-- SEARCH BAR (Floating) -->
    <!-- ============================================================ -->
    <div id="search-section" class="max-w-[1232px] mx-auto px-4 -mt-20 relative z-10">
        <form action="{{ route('guest.search') }}" method="GET"
            class="bg-white rounded-2xl p-8 shadow-xl outline outline-1 outline-neutral-300 flex flex-col md:flex-row items-center gap-4">
            <div class="flex-1 relative w-full">
                <svg class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-zinc-500" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17.657 16.657L13.414 12.414a5 5 0 10-1.414 1.414l4.243 4.243a1 1 0 001.414-1.414zM8 9a1 1 0 011-1h.01a1 1 0 010 2H9a1 1 0 01-1-1z" />
                </svg>
                <input type="text" name="location" placeholder="Cari Lokasi (Sukolilo, Mulyorejo...)"
                    class="w-full pl-12 pr-4 py-4 bg-white rounded-xl outline outline-1 outline-neutral-300 text-gray-500 focus:outline-sky-500 transition"
                    value="{{ request('location') }}">
            </div>
            <div class="flex-1 relative w-full">
                <svg class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-zinc-500" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21l-7-5-7 5V5a2 2 0 012-2h10a2 2 0 012 2v16z" />
                </svg>
                <input type="text" name="keyword" placeholder="Nama Kost atau Fasilitas"
                    class="w-full pl-12 pr-4 py-4 bg-white rounded-xl outline outline-1 outline-neutral-300 text-gray-500 focus:outline-sky-500 transition"
                    value="{{ request('keyword') }}">
            </div>
            <button type="submit"
                class="px-10 py-4 bg-cyan-950 rounded-xl text-white text-base font-bold hover:bg-cyan-900 transition whitespace-nowrap">
                Cari
            </button>
        </form>
    </div>

    <!-- ============================================================ -->
    <!-- WHY KOSTMUDAH -->
    <!-- ============================================================ -->
    <section id="features" class="max-w-[1280px] mx-auto px-6 py-24">
        <div class="text-center mb-16">
            <span class="text-sky-500 text-xs font-bold uppercase tracking-wider">MENGAPA KOSTMUDAH?</span>
            <h2 class="text-slate-950 text-3xl font-bold leading-10 mt-2">Solusi Hunian Terpercaya</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Card 1 -->
            <div class="p-8 bg-white rounded-2xl outline outline-1 outline-neutral-300 hover:shadow-lg transition">
                <div class="w-14 h-14 bg-gray-100 rounded-xl flex items-center justify-center mb-3">
                    <svg class="w-6 h-6 text-slate-950" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" />
                    </svg>
                </div>
                <h3 class="text-slate-950 text-xl font-semibold pt-3">Verified Owners</h3>
                <p class="text-zinc-700 text-base font-normal leading-6 mt-1">Semua pemilik kost telah melewati proses
                    verifikasi identitas dan dokumen properti yang ketat.</p>
            </div>

            <!-- Card 2 -->
            <div class="p-8 bg-white rounded-2xl outline outline-1 outline-neutral-300 hover:shadow-lg transition">
                <div class="w-14 h-14 bg-gray-100 rounded-xl flex items-center justify-center mb-3">
                    <svg class="w-6 h-6 text-slate-950" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z" />
                        <path fill-rule="evenodd"
                            d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" />
                    </svg>
                </div>
                <h3 class="text-slate-950 text-xl font-semibold pt-3">Safe Transactions</h3>
                <p class="text-zinc-700 text-base font-normal leading-6 mt-1">Sistem pembayaran aman yang menjamin uang
                    Anda terlindungi hingga proses check-in selesai.</p>
            </div>

            <!-- Card 3 -->
            <div class="p-8 bg-white rounded-2xl outline outline-1 outline-neutral-300 hover:shadow-lg transition">
                <div class="w-14 h-14 bg-gray-100 rounded-xl flex items-center justify-center mb-3">
                    <svg class="w-6 h-6 text-slate-950" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" />
                    </svg>
                </div>
                <h3 class="text-slate-950 text-xl font-semibold pt-3">Customer Support</h3>
                <p class="text-zinc-700 text-base font-normal leading-6 mt-1">Tim bantuan kami siap melayani Anda 24/7
                    untuk memastikan pengalaman pencarian kost yang lancar.</p>
            </div>

            <!-- Card 4 -->
            <div class="p-8 bg-white rounded-2xl outline outline-1 outline-neutral-300 hover:shadow-lg transition">
                <div class="w-14 h-14 bg-gray-100 rounded-xl flex items-center justify-center mb-3">
                    <svg class="w-6 h-6 text-slate-950" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                    </svg>
                </div>
                <h3 class="text-slate-950 text-xl font-semibold pt-3">Wide Range</h3>
                <p class="text-zinc-700 text-base font-normal leading-6 mt-1">Ribuan pilihan kost mulai dari tipe
                    eksklusif hingga ekonomis di seluruh Surabaya Timur.</p>
            </div>
        </div>
    </section>

    <!-- ============================================================ -->
    <!-- POPULAR KOST (TERLARIS) -->
    <!-- ============================================================ -->
    <section id="popular" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 mb-10">
                <div>
                    <span class="text-[#0194DC] text-xs font-bold uppercase tracking-wider">TERLARIS MINGGU INI</span>
                    <h2 class="text-[#001220] text-3xl font-bold leading-10">Rekomendasi Kost Populer</h2>
                </div>
                <a href="{{ route('guest.search') }}"
                    class="flex items-center gap-2 text-[#001220] text-base font-bold hover:text-[#0194DC] transition">
                    Lihat Semua
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
            </div>

            <!-- Grid Kost -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($popularKosts as $kost)
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
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        <p class="text-[#42474C] text-lg font-semibold">Belum ada kost tersedia</p>
                        <p class="text-[#42474C] text-sm mt-1">Silakan cek kembali nanti</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- ============================================================ -->
    <!-- TESTIMONI -->
    <!-- ============================================================ -->
    <section id="testimonials" class="max-w-[1280px] mx-auto px-6 py-24">
        <div class="text-center mb-16">
            <span class="text-sky-500 text-xs font-bold uppercase tracking-wider">APA KATA MEREKA?</span>
            <h2 class="text-slate-950 text-3xl font-bold leading-10 mt-2">Testimoni Penyewa</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach ($testimonials as $testimonial)
                <div class="p-8 bg-white rounded-2xl outline outline-1 outline-neutral-300 relative">
                    <div class="flex gap-1 mb-4">
                        @for ($i = 1; $i <= 5; $i++)
                            <svg class="w-5 h-5 {{ $i <= $testimonial->rating ? 'text-orange-400' : 'text-gray-300' }}"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        @endfor
                    </div>
                    <p class="text-zinc-700 text-base leading-6">"{{ $testimonial->review }}"</p>
                    <div class="flex items-center gap-4 mt-4 pt-4">
                        <div class="w-12 h-12 rounded-full outline outline-2 outline-neutral-300 overflow-hidden">
                            @if ($testimonial->tenant && $testimonial->tenant->user && $testimonial->tenant->user->photo)
                                <img src="{{ Storage::url($testimonial->tenant->user->photo) }}"
                                    alt="{{ $testimonial->tenant->user->name }}" class="w-full h-full object-cover">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($testimonial->tenant->user->name ?? 'User') }}&background=0EA5E9&color=fff"
                                    alt="{{ $testimonial->tenant->user->name ?? 'User' }}"
                                    class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div>
                            <p class="text-slate-950 text-base font-bold">{{ $testimonial->tenant->user->name ?? 'User' }}
                            </p>
                            <p class="text-zinc-700 text-sm">{{ $testimonial->occupation ?? 'Penyewa' }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- ============================================================ -->
    <!-- CTA BANNER -->
    <!-- ============================================================ -->
    <section class="max-w-[1280px] mx-auto px-6 pb-24">
        <div class="relative bg-cyan-950 rounded-3xl px-6 md:px-72 py-20 overflow-hidden">
            <div class="absolute w-64 h-64 rounded-full bg-white/5 -top-32 right-10"></div>
            <div class="absolute w-64 h-64 rounded-full bg-white/5 -bottom-32 -left-32"></div>

            <div class="relative max-w-[672px] mx-auto text-center">
                <h2 class="text-white text-3xl font-bold leading-10 mb-4">Punya Properti Kost di Surabaya Timur?</h2>
                <p class="text-slate-300 text-base leading-6 mb-6">Gabung bersama ribuan pemilik kost lainnya dan
                    dapatkan kemudahan dalam mengelola hunian serta transaksi yang transparan.</p>
                <div class="flex flex-wrap justify-center items-center gap-4 pt-4">
                    <a href="{{ route('register') }}"
                        class="px-8 py-4 bg-sky-500 rounded-xl text-white text-base font-bold hover:bg-sky-600 transition shadow-lg">Daftarkan
                        Kost Saya</a>
                </div>
            </div>
        </div>
    </section>
@endsection
