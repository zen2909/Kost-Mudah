@extends('layouts.tenant')

@section('search-placeholder','Cari Kost')

@section('content')

{{-- Hero --}}
<div class="mb-8">

    <h1 class="text-4xl font-bold text-slate-900">
        Temukan Kost Impianmu
    </h1>

    <p class="text-gray-600 mt-2">
        Ribuan pilihan hunian nyaman menantimu di berbagai lokasi strategis.
    </p>

</div>

{{-- Filter --}}
@include('tenant.kost.filter')

{{-- Header --}}
<div class="flex justify-between items-center mt-10 mb-6">

    <div>

        <h2 class="text-2xl font-bold">

            Hasil Pencarian

            <span class="text-gray-500 text-lg font-normal">

                (124 Kost ditemukan)

            </span>

        </h2>

    </div>

    <div class="flex items-center gap-2">

        <span class="text-gray-500">

            Urutkan:

        </span>

        <select class="border rounded-lg px-3 py-2">

            <option>Terpopuler</option>

            <option>Harga Terendah</option>

            <option>Harga Tertinggi</option>

        </select>

    </div>

</div>

{{-- Grid Card --}}
<div class="grid lg:grid-cols-3 md:grid-cols-2 gap-6">

    @php

        $kosts = collect(range(1,6))->map(function(){

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

        @include('tenant.kost.card',['kost'=>$kost])

    @endforeach

</div>

{{-- Pagination --}}
<div class="mt-10">

    @include('tenant.kost.pagination')

</div>

@endsection