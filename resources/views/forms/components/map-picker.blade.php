<div x-data="mapPicker()" x-init="init()" x-effect="checkLocationLoaded()" class="w-full" wire:ignore>

    <div id="map" class="w-full h-96 rounded-lg border border-gray-300 shadow-sm"></div>

    <div class="flex flex-col  pt-4">
        <label for="address" class="text-sm font-medium text-white">Adres</label>
        <div class="flex items-center ">
            <input
                type="text"
                id="address"
                x-model="address"
                @keydown.enter.prevent="geocodeAddress()"
                @input="updateLocation()"
                class="block w-full rounded-lg border-0 bg-transparent py-2 px-3 text-sm text-white ring-1 ring-inset ring-white/10 placeholder-white/40 focus:ring-2 focus:ring-inset focus:ring-white/20 appearance-none"
                placeholder="Typ een adres..." />

            <button
                type="button"
                @click="geocodeAddress()"
                class="text-white hover:text-white/70 focus:outline-none cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1012 19.5a7.5 7.5 0 004.35-1.85z" />
                </svg>
            </button>
        </div>
    </div>
    <div class="mt-2 flex space-x-4 pt-4">
        <div class="flex-1 ">
            <label for="latitude" class="block text-sm font-medium text-white">Latitude</label>
            <input type="number" step="any" id="latitude" x-model="latitude" @input="updateMarker()"
                class="block w-full rounded-lg border-0 bg-transparent py-2 px-3 text-sm text-white ring-1 ring-inset ring-white/10 placeholder-white/40 focus:ring-2 focus:ring-inset focus:ring-white/20"
                placeholder="Latitude">
        </div>
        <div class="flex-1">
            <label for="longitude" class="block text-sm font-medium text-white">Longitude</label>
            <input type="number" step="any" id="longitude" x-model="longitude" @input="updateMarker()"
                class="block w-full rounded-lg border-0 bg-transparent py-2 px-3 text-sm text-white ring-1 ring-inset ring-white/10 placeholder-white/40 focus:ring-2 focus:ring-inset focus:ring-white/20"
                placeholder="Longitude">
        </div>
    </div>

    <input type="hidden"
        x-ref="hiddenInput"
        x-modelable="location"
        wire:model.defer="{{ $getStatePath() }}" />
</div>

