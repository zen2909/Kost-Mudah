<div class="border-t border-gray-300 px-6 py-5 flex justify-end gap-4">

    <a
        href="{{ url()->previous() }}"
        class="px-8 py-3 rounded-lg text-cyan-950 font-semibold hover:bg-gray-100 transition">

        Batal

    </a>

    <button
        class="bg-cyan-950 hover:bg-cyan-900 text-white px-10 py-3 rounded-lg flex items-center gap-2 transition">

        <a
            href="{{ route('tenant.invoice.index') }}"
            class="bg-cyan-950 hover:bg-cyan-900 text-white px-10 py-3 rounded-lg flex items-center gap-2">

            Kirim Bukti

            <i data-lucide="send"></i>

        </a>


    </button>

</div>