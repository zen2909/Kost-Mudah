<aside id="sidebar"
    class="fixed top-0 left-0 h-full bg-[#06283D] overflow-y-auto overflow-x-hidden transition-all duration-300 ease-in-out z-50 group"
    style="box-shadow: 0px 2px 4px -2px rgba(0, 0, 0, 0.10), 0px 4px 6px -1px rgba(0, 0, 0, 0.10); width: 263px;">

    <!-- Logo -->
    <div class="px-4 py-6 border-b border-white/10">
        <div class="flex items-center gap-3">
            <!-- Logo Image Container -->
            <div id="logoContainer"
                class="flex-shrink-0 flex items-center justify-center transition-all duration-300 w-14 h-14 p-2 bg-white rounded-xl">
                <img src="{{ asset('images/logo-nobg.png') }}" alt="KostMudah"
                    class="w-full h-full object-contain transition-all duration-300">
            </div>
            <!-- Logo Text -->
            <div class="logo-text transition-all duration-300 overflow-hidden whitespace-nowrap" style="min-width: 0;">
                <p class="text-white font-bold text-xl leading-7">KostMudah</p>
                <p class="text-[#7390A9] text-[10px] font-bold uppercase tracking-wider leading-[15px]">MANAGEMENT</p>
            </div>
        </div>
    </div>

    <!-- Menu Items -->
    <nav class="px-3 py-4">
        <div class="flex flex-col gap-1">
            <!-- Dashboard -->
            <a href="{{ route('owner.dashboard') }}"
                class="group-item flex items-center px-3 py-3 rounded-lg transition-all duration-200 gap-3 relative {{ request()->routeIs('owner.dashboard') ? 'bg-white/10' : 'hover:bg-white/5' }}">
                <svg class="w-[22px] h-[18px] flex-shrink-0 {{ request()->routeIs('owner.dashboard') ? 'text-white' : 'text-[#7390A9]' }}"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span
                    class="menu-text text-sm transition-all duration-300 whitespace-nowrap overflow-hidden {{ request()->routeIs('owner.dashboard') ? 'text-white' : 'text-[#7390A9]' }}">
                    Dashboard
                </span>
                <!-- Tooltip -->
                <span
                    class="hidden absolute left-[56px] bg-[#001220] text-white text-xs px-3 py-1.5 rounded-lg shadow-lg whitespace-nowrap pointer-events-none z-50
                    before:content-[''] before:absolute before:-left-1.5 before:top-1/2 before:-translate-y-1/2 before:border-[6px] before:border-transparent before:border-r-[#001220]">
                    Dashboard
                </span>
            </a>

            <!-- Manajemen Kost -->
            <a href="{{ route('owner.kost.index') }}"
                class="group-item flex items-center px-3 py-3 rounded-lg transition-all duration-200 gap-3 relative {{ request()->routeIs('owner.kost.*') ? 'bg-white/10' : 'hover:bg-white/5' }}">
                <svg class="w-[22px] h-[18px] flex-shrink-0 {{ request()->routeIs('owner.kost.*') ? 'text-white' : 'text-[#7390A9]' }}"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                <span
                    class="menu-text text-sm transition-all duration-300 whitespace-nowrap overflow-hidden {{ request()->routeIs('owner.kost.*') ? 'text-white' : 'text-[#7390A9]' }}">
                    Manajemen Kost
                </span>
                <span
                    class="hidden absolute left-[56px] bg-[#001220] text-white text-xs px-3 py-1.5 rounded-lg shadow-lg whitespace-nowrap pointer-events-none z-50
                    before:content-[''] before:absolute before:-left-1.5 before:top-1/2 before:-translate-y-1/2 before:border-[6px] before:border-transparent before:border-r-[#001220]">
                    Manajemen Kost
                </span>
            </a>

            <!-- Data Penyewa -->
            <a href="{{ route('owner.tenant.index') }}"
                class="group-item flex items-center px-3 py-3 rounded-lg transition-all duration-200 gap-3 relative {{ request()->routeIs('owner.tenant.*') ? 'bg-white/10' : 'hover:bg-white/5' }}">
                <svg class="w-[22px] h-4 flex-shrink-0 {{ request()->routeIs('owner.tenant.*') ? 'text-white' : 'text-[#7390A9]/70' }}"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <span
                    class="menu-text text-sm transition-all duration-300 whitespace-nowrap overflow-hidden {{ request()->routeIs('owner.tenant.*') ? 'text-white' : 'text-[#7390A9]/70' }}">
                    Data Penyewa
                </span>
                <span
                    class="hidden absolute left-[56px] bg-[#001220] text-white text-xs px-3 py-1.5 rounded-lg shadow-lg whitespace-nowrap pointer-events-none z-50
                    before:content-[''] before:absolute before:-left-1.5 before:top-1/2 before:-translate-y-1/2 before:border-[6px] before:border-transparent before:border-r-[#001220]">
                    Data Penyewa
                </span>
            </a>

            <!-- Manajemen Pembayaran -->
            <a href="{{ route('owner.payment.index') }}"
                class="group-item flex items-center px-3 py-3 rounded-lg transition-all duration-200 gap-3 relative {{ request()->routeIs('owner.payment.*') ? 'bg-white/10' : 'hover:bg-white/5' }}">
                <svg class="w-[22px] h-4 flex-shrink-0 {{ request()->routeIs('owner.payment.*') ? 'text-white' : 'text-[#7390A9]/70' }}"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <span
                    class="menu-text text-sm transition-all duration-300 whitespace-nowrap overflow-hidden {{ request()->routeIs('owner.payment.*') ? 'text-white' : 'text-[#7390A9]/70' }}">
                    Manajemen Pembayaran
                </span>
                <span
                    class="hidden absolute left-[56px] bg-[#001220] text-white text-xs px-3 py-1.5 rounded-lg shadow-lg whitespace-nowrap pointer-events-none z-50
                    before:content-[''] before:absolute before:-left-1.5 before:top-1/2 before:-translate-y-1/2 before:border-[6px] before:border-transparent before:border-r-[#001220]">
                    Manajemen Pembayaran
                </span>
            </a>

            <!-- Laporan -->
            <a href="{{ route('owner.report.index') }}"
                class="group-item flex items-center px-3 py-3 rounded-lg transition-all duration-200 gap-3 relative {{ request()->routeIs('owner.report.*') ? 'bg-white/10' : 'hover:bg-white/5' }}">
                <svg class="w-[22px] h-[18px] flex-shrink-0 {{ request()->routeIs('owner.report.*') ? 'text-white' : 'text-[#7390A9]/70' }}"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2" />
                </svg>
                <span
                    class="menu-text text-sm transition-all duration-300 whitespace-nowrap overflow-hidden {{ request()->routeIs('owner.report.*') ? 'text-white' : 'text-[#7390A9]/70' }}">
                    Laporan
                </span>
                <span
                    class="hidden absolute left-[56px] bg-[#001220] text-white text-xs px-3 py-1.5 rounded-lg shadow-lg whitespace-nowrap pointer-events-none z-50
                    before:content-[''] before:absolute before:-left-1.5 before:top-1/2 before:-translate-y-1/2 before:border-[6px] before:border-transparent before:border-r-[#001220]">
                    Laporan
                </span>
            </a>

            <!-- Profil Pemilik -->
            <a href="{{ route('owner.profile.index') }}"
                class="group-item flex items-center px-3 py-3 rounded-lg transition-all duration-200 gap-3 relative {{ request()->routeIs('owner.profile.*') ? 'bg-white/10' : 'hover:bg-white/5' }}">
                <svg class="w-[22px] h-4 flex-shrink-0 {{ request()->routeIs('owner.profile.*') ? 'text-white' : 'text-[#7390A9]/70' }}"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span
                    class="menu-text text-sm transition-all duration-300 whitespace-nowrap overflow-hidden {{ request()->routeIs('owner.profile.*') ? 'text-white' : 'text-[#7390A9]/70' }}">
                    Profil Pemilik
                </span>
                <span
                    class="hidden absolute left-[56px] bg-[#001220] text-white text-xs px-3 py-1.5 rounded-lg shadow-lg whitespace-nowrap pointer-events-none z-50
                    before:content-[''] before:absolute before:-left-1.5 before:top-1/2 before:-translate-y-1/2 before:border-[6px] before:border-transparent before:border-r-[#001220]">
                    Profil Pemilik
                </span>
            </a>

            <!-- Verifikasi Dokumen -->
            <a href="{{ route('owner.document.index') }}"
                class="group-item flex items-center px-3 py-3 rounded-lg transition-all duration-200 gap-3 relative {{ request()->routeIs('owner.document.*') ? 'bg-white/10' : 'hover:bg-white/5' }}">
                <svg class="w-[22px] h-4 flex-shrink-0 {{ request()->routeIs('owner.document.*') ? 'text-white' : 'text-[#7390A9]/70' }}"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
                <span
                    class="menu-text text-sm transition-all duration-300 whitespace-nowrap overflow-hidden {{ request()->routeIs('owner.document.*') ? 'text-white' : 'text-[#7390A9]/70' }}">
                    Verifikasi Dokumen
                </span>
                <span
                    class="hidden absolute left-[56px] bg-[#001220] text-white text-xs px-3 py-1.5 rounded-lg shadow-lg whitespace-nowrap pointer-events-none z-50
                    before:content-[''] before:absolute before:-left-1.5 before:top-1/2 before:-translate-y-1/2 before:border-[6px] before:border-transparent before:border-r-[#001220]">
                    Verifikasi Dokumen
                </span>
            </a>
        </div>
    </nav>

    <!-- Logout -->
    <div class="absolute bottom-0 left-0 right-0 px-3 py-4 border-t border-[#7390A9]/10">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="group-item flex items-center w-full px-3 py-3 rounded-lg transition-all duration-200 gap-3 relative hover:bg-white/5">
                <svg class="w-[18px] h-[18px] flex-shrink-0 text-[#BA1A1A]" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span
                    class="menu-text text-sm font-semibold text-[#BA1A1A] transition-all duration-300 whitespace-nowrap overflow-hidden">
                    Logout
                </span>
                <span
                    class="hidden absolute left-[56px] bg-[#001220] text-white text-xs px-3 py-1.5 rounded-lg shadow-lg whitespace-nowrap pointer-events-none z-50
                    before:content-[''] before:absolute before:-left-1.5 before:top-1/2 before:-translate-y-1/2 before:border-[6px] before:border-transparent before:border-r-[#001220]">
                    Logout
                </span>
            </button>
        </form>
    </div>
</aside>
