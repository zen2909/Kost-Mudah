<div class="bg-white border-x border-gray-200 px-6 py-6">

    <div class="bg-slate-100 border border-gray-300 rounded-xl p-4 flex gap-5 items-center">

        <img
            src="{{ $kost->primaryPhoto ? Storage::url($kost->primaryPhoto->path) : asset('images/no-image.jpg') }}"
            class="w-20 h-20 rounded-lg object-cover">

        <div>

            <span class="uppercase tracking-wider text-cyan-600 text-xs font-bold">

                {{ strtoupper($kost->type) }}

            </span>

            <h2 class="text-3xl font-bold text-slate-900 mt-1">

                {{ $kost->name }}

            </h2>

            <p class="text-gray-600 mt-1 text-xl">

                Rp{{ number_format($kost->price_per_month,0,',','.') }} / bulan

            </p>

        </div>

    </div>

</div>