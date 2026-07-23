<div class="border-t mt-6 px-6 py-5 flex gap-4">

    <button

        onclick="window.print()"

        class="flex-1 border-2 border-cyan-950 text-cyan-950 rounded-xl py-4 font-bold hover:bg-cyan-50">

        <i data-lucide="printer" class="inline w-5 h-5 mr-2"></i>

        Cetak Invoice

    </button>

    <a href="{{ route('tenant.bills.index') }}"
        class="flex-1 bg-cyan-950 hover:bg-cyan-900 text-white rounded-xl py-4 text-center font-bold">

        Tutup

    </a>
</div>