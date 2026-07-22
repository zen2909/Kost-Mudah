<div class="mb-10">

    <h2 class="text-2xl font-bold text-slate-900 mb-6">

        Fasilitas Kamar & Kost

    </h2>

    @php

        $fasilitas = [

            ['icon'=>'wifi','nama'=>'WiFi','detail'=>'100 Mbps'],

            ['icon'=>'snowflake','nama'=>'AC','detail'=>'1 PK'],

            ['icon'=>'bath','nama'=>'KM Dalam','detail'=>'Private'],

            ['icon'=>'shirt','nama'=>'Laundry','detail'=>'Tersedia'],

            ['icon'=>'car','nama'=>'Parkir','detail'=>'Mobil'],

            ['icon'=>'shield-check','nama'=>'CCTV','detail'=>'24 Jam'],

            ['icon'=>'desk','nama'=>'Meja & Kursi','detail'=>'Lengkap'],

            ['icon'=>'zap','nama'=>'Listrik','detail'=>'Sudah Termasuk']

        ];

    @endphp

    <div class="grid grid-cols-2 md:grid-cols-4 gap-5">

        @foreach($fasilitas as $item)

            <div
                class="bg-gray-100 rounded-xl p-5 text-center hover:bg-cyan-950 hover:text-white transition-all duration-300 group">

                <div
                    class="flex justify-center mb-4">

                    <i
                        data-lucide="{{ $item['icon'] }}"
                        class="w-8 h-8 text-slate-700 group-hover:text-white">
                    </i>

                </div>

                <h3
                    class="font-semibold">

                    {{ $item['nama'] }}

                </h3>

                <p
                    class="text-sm text-gray-500 group-hover:text-gray-200 mt-1">

                    {{ $item['detail'] }}

                </p>

            </div>

        @endforeach

    </div>

</div>