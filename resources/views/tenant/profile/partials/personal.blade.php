<div class="bg-white rounded-xl border overflow-hidden mb-8">

    {{-- Header --}}
    <div class="bg-gray-50 border-b px-6 py-4 flex items-center gap-2">

        <i data-lucide="user-round" class="w-5 h-5 text-slate-900"></i>

        <h3 class="uppercase text-sm font-bold tracking-wide">

            Informasi Pribadi

        </h3>

    </div>

    {{-- Form --}}
    <div class="p-6">

        <form>

            <div class="grid lg:grid-cols-2 gap-6">

                <div>

                    <label
                        class="block text-sm font-semibold text-gray-700 mb-2">

                        Nama Lengkap

                    </label>

                    <input
                        type="text"
                        value="{{ Auth::user()->name }}"
                        class="w-full rounded-lg border px-4 py-3 focus:ring-2 focus:ring-cyan-900 focus:outline-none">

                </div>

                <div>

                    <label
                        class="block text-sm font-semibold text-gray-700 mb-2">

                        Nomor Telepon (WA)

                    </label>

                    <input
                        type="text"
                        value="081234567890"
                        class="w-full rounded-lg border px-4 py-3 focus:ring-2 focus:ring-cyan-900 focus:outline-none">

                </div>

            </div>

            <div class="mt-6">

                <label
                    class="block text-sm font-semibold text-gray-700 mb-2">

                    Alamat Asal

                </label>

                <textarea
                    rows="4"
                    class="w-full rounded-lg border px-4 py-3 resize-none focus:ring-2 focus:ring-cyan-900 focus:outline-none">Jl. Merdeka No.45, Kecamatan Sukajadi, Kota Bandung, Jawa Barat</textarea>

            </div>

        </form>

    </div>

</div>