<div class="bg-white rounded-xl border shadow-sm">

    <div class="border-b px-6 py-4">

        <h2 class="text-xl font-semibold">
            Tagihan Bulan Ini
        </h2>

    </div>

    <div class="p-6">

        <div class="flex justify-between">

            <div>

                <h3 class="text-2xl font-bold text-cyan-950">

                    Kost Melati Residence

                </h3>

                <p class="text-gray-500 mt-1">

                    Kamar 203

                </p>

            </div>

            <div class="text-right">

                <h2 class="text-3xl font-bold text-cyan-950">

                    Rp2.500.000

                </h2>

                <p class="text-gray-500">

                    Juli 2026

                </p>

            </div>

        </div>

        <div class="grid md:grid-cols-3 gap-6 mt-8">

            <div>

                <p class="text-sm text-gray-500">

                    Periode

                </p>

                <h4 class="font-semibold mt-1">

                    Juli 2026

                </h4>

            </div>

            <div>

                <p class="text-sm text-gray-500">

                    Jatuh Tempo

                </p>

                <h4 class="font-semibold mt-1 text-red-600">

                    05 Juli 2026

                </h4>

            </div>

            <div>

                <p class="text-sm text-gray-500">

                    Status

                </p>

                <span class="inline-flex mt-2 rounded-full bg-red-100 px-3 py-1 text-red-700 text-sm font-semibold">

                    Belum Dibayar

                </span>

            </div>

        </div>

        <div class="mt-8">

            <a href="{{ route('tenant.payment.index') }}"
                class="inline-flex items-center rounded-lg bg-cyan-950 px-8 py-3 text-white font-semibold hover:bg-cyan-900">

                Bayar Sekarang

            </a>

        </div>

    </div>

</div>