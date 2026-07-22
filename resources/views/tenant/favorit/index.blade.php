@extends('layouts.tenant')

@section('search-placeholder','Favorit Saya')

@section('content')

<div class="mb-8">

    <h1 class="text-4xl font-bold text-slate-900">
        Kost Favorit Saya
    </h1>

    <p class="text-gray-600 mt-2">
        Daftar kost yang telah Anda simpan untuk memudahkan pencarian di kemudian hari.
    </p>

</div>

<div class="grid lg:grid-cols-3 md:grid-cols-2 gap-6">

    @php

        $kosts = collect(range(1,4))->map(function(){

            return (object)[

                'nama'=>'Kost Menteng Residence',

                'lokasi'=>'Menteng, Jakarta Pusat',

                'rating'=>'4.8',

                'harga'=>'Rp 3.500.000',

                'badge'=>'verified',

                'gambar'=>'https://placehold.co/600x400'

            ];

        });

    @endphp

    @foreach($kosts as $kost)

        @include('tenant.kost.card', ['kost'=>$kost])

    @endforeach

</div>

@endsection