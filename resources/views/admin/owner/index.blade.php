@extends('layouts.admin')

@section('title', 'Manajemen Pemilik Properti - KostMudah')

@section('content')
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
            <div>
                <h1 class="text-[#001220] text-3xl md:text-4xl font-bold leading-10">Manajemen Pemilik Properti</h1>
                <p class="text-[#42474C] text-base mt-1">Kelola dan audit akun pemilik properti yang telah terverifikasi atau
                    ditolak.</p>
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
        <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
            <div class="bg-white p-5 rounded-xl border border-[#C3C7CD] shadow-sm">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-[#42474C] text-xs font-semibold tracking-wide uppercase">Total Owners</p>
                        <p class="text-[#001220] text-2xl font-bold mt-1">{{ number_format($totalOwners) }}</p>
                    </div>
                    <div class="w-10 h-10 bg-[#06283D]/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-[#06283D]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl border border-[#C3C7CD] shadow-sm">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-[#42474C] text-xs font-semibold tracking-wide uppercase">Menunggu Verifikasi</p>
                        <p class="text-[#F59E0B] text-2xl font-bold mt-1">{{ $pendingVerifications }}</p>
                    </div>
                    <div class="w-10 h-10 bg-[#F59E0B]/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-[#F59E0B]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl border border-[#C3C7CD] shadow-sm">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-[#42474C] text-xs font-semibold tracking-wide uppercase">Terverifikasi</p>
                        <p class="text-[#15803D] text-2xl font-bold mt-1">{{ number_format($verifiedOwners) }}</p>
                    </div>
                    <div class="w-10 h-10 bg-[#15803D]/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-[#15803D]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl border border-[#C3C7CD] shadow-sm">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-[#42474C] text-xs font-semibold tracking-wide uppercase">Ditolak</p>
                        <p class="text-[#BA1A1A] text-2xl font-bold mt-1">{{ number_format($rejectedOwners) }}</p>
                    </div>
                    <div class="w-10 h-10 bg-[#BA1A1A]/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-[#BA1A1A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl border border-[#C3C7CD] shadow-sm">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-[#42474C] text-xs font-semibold tracking-wide uppercase">Total Properties</p>
                        <p class="text-[#0194DC] text-2xl font-bold mt-1">{{ number_format($totalProperties) }}</p>
                    </div>
                    <div class="w-10 h-10 bg-[#0194DC]/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-[#0194DC]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter & Table -->
        <div class="bg-white rounded-xl border border-[#C3C7CD] shadow-sm overflow-hidden">
            <!-- Filter Header -->
            <div class="px-6 py-4 bg-[#F8FAFB] border-b border-[#C3C7CD]">
                <form method="GET" action="{{ route('admin.owners.index') }}"
                    class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-[#001220] text-lg font-semibold">Daftar Pemilik</h2>
                        <p class="text-[#42474C] text-sm">Kelola dan audit akun pemilik properti</p>
                    </div>
                    <div class="flex flex-wrap items-center gap-3">
                        <div class="relative">
                            <svg class="w-3.5 h-3.5 absolute left-3 top-1/2 -translate-y-1/2 text-[#42474C]" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <input name="search"
                                class="pl-8 pr-4 py-2 border border-[#C3C7CD] rounded-lg bg-white text-sm focus:outline-none focus:ring-2 focus:ring-[#06283D] w-full md:w-48"
                                placeholder="Cari pemilik..." type="text" value="{{ request('search') }}">
                        </div>

                        <select name="status"
                            class="px-4 py-2 border border-[#C3C7CD] rounded-lg bg-white text-sm focus:outline-none focus:ring-2 focus:ring-[#06283D]">
                            <option value="">All Status</option>
                            <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Verified
                            </option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected
                            </option>
                        </select>

                        <button type="submit"
                            class="px-4 py-2 bg-[#06283D] text-white text-sm font-semibold rounded-lg hover:bg-[#001220] transition-colors">
                            Filter
                        </button>

                        @if (request('search') || request('status'))
                            <a href="{{ route('admin.owners.index') }}"
                                class="px-4 py-2 border border-[#C3C7CD] rounded-lg text-sm font-semibold text-[#42474C] hover:bg-gray-50 transition-colors">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full min-w-[800px]">
                    <thead>
                        <tr class="bg-[#F2F4F5] border-b border-[#C3C7CD]">
                            <th
                                class="text-left px-6 py-3 text-[#42474C] text-xs font-semibold uppercase tracking-[0.6px]">
                                OWNER NAME</th>
                            <th
                                class="text-left px-6 py-3 text-[#42474C] text-xs font-semibold uppercase tracking-[0.6px]">
                                EMAIL</th>
                            <th
                                class="text-left px-6 py-3 text-[#42474C] text-xs font-semibold uppercase tracking-[0.6px]">
                                PHONE</th>
                            <th
                                class="text-left px-6 py-3 text-[#42474C] text-xs font-semibold uppercase tracking-[0.6px]">
                                STATUS</th>
                            <th
                                class="text-center px-6 py-3 text-[#42474C] text-xs font-semibold uppercase tracking-[0.6px]">
                                PROPERTIES</th>
                            <th
                                class="text-right px-6 py-3 text-[#42474C] text-xs font-semibold uppercase tracking-[0.6px]">
                                ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($owners as $owner)
                            @php
                                // Gunakan verification_status dari tabel owners, bukan dari dokumen
                                $status = $owner->owner ? $owner->owner->verification_status : 'unverified';
                                $statusLabels = [
                                    'approved' => ['label' => 'VERIFIED', 'class' => 'bg-[#DCFCE7] text-[#15803D]'],
                                    'pending' => ['label' => 'PENDING', 'class' => 'bg-[#FEF3C7] text-[#92400E]'],
                                    'rejected' => ['label' => 'REJECTED', 'class' => 'bg-[#FEE2E2] text-[#991B1B]'],
                                    'unverified' => ['label' => 'UNVERIFIED', 'class' => 'bg-[#F2F4F5] text-[#42474C]'],
                                ];
                                $currentStatus = $statusLabels[$status] ?? $statusLabels['unverified'];
                            @endphp
                            <tr class="border-b border-[#C3C7CD] hover:bg-gray-50/50 transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        @if ($owner->photo)
                                            <img src="{{ Storage::url($owner->photo) }}" alt="{{ $owner->name }}"
                                                class="w-10 h-10 rounded-full border border-[#C3C7CD] object-cover">
                                        @else
                                            <div
                                                class="w-10 h-10 rounded-full bg-[#06283D] flex items-center justify-center flex-shrink-0">
                                                <span
                                                    class="text-white text-sm font-bold">{{ strtoupper(substr($owner->name, 0, 2)) }}</span>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="text-[#191C1D] text-sm font-semibold">{{ $owner->name }}</div>
                                            <div class="text-[#42474C] text-xs">Joined
                                                {{ $owner->created_at->format('M Y') }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-[#42474C] text-sm">{{ $owner->email }}</td>
                                <td class="px-6 py-4 text-[#42474C] text-sm">{{ $owner->phone ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-block px-2.5 py-1 {{ $currentStatus['class'] }} text-[10px] font-bold uppercase rounded-full">
                                        {{ $currentStatus['label'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-[#191C1D] text-sm font-semibold text-center">
                                    {{ $owner->boardingHouses->count() }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('admin.owners.show', $owner->id) }}"
                                            class="p-2 rounded-lg hover:bg-gray-100 transition" title="View Details">
                                            <svg class="w-5 h-5 text-[#42474C]" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        <form method="POST" action="{{ route('admin.owners.destroy', $owner->id) }}"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus pemilik ini? Tindakan ini tidak dapat dibatalkan!')"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 rounded-lg hover:bg-red-50 transition"
                                                title="Delete">
                                                <svg class="w-5 h-5 text-[#BA1A1A]" fill="none" stroke="currentColor"
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
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <p class="text-lg font-semibold">Tidak ada data pemilik</p>
                                        <p class="text-sm">Belum ada pemilik properti yang terverifikasi atau ditolak</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($owners->hasPages())
                <div
                    class="px-6 py-4 bg-[#F8FAFB] border-t border-[#C3C7CD] flex flex-col md:flex-row justify-between items-center gap-4">
                    <div class="text-[#42474C] text-sm">
                        Showing {{ $owners->firstItem() ?? 0 }} to {{ $owners->lastItem() ?? 0 }} of
                        {{ $owners->total() }} entries
                    </div>
                    <div class="flex items-center gap-1">
                        {{ $owners->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
