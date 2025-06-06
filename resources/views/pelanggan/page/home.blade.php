@extends('pelanggan.layout.index')

@section('content')
@if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
@if ($best->count() < 1)
    <div class="container"></div>
@else
    <h4 class="mt-5">Best Seller</h4>
    <div class="content mt-3 d-flex flex-lg-wrap gap-5 mb-5">
        
        
            @foreach ($best as $b)
                <div class="card" style="width: 220px">
                    <div class="card-header m-auto" style="height :100%; width:100%;">
                        <img src=" {{ asset('storage/product/' . $b->foto) }}" alt="salib 1"
                            style="width: 100%; height:200px; object-fit:cover;">
                    </div>
                    <div class="card-body">
                        <p class="m-0 text-justify"> {{ $b->nama_product }}
                        </p>
                        <p class="m-0"><i class="fa-regular fa-star"></i> 5 </p>
                    </div>
                    <div class="card-footer d-flex flex-row justify-content-between align-items-center">
                        <p class="m-0" style="font-size:16px font-weight:600"><span>IDR</span> {{ number_format($b->harga) }}</p>
                        <button class="btn btn-outline-primary" style="font-size:24px">
                            <i class="fa-solid fa-cart-plus"></i>
                        </button>
                    </div>
                </div>
            @endforeach
    </div>
    @endif

    <h4 class="mt-5">New Product</h4>
    <div class="content mt-3 d-flex flex-lg-wrap gap-5 mb-5">
        @if ($data->isEmpty())
            <td colspan="9">Belum ada product...</td>
        @else
            @foreach ($data as $p)
                <div class="card" style="width: 220px">
                    <div class="card-header m-auto" style="height :100%; width:100%;">
                        <img src=" {{ asset('storage/product/' . $p->foto) }}" alt="salib 1"
                            style="width: 100%; height:200px; object-fit:cover;">
                    </div>
                    <div class="card-body">
                        <p class="m-0 text-justify"> {{ $p->nama_product }}
                        </p>
                        <p class="m-0"><i class="fa-regular fa-star"></i> 5 </p>
                        <p class="m-0" style="font-size:16px font-weight:600">{{ number_format($p->Quantity) }}</p>
                    </div>
                    <div class="card-footer d-flex flex-row justify-content-between align-items-center">
                        <p class="m-0" style="font-size:16px font-weight:600">{{ number_format($p->harga) }}</p>
                        <form action="{{route('addToCart')}}" method="POST">
                            @csrf
                            <input type="hidden" name="idProduct" value="{{$p->id}}">
                            <button type="submit" class="btn btn-outline-primary" style="font-size:24px">
                            <i class="fa-solid fa-cart-plus"></i>
                            </button>
                        </form>
                        
                    </div>
                </div>
            @endforeach
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div>
                    <strong>Menampilkan {{ $data->firstItem() }} - {{ $data->lastItem() }} dari total
                        {{ $data->total() }} data</strong>
                </div>
                <div>
                    {{ $data->links('pagination::bootstrap-5') }}
                </div>
            </div>

    </div>
    @endif

@endsection
