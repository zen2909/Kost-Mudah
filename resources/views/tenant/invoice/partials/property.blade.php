<div class="px-6 py-5">

    <div class="bg-slate-100 rounded-xl p-5 border">

        <div class="flex items-center gap-4">

            <div class="w-16 h-16 rounded-lg overflow-hidden">

                @if($rental->boardingHouse->primaryPhoto)

                    <img
                        src="{{ asset('storage/'.$rental->boardingHouse->primaryPhoto->photo_path) }}"
                        class="w-full h-full object-cover">

                @else

                    <div class="w-full h-full bg-cyan-950 flex items-center justify-center">
                        <i data-lucide="building-2" class="w-8 h-8 text-white"></i>
                    </div>

                @endif

            </div>

            <div>

                <h3 class="text-xl font-bold text-slate-900">
                    {{ $rental->boardingHouse->name }}
                </h3>

                <p class="text-gray-600">
                    {{ $rental->boardingHouse->type }}
                </p>

            </div>

        </div>

        <hr class="my-5">

        <div class="grid grid-cols-3 gap-6">

            <div>

                <p class="text-xs uppercase text-gray-500 font-semibold">
                    Start
                </p>

                <h4 class="font-semibold mt-1">
                    {{ \Carbon\Carbon::parse($rental->start_date)->translatedFormat('d M Y') }}
                </h4>

            </div>

            <div>

                <p class="text-xs uppercase text-gray-500 font-semibold">
                    End
                </p>

                <h4 class="font-semibold mt-1">
                    {{ \Carbon\Carbon::parse($rental->end_date)->translatedFormat('d M Y') }}
                </h4>

            </div>

            <div>

                <p class="text-xs uppercase text-gray-500 font-semibold">
                    Duration
                </p>

                <h4 class="font-semibold mt-1">
                    {{ $rental->duration_months }} Bulan
                </h4>

            </div>

        </div>

    </div>

</div>