<div class="mb-10">

    {{-- Badge --}}
    <div class="flex items-center gap-2 mb-3">

        <span
            class="px-3 py-1 bg-slate-200 text-slate-700 text-xs font-bold rounded">

            VERIFIED

        </span>

        <span
            class="px-3 py-1 bg-sky-100 text-cyan-950 text-xs font-bold rounded">

            {{ strtoupper($kost->type) }}

        </span>

    </div>

    {{-- Nama Kost --}}
    <div class="flex justify-between items-start">

        <div>

            <h1 class="text-4xl font-bold text-slate-900">

                {{ $kost->name }}

            </h1>

            <div
                class="flex items-center gap-2 mt-3 text-gray-600">

                <i
                    data-lucide="map-pin"
                    class="w-5 h-5">
                </i>

                <span>

                    {{ $kost->address }}

                    @if($kost->kelurahan)
                        , {{ $kost->kelurahan }}
                    @endif

                </span>

            </div>

        </div>

        {{-- Rating --}}
        <div
            class="flex items-center gap-2 bg-yellow-50 border border-yellow-200 px-4 py-2 rounded-lg">

            <i
                data-lucide="star"
                class="w-5 h-5 text-yellow-500 fill-yellow-500">
            </i>

            <div>

                <div class="font-bold">

                    {{ number_format($kost->averageRating(),1) }}

                </div>

                <div class="text-xs text-gray-500">

                    {{ $kost->reviews->count() }} Ulasan

                </div>

            </div>

        </div>

    </div>

    {{-- Harga --}}
    <div class="mt-5">

        <span class="text-3xl font-bold text-cyan-900">

            Rp{{ number_format($kost->price_per_month,0,',','.') }}

        </span>

        <span class="text-gray-500">

            /bulan

        </span>

    </div>

    {{-- Deskripsi --}}
    <p
        class="mt-6 text-gray-600 leading-8">

        {{ $kost->description }}

    </p>

    <hr class="mt-8">

</div>