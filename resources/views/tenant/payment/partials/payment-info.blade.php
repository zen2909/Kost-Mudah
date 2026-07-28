<div class="p-8">

    <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-6">

        <div class="flex-1">

            <p class="uppercase tracking-wide text-gray-500 text-sm">
                Total Pembayaran
            </p>

            <h2 class="text-4xl font-bold text-cyan-950 mt-2">
                Rp{{ number_format($rental->total_price, 0, ',', '.') }}
            </h2>

            <div class="mt-6 bg-white rounded-xl border border-gray-200 p-5">

                <div class="flex justify-between py-2 border-b">
                    <span class="text-gray-500">Kost</span>
                    <span class="font-semibold text-right">
                        {{ $rental->boardingHouse->name }}
                    </span>
                </div>

                <div class="flex justify-between py-2 border-b">
                    <span class="text-gray-500">Durasi</span>
                    <span class="font-semibold">
                        {{ $rental->duration_months }} Bulan
                    </span>
                </div>

                <div class="flex justify-between py-2">
                    <span class="text-gray-500">Mulai Sewa</span>
                    <span class="font-semibold">
                        {{ \Carbon\Carbon::parse($rental->start_date)->translatedFormat('d F Y') }}
                    </span>
                </div>

            </div>

        </div>

        <div class="flex-shrink-0">

            <span class="inline-flex items-center px-4 py-2 rounded-full bg-amber-100 text-amber-700 font-semibold">
                Menunggu Pembayaran
            </span>

        </div>

    </div>

</div>