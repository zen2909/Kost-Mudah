@extends('layouts.admin')

@section('title', 'Manajemen Penyewa - KostMudah')

@section('content')
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
            <div>
                <h1 class="text-[#001220] text-2xl md:text-3xl font-bold">Tenants Directory</h1>
                <p class="text-[#42474C] text-sm mt-1">Oversee all residents across your property portfolio.</p>
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
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-6">
            <div class="bg-white p-6 rounded-xl border border-[#C3C7CD] shadow-sm hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start">
                    <p class="text-[#42474C] text-xs font-semibold tracking-wider uppercase">TOTAL TENANTS</p>
                    <div class="w-8 h-8 bg-[#CCE5FF] rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-[#004B72]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <p class="text-[#191C1D] text-3xl font-bold">{{ number_format($totalTenants) }}</p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl border border-[#C3C7CD] shadow-sm hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start">
                    <p class="text-[#42474C] text-xs font-semibold tracking-wider uppercase">AKTIF</p>
                    <div class="w-8 h-8 bg-[#E8F5E9] rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-[#2E7D32]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <p class="text-[#15803D] text-3xl font-bold">{{ number_format($activeTenants) }}</p>
                    <p class="text-[#42474C] text-sm mt-1">Memiliki sewa aktif</p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl border border-[#C3C7CD] shadow-sm hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start">
                    <p class="text-[#42474C] text-xs font-semibold tracking-wider uppercase">NONAKTIF</p>
                    <div class="w-8 h-8 bg-[#F2F4F5] rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-[#42474C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <p class="text-[#42474C] text-3xl font-bold">{{ number_format($inactiveTenants) }}</p>
                    <p class="text-[#42474C] text-sm mt-1">Tidak memiliki sewa aktif</p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl border border-[#C3C7CD] shadow-sm hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start">
                    <p class="text-[#42474C] text-xs font-semibold tracking-wider uppercase">DUE SOON</p>
                    <div class="w-8 h-8 bg-[#FFDAD6] rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-[#BA1A1A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <p class="text-[#BA1A1A] text-3xl font-bold">{{ number_format($dueSoon) }}</p>
                    <p class="text-[#BA1A1A] text-sm font-semibold mt-1">Berakhir dalam 7 hari</p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl border border-[#C3C7CD] shadow-sm hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start">
                    <p class="text-[#42474C] text-xs font-semibold tracking-wider uppercase">WAITING PAYMENT</p>
                    <div class="w-8 h-8 bg-[#FFDAD6] rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-[#BA1A1A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <p class="text-[#BA1A1A] text-3xl font-bold">{{ number_format($waitingPayment) }}</p>
                    <div class="mt-1">
                        <span class="px-2 py-0.5 bg-rose-200 rounded-full text-red-800 text-[10px] font-bold">URGENT</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Daftar Penyewa -->
        <div class="bg-white rounded-xl border border-[#C3C7CD] shadow-sm overflow-hidden">
            <!-- Header -->
            <div
                class="px-6 py-5 bg-[#F8FAFB] border-b border-[#C3C7CD] flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h3 class="text-[#001220] text-xl font-semibold">Daftar Penyewa</h3>
                    <p class="text-[#42474C] text-sm mt-0.5">Manage and monitor all tenants across your properties.</p>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <form method="GET" action="{{ route('admin.penyewa.index') }}"
                        class="flex flex-wrap items-center gap-3">
                        <div class="relative">
                            <svg class="w-3.5 h-3.5 absolute left-3 top-1/2 -translate-y-1/2 text-[#42474C]" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <input name="search"
                                class="pl-8 pr-4 py-2 border border-[#C3C7CD] rounded-lg bg-[#F8FAFB] text-sm focus:outline-none focus:ring-2 focus:ring-[#06283D] w-full sm:w-56"
                                placeholder="Cari penyewa..." type="text" value="{{ request('search') }}">
                        </div>

                        <select name="gender"
                            class="px-4 py-2 border border-[#C3C7CD] rounded-lg bg-white text-sm focus:outline-none focus:ring-2 focus:ring-[#06283D]">
                            <option value="">All Gender</option>
                            <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Female</option>
                        </select>

                        <button type="submit"
                            class="px-4 py-2 bg-[#06283D] text-white text-sm font-semibold rounded-lg hover:bg-[#001220] transition-colors">
                            Filter
                        </button>

                        @if (request('search') || request('gender'))
                            <a href="{{ route('admin.penyewa.index') }}"
                                class="px-4 py-2 border border-[#C3C7CD] rounded-lg text-sm font-semibold text-[#42474C] hover:bg-gray-50 transition-colors">
                                Reset
                            </a>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full min-w-[1000px]">
                    <thead class="bg-[#F2F4F5] border-b border-[#C3C7CD]">
                        <tr>
                            <th class="text-left text-[#42474C] text-xs font-semibold tracking-wider py-4 px-6 w-[246px]">
                                TENANT NAME</th>
                            <th class="text-left text-[#42474C] text-xs font-semibold tracking-wider py-4 px-6 w-[156px]">
                                OCCUPATION</th>
                            <th class="text-left text-[#42474C] text-xs font-semibold tracking-wider py-4 px-6 w-[106px]">
                                GENDER</th>
                            <th class="text-left text-[#42474C] text-xs font-semibold tracking-wider py-4 px-6 w-[166px]">
                                ACTIVE RENTAL</th>
                            <th class="text-left text-[#42474C] text-xs font-semibold tracking-wider py-4 px-6 w-[126px]">
                                JOIN DATE</th>
                            <th
                                class="text-center text-[#42474C] text-xs font-semibold tracking-wider py-4 px-6 w-[100px]">
                                AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tenants as $tenant)
                            @php
                                $tenantData = $tenant->tenant;
                                $activeRental = $tenant->rentals->first();
                            @endphp
                            <tr class="border-b border-[#C3C7CD] hover:bg-gray-50/30 transition-colors">
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        @if ($tenant->photo)
                                            <img class="w-10 h-10 rounded-full object-cover flex-shrink-0"
                                                src="{{ Storage::url($tenant->photo) }}" alt="{{ $tenant->name }}" />
                                        @else
                                            <div
                                                class="w-10 h-10 rounded-full bg-[#06283D] flex items-center justify-center flex-shrink-0">
                                                <span
                                                    class="text-white text-sm font-bold">{{ strtoupper(substr($tenant->name, 0, 2)) }}</span>
                                            </div>
                                        @endif
                                        <div>
                                            <p class="text-[#191C1D] text-base font-semibold">{{ $tenant->name }}</p>
                                            <p class="text-[#42474C] text-xs">{{ $tenant->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    <p class="text-[#42474C] text-sm">{{ $tenantData ? $tenantData->occupation : '-' }}
                                    </p>
                                </td>
                                <td class="py-4 px-6">
                                    @if ($tenantData && $tenantData->gender)
                                        <span
                                            class="px-3 py-1 {{ $tenantData->gender == 'male' ? 'bg-[#06283D]/10 text-[#06283D]' : 'bg-[#F2F4F5] border border-[#C3C7CD] text-[#42474C]' }} rounded-full text-xs font-bold uppercase">
                                            {{ $tenantData->gender }}
                                        </span>
                                    @else
                                        <span
                                            class="px-3 py-1 bg-[#F2F4F5] border border-[#C3C7CD] rounded-full text-[#42474C] text-xs font-bold uppercase">-</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6">
                                    @if ($activeRental && $activeRental->boardingHouse)
                                        <p class="text-[#191C1D] text-sm font-semibold">
                                            {{ $activeRental->boardingHouse->name }}</p>
                                        <p class="text-[#42474C] text-xs">Room {{ $activeRental->room_number ?? '-' }}</p>
                                    @else
                                        <p class="text-[#42474C] text-sm italic">No active rental</p>
                                    @endif
                                </td>
                                <td class="py-4 px-6">
                                    <p class="text-[#42474C] text-sm">{{ $tenant->created_at->format('d M Y') }}</p>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex justify-center">
                                        <a href="{{ route('admin.penyewa.show', $tenant->id) }}"
                                            class="p-2 rounded-lg hover:bg-gray-100 transition-colors"
                                            title="View Details">
                                            <svg class="w-5 h-5 text-[#42474C]" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
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
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <p class="text-lg font-semibold">Tidak ada data penyewa</p>
                                        <p class="text-sm">Belum ada penyewa yang terdaftar</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($tenants->hasPages())
                <div
                    class="px-6 py-4 bg-[#F8FAFB] border-t border-[#C3C7CD] flex flex-col sm:flex-row justify-between items-center gap-4">
                    <span class="text-[#42474C] text-sm">Menampilkan
                        {{ $tenants->firstItem() ?? 0 }}-{{ $tenants->lastItem() ?? 0 }} dari {{ $tenants->total() }}
                        penyewa</span>
                    <div class="flex gap-2">
                        {{ $tenants->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
