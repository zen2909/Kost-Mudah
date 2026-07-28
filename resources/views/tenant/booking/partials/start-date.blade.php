<div class="bg-white border-x border-gray-200 px-6 pb-6">

    <h3 class="text-2xl font-bold mb-4">
        Tanggal Mulai Sewa
    </h3>

    <div class="relative">

        <input
            type="date"
            id="start_date"
            name="start_date"
            min="{{ now()->toDateString() }}"
            value="{{ now()->toDateString() }}"
            class="w-full rounded-xl border border-gray-300 px-5 py-4 pr-14 text-lg focus:ring-2 focus:ring-cyan-900 focus:border-cyan-900">

        <button
            type="button"
            id="calendarButton"
            class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 hover:text-cyan-900">

            <i
                data-lucide="calendar"
                class="w-6 h-6">
            </i>

        </button>

    </div>

    <p class="mt-3 text-gray-500">
        Check-in dapat dilakukan mulai pukul <b>14.00 WIB</b>.
    </p>

</div>