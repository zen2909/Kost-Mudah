@extends('layouts.owner')

@section('title', 'Profil Pemilik - KostMudah')

@section('content')
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8">
            <div>
                <h1 class="text-[#001220] text-3xl md:text-4xl font-bold leading-10">Profil Pemilik</h1>
                <p class="text-[#42474C] text-base mt-1">Kelola informasi pribadi, detail pembayaran, dan keamanan akun Anda.
                </p>
            </div>
        </div>

        @if (session('success'))
            <div class="mb-6 p-4 bg-green-100 text-green-800 rounded-lg border border-green-300">
                {{ session('success') }}
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

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <!-- Left Column - Profile Card & Stats -->
            <div class="lg:col-span-3 space-y-4">
                <!-- Profile Card -->
                <div class="bg-white rounded-xl border border-[#C3C7CD] shadow-sm p-6 text-center">
                    <!-- Avatar -->
                    <div class="relative inline-block">
                        <img src="{{ $user->photo ? Storage::url($user->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&size=128&background=06283D&color=fff&bold=true' }}"
                            alt="{{ $user->name }}"
                            class="w-32 h-32 rounded-full border-4 border-[#E6E8E9] mx-auto object-cover" id="profilePhoto">
                        <button onclick="document.getElementById('photoInput').click()"
                            class="absolute bottom-0 right-0 p-2 bg-[#001220] rounded-full shadow-lg cursor-pointer hover:bg-[#06283D] transition-colors">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </button>
                        <input type="file" id="photoInput" accept="image/jpeg,image/png,image/jpg" class="hidden"
                            onchange="uploadPhoto(this)">
                    </div>

                    <h2 class="text-[#001220] text-xl font-semibold mt-4">{{ $user->name }}</h2>
                    <p class="text-[#42474C] text-sm">Bergabung sejak {{ $user->created_at->format('M Y') }}</p>

                    @if ($owner && $owner->isVerified())
                        <div class="inline-flex items-center gap-2 mt-3 bg-[#CFE6EF] px-3 py-1 rounded-full">
                            <svg class="w-3 h-3 text-[#52686F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            <span class="text-[#52686F] text-xs font-semibold tracking-wide">Identitas Terverifikasi</span>
                        </div>
                    @else
                        <div class="inline-flex items-center gap-2 mt-3 bg-[#FEF3C7] px-3 py-1 rounded-full">
                            <svg class="w-3 h-3 text-[#92400E]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-[#92400E] text-xs font-semibold tracking-wide">Pending Verifikasi</span>
                        </div>
                    @endif

                    <!-- Tombol Hapus Foto -->
                    @if ($user->photo)
                        <button onclick="removePhoto()"
                            class="mt-3 text-[#BA1A1A] text-xs font-semibold hover:text-red-700 transition-colors">
                            Hapus Foto
                        </button>
                    @endif
                </div>

                <!-- Statistik Akun -->
                <div class="bg-[#06283D] p-6 rounded-xl">
                    <h3 class="text-white text-xl font-semibold mb-4">Statistik Akun</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-white/80 text-base">Total Properti</span>
                            <span class="text-white text-base font-semibold">{{ $totalProperties }} Unit</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-white/80 text-base">Total Penyewa</span>
                            <span class="text-white text-base font-semibold">{{ $totalTenants }} Orang</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-white/80 text-base">Status Verifikasi</span>
                            @if ($owner && $owner->isVerified())
                                <span class="text-green-400 text-base font-semibold">✓ Terverifikasi</span>
                            @else
                                <span class="text-yellow-400 text-base font-semibold">⏳ Pending</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Forms -->
            <div class="lg:col-span-9 space-y-6">
                <!-- Informasi Dasar -->
                <form action="{{ route('owner.profile.update') }}" method="POST"
                    class="bg-white rounded-xl border border-[#C3C7CD] shadow-sm overflow-hidden">
                    @csrf
                    @method('PUT')
                    <div
                        class="flex flex-col sm:flex-row justify-between items-start sm:items-center px-6 py-4 bg-[#F2F4F5] border-b border-[#C3C7CD] gap-3">
                        <h3 class="text-[#001220] text-xl font-semibold">Informasi Dasar</h3>
                        <button type="submit"
                            class="px-4 py-2 bg-[#001220] text-white text-xs font-semibold tracking-wide rounded-lg hover:bg-[#06283D] transition-colors">
                            Simpan Perubahan
                        </button>
                    </div>
                    <div class="p-6 space-y-5">
                        <!-- Nama Lengkap -->
                        <div>
                            <label class="block text-[#42474C] text-xs font-semibold tracking-wide uppercase mb-1.5">Nama
                                Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                class="w-full px-4 py-3 bg-white border border-[#C3C7CD] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#06283D] text-[#191C1D] transition-shadow">
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label
                                class="block text-[#42474C] text-xs font-semibold tracking-wide uppercase mb-1.5">Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                class="w-full px-4 py-3 bg-white border border-[#C3C7CD] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#06283D] text-[#191C1D] transition-shadow">
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nomor Telepon -->
                        <div>
                            <label class="block text-[#42474C] text-xs font-semibold tracking-wide uppercase mb-1.5">Nomor
                                Telepon (WhatsApp)</label>
                            <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}"
                                class="w-full px-4 py-3 bg-white border border-[#C3C7CD] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#06283D] text-[#191C1D] transition-shadow">
                            @error('phone')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- ID Identitas -->
                        <div>
                            <label class="block text-[#42474C] text-xs font-semibold tracking-wide uppercase mb-1.5">ID
                                Identitas (KTP)</label>
                            <input type="text" value="{{ $owner->verification_document ?? 'Belum diunggah' }}" disabled
                                class="w-full px-4 py-3 bg-[#F2F4F5] border border-[#C3C7CD] rounded-lg text-[#42474C] cursor-not-allowed">
                        </div>
                    </div>
                </form>

                <!-- Rekening Pencairan Sewa & Keamanan - 2 Kolom -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Rekening Pencairan Sewa -->
                    <form action="{{ route('owner.profile.updateBank') }}" method="POST"
                        class="bg-white rounded-xl border border-[#C3C7CD] shadow-sm overflow-hidden">
                        @csrf
                        @method('PUT')
                        <div class="px-6 py-4 bg-[#F2F4F5] border-b border-[#C3C7CD]">
                            <h3 class="text-[#001220] text-xl font-semibold">Rekening Pencairan Sewa</h3>
                        </div>
                        <div class="p-6 space-y-4">
                            <!-- Info Alert -->
                            <div class="flex items-start gap-3 p-3 bg-[#CFE6EF]/30 rounded-lg border border-[#CFE6EF]">
                                <svg class="w-4 h-4 text-[#0194DC] flex-shrink-0 mt-0.5" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="text-[#354A51] text-xs">Rekening untuk pencairan dana sewa otomatis.</p>
                            </div>

                            <!-- Bank -->
                            <div>
                                <label
                                    class="block text-[#42474C] text-xs font-semibold tracking-wide uppercase mb-1">Bank</label>
                                <select name="bank_name"
                                    class="w-full px-4 py-2.5 bg-white border border-[#C3C7CD] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#06283D] text-[#191C1D] text-sm transition-shadow">
                                    <option value="BCA" {{ $owner && $owner->bank_name == 'BCA' ? 'selected' : '' }}>
                                        Bank Central Asia (BCA)</option>
                                    <option value="Mandiri"
                                        {{ $owner && $owner->bank_name == 'Mandiri' ? 'selected' : '' }}>Bank Mandiri
                                    </option>
                                    <option value="BRI" {{ $owner && $owner->bank_name == 'BRI' ? 'selected' : '' }}>
                                        Bank Rakyat Indonesia (BRI)</option>
                                    <option value="BNI" {{ $owner && $owner->bank_name == 'BNI' ? 'selected' : '' }}>
                                        Bank Negara Indonesia (BNI)</option>
                                    <option value="BSI" {{ $owner && $owner->bank_name == 'BSI' ? 'selected' : '' }}>
                                        Bank Syariah Indonesia (BSI)</option>
                                </select>
                                @error('bank_name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nomor Rekening -->
                            <div>
                                <label
                                    class="block text-[#42474C] text-xs font-semibold tracking-wide uppercase mb-1">Nomor
                                    Rekening</label>
                                <input type="text" name="bank_account_number"
                                    value="{{ old('bank_account_number', $owner->bank_account_number ?? '') }}"
                                    class="w-full px-4 py-2.5 bg-white border border-[#C3C7CD] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#06283D] text-[#191C1D] text-sm transition-shadow"
                                    placeholder="Masukkan nomor rekening">
                                @error('bank_account_number')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nama Pemilik Rekening -->
                            <div>
                                <label class="block text-[#42474C] text-xs font-semibold tracking-wide uppercase mb-1">Nama
                                    Pemilik Rekening</label>
                                <input type="text" name="bank_account_holder"
                                    value="{{ old('bank_account_holder', $owner->bank_account_holder ?? '') }}"
                                    class="w-full px-4 py-2.5 bg-white border border-[#C3C7CD] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#06283D] text-[#191C1D] text-sm transition-shadow"
                                    placeholder="Masukkan nama pemilik rekening">
                                @error('bank_account_holder')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit"
                                class="w-full py-2.5 bg-[#001220] text-white text-sm font-semibold rounded-lg hover:bg-[#06283D] transition-colors">
                                Update Rekening
                            </button>
                        </div>
                    </form>

                    <!-- Keamanan & Password -->
                    <form action="{{ route('owner.profile.updatePassword') }}" method="POST"
                        class="bg-white rounded-xl border border-[#C3C7CD] shadow-sm overflow-hidden">
                        @csrf
                        @method('PUT')
                        <div class="px-6 py-4 bg-[#F2F4F5] border-b border-[#C3C7CD]">
                            <h3 class="text-[#001220] text-xl font-semibold">Keamanan & Password</h3>
                        </div>
                        <div class="p-6 space-y-4">
                            <!-- Password -->
                            <div class="p-3 bg-[#F8FAFB] rounded-lg border border-[#C3C7CD]">
                                <div class="flex items-center gap-3 mb-3">
                                    <div
                                        class="w-8 h-8 bg-[#001220]/10 rounded-full flex items-center justify-center flex-shrink-0">
                                        <svg class="w-3.5 h-4 text-[#001220]" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-[#001220] text-xs font-semibold tracking-wide">Password Akun</p>
                                        <p class="text-[#42474C] text-xs">Terakhir diubah 3 bulan lalu</p>
                                    </div>
                                </div>
                                <div class="space-y-2.5">
                                    <input type="password" name="current_password" placeholder="Password Saat Ini"
                                        class="w-full px-3 py-2 bg-white border border-[#C3C7CD] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#06283D] text-sm transition-shadow">
                                    @error('current_password')
                                        <p class="text-red-500 text-xs">{{ $message }}</p>
                                    @enderror
                                    <input type="password" name="new_password" placeholder="Password Baru"
                                        class="w-full px-3 py-2 bg-white border border-[#C3C7CD] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#06283D] text-sm transition-shadow">
                                    @error('new_password')
                                        <p class="text-red-500 text-xs">{{ $message }}</p>
                                    @enderror
                                    <input type="password" name="new_password_confirmation"
                                        placeholder="Konfirmasi Password Baru"
                                        class="w-full px-3 py-2 bg-white border border-[#C3C7CD] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#06283D] text-sm transition-shadow">
                                    <button type="submit"
                                        class="w-full py-2 bg-[#001220] text-white text-sm font-semibold rounded-lg hover:bg-[#06283D] transition-colors">
                                        Update Password
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Hapus Akun -->
        <div class="mt-8 p-6 bg-[#FFDAD6]/20 rounded-xl border border-[#BA1A1A]/20">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                <div>
                    <h3 class="text-[#BA1A1A] text-xl font-semibold">Hapus Akun Pemilik</h3>
                    <p class="text-[#93000A] text-sm opacity-80 mt-1">Tindakan ini tidak dapat dibatalkan. Semua data
                        properti dan riwayat akan dihapus secara permanen.</p>
                </div>
                <form action="{{ route('owner.profile.destroy') }}" method="POST"
                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun ini? Tindakan ini tidak dapat dibatalkan.');"
                    class="w-full lg:w-auto">
                    @csrf
                    @method('DELETE')
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                        <input type="password" name="password" placeholder="Konfirmasi Password"
                            class="px-4 py-2.5 border border-[#BA1A1A]/30 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#BA1A1A] text-sm"
                            required>
                        @error('password')
                            <p class="text-red-500 text-xs">{{ $message }}</p>
                        @enderror
                        <button type="submit"
                            class="px-6 py-2.5 border-2 border-[#BA1A1A] rounded-lg text-[#BA1A1A] text-xs font-semibold tracking-wide hover:bg-[#BA1A1A] hover:text-white transition-colors whitespace-nowrap">
                            Ajukan Penghapusan Akun
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Upload photo
        function uploadPhoto(input) {
            if (input.files && input.files[0]) {
                const file = input.files[0];
                const formData = new FormData();
                formData.append('photo', file);

                // Show loading
                const photoImg = document.getElementById('profilePhoto');
                const originalSrc = photoImg.src;
                photoImg.style.opacity = '0.5';

                fetch('{{ route('owner.profile.updatePhoto') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            photoImg.src = data.photo_url + '?t=' + new Date().getTime();
                            photoImg.style.opacity = '1';

                            // Tampilkan notifikasi sukses
                            showNotification('success', data.message);

                            // Refresh halaman setelah 2 detik
                            setTimeout(() => {
                                location.reload();
                            }, 2000);
                        } else {
                            photoImg.style.opacity = '1';
                            showNotification('error', data.message || 'Gagal upload foto');
                        }
                    })
                    .catch(error => {
                        photoImg.style.opacity = '1';
                        showNotification('error', 'Terjadi kesalahan saat upload foto');
                    });
            }
        }

        // Remove photo
        function removePhoto() {
            if (!confirm('Yakin ingin menghapus foto profil?')) return;

            fetch('{{ route('owner.profile.removePhoto') }}', {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification('success', data.message);
                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    }
                })
                .catch(error => {
                    showNotification('error', 'Terjadi kesalahan saat menghapus foto');
                });
        }

        // Notification helper
        function showNotification(type, message) {
            const colors = {
                success: 'bg-green-100 text-green-800 border-green-300',
                error: 'bg-red-100 text-red-800 border-red-300'
            };

            const container = document.createElement('div');
            container.className = `mb-6 p-4 rounded-lg border ${colors[type] || colors.success}`;
            container.textContent = message;

            const header = document.querySelector('.flex.flex-col.md\\:flex-row.justify-between');
            if (header) {
                header.parentNode.insertBefore(container, header.nextSibling);
            }

            setTimeout(() => {
                container.remove();
            }, 5000);
        }
    </script>
@endsection
