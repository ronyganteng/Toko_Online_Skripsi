@extends('pelanggan.layout.index')

@section('content')
<style>
    .profile-wrapper {
        background: linear-gradient(135deg, #fce4ec 0%, #fff3e0 50%, #e3f2fd 100%);
        border-radius: 24px;
        padding: 32px 24px;
    }

    .profile-card {
        border-radius: 20px;
        border: none;
        overflow: hidden;
    }

    .profile-header {
        background: linear-gradient(135deg, #b71c1c, #d32f2f);
        color: #fff;
        padding: 18px 24px;
    }

    .profile-header h4 {
        margin-bottom: 0;
        font-weight: 700;
    }

    .profile-badge {
        background: rgba(255,255,255,0.15);
        padding: 4px 10px;
        border-radius: 999px;
        font-size: 12px;
    }

    .profile-avatar {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #fff;
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }

    .profile-avatar-placeholder {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: #ffeeee;
        color: #b71c1c;
        font-size: 40px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 4px solid #fff;
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }

    .profile-name {
        font-size: 1.5rem;
        font-weight: 700;
    }

    .profile-role {
        font-size: .9rem;
        font-weight: 600;
        color: #ef9a9a;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .profile-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        border-radius: 999px;
        font-size: .85rem;
        background-color: #f5f5f5;
    }

    .profile-section-title {
        font-size: .9rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .08em;
        color: #9e9e9e;
        margin-bottom: .5rem;
    }

    .profile-detail-label {
        font-size: .9rem;
        color: #9e9e9e;
        margin-bottom: 2px;
    }

    .profile-detail-value {
        font-size: 1rem;
        font-weight: 500;
        color: #424242;
    }

    .profile-map-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        border-radius: 999px;
        background: #e3f2fd;
        font-size: .85rem;
        color: #1565c0;
    }

    @media (max-width: 768px) {
        .profile-wrapper {
            padding: 20px 16px;
        }
    }
</style>

<div class="container py-5">

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="profile-wrapper">
        <div class="card shadow profile-card">
            {{-- HEADER --}}
            <div class="profile-header d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div>
                    <h4>Profil Pelanggan</h4>
                    <div class="small opacity-75">Kelola data akun dan alamat pengirimanmu</div>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="profile-badge">
                        <i class="fa fa-user-check me-1"></i> Pelanggan Terdaftar
                    </span>
                    <a href="{{ route('customer.profile.edit') }}" class="btn btn-light btn-sm">
                        <i class="fa fa-pen-to-square me-1"></i> Edit Profil
                    </a>
                </div>
            </div>

            {{-- BODY --}}
            <div class="card-body p-4">
                <div class="row g-4">
                    {{-- KIRI: AVATAR + RINGKASAN --}}
                    <div class="col-md-4 text-center text-md-start border-md-end">
                        <div class="d-flex flex-column align-items-center align-items-md-start gap-3">

                            @if($customer->photo)
                                <img src="{{ asset('storage/customer/'.$customer->photo) }}"
                                     alt="Foto Profil"
                                     class="profile-avatar">
                            @else
                                <div class="profile-avatar-placeholder">
                                    {{ strtoupper(substr($customer->name, 0, 1)) }}
                                </div>
                            @endif

                            <div>
                                <div class="profile-name">{{ $customer->name }}</div>
                                <div class="profile-role mb-2">Member St. Benedictus</div>

                                <div class="d-flex flex-column gap-2">
                                    <div class="profile-chip">
                                        <i class="fa fa-envelope"></i>
                                        <span>{{ $customer->email }}</span>
                                    </div>
                                    @if($customer->phone)
                                        <div class="profile-chip">
                                            <i class="fa fa-phone"></i>
                                            <span>{{ $customer->phone }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- KANAN: DETAIL LENGKAP --}}
                    <div class="col-md-8">
                        <div class="row g-4">

                            {{-- INFORMASI AKUN --}}
                            <div class="col-12">
                                <div class="profile-section-title">
                                    <i class="fa fa-id-card me-1"></i> Informasi Akun
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 mb-3">
                                        <div class="profile-detail-label">Nama Lengkap</div>
                                        <div class="profile-detail-value">
                                            {{ $customer->name }}
                                        </div>
                                    </div>
                                    <div class="col-sm-6 mb-3">
                                        <div class="profile-detail-label">Tanggal Lahir</div>
                                        <div class="profile-detail-value">
                                            {{ $customer->birth_date ? $customer->birth_date : '-' }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- ALAMAT PENGIRIMAN --}}
                            <div class="col-12">
                                <div class="profile-section-title">
                                    <i class="fa fa-location-dot me-1"></i> Alamat Pengiriman
                                </div>
                                <div class="mb-3">
                                    <div class="profile-detail-label">Alamat Utama</div>
                                    <div class="profile-detail-value">
                                        {{ $customer->address1 ?? '-' }}
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="profile-detail-label">Alamat Tambahan</div>
                                    <div class="profile-detail-value">
                                        {{ $customer->address2 ?? '-' }}
                                    </div>
                                </div>

                                <div>
                                    <div class="profile-detail-label mb-1">Lokasi di Peta</div>
                                    @if($customer->lat && $customer->lng)
                                        <span class="profile-map-pill">
                                            <i class="fa fa-map-pin"></i>
                                            {{ $customer->lat }}, {{ $customer->lng }}
                                        </span>
                                        <div class="small text-muted mt-1">
                                            Titik ini diambil dari pilihanmu di peta saat edit profil.
                                        </div>
                                    @else
                                        <span class="text-muted">Belum ada titik lokasi. Kamu bisa menambahkannya di menu Edit Profil.</span>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
