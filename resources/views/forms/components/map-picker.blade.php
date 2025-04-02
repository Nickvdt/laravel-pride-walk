<div x-data="mapPicker()" x-init="init()" x-effect="checkLocationLoaded()" class="w-full">


    <div id="map" class="w-full h-96 rounded-lg border border-gray-300 shadow-sm"></div>

    <div class="mt-2 flex space-x-2">
        <div class="flex-1">
            <label for="address" class="block text-sm font-medium text-gray-700">Adres</label>
            <input type="text" id="address" x-model="address"
                @keydown.enter.prevent="geocodeAddress()"
                class="mt-1 block w-full px-3 py-2 bg-[#161617] text-white border border-[#161617] rounded-md shadow-sm focus:ring-[#161617] focus:border-[#161617] sm:text-sm"
                style="background-color: #161617; color: white;">
        </div>
        <div class="flex-shrink-0">
            <button type="button" @click="geocodeAddress()"
                class="w-full px-3 py-2 bg-indigo-600 text-white font-medium text-sm rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">
                Zoek
            </button>
        </div>
    </div>

    <div class="mt-2 flex space-x-4">
        <div class="flex-1">
            <label for="latitude" class="block text-sm font-medium text-gray-700">Latitude</label>
            <input type="number" step="any" id="latitude" x-model="latitude" @input="updateMarker()"
                class="mt-1 block w-full px-3 py-2 bg-[#161617] text-white border border-[#161617] rounded-md shadow-sm focus:ring-[#161617] focus:border-[#161617] sm:text-sm"
                style="background-color: #161617; color: white;">
        </div>
        <div class="flex-1">
            <label for="longitude" class="block text-sm font-medium text-gray-700">Longitude</label>
            <input type="number" step="any" id="longitude" x-model="longitude" @input="updateMarker()"
                class="mt-1 block w-full px-3 py-2 bg-[#161617] text-white border border-[#161617] rounded-md shadow-sm focus:ring-[#161617] focus:border-[#161617] sm:text-sm"
                style="background-color: #161617; color: white;">
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
                    this.latitude = parseFloat(this.location.latitude);
                    this.longitude = parseFloat(this.location.longitude);
                    this.initMap();
                    return;
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

                if (!this.location || typeof this.location !== 'object') {
                    console.warn('[updateLocation] Locatie is leeg, resetten...');
                    this.location = {
                        latitude: this.latitude,
                        longitude: this.longitude
                    };
                } else {
                    this.location.latitude = this.latitude;
                    this.location.longitude = this.longitude;
                }

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
                            this.address = data.display_name || 'Onbekend adres';
                        } else {
                            this.address = 'Adres niet gevonden';
                        }
                    })
                    .catch(error => {
                        console.error('Reverse geocoding fout:', error);
                        this.address = 'Fout bij ophalen adres';
                    });
            }
        };
    }
</script>


<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>