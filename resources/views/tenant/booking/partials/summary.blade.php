<div class="bg-white border-x border-gray-200 px-6 pb-6">

    <div class="bg-slate-100 rounded-xl border border-gray-300 p-6">

        <div class="flex justify-between mb-4">

            <span class="text-gray-600">
                Harga Sewa
            </span>

            <span
                id="price"
                class="font-semibold"
                data-price="{{ $kost->price_per_month }}">

                Rp{{ number_format($kost->price_per_month,0,',','.') }}

            </span>

        </div>

        <div class="flex justify-between mb-4">

            <span class="text-gray-600">
                Durasi
            </span>

            <span
                id="durationText"
                class="font-semibold">

                1 Bulan

            </span>

        </div>

        <div class="flex justify-between mb-4">

            <span class="text-gray-600">
                Mulai Sewa
            </span>

            <span
                id="startDateText"
                class="font-semibold">

                {{ now()->translatedFormat('d F Y') }}

            </span>

        </div>

        <hr class="my-5">

        <div class="flex justify-between items-center">

            <h3 class="text-2xl font-bold">
                Total Pembayaran
            </h3>

            <h2
                id="totalPrice"
                class="text-4xl font-bold text-cyan-950">

                Rp{{ number_format($kost->price_per_month,0,',','.') }}

            </h2>

        </div>

    </div>

</div>