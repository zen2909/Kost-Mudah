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

    @if(!empty($kost->rules))

        @php
            $rules = preg_split('/\r\n|\r|\n/', $kost->rules);
        @endphp

        <div class="grid md:grid-cols-2 gap-5">

            @foreach($rules as $rule)

                @if(trim($rule) != '')

                    <div class="flex items-start gap-4">

                        <i
                            data-lucide="badge-check"
                            class="w-6 h-6 text-cyan-950">
                        </i>

                        <span
                            class="text-gray-700 leading-7">

                            {{ trim($rule) }}

                        </span>

                    </div>

                @endif

            @endforeach

        </div>

    @else

        <div class="text-center text-gray-500 py-6">

            Belum ada peraturan kost.

        </div>

    @endif

</div>