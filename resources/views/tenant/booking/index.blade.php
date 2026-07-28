@extends('layouts.tenant')

@section('search-placeholder','Cari kost...')

@section('content')

<div class="max-w-3xl mx-auto py-8">

    @include('tenant.booking.partials.header')

    @include('tenant.booking.partials.kost-info')

    @include('tenant.booking.partials.duration')

    @include('tenant.booking.partials.start-date')

    @include('tenant.booking.partials.summary')

    @include('tenant.booking.partials.action')

</div>

@endsection

@push('scripts')
<script>

document.addEventListener('DOMContentLoaded', function () {

    // ===========================
    // Harga & Durasi
    // ===========================

    const priceElement = document.getElementById('price');

    if (!priceElement) return;

    const price = Number(priceElement.dataset.price);

    const durationText = document.getElementById('durationText');
    const totalPrice = document.getElementById('totalPrice');

    const durationInput = document.getElementById('duration_months');
const totalInput = document.getElementById('booking_total_price');
const startDateInput = document.getElementById('booking_start_date');

    document.querySelectorAll('.duration-btn').forEach(button => {

        button.addEventListener('click', function () {

            document.querySelectorAll('.duration-btn').forEach(btn => {

                btn.classList.remove(
                    'border-cyan-950',
                    'bg-cyan-50'
                );

                btn.classList.add('border');

            });

            this.classList.remove('border');

            this.classList.add(
                'border-cyan-950',
                'bg-cyan-50'
            );

            const month = parseInt(this.dataset.month);

            durationText.innerText = month + ' Bulan';

            let total = price * month;

            if (month === 3) {
                total *= 0.98;
            } else if (month === 6) {
                total *= 0.95;
            } else if (month === 12) {
                total *= 0.90;
            }

            totalPrice.innerText =
    'Rp' + Math.round(total).toLocaleString('id-ID');

durationInput.value = month;
totalInput.value = Math.round(total);

        });

    });

    // ===========================
    // Tanggal Mulai Sewa
    // ===========================
// ===========================
// Tanggal Mulai Sewa
// ===========================

const startDate = document.getElementById('start_date');
const startDateText = document.getElementById('startDateText');
const calendarButton = document.getElementById('calendarButton');

if (calendarButton && startDate) {

    calendarButton.addEventListener('click', function () {

        if (startDate.showPicker) {
            startDate.showPicker();
        } else {
            startDate.focus();
            startDate.click();
        }

    });

}

if (startDate && startDateText) {

    function formatTanggal(tanggal) {

        if (!tanggal) return '';

        return new Date(tanggal).toLocaleDateString('id-ID', {
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        });

    }

    startDateText.innerText = formatTanggal(startDate.value);

    startDate.addEventListener('change', function () {

        startDateText.innerText = formatTanggal(this.value);
        startDateInput.value = this.value;

    });

}

});
</script>
@endpush