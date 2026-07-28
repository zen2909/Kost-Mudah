<div class="bg-white rounded-xl border shadow-sm">

    <div class="border-b px-6 py-4">

        <h2 class="text-xl font-semibold">
            Tagihan Saat Ini
        </h2>

    </div>

    @if($currentBill)

    <div class="p-6">

        <div class="flex justify-between">

            <div>

                <h3 class="text-2xl font-bold text-cyan-950">

                    {{ $currentBill->boardingHouse->name }}

                </h3>

                <p class="text-gray-500 mt-1">

                    {{ $currentBill->boardingHouse->address }}

                </p>

            </div>

            <div class="text-right">

                <h2 class="text-3xl font-bold text-cyan-950">

                    Rp{{ number_format($currentBill->total_price,0,',','.') }}

                </h2>

            </div>

        </div>

        <div class="grid md:grid-cols-3 gap-6 mt-8">

            <div>

                <p class="text-sm text-gray-500">
                    Mulai Sewa
                </p>

                <h4 class="font-semibold mt-1">

                    {{ $currentBill->start_date->format('d M Y') }}

                </h4>

            </div>

            <div>

                <p class="text-sm text-gray-500">
                    Berakhir
                </p>

                <h4 class="font-semibold mt-1 text-red-600">

                    {{ $currentBill->end_date->format('d M Y') }}

                </h4>

            </div>

            <div>

                <p class="text-sm text-gray-500">
                    Status
                </p>

                <span class="inline-flex mt-2 rounded-full bg-red-100 px-3 py-1 text-red-700 text-sm font-semibold">

                    {{ ucfirst($currentBill->status) }}

                </span>

            </div>

        </div>

        <div class="mt-8">

            <a
                href="{{ route('tenant.payment.index',$currentBill) }}"
                class="inline-flex items-center rounded-lg bg-cyan-950 px-8 py-3 text-white font-semibold hover:bg-cyan-900">

                Bayar Sekarang

            </a>

        </div>

    </div>

    @else

    <div class="p-10 text-center text-gray-500">

        Tidak ada tagihan yang perlu dibayar.

    </div>

    @endif

</div>