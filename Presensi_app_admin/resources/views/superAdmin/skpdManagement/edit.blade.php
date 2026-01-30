@extends('layouts.admin')

@section('header_title', 'Edit SKPD')

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        #map { height: 400px; border-radius: 0.75rem; border: 2px solid #e5e7eb; }
    </style>
@endpush

@section('content')
    <div class="max-w-6xl mx-auto">
        <form action="{{ route('skpd.update', $skpd->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 space-y-6">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                            <i class="fa-solid fa-file-invoice text-indigo-600 mr-2"></i> Informasi SKPD
                        </h3>
                        <hr class="mb-6">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Instansi / SKPD <span class="text-red-500">*</span></label>
                        <input type="text" name="nama" value="{{ old('nama', $skpd->nama) }}"
                               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none @error('nama') border-red-500 @else border-gray-300 @enderror"
                               placeholder="Contoh: Dinas Komunikasi dan Informatika">
                        @error('nama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kode SKPD <span class="text-red-500">*</span></label>
                        <input type="text" name="kode_skpd" value="{{ old('kode_skpd', $skpd->kode) }}"
                               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none @error('kode_skpd') border-red-500 @else border-gray-300 @enderror"
                               placeholder="Contoh: DISKOMINFO-01">
                        @error('kode_skpd') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Kantor <span class="text-red-500">*</span></label>
                        <textarea name="alamat" rows="4" required
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                                  placeholder="Jalan Raya No. 123...">{{ old('alamat', $skpd->Alamat) }}</textarea>
                    </div>

                    <div class="flex items-center justify-end space-x-3 pt-6">
                        <a href="{{ route('skpd.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 font-medium transition-colors">Batal</a>
                        <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-medium shadow-md transition-all active:scale-95">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                            <i class="fa-solid fa-map-location-dot text-indigo-600 mr-2"></i> Titik Koordinat
                        </h3>
                        <hr class="mb-6">
                    </div>

                    <div id="map" class="mb-6 shadow-inner"></div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-gray-50 p-3 rounded-lg border border-gray-200">
                            <label class="block text-[10px] uppercase font-bold text-gray-400 mb-1">Latitude</label>
                            <input type="text" name="latitude" id="latitude" readonly
                                   value="{{ old('latitude', $skpd->Latitude) }}"
                                   class="w-full bg-transparent border-none p-0 text-sm font-mono text-indigo-700 focus:ring-0" placeholder="Latitude">
                        </div>
                        <div class="bg-gray-50 p-3 rounded-lg border border-gray-200">
                            <label class="block text-[10px] uppercase font-bold text-gray-400 mb-1">Longitude</label>
                            <input type="text" name="longitude" id="longitude" readonly
                                   value="{{ old('longitude', $skpd->Longitude) }}"
                                   class="w-full bg-transparent border-none p-0 text-sm font-mono text-indigo-700 focus:ring-0" placeholder="Longitude">
                        </div>
                    </div>
                    <p class="mt-4 text-xs text-gray-500 italic">
                        * Klik pada peta untuk memindahkan marker ke lokasi yang tepat.
                    </p>
                </div>

            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        var savedLat = {{ old('latitude', $skpd->Latitude ?? -6.7219) }};
        var savedLng = {{ old('longitude', $skpd->Longitude ?? 108.5561) }};

        var map = L.map('map').setView([savedLat, savedLng], 15);

        var tiles = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap',
            keepBuffer: 2,
            updateWhenIdle: true
        }).addTo(map);

        window.onload = function() {
            map.invalidateSize();
        };

        setTimeout(function(){
            map.invalidateSize();
        }, 100);

        var marker = L.marker([savedLat, savedLng]).addTo(map);

        map.on('click', function(e) {
            var lat = e.latlng.lat.toFixed(8);
            var lng = e.latlng.lng.toFixed(8);
            marker.setLatLng(e.latlng);
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;
        });

        setTimeout(function(){ map.invalidateSize(); }, 400);
    </script>
@endpush
