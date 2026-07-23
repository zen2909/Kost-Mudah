@extends('layouts.tenant')

@section('title', $boardingHouse->name)

@section('content')
    <div class="max-w-7xl mx-auto">
        <!-- Back Button -->
        <a href="{{ route('tenant.kost.index') }}"
            class="inline-flex items-center gap-2 text-[#42474C] text-sm font-medium hover:text-[#06283D] transition-colors mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke hasil pencarian
        </a>

        <div class="bg-white rounded-xl border border-[#C3C7CD] shadow-sm overflow-hidden">
            <!-- Image Gallery -->
            <div class="p-2">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-2">
                    <!-- Main Image -->
                    <div class="md:col-span-2 md:row-span-2 relative">
                        <img class="w-full h-96 object-cover rounded-lg"
                            src="{{ $boardingHouse->primaryPhoto?->path ? asset('storage/' . $boardingHouse->primaryPhoto->path) : asset('images/default-kost.jpg') }}"
                            alt="{{ $boardingHouse->name }}" />
                        @if ($boardingHouse->owner?->verification_status === 'approved')
                            <div class="absolute left-4 bottom-4 px-3 py-1 bg-[#06283D]/80 rounded-full">
                                <span class="text-white text-xs font-medium tracking-wider">UTAMA</span>
                            </div>
                        @endif
                    </div>

                    <!-- Thumbnails -->
                    @foreach ($boardingHouse->photos->where('is_primary', false)->take(3) as $photo)
                        <div class="relative">
                            <img class="w-full h-60 object-cover rounded-lg" src="{{ asset('storage/' . $photo->path) }}"
                                alt="{{ $boardingHouse->name }}" />
                        </div>
                    @endforeach

                    <!-- More Photos -->
                    @if ($boardingHouse->photos->count() > 4)
                        <div class="relative h-60 bg-[#F2F4F5] rounded-lg overflow-hidden">
                            <img class="w-full h-full object-cover opacity-60"
                                src="{{ $boardingHouse->photos->where('is_primary', false)->skip(3)->first()?->path ? asset('storage/' . $boardingHouse->photos->where('is_primary', false)->skip(3)->first()->path) : asset('images/default-kost.jpg') }}"
                                alt="{{ $boardingHouse->name }}" />
                            <div class="absolute inset-0 flex flex-col justify-center items-center bg-black/5">
                                <svg class="w-12 h-12 text-[#001220]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                </svg>
                                <span
                                    class="text-[#001220] text-base font-medium">+{{ $boardingHouse->photos->count() - 4 }}
                                    Foto</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Content -->
            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Left Column -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Header -->
                        <div class="border-b border-[#C3C7CD] pb-6">
                            <div class="flex flex-wrap items-center gap-2 mb-3">
                                @if ($boardingHouse->owner?->verification_status === 'approved')
                                    <span
                                        class="px-2.5 py-0.5 bg-[#CCE5FF] text-[#004B72] rounded-sm text-[10px] font-bold uppercase tracking-wide">VERIFIED</span>
                                @endif
                                <span
                                    class="px-2.5 py-0.5 bg-[#E8F0FE] text-[#004B72] rounded-sm text-[10px] font-bold uppercase tracking-wide">
                                    {{ strtoupper($boardingHouse->type ?? 'campur') }}
                                </span>
                                @if ($boardingHouse->available_rooms > 0)
                                    <span
                                        class="px-2.5 py-0.5 bg-[#DCFCE7] text-[#15803D] rounded-sm text-[10px] font-bold uppercase tracking-wide">TERSEDIA</span>
                                @else
                                    <span
                                        class="px-2.5 py-0.5 bg-[#FEE2E2] text-[#991B1B] rounded-sm text-[10px] font-bold uppercase tracking-wide">PENUH</span>
                                @endif
                            </div>
                            <h1 class="text-[#001220] text-3xl font-bold">{{ $boardingHouse->name }}</h1>
                            <div class="flex items-center gap-1.5 mt-2">
                                <svg class="w-4 h-4 text-[#42474C] flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span class="text-[#42474C] text-base font-medium">{{ $boardingHouse->address }}</span>
                            </div>
                            <div class="flex items-center gap-4 mt-3">
                                <div class="flex items-center gap-1.5">
                                    <div class="flex items-center">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= floor($averageRating))
                                                <svg class="w-4 h-4 text-yellow-500" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                            @elseif($i - 0.5 <= $averageRating)
                                                <svg class="w-4 h-4 text-yellow-500" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                            @else
                                                <svg class="w-4 h-4 text-[#C3C7CD]" fill="currentColor" viewBox="0 0 20 20">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                            @endif
                                        @endfor
                                    </div>
                                    <span
                                        class="text-[#001220] text-sm font-bold">{{ number_format($averageRating, 1) }}</span>
                                    <span class="text-[#42474C] text-sm font-medium">({{ $totalReviews }} ulasan)</span>
                                </div>
                                <span class="text-[#C3C7CD]">|</span>
                                <span class="text-[#42474C] text-sm font-medium">{{ $boardingHouse->available_rooms }}
                                    kamar tersedia</span>
                            </div>
                        </div>

                        <!-- Description -->
                        @if ($boardingHouse->description)
                            <div>
                                <h2 class="text-[#001220] text-xl font-bold mb-3">Deskripsi</h2>
                                <p class="text-[#42474C] text-base leading-relaxed">{{ $boardingHouse->description }}</p>
                            </div>
                        @endif

                        <!-- Facilities -->
                        @if (count($facilities) > 0)
                            <div>
                                <h2 class="text-[#001220] text-xl font-bold mb-4">Fasilitas Kamar & Kost</h2>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                    @foreach ($facilities as $facility)
                                        <div
                                            class="p-4 bg-[#F2F4F5] rounded-lg text-center hover:bg-[#E8F0FE] transition-colors">
                                            <div class="flex justify-center mb-2">
                                                <svg class="w-6 h-6 text-[#42474C]" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 13l4 4L19 7" />
                                                </svg>
                                            </div>
                                            <span class="text-[#42474C] text-sm font-medium">{{ $facility }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Rules -->
                        @if (!empty($rules))
                            <div class="p-6 bg-[#F2F4F5] rounded-xl border-l-4 border-[#06283D]">
                                <div class="flex items-center gap-2 mb-4">
                                    <svg class="w-5 h-5 text-[#06283D]" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <h3 class="text-[#001220] text-xl font-bold">Peraturan Kost</h3>
                                </div>
                                <ul class="space-y-2.5">
                                    @foreach ($rules as $rule)
                                        @if (trim($rule))
                                            <li class="flex items-start gap-3">
                                                <svg class="w-4 h-4 text-[#BA1A1A] mt-1 flex-shrink-0" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                                <span
                                                    class="text-[#001220] text-base font-medium">{{ $rule }}</span>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>

                    <!-- Right Column - Booking Card -->
                    <div class="lg:col-span-1">
                        <div class="sticky top-4 space-y-4">
                            <!-- Price Card -->
                            <div class="p-6 bg-white rounded-xl border border-[#C3C7CD] shadow-sm">
                                <div class="mb-4">
                                    <p class="text-[#42474C] text-sm font-medium">Mulai Dari</p>
                                    <div class="flex items-baseline">
                                        <span class="text-[#001220] text-3xl font-bold">
                                            Rp {{ number_format($boardingHouse->price_per_month, 0, ',', '.') }}
                                        </span>
                                        <span class="text-[#42474C] text-sm font-medium ml-2">/ bln</span>
                                    </div>
                                </div>

                                <div class="space-y-3 mb-4">
                                    <div class="py-2.5 border-b border-[#C3C7CD] flex justify-between">
                                        <span class="text-[#42474C] text-sm font-medium">Tipe Kamar</span>
                                        <span class="text-[#001220] text-sm font-bold">Standar</span>
                                    </div>
                                    <div class="py-2.5 border-b border-[#C3C7CD] flex justify-between">
                                        <span class="text-[#42474C] text-sm font-medium">Min. Sewa</span>
                                        <span class="text-[#001220] text-sm font-bold">3 Bulan</span>
                                    </div>
                                    <div class="py-2.5 border-b border-[#C3C7CD] flex justify-between">
                                        <span class="text-[#42474C] text-sm font-medium">Tersedia</span>
                                        <span
                                            class="text-[#001220] text-sm font-bold">{{ $boardingHouse->available_rooms }}
                                            Kamar</span>
                                    </div>
                                    <div class="py-2.5 flex justify-between">
                                        <span class="text-[#42474C] text-sm font-medium">Deposit</span>
                                        <span class="text-[#001220] text-sm font-bold">Rp 1.000.000</span>
                                    </div>
                                </div>

                                <div class="space-y-3">
                                    @if ($boardingHouse->available_rooms > 0)
                                        <a href="#" onclick="openBookingModal({{ $boardingHouse->id }})"
                                            class="w-full py-3.5 bg-[#06283D] text-white text-sm font-bold rounded-lg flex justify-center items-center gap-2 hover:bg-[#001220] transition-colors shadow-sm">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            Sewa Sekarang
                                        </a>
                                    @else
                                        <button disabled
                                            class="w-full py-3.5 bg-[#F2F4F5] text-[#42474C] text-sm font-bold rounded-lg cursor-not-allowed">
                                            Kamar Penuh
                                        </button>
                                    @endif

                                    <button onclick="toggleFavorite({{ $boardingHouse->id }})"
                                        class="w-full py-3.5 border-2 border-[#06283D] rounded-lg flex justify-center items-center gap-2 hover:bg-[#F2F4F5] transition-colors">
                                        <svg class="w-5 h-5 {{ $isFavorited ? 'fill-red-500 text-red-500' : 'text-[#06283D]' }}"
                                            fill="{{ $isFavorited ? 'currentColor' : 'none' }}" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                        </svg>
                                        <span class="text-[#06283D] text-sm font-bold">
                                            {{ $isFavorited ? 'Hapus Favorit' : 'Tambah Favorit' }}
                                        </span>
                                    </button>
                                </div>
                            </div>

                            <!-- Owner Info -->
                            @if ($boardingHouse->owner && $boardingHouse->owner->user)
                                <div class="p-5 bg-[#F8FAFB] rounded-xl border border-[#C3C7CD]">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="w-12 h-12 bg-white rounded-full overflow-hidden flex items-center justify-center flex-shrink-0 border border-[#C3C7CD]">
                                            <img class="w-full h-full object-cover"
                                                src="{{ $boardingHouse->owner->user->photo ? asset('storage/' . $boardingHouse->owner->user->photo) : asset('images/default-avatar.png') }}"
                                                alt="{{ $boardingHouse->owner->user->name }}" />
                                        </div>
                                        <div>
                                            <h4 class="text-[#001220] font-bold">{{ $boardingHouse->owner->user->name }}
                                            </h4>
                                            <p class="text-[#42474C] text-sm font-medium">Pemilik Kost</p>
                                            @if ($boardingHouse->owner->verification_status === 'approved')
                                                <span class="text-[#15803D] text-xs font-semibold">✓ Terverifikasi</span>
                                            @endif
                                        </div>
                                    </div>
                                    <a href="#"
                                        class="mt-4 w-full py-3 bg-[#15803D] text-white text-sm font-bold rounded-lg flex justify-center items-center gap-2 hover:bg-[#166534] transition-colors shadow-sm">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                        </svg>
                                        Chat Owner
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="px-6 pb-6 opacity-40 flex justify-center items-center gap-2">
                <span class="text-[#001220] text-base font-bold">KostMudah</span>
                <span class="w-1 h-1 bg-[#001220] rounded-full"></span>
                <span class="text-[#42474C] text-xs font-bold uppercase tracking-wider">PROPERTY PORTAL</span>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Toggle favorite function
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

            // ============================================
            // BOOKING MODAL FUNCTIONS
            // ============================================

            function openBookingModal(kostId) {
                const modal = document.getElementById('bookingModal');
                if (!modal) {
                    console.error('Booking modal not found');
                    return;
                }

                modal.style.display = 'flex';
                document.body.style.overflow = 'hidden';

                // Fetch booking data
                fetch('{{ route('tenant.booking.form') }}?kost_id=' + kostId)
                    .then(response => response.json())
                    .then(data => {
                        if (data.boarding_house) {
                            // Update kost info
                            const img = document.getElementById('booking-kost-image');
                            if (img) {
                                img.src = data.boarding_house.primary_photo?.path ?
                                    '/storage/' + data.boarding_house.primary_photo.path :
                                    '/images/default-kost.jpg';
                            }
                            document.getElementById('booking-kost-name').textContent = data.boarding_house.name;
                            document.getElementById('booking-kost-price').textContent =
                                'Rp ' + new Intl.NumberFormat('id-ID').format(data.boarding_house.price_per_month) +
                                ' / bln';

                            // Render duration options
                            const container = document.getElementById('duration-options');
                            if (container && data.durations) {
                                container.innerHTML = data.durations.map((d, index) => `
                            <div onclick="selectDuration(${index})" 
                                 id="duration-${index}"
                                 class="p-3 rounded-lg outline outline-1 outline-offset-[-1px] ${d.is_selected ? 'outline-cyan-950 bg-gray-100' : 'outline-neutral-300'} cursor-pointer hover:bg-gray-50 transition-all text-center">
                                <p class="text-zinc-900 text-base font-semibold">${d.label}</p>
                                <p class="text-zinc-700 text-[10px] font-normal">${d.discount_label}</p>
                            </div>
                        `).join('');

                                // Set default
                                window.selectedDurationIndex = 0;
                                updateSummary(data.durations[0], data.boarding_house.price_per_month);
                            }

                            // Set start date
                            const startDate = document.getElementById('booking-start-date');
                            if (startDate && data.start_date) {
                                const dateParts = data.start_date.split('/');
                                if (dateParts.length === 3) {
                                    const formattedDate = dateParts[2] + '-' + dateParts[1] + '-' + dateParts[0];
                                    startDate.value = formattedDate;
                                }
                            }

                            // Store data for submission
                            window.bookingData = {
                                boarding_house_id: data.boarding_house.id,
                                price_per_month: data.boarding_house.price_per_month,
                                durations: data.durations,
                            };
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching booking data:', error);
                        alert('Gagal memuat data booking');
                        closeBookingModal();
                    });
            }

            function closeBookingModal() {
                const modal = document.getElementById('bookingModal');
                if (modal) {
                    modal.style.display = 'none';
                    document.body.style.overflow = '';
                }
            }

            function selectDuration(index) {
                window.selectedDurationIndex = index;

                // Update UI
                const container = document.getElementById('duration-options');
                if (container) {
                    container.querySelectorAll('[id^="duration-"]').forEach((el, i) => {
                        el.className =
                            `p-3 rounded-lg outline outline-1 outline-offset-[-1px] ${i === index ? 'outline-cyan-950 bg-gray-100' : 'outline-neutral-300'} cursor-pointer hover:bg-gray-50 transition-all text-center`;
                    });
                }

                // Update summary
                if (window.bookingData && window.bookingData.durations) {
                    const duration = window.bookingData.durations[index];
                    updateSummary(duration, window.bookingData.price_per_month);
                }
            }

            function updateSummary(duration, pricePerMonth) {
                const total = duration.total || (pricePerMonth * duration.months);
                const pricePerMonthFormatted = new Intl.NumberFormat('id-ID').format(pricePerMonth);
                const totalFormatted = new Intl.NumberFormat('id-ID').format(total);

                const summaryPrice = document.getElementById('summary-price');
                const summaryDuration = document.getElementById('summary-duration');
                const summaryTotal = document.getElementById('summary-total');

                if (summaryPrice) summaryPrice.textContent = 'Rp ' + pricePerMonthFormatted;
                if (summaryDuration) summaryDuration.textContent = duration.label;
                if (summaryTotal) summaryTotal.textContent = 'Rp ' + totalFormatted;

                // Store for submission
                window.selectedDuration = duration;
            }

            function processBooking() {
                const btn = document.getElementById('booking-submit-btn');
                if (!btn) return;

                btn.disabled = true;
                btn.textContent = 'Memproses...';

                const startDate = document.getElementById('booking-start-date').value;
                if (!startDate) {
                    alert('Silakan pilih tanggal mulai sewa');
                    btn.disabled = false;
                    btn.textContent = 'Lanjutkan ke Pembayaran';
                    return;
                }

                const data = {
                    boarding_house_id: window.bookingData?.boarding_house_id,
                    duration_months: window.selectedDuration?.months,
                    start_date: startDate,
                    total_price: window.selectedDuration?.total,
                };

                if (!data.boarding_house_id || !data.duration_months || !data.total_price) {
                    alert('Data booking tidak lengkap');
                    btn.disabled = false;
                    btn.textContent = 'Lanjutkan ke Pembayaran';
                    return;
                }

                fetch('{{ route('tenant.booking.process') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify(data)
                    })
                    .then(response => response.json())
                    .then(result => {
                        if (result.status === 'success') {
                            window.location.href = result.data.redirect_url;
                        } else {
                            alert(result.message || 'Terjadi kesalahan');
                            btn.disabled = false;
                            btn.textContent = 'Lanjutkan ke Pembayaran';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan: ' + error.message);
                        btn.disabled = false;
                        btn.textContent = 'Lanjutkan ke Pembayaran';
                    });
            }

            // Close modal when clicking outside
            document.addEventListener('click', function(e) {
                const modal = document.getElementById('bookingModal');
                if (modal && modal.style.display === 'flex') {
                    if (e.target === modal) {
                        closeBookingModal();
                    }
                }
            });

            // Close modal with ESC key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeBookingModal();
                }
            });

            // Initialize start date change event
            document.addEventListener('DOMContentLoaded', function() {
                const startDateInput = document.getElementById('booking-start-date');
                if (startDateInput) {
                    startDateInput.addEventListener('change', function() {
                        // Recalculate if needed
                    });
                }
            });
        </script>
    @endpush
    @include('components.tenant.booking-modal');
@endsection
