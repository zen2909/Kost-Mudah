@extends('layouts.owner')

@section('title', 'Manajemen Kost - KostMudah')

@section('content')
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
            <div>
                <h1 class="text-[#001220] text-3xl md:text-4xl font-bold leading-10">Manajemen Kost</h1>
                <p class="text-[#42474C] text-base mt-1">Pantau dan kelola unit properti Anda secara efisien.</p>
            </div>
            <a href="{{ route('owner.kost.create') }}"
                class="inline-flex items-center bg-[#06283D] text-white px-6 py-3 rounded-lg hover:bg-[#001220] transition-colors shadow-md mt-4 md:mt-0">
                <svg class="w-3.5 h-3.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span class="text-xs font-semibold tracking-wide">Tambah Properti</span>
            </a>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <!-- Total Unit -->
            <div class="flex items-center bg-white p-6 rounded-xl border border-[#C3C7CD] shadow-sm h-[98px]">
                <div class="w-11 h-11 bg-[#ADCAE5] rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-5 h-5 text-[#001E30]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <div>
                    <p class="text-[#42474C] text-xs font-semibold tracking-wide">Total Unit</p>
                    <p class="text-[#191C1D] text-3xl font-bold leading-8">{{ $totalUnits }}</p>
                </div>
            </div>

            <!-- Tersedia -->
            <div class="flex items-center bg-white p-6 rounded-xl border border-[#C3C7CD] shadow-sm h-[98px]">
                <div class="w-11 h-11 bg-[#CFE6EF] rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-5 h-4 text-[#52686F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-[#42474C] text-xs font-semibold tracking-wide">Tersedia</p>
                    <p class="text-[#191C1D] text-3xl font-bold leading-8">{{ $totalAvailable }}</p>
                </div>
            </div>

            <!-- Okupansi -->
            <div class="flex items-center bg-white p-6 rounded-xl border border-[#C3C7CD] shadow-sm h-[98px]">
                <div class="w-11 h-11 bg-[#0194DC]/10 rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-5 h-3 text-[#0194DC]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-[#42474C] text-xs font-semibold tracking-wide">Okupansi</p>
                    <p class="text-[#191C1D] text-3xl font-bold leading-8">{{ $occupancyRate }}%</p>
                </div>
            </div>

            <!-- Jatuh Tempo -->
            <div class="flex items-center bg-white p-6 rounded-xl border border-[#C3C7CD] shadow-sm h-[98px]">
                <div class="w-11 h-11 bg-[#FFDAD6] rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-5 h-5 text-[#93000A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-[#42474C] text-xs font-semibold tracking-wide">Jatuh Tempo</p>
                    <p class="text-[#191C1D] text-3xl font-bold leading-8">{{ $expiringSoon }}</p>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-xl border border-[#C3C7CD] shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full min-w-[800px]">
                    <thead class="bg-[#F2F4F5] border-b border-[#C3C7CD]">
                        <tr>
                            <th class="text-left text-[#42474C] text-xs font-semibold tracking-wide py-4 px-6 w-[226px]">
                                Informasi Unit</th>
                            <th class="text-left text-[#42474C] text-xs font-semibold tracking-wide py-4 px-6 w-[163px]">
                                Tipe Kost</th>
                            <th class="text-left text-[#42474C] text-xs font-semibold tracking-wide py-4 px-6 w-[144px]">
                                Ketersediaan</th>
                            <th class="text-left text-[#42474C] text-xs font-semibold tracking-wide py-4 px-6 w-[185px]">
                                Harga Sewa</th>
                            <th class="text-left text-[#42474C] text-xs font-semibold tracking-wide py-4 px-6 w-[116px]">
                                Status</th>
                            <th class="text-right text-[#42474C] text-xs font-semibold tracking-wide py-4 px-6 w-[136px]">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($boardingHouses as $index => $kost)
                            <tr class="border-b border-[#C3C7CD] last:border-b-0">
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-4">
                                        @if ($kost->primaryPhoto)
                                            <img src="{{ Storage::url($kost->primaryPhoto->path) }}"
                                                alt="{{ $kost->name }}" class="w-16 h-12 rounded-lg object-cover">
                                        @else
                                            <div class="w-16 h-12 bg-[#F2F4F5] rounded-lg flex items-center justify-center">
                                                <svg class="w-6 h-6 text-[#C3C7CD]" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                        <div>
                                            <p class="text-[#001220] text-xl font-semibold leading-7">{{ $kost->name }}
                                            </p>
                                            <p class="text-[#42474C] text-sm">{{ Str::limit($kost->address, 30) }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-[#191C1D] text-base capitalize">{{ $kost->type }}</td>
                                <td class="py-4 px-6">
                                    <div class="flex flex-col gap-1">
                                        @php
                                            $percentage =
                                                $kost->total_rooms > 0
                                                    ? round(($kost->available_rooms / $kost->total_rooms) * 100)
                                                    : 0;
                                        @endphp
                                        <div class="w-24 h-1.5 bg-[#C3C7CD] rounded-full overflow-hidden">
                                            <div class="h-full rounded-full"
                                                style="width: {{ 100 - $percentage }}%; 
                                                background: {{ $percentage < 20 ? '#BA1A1A' : ($percentage < 50 ? '#F59E0B' : '#0194DC') }}">
                                            </div>
                                        </div>
                                        <span
                                            class="text-[#191C1D] text-sm">{{ $kost->available_rooms }}/{{ $kost->total_rooms }}
                                            Kamar</span>
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    <span class="text-[#191C1D] text-base font-semibold">Rp
                                        {{ number_format($kost->price_per_month, 0, ',', '.') }} /bln</span>
                                </td>
                                <td class="py-4 px-6">
                                    @php
                                        $statusColors = [
                                            'active' => 'bg-[#ADCAE5] text-[#001E30]',
                                            'inactive' => 'bg-[#E6E8E9] text-[#42474C]',
                                            'pending' => 'bg-[#CFE6EF] text-[#52686F]',
                                        ];
                                        $statusTexts = [
                                            'active' => 'Active',
                                            'inactive' => 'Inactive',
                                            'pending' => 'Pending',
                                        ];
                                        $color = $statusColors[$kost->status] ?? 'bg-[#ADCAE5] text-[#001E30]';
                                        $text = $statusTexts[$kost->status] ?? ucfirst($kost->status);
                                    @endphp
                                    <span
                                        class="inline-block {{ $color }} text-xs font-semibold px-2.5 py-0.5 rounded-full">
                                        {{ $text }}
                                    </span>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex justify-end gap-2">
                                        <!-- Detail -->
                                        <a href="{{ route('owner.kost.show', $kost->id) }}"
                                            class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                                            <svg class="w-[18px] h-[18px] text-[#0194DC]" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>

                                        <!-- Edit -->
                                        <a href="{{ route('owner.kost.edit', $kost->id) }}"
                                            class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                                            <svg class="w-[18px] h-[18px] text-[#001220]" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>

                                        <!-- Delete - Buka Modal -->
                                        <button onclick="openDeleteModal('delete-modal-{{ $kost->id }}')"
                                            class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                                            <svg class="w-4 h-[18px] text-[#BA1A1A]" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-16 h-16 text-[#C3C7CD] mb-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                        <p class="text-[#42474C] text-lg font-semibold">Belum ada properti</p>
                                        <p class="text-[#42474C] text-sm mt-1">Mulai tambahkan properti kost Anda sekarang
                                        </p>
                                        <a href="{{ route('owner.kost.create') }}"
                                            class="mt-4 inline-flex items-center bg-[#06283D] text-white px-4 py-2 rounded-lg hover:bg-[#001220] transition-colors">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4v16m8-8H4" />
                                            </svg>
                                            Tambah Properti
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($boardingHouses->count() > 0)
                <div
                    class="flex flex-col sm:flex-row justify-between items-center px-6 py-4 border-t border-[#C3C7CD] gap-4">
                    <span class="text-[#42474C] text-sm">
                        Menampilkan 1-{{ $boardingHouses->count() }} dari {{ $boardingHouses->count() }} properti
                    </span>
                    <div class="flex gap-2">
                        <button
                            class="px-4 py-2 border border-[#C3C7CD] rounded-lg text-xs font-semibold tracking-wide text-[#42474C] hover:bg-gray-50 transition-colors opacity-50 cursor-not-allowed"
                            disabled>
                            Sebelumnya
                        </button>
                        <button
                            class="px-4 py-2 bg-[#06283D] text-white rounded-lg text-xs font-semibold tracking-wide hover:bg-[#001220] transition-colors">
                            1
                        </button>
                        <button
                            class="px-4 py-2 border border-[#C3C7CD] rounded-lg text-xs font-semibold tracking-wide text-[#42474C] hover:bg-gray-50 transition-colors opacity-50 cursor-not-allowed"
                            disabled>
                            Selanjutnya
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>
    @foreach ($boardingHouses as $kost)
        <x-owner.delete :boardingHouse="$kost" :id="'delete-modal-' . $kost->id" />
    @endforeach
@endsection
