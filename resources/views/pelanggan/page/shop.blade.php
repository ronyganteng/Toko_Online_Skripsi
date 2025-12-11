@extends('pelanggan.layout.index')

@section('content')
<style>
    .shop-layout {
        margin-top: 24px;
    }

    /* SIDEBAR CARD */
    .shop-sidebar-card {
        border-radius: 18px;
        border: none;
        background: #ffffff;
        box-shadow: 0 10px 24px rgba(0,0,0,0.10);
        overflow: hidden;
    }
    .shop-sidebar-card .card-header {
        background: linear-gradient(135deg, #5d1010, #b71c1c);
        color: #fff;
        font-weight: 600;
        font-size: 15px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .shop-sidebar-card .card-header i {
        font-size: 18px;
    }

    .shop-category-header {
        font-size: 13px;
        font-weight: 600;
        text-transform: uppercase;
        color: #555;
        margin-bottom: 4px;
        margin-top: 8px;
    }

    .shop-category-link {
        font-size: 13px;
        padding: 6px 10px;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        color: #444;
        background: #f5f5f5;
        margin-bottom: 6px;
        border: 1px solid transparent;
        transition: all .15s ease;
    }
    .shop-category-link i {
        font-size: 11px;
    }
    .shop-category-link:hover {
        background: #ffe0b2;
        border-color: #ffb74d;
        color: #5d1010;
    }
    .shop-category-link.active {
        background: #ffb74d;
        border-color: #fb8c00;
        color: #5d1010;
    }

    /* PRODUCT CARD (SAMA DENGAN HOME) */
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
    .badge-type {
        background: #f3e5f5;
        color: #6a1b9a;
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

    @media (max-width: 767.98px) {
        .product-card {
            width: 100%;
        }
    }
</style>

<div class="row shop-layout">

    {{-- ========== SIDEBAR KATEGORI ========== --}}
    <div class="col-md-3 mb-4">
        <div class="card shop-sidebar-card">
            <div class="card-header">
                <i class="fa-solid fa-filter"></i>
                <span>Filter Kategori</span>
            </div>
            <div class="card-body">

                {{-- SALIB --}}
                <div class="mb-3">
                    <div class="shop-category-header">Salib</div>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('shop', ['type' => 'salib', 'kategori' => 'salibkayu']) }}"
                           class="shop-category-link {{ request('type')=='salib' && request('kategori')=='salibkayu' ? 'active' : '' }}">
                            <i class="fas fa-plus"></i> Salib Kayu
                        </a>
                        <a href="{{ route('shop', ['type' => 'salib', 'kategori' => 'salibbesi']) }}"
                           class="shop-category-link {{ request('type')=='salib' && request('kategori')=='salibbesi' ? 'active' : '' }}">
                            <i class="fas fa-plus"></i> Salib Besi
                        </a>
                        <a href="{{ route('shop', ['type' => 'salib', 'kategori' => 'salibcustom']) }}"
                           class="shop-category-link {{ request('type')=='salib' && request('kategori')=='salibcustom' ? 'active' : '' }}">
                            <i class="fas fa-plus"></i> Salib Custom
                        </a>
                    </div>
                </div>

                {{-- ALKITAB / PATUNG / LAINNYA --}}
                <div class="mb-3">
                    <div class="shop-category-header">Alkitab</div>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('shop', ['type' => 'alkitab', 'kategori' => 'alkitabkristen']) }}"
                           class="shop-category-link {{ request('type')=='alkitab' && request('kategori')=='alkitabkristen' ? 'active' : '' }}">
                            <i class="fas fa-plus"></i> Alkitab Kristen
                        </a>
                        <a href="{{ route('shop', ['type' => 'alkitab', 'kategori' => 'alkitabkatolik']) }}"
                           class="shop-category-link {{ request('type')=='alkitab' && request('kategori')=='alkitabkatolik' ? 'active' : '' }}">
                            <i class="fas fa-plus"></i> Alkitab Katolik
                        </a>
                        <a href="{{ route('shop', ['type' => 'alkitab', 'kategori' => 'alkitabcustom']) }}"
                           class="shop-category-link {{ request('type')=='alkitab' && request('kategori')=='alkitabcustom' ? 'active' : '' }}">
                            <i class="fas fa-plus"></i> Alkitab Custom
                        </a>
                    </div>
                </div>

                {{-- AKSESORIS --}}
                <div class="mb-3">
                    <div class="shop-category-header">Aksesoris</div>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('shop', ['type' => 'aksesoris', 'kategori' => 'gelang']) }}"
                           class="shop-category-link {{ request('type')=='aksesoris' && request('kategori')=='gelang' ? 'active' : '' }}">
                            <i class="fas fa-plus"></i> Gelang
                        </a>
                        <a href="{{ route('shop', ['type' => 'aksesoris', 'kategori' => 'kalung']) }}"
                           class="shop-category-link {{ request('type')=='aksesoris' && request('kategori')=='kalung' ? 'active' : '' }}">
                            <i class="fas fa-plus"></i> Kalung
                        </a>
                        <a href="{{ route('shop', ['type' => 'aksesoris', 'kategori' => 'rosario']) }}"
                           class="shop-category-link {{ request('type')=='aksesoris' && request('kategori')=='rosario' ? 'active' : '' }}">
                            <i class="fas fa-plus"></i> Rosario
                        </a>
                    </div>
                </div>

                {{-- RESET FILTER --}}
                <hr>
                <a href="{{ route('shop') }}" class="btn btn-sm btn-outline-secondary w-100">
                    Reset Semua Filter
                </a>
            </div>
        </div>
    </div>

    {{-- ========== KOLOM PRODUK + SEARCH ========== --}}
    <div class="col-md-9">

        {{-- HEADER & SEARCH --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
            <div class="mb-2">
                <h4 class="section-title">
                    <i class="fa-solid fa-store"></i>
                    Katalog Produk
                </h4>
                <p class="section-subtitle">
                    Temukan salib, patung, rosario, dan perlengkapan rohani lainnya.
                </p>
            </div>

            <div class="mb-2" style="max-width: 400px; width: 100%;">
                <form action="{{ route('shop') }}" method="GET" class="d-flex">
                    {{-- Pertahankan filter type & kategori saat search --}}
                    @if(request('type'))
                        <input type="hidden" name="type" value="{{ request('type') }}">
                    @endif
                    @if(request('kategori'))
                        <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                    @endif

                    <input type="text"
                           name="search"
                           class="form-control"
                           placeholder="Cari produk..."
                           value="{{ request('search') }}">
                    <button class="btn btn-primary ms-2">Cari</button>
                </form>
            </div>
        </div>

        {{-- BADGE INFO FILTER --}}
        <div class="mb-3">
            @if(request('search'))
                <span class="badge bg-secondary me-2">
                    Search: "{{ request('search') }}"
                </span>
            @endif
            @if(request('type'))
                <span class="badge bg-info text-dark me-2">
                    Type: {{ request('type') }}
                </span>
            @endif
            @if(request('kategori'))
                <span class="badge bg-success me-2">
                    Kategori: {{ request('kategori') }}
                </span>
            @endif
        </div>

        {{-- LIST PRODUK --}}
        <div class="d-flex flex-wrap gap-4 mb-5">
            @if ($products->isEmpty())
                <p class="text-muted">Belum ada produk yang cocok dengan filter / pencarian.</p>
            @else
                @foreach ($products as $p)
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

                                {{-- type / kategori kecil di bawah --}}
                                <div style="font-size: 11px; color:#777;">
                                    @if($p->type)
                                        <span class="badge-type me-1">
                                            {{ ucfirst($p->type) }}
                                        </span>
                                    @endif
                                    @if($p->kategory)
                                        <span class="badge bg-light text-muted border">
                                            {{ $p->kategory }}
                                        </span>
                                    @endif
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

        {{-- PAGINATION --}}
        @if($products->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div>
                    <strong>
                        Menampilkan {{ $products->firstItem() }} - {{ $products->lastItem() }}
                        dari total {{ $products->total() }} data
                    </strong>
                </div>
                <div>
                    {{ $products->links('pagination::bootstrap-5') }}
                </div>
            </div>
        @endif

    </div>
</div>
@endsection
