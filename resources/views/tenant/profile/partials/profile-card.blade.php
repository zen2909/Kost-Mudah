<div
class="bg-white rounded-xl border p-8 flex justify-between items-center mb-8">

    <div
    class="flex items-center gap-8">

        <div class="relative">

            <img
            src="https://placehold.co/130x130"
            class="w-32 h-32 rounded-full border-4 border-gray-100">

            <button
            class="absolute bottom-1 right-1 w-10 h-10 rounded-full bg-slate-950 flex items-center justify-center">

                <i data-lucide="camera"
                class="w-5 h-5 text-white"></i>

            </button>

        </div>

        <div>

            <h2
            class="text-4xl font-bold">

                {{ Auth::user()->name }}

            </h2>

            <p
            class="text-gray-500 text-lg mt-1">

                {{ Auth::user()->email }}

            </p>

            <div class="flex gap-2 mt-5">

                <span
                class="px-3 py-1 rounded-full bg-cyan-100 text-cyan-900 text-sm">

                    Email Terverifikasi

                </span>

                <span
                class="px-3 py-1 rounded-full bg-gray-100 text-gray-600 text-sm">

                    Identitas Terverifikasi

                </span>

            </div>

        </div>

    </div>

    <button
    class="border px-6 py-3 rounded-lg hover:bg-gray-100">

        Ganti Foto Profil

    </button>

</div>