@extends('pelanggan.layout.index')

@section('content')
<div class="container py-4">

    <div class="row g-4 align-items-start">

        {{-- FOTO PRODUK --}}
        <div class="col-md-5">
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                <img src="{{ asset('storage/product/' . $product->foto) }}"
                     alt="{{ $product->nama_product }}"
                     class="img-fluid"
                     style="width: 100%; height: 320px; object-fit: cover;">
            </div>
        </div>

        {{-- INFO PRODUK --}}
        <div class="col-md-7">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">

                    <h3 class="mb-1">{{ $product->nama_product }}</h3>

                    {{-- Label kecil type & kategori --}}
                    <p class="text-muted mb-2" style="font-size: 13px;">
                        @if(!empty($product->type))
                            <span class="badge bg-light text-dark border me-1">
                                {{ ucfirst($product->type) }}
                            </span>
                        @endif
                        @if(!empty($product->kategory))
                            <span class="badge bg-light text-dark border">
                                {{ ucfirst($product->kategory) }}
                            </span>
                        @endif
                    </p>

                    {{-- RATING DUMMY --}}
                    <div class="d-flex align-items-center mb-2">
                        <div class="me-2" style="color:#ffc107;">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-regular fa-star"></i>
                        </div>
                        <small class="text-muted">(Rating contoh)</small>
                    </div>

                    {{-- HARGA --}}
                    <h4 class="text-danger fw-bold mb-1">
                        Rp {{ number_format($product->harga, 0, ',', '.') }}
                    </h4>

                    {{-- STOK --}}
                    <p class="mb-3" style="font-size: 14px;">
                        Stok tersedia:
                        <strong>{{ $product->quantity }}</strong> unit
                    </p>

                    {{-- DESKRIPSI --}}
                    <div class="mb-3">
                        <h6 class="fw-semibold mb-1">Deskripsi Produk</h6>
                        <p class="mb-0" style="font-size: 14px; white-space: pre-line;">
                            {{ $product->deskripsi ?? 'Belum ada deskripsi untuk produk ini.' }}
                        </p>
                    </div>

                    <hr>

                    {{-- ADD TO CART --}}
                    <form action="{{ route('addToCart') }}" method="POST" class="mt-2">
                        @csrf
                        <input type="hidden" name="id_barang" value="{{ $product->id }}">

                        <div class="row g-2 align-items-center mb-3">
                            <div class="col-auto">
                                <label class="form-label mb-0" for="qty">Jumlah</label>
                            </div>
                            <div class="col-4 col-sm-3">
                                <input type="number"
                                       name="qty"
                                       id="qty"
                                       value="1"
                                       min="1"
                                       max="{{ $product->quantity }}"
                                       class="form-control form-control-sm">
                            </div>
                        </div>

                        <div class="d-flex flex-column flex-sm-row gap-2">
                            <button type="submit" class="btn btn-warning flex-fill">
                                <i class="fa-solid fa-cart-plus me-1"></i>
                                Tambah ke Keranjang
                            </button>

                            <a href="{{ route('checkout') }}" class="btn btn-outline-success flex-fill">
                                <i class="fa-solid fa-bag-shopping me-1"></i>
                                Lanjut ke Checkout
                            </a>
                        </div>
                    </form>

                    <div class="mt-3">
                        <a href="{{ url()->previous() }}" style="font-size: 13px;">
                            ← Kembali ke halaman sebelumnya
                        </a>
                    </div>

                </div>
            </div>
        </div>

    </div>

</div>
@endsection
