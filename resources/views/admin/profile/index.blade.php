@extends('layouts.admin')

@section('title', 'Profil Admin - KostMudah')

@section('content')
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
            <div>
                <h1 class="text-[#001220] text-2xl md:text-3xl font-bold">Profil Admin</h1>
                <p class="text-[#42474C] text-sm mt-1">Kelola informasi pribadi dan keamanan akun Anda.</p>
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

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 text-red-800 rounded-lg border border-red-300">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Profile Card -->
        <div class="bg-white p-8 rounded-xl border border-[#C3C7CD] shadow-sm relative overflow-hidden mb-6">
            <div class="absolute -right-16 -top-16 w-64 h-64 bg-[#06283D]/5 rounded-full"></div>
            <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center gap-8">
                <!-- Profile Image -->
                <div class="relative">
                    <div
                        class="w-40 h-40 rounded-full shadow-lg outline outline-4 outline-offset-[-4px] outline-white overflow-hidden flex-shrink-0">
                        @if ($admin->photo)
                            <img class="w-full h-full object-cover" src="{{ Storage::url($admin->photo) }}"
                                alt="{{ $admin->name }}" />
                        @else
                            <img class="w-full h-full object-cover"
                                src="https://placehold.co/152x152/06283D/FFFFFF?text={{ strtoupper(substr($admin->name, 0, 2)) }}"
                                alt="{{ $admin->name }}" />
                        @endif
                    </div>
                    <!-- Upload Photo Button -->
                    <form action="{{ route('admin.profile.updatePhoto') }}" method="POST" enctype="multipart/form-data"
                        class="absolute bottom-0 right-0">
                        @csrf
                        <label for="photoInput"
                            class="p-2 bg-[#0194DC] rounded-full shadow-md hover:bg-[#0179b8] transition-colors cursor-pointer flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </label>
                        <input type="file" name="photo" id="photoInput" accept="image/*" class="hidden"
                            onchange="this.form.submit()">
                    </form>
                    @if ($admin->photo)
                        <form action="{{ route('admin.profile.removePhoto') }}" method="POST"
                            class="absolute -top-2 -right-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="p-1 bg-[#BA1A1A] rounded-full shadow-md hover:bg-[#991B1B] transition-colors"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus foto profil?')">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </form>
                    @endif
                </div>
                <!-- Profile Info -->
                <div class="flex-1">
                    <h2 class="text-[#191C1D] text-3xl font-bold">{{ $admin->name }}</h2>
                    <div class="flex items-center gap-2 mt-1">
                        <div class="px-3 py-1 bg-[#F2F4F5] rounded-full inline-flex items-center gap-1">
                            <svg class="w-2.5 h-3.5 text-[#42474C]" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span class="text-[#42474C] text-xs font-semibold tracking-wide">Super Admin</span>
                        </div>
                    </div>
                    <div class="flex flex-wrap items-center gap-4 mt-3">
                        <div class="flex items-center gap-2">
                            <svg class="w-3.5 h-3.5 text-[#42474C]" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span class="text-[#42474C] text-sm">{{ $admin->email }}</span>
                        </div>
                        @if ($admin->phone)
                            <div class="flex items-center gap-2">
                                <svg class="w-3 h-3 text-[#42474C]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                <span class="text-[#42474C] text-sm">{{ $admin->phone }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Sections -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Informasi Pribadi -->
            <div class="bg-white p-8 rounded-xl border border-[#C3C7CD] shadow-sm">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-8 h-8 bg-[#F2F4F5] rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-[#191C1D]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <h3 class="text-[#191C1D] text-xl font-semibold">Informasi Pribadi</h3>
                </div>

                <form action="{{ route('admin.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="space-y-4">
                        <div>
                            <label class="block text-[#42474C] text-xs font-semibold tracking-wide mb-1.5">Nama
                                Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', $admin->name) }}"
                                class="w-full px-4 py-3 bg-white border border-[#C3C7CD] rounded-lg text-[#191C1D] text-sm focus:outline-none focus:ring-2 focus:ring-[#06283D]">
                        </div>
                        <div>
                            <label class="block text-[#42474C] text-xs font-semibold tracking-wide mb-1.5">Email
                                Utama</label>
                            <input type="email" name="email" value="{{ old('email', $admin->email) }}"
                                class="w-full px-4 py-3 bg-white border border-[#C3C7CD] rounded-lg text-[#191C1D] text-sm focus:outline-none focus:ring-2 focus:ring-[#06283D]">
                        </div>
                        <div>
                            <label class="block text-[#42474C] text-xs font-semibold tracking-wide mb-1.5">Nomor
                                Telepon</label>
                            <input type="tel" name="phone" value="{{ old('phone', $admin->phone) }}"
                                class="w-full px-4 py-3 bg-white border border-[#C3C7CD] rounded-lg text-[#191C1D] text-sm focus:outline-none focus:ring-2 focus:ring-[#06283D]">
                        </div>
                        <div class="flex justify-end pt-2">
                            <button type="submit"
                                class="px-6 py-2.5 bg-[#06283D] text-white font-semibold rounded-lg hover:bg-[#001220] transition-colors">
                                Update Data
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Keamanan & Password -->
            <div class="bg-white p-8 rounded-xl border border-[#C3C7CD] shadow-sm">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-8 h-8 bg-[#F2F4F5] rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-[#191C1D]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <h3 class="text-[#191C1D] text-xl font-semibold">Keamanan & Password</h3>
                </div>

                <form action="{{ route('admin.profile.updatePassword') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="space-y-4">
                        <div>
                            <label class="block text-[#42474C] text-xs font-semibold tracking-wide mb-1.5">Password Saat
                                Ini</label>
                            <div class="relative">
                                <input type="password" name="current_password"
                                    class="w-full px-4 py-3 bg-white border border-[#C3C7CD] rounded-lg text-[#42474C] text-sm focus:outline-none focus:ring-2 focus:ring-[#06283D] pr-10"
                                    placeholder="Masukkan password saat ini">
                                <button type="button"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-[#42474C] hover:text-[#191C1D] toggle-password">
                                    <svg class="w-5 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                            @error('current_password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-[#42474C] text-xs font-semibold tracking-wide mb-1.5">Password
                                Baru</label>
                            <input type="password" name="password"
                                class="w-full px-4 py-3 bg-white border border-[#C3C7CD] rounded-lg text-[#42474C] text-sm focus:outline-none focus:ring-2 focus:ring-[#06283D]"
                                placeholder="Min. 8 karakter">
                            @error('password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-[#42474C] text-xs font-semibold tracking-wide mb-1.5">Konfirmasi
                                Password Baru</label>
                            <input type="password" name="password_confirmation"
                                class="w-full px-4 py-3 bg-white border border-[#C3C7CD] rounded-lg text-[#42474C] text-sm focus:outline-none focus:ring-2 focus:ring-[#06283D]"
                                placeholder="Ulangi password baru">
                        </div>
                        <div class="flex justify-end pt-2">
                            <button type="submit"
                                class="px-6 py-2.5 bg-[#06283D] text-white font-semibold rounded-lg hover:bg-[#001220] transition-colors">
                                Update Password
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row justify-end items-center gap-4">
            <a href="{{ route('admin.dashboard') }}"
                class="w-full sm:w-auto px-8 py-3 bg-[#F2F4F5] text-[#191C1D] text-base font-semibold rounded-lg hover:bg-[#E5E7EB] transition-colors text-center">
                Kembali ke Dashboard
            </a>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Toggle password visibility
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function() {
                const input = this.closest('.relative').querySelector('input');
                const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                input.setAttribute('type', type);

                // Change icon
                const svg = this.querySelector('svg');
                if (type === 'text') {
                    svg.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                `;
                } else {
                    svg.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                `;
                }
            });
        });

        // Auto submit photo upload
        document.getElementById('photoInput')?.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                this.form.submit();
            }
        });
    </script>
@endpush
