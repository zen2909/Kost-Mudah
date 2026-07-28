<div class="bg-white rounded-xl border overflow-hidden mb-8">

    {{-- Header --}}
    <div class="bg-gray-50 border-b px-6 py-4 flex items-center gap-2">

        <i data-lucide="shield-check" class="w-5 h-5 text-slate-900"></i>

        <h3 class="uppercase text-sm font-bold tracking-wide">
            Keamanan
        </h3>

    </div>

    <div class="p-6">

        <div class="grid lg:grid-cols-3 gap-6">

            {{-- Password Lama --}}
            <div>

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Kata Sandi Saat Ini
                </label>

                <input
                    type="password"
                    name="current_password"
                    class="w-full rounded-lg border px-4 py-3 focus:ring-2 focus:ring-cyan-900 focus:outline-none">

                @error('current_password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

            </div>

            {{-- Password Baru --}}
            <div>

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Kata Sandi Baru
                </label>

                <input
                    type="password"
                    name="password"
                    class="w-full rounded-lg border px-4 py-3 focus:ring-2 focus:ring-cyan-900 focus:outline-none">

                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

            </div>

            {{-- Konfirmasi Password --}}
            <div>

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Konfirmasi Password
                </label>

                <input
                    type="password"
                    name="password_confirmation"
                    class="w-full rounded-lg border px-4 py-3 focus:ring-2 focus:ring-cyan-900 focus:outline-none">

            </div>

        </div>

        <div class="mt-4 text-sm text-gray-500">
            Kosongkan semua kolom password jika tidak ingin mengganti kata sandi.
        </div>

    </div>

</div>