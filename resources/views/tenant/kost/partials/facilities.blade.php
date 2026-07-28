<div class="mb-10">

    <h2 class="text-2xl font-bold text-slate-900 mb-6">

        Fasilitas Kamar & Kost

    </h2>

    @if(!empty($kost->facilities))

        <div class="grid grid-cols-2 md:grid-cols-4 gap-5">

            @foreach($kost->facilities as $facility)

                <div
                    class="bg-gray-100 rounded-xl p-5 text-center hover:bg-cyan-950 hover:text-white transition-all duration-300 group">

                    <div class="flex justify-center mb-4">

                        <i
                            data-lucide="check-circle"
                            class="w-8 h-8 text-slate-700 group-hover:text-white">
                        </i>

                    </div>

                    <h3 class="font-semibold">

                        {{ $facility }}

                    </h3>

                </div>

            @endforeach

        </div>

    @else

        <div class="bg-gray-100 rounded-xl p-6 text-center text-gray-500">

            Fasilitas belum tersedia.

        </div>

    @endif

</div>