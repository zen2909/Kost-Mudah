<div class="bg-white rounded-xl border overflow-hidden mb-8">

    {{-- Header --}}
    <div class="bg-gray-50 border-b px-6 py-4 flex items-center gap-2">

        <i data-lucide="user" class="w-5 h-5 text-slate-900"></i>

        <h3 class="uppercase text-sm font-bold tracking-wide">
            Informasi Pribadi
        </h3>

    </div>

    <div class="p-6">

        <div class="grid lg:grid-cols-2 gap-6">

            {{-- Nama --}}
            <div>

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Nama Lengkap
                </label>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name', Auth::user()->name) }}"
                    class="w-full rounded-lg border px-4 py-3 focus:ring-2 focus:ring-cyan-900 focus:outline-none">

                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

            </div>

            {{-- Email --}}
            <div>

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Email
                </label>

                <input
                    type="email"
                    value="{{ Auth::user()->email }}"
                    disabled
                    class="w-full rounded-lg border px-4 py-3 bg-gray-100">

            </div>

            {{-- Telepon --}}
            <div>

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Nomor Telepon
                </label>

                <input
                    type="text"
                    name="phone"
                    value="{{ old('phone', Auth::user()->phone) }}"
                    class="w-full rounded-lg border px-4 py-3 focus:ring-2 focus:ring-cyan-900 focus:outline-none">

                @error('phone')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

            </div>

            {{-- Pekerjaan --}}
            <div>

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Pekerjaan
                </label>

                <input
                    type="text"
                    name="occupation"
                    value="{{ old('occupation', Auth::user()->tenant?->occupation) }}"
                    class="w-full rounded-lg border px-4 py-3 focus:ring-2 focus:ring-cyan-900 focus:outline-none">

                @error('occupation')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

            </div>

            {{-- Jenis Kelamin --}}
            <div>

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Jenis Kelamin
                </label>

                <select
                    name="gender"
                    class="w-full rounded-lg border px-4 py-3 focus:ring-2 focus:ring-cyan-900 focus:outline-none">

                    <option value="">Pilih Jenis Kelamin</option>

                    <option value="L"
                        {{ old('gender', Auth::user()->tenant?->gender) == 'L' ? 'selected' : '' }}>
                        Laki-laki
                    </option>

                    <option value="P"
                        {{ old('gender', Auth::user()->tenant?->gender) == 'P' ? 'selected' : '' }}>
                        Perempuan
                    </option>

                </select>

                @error('gender')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

            </div>

        </div>

    </div>

</div>