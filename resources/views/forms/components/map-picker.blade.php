<div x-data="mapPicker()" x-init="initMap()" class="w-full">
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

    <input 
    type="hidden" 
    x-bind:value="JSON.stringify({latitude: latitude, longitude: longitude})" 
    name="{{ $getStatePath() }}"
    x-effect="console.log('Location:', JSON.stringify({latitude: latitude, longitude: longitude}))">

</div>

<script>
    function mapPicker() {
        return {
            latitude: 52.3676,
            longitude: 4.9041,
            address: '',
            map: null,
            marker: null,
            coordControl: null,

            initMap() {
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
                });

                this.map.on('click', (event) => {
                    let position = event.latlng;
                    this.latitude = position.lat.toFixed(6);
                    this.longitude = position.lng.toFixed(6);
                    this.marker.setLatLng(position);
                    this.reverseGeocode();
                    this.updateCoords();
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
            },

            updateCoords() {
                document.querySelector('.leaflet-control-latlng').innerHTML =
                    `Lat: ${this.latitude}, Lng: ${this.longitude}`;
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
                        } else {
                            alert('Adres niet gevonden.');
                        }
                    })
                    .catch(error => {
                        console.error('Geocoding fout:', error);
                        alert('Er is een fout opgetreden bij het ophalen van het adres.');
                    });
            },

            reverseGeocode() {
                fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${this.latitude}&lon=${this.longitude}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data && data.address) {
                            this.address = data.address.road || 'Onbekend adres';
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