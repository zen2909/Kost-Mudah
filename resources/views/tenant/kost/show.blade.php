@extends('layouts.tenant')

@section('search-placeholder','Cari kost...')

@section('content')

@include('tenant.kost.partials.gallery')

<div class="grid lg:grid-cols-3 gap-8 mt-10">

    <div class="lg:col-span-2">

        @include('tenant.kost.partials.info')

        @include('tenant.kost.partials.facilities')

        @include('tenant.kost.partials.rules')

    </div>

    <div class="space-y-6">

        @include('tenant.kost.partials.booking-card')
        
    </div>

</div>

@endsection