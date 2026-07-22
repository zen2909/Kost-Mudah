@extends('layouts.admin')

@section('title', 'Manajemen Transaksi - KostMudah')

@section('content')
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
            <div>
                <h1 class="text-[#001220] text-2xl md:text-3xl font-bold">Transaction Overview</h1>
                <p class="text-[#42474C] text-sm mt-1">Manage and track all boarding house payments in real-time.</p>
            </div>
            <div class="flex items-center gap-3 mt-4 md:mt-0">
                <button
                    class="flex items-center gap-2 px-4 py-2 border border-[#C3C7CD] rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors">
                    <svg class="w-3.5 h-3.5 text-[#191C1D]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Export Report
                </button>
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
            <!-- Total Revenue -->
            <div
                class="bg-white p-6 rounded-xl border border-[#C3C7CD] shadow-sm hover:shadow-md transition-shadow relative overflow-hidden">
                <div class="absolute -right-8 -top-8 w-24 h-24 bg-slate-950/5 rounded-full"></div>
                <div class="relative z-10">
                    <div class="flex justify-between items-start">
                        <p class="text-[#42474C] text-xs font-semibold tracking-wider uppercase">TOTAL REVENUE</p>
                        <div class="w-8 h-8 bg-[#E8F5E9] rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-[#2E7D32]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v1m0 1V9m0 1v1m0 1V9m0 1v1M12 8v1m0 1V9m0 1v1m0 1V9m0 1v1m0 0v1M9 15h6" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <p class="text-[#191C1D] text-3xl font-bold">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                        <div class="flex items-center gap-1 mt-1">
                            <div class="w-2 h-1.5 bg-[#2E7D32]"></div>
                            <p class="text-[#2E7D32] text-sm font-semibold">Total pendapatan</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Payments -->
            <div
                class="bg-white p-6 rounded-xl border border-[#C3C7CD] shadow-sm hover:shadow-md transition-shadow relative overflow-hidden">
                <div class="absolute -right-8 -top-8 w-24 h-24 bg-slate-600/5 rounded-full"></div>
                <div class="relative z-10">
                    <div class="flex justify-between items-start">
                        <p class="text-[#42474C] text-xs font-semibold tracking-wider uppercase">PENDING PAYMENTS</p>
                        <div class="w-8 h-8 bg-[#FFDAD6] rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-[#BA1A1A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <p class="text-[#191C1D] text-3xl font-bold">Rp {{ number_format($pendingAmount, 0, ',', '.') }}</p>
                        <p class="text-[#42474C] text-sm mt-1">{{ $pendingPayments }} invoices awaiting clearance</p>
                    </div>
                </div>
            </div>

            <!-- Successful -->
            <div
                class="bg-white p-6 rounded-xl border border-[#C3C7CD] shadow-sm hover:shadow-md transition-shadow relative overflow-hidden">
                <div class="absolute -right-8 -top-8 w-24 h-24 bg-sky-500/5 rounded-full"></div>
                <div class="relative z-10">
                    <div class="flex justify-between items-start">
                        <p class="text-[#42474C] text-xs font-semibold tracking-wider uppercase">SUCCESSFUL</p>
                        <div class="w-8 h-8 bg-[#CCE5FF] rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-[#004B72]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <p class="text-[#004B72] text-3xl font-bold">{{ number_format($successfulCount) }}</p>
                        <p class="text-[#42474C] text-sm mt-1">Processed successfully</p>
                    </div>
                </div>
            </div>

            <!-- Cancelled -->
            <div
                class="bg-white p-6 rounded-xl border border-[#C3C7CD] shadow-sm hover:shadow-md transition-shadow relative overflow-hidden">
                <div class="absolute -right-8 -top-8 w-24 h-24 bg-red-700/5 rounded-full"></div>
                <div class="relative z-10">
                    <div class="flex justify-between items-start">
                        <p class="text-[#42474C] text-xs font-semibold tracking-wider uppercase">CANCELLED</p>
                        <div class="w-8 h-8 bg-[#FFDAD6] rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-[#BA1A1A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <p class="text-[#BA1A1A] text-3xl font-bold">{{ number_format($cancelledCount) }}</p>
                        <p class="text-[#42474C] text-sm mt-1">Failed or voided transactions</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Daftar Transaksi -->
        <div class="bg-white rounded-xl border border-[#C3C7CD] shadow-sm overflow-hidden">
            <!-- Header -->
            <div
                class="px-6 py-5 bg-[#F8FAFB] border-b border-[#C3C7CD] flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h3 class="text-[#001220] text-xl font-semibold">Daftar Transaksi</h3>
                    <p class="text-[#42474C] text-sm mt-0.5">Manage and track all boarding house payments in real-time.</p>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <form method="GET" action="{{ route('admin.transaksi.index') }}"
                        class="flex flex-wrap items-center gap-3">
                        <!-- Search -->
                        <div class="relative">
                            <svg class="w-3.5 h-3.5 absolute left-3 top-1/2 -translate-y-1/2 text-[#42474C]" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <input name="search"
                                class="pl-8 pr-4 py-2 border border-[#C3C7CD] rounded-lg bg-white text-sm focus:outline-none focus:ring-2 focus:ring-[#06283D] w-full sm:w-48"
                                placeholder="Cari transaksi..." type="text" value="{{ request('search') }}">
                        </div>

                        <!-- Status Filter -->
                        <select name="status"
                            class="px-4 py-2 border border-[#C3C7CD] rounded-lg bg-white text-sm focus:outline-none focus:ring-2 focus:ring-[#06283D] appearance-none pr-8">
                            <option value="">All Status</option>
                            <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending
                            </option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled
                            </option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed
                            </option>
                        </select>

                        <!-- Date Filter -->
                        <select name="date_range"
                            class="px-4 py-2 border border-[#C3C7CD] rounded-lg bg-white text-sm focus:outline-none focus:ring-2 focus:ring-[#06283D] appearance-none pr-8">
                            <option value="">All Time</option>
                            <option value="7_days" {{ request('date_range') == '7_days' ? 'selected' : '' }}>Last 7 Days
                            </option>
                            <option value="30_days" {{ request('date_range') == '30_days' ? 'selected' : '' }}>Last 30
                                Days</option>
                            <option value="90_days" {{ request('date_range') == '90_days' ? 'selected' : '' }}>Last 90
                                Days</option>
                        </select>

                        <button type="submit"
                            class="px-4 py-2 bg-[#06283D] text-white text-sm font-semibold rounded-lg hover:bg-[#001220] transition-colors">
                            Filter
                        </button>

                        @if (request('search') || request('status') || request('date_range'))
                            <a href="{{ route('admin.transaksi.index') }}"
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
                            <th class="text-left text-[#42474C] text-xs font-semibold tracking-wider py-4 px-6 w-[100px]">
                                ID RENTAL</th>
                            <th class="text-left text-[#42474C] text-xs font-semibold tracking-wider py-4 px-6 w-[156px]">
                                TENANT NAME</th>
                            <th class="text-left text-[#42474C] text-xs font-semibold tracking-wider py-4 px-6 w-[176px]">
                                KOST NAME</th>
                            <th class="text-left text-[#42474C] text-xs font-semibold tracking-wider py-4 px-6 w-[106px]">
                                DATE</th>
                            <th class="text-left text-[#42474C] text-xs font-semibold tracking-wider py-4 px-6 w-[116px]">
                                TOTAL PRICE</th>
                            <th class="text-left text-[#42474C] text-xs font-semibold tracking-wider py-4 px-6 w-[116px]">
                                STATUS</th>
                            <th class="text-right text-[#42474C] text-xs font-semibold tracking-wider py-4 px-6 w-[100px]">
                                AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaction)
                            @php
                                $statusColors = [
                                    'paid' => 'bg-[#E8F5E9] text-[#2E7D32]',
                                    'pending' => 'bg-[#FFF3E0] text-[#E65100]',
                                    'cancelled' => 'bg-[#FFDAD6] text-[#BA1A1A]',
                                    'completed' => 'bg-[#CCE5FF] text-[#004B72]',
                                ];
                                $statusLabels = [
                                    'paid' => 'Paid',
                                    'pending' => 'Pending',
                                    'cancelled' => 'Cancelled',
                                    'completed' => 'Completed',
                                ];
                                $statusDot = [
                                    'paid' => 'bg-[#2E7D32]',
                                    'pending' => 'bg-[#E65100]',
                                    'cancelled' => 'bg-[#BA1A1A]',
                                    'completed' => 'bg-[#004B72]',
                                ];
                                $color = $statusColors[$transaction->status] ?? 'bg-[#F2F4F5] text-[#42474C]';
                                $label = $statusLabels[$transaction->status] ?? ucfirst($transaction->status);
                                $dot = $statusDot[$transaction->status] ?? 'bg-[#42474C]';
                            @endphp
                            <tr class="border-b border-[#C3C7CD] hover:bg-gray-50/30 transition-colors">
                                <td class="py-4 px-6">
                                    <p class="text-[#191C1D] text-base font-semibold">
                                        #{{ $transaction->unique_code ?? 'KM-' . str_pad($transaction->id, 5, '0', STR_PAD_LEFT) }}
                                    </p>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 bg-[#F2F4F5] rounded-full flex items-center justify-center text-[#42474C] font-bold text-xs">
                                            {{ $transaction->tenant && $transaction->tenant->user ? strtoupper(substr($transaction->tenant->user->name, 0, 2)) : 'NA' }}
                                        </div>
                                        <div>
                                            <p class="text-[#191C1D] text-sm font-medium">
                                                {{ $transaction->tenant && $transaction->tenant->user ? $transaction->tenant->user->name : 'Tidak diketahui' }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    <p class="text-[#42474C] text-sm">
                                        {{ $transaction->boardingHouse ? $transaction->boardingHouse->name : 'Properti tidak ditemukan' }}
                                    </p>
                                    <p class="text-[#42474C] text-xs">Room {{ $transaction->room_number ?? '-' }}</p>
                                </td>
                                <td class="py-4 px-6">
                                    <p class="text-[#42474C] text-sm">
                                        {{ $transaction->created_at ? $transaction->created_at->format('d M Y') : '-' }}
                                    </p>
                                </td>
                                <td class="py-4 px-6">
                                    <p class="text-[#191C1D] text-sm font-semibold">Rp
                                        {{ number_format($transaction->total_price, 0, ',', '.') }}</p>
                                </td>
                                <td class="py-4 px-6">
                                    <span
                                        class="inline-flex items-center gap-1.5 px-3 py-1 {{ $color }} rounded-full text-xs font-semibold">
                                        <span class="w-1.5 h-1.5 {{ $dot }} rounded-full"></span>
                                        {{ $label }}
                                    </span>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex justify-end">
                                        <a href="{{ route('admin.transaksi.show', $transaction->id) }}"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#06283D] text-white text-sm font-medium rounded-lg hover:bg-[#001220] transition-colors shadow-sm">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            <span>Detail</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-12 text-[#42474C]">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-16 h-16 text-[#C3C7CD] mb-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v1m0 1V9m0 1v1m0 1V9m0 1v1M12 8v1m0 1V9m0 1v1m0 1V9m0 1v1m0 0v1M9 15h6" />
                                        </svg>
                                        <p class="text-lg font-semibold">Tidak ada transaksi</p>
                                        <p class="text-sm">Belum ada transaksi yang tercatat</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($transactions->hasPages())
                <div
                    class="px-6 py-4 bg-[#F8FAFB] border-t border-[#C3C7CD] flex flex-col sm:flex-row justify-between items-center gap-4">
                    <span class="text-[#42474C] text-sm">Menampilkan
                        {{ $transactions->firstItem() ?? 0 }}-{{ $transactions->lastItem() ?? 0 }} dari
                        {{ $transactions->total() }} transaksi</span>
                    <div class="flex gap-2">
                        {{ $transactions->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
