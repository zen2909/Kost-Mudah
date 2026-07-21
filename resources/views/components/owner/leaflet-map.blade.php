@props([
    'latitude' => '-7.2575',
    'longitude' => '112.7521',
    'height' => '300px',
    'zoom' => 15,
    'readonly' => false,
    'id' => 'map',
])

<div x-data="leafletMap({
    lat: {{ $latitude }},
    lng: {{ $longitude }},
    zoom: {{ $zoom }},
    readonly: {{ $readonly ? 'true' : 'false' }},
    mapId: '{{ $id }}'
})" x-init="initMap()" x-on:resize.window="refreshMap()"
    class="w-full rounded-lg overflow-hidden border border-[#C3C7CD]" style="height: {{ $height }}; z-index: 1;">
    <div x-ref="mapContainer" id="{{ $id }}" class="w-full h-full"></div>
</div>

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('leafletMap', (config) => ({
                map: null,
                marker: null,
                lat: config.lat,
                lng: config.lng,
                zoom: config.zoom,
                readonly: config.readonly,
                mapId: config.mapId,
                isInitialized: false,

                initMap() {
                    if (this.isInitialized) return;

                    this.$nextTick(() => {
                        const container = this.$refs.mapContainer;
                        if (!container) return;

                        this.map = L.map(this.mapId, {
                            center: [this.lat, this.lng],
                            zoom: this.zoom,
                            zoomControl: !this.readonly,
                            attributionControl: true
                        });

                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            attribution: '© OpenStreetMap contributors',
                            maxZoom: 19
                        }).addTo(this.map);

                        const markerOptions = {
                            draggable: !this.readonly,
                            autoPan: true
                        };

                        this.marker = L.marker([this.lat, this.lng], markerOptions).addTo(this
                            .map);

                        if (!this.readonly) {
                            this.marker.on('dragend', () => {
                                const pos = this.marker.getLatLng();
                                this.lat = pos.lat;
                                this.lng = pos.lng;

                                const latInput = document.getElementById('latitude');
                                const lngInput = document.getElementById('longitude');
                                if (latInput) latInput.value = pos.lat.toFixed(6);
                                if (lngInput) lngInput.value = pos.lng.toFixed(6);

                                this.$dispatch('location-updated', {
                                    latitude: pos.lat,
                                    longitude: pos.lng
                                });
                            });

                            this.map.on('click', (e) => {
                                this.marker.setLatLng(e.latlng);
                                this.lat = e.latlng.lat;
                                this.lng = e.latlng.lng;

                                const latInput = document.getElementById('latitude');
                                const lngInput = document.getElementById('longitude');
                                if (latInput) latInput.value = e.latlng.lat.toFixed(6);
                                if (lngInput) lngInput.value = e.latlng.lng.toFixed(6);

                                this.$dispatch('location-updated', {
                                    latitude: e.latlng.lat,
                                    longitude: e.latlng.lng
                                });
                            });
                        }

                        this.isInitialized = true;

                        setTimeout(() => {
                            if (this.map) this.map.invalidateSize();
                        }, 300);
                    });
                },

                refreshMap() {
                    if (this.map) {
                        setTimeout(() => {
                            this.map.invalidateSize();
                        }, 100);
                    }
                },

                setLocation(lat, lng) {
                    this.lat = lat;
                    this.lng = lng;
                    if (this.map) {
                        this.map.setView([lat, lng], this.zoom);
                    }
                    if (this.marker) {
                        this.marker.setLatLng([lat, lng]);
                    }
                },

                getCurrentLocation() {
                    if (!navigator.geolocation) {
                        alert('Browser Anda tidak mendukung geolokasi.');
                        return;
                    }

                    navigator.geolocation.getCurrentPosition(
                        (position) => {
                            const lat = position.coords.latitude;
                            const lng = position.coords.longitude;
                            this.setLocation(lat, lng);

                            const latInput = document.getElementById('latitude');
                            const lngInput = document.getElementById('longitude');
                            if (latInput) latInput.value = lat.toFixed(6);
                            if (lngInput) lngInput.value = lng.toFixed(6);

                            this.$dispatch('location-updated', {
                                latitude: lat,
                                longitude: lng
                            });
                        },
                        (error) => {
                            alert(
                                'Gagal mendapatkan lokasi. Pastikan GPS aktif dan izinkan akses lokasi.');
                        }
                    );
                }
            }));
        });
    </script>
@endpush
