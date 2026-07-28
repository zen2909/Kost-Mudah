<div class="bg-white border border-gray-200 rounded-b-xl px-6 py-6">

<form
    action="{{ route('tenant.booking.store') }}"
    method="POST"
    id="bookingForm">

    @csrf

    <input
        type="hidden"
        name="boarding_house_id"
        value="{{ $kost->id }}">

    <input
        type="hidden"
        name="duration_months"
        id="duration_months"
        value="1">

    <input
        type="hidden"
        name="start_date"
        id="booking_start_date"
        value="{{ now()->toDateString() }}">

    <input
        type="hidden"
        name="total_price"
        id="booking_total_price"
        value="{{ $kost->price_per_month }}">

    <button
        type="submit"
        class="w-full bg-cyan-950 hover:bg-cyan-900 text-white py-5 rounded-xl text-xl font-semibold transition">

        Lanjutkan ke Pembayaran

    </button>

</form>

    <p class="text-center text-gray-500 mt-6">

        Dengan menekan tombol di atas, Anda menyetujui

        <a
            href="#"
            class="underline">

            Syarat & Ketentuan

        </a>

        penyewaan KostMudah.

    </p>

</div>