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
                <p class="text-[#7390A9] text-[10px] font-bold uppercase tracking-wider leading-[15px]">Tenant Panel</p>
            </div>
        </div>
    </div>

    <!-- Menu Items -->
    <nav class="px-3 py-4">
        <div class="flex flex-col gap-1">
            <!-- Dashboard -->
            <a href="{{ route('tenant.dashboard') }}"
                class="group-item flex items-center px-3 py-3 rounded-lg transition-all duration-200 gap-3 relative {{ request()->routeIs('tenant.dashboard') ? 'bg-white/10' : 'hover:bg-white/5' }}">
                <svg class="w-[22px] h-[18px] flex-shrink-0 {{ request()->routeIs('tenant.dashboard') ? 'text-white' : 'text-[#7390A9]' }}"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span
                    class="menu-text text-sm transition-all duration-300 whitespace-nowrap overflow-hidden {{ request()->routeIs('tenant.dashboard') ? 'text-white' : 'text-[#7390A9]' }}">
                    Dashboard
                </span>
                <!-- Tooltip -->
                <span
                    class="hidden absolute left-[56px] bg-[#001220] text-white text-xs px-3 py-1.5 rounded-lg shadow-lg whitespace-nowrap pointer-events-none z-50
                    before:content-[''] before:absolute before:-left-1.5 before:top-1/2 before:-translate-y-1/2 before:border-[6px] before:border-transparent before:border-r-[#001220]">
                    Dashboard
                </span>
            </a>

            <!-- Cari Kost -->
            <a href="{{ route('tenant.kost.index') }}"
                class="group-item flex items-center px-3 py-3 rounded-lg transition-all duration-200 gap-3 relative {{ request()->routeIs('tenant.kost.*') ? 'bg-white/10' : 'hover:bg-white/5' }}">
                <svg class="w-[22px] h-[18px] flex-shrink-0 {{ request()->routeIs('tenant.kost.*') ? 'text-white' : 'text-[#7390A9]' }}"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <span
                    class="menu-text text-sm transition-all duration-300 whitespace-nowrap overflow-hidden {{ request()->routeIs('tenant.kost.*') ? 'text-white' : 'text-[#7390A9]' }}">
                    Cari Kost
                </span>
                <span
                    class="hidden absolute left-[56px] bg-[#001220] text-white text-xs px-3 py-1.5 rounded-lg shadow-lg whitespace-nowrap pointer-events-none z-50
                    before:content-[''] before:absolute before:-left-1.5 before:top-1/2 before:-translate-y-1/2 before:border-[6px] before:border-transparent before:border-r-[#001220]">
                    Cari Kost
                </span>
            </a>

            <!-- Favorit Saya -->
            <a href="{{ route('tenant.favorit.index') }}"
                class="group-item flex items-center px-3 py-3 rounded-lg transition-all duration-200 gap-3 relative {{ request()->routeIs('tenant.favorit.*') ? 'bg-white/10' : 'hover:bg-white/5' }}">
                <svg class="w-[22px] h-[18px] flex-shrink-0 {{ request()->routeIs('tenant.favorit.*') ? 'text-white' : 'text-[#7390A9]' }}"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
                <span
                    class="menu-text text-sm transition-all duration-300 whitespace-nowrap overflow-hidden {{ request()->routeIs('tenant.favorit.*') ? 'text-white' : 'text-[#7390A9]' }}">
                    Favorit Saya
                </span>
                <span
                    class="hidden absolute left-[56px] bg-[#001220] text-white text-xs px-3 py-1.5 rounded-lg shadow-lg whitespace-nowrap pointer-events-none z-50
                    before:content-[''] before:absolute before:-left-1.5 before:top-1/2 before:-translate-y-1/2 before:border-[6px] before:border-transparent before:border-r-[#001220]">
                    Favorit Saya
                </span>
            </a>

            <!-- Riwayat Sewa -->
            <a href="{{ route('tenant.riwayat.index') }}"
                class="group-item flex items-center px-3 py-3 rounded-lg transition-all duration-200 gap-3 relative {{ request()->routeIs('tenant.riwayat.*') ? 'bg-white/10' : 'hover:bg-white/5' }}">
                <svg class="w-[22px] h-[18px] flex-shrink-0 {{ request()->routeIs('tenant.riwayat.*') ? 'text-white' : 'text-[#7390A9]' }}"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span
                    class="menu-text text-sm transition-all duration-300 whitespace-nowrap overflow-hidden {{ request()->routeIs('tenant.riwayat.*') ? 'text-white' : 'text-[#7390A9]' }}">
                    Riwayat Sewa
                </span>
                <span
                    class="hidden absolute left-[56px] bg-[#001220] text-white text-xs px-3 py-1.5 rounded-lg shadow-lg whitespace-nowrap pointer-events-none z-50
                    before:content-[''] before:absolute before:-left-1.5 before:top-1/2 before:-translate-y-1/2 before:border-[6px] before:border-transparent before:border-r-[#001220]">
                    Riwayat Sewa
                </span>
            </a>

                        <!-- Tagihan -->
            <a href="{{ route('tenant.bills.index') }}"
                class="group-item flex items-center px-3 py-3 rounded-lg transition-all duration-200 gap-3 relative {{ request()->routeIs('tenant.bills.*') ? 'bg-white/10' : 'hover:bg-white/5' }}">

                <svg class="w-[22px] h-[18px] flex-shrink-0 {{ request()->routeIs('tenant.bills.*') ? 'text-white' : 'text-[#7390A9]' }}"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M9 14l2 2 4-4M7 3h10a2 2 0 012 2v14a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z"/>

                </svg>

                <span
                    class="menu-text text-sm transition-all duration-300 whitespace-nowrap overflow-hidden {{ request()->routeIs('tenant.bills.*') ? 'text-white' : 'text-[#7390A9]' }}">

                    Tagihan

                </span>

                <span
                    class="hidden absolute left-[56px] bg-[#001220] text-white text-xs px-3 py-1.5 rounded-lg shadow-lg whitespace-nowrap pointer-events-none z-50
                    before:content-[''] before:absolute before:-left-1.5 before:top-1/2 before:-translate-y-1/2 before:border-[6px] before:border-transparent before:border-r-[#001220]">

                    Tagihan

                </span>

            </a>

            <!-- Profil Saya -->
            <a href="{{ route('tenant.profile.index') }}"
                class="group-item flex items-center px-3 py-3 rounded-lg transition-all duration-200 gap-3 relative {{ request()->routeIs('tenant.profile.*') ? 'bg-white/10' : 'hover:bg-white/5' }}">
                <svg class="w-[22px] h-[18px] flex-shrink-0 {{ request()->routeIs('tenant.profile.*') ? 'text-white' : 'text-[#7390A9]' }}"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span
                    class="menu-text text-sm transition-all duration-300 whitespace-nowrap overflow-hidden {{ request()->routeIs('tenant.profile.*') ? 'text-white' : 'text-[#7390A9]' }}">
                    Profil Saya
                </span>
                <span
                    class="hidden absolute left-[56px] bg-[#001220] text-white text-xs px-3 py-1.5 rounded-lg shadow-lg whitespace-nowrap pointer-events-none z-50
                    before:content-[''] before:absolute before:-left-1.5 before:top-1/2 before:-translate-y-1/2 before:border-[6px] before:border-transparent before:border-r-[#001220]">
                    Profil Saya
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