<script>
    function mapPicker() {
        return {
            latitude: 52.3676,
            longitude: 4.9041,
            address: '',
            location: null,

            map: null,
            marker: null,
            coordControl: null,

            init() {
                console.log('[init] Alpine component gestart');

                this.$nextTick(() => {
                    setTimeout(() => {
                        if (
                            (!this.location || !this.location.latitude || !this.location.longitude) &&
                            !this.map
                        ) {
                            console.warn('[init > fallback] Geen geldige locatie ontvangen binnen tijd. Fallback naar Amsterdam.');
                            this.latitude = 52.3676;
                            this.longitude = 4.9041;
                            this.initMap();
                            this.updateLocation();
                            this.reverseGeocode();
                        }
                    }, 500);
                });
            },


            checkLocationLoaded() {
                console.log('[checkLocationLoaded] this.location:', this.location);

                if (this.location === null) {
                    console.log('[checkLocationLoaded] this.location is null, wachten...');
                    return;
                }

                if (
                    typeof this.location === 'object' &&
                    this.location.latitude &&
                    this.location.longitude &&
                    !this.map
                ) {
                    console.log('[checkLocationLoaded] Geldige locatie ontvangen van Livewire:', this.location);

                    this.$nextTick(() => {
                        this.latitude = parseFloat(this.location.latitude);
                        this.longitude = parseFloat(this.location.longitude);
                        this.address = this.location.address || '';
                        this.initMap();
                    });
                }
            },


            initMap() {
                console.log('[initMap] Kaart aanmaken bij', this.latitude, this.longitude);

                this.map = L.map('map').setView([this.latitude, this.longitude], 12);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '',
                }).addTo(this.map);

                this.marker = L.marker([this.latitude, this.longitude], {
                    draggable: true,
                }).addTo(this.map);

                this.marker.on('dragend', (event) => {
                    let position = event.target.getLatLng();
                    this.latitude = position.lat.toFixed(6);
                    this.longitude = position.lng.toFixed(6);
                    this.reverseGeocode();
                    this.updateCoords();
                    this.updateLocation();
                });

                this.map.on('click', (event) => {
                    let position = event.latlng;
                    this.latitude = position.lat.toFixed(6);
                    this.longitude = position.lng.toFixed(6);
                    this.marker.setLatLng(position);
                    this.reverseGeocode();
                    this.updateCoords();
                    this.updateLocation();
                });

                this.coordControl = L.control({
                    position: 'bottomright'
                });

                this.coordControl.onAdd = () => {
                    let div = L.DomUtil.create('div', 'leaflet-control-latlng');
                    div.style.padding = "8px";
                    div.style.background = "rgba(0, 0, 0, 0.7)";
                    div.style.color = "white";
                    div.style.borderRadius = "5px";
                    div.style.fontSize = "12px";
                    div.innerHTML = `Lat: ${this.latitude}, Lng: ${this.longitude}`;
                    return div;
                };

                this.coordControl.addTo(this.map);

                this.updateCoords();
            },

            updateCoords() {
                const coordBox = document.querySelector('.leaflet-control-latlng');
                if (coordBox) {
                    coordBox.innerHTML = `Lat: ${this.latitude}, Lng: ${this.longitude}`;
                }
            },

            updateMarker() {
                let lat = parseFloat(this.latitude);
                let lng = parseFloat(this.longitude);

                if (!isNaN(lat) && !isNaN(lng)) {
                    let position = L.latLng(lat, lng);
                    this.marker.setLatLng(position);
                    this.map.setView(position, 12);
                    this.reverseGeocode();
                    this.updateCoords();
                    this.updateLocation();
                }
            },

            updateLocation() {
                console.log('[updateLocation] Huidige locatie:', this.location);

                this.location = {
                    latitude: this.latitude,
                    longitude: this.longitude,
                    address: this.address
                };

                if (this.$refs.hiddenInput) {
                    this.$refs.hiddenInput.value = JSON.stringify(this.location);
                    this.$refs.hiddenInput.dispatchEvent(new Event('input'));
                    console.log('[updateLocation] Hidden input verstuurd');
                } else {
                    console.error('[updateLocation] $refs.hiddenInput niet gevonden');
                }
            },

            geocodeAddress() {
                if (this.address.trim() === '') return;

                fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(this.address)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data && data.length > 0) {
                            const location = data[0];
                            this.latitude = parseFloat(location.lat);
                            this.longitude = parseFloat(location.lon);

                            this.marker.setLatLng([this.latitude, this.longitude]);
                            this.map.setView([this.latitude, this.longitude], 12);

                            this.updateCoords();
                            this.updateLocation();
                        } else {
                            alert('Adres niet gevonden.');
                        }
                    })
                    .catch(error => {
                        console.error('Geocoding fout:', error);
                        alert('Fout bij ophalen adres.');
                    });
            },

            reverseGeocode() {
                fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${this.latitude}&lon=${this.longitude}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data && data.address) {
                            const addr = data.address;
                            this.address = [
                                addr.road || addr.park || addr.neighbourhood,
                                addr.postcode,
                                addr.city || addr.town,
                                addr.state
                            ].filter(Boolean).join(', ');
                        } else {
                            this.address = 'Adres niet gevonden';
                        }

                        this.updateLocation();
                    })
                    .catch(error => {
                        console.error('Reverse geocoding fout:', error);
                        this.address = 'Fout bij ophalen adres';
                        this.updateLocation();
                    });
                }
            }
        }
</script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.js"></script>