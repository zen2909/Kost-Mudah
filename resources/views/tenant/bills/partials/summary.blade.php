<div class="grid md:grid-cols-3 gap-6">

    <div class="bg-white rounded-xl border shadow-sm p-6">

        <p class="text-sm text-gray-500">
            Total Tagihan
        </p>

        <h2 class="text-3xl font-bold mt-2 text-cyan-950">

            Rp{{ number_format($currentBill?->total_price ?? 0,0,',','.') }}

        </h2>

    </div>

    <div class="bg-white rounded-xl border shadow-sm p-6">

        <p class="text-sm text-gray-500">
            Jatuh Tempo
        </p>

        <h2 class="text-3xl font-bold mt-2 text-red-600">

            {{ $currentBill?->end_date?->format('d F Y') ?? '-' }}

        </h2>

    </div>

    <div class="bg-white rounded-xl border shadow-sm p-6">

        <p class="text-sm text-gray-500">
            Status
        </p>

        @if($currentBill)

            <span class="mt-3 inline-flex rounded-full bg-red-100 px-4 py-2 text-sm font-semibold text-red-700">

                Belum Dibayar

            </span>

        @else

            <span class="mt-3 inline-flex rounded-full bg-green-100 px-4 py-2 text-sm font-semibold text-green-700">

                Tidak Ada Tagihan

            </span>

        @endif

    </div>

</div>