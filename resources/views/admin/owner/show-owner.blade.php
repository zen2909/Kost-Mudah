@extends('layouts.admin')

@section('title', 'Detail Pemilik - KostMudah')

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
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <h2 class="text-[#001220] text-xl font-semibold">Detail Pemilik</h2>
                        @php
                            $status = $owner->getVerificationStatusAttribute();
                            $statusColors = [
                                'approved' => 'bg-[#DCFCE7] text-[#15803D]',
                                'pending' => 'bg-[#FEF3C7] text-[#92400E]',
                                'rejected' => 'bg-[#FEE2E2] text-[#991B1B]',
                                'unverified' => 'bg-[#F2F4F5] text-[#42474C]',
                            ];
                            $statusLabels = [
                                'approved' => 'Terverifikasi',
                                'pending' => 'Pending',
                                'rejected' => 'Ditolak',
                                'unverified' => 'Belum Verifikasi',
                            ];
                        @endphp
                        <span
                            class="inline-block {{ $statusColors[$status] ?? 'bg-[#F2F4F5] text-[#42474C]' }} text-[10px] font-bold uppercase px-2.5 py-0.5 rounded-full">
                            {{ $statusLabels[$status] ?? 'Unknown' }}
                        </span>
                    </div>
                    <a href="{{ route('admin.owners.index') }}"
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
                            @if ($owner->photo)
                                <img src="{{ Storage::url($owner->photo) }}" alt="{{ $owner->name }}"
                                    class="w-14 h-14 rounded-full object-cover border-2 border-[#C3C7CD]">
                            @else
                                <div
                                    class="w-14 h-14 rounded-full bg-[#06283D] flex items-center justify-center flex-shrink-0">
                                    <span
                                        class="text-white text-lg font-bold">{{ strtoupper(substr($owner->name, 0, 2)) }}</span>
                                </div>
                            @endif
                            <div>
                                <h4 class="text-[#191C1D] text-base font-bold">{{ $owner->name }}</h4>
                                <p class="text-[#42474C] text-sm">{{ $owner->email }}</p>
                            </div>
                        </div>

                        <div>
                            <p class="text-[#42474C] text-xs font-semibold tracking-wide uppercase">Nama Lengkap</p>
                            <p class="text-[#191C1D] text-base mt-1">{{ $owner->name }}</p>
                        </div>

                        <div>
                            <p class="text-[#42474C] text-xs font-semibold tracking-wide uppercase">Email</p>
                            <p class="text-[#191C1D] text-base mt-1">{{ $owner->email }}</p>
                        </div>

                        <div>
                            <p class="text-[#42474C] text-xs font-semibold tracking-wide uppercase">Nomor Telepon</p>
                            <p class="text-[#191C1D] text-base mt-1">{{ $owner->phone ?? '-' }}</p>
                        </div>

                        @if ($owner->owner && $owner->owner->rejection_reason)
                            <div>
                                <p class="text-[#42474C] text-xs font-semibold tracking-wide uppercase">Alasan Ditolak</p>
                                <p class="text-[#BA1A1A] text-sm mt-1 bg-[#FEE2E2] p-3 rounded-lg">
                                    {{ $owner->owner->rejection_reason }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-4">
                        <div>
                            <p class="text-[#42474C] text-xs font-semibold tracking-wide uppercase">Status Verifikasi</p>
                            <span
                                class="inline-block {{ $statusColors[$status] ?? 'bg-[#F2F4F5] text-[#42474C]' }} text-xs font-bold uppercase px-3 py-1 rounded-full mt-1">
                                {{ $statusLabels[$status] ?? 'Unknown' }}
                            </span>
                        </div>

                        <div>
                            <p class="text-[#42474C] text-xs font-semibold tracking-wide uppercase">Bergabung Sejak</p>
                            <p class="text-[#191C1D] text-base mt-1">{{ $owner->created_at->format('d M Y') }}</p>
                        </div>

                        @if ($owner->owner && $owner->owner->verified_at)
                            <div>
                                <p class="text-[#42474C] text-xs font-semibold tracking-wide uppercase">Diverifikasi Pada
                                </p>
                                <p class="text-[#191C1D] text-base mt-1">{{ $owner->owner->verified_at->format('d M Y') }}
                                </p>
                            </div>
                        @endif

                        <div>
                            <p class="text-[#42474C] text-xs font-semibold tracking-wide uppercase">Total Properti</p>
                            <p class="text-[#191C1D] text-base mt-1">{{ $owner->boardingHouses->count() }} Unit</p>
                        </div>

                        <!-- Daftar Properti -->
                        <div>
                            <p class="text-[#42474C] text-xs font-semibold tracking-wide uppercase">Daftar Properti</p>
                            @if ($owner->boardingHouses->count() > 0)
                                <div class="mt-2 space-y-2">
                                    @foreach ($owner->boardingHouses as $house)
                                        <div class="bg-[#F2F4F5] rounded-lg p-3 flex justify-between items-center">
                                            <div>
                                                <p class="text-[#191C1D] text-sm font-semibold">{{ $house->name }}</p>
                                                <p class="text-[#42474C] text-xs">
                                                    {{ $house->address ?? 'Alamat tidak tersedia' }}</p>
                                                <p class="text-[#42474C] text-xs">Total: {{ $house->total_rooms ?? 0 }}
                                                    kamar | Tersedia: {{ $house->available_rooms ?? 0 }}</p>
                                            </div>
                                            <span
                                                class="text-[#42474C] text-xs bg-white px-2 py-1 rounded-full {{ $house->status == 'active' ? 'text-[#15803D]' : 'text-[#42474C]' }}">
                                                {{ $house->status == 'active' ? 'Aktif' : 'Nonaktif' }}
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-[#42474C] text-sm mt-2 italic">Belum memiliki properti</p>
                            @endif
                        </div>

                        <!-- Daftar Dokumen -->
                        <div>
                            <p class="text-[#42474C] text-xs font-semibold tracking-wide uppercase">Daftar Dokumen</p>
                            @if ($owner->documents->count() > 0)
                                <div class="mt-2 space-y-2">
                                    @foreach ($owner->documents as $doc)
                                        <div class="bg-[#F2F4F5] rounded-lg p-3 flex justify-between items-center">
                                            <div>
                                                <p class="text-[#191C1D] text-sm font-semibold">
                                                    {{ $doc->document_type_label }}</p>
                                                <p class="text-[#42474C] text-xs">No: {{ $doc->document_number ?? '-' }}
                                                </p>
                                                <p class="text-[#42474C] text-xs">Upload:
                                                    {{ $doc->created_at->format('d M Y') }}</p>
                                            </div>
                                            @php
                                                $docStatusColors = [
                                                    'verified' => 'bg-[#DCFCE7] text-[#15803D]',
                                                    'pending' => 'bg-[#FEF3C7] text-[#92400E]',
                                                    'rejected' => 'bg-[#FEE2E2] text-[#991B1B]',
                                                ];
                                                $docStatusLabels = [
                                                    'verified' => 'Terverifikasi',
                                                    'pending' => 'Pending',
                                                    'rejected' => 'Ditolak',
                                                ];
                                            @endphp
                                            <span
                                                class="text-[#42474C] text-xs bg-white px-2 py-1 rounded-full {{ $docStatusColors[$doc->status] ?? 'bg-[#F2F4F5] text-[#42474C]' }}">
                                                {{ $docStatusLabels[$doc->status] ?? $doc->status }}
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-[#42474C] text-sm mt-2 italic">Belum ada dokumen</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="flex justify-end pt-4 mt-4 border-t border-[#C3C7CD]">
                    <a href="{{ route('admin.owners.index') }}"
                        class="px-6 py-2 border border-[#C3C7CD] rounded-lg text-[#42474C] font-semibold hover:bg-gray-50 transition-colors">
                        Tutup
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
