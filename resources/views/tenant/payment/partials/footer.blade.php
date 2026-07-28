<div class="border-t border-gray-300 px-6 py-5 flex justify-end gap-4">

    <a
        href="{{ route('tenant.kost.show', $rental->boardingHouse->slug) }}"
        class="px-8 py-3 rounded-lg text-cyan-950 font-semibold hover:bg-gray-100 transition">

        Kembali

    </a>

    <button
        type="submit"
        class="bg-cyan-950 hover:bg-cyan-900 text-white px-8 py-3 rounded-lg flex items-center gap-2 transition">

        Kirim Bukti

        <i data-lucide="send" class="w-5 h-5"></i>

    </button>

</div>