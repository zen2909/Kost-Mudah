<div
    x-data="{ metode:'bank' }"
    class="p-6">

    <div class="bg-slate-100 rounded-xl border border-gray-300 p-6">

        {{-- Header --}}
        <div class="flex justify-between items-start">

            <div>

                <p class="uppercase tracking-wide text-gray-600">
                    Total Bayar
                </p>

                <h2 class="text-3xl font-bold mt-2">
                    Rp 3.500.000
                </h2>

            </div>

            <span
                class="bg-sky-100 text-slate-700 px-4 py-2 rounded-full text-sm font-semibold">

                Menunggu Pembayaran

            </span>

        </div>

        {{-- Metode Pembayaran --}}
        <div class="mt-8">

            <p class="uppercase tracking-wide text-gray-600 mb-4">
                Metode Pembayaran
            </p>

            <div class="bg-gray-200 rounded-xl p-1 flex">

                <button
                    @click="metode='bank'"
                    :class="metode=='bank'
                        ? 'bg-white shadow font-semibold text-cyan-950'
                        : 'text-gray-600'"
                    class="flex-1 py-3 rounded-lg transition">

                    Transfer Bank

                </button>

                <button
                    @click="metode='qris'"
                    :class="metode=='qris'
                        ? 'bg-white shadow font-semibold text-cyan-950'
                        : 'text-gray-600'"
                    class="flex-1 py-3 rounded-lg transition">

                    QRIS

                </button>

                <button
                    @click="metode='ewallet'"
                    :class="metode=='ewallet'
                        ? 'bg-white shadow font-semibold text-cyan-950'
                        : 'text-gray-600'"
                    class="flex-1 py-3 rounded-lg transition">

                    E-Wallet

                </button>

            </div>

        </div>

        <hr class="my-6">

        {{-- ====================== --}}
        {{-- Transfer Bank --}}
        {{-- ====================== --}}

        <div x-show="metode=='bank'">

            <h3 class="uppercase text-gray-700 mb-4">

                Transfer ke Rekening

            </h3>

            <div class="flex gap-4 items-center">

                <img
                    src="https://upload.wikimedia.org/wikipedia/commons/5/5c/Bank_Central_Asia.svg"
                    class="w-14 h-14 rounded-lg bg-white p-2 border">

                <div>

                    <h4 class="font-bold text-xl">

                        Bank Central Asia (BCA)

                    </h4>

                    <div class="flex items-center gap-3">

                        <span class="text-lg">

                            8830 1234 5678

                        </span>

                        <button
                            onclick="navigator.clipboard.writeText('883012345678')"
                            class="text-cyan-950 font-semibold">

                            Salin

                        </button>

                    </div>

                    <p class="text-gray-600">

                        a.n PT KostMudah Properti Indonesia

                    </p>

                </div>

            </div>

        </div>

        {{-- ====================== --}}
        {{-- QRIS --}}
        {{-- ====================== --}}

        <div
            x-show="metode=='qris'"
            class="text-center">

            <h3 class="uppercase text-gray-700 mb-6">

                Scan QRIS

            </h3>

            <img
                src="https://placehold.co/220x220?text=QRIS"
                class="mx-auto rounded-lg border">

            <p class="text-gray-600 mt-5">

                Scan menggunakan Mobile Banking atau E-Wallet.

            </p>

        </div>

        {{-- ====================== --}}
        {{-- E-Wallet --}}
        {{-- ====================== --}}

        <div x-show="metode=='ewallet'">

            <h3 class="uppercase text-gray-700 mb-4">

                Pilih E-Wallet

            </h3>

            <div class="grid grid-cols-2 gap-4">

                <button class="border rounded-xl p-5 hover:border-cyan-950">

                    OVO

                </button>

                <button class="border rounded-xl p-5 hover:border-cyan-950">

                    DANA

                </button>

                <button class="border rounded-xl p-5 hover:border-cyan-950">

                    ShopeePay

                </button>

            </div>

            <input
                type="text"
                placeholder="08xx xxxx xxxx"
                class="mt-6 w-full border rounded-xl px-4 py-3">

        </div>

    </div>

</div>