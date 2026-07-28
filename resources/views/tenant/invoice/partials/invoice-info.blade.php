<div class="px-6 py-5 flex justify-between items-start">

    <div>

        <p class="text-xs uppercase tracking-wider text-gray-400 font-semibold">
            Invoice Number
        </p>

        <h3 class="text-xl font-semibold text-cyan-950 mt-1">
            {{ $rental->unique_code }}
        </h3>

    </div>

    <div class="text-right text-gray-600">

        {{ $rental->created_at->translatedFormat('d M Y, H:i') }} WIB

    </div>

</div>