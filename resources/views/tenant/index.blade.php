@extends('layouts.tenant')

@section('search-placeholder','Dashboard Overview')

@section('content')

<div class="grid grid-cols-3 gap-6">

    {{-- Hero --}}
    <div class="col-span-2 bg-cyan-950 rounded-3xl p-10 text-white relative overflow-hidden">

        <h1 class="text-5xl font-bold mb-4">
            Halo, {{ Auth::user()->name }}! 👋
        </h1>

        <p class="text-slate-300 text-xl">
            Tagihan kost kamu untuk periode ini sudah siap dibayarkan.
            Jangan sampai telat ya!
        </p>

        <div class="mt-8 flex gap-4">

            <a href="{{ route('tenant.bills.index') }}"
                class="inline-flex items-center justify-center bg-sky-500 hover:bg-sky-600 px-6 py-3 rounded-xl font-semibold transition">

                Bayar Sekarang

            </a>

        </div>

    </div>

    {{-- Sewa Aktif --}}
    <div class="bg-white rounded-3xl border p-6">

        <h2 class="text-3xl font-bold mb-4">
            Sewa Aktif
        </h2>

        @if($activeRental)

            <div class="space-y-4">

                <div class="font-bold text-xl">
                    {{ $activeRental->boardingHouse->name }}
                </div>

                <div class="text-gray-500">
                    {{ $activeRental->boardingHouse->address }}
                </div>

                <hr>

                <div class="flex justify-between">

                    <div>

                        <div class="text-gray-500">
                            Sisa Masa Sewa
                        </div>

                        <div class="font-bold">

                            @php
                                $days = now()->diffInDays($activeRental->end_date,false);
                            @endphp

                            {{ $days > 0 ? $days.' Hari Lagi' : 'Berakhir' }}

                        </div>

                    </div>

                    <div class="text-right">

                        <div class="text-gray-500">
                            Tagihan
                        </div>

                        <div class="font-bold text-sky-500">

                            Rp{{ number_format($activeRental->total_price,0,',','.') }}

                        </div>

                    </div>

                </div>

                @if($activeRental)
                    <a href="{{ route('tenant.invoice.index', $activeRental) }}"
                        class="block w-full text-center bg-cyan-900 hover:bg-cyan-800 text-white py-3 rounded-xl font-semibold">
                        Lihat Invoice
                    </a>
                @else
                    <button
                        class="block w-full text-center bg-gray-300 text-gray-500 py-3 rounded-xl font-semibold cursor-not-allowed"
                        disabled>
                        Belum Ada Invoice
                    </button>
                @endif

            </div>

        @else

            <div class="flex flex-col justify-center items-center h-full py-10">

                <div class="text-5xl mb-4">
                    🏠
                </div>

                <div class="font-semibold text-lg">
                    Belum Ada Sewa Aktif
                </div>

                <p class="text-gray-500 text-center mt-2">
                    Yuk cari kost terbaik untukmu.
                </p>

                <a href="{{ route('tenant.kost.index') }}"
                    class="mt-6 bg-cyan-900 hover:bg-cyan-800 text-white px-5 py-3 rounded-xl">

                    Cari Kost

                </a>

            </div>

        @endif

    </div>

</div>

{{-- Rekomendasi --}}
<div class="mt-10 flex justify-between items-center">

    <h2 class="text-3xl font-bold">
        Untukmu
    </h2>

    <a href="{{ route('tenant.kost.index') }}"
        class="text-sky-500 font-semibold">

        Lihat Semua →

    </a>

</div>

<div class="grid lg:grid-cols-2 gap-6 mt-6">

    @forelse($recommendations as $kost)

        @include('tenant.kost.card', [
            'kost' => $kost
        ])

    @empty

        <div class="col-span-2">
            <div class="bg-white rounded-xl border p-10 text-center">

                <h3 class="text-2xl font-bold">
                    Belum ada rekomendasi kost.
                </h3>

            </div>
        </div>

    @endforelse

</div>

@endsection
