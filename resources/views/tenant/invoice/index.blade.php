@extends('layouts.tenant')

@section('search-placeholder','Invoice')

@section('content')

<div class="fixed inset-0 bg-black/40 backdrop-blur-sm flex justify-center items-center z-50">

    <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl overflow-hidden">

        @include('tenant.invoice.partials.header')

        @include('tenant.invoice.partials.invoice-info')

        @include('tenant.invoice.partials.property')

        @include('tenant.invoice.partials.pricing')

        @include('tenant.invoice.partials.status')

        @include('tenant.invoice.partials.proof')

        @include('tenant.invoice.partials.footer')

    </div>

</div>

@endsection