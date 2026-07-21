<header class="bg-[#F8FAFBCC] border-b border-gray-200 sticky top-0 z-40" style="backdrop-filter: blur(8px);">
    <div class="flex justify-between items-center px-6 py-4">
        <!-- Left Section - Toggle Button -->
        <div class="flex items-center gap-4">
            <!-- Toggle Sidebar Button -->
            <button onclick="toggleSidebar()" class="p-2 hover:bg-gray-200 rounded-lg transition-colors"
                title="Toggle Sidebar">
                <svg id="toggleIcon" class="w-5 h-5 text-[#42474C]" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <!-- User Profile -->
        <div class="flex items-center gap-3">
            <div class="text-right">
                <p class="text-[#191C1D] text-sm font-bold">{{ Auth::user()->name ?? 'Budi Darmawan' }}</p>
                @php
                    $user = Auth::user();
                    $role = $user->roles->first();
                    $roleName = $role ? strtoupper($role->name) : 'USER';
                @endphp
                <p class="text-[#42474C] text-[10px] font-bold tracking-wider">{{ $roleName }}</p>
            </div>
            <div
                class="w-10 h-10 rounded-full flex items-center justify-center text-white font-bold text-sm overflow-hidden flex-shrink-0
                {{ Auth::user()->photo ? '' : 'bg-gradient-to-r from-blue-500 to-purple-500' }}">
                @if (Auth::user()->photo)
                    <img src="{{ Storage::url(Auth::user()->photo) }}" alt="{{ Auth::user()->name }}"
                        class="w-full h-full object-cover">
                @else
                    {{ Str::upper(substr(Auth::user()->name ?? 'BD', 0, 2)) }}
                @endif
            </div>
        </div>
    </div>
</header>
