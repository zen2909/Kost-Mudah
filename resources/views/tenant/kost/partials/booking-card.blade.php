<div class="bg-white rounded-2xl border shadow-sm sticky top-24 overflow-hidden">

    <!-- Harga -->
    <div class="p-6">

        <p class="text-gray-500 text-sm">
            Mulai Dari
        </p>

        <div class="flex items-end gap-2 mt-2">
            <h2 class="text-4xl font-bold text-slate-900">
                Rp 3.500.000
            </h2>
            <span class="text-gray-500 mb-1">
                /bulan
            </span>
        </div>

    </div>

    <!-- Detail -->
    <div class="border-t">

        <div class="flex justify-between px-6 py-4">
            <span class="text-gray-500">Tipe Kamar</span>
            <span class="font-semibold">Deluxe Queen</span>
        </div>

        <div class="flex justify-between px-6 py-4 border-t">
            <span class="text-gray-500">Minimum Sewa</span>
            <span class="font-semibold">3 Bulan</span>
        </div>

        <div class="flex justify-between px-6 py-4 border-t">
            <span class="text-gray-500">Deposit</span>
            <span class="font-semibold">Rp1.000.000</span>
        </div>

    </div>

    <!-- Tombol -->
    <div class="p-6">

        <a
            href="{{ route('tenant.booking.index') }}"
            class="w-full flex justify-center items-center gap-2 bg-cyan-950 hover:bg-cyan-900 text-white py-4 rounded-xl font-semibold transition">

            <i data-lucide="calendar-check" class="w-5 h-5"></i>

            Sewa Sekarang

        </a>

        <button
            class="mt-3 w-full flex justify-center items-center gap-2 border-2 border-cyan-950 text-cyan-950 hover:bg-cyan-950 hover:text-white py-4 rounded-xl font-semibold transition">

            <i data-lucide="heart" class="w-5 h-5"></i>

            Tambah Favorit

        </button>

    </div>

    <!-- Owner -->
    <div class="border-t bg-slate-50 p-6">

        <div class="flex items-center gap-4">

            <img
                src="https://ui-avatars.com/api/?name=Ibu+Melani&background=0EA5E9&color=fff"
                class="w-14 h-14 rounded-full">

            <div>

                <h4 class="font-bold text-slate-900">
                    Ibu Melani
                </h4>

                <p class="text-sm text-gray-500">
                    Pemilik Kost
                </p>

                <div class="flex items-center gap-2 mt-1">

                    <span class="w-2 h-2 rounded-full bg-green-500"></span>

                    <span class="text-xs text-green-600">
                        Online
                    </span>

                </div>

            </div>

        </div>

        <a
            href="https://wa.me/6281234567890?text=Halo,%20saya%20tertarik%20dengan%20kost%20ini."
            target="_blank"
            class="mt-5 flex items-center justify-center gap-2 w-full bg-[#25D366] hover:bg-[#1EBE5D] text-white py-3 rounded-xl font-semibold transition">

            <i data-lucide="message-circle" class="w-5 h-5"></i>

            Chat WhatsApp

        </a>

    </div>

</div>