@php
    $activeRentals = $rentals->where('status', 'active')->count();

    $totalPayment = $rentals->sum('total_price');

    $lastRental = $rentals->first();
@endphp

<div class="grid lg:grid-cols-3 gap-6 mb-8">

    <div class="bg-white rounded-xl border p-6 hover:shadow-lg transition">

        <div class="flex items-center gap-4">

            <div class="w-12 h-12 bg-sky-100 rounded-lg flex items-center justify-center">

                <i data-lucide="house" class="w-6 h-6 text-sky-700"></i>

            </div>

            <div>

                <p class="text-xs uppercase font-semibold text-gray-500">
                    Total Sewa Aktif
                </p>

                <h3 class="text-3xl font-bold">
                    {{ $activeRentals }} Unit
                </h3>

            </div>

        </div>

    </div>

    <div class="bg-white rounded-xl border p-6 hover:shadow-lg transition">

        <div class="flex items-center gap-4">

            <div class="w-12 h-12 bg-cyan-950 rounded-lg flex items-center justify-center">

                <i data-lucide="wallet" class="w-6 h-6 text-white"></i>

            </div>

            <div>

                <p class="text-xs uppercase font-semibold text-gray-500">
                    Total Pembayaran
                </p>

                <h3 class="text-3xl font-bold">
                    Rp {{ number_format($totalPayment,0,',','.') }}
                </h3>

            </div>

        </div>

    </div>

    <div class="bg-white rounded-xl border overflow-hidden hover:shadow-lg transition">

        @if($lastRental)

        <div class="flex">

            <div class="flex-1 p-6">

                <p class="text-xs uppercase font-semibold text-gray-500">
                    Hunian Terakhir
                </p>

                <h3 class="text-xl font-bold mt-2">
                    {{ $lastRental->boardingHouse->name }}
                </h3>

                <p class="text-sm text-gray-500">
                    {{ \Carbon\Carbon::parse($lastRental->end_date)->translatedFormat('d M Y') }}
                </p>

            </div>

            @if($lastRental->boardingHouse->primaryPhoto)

                <img
                    src="{{ asset('storage/'.$lastRental->boardingHouse->primaryPhoto->photo_path) }}"
                    class="w-28 object-cover">

            @endif

        </div>

        @endif

    </div>

</div>