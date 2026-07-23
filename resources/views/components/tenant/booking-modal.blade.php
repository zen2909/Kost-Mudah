<!-- Booking Modal -->
<div id="bookingModal" class="modal-overlay hidden" style="display: none;">
    <div class="modal-container max-w-[500px] w-full bg-white rounded-xl shadow-2xl overflow-hidden">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-neutral-300 flex justify-between items-center">
            <div>
                <h2 class="text-slate-950 text-xl font-semibold leading-7">Form Pemesanan</h2>
            </div>
            <button onclick="closeBookingModal()" class="p-2 hover:bg-gray-100 rounded-full transition-colors">
                <svg class="w-5 h-5 text-zinc-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Body -->
        <div class="max-h-[819px] p-6 overflow-y-auto">
            <!-- Kost Info -->
            <div id="booking-kost-info"
                class="p-3 bg-gray-100 rounded-lg outline outline-1 outline-offset-[-1px] outline-neutral-300 flex items-center gap-4">
                <div class="w-20 h-20 rounded-md overflow-hidden flex-shrink-0">
                    <img id="booking-kost-image" class="w-full h-full object-cover" src="" alt="Kost" />
                </div>
                <div>
                    <span class="text-sky-500 text-xs font-semibold uppercase tracking-wide">SEWA KOST</span>
                    <h3 id="booking-kost-name" class="text-slate-950 text-base font-bold leading-6">Kost Menteng
                        Residence</h3>
                    <p id="booking-kost-price" class="text-zinc-700 text-sm font-normal leading-5">Rp 3.500.000 / bln
                    </p>
                </div>
            </div>

            <!-- Durasi Sewa -->
            <div class="mt-4">
                <label class="text-slate-950 text-sm font-semibold leading-5 block mb-2">Pilih Durasi Sewa</label>
                <div id="duration-options" class="grid grid-cols-2 gap-2">
                    <!-- Durations will be inserted by JS -->
                </div>
            </div>

            <!-- Tanggal Mulai Sewa -->
            <div class="mt-4">
                <label class="text-slate-950 text-sm font-semibold leading-5 block mb-2">Tanggal Mulai Sewa</label>
                <div class="relative">
                    <input type="date" id="booking-start-date"
                        class="w-full px-4 py-3 bg-white rounded-lg outline outline-1 outline-offset-[-1px] outline-neutral-300 text-zinc-900 text-base font-normal focus:outline-2 focus:outline-cyan-950 transition-all"
                        min="{{ date('Y-m-d', strtotime('+3 days')) }}" />
                </div>
                <p class="text-zinc-700 text-xs leading-4 mt-1">Check-in dapat dilakukan mulai pukul 14:00 WIB.</p>
            </div>

            <!-- Summary -->
            <div id="booking-summary"
                class="mt-4 p-4 bg-gray-100 rounded-xl outline outline-1 outline-offset-[-1px] outline-neutral-300">
                <div class="flex justify-between items-center">
                    <span class="text-zinc-700 text-sm font-normal">Harga Sewa</span>
                    <span id="summary-price" class="text-slate-950 text-sm font-medium">Rp 0</span>
                </div>
                <div class="flex justify-between items-center mt-2">
                    <span class="text-zinc-700 text-sm font-normal">Durasi</span>
                    <span id="summary-duration" class="text-slate-950 text-sm font-medium">1 Bulan</span>
                </div>
                <div class="pt-3 mt-2 border-t border-neutral-300 flex justify-between items-end">
                    <span class="text-slate-950 text-base font-semibold">Total Pembayaran</span>
                    <span id="summary-total" class="text-cyan-950 text-xl font-bold">Rp 0</span>
                </div>
            </div>

            <!-- Action Buttons -->
            <button onclick="processBooking()" id="booking-submit-btn"
                class="w-full mt-4 py-4 bg-cyan-950 rounded-lg shadow-[0px_1px_2px_0px_rgba(0,0,0,0.05)] text-white text-base font-semibold hover:bg-cyan-900 transition-colors">
                Lanjutkan ke Pembayaran
            </button>

            <div class="mt-3 px-4 text-center">
                <p class="text-zinc-700 text-xs leading-4">
                    Dengan menekan tombol di atas, Anda menyetujui
                    <span class="underline">Syarat & Ketentuan</span>
                    <br />penyewaan KostMudah.
                </p>
            </div>
        </div>
    </div>
</div>
