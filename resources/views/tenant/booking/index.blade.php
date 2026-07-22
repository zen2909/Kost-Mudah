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