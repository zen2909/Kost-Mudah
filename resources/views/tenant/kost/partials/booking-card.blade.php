@php
    $isFavorite = isset($kost->favorites) && $kost->favorites->isNotEmpty();
@endphp

<div class="bg-white rounded-2xl border shadow-sm sticky top-24 overflow-hidden">

    <!-- Harga -->
    <div class="p-6">

        <p class="text-gray-500 text-sm">
            Mulai Dari
        </p>

        <div class="flex items-end gap-2 mt-2">
            <h2 class="text-4xl font-bold text-slate-900">
                Rp{{ number_format($kost->price_per_month,0,',','.') }}
            </h2>

            <span class="text-gray-500 mb-1">
                /bulan
            </span>
        </div>

    </div>

    <!-- Detail -->
    <div class="border-t">

        <div class="flex justify-between px-6 py-4">
            <span class="text-gray-500">
                Jenis Kost
            </span>

            <span class="font-semibold">
                {{ ucfirst($kost->type) }}
            </span>
        </div>

        <div class="flex justify-between px-6 py-4 border-t">
            <span class="text-gray-500">
                Kamar Tersedia
            </span>

            <span class="font-semibold">

                @if($kost->available_rooms > 0)

                    {{ $kost->available_rooms }} Kamar

                @else

                    Penuh

                @endif

            </span>
        </div>

        <div class="flex justify-between px-6 py-4 border-t">
            <span class="text-gray-500">
                Status
            </span>

            <span class="font-semibold">

                @if($kost->status == 'active')

                    <span class="text-green-600">
                        Tersedia
                    </span>

                @else

                    <span class="text-red-600">
                        Tidak Tersedia
                    </span>

                @endif

            </span>
        </div>

    </div>

    <!-- Tombol -->
    <div class="p-6">

        @if($kost->available_rooms > 0 && $kost->status == 'active')

            <a
                href="{{ route('tenant.booking.index', $kost->slug) }}"
                class="w-full flex justify-center items-center gap-2 bg-cyan-950 hover:bg-cyan-900 text-white py-4 rounded-xl font-semibold transition">

                <i data-lucide="calendar-check" class="w-5 h-5"></i>

                Sewa Sekarang

            </a>

        @else

            <button
                disabled
                class="w-full bg-gray-300 text-gray-600 py-4 rounded-xl font-semibold cursor-not-allowed">

                Kost Penuh

            </button>

        @endif

        <button
            type="button"
            data-id="{{ $kost->id }}"
            class="favorite-btn mt-3 w-full flex justify-center items-center gap-2 border-2 border-cyan-950 text-cyan-950 hover:bg-cyan-950 hover:text-white py-4 rounded-xl font-semibold transition">

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="favorite-icon w-5 h-5 {{ $isFavorite ? 'text-red-600 fill-red-600' : '' }}"
                 viewBox="0 0 24 24"
                 fill="{{ $isFavorite ? 'currentColor' : 'none' }}"
                 stroke="currentColor">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 20.364 4.318 12.682a4.5 4.5 0 010-6.364z"/>
            </svg>

            {{ $isFavorite ? 'Hapus Favorit' : 'Tambah Favorit' }}

        </button>

    </div>

    <!-- Owner -->
    <div class="border-t bg-slate-50 p-6">

        <div class="flex items-center gap-4">

            <img
                src="https://ui-avatars.com/api/?name={{ urlencode($kost->owner->user->name ?? $kost->user->name) }}&background=0EA5E9&color=fff"
                class="w-14 h-14 rounded-full">

            <div>

                <h4 class="font-bold text-slate-900">

                    {{ $kost->owner->user->name ?? $kost->user->name }}

                </h4>

                <p class="text-sm text-gray-500">

                    Pemilik Kost

                </p>

            </div>

        </div>

    </div>

</div>