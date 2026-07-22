@extends('layouts.tenant')

@section('search-placeholder','Riwayat Penyewaan')

@section('content')

@include('tenant.riwayat.partials.header')

@include('tenant.riwayat.partials.summary')

@include('tenant.riwayat.partials.table')

<div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mt-8">

    <div class="lg:col-span-3">

        @include('tenant.riwayat.partials.helpdesk')

    </div>

    <div>

        @include('tenant.riwayat.partials.security')

    </div>

</div>

@endsection