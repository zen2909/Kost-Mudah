@extends('layouts.tenant')

@section('search-placeholder','Dashboard Overview')

@section('content')
<div class="grid grid-cols-3 gap-6">
<div class="col-span-2 bg-cyan-950 rounded-3xl p-10 text-white relative overflow-hidden">
<h1 class="text-5xl font-bold mb-4">Halo, {{ Auth::user()->name }}! 👋</h1>
<p class="text-slate-300 text-xl">Tagihan kost kamu untuk periode ini sudah siap dibayarkan. Jangan sampai telat ya!</p>
<div class="mt-8 flex gap-4">

            <a href="{{ route('tenant.bills.index') }}"
                class="inline-flex items-center justify-center bg-sky-500 hover:bg-sky-600 px-6 py-3 rounded-xl font-semibold transition">

                Bayar Sekarang

            </a>

        </div>
</div>

<div class="bg-white rounded-3xl border p-6">
<h2 class="text-3xl font-bold mb-4">Sewa Aktif</h2>
<div class="space-y-3">
<div class="font-bold text-xl">Kost Mentari Sudirman</div>
<div class="text-gray-500">Jakarta Pusat</div>
<hr>
<div class="flex justify-between">
<div><div class="text-gray-500">Sisa Masa Sewa</div><div class="font-bold">12 Hari Lagi</div></div>
<div><div class="text-gray-500">Tagihan</div><div class="font-bold text-sky-500">Rp2.500.000</div></div>
</div>
<button class="w-full mt-5 py-3 font-semibold">Perpanjang Sewa</button>
</div>
</div>
</div>

<div class="mt-10 flex justify-between items-center">
<h2 class="text-3xl font-bold">Untukmu</h2>
<a href="#" class="text-sky-500 font-semibold">Lihat Semua →</a>
</div>

<div class="grid md:grid-cols-2 gap-6 mt-6">

@for($i=0;$i<2;$i++)

<div class="bg-white rounded-2xl shadow hover:shadow-xl transition overflow-hidden">

    <!-- Gambar -->
    <div class="relative">

        <img
            src="https://placehold.co/600x350"
            class="w-full h-56 object-cover">

        <!-- Badge -->
        <span
            class="absolute top-3 left-3 bg-green-500 text-white text-xs px-3 py-1 rounded-full font-semibold">
            Terverifikasi
        </span>

        <!-- Favorite -->
        <button
            class="absolute top-3 right-3 w-10 h-10 rounded-full bg-white/30 backdrop-blur flex items-center justify-center">

            <i data-lucide="heart"
                class="w-5 h-5 text-white">
            </i>

        </button>

    </div>

    <!-- Konten -->
    <div class="p-5">

        <div class="flex justify-between">

            <div>

                <h3 class="text-xl font-bold">

                    {{ $i==0 ? 'Kost Green Emerald' : 'Kost Kemang 21' }}

                </h3>

                <div class="flex items-center gap-1 text-gray-500 mt-1">

                    <i data-lucide="map-pin" class="w-4 h-4"></i>

                    {{ $i==0 ? 'Setiabudi, Jakarta Selatan' : 'Kemang, Jakarta Selatan' }}

                </div>

            </div>

            <div class="flex items-center gap-1 text-yellow-500">

                <i data-lucide="star" class="w-4 h-4 fill-yellow-400"></i>

                <span class="font-semibold">4.9</span>

            </div>

        </div>

        <!-- Fasilitas -->
        <div class="flex flex-wrap gap-2 mt-5">

            <span class="flex items-center gap-1 bg-slate-100 px-3 py-1 rounded-full text-xs">

                <i data-lucide="wifi" class="w-4 h-4"></i>

                WiFi

            </span>

            <span class="flex items-center gap-1 bg-slate-100 px-3 py-1 rounded-full text-xs">

                <i data-lucide="snowflake" class="w-4 h-4"></i>

                AC

            </span>

            <span class="flex items-center gap-1 bg-slate-100 px-3 py-1 rounded-full text-xs">

                <i data-lucide="car" class="w-4 h-4"></i>

                Parkir

            </span>

            <span class="flex items-center gap-1 bg-slate-100 px-3 py-1 rounded-full text-xs">

                <i data-lucide="bath" class="w-4 h-4"></i>

                KM Dalam

            </span>

        </div>

        <!-- Harga -->
        <div class="flex justify-between items-center mt-6">

            <div>

                <p class="text-2xl font-bold text-cyan-900">

                    {{ $i==0 ? 'Rp2.800.000' : 'Rp3.500.000' }}

                </p>

                <p class="text-sm text-gray-500">
                    /bulan
                </p>

            </div>

            <a href="#"
                class="bg-cyan-900 hover:bg-cyan-800 text-white px-5 py-2 rounded-lg font-semibold">

                Lihat Detail

            </a>

        </div>

    </div>

</div>

@endfor

</div>
@endsection
