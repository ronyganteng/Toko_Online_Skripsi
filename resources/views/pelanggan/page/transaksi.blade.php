@extends('pelanggan.layout.index')

@section('content')
<style>
    .cart-page-title {
        font-weight: 700;
        letter-spacing: .5px;
    }

    .cart-item {
        border-radius: 16px;
        border: none;
    }

    .cart-item + .cart-item {
        margin-top: 1.5rem;
    }

    .cart-image {
        width: 120px;
        height: 120px;
        object-fit: contain;
        border-radius: 12px;
        background: #f8f9fa;
        padding: 8px;
    }

    .cart-product-name {
        font-size: 1.4rem;
        font-weight: 700;
        margin-bottom: .5rem;
    }

    .cart-label {
        font-size: .9rem;
        color: #6c757d;
        margin-bottom: .1rem;
    }

    .price-text {
        font-size: 1.1rem;
        font-weight: 600;
    }

    .qty-wrapper button {
        width: 36px;
        height: 36px;
    }

    .qty-wrapper input {
        width: 70px;
    }

    .cart-actions .btn {
        border-radius: 999px;
        font-weight: 600;
    }

    .cart-empty-card {
        border-radius: 16px;
        border: none;
    }
</style>

<div class="container py-5">
    <h2 class="mb-4 text-center cart-page-title">Keranjang Belanja</h2>

    @if($data->isEmpty())
        <div class="card cart-empty-card shadow-sm">
            <div class="card-body text-center py-5">
                <h4 class="mb-3">Keranjang masih kosong</h4>
                <p class="text-muted mb-4">
                    Yuk mulai belanja dulu. Pilih salib, patung, atau aksesoris yang kamu suka.
                </p>
                <a href="{{ route('shop') }}" class="btn btn-primary px-4">
                    Ke Halaman Shop
                </a>
            </div>
        </div>
    @else
        @foreach ($data as $x)
            <div class="card cart-item shadow-sm" data-price="{{ $x->product->harga }}">
                <div class="card-body d-flex flex-column flex-md-row align-items-center gap-4">

                    {{-- FOTO PRODUK --}}
                    <div class="flex-shrink-0">
                        <img src="{{ asset('storage/product/' . $x->product->foto) }}"
                             alt="{{ $x->product->nama_product }}"
                             class="cart-image">
                    </div>

                    {{-- DESKRIPSI + QTY + TOTAL --}}
                    <form action="{{ route('checkout.product', ['id' => $x->id]) }}"
                          method="POST"
                          class="flex-grow-1 w-100">
                        @csrf
                        <input type="hidden" name="idBarang" value="{{ $x->product->id }}">
                        {{-- harga satuan (raw number) --}}
                        <input type="hidden" name="harga" value="{{ $x->product->harga }}">
                        {{-- total (raw number, di-update via JS) --}}
                        <input type="hidden" name="total" class="input-total"
                               value="{{ $x->product->harga * $x->qty }}">

                        <div class="row align-items-center">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <div class="cart-product-name">
                                    {{ $x->product->nama_product }}
                                </div>

                                <div class="mb-2">
                                    <div class="cart-label">Harga Satuan</div>
                                    <div class="price-text">
                                        Rp {{ number_format($x->product->harga, 0, ',', '.') }}
                                    </div>
                                </div>

                                <div class="mb-2">
                                    <div class="cart-label">Quantity</div>
                                    <div class="d-flex align-items-center qty-wrapper">
                                        <button type="button"
                                                class="btn btn-outline-secondary btn-sm btn-minus"
                                                @if($x->qty <= 1) disabled @endif>-</button>

                                        <input type="number"
                                               class="form-control text-center mx-2 qty-input"
                                               name="qty"
                                               value="{{ $x->qty }}"
                                               min="1">

                                        <button type="button"
                                                class="btn btn-outline-secondary btn-sm btn-plus">+</button>
                                    </div>
                                </div>

                                <div>
                                    <div class="cart-label mb-1">Total</div>
                                    <div class="price-text item-total-display">
                                        Rp {{ number_format($x->product->harga * $x->qty, 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>

                            {{-- TOMBOL AKSI --}}
                            <div class="col-md-3 ms-md-auto cart-actions">
                                <button type="submit"
                                        class="btn btn-success w-100 mb-2">
                                    <i class="fa fa-shopping-cart me-1"></i>
                                    Checkout
                                </button>
                    </form>

                                {{-- HAPUS DARI KERANJANG --}}
                                <form action="{{ route('cart.delete', $x->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Hapus barang ini dari keranjang?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-outline-danger w-100">
                                        <i class="fa fa-trash-alt me-1"></i>
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>

                </div>
            </div>
        @endforeach
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.cart-item').forEach(function (card) {
            const unitPrice      = parseInt(card.getAttribute('data-price')) || 0;
            const qtyInput       = card.querySelector('.qty-input');
            const btnMinus       = card.querySelector('.btn-minus');
            const btnPlus        = card.querySelector('.btn-plus');
            const totalDisplay   = card.querySelector('.item-total-display');
            const totalInputHidden = card.querySelector('.input-total');

            function formatRupiah(angka) {
                return 'Rp ' + angka.toLocaleString('id-ID');
            }

            function updateTotal() {
                let qty = parseInt(qtyInput.value) || 1;
                if (qty < 1) qty = 1;
                qtyInput.value = qty;

                const total = unitPrice * qty;
                totalDisplay.textContent = formatRupiah(total);
                if (totalInputHidden) {
                    totalInputHidden.value = total;
                }

                // atur disable tombol minus
                btnMinus.disabled = qty <= 1;
            }

            btnPlus.addEventListener('click', function () {
                let qty = parseInt(qtyInput.value) || 1;
                qtyInput.value = qty + 1;
                updateTotal();
            });

            btnMinus.addEventListener('click', function () {
                let qty = parseInt(qtyInput.value) || 1;
                if (qty > 1) {
                    qtyInput.value = qty - 1;
                    updateTotal();
                }
            });

            qtyInput.addEventListener('input', updateTotal);

            // set awal
            updateTotal();
        });
    });
</script>
@endsection
