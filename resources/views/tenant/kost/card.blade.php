<div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-xl transition duration-300">
    @php
        $isFavorite = isset($kost->favorites) && $kost->favorites->isNotEmpty();
    @endphp

    <div class="relative">
        @if($kost->primaryPhoto)
            <img src="{{ Storage::url($kost->primaryPhoto->path) }}" alt="{{ $kost->name }}" class="w-full h-56 object-cover">
        @else
            <img src="{{ asset('images/no-image.jpg') }}" alt="No Image" class="w-full h-56 object-cover">
        @endif

        <div class="absolute top-3 left-3 flex gap-2">
            <span class="bg-green-600 text-white text-xs px-3 py-1 rounded-full font-semibold">Verified</span>
            <span class="bg-cyan-900 text-white text-xs px-3 py-1 rounded-full">{{ $kost->type }}</span>
        </div>

        <button type="button"
                class="favorite-btn absolute top-3 right-3 w-10 h-10 rounded-full bg-white shadow flex items-center justify-center hover:bg-red-50 transition"
                data-id="{{ $kost->id }}">
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="favorite-icon w-6 h-6 {{ $isFavorite ? 'text-red-600 fill-red-600' : 'text-gray-400' }}"
                 viewBox="0 0 24 24"
                 fill="{{ $isFavorite ? 'currentColor' : 'none' }}"
                 stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 20.364 4.318 12.682a4.5 4.5 0 010-6.364z"/>
            </svg>
        </button>
    </div>

    <div class="p-5">
        <h3 class="text-xl font-bold text-slate-900">{{ $kost->name }}</h3>
        <div class="flex items-center mt-2 text-gray-500 text-sm">📍 {{ $kost->address }}</div>

        <div class="flex items-center justify-between mt-4">
            <div class="flex items-center gap-2">
                ⭐
                <span class="font-semibold">{{ number_format($kost->averageRating(),1) }}</span>
                <span class="text-gray-500">({{ $kost->reviews->count() }} ulasan)</span>
            </div>
        </div>

        @if($kost->facilities)
            <div class="flex flex-wrap gap-2 mt-4">
                @foreach(array_slice((array)$kost->facilities,0,4) as $facility)
                    <span class="bg-gray-100 px-3 py-1 rounded-full text-xs">{{ $facility }}</span>
                @endforeach
            </div>
        @endif

        <div class="mt-5">
            @if($kost->available_rooms > 0)
                <span class="text-green-600 font-semibold">{{ $kost->available_rooms }} kamar tersedia</span>
            @else
                <span class="text-red-600 font-semibold">Penuh</span>
            @endif
        </div>

        <div class="border-t mt-6 pt-5 flex justify-between items-center">
            <div>
                <div class="text-2xl font-bold text-cyan-900">
                    Rp{{ number_format($kost->price_per_month,0,',','.') }}
                </div>
                <div class="text-sm text-gray-500">/bulan</div>
            </div>

            <a href="{{ route('tenant.kost.show',$kost->slug) }}"
               class="bg-cyan-900 hover:bg-cyan-800 text-white px-5 py-3 rounded-lg font-semibold">
                Detail
            </a>
        </div>
    </div>
</div>
