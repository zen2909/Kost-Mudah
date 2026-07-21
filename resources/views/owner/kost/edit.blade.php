@extends('layouts.owner')

@section('title', 'Edit Kost - KostMudah')

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endpush

@section('content')
    <!-- Modal Overlay -->
    <div class="modal-overlay">
        <!-- Modal Container -->
        <div class="modal-container">
            <!-- Header -->
            <div
                class="flex justify-between items-center px-6 py-4 bg-[#F8FAFB] border-b border-[#C3C7CD] sticky-top rounded-t-xl">
                <h2 class="text-[#001220] text-xl font-semibold">Edit Properti</h2>
                <a href="{{ route('owner.kost.index') }}" class="p-2 hover:bg-gray-200 rounded-full transition-colors">
                    <svg class="w-3.5 h-3.5 text-[#42474C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </a>
            </div>

            <form action="{{ route('owner.kost.update', $boardingHouse->id) }}" method="POST" enctype="multipart/form-data"
                class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <!-- Nama Kost -->
                <div>
                    <label class="block text-[#42474C] text-xs font-semibold tracking-wide mb-1.5">
                        NAMA KOST <span class="text-[#BA1A1A]">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name', $boardingHouse->name) }}" required
                        class="w-full px-4 py-3.5 bg-white border border-[#C3C7CD] rounded-lg input-focus text-[#191C1D]"
                        placeholder="Kost Putri Mulyosari">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Alamat Lengkap -->
                <div>
                    <label class="block text-[#42474C] text-xs font-semibold tracking-wide mb-1.5">
                        ALAMAT LENGKAP <span class="text-[#BA1A1A]">*</span>
                    </label>
                    <textarea name="address" required rows="3"
                        class="w-full px-4 py-3 bg-white border border-[#C3C7CD] rounded-lg input-focus text-[#191C1D] resize-none"
                        placeholder="Masukkan alamat lengkap kost">{{ old('address', $boardingHouse->address) }}</textarea>
                    @error('address')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Koordinat Lokasi -->
                <div>
                    <label class="block text-[#42474C] text-xs font-semibold tracking-wide mb-1.5">
                        KOORDINAT LOKASI <span class="text-[#BA1A1A]">*</span>
                    </label>
                    <div class="space-y-3">
                        <div class="flex gap-4">
                            <div class="flex-1">
                                <input type="text" name="latitude" id="latitude"
                                    value="{{ old('latitude', $boardingHouse->latitude ?? '-7.2575') }}"
                                    class="w-full px-4 py-3 bg-[#F8FAFB] border border-[#C3C7CD] rounded-lg text-[#42474C] cursor-not-allowed"
                                    placeholder="Latitude" readonly>
                            </div>
                            <div class="flex-1">
                                <input type="text" name="longitude" id="longitude"
                                    value="{{ old('longitude', $boardingHouse->longitude ?? '112.7521') }}"
                                    class="w-full px-4 py-3 bg-[#F8FAFB] border border-[#C3C7CD] rounded-lg text-[#42474C] cursor-not-allowed"
                                    placeholder="Longitude" readonly>
                            </div>
                        </div>

                        <!-- Map Container -->
                        <div id="kost-map"></div>

                        <button type="button" id="getLocationBtn"
                            class="w-full px-6 py-3 border border-[#001220] rounded-lg text-[#001220] text-sm font-bold hover:bg-[#001220] hover:text-white transition-colors flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Gunakan Lokasi Saya
                        </button>
                    </div>
                    @error('latitude')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    @error('longitude')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kelurahan & Jenis Kost -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[#42474C] text-xs font-semibold tracking-wide mb-1.5">
                            KELURAHAN <span class="text-[#BA1A1A]">*</span>
                        </label>
                        <select name="kelurahan" required
                            class="w-full px-4 py-3 bg-white border border-[#C3C7CD] rounded-lg input-focus text-[#191C1D]">
                            <option value="">Pilih Kelurahan</option>
                            @php
                                $kelurahans = [
                                    'Tebet',
                                    'Menteng',
                                    'Kuningan',
                                    'Mulyosari',
                                    'Senopati',
                                    'Grogol',
                                    'Kemanggisan',
                                ];
                            @endphp
                            @foreach ($kelurahans as $kel)
                                <option value="{{ $kel }}"
                                    {{ old('kelurahan', $boardingHouse->kelurahan) == $kel ? 'selected' : '' }}>
                                    {{ $kel }}
                                </option>
                            @endforeach
                        </select>
                        @error('kelurahan')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-[#42474C] text-xs font-semibold tracking-wide mb-1.5">
                            JENIS KOST <span class="text-[#BA1A1A]">*</span>
                        </label>
                        <div class="flex gap-6 pt-1">
                            @php
                                $types = ['putra' => 'Putra', 'putri' => 'Putri', 'campur' => 'Campur'];
                            @endphp
                            @foreach ($types as $value => $label)
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="type" value="{{ $value }}"
                                        {{ old('type', $boardingHouse->type) == $value ? 'checked' : '' }}
                                        class="w-5 h-5 border-[#73777D] text-[#06283D] focus:ring-[#06283D]">
                                    <span class="text-[#191C1D] text-base">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('type')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Harga & Jumlah Kamar -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[#42474C] text-xs font-semibold tracking-wide mb-1.5">
                            HARGA PER BULAN <span class="text-[#BA1A1A]">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#001220] font-bold">Rp</span>
                            <input type="number" name="price_per_month"
                                value="{{ old('price_per_month', $boardingHouse->price_per_month) }}" required
                                class="w-full pl-10 pr-4 py-3 bg-white border border-[#C3C7CD] rounded-lg input-focus text-[#191C1D]"
                                placeholder="0" min="0">
                        </div>
                        @error('price_per_month')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-[#42474C] text-xs font-semibold tracking-wide mb-1.5">
                            JUMLAH KAMAR <span class="text-[#BA1A1A]">*</span>
                        </label>
                        <input type="number" name="total_rooms"
                            value="{{ old('total_rooms', $boardingHouse->total_rooms) }}" required
                            class="w-full px-4 py-3 bg-white border border-[#C3C7CD] rounded-lg input-focus text-[#191C1D]"
                            placeholder="1" min="1">
                        @error('total_rooms')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Fasilitas Kost -->
                <div>
                    <label class="block text-[#42474C] text-xs font-semibold tracking-wide mb-1.5">
                        FASILITAS KOST
                    </label>
                    <div class="p-4 bg-[#F8FAFB] border border-[#C3C7CD] rounded-lg grid grid-cols-2 md:grid-cols-3 gap-1">
                        @php
                            $facilities = [
                                'WiFi',
                                'AC',
                                'KM Dalam',
                                'Dapur Umum',
                                'Parkir Motor',
                                'Parkir Mobil',
                                'Laundry',
                                'Lemari',
                                'Meja Belajar',
                                'Air Panas',
                                'TV',
                                'Kulkas',
                            ];
                            $selectedFacilities = old('facilities', $boardingHouse->facilities ?? []);
                        @endphp
                        @foreach ($facilities as $facility)
                            <label class="flex items-center gap-3 p-2 rounded-lg hover:bg-white/50 cursor-pointer">
                                <input type="checkbox" name="facilities[]" value="{{ $facility }}"
                                    class="w-4 h-4 border-[#C3C7CD] rounded text-[#06283D] focus:ring-[#06283D]"
                                    {{ in_array($facility, (array) $selectedFacilities) ? 'checked' : '' }}>
                                <span class="text-[#42474C] text-sm">{{ $facility }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('facilities')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Aturan Kost -->
                <div>
                    <label class="block text-[#42474C] text-xs font-semibold tracking-wide mb-1.5">
                        ATURAN KOST (OPTIONAL)
                    </label>
                    <textarea name="rules" rows="2"
                        class="w-full px-4 py-3 bg-white border border-[#C3C7CD] rounded-lg input-focus text-[#191C1D] resize-none"
                        placeholder="Contoh: Jam malam 22.00">{{ old('rules', $boardingHouse->rules) }}</textarea>
                </div>

                <!-- Foto Kost -->
                <div>
                    <label class="block text-[#42474C] text-xs font-semibold tracking-wide mb-1.5">
                        FOTO KOST (MAKS. 5)
                    </label>

                    <!-- Existing Photos -->
                    @if ($boardingHouse->photos && $boardingHouse->photos->count() > 0)
                        <div class="photo-preview-container mb-4">
                            @foreach ($boardingHouse->photos as $photo)
                                <div class="photo-item" id="photo-{{ $photo->id }}">
                                    <img src="{{ Storage::url($photo->path) }}" alt="Foto Kost">
                                    <span class="primary-badge {{ $photo->is_primary ? 'active' : '' }}">
                                        {{ $photo->is_primary ? '★ Utama' : '' }}
                                    </span>
                                    <button type="button" onclick="deletePhoto({{ $photo->id }})"
                                        class="remove-photo"
                                        style="background: #BA1A1A; border-radius: 50%; padding: 4px; border: none; cursor: pointer;">
                                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <!-- Upload New Photos -->
                    <div class="upload-area" onclick="document.getElementById('photoInput').click()">
                        <div class="flex flex-col items-center">
                            <svg class="w-8 h-6 text-[#73777D] mb-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="text-[#42474C] text-sm font-medium">Klik atau seret file untuk upload</p>
                            <p class="text-[#73777D] text-xs mt-1">PNG, JPG atau WEBP (Maks 2MB)</p>
                        </div>
                        <input type="file" name="photos[]" id="photoInput" accept="image/*" multiple
                            class="file-input-hidden" onchange="previewPhotos(this)">
                    </div>
                    <div id="photoPreview" class="flex flex-wrap gap-4 mt-4"></div>
                    <p class="text-[#73777D] text-xs mt-1">* Upload foto baru untuk menambahkan</p>
                    @error('photos.*')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-[#42474C] text-xs font-semibold tracking-wide mb-1.5">
                        STATUS KOST
                    </label>
                    <select name="status"
                        class="w-full px-4 py-3 bg-white border border-[#C3C7CD] rounded-lg input-focus text-[#191C1D]">
                        <option value="active" {{ old('status', $boardingHouse->status) == 'active' ? 'selected' : '' }}>
                            Active</option>
                        <option value="inactive"
                            {{ old('status', $boardingHouse->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="pending"
                            {{ old('status', $boardingHouse->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                    </select>
                    @error('status')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Footer -->
                <div class="flex justify-end items-center gap-4 pt-4 border-t border-[#C3C7CD]">
                    <a href="{{ route('owner.kost.index') }}"
                        class="px-6 py-2.5 text-[#42474C] text-base font-bold hover:bg-gray-100 rounded-lg transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-8 py-2.5 bg-[#06283D] text-white text-base font-bold rounded-lg hover:bg-[#001220] transition-colors shadow-sm">
                        Update Properti
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // Inisialisasi Leaflet Map
        let map;
        let marker;
        let isMapInitialized = false;
        const defaultLat = {{ $boardingHouse->latitude ?? -7.2575 }};
        const defaultLng = {{ $boardingHouse->longitude ?? 112.7521 }};

        function initMap(lat = defaultLat, lng = defaultLng) {
            if (!isMapInitialized) {
                map = L.map('kost-map').setView([lat, lng], 15);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(map);
                isMapInitialized = true;
            } else {
                map.setView([lat, lng], 15);
            }

            if (marker) {
                map.removeLayer(marker);
            }

            marker = L.marker([lat, lng], {
                draggable: true
            }).addTo(map);

            marker.on('dragend', function(e) {
                const pos = marker.getLatLng();
                document.getElementById('latitude').value = pos.lat.toFixed(6);
                document.getElementById('longitude').value = pos.lng.toFixed(6);
            });

            map.on('click', function(e) {
                marker.setLatLng(e.latlng);
                document.getElementById('latitude').value = e.latlng.lat.toFixed(6);
                document.getElementById('longitude').value = e.latlng.lng.toFixed(6);
            });

            document.getElementById('latitude').value = lat.toFixed(6);
            document.getElementById('longitude').value = lng.toFixed(6);

            setTimeout(() => {
                if (map) map.invalidateSize();
            }, 300);
        }

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        initMap(lat, lng);
                    },
                    function(error) {
                        alert('Gagal mendapatkan lokasi. Pastikan GPS aktif dan izinkan akses lokasi.');
                    }
                );
            } else {
                alert('Browser Anda tidak mendukung geolokasi.');
            }
        }

        // Preview Photos
        function previewPhotos(input) {
            const preview = document.getElementById('photoPreview');
            preview.innerHTML = '';

            const files = Array.from(input.files);
            const maxFiles = 5;
            const existingPhotos = {{ $boardingHouse->photos ? $boardingHouse->photos->count() : 0 }};
            const totalPhotos = existingPhotos + files.length;

            if (totalPhotos > maxFiles) {
                alert('Maksimal 5 foto! Anda sudah memiliki ' + existingPhotos + ' foto.');
                input.value = '';
                return;
            }

            files.forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const container = document.createElement('div');
                    container.className =
                        'relative w-20 h-20 rounded-lg border border-[#C3C7CD] overflow-hidden shadow-sm';
                    container.innerHTML = `
                        <img src="${e.target.result}" class="w-full h-full object-cover">
                        <button type="button" onclick="removePhoto(${index})" 
                                class="absolute -top-1 -right-1 bg-[#BA1A1A] rounded-full p-1 hover:bg-red-700 transition-colors">
                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    `;
                    preview.appendChild(container);
                };
                reader.readAsDataURL(file);
            });
        }

        function deletePhoto(photoId) {
            const photoElement = document.getElementById('photo-' + photoId);

            fetch(`/owner/kost/photo/${photoId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        photoElement.remove();
                        // alert('Foto berhasil dihapus!');
                    } else {
                        alert('Gagal menghapus foto: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menghapus foto!');
                });
        }

        function removePhoto(index) {
            const preview = document.getElementById('photoPreview');
            const input = document.getElementById('photoInput');

            const containers = preview.children;
            if (containers[index]) {
                containers[index].remove();
            }

            const dt = new DataTransfer();
            const files = Array.from(input.files);
            files.splice(index, 1);
            files.forEach(file => dt.items.add(file));
            input.files = dt.files;
        }

        // Init map when DOM ready
        document.addEventListener('DOMContentLoaded', function() {
            const lat = parseFloat(document.getElementById('latitude').value) || defaultLat;
            const lng = parseFloat(document.getElementById('longitude').value) || defaultLng;
            initMap(lat, lng);
        });

        // Get location button
        document.getElementById('getLocationBtn').addEventListener('click', getLocation);
    </script>
@endpush
