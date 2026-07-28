<div class="px-6 py-6">

    <div class="grid grid-cols-2 gap-4">

        {{-- Status --}}
        <div class="bg-slate-100 rounded-xl p-4">

            <p class="uppercase text-xs text-gray-500 font-bold">
                Status
            </p>

            <div class="flex items-center gap-2 mt-3">

                @php
                    $status = $rental->payment->status ?? 'pending';
                @endphp

                @if($status == 'completed')
                    <span class="w-3 h-3 rounded-full bg-green-500"></span>
                    <span class="font-bold text-green-600">Completed</span>

                @elseif($status == 'pending')
                    <span class="w-3 h-3 rounded-full bg-yellow-500"></span>
                    <span class="font-bold text-yellow-600">Pending</span>

                @else
                    <span class="w-3 h-3 rounded-full bg-red-500"></span>
                    <span class="font-bold text-red-600">Rejected</span>
                @endif

            </div>

        </div>

        {{-- Metode Pembayaran --}}
        <div class="bg-slate-100 rounded-xl p-4">

            <p class="uppercase text-xs text-gray-500 font-bold">
                Method
            </p>

            <h4 class="font-bold text-cyan-950 mt-3">

                @if($rental->payment)

                    @switch($rental->payment->method)

                        @case('bank_transfer')
                            Bank Transfer
                            @break

                        @case('qris')
                            QRIS
                            @break

                        @case('ewallet')
                            E-Wallet
                            @break

                        @default
                            -
                    @endswitch

                @else

                    Belum ada pembayaran

                @endif

            </h4>

        </div>

    </div>

</div>