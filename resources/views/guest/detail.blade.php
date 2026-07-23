@extends('layouts.guest')

@section('title', $kost->name . ' - KostMudah')

@section('content')
    <div class="max-w-7xl mx-auto px-4 pt-28 pb-12">
        <!-- Breadcrumb -->
        <div class="text-sm text-[#42474C] mb-6">
            <a href="{{ route('guest.home') }}" class="hover:text-[#001220]">Beranda</a>
            <span class="mx-2">/</span>
            <a href="{{ route('guest.search') }}" class="hover:text-[#001220]">Cari Kost</a>
            <span class="mx-2">/</span>
            <span class="text-[#001220] font-semibold">{{ $kost->name }}</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Photos -->
                <div class="grid grid-cols-2 gap-2 mb-6">
                    @if ($kost->photos->count() > 0)
                        <div class="col-span-2 rounded-xl overflow-hidden h-80">
                            <img src="{{ Storage::url($kost->photos->first()->path) }}" alt="{{ $kost->name }}"
                                class="w-full h-full object-cover">
                        </div>
                        @foreach ($kost->photos->skip(1)->take(3) as $photo)
                            <div class="rounded-xl overflow-hidden h-40">
                                <img src="{{ Storage::url($photo->path) }}" alt="{{ $kost->name }}"
                                    class="w-full h-full object-cover">
                            </div>
                        @endforeach
                    @else
                        <div class="col-span-2 rounded-xl bg-[#F2F4F5] h-80 flex items-center justify-center">
                            <svg class="w-20 h-20 text-[#C3C7CD]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    @endif
                </div>

                <!-- Title & Price -->
                <div class="flex flex-wrap justify-between items-start gap-4 mb-6">
                    <div>
                        <h1 class="text-3xl font-bold text-[#001220]">{{ $kost->name }}</h1>
                        <p class="text-[#42474C] mt-1">{{ $kost->address }}, {{ $kost->kelurahan }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-2xl font-bold text-[#001220]">Rp
                            {{ number_format($kost->price_per_month, 0, ',', '.') }}</p>
                        <p class="text-[#42474C] text-sm">/bulan</p>
                    </div>
                </div>

                <!-- Status -->
                <div class="flex flex-wrap gap-2 mb-6">
                    @if ($kost->status == 'active')
                        <span
                            class="px-3 py-1 bg-green-500 text-white text-xs font-bold uppercase rounded-full">Tersedia</span>
                    @endif
                    @if ($kost->available_rooms > 0)
                        <span
                            class="px-3 py-1 bg-[#06283D] text-white text-xs font-bold rounded-full">{{ $kost->available_rooms }}
                            Kamar Tersedia</span>
                    @endif
                </div>

                <!-- Description -->
                @if ($kost->description)
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-[#001220] mb-2">Deskripsi</h3>
                        <p class="text-[#42474C] leading-relaxed">{{ $kost->description }}</p>
                    </div>
                @endif

                <!-- Facilities -->
                @if ($kost->facilities && count($kost->facilities) > 0)
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-[#001220] mb-2">Fasilitas</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($kost->facilities as $facility)
                                <span
                                    class="px-3 py-1 bg-gray-100 text-[#42474C] text-sm rounded-full">{{ $facility }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Rules -->
                @if ($kost->rules)
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-[#001220] mb-2">Peraturan</h3>
                        <p class="text-[#42474C] leading-relaxed">{{ $kost->rules }}</p>
                    </div>
                @endif

                <!-- Reviews -->
                @if ($kost->reviews->count() > 0)
                    <div>
                        <h3 class="text-lg font-semibold text-[#001220] mb-4">Ulasan ({{ $kost->reviews->count() }})</h3>
                        <div class="space-y-4">
                            @foreach ($kost->reviews->take(3) as $review)
                                <div class="p-4 bg-gray-50 rounded-xl border border-[#C3C7CD]">
                                    <div class="flex items-center gap-3 mb-2">
                                        <div
                                            class="w-10 h-10 rounded-full bg-[#06283D] flex items-center justify-center text-white font-bold">
                                            {{ strtoupper(substr($review->tenant->user->name ?? 'U', 0, 2)) }}
                                        </div>
                                        <div>
                                            <p class="font-semibold text-[#001220]">
                                                {{ $review->tenant->user->name ?? 'User' }}</p>
                                            <div class="flex gap-0.5">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <svg class="w-3 h-3 {{ $i <= $review->rating ? 'text-orange-400' : 'text-gray-300' }}"
                                                        fill="currentColor" viewBox="0 0 20 20">
                                                        <path
                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                    </svg>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-[#42474C] text-sm">{{ $review->review }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl border border-[#C3C7CD] p-6 sticky top-28">
                    <div class="space-y-4">
                        <div>
                            <p class="text-[#42474C] text-sm">Harga per Bulan</p>
                            <p class="text-2xl font-bold text-[#001220]">Rp
                                {{ number_format($kost->price_per_month, 0, ',', '.') }}</p>
                        </div>

                        <hr class="border-[#C3C7CD]">

                        <div>
                            <p class="text-[#42474C] text-sm">Pemilik</p>
                            <p class="font-semibold text-[#001220]">{{ $kost->user->name ?? 'Tidak diketahui' }}</p>
                        </div>

                        <div>
                            <p class="text-[#42474C] text-sm">Kamar Tersedia</p>
                            <p class="font-semibold text-[#001220]">{{ $kost->available_rooms }} dari
                                {{ $kost->total_rooms }} kamar</p>
                        </div>

                        <div>
                            <p class="text-[#42474C] text-sm">Tipe Kost</p>
                            <p class="font-semibold text-[#001220]">{{ ucfirst($kost->type) }}</p>
                        </div>

                        @auth
                            @if (Auth::user()->isTenant())
                                <a href="#"
                                    class="block py-3 bg-[#06283D] text-white text-center font-semibold rounded-lg hover:bg-[#001220] transition">
                                    Hubungi Pemilik
                                </a>
                            @endif
                        @else
                            <a href="{{ route('login') }}"
                                class="block py-3 bg-[#06283D] text-white text-center font-semibold rounded-lg hover:bg-[#001220] transition">
                                Login untuk Hubungi Pemilik
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Kost -->
        @if ($relatedKosts->count() > 0)
            <div class="mt-16">
                <h3 class="text-2xl font-bold text-[#001220] mb-6">Kost Lainnya di {{ $kost->kelurahan }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach ($relatedKosts as $related)
                        <div
                            class="bg-white rounded-xl border border-[#C3C7CD] overflow-hidden hover:shadow-lg transition group">
                            <div class="relative h-40 overflow-hidden">
                                @if ($related->primaryPhoto)
                                    <img src="{{ Storage::url($related->primaryPhoto->path) }}" alt="{{ $related->name }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                @else
                                    <div class="w-full h-full bg-[#F2F4F5] flex items-center justify-center">
                                        <svg class="w-10 h-10 text-[#C3C7CD]" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="p-4">
                                <h4 class="font-semibold text-[#001220] line-clamp-1">{{ $related->name }}</h4>
                                <p class="text-[#42474C] text-sm mt-1">Rp
                                    {{ number_format($related->price_per_month, 0, ',', '.') }}/bulan</p>
                                <a href="{{ route('guest.detail', $related->slug) }}"
                                    class="block mt-3 py-2 text-center text-sm font-semibold text-[#06283D] border border-[#06283D] rounded-lg hover:bg-[#06283D] hover:text-white transition">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection
