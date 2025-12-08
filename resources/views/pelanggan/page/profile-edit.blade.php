@extends('pelanggan.layout.index')

@section('content')
<div class="container py-5">

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0">Edit Profil</h4>
                        <small class="text-muted">Perbarui data akun kamu</small>
                    </div>
                    <a href="{{ route('customer.profile') }}" class="btn btn-sm btn-outline-secondary">
                        Batal
                    </a>
                </div>
                <div class="card-body">

                    <form action="{{ route('customer.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">

                                {{-- FOTO PROFIL --}}
                                <div class="mb-3">
                                    <label class="form-label">Foto Profil</label>
                                    <div class="d-flex align-items-center gap-3">
                                        @if($customer->photo)
                                            <img src="{{ asset('storage/customer/'.$customer->photo) }}"
                                                 alt="Foto Profil"
                                                 class="rounded-circle"
                                                 style="width: 70px; height: 70px; object-fit: cover;">
                                        @else
                                            <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center"
                                                 style="width: 70px; height: 70px; font-size: 28px;">
                                                {{ strtoupper(substr($customer->name, 0, 1)) }}
                                            </div>
                                        @endif

                                        <div class="flex-grow-1">
                                            <input type="file" name="photo" class="form-control">
                                            <small class="text-muted">
                                                Format: JPG, JPEG, PNG, WEBP. Maks 2 MB.
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" name="name" class="form-control"
                                           value="{{ old('name', $customer->name) }}" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control"
                                           value="{{ old('email', $customer->email) }}" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Nomor Telepon</label>
                                    <input type="text" name="phone" class="form-control"
                                           value="{{ old('phone', $customer->phone) }}" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Alamat 1</label>
                                    <input type="text" name="address1" id="address1" class="form-control"
                                           value="{{ old('address1', $customer->address1) }}" required>
                                    <small class="text-muted">
                                        Bisa diisi manual atau pilih titik di peta.
                                    </small>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Alamat 2 (Opsional)</label>
                                    <input type="text" name="address2" class="form-control"
                                           value="{{ old('address2', $customer->address2) }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Tanggal Lahir</label>
                                    <input type="date" name="birth_date" class="form-control"
                                           value="{{ old('birth_date', $customer->birth_date) }}">
                                </div>

                                {{-- lat & lng disimpan hidden --}}
                                <input type="hidden" name="lat" id="lat"
                                       value="{{ old('lat', $customer->lat) }}">
                                <input type="hidden" name="lng" id="lng"
                                       value="{{ old('lng', $customer->lng) }}">

                                <div class="d-flex justify-content-end gap-2 mt-2">
                                    <a href="{{ route('customer.profile') }}" class="btn btn-secondary">
                                        Batal
                                    </a>
                                    <button type="submit" class="btn btn-success">
                                        Simpan Perubahan
                                    </button>
                                </div>

                            </div>

                            {{-- KANAN: PETA --}}
                            <div class="col-md-6">
                                <label class="form-label">Pilih Lokasi di Peta (OpenStreetMap)</label>
                                <div id="map" style="width: 100%; height: 380px; border-radius: 8px; overflow: hidden;"></div>
                                <small class="text-muted">
                                    Klik pada peta untuk memilih lokasi. Alamat 1 akan terisi otomatis berdasarkan titik yang dipilih.
                                </small>
                            </div>
                        </div>

                    </form>

                </div>
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
    const latInput  = document.getElementById('lat');
    const lngInput  = document.getElementById('lng');
    const addrInput = document.getElementById('address1');

    let defaultLat = parseFloat(latInput.value) || -7.2575;
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

        fetch(url, {
            headers: {
                'Accept': 'application/json'
            }
        })
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
