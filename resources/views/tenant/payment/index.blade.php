@extends('layouts.tenant')

@section('search-placeholder','Pembayaran')

@section('content')

<div x-data="{ metode: 'bank_transfer' }" class="max-w-4xl mx-auto py-10">

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">

        @include('tenant.payment.partials.header')

        @include('tenant.payment.partials.payment-info')

        <form
            id="paymentForm"
            action="{{ route('tenant.payment.store', $rental) }}"
            method="POST"
            enctype="multipart/form-data">

            @csrf

            <input
                type="hidden"
                name="method"
                x-model="metode">

            @include('tenant.payment.partials.upload')

            @include('tenant.payment.partials.note')

            @include('tenant.payment.partials.footer')

        </form>

    </div>

</div>

@endsection

@push('scripts')
<script>
function previewFile(event) {

    const file = event.target.files[0];
    if (!file) return;

    const image = document.getElementById('previewImage');
    const pdf = document.getElementById('previewPdf');
    const fileName = document.getElementById('fileName');

    image.classList.add('hidden');
    pdf.classList.add('hidden');

    fileName.textContent = file.name;
    fileName.classList.remove('hidden');

    if (file.type === 'application/pdf') {

        pdf.src = URL.createObjectURL(file);
        pdf.classList.remove('hidden');

    } else {

        image.src = URL.createObjectURL(file);
        image.classList.remove('hidden');

    }
}
</script>
@endpush