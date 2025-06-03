@extends('pelanggan.layout.index')

@section('content')
    <div class="row mt-4">
        <div class="col-md-3">
            <div class="card" style="width: 18rem">
                <div class="card-header">
                    Category
                </div>
                <div class="card-body">
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseOne" aria-expanded="false"
                                    aria-controls="flush-collapseOne">
                                    Salib
                                </button>
                            </h2>
                            <div id="flush-collapseOne" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body ">
                                    <div class="d-flex flex-column gap-4">
                                        <a href="#" class="page-link">
                                            <i class="fas fa-plus"></i> Salib Kayu
                                        </a>
                                        <a href="#" class="page-link">
                                            <i class="fas fa-plus"></i> Salib Besi
                                        </a>
                                        <a href="#" class="page-link">
                                            <i class="fas fa-plus"></i> Salib Custom
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseTwo" aria-expanded="false"
                                    aria-controls="flush-collapseTwo">
                                    Alkitab
                                </button>
                            </h2>
                            <div id="flush-collapseTwo" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body p-0">
                                    <div class="accordion-body">
                                        <div class="d-flex flex-column gap-4">
                                            <a href="#" class="page-link">
                                                <i class="fas fa-plus"></i> Alkitab Kristen
                                            </a>
                                            <a href="#" class="page-link">
                                                <i class="fas fa-plus"></i> ALkitab Katolik
                                            </a>
                                            <a href="#" class="page-link">
                                                <i class="fas fa-plus"></i> Alkitab Custom
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseThree" aria-expanded="false"
                                    aria-controls="flush-collapseThree">
                                    Aksesoris
                                </button>
                            </h2>
                            <div id="flush-collapseThree" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body p-0">
                                    <div class="accordion-body">
                                        <div class="d-flex flex-column gap-4">
                                            <a href="#" class="page-link">
                                                <i class="fas fa-plus"></i> Gelang
                                            </a>
                                            <a href="#" class="page-link">
                                                <i class="fas fa-plus"></i> Kalung
                                            </a>
                                            <a href="#" class="page-link">
                                                <i class="fas fa-plus"></i> Rosario
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-md-9 d-flex flex-wrap gap-4 mb-5">
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
                            <button class="btn btn-outline-primary" style="font-size:24px">
                                <i class="fa-solid fa-cart-plus"></i>
                            </button>
                        </div>
                    </div>
                @endforeach
            
        </div>

        <div class="d-flex justify-content-between align-items-center mt-4">
            <div>
                <strong>Menampilkan {{ $data->firstItem() }} - {{ $data->lastItem() }} dari total
                    {{ $data->total() }} data</strong>
            </div>
            <div>
                {{ $data->links('pagination::bootstrap-5') }}
            </div>
        </div>
        @endif


    </div>
@endsection
