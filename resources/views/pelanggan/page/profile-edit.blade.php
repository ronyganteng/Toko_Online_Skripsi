@extends('pelanggan.layout.index')

@section('content')
<style>
    .profile-edit-wrapper {
        background: linear-gradient(135deg, #fce4ec 0%, #fffde7 40%, #e3f2fd 100%);
        border-radius: 24px;
        padding: 32px 24px;
    }

    .profile-edit-card {
        border-radius: 20px;
        border: none;
        overflow: hidden;
    }

    .profile-edit-header {
        background: linear-gradient(135deg, #b71c1c, #d32f2f);
        color: #fff;
        padding: 18px 24px;
    }

    .profile-edit-header h4 {
        margin-bottom: 0;
        font-weight: 700;
    }

    .profile-step-badge {
        background: rgba(255,255,255,0.15);
        padding: 4px 10px;
        border-radius: 999px;
        font-size: 12px;
    }

    .avatar-edit {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #fff;
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }

    .avatar-edit-placeholder {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        background: #ffeeee;
        color: #b71c1c;
        font-size: 38px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 4px solid #fff;
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }

    .section-label {
        font-size: .85rem;
        text-transform: uppercase;
        letter-spacing: .1em;
        color: #9e9e9e;
        font-weight: 700;
        margin-bottom: 6px;
    }

    .pill-note {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        border-radius: 999px;
        background: #f5f5f5;
        font-size: .8rem;
        color: #616161;
    }

    #map {
        width: 100%;
        height: 380px;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }

    @media (max-width: 768px) {
        .profile-edit-wrapper {
            padding: 20px 16px;
        }
    }
</style>

<div class="container py-5">

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="profile-edit-wrapper">
        <div class="card shadow profile-edit-card">
            {{-- HEADER --}}
            <div class="profile-edit-header d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h4>Edit Profil</h4>
                    <div class="small opacity-75">Perbarui data akun & alamat pengirimanmu</div>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="profile-step-badge">
                        Langkah 1 dari 1 · Data Profil
                    </span>
                    <a href="{{ route('customer.profile') }}" class="btn btn-light btn-sm">
                        <i class="fa fa-arrow-left me-1"></i> Kembali ke Profil
                    </a>
                </div>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('customer.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-4">
                        {{-- KIRI: DATA AKUN --}}
                        <div class="col-md-6 border-md-end">
                            <div class="section-label">
                                <i class="fa fa-user-pen me-1"></i> Data Akun
                            </div>

                            {{-- FOTO PROFIL --}}
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Foto Profil</label>
                                <div class="d-flex align-items-center gap-3">
                                    @if($customer->photo)
                                        <img src="{{ asset('storage/customer/'.$customer->photo) }}"
                                             alt="Foto Profil"
                                             class="avatar-edit"
                                             id="avatarPreview">
                                    @else
                                        <div class="avatar-edit-placeholder" id="avatarPreviewPlaceholder">
                                            {{ strtoupper(substr($customer->name, 0, 1)) }}
                                        </div>
                                    @endif

                                    <div class="flex-grow-1">
                                        <input type="file" name="photo" class="form-control" id="photoInput">
                                        <small class="text-muted d-block mt-1">
                                            Format: JPG, JPEG, PNG, WEBP · Maks 2 MB.
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control"
                                       value="{{ old('name', $customer->name) }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="email" name="email" class="form-control"
                                       value="{{ old('email', $customer->email) }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nomor Telepon</label>
                                <input type="text" name="phone" class="form-control"
                                       value="{{ old('phone', $customer->phone) }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Tanggal Lahir</label>
                                <input type="date" name="birth_date" class="form-control"
                                       value="{{ old('birth_date', $customer->birth_date) }}">
                            </div>

                            {{-- HIDDEN LAT LNG --}}
                            <input type="hidden" name="lat" id="lat"
                                   value="{{ old('lat', $customer->lat) }}">
                            <input type="hidden" name="lng" id="lng"
                                   value="{{ old('lng', $customer->lng) }}">

                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <a href="{{ route('customer.profile') }}" class="btn btn-outline-secondary">
                                    Batal
                                </a>
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-save me-1"></i> Simpan Perubahan
                                </button>
                            </div>
                        </div>

                        {{-- KANAN: ALAMAT & PETA --}}
                        <div class="col-md-6">
                            <div class="section-label">
                                <i class="fa fa-location-dot me-1"></i> Alamat & Lokasi
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Alamat 1 (Utama)</label>
                                <input type="text" name="address1" id="address1" class="form-control"
                                       value="{{ old('address1', $customer->address1) }}" required>
                                <div class="mt-1">
                                    <span class="pill-note">
                                        <i class="fa fa-info-circle"></i>
                                        Bisa diisi manual atau otomatis dari peta di bawah.
                                    </span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Alamat 2 (Opsional)</label>
                                <input type="text" name="address2" class="form-control"
                                       value="{{ old('address2', $customer->address2) }}">
                            </div>

                            <div class="mb-2">
                                <label class="form-label fw-semibold">Pilih Lokasi di Peta (OpenStreetMap)</label>
                                <div id="map"></div>
                            </div>
                            <small class="text-muted">
                                Klik pada peta atau geser marker untuk memilih lokasi. Sistem akan mencoba mengisi
                                Alamat 1 secara otomatis.
                            </small>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet"
      href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
      integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
      crossorigin=""/>
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin=""></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // --- PREVIEW FOTO ---
    const photoInput   = document.getElementById('photoInput');
    const avatarImg    = document.getElementById('avatarPreview');
    const avatarPh     = document.getElementById('avatarPreviewPlaceholder');

    if (photoInput) {
        photoInput.addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function (ev) {
                if (avatarImg) {
                    avatarImg.src = ev.target.result;
                } else if (avatarPh) {
                    const img = document.createElement('img');
                    img.src = ev.target.result;
                    img.className = 'avatar-edit';
                    avatarPh.replaceWith(img);
                }
            };
            reader.readAsDataURL(file);
        });
    }

    // --- MAP & KOORDINAT ---
    const latInput  = document.getElementById('lat');
    const lngInput  = document.getElementById('lng');
    const addrInput = document.getElementById('address1');

    let defaultLat = parseFloat(latInput.value) || -7.2575;   // Surabaya default
    let defaultLng = parseFloat(lngInput.value) || 112.7521;

    const map = L.map('map').setView([defaultLat, defaultLng], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    let marker = L.marker([defaultLat, defaultLng], { draggable: true }).addTo(map);

    function setLatLngAndAddress(lat, lng) {
        lat = parseFloat(lat);
        lng = parseFloat(lng);

        latInput.value = lat.toFixed(6);
        lngInput.value = lng.toFixed(6);

        const url = `https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`;

        fetch(url, { headers: { 'Accept': 'application/json' } })
            .then(res => res.json())
            .then(data => {
                if (data && data.display_name) {
                    addrInput.value = data.display_name;
                }
            })
            .catch(err => {
                console.error('Reverse geocode error:', err);
            });
    }

    map.on('click', function (e) {
        marker.setLatLng(e.latlng);
        setLatLngAndAddress(e.latlng.lat, e.latlng.lng);
    });

    marker.on('dragend', function (e) {
        const pos = e.target.getLatLng();
        setLatLngAndAddress(pos.lat, pos.lng);
    });
});
</script>
@endpush
