@extends('layouts.tenant')

@section('title', 'Temukan Kost Impianmu')

@section('content')
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
            <div>
                <h1 class="text-[#001220] text-2xl md:text-3xl font-bold">Temukan Kost Impianmu</h1>
                <p class="text-[#42474C] text-sm mt-1">Ribuan pilihan hunian nyaman menantimu di berbagai lokasi strategis.
                </p>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="bg-white p-6 rounded-xl border border-[#C3C7CD] shadow-sm mb-6">
            <form id="search-form" action="{{ route('tenant.kost.index') }}" method="GET"
                class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Lokasi dengan Autocomplete -->
                <div class="relative">
                    <label class="text-[#42474C] text-xs font-black uppercase tracking-wider block mb-1.5">LOKASI</label>
                    <div class="relative">
                        <input type="text" id="location-input" name="location" value="{{ request('location') }}"
                            placeholder="Cari lokasi atau nama kost..."
                            class="w-full pl-9 pr-4 py-2.5 border border-[#C3C7CD] rounded-lg bg-white text-sm focus:outline-none focus:ring-2 focus:ring-[#06283D] transition-all"
                            autocomplete="off">
                        <div class="absolute left-3 top-1/2 -translate-y-1/2">
                            <svg class="w-4 h-4 text-[#42474C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <!-- Loading spinner -->
                        <div id="search-loading" class="absolute right-3 top-1/2 -translate-y-1/2 hidden">
                            <svg class="animate-spin h-5 w-5 text-[#06283D]" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <!-- Autocomplete dropdown -->
                    <div id="autocomplete-dropdown"
                        class="absolute z-50 w-full mt-1 bg-white border border-[#C3C7CD] rounded-lg shadow-lg hidden max-h-60 overflow-y-auto">
                        <div id="autocomplete-list" class="py-1">
                            <!-- Results will be inserted here -->
                        </div>
                    </div>
                </div>

                <!-- Rentang Harga -->
                <div>
                    <label class="text-[#42474C] text-xs font-black uppercase tracking-wider block mb-1.5">RENTANG
                        HARGA</label>
                    <div class="flex gap-2">
                        <input type="number" name="price_min" value="{{ request('price_min') }}" placeholder="Min"
                            min="0"
                            class="w-1/2 pl-3 pr-4 py-2.5 border border-[#C3C7CD] rounded-lg bg-white text-sm focus:outline-none focus:ring-2 focus:ring-[#06283D] transition-all">
                        <input type="number" name="price_max" value="{{ request('price_max') }}" placeholder="Max"
                            min="0"
                            class="w-1/2 pl-3 pr-4 py-2.5 border border-[#C3C7CD] rounded-lg bg-white text-sm focus:outline-none focus:ring-2 focus:ring-[#06283D] transition-all">
                    </div>
                </div>

                <!-- Fasilitas -->
                <div>
                    <label class="text-[#42474C] text-xs font-black uppercase tracking-wider block mb-1.5">FASILITAS</label>
                    <div class="relative">
                        <select name="facilities"
                            class="w-full pl-3 pr-10 py-2.5 border border-[#C3C7CD] rounded-lg bg-white text-sm focus:outline-none focus:ring-2 focus:ring-[#06283D] appearance-none transition-all">
                            <option value="">Semua Fasilitas</option>
                            @foreach ($allFacilities as $facility)
                                <option value="{{ $facility }}"
                                    {{ request('facilities') == $facility ? 'selected' : '' }}>
                                    {{ $facility }}
                                </option>
                            @endforeach
                        </select>
                        <svg class="w-3 h-3 absolute right-3 top-1/2 -translate-y-1/2 text-[#42474C]" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>

                <!-- Tipe Kost -->
                <div>
                    <label class="text-[#42474C] text-xs font-black uppercase tracking-wider block mb-1.5">TIPE KOST</label>
                    <div class="relative">
                        <select name="type"
                            class="w-full pl-3 pr-10 py-2.5 border border-[#C3C7CD] rounded-lg bg-white text-sm focus:outline-none focus:ring-2 focus:ring-[#06283D] appearance-none transition-all">
                            <option value="">Semua Tipe</option>
                            <option value="putra" {{ request('type') == 'putra' ? 'selected' : '' }}>Putra</option>
                            <option value="putri" {{ request('type') == 'putri' ? 'selected' : '' }}>Putri</option>
                            <option value="campur" {{ request('type') == 'campur' ? 'selected' : '' }}>Campur</option>
                        </select>
                        <svg class="w-3 h-3 absolute right-3 top-1/2 -translate-y-1/2 text-[#42474C]" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>

                <div class="md:col-span-4 flex justify-end gap-2 pt-2">
                    <a href="{{ route('tenant.kost.index') }}"
                        class="px-6 py-2.5 border border-[#C3C7CD] rounded-lg text-[#42474C] text-sm font-semibold hover:bg-gray-50 transition-colors">
                        Reset
                    </a>
                    <button type="submit"
                        class="px-6 py-2.5 bg-[#06283D] text-white text-sm font-semibold rounded-lg hover:bg-[#001220] transition-colors shadow-sm">
                        Terapkan Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Results Section -->
        <div class="flex flex-col gap-6">
            <!-- Header Results -->
            <div class="flex flex-wrap justify-between items-center gap-4">
                <div class="flex items-center gap-3">
                    <h2 class="text-[#001220] text-xl font-bold">Hasil Pencarian</h2>
                    <span class="text-[#42474C] text-sm font-medium bg-[#F2F4F5] px-3 py-1 rounded-full">
                        {{ $boardingHouses->total() }} Kost ditemukan
                    </span>
                </div>

                <!-- Sorting -->
                <div class="flex items-center gap-2">
                    <span class="text-[#42474C] text-sm font-medium">Urutkan:</span>
                    <div class="relative">
                        <select name="sort" form="filter-form"
                            class="pl-3 pr-10 py-2 border border-[#C3C7CD] rounded-lg bg-white text-sm font-semibold text-[#001220] focus:outline-none focus:ring-2 focus:ring-[#06283D] appearance-none transition-all">
                            <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Terpopuler
                            </option>
                            <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Rating Tertinggi
                            </option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga
                                Terendah</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga
                                Tertinggi</option>
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                        </select>
                        <svg class="w-3 h-3 absolute right-3 top-1/2 -translate-y-1/2 text-[#42474C]" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Results Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($boardingHouses as $kost)
                    <div
                        class="bg-white rounded-xl border border-[#C3C7CD] overflow-hidden hover:shadow-md transition-shadow duration-300">
                        <!-- Image -->
                        <div class="relative">
                            <img class="w-full h-56 object-cover"
                                src="{{ $kost->primaryPhoto?->path ? asset('storage/' . $kost->primaryPhoto->path) : asset('images/default-kost.jpg') }}"
                                alt="{{ $kost->name }}" />

                            @if ($kost->owner?->verification_status === 'approved')
                                <div class="absolute left-3 top-3">
                                    <span
                                        class="px-2 py-1 bg-[#CCE5FF] text-[#004B72] rounded-sm text-[10px] font-bold tracking-wide">VERIFIED</span>
                                </div>
                            @endif

                            <button onclick="toggleFavorite({{ $kost->id }})"
                                class="absolute right-3 top-3 w-8 h-8 bg-white/80 rounded-full flex justify-center items-center hover:bg-white transition-colors shadow-sm">
                                <svg class="w-5 h-5 transition-colors {{ in_array($kost->id, $favoriteIds) ? 'fill-red-500 text-red-500' : 'fill-none text-[#42474C]' }}"
                                    fill="{{ in_array($kost->id, $favoriteIds) ? 'currentColor' : 'none' }}"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </button>
                        </div>

                        <!-- Content -->
                        <div class="p-5 flex flex-col gap-2.5">
                            <div class="flex justify-between items-start">
                                <h3 class="text-[#001220] text-lg font-bold leading-6 line-clamp-1">{{ $kost->name }}
                                </h3>
                                <div class="flex items-center gap-1 flex-shrink-0 ml-2">
                                    <svg class="w-3.5 h-3.5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <span
                                        class="text-[#42474C] text-sm font-bold">{{ number_format($kost->averageRating(), 1) }}</span>
                                </div>
                            </div>

                            <div class="flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-[#42474C] flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span
                                    class="text-[#42474C] text-sm font-medium truncate">{{ $kost->kelurahan ?: 'Lokasi' }}</span>
                            </div>

                            <!-- Facilities -->
                            <div class="flex flex-wrap items-center gap-2 pt-1">
                                @php
                                    $displayFacilities = is_array($kost->facilities)
                                        ? array_slice($kost->facilities, 0, 3)
                                        : [];
                                @endphp
                                @foreach ($displayFacilities as $facility)
                                    <span
                                        class="text-[#42474C] text-xs font-medium bg-[#F2F4F5] px-2.5 py-1 rounded">{{ $facility }}</span>
                                @endforeach
                                @if (is_array($kost->facilities) && count($kost->facilities) > 3)
                                    <span
                                        class="text-[#42474C] text-xs font-medium">+{{ count($kost->facilities) - 3 }}</span>
                                @endif
                            </div>

                            <!-- Price & Action -->
                            <div class="pt-3.5 border-t border-[#C3C7CD] flex justify-between items-center">
                                <div>
                                    <p class="text-[#001220] text-xl font-bold">
                                        Rp {{ number_format($kost->price_per_month, 0, ',', '.') }}
                                    </p>
                                    <p class="text-[#42474C] text-xs font-medium">/ bln</p>
                                </div>
                                <a href="{{ route('tenant.kost.show', $kost->id) }}"
                                    class="px-5 py-2 bg-[#06283D] text-white text-sm font-semibold rounded-lg hover:bg-[#001220] transition-colors shadow-sm">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-16">
                        <svg class="w-20 h-20 mx-auto text-[#C3C7CD] mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        <p class="text-[#001220] text-xl font-bold">Tidak ada kost yang ditemukan</p>
                        <p class="text-[#42474C] text-sm mt-2">Coba ubah filter pencarian Anda</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if ($boardingHouses->hasPages())
                <div class="pt-4 flex justify-center">
                    {{ $boardingHouses->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Hidden form for sorting -->
    <form id="filter-form" action="{{ route('tenant.kost.index') }}" method="GET" class="hidden">
        <input type="hidden" name="location" value="{{ request('location') }}">
        <input type="hidden" name="price_min" value="{{ request('price_min') }}">
        <input type="hidden" name="price_max" value="{{ request('price_max') }}">
        <input type="hidden" name="facilities" value="{{ request('facilities') }}">
        <input type="hidden" name="type" value="{{ request('type') }}">
        <input type="hidden" name="sort" id="sort-input" value="{{ request('sort', 'popular') }}">
    </form>

    @push('scripts')
        <script>
            // Auto-submit when sort changes
            document.querySelector('select[name="sort"]')?.addEventListener('change', function() {
                document.getElementById('sort-input').value = this.value;
                document.getElementById('filter-form').submit();
            });

            // Toggle favorite
            function toggleFavorite(boardingHouseId) {
                fetch('{{ route('tenant.kost.favorite.toggle') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            boarding_house_id: boardingHouseId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            window.location.reload();
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }

            // Autocomplete functionality
            const locationInput = document.getElementById('location-input');
            const dropdown = document.getElementById('autocomplete-dropdown');
            const list = document.getElementById('autocomplete-list');
            const loading = document.getElementById('search-loading');
            let debounceTimer;

            if (locationInput) {
                locationInput.addEventListener('input', function() {
                    const query = this.value.trim();

                    // Clear previous timer
                    clearTimeout(debounceTimer);

                    if (query.length === 0) {
                        dropdown.classList.add('hidden');
                        return;
                    }

                    // Show loading
                    loading.classList.remove('hidden');

                    // Debounce request
                    debounceTimer = setTimeout(function() {
                        fetch('{{ route('tenant.kost.suggest') }}?q=' + encodeURIComponent(query))
                            .then(response => response.json())
                            .then(data => {
                                loading.classList.add('hidden');

                                if (data.length === 0) {
                                    list.innerHTML =
                                        '<div class="px-4 py-2 text-[#42474C] text-sm">Tidak ada lokasi ditemukan</div>';
                                    dropdown.classList.remove('hidden');
                                    return;
                                }

                                let html = '';
                                data.forEach(function(item) {
                                    html += `
                                <div class="px-4 py-2 hover:bg-[#F2F4F5] cursor-pointer text-[#001220] text-sm font-medium"
                                     onclick="selectLocation('${item.name}')">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-[#42474C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        ${item.name}
                                    </div>
                                </div>
                            `;
                                });

                                list.innerHTML = html;
                                dropdown.classList.remove('hidden');
                            })
                            .catch(() => {
                                loading.classList.add('hidden');
                            });
                    }, 300);
                });

                // Hide dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!e.target.closest('#location-input') && !e.target.closest('#autocomplete-dropdown')) {
                        dropdown.classList.add('hidden');
                    }
                });
            }

            function selectLocation(name) {
                locationInput.value = name;
                dropdown.classList.add('hidden');
                // Auto submit form after selecting location
                document.getElementById('search-form').submit();
            }

            // Enter key to submit form
            if (locationInput) {
                locationInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        document.getElementById('search-form').submit();
                    }
                });
            }
        </script>
    @endpush
@endsection
