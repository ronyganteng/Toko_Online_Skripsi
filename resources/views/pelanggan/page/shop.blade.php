@extends('pelanggan.layout.index')

@section('content')
<style>
    /* AREA SHOP */
    .shop-hero {
        background: linear-gradient(135deg, #b71c1c, #ff7043);
        color: #fff;
        border-radius: 16px;
        padding: 24px 28px;
        margin-top: 24px;
        margin-bottom: 24px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }
    .shop-hero h3 {
        font-weight: 700;
        margin-bottom: 4px;
    }
    .shop-hero p {
        margin: 0;
        opacity: 0.9;
    }

    /* SIDEBAR CATEGORY */
    .shop-sidebar-card {
        border-radius: 18px;
        border: none;
        box-shadow: 0 6px 16px rgba(0,0,0,0.08);
        overflow: hidden;
    }
    .shop-sidebar-card .card-header {
        background: #fafafa;
        border-bottom: none;
        font-weight: 600;
        font-size: 18px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .shop-sidebar-card .card-header i {
        color: #b71c1c;
    }
    .category-chip-title {
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: .05em;
        color: #b71c1c;
        margin-bottom: 6px;
        font-weight: 600;
    }

    .accordion-button {
        background-color: #fff;
        font-weight: 600;
    }
    .accordion-button:not(.collapsed) {
        background-color: #fff3e0;
        color: #bf360c;
        box-shadow: none;
    }
    .accordion-body a.page-link {
        border-radius: 999px;
        border: none;
        padding: 6px 12px;
        font-size: 14px;
        color: #555;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }
    .accordion-body a.page-link i {
        font-size: 11px;
    }
    .accordion-body a.page-link:hover {
        background: #ffe0b2;
        color: #bf360c;
    }
    .accordion-body a.page-link.active-filter {
        background: #bf360c;
        color: #fff;
    }

    .btn-reset-filter {
        border-radius: 999px;
        font-weight: 500;
        font-size: 14px;
    }

    /* PRODUCT LIST */
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
    .btn-cart i {
        font-size: 16px;
    }

    /* SEARCH BAR */
    .shop-search-wrapper {
        max-width: 420px;
        width: 100%;
    }
    .shop-search-wrapper input {
        border-radius: 999px 0 0 999px;
    }
    .shop-search-wrapper button {
        border-radius: 0 999px 999px 0;
        padding-inline: 18px;
        background: #b71c1c;
        border-color: #b71c1c;
    }

    .filter-badges span {
        font-size: 12px;
    }
</style>

<div class="shop-hero">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
            <h3>Temukan Perlengkapan Rohani Terbaik</h3>
            <p>Pilih salib, patung, dan aksesoris rohani yang cocok untukmu atau orang yang kamu kasihi.</p>
        </div>
        <div class="text-end">
            <span class="badge bg-light text-dark">
                {{ $products->total() }} produk tersedia
            </span>
        </div>
    </div>
</div>

<div class="row">

    {{-- SIDEBAR KATEGORI --}}
    <div class="col-md-3 mb-4">
        <div class="card shop-sidebar-card">
            <div class="card-header">
                <i class="fa-solid fa-filter"></i>
                <span>Kategori Produk</span>
            </div>
            <div class="card-body">
                <p class="category-chip-title">Pilih kategori</p>

                <div class="accordion accordion-flush" id="accordionFlushExample">

                    {{-- SALIB --}}
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseOne" aria-expanded="false"
                                    aria-controls="flush-collapseOne">
                                <i class="fa-solid fa-cross me-2 text-danger"></i> Salib
                            </button>
                        </h2>
                        <div id="flush-collapseOne" class="accordion-collapse collapse"
                             aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                <div class="d-flex flex-column gap-2">
                                    <a href="{{ route('shop', ['type' => 'salib', 'kategori' => 'salibkayu']) }}"
                                       class="page-link {{ request('type')=='salib' && request('kategori')=='salibkayu' ? 'active-filter' : '' }}">
                                        <i class="fas fa-plus"></i> Salib Kayu
                                    </a>
                                    <a href="{{ route('shop', ['type' => 'salib', 'kategori' => 'salibbesi']) }}"
                                       class="page-link {{ request('type')=='salib' && request('kategori')=='salibbesi' ? 'active-filter' : '' }}">
                                        <i class="fas fa-plus"></i> Salib Besi
                                    </a>
                                    <a href="{{ route('shop', ['type' => 'salib', 'kategori' => 'salibcustom']) }}"
                                       class="page-link {{ request('type')=='salib' && request('kategori')=='salibcustom' ? 'active-filter' : '' }}">
                                        <i class="fas fa-plus"></i> Salib Custom
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ALKITAB / PATUNG --}}
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseTwo" aria-expanded="false"
                                    aria-controls="flush-collapseTwo">
                                <i class="fa-solid fa-book-bible me-2 text-primary"></i> Alkitab
                            </button>
                        </h2>
                        <div id="flush-collapseTwo" class="accordion-collapse collapse"
                             aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                <div class="d-flex flex-column gap-2">
                                    <a href="{{ route('shop', ['type' => 'alkitab', 'kategori' => 'alkitabkristen']) }}"
                                       class="page-link {{ request('type')=='alkitab' && request('kategori')=='alkitabkristen' ? 'active-filter' : '' }}">
                                        <i class="fas fa-plus"></i> Alkitab Kristen
                                    </a>
                                    <a href="{{ route('shop', ['type' => 'alkitab', 'kategori' => 'alkitabkatolik']) }}"
                                       class="page-link {{ request('type')=='alkitab' && request('kategori')=='alkitabkatolik' ? 'active-filter' : '' }}">
                                        <i class="fas fa-plus"></i> Alkitab Katolik
                                    </a>
                                    <a href="{{ route('shop', ['type' => 'alkitab', 'kategori' => 'alkitabcustom']) }}"
                                       class="page-link {{ request('type')=='alkitab' && request('kategori')=='alkitabcustom' ? 'active-filter' : '' }}">
                                        <i class="fas fa-plus"></i> Alkitab Custom
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- AKSESORIS --}}
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseThree" aria-expanded="false"
                                    aria-controls="flush-collapseThree">
                                <i class="fa-solid fa-beads me-2 text-success"></i> Aksesoris
                            </button>
                        </h2>
                        <div id="flush-collapseThree" class="accordion-collapse collapse"
                             aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                <div class="d-flex flex-column gap-2">
                                    <a href="{{ route('shop', ['type' => 'aksesoris', 'kategori' => 'gelang']) }}"
                                       class="page-link {{ request('type')=='aksesoris' && request('kategori')=='gelang' ? 'active-filter' : '' }}">
                                        <i class="fas fa-plus"></i> Gelang
                                    </a>
                                    <a href="{{ route('shop', ['type' => 'aksesoris', 'kategori' => 'kalung']) }}"
                                       class="page-link {{ request('type')=='aksesoris' && request('kategori')=='kalung' ? 'active-filter' : '' }}">
                                        <i class="fas fa-plus"></i> Kalung
                                    </a>
                                    <a href="{{ route('shop', ['type' => 'aksesoris', 'kategori' => 'rosario']) }}"
                                       class="page-link {{ request('type')=='aksesoris' && request('kategori')=='rosario' ? 'active-filter' : '' }}">
                                        <i class="fas fa-plus"></i> Rosario
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- RESET FILTER --}}
                <div class="mt-4">
                    <a href="{{ route('shop') }}" class="btn btn-outline-secondary btn-reset-filter w-100">
                        <i class="fa-solid fa-rotate-left me-1"></i> Reset Filter
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- KOLOM PRODUK + SEARCH --}}
    <div class="col-md-9">

        {{-- FORM SEARCH --}}
        <div class="d-flex justify-content-end mb-3">
            <form action="{{ route('shop') }}" method="GET" class="d-flex shop-search-wrapper">
                @if(request('type'))
                    <input type="hidden" name="type" value="{{ request('type') }}">
                @endif
                @if(request('kategori'))
                    <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                @endif

                <input type="text"
                       name="search"
                       class="form-control"
                       placeholder="Cari nama produk..."
                       value="{{ request('search') }}">
                <button class="btn btn-primary ms-0">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </form>
        </div>

        {{-- BADGE INFO FILTER --}}
        <div class="mb-3 filter-badges">
            @if(request('search'))
                <span class="badge bg-secondary me-2">
                    <i class="fa-solid fa-magnifying-glass me-1"></i> "{{ request('search') }}"
                </span>
            @endif
            @if(request('type'))
                <span class="badge bg-info text-dark me-2">
                    <i class="fa-solid fa-layer-group me-1"></i> Type: {{ request('type') }}
                </span>
            @endif
            @if(request('kategori'))
                <span class="badge bg-success me-2">
                    <i class="fa-solid fa-tag me-1"></i> Kategori: {{ request('kategori') }}
                </span>
            @endif
        </div>

        {{-- LIST PRODUK --}}
        <div class="d-flex flex-wrap gap-4 mb-5">
            @if ($products->isEmpty())
                <p class="text-muted">Belum ada produk untuk filter yang dipilih.</p>
            @else
                @foreach ($products as $p)
                    <div class="card product-card">
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
                        <div class="card-footer d-flex flex-row justify-content-between align-items-center">
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

        {{-- PAGINATION --}}
        @if($products->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div>
                    <strong>Menampilkan {{ $products->firstItem() }} - {{ $products->lastItem() }}
                        dari total {{ $products->total() }} produk</strong>
                </div>
                <div>
                    {{ $products->links('pagination::bootstrap-5') }}
                </div>
            </div>
        @endif

    </div>
</div>
@endsection
