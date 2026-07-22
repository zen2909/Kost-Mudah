@extends('layouts.admin')

@section('title', 'Manajemen Kost - KostMudah')

@section('content')
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
            <div>
                <h1 class="text-[#001220] text-2xl md:text-3xl font-bold">Manajemen Kost</h1>
                <p class="text-[#42474C] text-sm mt-1">Kelola dan monitor semua daftar properti kost dari pemilik
                    terverifikasi.</p>
            </div>
        </div>

        <!-- Flash Messages -->
        @if (session('success'))
            <div class="mb-6 p-4 bg-green-100 text-green-800 rounded-lg border border-green-300">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 p-4 bg-red-100 text-red-800 rounded-lg border border-red-300">
                {{ session('error') }}
            </div>
        @endif

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <div class="bg-white p-6 rounded-xl border border-[#C3C7CD] shadow-sm hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start">
                    <p class="text-[#42474C] text-xs font-semibold tracking-wider uppercase">TOTAL PROPERTIES</p>
                    <div class="w-8 h-8 bg-[#CCE5FF] rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-[#004B72]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <p class="text-[#191C1D] text-3xl font-bold">{{ number_format($totalProperties) }}</p>
                    <div class="flex items-center gap-1 mt-1">
                        <div class="w-2 h-1.5 bg-[#0194DC]"></div>
                        <p class="text-[#0194DC] text-sm font-semibold">+{{ $growthThisMonth }} this month</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl border border-[#C3C7CD] shadow-sm hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start">
                    <p class="text-[#42474C] text-xs font-semibold tracking-wider uppercase">ACTIVE STATUS</p>
                    <div class="w-8 h-8 bg-[#E8F5E9] rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-[#2E7D32]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <p class="text-[#191C1D] text-3xl font-bold">{{ number_format($activeProperties) }}</p>
                    <div class="flex items-center gap-2 mt-1">
                        <div class="w-2 h-2 bg-[#2E7D32] rounded-full"></div>
                        <p class="text-[#42474C] text-sm">Operational</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl border border-[#C3C7CD] shadow-sm hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start">
                    <p class="text-[#42474C] text-xs font-semibold tracking-wider uppercase">INACTIVE</p>
                    <div class="w-8 h-8 bg-[#FFDAD6] rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-[#BA1A1A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <p class="text-[#BA1A1A] text-3xl font-bold">{{ number_format($inactiveProperties) }}</p>
                    <div class="flex items-center gap-1 mt-1">
                        <div class="w-0.5 h-2.5 bg-[#BA1A1A]"></div>
                        <p class="text-[#BA1A1A] text-sm font-semibold">Not Operational</p>
                    </div>
                </div>
            </div>

            <div class="bg-[#06283D] p-6 rounded-xl border border-[#C3C7CD] shadow-sm relative overflow-hidden">
                <div class="absolute -right-4 -top-4 opacity-10">
                    <svg class="w-28 h-28 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z" />
                    </svg>
                </div>
                <div class="relative z-10">
                    <p class="text-[#7390A9] text-xs font-semibold tracking-wider uppercase">PENDING REVIEW</p>
                    <h3 class="text-white text-3xl font-bold mt-1">{{ number_format($pendingReview) }}</h3>
                    <p class="text-[#7390A9] text-sm mt-1">Properties awaiting owner verification</p>
                </div>
            </div>
        </div>

        <!-- Daftar Properti -->
        <div class="bg-white rounded-xl border border-[#C3C7CD] shadow-sm overflow-hidden">
            <!-- Header -->
            <div
                class="px-6 py-5 bg-[#F8FAFB] border-b border-[#C3C7CD] flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h3 class="text-[#001220] text-xl font-semibold">Daftar Properti</h3>
                    <p class="text-[#42474C] text-sm mt-0.5">Manage and monitor all your boarding house listings.</p>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <form method="GET" action="{{ route('admin.kost.index') }}" class="flex flex-wrap items-center gap-3">
                        <div class="relative">
                            <svg class="w-3.5 h-3.5 absolute left-3 top-1/2 -translate-y-1/2 text-[#42474C]" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <input name="search"
                                class="pl-8 pr-4 py-2 border border-[#C3C7CD] rounded-lg bg-[#F8FAFB] text-sm focus:outline-none focus:ring-2 focus:ring-[#06283D] w-full sm:w-56"
                                placeholder="Cari properti..." type="text" value="{{ request('search') }}">
                        </div>

                        <select name="status"
                            class="px-4 py-2 border border-[#C3C7CD] rounded-lg bg-white text-sm focus:outline-none focus:ring-2 focus:ring-[#06283D]">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive
                            </option>
                        </select>

                        <button type="submit"
                            class="px-4 py-2 bg-[#06283D] text-white text-sm font-semibold rounded-lg hover:bg-[#001220] transition-colors">
                            Filter
                        </button>

                        @if (request('search') || request('status'))
                            <a href="{{ route('admin.kost.index') }}"
                                class="px-4 py-2 border border-[#C3C7CD] rounded-lg text-sm font-semibold text-[#42474C] hover:bg-gray-50 transition-colors">
                                Reset
                            </a>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full min-w-[900px]">
                    <thead class="bg-[#F2F4F5] border-b border-[#C3C7CD]">
                        <tr>
                            <th class="text-left text-[#42474C] text-xs font-semibold tracking-wider py-4 px-6 w-[246px]">
                                KOST NAME</th>
                            <th class="text-left text-[#42474C] text-xs font-semibold tracking-wider py-4 px-6 w-[136px]">
                                OWNER</th>
                            <th class="text-left text-[#42474C] text-xs font-semibold tracking-wider py-4 px-6 w-[156px]">
                                LOCATION</th>
                            <th class="text-left text-[#42474C] text-xs font-semibold tracking-wider py-4 px-6 w-[146px]">
                                PRICE/MONTH</th>
                            <th class="text-left text-[#42474C] text-xs font-semibold tracking-wider py-4 px-6 w-[116px]">
                                STATUS</th>
                            <th class="text-right text-[#42474C] text-xs font-semibold tracking-wider py-4 px-6 w-[100px]">
                                AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kosts as $kost)
                            <tr class="border-b border-[#C3C7CD] hover:bg-gray-50/30 transition-colors">
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        @php
                                            $primaryPhoto = $kost->photos->where('is_primary', true)->first();
                                        @endphp
                                        @if ($primaryPhoto && $primaryPhoto->path)
                                            <img class="w-12 h-12 rounded-lg object-cover flex-shrink-0"
                                                src="{{ Storage::url($primaryPhoto->path) }}"
                                                alt="{{ $kost->name }}" />
                                        @else
                                            <div
                                                class="w-12 h-12 rounded-lg bg-[#F2F4F5] flex items-center justify-center flex-shrink-0">
                                                <svg class="w-6 h-6 text-[#42474C]" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                        <div>
                                            <p class="text-[#191C1D] text-base font-semibold">{{ $kost->name }}</p>
                                            <p class="text-[#42474C] text-xs">ID:
                                                KST-{{ str_pad($kost->id, 5, '0', STR_PAD_LEFT) }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    <p class="text-[#191C1D] text-sm">{{ $kost->user ? $kost->user->name : '-' }}</p>
                                </td>
                                <td class="py-4 px-6">
                                    <p class="text-[#42474C] text-sm">{{ $kost->address ?? '-' }}</p>
                                    <p class="text-[#42474C] text-xs">{{ $kost->kelurahan ?? '' }}</p>
                                </td>
                                <td class="py-4 px-6">
                                    <p class="text-[#191C1D] text-sm font-semibold">Rp
                                        {{ number_format($kost->price_per_month, 0, ',', '.') }}</p>
                                </td>
                                <td class="py-4 px-6">
                                    @if ($kost->status == 'active')
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1 bg-[#CCE5FF] rounded-full text-[#004B72] text-xs font-semibold">
                                            <span class="w-1.5 h-1.5 bg-[#004B72] rounded-full"></span>
                                            Active
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1 bg-[#F2F4F5] border border-[#C3C7CD] rounded-full text-[#42474C] text-xs font-semibold">
                                            <span class="w-1.5 h-1.5 bg-[#42474C] rounded-full"></span>
                                            Inactive
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('admin.kost.show', $kost->id) }}"
                                            class="p-2 rounded-lg hover:bg-gray-100 transition-colors"
                                            title="View Details">
                                            <svg class="w-4 h-4 text-[#42474C]" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        <form method="POST" action="{{ route('admin.kost.destroy', $kost->id) }}"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus kost ini? Tindakan ini tidak dapat dibatalkan!')"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-2 rounded-lg hover:bg-red-50 transition-colors" title="Delete">
                                                <svg class="w-4 h-4 text-[#BA1A1A]" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-12 text-[#42474C]">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-16 h-16 text-[#C3C7CD] mb-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                        <p class="text-lg font-semibold">Tidak ada data properti</p>
                                        <p class="text-sm">Belum ada properti dari pemilik terverifikasi</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($kosts->hasPages())
                <div
                    class="px-6 py-4 bg-[#F8FAFB] border-t border-[#C3C7CD] flex flex-col sm:flex-row justify-between items-center gap-4">
                    <span class="text-[#42474C] text-sm">Menampilkan
                        {{ $kosts->firstItem() ?? 0 }}-{{ $kosts->lastItem() ?? 0 }} dari {{ $kosts->total() }}
                        properti</span>
                    <div class="flex gap-2">
                        {{ $kosts->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
