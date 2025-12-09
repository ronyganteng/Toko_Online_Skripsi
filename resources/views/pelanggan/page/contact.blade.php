@extends('pelanggan.layout.index')

@section('content')
<div class="container py-4">

    {{-- HERO SECTION --}}
    <div class="row align-items-center mb-4">
        <div class="col-md-7 mb-3 mb-md-0">
            <div class="contact-tag mb-2">
                <i class="fa-solid fa-envelope-open-text"></i>
                <span>Hubungi Kami</span>
            </div>
            <div class="contact-hero-heading mb-1">
                Contact Us
            </div>
            <p class="contact-hero-text">
                Punya pertanyaan tentang produk, pesanan, atau ingin kerja sama dengan
                St. Benedictus? Silakan kirim pesan, kami akan dengan senang hati membantu.
            </p>

            <div class="contact-stats">
                <div class="contact-stat-card">
                    <div class="icon-wrap">
                        <i class="fa fa-users"></i>
                    </div>
                    <div>
                        <p class="stat-number">+300</p>
                        <p class="stat-label">Pelanggan Puas</p>
                    </div>
                </div>

                <div class="contact-stat-card">
                    <div class="icon-wrap">
                        <i class="fa fa-home"></i>
                    </div>
                    <div>
                        <p class="stat-number">+300</p>
                        <p class="stat-label">Produk Tersedia</p>
                    </div>
                </div>

                <div class="contact-stat-card">
                    <div class="icon-wrap">
                        <i class="fa fa-cross"></i>
                    </div>
                    <div>
                        <p class="stat-number">Setiap Hari</p>
                        <p class="stat-label">Melayani dengan Hati</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Bisa pakai ilustrasi / foto --}}
        <div class="col-md-5 text-center">
            <img src="{{ asset('assets/images/contact.jpg') }}"
                 alt="Contact St. Benedictus"
                 class="img-fluid rounded-4 shadow-sm">
        </div>
    </div>

    {{-- MAP + FORM --}}
    <div class="row contact-wrapper mb-5">
        {{-- MAP LOKASI TOKO --}}
        <div class="col-md-5 mb-4 mb-md-0">
            <div class="contact-map-box">
                <div id="contactMap"></div>
            </div>
        </div>

        {{-- FORM KRITIK & SARAN --}}
        <div class="col-md-7">
            <div class="card contact-card">
                <div class="card-header text-center py-3">
                    <h4 class="mb-1">Kritik dan Saran</h4>
                    <p class="mb-0 contact-description">
                        Masukan Anda membantu kami menghadirkan pengalaman belanja rohani
                        yang lebih baik lagi.
                    </p>
                </div>
                <div class="card-body">

                    <form action="#" method="POST">
                        @csrf
                        <div class="mb-3 row align-items-center">
                            <label for="email" class="col-sm-3 col-form-label contact-label">
                                Email
                            </label>
                            <div class="col-sm-9">
                                <input type="email" class="form-control" id="email"
                                       name="email" placeholder="Masukan E-mail Anda">
                            </div>
                        </div>

                        <div class="mb-3 row align-items-start">
                            <label for="pesan" class="col-sm-3 col-form-label contact-label">
                                Pesan
                            </label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="pesan" name="pesan"
                                          rows="4" placeholder="Tulis kritik, saran, atau pertanyaan Anda di sini..."></textarea>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-contact-send mt-3 w-100">
                            Kirim Pesan Anda
                        </button>
                    </form>

                    <div class="mt-3 text-center" style="font-size: 13px; color:#777;">
                        Atau hubungi kami via WhatsApp:
                        <strong>08xx-xxxx-xxxx</strong>
                    </div>

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
    // Koordinat toko (contoh: Surabaya)
    const tokoLat = -7.2575;
    const tokoLng = 112.7521;

    const map = L.map('contactMap').setView([tokoLat, tokoLng], 14);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    const marker = L.marker([tokoLat, tokoLng]).addTo(map);
    marker.bindPopup(`
        <strong>St. Benedictus Store</strong><br>
        Surabaya, Indonesia<br>
        <span style="font-size:12px;">Klik untuk melihat lebih dekat.</span>
    `).openPopup();

    // Tambahan lingkaran lembut sekitar toko
    L.circle([tokoLat, tokoLng], {
        radius: 300,
        color: '#b71c1c',
        fillColor: '#ef9a9a',
        fillOpacity: 0.2
    }).addTo(map);
});
</script>
@endpush
