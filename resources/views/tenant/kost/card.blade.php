<div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition duration-300">

    {{-- Gambar --}}
    <div class="relative">

        <img
            src="{{ $kost->gambar ?? 'https://placehold.co/600x400' }}"
            class="w-full h-56 object-cover">

        {{-- Badge --}}
        @if(($kost->badge ?? 'verified') == 'verified')

            <span
                class="absolute top-3 left-3 bg-green-500/90 backdrop-blur text-white text-[10px] font-bold px-2 py-1 rounded">

                VERIFIED

            </span>

        @else

            <span
                class="absolute top-3 left-3 bg-gray-700/90 backdrop-blur text-white text-[10px] font-bold px-2 py-1 rounded">

                PROMO

            </span>

        @endif

        {{-- Favorite --}}
        <button
            class="absolute top-3 right-3 w-9 h-9 rounded-full bg-red-500 flex items-center justify-center">

            <i data-lucide="heart"
                class="w-5 h-5 text-white fill-white">
            </i>

        </button>

    </div>

    {{-- Isi Card --}}
    <div class="p-5">

        {{-- Nama + Rating --}}
        <div class="flex justify-between items-start">

            <div>

                <h3 class="text-xl font-semibold text-slate-900">

                    {{ $kost->nama ?? 'Kost Menteng Residence' }}

                </h3>

            </div>

            <div class="flex items-center gap-1">

                <i data-lucide="star"
                    class="w-4 h-4 text-yellow-500 fill-yellow-500">
                </i>

                <span class="text-sm font-semibold text-gray-700">

                    {{ $kost->rating ?? '4.8' }}

                </span>

            </div>

        </div>

        {{-- Lokasi --}}
        <div class="flex items-center gap-1 mt-2 text-gray-600">

            <i data-lucide="map-pin"
                class="w-4 h-4">
            </i>

            <span class="text-sm">

                {{ $kost->lokasi ?? 'Menteng, Jakarta Pusat' }}

            </span>

        </div>

        {{-- Fasilitas --}}
        <div class="flex flex-wrap gap-3 mt-4">

            <div class="flex items-center gap-1 text-xs text-gray-700">

                <i data-lucide="snowflake"
                    class="w-4 h-4">
                </i>

                AC

            </div>

            <div class="flex items-center gap-1 text-xs text-gray-700">

                <i data-lucide="wifi"
                    class="w-4 h-4">
                </i>

                WiFi

            </div>

            <div class="flex items-center gap-1 text-xs text-gray-700">

                <i data-lucide="bath"
                    class="w-4 h-4">
                </i>

                KM Dalam

            </div>

            <div class="flex items-center gap-1 text-xs text-gray-700">

                <i data-lucide="car"
                    class="w-4 h-4">
                </i>

                Parkir

            </div>

        </div>

        {{-- Harga --}}
        <div class="border-t mt-5 pt-5 flex justify-between items-center">

            <div>

                <h4 class="text-2xl font-bold text-slate-900">

                    {{ $kost->harga ?? 'Rp 3.500.000' }}

                </h4>

                <p class="text-sm text-gray-500">

                    /bulan

                </p>

            </div>

            <a
                href="{{ route('tenant.kost.show') }}"
                class="w-full bg-cyan-950 text-white rounded-lg py-3 flex justify-center">

                View Detail

            </a>

        </div>

    </div>

</div>