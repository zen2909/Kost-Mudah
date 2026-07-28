<div class="px-6">

    <h3 class="text-sm uppercase tracking-wide font-bold text-cyan-950 mb-4">

        Pricing Summary

    </h3>

    <div class="space-y-3">

        <div class="flex justify-between">

            <span class="text-gray-600">
                Monthly Rent
            </span>

            <span class="font-semibold">
                Rp {{ number_format($rental->boardingHouse->price,0,',','.') }}
            </span>

        </div>

        <div class="flex justify-between">

            <span class="text-gray-600">
                Service Fee
            </span>

            <span class="font-semibold">
                Rp 0
            </span>

        </div>

    </div>

    <hr class="my-5 border-dashed">

    <div class="flex justify-between items-center">

        <h3 class="text-2xl font-bold">

            Total Amount

        </h3>

        <h2 class="text-4xl font-bold text-cyan-950">

            Rp {{ number_format($rental->total_price,0,',','.') }}

        </h2>

    </div>

</div>