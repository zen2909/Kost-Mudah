@props([
    'boardingHouse' => null,
    'id' => 'delete-modal',
])

<div id="{{ $id }}" class="modal-overlay" style="display: none;">
    <div class="modal-container-confirm">
        <!-- Header -->
        <div class="flex justify-between items-center px-6 py-4 border-b border-[#C3C7CD]">
            <h3 class="text-[#001220] text-xl font-semibold">Konfirmasi Hapus</h3>
            <button onclick="closeDeleteModal('{{ $id }}')"
                class="p-1.5 hover:bg-gray-100 rounded-full transition-colors">
                <svg class="w-3.5 h-3.5 text-[#42474C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Content -->
        <div class="p-6">
            <div class="flex flex-col items-center">
                <!-- Icon -->
                <div class="w-16 h-16 bg-[#FFDAD6] rounded-full flex items-center justify-center">
                    <svg class="w-[33px] h-[28.5px] text-[#BA1A1A]" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </div>

                <!-- Pesan -->
                <div class="mt-4 text-center">
                    <p class="text-[#191C1D] text-xl font-semibold">
                        Yakin ingin menghapus kost
                        <span class="text-[#001220]">{{ $boardingHouse->name ?? 'ini' }}</span>?
                    </p>
                </div>
            </div>

            <!-- Warning -->
            <div class="mt-6 p-4 bg-[#ECEEEF] rounded-lg border-l-4 border-[#BA1A1A]">
                <p class="text-[#BA1A1A] font-bold">Peringatan:</p>
                <p class="text-[#42474C] font-bold">
                    Semua data terkait seperti foto, data sewa, riwayat pembayaran, ulasan, dan favorit akan ikut
                    terhapus secara permanen.
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="flex justify-center gap-3 px-6 pb-6">
            <button onclick="closeDeleteModal('{{ $id }}')"
                class="flex-1 px-6 py-3 border border-[#73777D] rounded-lg text-[#42474C] text-base font-semibold hover:bg-gray-50 transition-colors">
                Batal
            </button>
            <form action="{{ route('owner.kost.destroy', $boardingHouse->id ?? 0) }}" method="POST" class="flex-1">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="w-full px-6 py-3 bg-[#BA1A1A] rounded-lg text-white text-base font-semibold hover:bg-red-700 transition-colors shadow-sm">
                    Ya, Hapus
                </button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        function openDeleteModal(id) {
            const modal = document.getElementById(id);
            if (modal) {
                modal.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            }
        }

        function closeDeleteModal(id) {
            const modal = document.getElementById(id);
            if (modal) {
                modal.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        }

        // Close modal when clicking outside
        document.addEventListener('click', function(event) {
            const modals = document.querySelectorAll('.modal-overlay');
            modals.forEach(modal => {
                if (event.target === modal) {
                    modal.style.display = 'none';
                    document.body.style.overflow = 'auto';
                }
            });
        });
    </script>
@endpush
