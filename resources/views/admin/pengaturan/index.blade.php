@extends('layouts.admin')

@section('title', 'Pengaturan Sistem - KostMudah')

@section('content')
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
            <div>
                <h1 class="text-[#001220] text-2xl md:text-3xl font-bold">Pengaturan Sistem</h1>
                <p class="text-[#42474C] text-sm mt-1">Kelola konfigurasi dan pengaturan umum aplikasi KostMudah.</p>
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

        <form action="{{ route('admin.pengaturan.update') }}" method="POST">
            @csrf
            @method('PUT')

            <!-- General Settings -->
            <div class="bg-white rounded-xl border border-[#C3C7CD] shadow-sm overflow-hidden mb-6">
                <div class="px-6 py-4 bg-[#F8FAFB] border-b border-[#C3C7CD] flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#191C1D]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <h2 class="text-[#191C1D] text-xl font-semibold">General Settings</h2>
                </div>
                <div class="p-6">
                    <!-- Logo Upload -->
                    <div class="flex flex-col items-center pt-4 pb-8">
                        <div class="relative">
                            <div
                                class="w-32 h-32 bg-[#F2F4F5] rounded-xl border border-[#C3C7CD] flex items-center justify-center overflow-hidden">
                                @if ($logo && Storage::exists($logo))
                                    <img class="w-full h-full object-cover" src="{{ Storage::url($logo) }}"
                                        alt="Logo" />
                                @else
                                    <svg class="w-10 h-9 text-[#42474C]" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                @endif
                            </div>
                            <label for="logoInput"
                                class="absolute bottom-0 right-0 p-2 bg-[#06283D] rounded-full shadow-lg hover:bg-[#001220] transition-colors cursor-pointer">
                                <svg class="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </label>
                            <input type="file" name="logo" id="logoInput" accept="image/*" class="hidden"
                                onchange="document.getElementById('logoForm').submit()">
                        </div>
                        <p class="text-[#42474C] text-xs font-medium uppercase tracking-wide mt-4">LOGO APLIKASI (1:1 RATIO)
                        </p>
                        @if ($logo)
                            <button type="button"
                                onclick="if(confirm('Apakah Anda yakin ingin menghapus logo?')){ document.getElementById('removeLogoForm').submit(); }"
                                class="mt-2 text-[#BA1A1A] text-xs font-semibold hover:underline">
                                Hapus Logo
                            </button>
                        @endif
                    </div>

                    <!-- Form Fields -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-[#191C1D] text-sm font-bold mb-1.5">Nama Aplikasi</label>
                            <input type="text" name="app_name" value="{{ old('app_name', $appName) }}"
                                class="w-full px-4 py-2.5 bg-white border border-[#C3C7CD] rounded-lg text-[#191C1D] text-base focus:outline-none focus:ring-2 focus:ring-[#06283D]">
                            @error('app_name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-[#191C1D] text-sm font-bold mb-1.5">Deskripsi Aplikasi</label>
                            <textarea name="app_description" rows="3"
                                class="w-full px-4 py-2.5 bg-white border border-[#C3C7CD] rounded-lg text-[#191C1D] text-base focus:outline-none focus:ring-2 focus:ring-[#06283D] resize-none">{{ old('app_description', $appDescription) }}</textarea>
                            @error('app_description')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- System Configuration -->
            <div class="bg-white rounded-xl border border-[#C3C7CD] shadow-sm overflow-hidden mb-6">
                <div class="px-6 py-4 bg-[#F8FAFB] border-b border-[#C3C7CD] flex items-center gap-2">
                    <svg class="w-4 h-4 text-[#191C1D]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <h2 class="text-[#191C1D] text-xl font-semibold">System Configuration</h2>
                </div>
                <div class="p-6 space-y-6">
                    <!-- Biaya Admin -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-[#191C1D] text-sm font-bold mb-1.5">Biaya Admin per Transaksi
                                (Rp)</label>
                            <div class="relative">
                                <span
                                    class="absolute left-4 top-1/2 -translate-y-1/2 text-[#42474C] text-base font-semibold">Rp</span>
                                <input type="number" name="admin_fee" value="{{ old('admin_fee', $adminFee) }}"
                                    class="w-full pl-12 pr-4 py-2.5 bg-white border border-[#C3C7CD] rounded-lg text-[#191C1D] text-base focus:outline-none focus:ring-2 focus:ring-[#06283D]">
                            </div>
                            <p class="text-[#42474C] text-xs mt-1">Biaya ini akan dibebankan kepada tenant pada setiap
                                pembayaran sewa.</p>
                            @error('admin_fee')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-[#191C1D] text-sm font-bold mb-1.5">Minimal Penarikan Dana (Rp)</label>
                            <div class="relative">
                                <span
                                    class="absolute left-4 top-1/2 -translate-y-1/2 text-[#42474C] text-base font-semibold">Rp</span>
                                <input type="number" name="min_withdrawal"
                                    value="{{ old('min_withdrawal', $minWithdrawal) }}"
                                    class="w-full pl-12 pr-4 py-2.5 bg-white border border-[#C3C7CD] rounded-lg text-[#191C1D] text-base focus:outline-none focus:ring-2 focus:ring-[#06283D]">
                            </div>
                            @error('min_withdrawal')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Notifikasi Email -->
                    <div class="pt-4 border-t border-[#C3C7CD]">
                        <h3 class="text-[#191C1D]/60 text-sm font-bold uppercase tracking-wider mb-4">NOTIFIKASI EMAIL</h3>
                        <div class="space-y-3">
                            <!-- Invoice Pembayaran -->
                            <div
                                class="flex items-center justify-between p-3 pl-3 pr-2.5 border border-[#C3C7CD] rounded-lg">
                                <div class="flex items-center gap-3">
                                    <div class="p-2 bg-[#06283D]/10 rounded-sm">
                                        <svg class="w-4 h-3.5 text-[#06283D]" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-[#191C1D] text-sm font-semibold">Invoice Pembayaran</p>
                                        <p class="text-[#42474C] text-xs">Kirim email otomatis saat tagihan dibuat.</p>
                                    </div>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="hidden" name="email_invoice" value="false">
                                    <input type="checkbox" name="email_invoice" value="true"
                                        {{ $emailInvoice == 'true' ? 'checked' : '' }} class="sr-only peer">
                                    <div
                                        class="w-10 h-5 bg-[#C3C7CD] rounded-full peer peer-checked:bg-[#06283D] transition-colors">
                                        <div
                                            class="w-4 h-4 bg-white rounded-full absolute right-1 top-0.5 shadow-sm peer-checked:right-1 peer-checked:translate-x-5 transition-transform">
                                        </div>
                                    </div>
                                </label>
                            </div>

                            <!-- Pengingat Jatuh Tempo -->
                            <div
                                class="flex items-center justify-between p-3 pl-3 pr-2.5 border border-[#C3C7CD] rounded-lg">
                                <div class="flex items-center gap-3">
                                    <div class="p-2 bg-[#06283D]/10 rounded-sm">
                                        <svg class="w-4 h-4 text-[#06283D]" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-[#191C1D] text-sm font-semibold">Pengingat Jatuh Tempo</p>
                                        <p class="text-[#42474C] text-xs">Kirim pengingat H-3 sebelum tanggal jatuh tempo.
                                        </p>
                                    </div>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="hidden" name="email_reminder" value="false">
                                    <input type="checkbox" name="email_reminder" value="true"
                                        {{ $emailReminder == 'true' ? 'checked' : '' }} class="sr-only peer">
                                    <div
                                        class="w-10 h-5 bg-[#C3C7CD] rounded-full peer peer-checked:bg-[#06283D] transition-colors">
                                        <div
                                            class="w-4 h-4 bg-white rounded-full absolute right-1 top-0.5 shadow-sm peer-checked:right-1 peer-checked:translate-x-5 transition-transform">
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Danger Zone -->
            <div class="bg-white rounded-xl border border-[#BA1A1A]/20 shadow-sm overflow-hidden mb-6">
                <div class="px-6 py-4 bg-[#BA1A1A]/10 border-b border-[#BA1A1A]/10 flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#BA1A1A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <h2 class="text-[#BA1A1A] text-xl font-semibold">Danger Zone</h2>
                </div>
                <div class="p-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div>
                        <p class="text-[#191C1D] text-sm font-bold">Maintenance Mode</p>
                        <p class="text-[#42474C] text-sm max-w-2xl">Saat diaktifkan, user tidak dapat mengakses aplikasi.
                            Hanya admin yang dapat login untuk melakukan pemeliharaan.</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer flex-shrink-0">
                        <input type="hidden" name="maintenance_mode" value="false">
                        <input type="checkbox" name="maintenance_mode" value="true"
                            {{ $maintenanceMode == 'true' ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-14 h-7 bg-[#C3C7CD] rounded-full peer peer-checked:bg-[#BA1A1A] transition-colors">
                            <div
                                class="w-6 h-6 bg-white rounded-full absolute left-1 top-0.5 border border-[#C3C7CD] shadow-sm peer-checked:right-1 peer-checked:left-auto transition-transform">
                            </div>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row justify-end items-center gap-4 pt-4">
                <a href="{{ route('admin.pengaturan.index') }}"
                    class="w-full sm:w-auto px-6 py-2.5 text-[#42474C] text-base font-semibold hover:text-[#191C1D] transition-colors text-center">
                    Batalkan Perubahan
                </a>
                <button type="submit"
                    class="w-full sm:w-auto px-8 py-2.5 bg-[#06283D] text-white text-base font-bold rounded-lg hover:bg-[#001220] transition-colors shadow-md flex items-center justify-center gap-2">
                    <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>

        <!-- Form untuk upload logo -->
        <form id="logoForm" action="{{ route('admin.pengaturan.uploadLogo') }}" method="POST"
            enctype="multipart/form-data" style="display:none;">
            @csrf
            <input type="file" name="logo" accept="image/*">
        </form>

        <!-- Form untuk hapus logo -->
        <form id="removeLogoForm" action="{{ route('admin.pengaturan.removeLogo') }}" method="POST"
            style="display:none;">
            @csrf
            @method('DELETE')
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        // Toggle switch styling - sudah handle oleh Tailwind peer
        console.log('Pengaturan page loaded');
    </script>
@endpush
