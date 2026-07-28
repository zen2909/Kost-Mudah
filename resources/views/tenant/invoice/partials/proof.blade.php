@php
use Illuminate\Support\Str;
@endphp

<div class="px-6">

    <h3 class="text-sm uppercase font-bold text-cyan-950 mb-4">
        Bukti Transfer
    </h3>

    @if($rental->payment && $rental->payment->proof_path)

        @if(Str::endsWith($rental->payment->proof_path, '.pdf'))

            <embed
                src="{{ asset('storage/'.$rental->payment->proof_path) }}"
                type="application/pdf"
                class="rounded-xl border w-full h-[500px]">

        @else

            <img
                src="{{ asset('storage/'.$rental->payment->proof_path) }}"
                class="rounded-xl border w-full object-cover">

        @endif

    @else

        <div class="rounded-xl border h-64 flex items-center justify-center text-gray-400">
            Bukti pembayaran belum tersedia.
        </div>

    @endif

</div>