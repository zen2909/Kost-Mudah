@extends('layouts.tenant')

@section('search-placeholder','Pembayaran')

@section('content')

<div class="max-w-4xl mx-auto py-10">

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">

        @include('tenant.payment.partials.header')

        @include('tenant.payment.partials.payment-info')

        @include('tenant.payment.partials.upload')

        @include('tenant.payment.partials.note')

        @include('tenant.payment.partials.footer')

    </div>

</div>

@endsection