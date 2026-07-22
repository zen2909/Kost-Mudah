@extends('layouts.admin')

@section('title', 'Detail Penyewa - KostMudah')

@section('content')
    <div class="modal-overlay">
        <div class="modal-container">
            <!-- Header -->
            <div class="sticky-top bg-white px-6 pt-6 pb-4 border-b border-[#C3C7CD]">
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-[#06283D] flex items-center justify-center text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <h2 class="text-[#001220] text-xl font-semibold">Detail Penyewa</h2>
                    </div>
                    <a href="{{ route('admin.penyewa.index') }}"
                        class="p-2 hover:bg-gray-100 rounded-full transition-colors">
                        <svg class="w-5 h-5 text-[#42474C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Content -->
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Left Column -->
                    <div class="space-y-4">
                        <!-- Profile -->
                        <div class="flex items-center gap-4 pb-4 border-b border-[#C3C7CD]">
                            @if ($tenant->photo)
                                <img src="{{ Storage::url($tenant->photo) }}" alt="{{ $tenant->name }}"
                                    class="w-16 h-16 rounded-full object-cover border-2 border-[#C3C7CD]">
                            @else
                                <div
                                    class="w-16 h-16 rounded-full bg-[#06283D] flex items-center justify-center flex-shrink-0">
                                    <span
                                        class="text-white text-xl font-bold">{{ strtoupper(substr($tenant->name, 0, 2)) }}</span>
                                </div>
                            @endif
                            <div>
                                <h4 class="text-lg font-bold text-[#191C1D]">{{ $tenant->name }}</h4>
                                <p class="text-[#42474C] text-sm">{{ $tenant->email }}</p>
                                <p class="text-[#42474C] text-sm">{{ $tenant->phone ?? '-' }}</p>
                            </div>
                        </div>

                        <div>
                            <p class="text-[#42474C] text-xs font-semibold tracking-wide uppercase">Nama Lengkap</p>
                            <p class="text-[#191C1D] text-base mt-1">{{ $tenant->name }}</p>
                        </div>

                        <div>
                            <p class="text-[#42474C] text-xs font-semibold tracking-wide uppercase">Email</p>
                            <p class="text-[#191C1D] text-base mt-1">{{ $tenant->email }}</p>
                        </div>

                        <div>
                            <p class="text-[#42474C] text-xs font-semibold tracking-wide uppercase">Nomor Telepon</p>
                            <p class="text-[#191C1D] text-base mt-1">{{ $tenant->phone ?? '-' }}</p>
                        </div>

                        @if ($tenant->tenant)
                            <div>
                                <p class="text-[#42474C] text-xs font-semibold tracking-wide uppercase">Pekerjaan</p>
                                <p class="text-[#191C1D] text-base mt-1">{{ $tenant->tenant->occupation ?? '-' }}</p>
                            </div>

                            <div>
                                <p class="text-[#42474C] text-xs font-semibold tracking-wide uppercase">Jenis Kelamin</p>
                                <span
                                    class="inline-block px-3 py-1 {{ $tenant->tenant->gender == 'male' ? 'bg-[#06283D]/10 text-[#06283D]' : 'bg-[#F2F4F5] border border-[#C3C7CD] text-[#42474C]' }} rounded-full text-xs font-bold uppercase mt-1">
                                    {{ $tenant->tenant->gender ?? '-' }}
                                </span>
                            </div>
                        @endif
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-4">
                        <div>
                            <p class="text-[#42474C] text-xs font-semibold tracking-wide uppercase">Bergabung Sejak</p>
                            <p class="text-[#191C1D] text-base mt-1">{{ $tenant->created_at->format('d M Y') }}</p>
                        </div>

                        <!-- Daftar Rental / Sewa -->
                        <div>
                            <p class="text-[#42474C] text-xs font-semibold tracking-wide uppercase">Riwayat Sewa</p>
                            @if ($tenant->rentals && $tenant->rentals->count() > 0)
                                <div class="mt-2 space-y-2">
                                    @foreach ($tenant->rentals as $rental)
                                        <div class="bg-[#F2F4F5] rounded-lg p-3">
                                            <div class="flex justify-between items-start">
                                                <div>
                                                    <p class="text-[#191C1D] text-sm font-semibold">
                                                        {{ $rental->boardingHouse ? $rental->boardingHouse->name : 'Properti tidak ditemukan' }}
                                                    </p>
                                                    <p class="text-[#42474C] text-xs">Room:
                                                        {{ $rental->room_number ?? '-' }}</p>
                                                    <p class="text-[#42474C] text-xs">Periode:
                                                        {{ $rental->start_date ? $rental->start_date->format('d M Y') : '-' }}
                                                        -
                                                        {{ $rental->end_date ? $rental->end_date->format('d M Y') : '-' }}
                                                    </p>
                                                    @if ($rental->unique_code)
                                                        <p class="text-[#42474C] text-xs">Kode: {{ $rental->unique_code }}
                                                        </p>
                                                    @endif
                                                </div>
                                                <span
                                                    class="text-[#42474C] text-xs bg-white px-2 py-1 rounded-full 
                                        {{ $rental->status == 'paid'
                                            ? 'text-[#15803D]'
                                            : ($rental->status == 'pending'
                                                ? 'text-[#F59E0B]'
                                                : ($rental->status == 'completed'
                                                    ? 'text-[#004B72]'
                                                    : 'text-[#BA1A1A]')) }}">
                                                    {{ ucfirst($rental->status) }}
                                                </span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-[#42474C] text-sm mt-2 italic">Belum ada riwayat sewa</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="flex justify-end pt-4 mt-4 border-t border-[#C3C7CD]">
                    <a href="{{ route('admin.penyewa.index') }}"
                        class="px-6 py-2 border border-[#C3C7CD] rounded-lg text-[#42474C] font-semibold hover:bg-gray-50 transition-colors">
                        Tutup
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
