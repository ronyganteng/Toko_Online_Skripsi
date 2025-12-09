@extends('pelanggan.layout.index')

@section('content')
    {{-- Leaflet CSS --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>

    {{-- STYLE KHUSUS HALAMAN REGISTER --}}
    <style>
        .register-wrapper{
            min-height: calc(100vh - 120px);
            display:flex;
            align-items:center;
            justify-content:center;
        }
        .register-card{
            max-width: 1100px;
            width:100%;
            border-radius:18px;
            overflow:hidden;
            box-shadow:0 10px 30px rgba(0,0,0,.18);
            background:#fff;
        }

        /* KIRI: panel info */
        .register-left{
            position:relative;
            background:linear-gradient(135deg,#5d1010,#b71c1c);
            color:#fff;
            padding:32px 26px;
            display:flex;
            flex-direction:column;
            justify-content:space-between;
        }
        .register-left::before{
            content:"";
            position:absolute;
            inset:0;
            background:url("{{ asset('assets/images/contact.jpg') }}") center/cover no-repeat;
            opacity:.25;
        }
        .register-left-inner{
            position:relative;
            z-index:1;
        }
        .reg-badge{
            display:inline-flex;
            align-items:center;
            gap:8px;
            padding:6px 12px;
            border-radius:999px;
            background:rgba(255,255,255,.15);
            font-size:12px;
            text-transform:uppercase;
            letter-spacing:.08em;
        }
        .reg-badge i{font-size:14px;}

        .reg-title{
            margin-top:20px;
            font-size:26px;
            font-weight:700;
            line-height:1.3;
        }
        .reg-subtitle{
            margin-top:10px;
            font-size:13px;
            opacity:.9;
        }
        .reg-steps{
            margin-top:22px;
            display:flex;
            flex-direction:column;
            gap:10px;
            font-size:13px;
        }
        .reg-step-item{
            display:flex;
            gap:10px;
            align-items:flex-start;
        }
        .reg-step-icon{
            width:22px;
            height:22px;
            border-radius:999px;
            background:#ffca28;
            color:#5d1010;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:12px;
            margin-top:2px;
        }
        .reg-left-bottom{
            position:relative;
            z-index:1;
            margin-top:28px;
            font-size:11px;
            opacity:.85;
        }

        /* KANAN: form */
        .register-right{
            padding:28px 30px 24px;
            background:#fafafa;
        }
        .register-right h4{
            font-weight:700;
            color:#333;
        }
        .register-right small{
            color:#777;
        }
        .reg-form-label{
            font-size:13px;
            font-weight:500;
            color:#555;
        }
        .reg-input{
            border-radius:10px;
            font-size:14px;
        }
        .reg-input:focus{
            box-shadow:0 0 0 2px rgba(33,150,243,.25);
        }
        #map{
            height: 260px;
            width: 100%;
            border-radius:12px;
            overflow:hidden;
            box-shadow:0 4px 14px rgba(0,0,0,.14);
        }
        .reg-btn-primary{
            background:#0056ff;
            border:none;
            border-radius:999px;
            font-weight:600;
            font-size:15px;
            padding:8px 0;
            transition:.2s;
        }
        .reg-btn-primary:hover{
            background:#003fc7;
        }
        .reg-login-link{
            font-size:13px;
        }

        @media (max-width: 991.98px){
            .register-left{
                display:none;
            }
            .register-card{
                max-width:520px;
            }
            .register-right{
                padding:26px 20px 22px;
            }
        }
    </style>

    <div class="container register-wrapper">
        <div class="register-card row g-0">

            {{-- KIRI: BRANDING + STEP REGISTER --}}
            <div class="col-md-4 register-left">
                <div class="register-left-inner">
                    <div class="reg-badge">
                        <i class="fa fa-user-plus"></i> Daftar Pelanggan Baru
                    </div>

                    <h2 class="reg-title">
                        Bergabung dengan<br> Komunitas St. Benedictus
                    </h2>
                    <p class="reg-subtitle">
                        Simpan alamat pengiriman, pantau pesanan, dan nikmati belanja perlengkapan rohani dengan lebih mudah.
                    </p>

                    <div class="reg-steps">
                        <div class="reg-step-item">
                            <div class="reg-step-icon">1</div>
                            <div>
                                <strong>Isi data diri singkat</strong><br>
                                Nama, email, dan nomor telepon untuk menghubungi Anda.
                            </div>
                        </div>
                        <div class="reg-step-item">
                            <div class="reg-step-icon">2</div>
                            <div>
                                <strong>Tentukan alamat & lokasi</strong><br>
                                Pin lokasi di peta agar pengiriman lebih akurat.
                            </div>
                        </div>
                        <div class="reg-step-item">
                            <div class="reg-step-icon">3</div>
                            <div>
                                <strong>Mulai berbelanja</strong><br>
                                Tambahkan produk ke keranjang dan lakukan checkout kapan saja.
                            </div>
                        </div>
                    </div>

                    <div class="reg-left-bottom">
                        “Kasihilah sesamamu manusia seperti dirimu sendiri.” – Markus 12:31
                    </div>
                </div>
            </div>

            {{-- KANAN: FORM REGISTER --}}
            <div class="col-md-8 register-right">
                <div class="mb-3 text-center">
                    <h4 class="mb-0">Register Pelanggan</h4>
                    <small>Lengkapi data di bawah ini untuk membuat akun baru.</small>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger py-2">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('customer.register.post') }}" method="POST" class="mt-3">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="reg-form-label">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control reg-input"
                                   value="{{ old('name') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="reg-form-label">Email</label>
                            <input type="email" name="email" class="form-control reg-input"
                                   value="{{ old('email') }}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="reg-form-label">Password</label>
                            <input type="password" name="password" class="form-control reg-input" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="reg-form-label">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control reg-input" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="reg-form-label">Nomor Telepon</label>
                            <input type="text" name="phone" class="form-control reg-input"
                                   value="{{ old('phone') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="reg-form-label">Tanggal Lahir</label>
                            <input type="date" name="birth_date" class="form-control reg-input"
                                   value="{{ old('birth_date') }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="reg-form-label">Alamat 1</label>
                        <input type="text" name="address1" id="address1"
                               class="form-control reg-input" value="{{ old('address1') }}" required>
                        <small class="text-muted" style="font-size:12px;">
                            Bisa diedit manual atau otomatis dari peta di bawah.
                        </small>
                    </div>

                    <div class="mb-3">
                        <label class="reg-form-label">Alamat 2 (opsional)</label>
                        <input type="text" name="address2" class="form-control reg-input"
                               value="{{ old('address2') }}">
                    </div>

                    {{-- Peta Lokasi --}}
                    <div class="mb-3">
                        <label class="reg-form-label">Pin Lokasi Rumah di Peta</label>
                        <div id="map"></div>
                        <small class="text-muted" style="font-size:12px;">
                            Klik di peta untuk memilih titik, atau geser marker hijau. Alamat 1 akan berusaha terisi otomatis.
                        </small>
                    </div>

                    {{-- Hidden: otomatis terisi dari map --}}
                    <input type="hidden" name="lat" id="lat" value="{{ old('lat') }}">
                    <input type="hidden" name="lng" id="lng" value="{{ old('lng') }}">

                    <button type="submit" class="btn reg-btn-primary w-100 mt-2">
                        Buat Akun
                    </button>
                </form>

                <hr class="mt-4 mb-2">
                <div class="text-center reg-login-link">
                    Sudah punya akun?
                    <a href="{{ route('customer.login') }}">Login di sini</a>
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

        // Fungsi update alamat berdasarkan lat/lng
        function updateAddressFromLatLng(lat, lng) {
            let url = 'https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat='
                + lat + '&lon=' + lng;

            fetch(url, {
                headers: {
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

        // Panggil sekali di awal
        updateAddressFromLatLng(defaultLat, defaultLng);

        // Kalau marker digeser
        marker.on('dragend', function () {
            let pos = marker.getLatLng();
            document.getElementById('lat').value = pos.lat;
            document.getElementById('lng').value = pos.lng;
            updateAddressFromLatLng(pos.lat, pos.lng);
        });

        // Kalau user klik di peta
        map.on('click', function (e) {
            marker.setLatLng(e.latlng);
            document.getElementById('lat').value = e.latlng.lat;
            document.getElementById('lng').value = e.latlng.lng;
            updateAddressFromLatLng(e.latlng.lat, e.latlng.lng);
        });
    </script>
@endsection
