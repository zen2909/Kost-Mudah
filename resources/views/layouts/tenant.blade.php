<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KostMudah - Tenant</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="bg-gray-50">
    <script src="https://unpkg.com/lucide@latest"></script>

<script>
    lucide.createIcons();
</script>
<div class="flex min-h-screen">
<aside class="w-64 bg-cyan-950 text-white flex flex-col justify-between">
<div>
<div class="p-6 flex items-center gap-3">

    <div
        class="w-10 h-10 rounded-lg bg-sky-500 flex items-center justify-center">

        <i data-lucide="building-2"
            class="w-6 h-6 text-white">
        </i>

    </div>

    <div>

        <h1 class="text-xl font-bold text-white">
            KostMudah
        </h1>

        <p class="text-slate-400 text-[10px] uppercase tracking-widest">
            MANAGEMENT
        </p>

    </div>

</div>
<nav class="px-4 space-y-2">

    <!-- Dashboard -->
    <a href="{{ route('tenant.dashboard') }}"
        class="flex items-center gap-3 px-4 py-3 rounded-lg transition
        {{ request()->routeIs('tenant.dashboard')
            ? 'bg-white/10 text-white font-bold'
            : 'text-slate-400 hover:bg-white/10 hover:text-white' }}">

        <i data-lucide="layout-dashboard" class="w-5 h-5"></i>

        <span>Dashboard</span>

    </a>

    <!-- Cari Kost -->
    <a href="{{ route('tenant.kost.index') }}"
        class="flex items-center gap-3 px-4 py-3 rounded-lg transition
        {{ request()->routeIs('tenant.kost.*')
            ? 'bg-white/10 text-white font-bold'
            : 'text-slate-400 hover:bg-white/10 hover:text-white' }}">

        <i data-lucide="search" class="w-5 h-5"></i>

        <span>Cari Kost</span>

    </a>

    <!-- Favorit -->
    <a href="{{ route('tenant.favorit.index') }}"
        class="flex items-center gap-3 px-4 py-3 rounded-lg transition
        {{ request()->routeIs('tenant.favorit.*')
            ? 'bg-white/10 text-white font-bold'
            : 'text-slate-400 hover:bg-white/10 hover:text-white' }}">

        <i data-lucide="heart" class="w-5 h-5"></i>

        <span>Favorit Saya</span>

    </a>

    <!-- Riwayat -->
    <a href="{{ route('tenant.riwayat.index') }}"
        class="flex items-center gap-3 px-4 py-3 rounded-lg transition
        {{ request()->routeIs('tenant.riwayat.*')
        ? 'bg-white/10 text-white font-bold'
        : 'text-slate-400 hover:bg-white/10 hover:text-white' }}">

            <i data-lucide="history" class="w-5 h-5"></i>

            <span>Riwayat Sewa</span>

    </a>

    <!-- Profil -->
    <a href="{{ route('tenant.profile.index') }}"
        class="flex items-center gap-3 px-4 py-3 rounded-lg transition
        {{ request()->routeIs('tenant.profile.*')
        ? 'bg-white/10 text-white font-bold'
        : 'text-slate-400 hover:bg-white/10 hover:text-white' }}">

            <i data-lucide="user-round" class="w-5 h-5"></i>

            <span>Profil Saya</span>

    </a>
    <!-- Tagihan -->
    <!-- Tagihan Saya -->
    <a href="{{ route('tenant.bills.index') }}"
        class="flex items-center gap-3 px-4 py-3 rounded-lg transition
        {{ request()->routeIs('tenant.bills.*')
            ? 'bg-white/10 text-white font-bold'
            : 'text-slate-400 hover:bg-white/10 hover:text-white' }}">

        <i data-lucide="receipt-text" class="w-5 h-5"></i>

        <span>Tagihan Saya</span>

    </a>

</nav>
</div>
<div class="p-6 border-t border-slate-700">
<form method="POST" action="{{ route('logout') }}">
    @csrf

    <button
        type="submit"
        class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-slate-400 hover:bg-red-600 hover:text-white transition">

        <i data-lucide="log-out" class="w-5 h-5"></i>

        <span>Logout</span>

    </button>
</form>
</div>
</aside>
<div class="flex-1">
<header class="bg-white border-b border-gray-200 px-8 py-4 flex justify-between items-center">

    {{-- Search --}}
    <div class="w-full max-w-xl">

        <div class="relative">

            <i
                data-lucide="search"
                class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-500">
            </i>

            <input
                type="text"
                placeholder="@yield('search-placeholder','Cari...')"
                class="w-full pl-12 pr-4 py-3 bg-gray-100 rounded-full border border-transparent
                       focus:border-cyan-900 focus:ring-2 focus:ring-cyan-900/20 outline-none">

        </div>

    </div>

    {{-- Right --}}
    <div class="flex items-center gap-6 ml-8">

        {{-- Notification --}}
        <button class="relative">

            <i
                data-lucide="bell"
                class="w-7 h-7 text-gray-700">
            </i>

            <span
                class="absolute top-0 right-0 w-2 h-2 rounded-full bg-red-500">
            </span>

        </button>

        <div class="h-10 border-l border-gray-300"></div>

        {{-- Avatar --}}
        <img
            src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0EA5E9&color=fff"
            class="w-12 h-12 rounded-full border-2 border-cyan-900">

    </div>

</header>
<main class="p-8">
@yield('content')
</main>
</div>
</div>
</body>
</html>
