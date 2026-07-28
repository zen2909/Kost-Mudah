@extends('layouts.tenant')

@section('search-placeholder','Cari Kost')

@section('content')

{{-- Hero --}}
<div class="mb-8">

    <h1 class="text-4xl font-bold text-slate-900">
        Temukan Kost Impianmu
    </h1>

    <p class="text-gray-600 mt-2">
        Ribuan pilihan kost terbaik tersedia untukmu.
    </p>

</div>

{{-- Filter --}}
@include('tenant.kost.filter')

{{-- Header --}}
<div class="flex flex-col md:flex-row md:justify-between md:items-center mt-10 mb-6 gap-4">

    <div>

        <h2 class="text-2xl font-bold">

            Hasil Pencarian

            <span class="text-gray-500 text-lg font-normal">

                ({{ $kosts->total() }} Kost ditemukan)

            </span>

        </h2>

    </div>

    {{-- Sorting --}}
    <form method="GET">

        {{-- mempertahankan filter --}}
        <input type="hidden" name="search" value="{{ request('search') }}">
        <input type="hidden" name="kelurahan" value="{{ request('kelurahan') }}">
        <input type="hidden" name="type" value="{{ request('type') }}">
        <input type="hidden" name="price" value="{{ request('price') }}">

        <div class="flex items-center gap-3">

            <span class="text-gray-500">

                Urutkan

            </span>

            <select
                name="sort"
                onchange="this.form.submit()"
                class="border rounded-lg px-4 py-2">

                <option value=""
                    {{ request('sort')=='' ? 'selected' : '' }}>
                    Terbaru
                </option>

                <option
                    value="price_low"
                    {{ request('sort')=='price_low' ? 'selected' : '' }}>
                    Harga Terendah
                </option>

                <option
                    value="price_high"
                    {{ request('sort')=='price_high' ? 'selected' : '' }}>
                    Harga Tertinggi
                </option>

                <option
                    value="name"
                    {{ request('sort')=='name' ? 'selected' : '' }}>
                    Nama A-Z
                </option>

            </select>

        </div>

    </form>

</div>

{{-- Grid Kost --}}
<div class="grid lg:grid-cols-3 md:grid-cols-2 gap-6">

    @forelse($kosts as $kost)

        @include('tenant.kost.card', [
            'kost' => $kost
        ])

    @empty

        <div class="col-span-3">

            <div class="bg-white rounded-xl border p-10 text-center">

                <div class="text-6xl mb-4">
                    🏠
                </div>

                <h2 class="text-2xl font-bold text-gray-700">

                    Kost tidak ditemukan

                </h2>

                <p class="text-gray-500 mt-2">

                    Coba ubah kata kunci pencarian atau filter.

                </p>

                <a
                    href="{{ route('tenant.kost.index') }}"
                    class="inline-block mt-6 bg-cyan-900 hover:bg-cyan-800 text-white px-6 py-3 rounded-lg">

                    Reset Pencarian

                </a>

            </div>

        </div>

    @endforelse

</div>

{{-- Pagination --}}
@if($kosts->hasPages())

<div class="mt-10">

    {{ $kosts->links() }}

</div>

@endif

@endsection
