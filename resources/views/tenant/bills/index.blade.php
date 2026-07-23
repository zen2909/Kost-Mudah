@extends('layouts.tenant')

@section('search-placeholder','Cari Tagihan')

@section('content')

<div class="space-y-6">

    @include('tenant.bills.partials.header')

    @include('tenant.bills.partials.summary')

    @include('tenant.bills.partials.current-bill')

    @include('tenant.bills.partials.history')

</div>

@endsection