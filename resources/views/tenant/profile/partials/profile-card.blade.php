<div class="bg-white rounded-xl border p-8 flex justify-between items-center mb-8">

    <div class="flex items-center gap-8">

        <div class="relative">

            {{-- Preview Foto --}}
            <img
                id="preview"
                src="{{ Auth::user()->photo ? asset('storage/'.Auth::user()->photo) : 'https://placehold.co/130x130' }}"
                class="w-32 h-32 rounded-full border-4 border-gray-100 object-cover">

            {{-- Input File --}}
            <input
                type="file"
                id="photo"
                name="photo"
                accept="image/*"
                class="hidden"
                onchange="previewPhoto(event)">

            {{-- Tombol Kamera --}}
            <button
                type="button"
                onclick="choosePhoto()"
                class="absolute bottom-1 right-1 w-10 h-10 rounded-full bg-slate-950 flex items-center justify-center hover:bg-slate-800">

                <i data-lucide="camera" class="w-5 h-5 text-white"></i>

            </button>

        </div>

        <div>

            <h2 class="text-4xl font-bold">
                {{ Auth::user()->name }}
            </h2>

            <p class="text-gray-500 text-lg mt-1">
                {{ Auth::user()->email }}
            </p>

            <div class="flex gap-2 mt-5">

                @if(Auth::user()->email_verified_at)

                    <span class="px-3 py-1 rounded-full bg-cyan-100 text-cyan-900 text-sm">
                        Email Terverifikasi
                    </span>

                @else

                    <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-sm">
                        Email Belum Terverifikasi
                    </span>

                @endif

                @if(Auth::user()->tenant?->verification_status == 'verified')

                    <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm">
                        Identitas Terverifikasi
                    </span>

                @elseif(Auth::user()->tenant?->verification_status == 'pending')

                    <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-sm">
                        Verifikasi Pending
                    </span>

                @else

                    <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-700 text-sm">
                        Belum Verifikasi
                    </span>

                @endif

            </div>

        </div>

    </div>

    {{-- Tombol Pilih Foto --}}
    <button
        type="button"
        onclick="choosePhoto()"
        class="border px-6 py-3 rounded-lg hover:bg-gray-100">

        Ganti Foto Profil

    </button>

</div>