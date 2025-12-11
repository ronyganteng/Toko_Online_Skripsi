@extends('pelanggan.layout.index')

@section('content')
<style>
    .home-hero {
        margin-top: 24px;
        margin-bottom: 32px;
        padding: 32px 28px;
        border-radius: 18px;
        background: radial-gradient(circle at top left, #ffccbc, #b71c1c);
        color: #fff;
        box-shadow: 0 12px 26px rgba(0,0,0,0.18);
    }
    .home-hero-title {
        font-weight: 800;
        font-size: 30px;
        letter-spacing: .03em;
    }
    .home-hero-subtitle {
        opacity: 0.95;
        font-size: 14px;
    }
    .hero-chip {
        background: rgba(255,255,255,0.18);
        border-radius: 999px;
        padding: 6px 12px;
        font-size: 12px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .hero-btn-main {
        border-radius: 999px;
        padding-inline: 20px;
        font-weight: 600;
        background: #ffffff;
        color: #b71c1c;
        border: none;
    }
    .hero-btn-main:hover {
        color: #8b0000;
    }
    .hero-btn-secondary {
        border-radius: 999px;
        padding-inline: 18px;
        border-color: #fff;
        color: #fff;
        font-weight: 500;
    }

    .hero-stats {
        display: flex;
        gap: 18px;
        flex-wrap: wrap;
        margin-top: 14px;
    }
    .hero-stat-item {
        background: rgba(255,255,255,0.15);
        border-radius: 14px;
        padding: 8px 12px;
        font-size: 12px;
    }
    .hero-stat-item strong {
        font-size: 16px;
    }

    /* SECTION TITLE */
    .section-title {
        font-weight: 700;
        font-size: 20px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-top: 8px;
    }
    .section-title i {
        color: #b71c1c;
    }
    .section-subtitle {
        font-size: 13px;
        color: #777;
        margin-bottom: 12px;
    }

    /* PRODUCT CARD */
    .product-card {
        width: 230px;
        border-radius: 16px;
        border: none;
        overflow: hidden;
        box-shadow: 0 10px 22px rgba(0,0,0,0.10);
        transition: transform .18s ease, box-shadow .18s ease;
        background: #ffffff;
    }
    .product-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 14px 26px rgba(0,0,0,0.16);
    }
    .product-card .card-header {
        padding: 0;
        border-bottom: none;
        background: #fafafa;
    }
    .product-card img {
        width: 100%;
        height: 210px;
        object-fit: cover;
    }
    .product-name {
        font-weight: 600;
        font-size: 15px;
        min-height: 40px;
    }
    .product-meta {
        font-size: 12px;
        color: #999;
    }
    .badge-stock {
        background: #e0f2f1;
        color: #004d40;
        font-size: 11px;
        border-radius: 999px;
        padding: 3px 9px;
    }
    .product-price {
        font-size: 16px;
        font-weight: 700;
        color: #b71c1c;
    }
    .btn-cart {
        border-radius: 999px;
        padding: 6px 10px;
        border-width: 2px;
    }

    .pagination-summary {
        font-size: 13px;
    }

    @media (max-width: 767.98px) {
        .home-hero {
            padding: 24px 18px;
        }
        .home-hero-title {
            font-size: 24px;
        }
    }
</style>

{{-- ALERT SUCCESS --}}
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

{{-- HERO SECTION --}}
<div class="home-hero">
    <div class="row align-items-center g-3">
        <div class="col-md-7">
            <div class="hero-chip mb-2">
                <i class="fa-solid fa-cross"></i>
                Toko Devosi & Perlengkapan Rohani
            </div>
            <h1 class="home-hero-title mt-2">
                Hadiahkan Berkat,<br> Lewat Setiap Salib & Aksesoris.
            </h1>
            <p class="home-hero-subtitle mt-2">
                Pilih salib, patung, rosario, dan aksesoris rohani berkualitas untuk rumah, gereja,
                atau hadiah bagi orang yang kamu kasihi.
            </p>
            <div class="mt-3 d-flex flex-wrap gap-2">
                <a href="{{ route('shop') }}" class="btn hero-btn-main">
                    Jelajahi Katalog <i class="fa-solid fa-arrow-right ms-1"></i>
                </a>
                <a href="#new-products" class="btn btn-outline-light hero-btn-secondary">
                    Lihat Produk Terbaru
                </a>
            </div>

            <div class="hero-stats">
                <div class="hero-stat-item">
                    <strong>Best Seller</strong><br>
                    <span>Produk paling banyak dipilih pelanggan</span>
                </div>
                <div class="hero-stat-item">
                    <strong>New Arrival</strong><br>
                    <span>Update barang rohani secara berkala</span>
                </div>
            </div>
        </div>
        <div class="col-md-5 text-center">
            <img src="{{ asset('assets/images/contact.jpg') }}"
                 alt="Banner"
                 style="max-width: 100%; border-radius: 18px; box-shadow: 0 8px 20px rgba(0,0,0,0.3); object-fit: cover;">
        </div>
    </div>
</div>

{{-- BEST SELLER --}}
@if ($best->count() > 0)
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h4 class="section-title">
                <i class="fa-solid fa-fire-flame-curved"></i>
                Best Seller
            </h4>
            <p class="section-subtitle">
                Produk yang paling banyak dibeli dan disukai pelanggan.
            </p>
        </div>
        <div class="d-none d-md-block">
            <a href="{{ route('shop') }}" class="btn btn-outline-secondary btn-sm rounded-pill">
                Lihat semua produk
            </a>
        </div>
    </div>

    <div class="mt-2 mb-4 d-flex flex-wrap gap-4">
        @foreach ($best as $b)
            <div class="card product-card">
                <a href="{{ route('product.show', $b->id) }}" class="text-decoration-none text-dark">
                    <div class="card-header">
                        <img src="{{ asset('storage/product/' . $b->foto) }}"
                             alt="{{ $b->nama_product }}">
                    </div>
                    <div class="card-body">
                        <p class="product-name mb-1">{{ $b->nama_product }}</p>
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="product-meta">
                                <i class="fa-regular fa-star text-warning"></i> 5.0
                            </span>
                            <span class="badge badge-stock">
                                Best Seller
                            </span>
                        </div>
                    </div>
                </a>
                <div class="card-footer d-flex justify-content-between align-items-center">
                    <p class="m-0 product-price">
                        Rp {{ number_format($b->harga, 0, ',', '.') }}
                    </p>

                    <form action="{{ route('addToCart') }}" method="POST" class="m-0">
                        @csrf
                        <input type="hidden" name="id_barang" value="{{ $b->id }}">
                        <input type="hidden" name="qty" value="1">
                        <button type="submit" class="btn btn-outline-primary btn-cart">
                            <i class="fa-solid fa-cart-plus"></i>
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@endif

{{-- NEW PRODUCT --}}
<div id="new-products" class="mt-4">
    <h4 class="section-title">
        <i class="fa-solid fa-box-open"></i>
        New Product
    </h4>
    <p class="section-subtitle">
        Koleksi terbaru yang baru saja masuk ke katalog kami.
    </p>

    <div class="mt-2 mb-4 d-flex flex-wrap gap-4">
        @if ($data->isEmpty())
            <p class="text-muted">Belum ada produk baru saat ini.</p>
        @else
            @foreach ($data as $p)
                <div class="card product-card">
                    <a href="{{ route('product.show', $p->id) }}" class="text-decoration-none text-dark">
                        <div class="card-header">
                            <img src="{{ asset('storage/product/' . $p->foto) }}"
                                 alt="{{ $p->nama_product }}">
                        </div>
                        <div class="card-body">
                            <p class="product-name mb-1">{{ $p->nama_product }}</p>
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="product-meta">
                                    <i class="fa-regular fa-star text-warning"></i> 5.0
                                </span>
                                <span class="badge badge-stock">
                                    Stok: {{ $p->quantity }}
                                </span>
                            </div>
                        </div>
                    </a>
                    <div class="card-footer d-flex justify-content-between align-items-center">
                        <p class="m-0 product-price">
                            Rp {{ number_format($p->harga, 0, ',', '.') }}
                        </p>

                        <form action="{{ route('addToCart') }}" method="POST" class="m-0">
                            @csrf
                            <input type="hidden" name="id_barang" value="{{ $p->id }}">
                            <input type="hidden" name="qty" value="1">
                            <button type="submit" class="btn btn-outline-primary btn-cart">
                                <i class="fa-solid fa-cart-plus"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>

@if (!$data->isEmpty())
    <div class="d-flex justify-content-between align-items-center mt-3">
        <div class="pagination-summary">
            <strong>
                Menampilkan {{ $data->firstItem() }} - {{ $data->lastItem() }} dari total
                {{ $data->total() }} produk
            </strong>
        </div>
        <div>
            {{ $data->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endif
@endsection
