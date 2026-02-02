@extends('layouts.admin')

@section('header_title', 'Tambah SKPD Baru')

{{-- Tambahkan CSS Leaflet di head --}}
@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        /* Map mengisi tinggi container di sebelahnya agar seimbang */
        #map { height: 100%; min-height: 300px; border-radius: 0.75rem; border: 2px solid #e5e7eb; }
    </style>
@endpush

@section('content')
    {{-- UBAH: max-w-2xl menjadi max-w-6xl agar lebih lebar --}}
    <div class="max-w-6xl mx-auto bg-white rounded-xl shadow-sm border border-gray-100 p-8">

        <form action="{{ route('skpd.store') }}" method="POST">
            @csrf

            {{-- LAYOUT GRID: Membagi tampilan menjadi 2 kolom (Kiri: Form, Kanan: Peta) --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-6">

                {{-- KOLOM KIRI: Data Identitas --}}
                <div class="space-y-5">

                    {{-- Baris 1: Kode SKPD & Telepon (Sejajar) --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Kode SKPD <span class="text-red-500">*</span></label>
                            <input type="text" name="kode" value="{{ old('kode') }}" required
                                   class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none @error('kode') border-red-500 @else border-gray-300 @enderror"
                                   placeholder="Cth: 2.05.01">
                            @error('kode')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">No. Telepon</label>
                            <input type="text" name="telepon" value="{{ old('telepon') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                                   placeholder="0231-xxxxxx">
                        </div>
                    </div>

                    {{-- Baris 2: Nama Instansi --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Nama Instansi / SKPD <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_skpd" value="{{ old('nama_skpd') }}" required
                               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none @error('nama_skpd') border-red-500 @else border-gray-300 @enderror"
                               placeholder="Contoh: Dinas Komunikasi, Informatika dan Statistik">
                        @error('nama_skpd')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Baris 3: Alamat (Textarea lebih tinggi dikit) --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Alamat Kantor <span class="text-red-500">*</span></label>
                        <textarea name="alamat" rows="4" required
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none resize-none"
                                  placeholder="Jalan Raya No. 123...">{{ old('alamat') }}</textarea>
                        @error('alamat')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- KOLOM KANAN: Peta & Koordinat --}}
                <div class="flex flex-col h-full">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Lokasi Koordinat (Klik pada peta)</label>

                    {{-- Map container mengisi sisa ruang --}}
                    <div class="flex-grow mb-3 relative">
                        <div id="map" class="w-full h-full absolute inset-0"></div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mt-auto">
                        <div>
                            <span class="text-xs text-gray-500 block mb-1">Latitude</span>
                            <input type="text" name="latitude" id="latitude" readonly value="{{ old('latitude') }}"
                                   class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-lg text-sm font-mono" placeholder="-6.xxxxx">
                        </div>
                        <div>
                            <span class="text-xs text-gray-500 block mb-1">Longitude</span>
                            <input type="text" name="longitude" id="longitude" readonly value="{{ old('longitude') }}"
                                   class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-lg text-sm font-mono" placeholder="108.xxxxx">
                        </div>
                    </div>
                    @error('latitude') <p class="text-red-500 text-xs mt-1 font-bold">Lokasi wajib dipilih pada peta.</p> @enderror
                </div>
            </div>

            {{-- TOMBOL AKSI --}}
            <div class="flex justify-end space-x-3 pt-6 border-t border-gray-100">
                <a href="{{ route('skpd.index') }}" class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 font-bold transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-8 py-2.5 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 font-bold shadow-lg shadow-indigo-200 transition-all active:scale-95">
                    Simpan Data SKPD
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // Inisialisasi Peta (Default Cirebon)
        var map = L.map('map').setView([-6.7219, 108.5561], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        var marker;

        // Jika ada koordinat 'old' dari validasi gagal, tampilkan kembali
        @if(old('latitude') && old('longitude'))
        var oldLat = {{ old('latitude') }};
        var oldLng = {{ old('longitude') }};
        marker = L.marker([oldLat, oldLng]).addTo(map);
        map.setView([oldLat, oldLng], 15);
        @endif

        // Fungsi klik pada peta
        map.on('click', function(e) {
            var lat = e.latlng.lat.toFixed(8);
            var lng = e.latlng.lng.toFixed(8);

            if (marker) {
                marker.setLatLng(e.latlng);
            } else {
                marker = L.marker(e.latlng).addTo(map);
            }

            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;
        });

        // Trik agar peta merender ulang ukurannya saat layout berubah (karena flexbox)
        setTimeout(function(){ map.invalidateSize(); }, 400);
    </script>
@endpush
