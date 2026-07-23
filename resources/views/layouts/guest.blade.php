<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'KostMudah - Cari Kost di Surabaya Timur Jadi Lebih Mudah')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon-16x16.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-32x32.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('images/android-chrome-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="512x512" href="{{ asset('images/android-chrome-512x512.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">
    @stack('styles')
</head>

<body>

    <!-- ============================================================ -->
    <!-- NAVBAR -->
    <!-- ============================================================ -->
    <nav
        class="w-full px-6 py-4 bg-gray-50/80 backdrop-blur-[6px] border-b border-neutral-300 shadow-[0px_1px_2px_0px_rgba(0,0,0,0.05)] fixed top-0 left-0 z-50">
        <div class="max-w-[1280px] mx-auto flex justify-between items-center">
            <!-- Logo -->
            <a href="{{ route('guest.home') }}" class="flex items-center gap-2">
                <img src="{{ asset('images/logo-nobg.png') }}" alt="logo-aplikasi" class="w-8 h-8 object-contain">
                <span class="text-slate-950 text-xl font-black">KostMudah</span>
            </a>

            <!-- Tombol Auth -->
            <div class="flex items-center gap-4">
                @guest
                    <a href="{{ route('login') }}"
                        class="px-5 py-2 rounded-lg text-slate-950 text-base font-semibold hover:bg-gray-200 transition">Login</a>
                    <a href="{{ route('register') }}"
                        class="px-5 py-2 bg-cyan-950 rounded-lg text-white text-base font-semibold hover:bg-cyan-900 transition shadow-md">Register</a>
                @else
                    @if (Auth::user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}"
                            class="px-5 py-2 bg-cyan-950 rounded-lg text-white text-base font-semibold hover:bg-cyan-900 transition">Dashboard</a>
                    @elseif(Auth::user()->isOwner())
                        <a href="{{ route('owner.dashboard') }}"
                            class="px-5 py-2 bg-cyan-950 rounded-lg text-white text-base font-semibold hover:bg-cyan-900 transition">Dashboard</a>
                    @elseif(Auth::user()->isTenant())
                        <a href="{{ route('tenant.dashboard') }}"
                            class="px-5 py-2 bg-cyan-950 rounded-lg text-white text-base font-semibold hover:bg-cyan-900 transition">Dashboard</a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                            class="px-5 py-2 bg-red-500 rounded-lg text-white text-base font-semibold hover:bg-red-600 transition">Logout</button>
                    </form>
                @endguest
            </div>
        </div>
    </nav>

    <!-- Content -->
    @yield('content')

    <!-- ============================================================ -->
    <!-- FOOTER -->
    <!-- ============================================================ -->
    <footer class="w-full px-6 py-8 bg-zinc-200 border-t border-neutral-300">
        <div class="max-w-[1280px] mx-auto flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-zinc-700 text-sm">© 2024 KostMudah Management System. All rights reserved.</p>
            <div class="flex items-center gap-8">
                <a href="{{ route('guest.home') }}"
                    class="text-zinc-700 text-sm hover:text-slate-950 transition">Beranda</a>
                <a href="mailto:support@kostmudah.com"
                    class="text-zinc-700 text-sm hover:text-slate-950 transition">Contact Support</a>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>

</html>
