@extends('pelanggan.layout.index')

@section('content')
    {{-- Leaflet CSS --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>

    <style>
        #map {
            height: 350px;
            width: 100%;
            border-radius: 10px;
        }
    </style>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card shadow-sm">
                    <div class="card-header text-center">
                        <h4>Register Pelanggan</h4>
                    </div>
                    <div class="card-body">

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $e)
                                        <li>{{ $e }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('customer.register.post') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control"
                                       value="{{ old('name') }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control"
                                       value="{{ old('email') }}" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Konfirmasi Password</label>
                                    <input type="password" name="password_confirmation" class="form-control" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nomor Telepon</label>
                                <input type="text" name="phone" class="form-control"
                                       value="{{ old('phone') }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Alamat 1</label>
                                <input type="text" name="address1" id="address1"
                                       class="form-control" value="{{ old('address1') }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Alamat 2 (opsional)</label>
                                <input type="text" name="address2" class="form-control"
                                       value="{{ old('address2') }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="date" name="birth_date" class="form-control"
                                       value="{{ old('birth_date') }}">
                            </div>

                            {{-- Peta Lokasi (OpenStreetMap + Leaflet) --}}
                            <div class="mb-3">
                                <label class="form-label">Pin Lokasi Rumah (klik di peta)</label>
                                <div id="map"></div>
                                <small class="text-muted">
                                    Klik di peta untuk memilih lokasi, atau geser marker hijau.
                                    Alamat 1 akan terisi otomatis.
                                </small>
                            </div>

                            {{-- Hidden: otomatis terisi dari map --}}
                            <input type="hidden" name="lat" id="lat" value="{{ old('lat') }}">
                            <input type="hidden" name="lng" id="lng" value="{{ old('lng') }}">

                            <button type="submit" class="btn btn-success w-100">
                                Register
                            </button>
                        </form>

                        <hr>
                        <div class="text-center">
                            Sudah punya akun?
                            <a href="{{ route('customer.login') }}">Login di sini</a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Leaflet JS --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        // Posisi awal map (contoh Surabaya)
        let defaultLat = -7.2575;
        let defaultLng = 112.7521;

        // Kalau ada old value (misalnya form error), pakai itu
        let oldLat = "{{ old('lat') }}";
        let oldLng = "{{ old('lng') }}";

        if (oldLat && oldLng) {
            defaultLat = parseFloat(oldLat);
            defaultLng = parseFloat(oldLng);
        }

        // Inisialisasi map
        let map = L.map('map').setView([defaultLat, defaultLng], 13);

        // Tile dari OpenStreetMap (gratis, tanpa API key)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // Marker awal
        let marker = L.marker([defaultLat, defaultLng], {draggable: true}).addTo(map);

        // Isi nilai awal ke hidden input
        document.getElementById('lat').value = defaultLat;
        document.getElementById('lng').value = defaultLng;

        // --- fungsi panggil API reverse geocoding & isi Alamat 1 ---
        function updateAddressFromLatLng(lat, lng) {
            // Simpel call ke Nominatim (OpenStreetMap)
            let url = 'https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat='
                + lat + '&lon=' + lng;

            fetch(url, {
                headers: {
                    // Nominatim minta User-Agent yang jelas
                    'Accept': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data && data.display_name) {
                        document.getElementById('address1').value = data.display_name;
                    }
                })
                .catch(err => {
                    console.error('Gagal mengambil alamat dari koordinat', err);
                });
        }

        // Panggil sekali di awal (kalau mau alamat awal keisi)
        updateAddressFromLatLng(defaultLat, defaultLng);

        // Kalau marker digeser
        marker.on('dragend', function (e) {
            let pos = marker.getLatLng();
            document.getElementById('lat').value = pos.lat;
            document.getElementById('lng').value = pos.lng;
            updateAddressFromLatLng(pos.lat, pos.lng);
        });

        // Kalau user klik di peta → pindahkan marker + update hidden input + alamat
        map.on('click', function (e) {
            marker.setLatLng(e.latlng);
            document.getElementById('lat').value = e.latlng.lat;
            document.getElementById('lng').value = e.latlng.lng;
            updateAddressFromLatLng(e.latlng.lat, e.latlng.lng);
        });
    </script>
@endsection
