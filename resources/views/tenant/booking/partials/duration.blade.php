<div class="bg-white border-x border-gray-200 px-6 pb-6">

    <h3 class="font-bold text-2xl mb-5">

        Pilih Durasi Sewa

    </h3>

    <div class="grid grid-cols-2 gap-5">

        @foreach([1,3,6,12] as $bulan)

            <button
                type="button"
                class="duration-btn {{ $bulan == 1 ? 'border-2 border-cyan-950 bg-cyan-50' : 'border' }} rounded-xl py-8 hover:border-cyan-950 hover:bg-cyan-50 transition"
                data-month="{{ $bulan }}">

                <div class="text-3xl font-bold">

                    {{ $bulan }} Bulan

                </div>

                <div class="mt-2
                    @if($bulan == 1)
                        text-gray-500
                    @else
                        text-green-600
                    @endif">

                    @switch($bulan)

                        @case(3)
                            Hemat 2%
                            @break

                        @case(6)
                            Hemat 5%
                            @break

                        @case(12)
                            Hemat 10%
                            @break

                        @default
                            Reguler

                    @endswitch

                </div>

            </button>

        @endforeach

    </div>

</div>