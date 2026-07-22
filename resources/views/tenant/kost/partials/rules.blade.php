<div class="bg-gray-100 rounded-xl border-l-4 border-cyan-950 p-6 mb-10">

    {{-- Header --}}
    <div class="flex items-center gap-3 mb-6">

        <i
            data-lucide="shield-alert"
            class="w-6 h-6 text-cyan-950">
        </i>

        <h2
            class="text-2xl font-bold text-slate-900">

            Peraturan Kost

        </h2>

    </div>

    @php

        $rules = [

            [
                'icon'=>'cigarette-off',
                'text'=>'Dilarang merokok di dalam kamar',
                'color'=>'text-red-600'
            ],

            [
                'icon'=>'paw-print',
                'text'=>'Tidak diperbolehkan membawa hewan peliharaan',
                'color'=>'text-red-600'
            ],

            [
                'icon'=>'clock-3',
                'text'=>'Akses tamu hingga pukul 22.00',
                'color'=>'text-slate-700'
            ],

            [
                'icon'=>'key-round',
                'text'=>'Akses penghuni 24 jam (Free Keycard)',
                'color'=>'text-slate-700'
            ],

        ];

    @endphp

    <div class="grid md:grid-cols-2 gap-5">

        @foreach($rules as $rule)

            <div
                class="flex items-start gap-4">

                <i
                    data-lucide="{{ $rule['icon'] }}"
                    class="w-6 h-6 {{ $rule['color'] }}">
                </i>

                <span
                    class="text-gray-700 leading-7">

                    {{ $rule['text'] }}

                </span>

            </div>

        @endforeach

    </div>

</div>