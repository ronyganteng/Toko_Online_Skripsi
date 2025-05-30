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
        <div class="col-md-9 d-flex flex-wrap gap-4 mb-4">
            <div class="card" style="width: 220px">
                <div class="card-header m-auto" style="border-radius: 5px">
                    <img src=" {{ asset('assets/images/contoh.png') }}" alt="salib 1" style="width: 100%;">
                </div>
                <div class="card-body">
                    <p class="m-0 text-justify"> Sayangku Cantikku Duniaku
                    </p>
                    <p class="m-0"><i class="fa-regular fa-star"></i> 5 </p>
                </div>
                <div class="card-footer d-flex flex-row justify-content-between align-items-center">
                    <p class="m-0" style="font-size:16px font-weight:600">Rp.100.000</p>
                    <button class="btn btn-outline-primary" style="font-size:24px">
                        <i class="fa-solid fa-cart-plus"></i>
                    </button>
                </div>
            </div>
            <div class="card" style="width: 220px">
                <div class="card-header m-auto" style="border-radius: 5px">
                    <img src=" {{ asset('assets/images/contoh.png') }}" alt="salib 1" style="width: 100%;">
                </div>
                <div class="card-body">
                    <p class="m-0 text-justify"> Sayangku Cantikku Duniaku
                    </p>
                    <p class="m-0"><i class="fa-regular fa-star"></i> 5 </p>
                </div>
                <div class="card-footer d-flex flex-row justify-content-between align-items-center">
                    <p class="m-0" style="font-size:16px font-weight:600">Rp.100.000</p>
                    <button class="btn btn-outline-primary" style="font-size:24px">
                        <i class="fa-solid fa-cart-plus"></i>
                    </button>
                </div>
            </div>
            <div class="card" style="width: 220px">
                <div class="card-header m-auto" style="border-radius: 5px">
                    <img src=" {{ asset('assets/images/contoh.png') }}" alt="salib 1" style="width: 100%;">
                </div>
                <div class="card-body">
                    <p class="m-0 text-justify"> Sayangku Cantikku Duniaku
                    </p>
                    <p class="m-0"><i class="fa-regular fa-star"></i> 5 </p>
                </div>
                <div class="card-footer d-flex flex-row justify-content-between align-items-center">
                    <p class="m-0" style="font-size:16px font-weight:600">Rp.100.000</p>
                    <button class="btn btn-outline-primary" style="font-size:24px">
                        <i class="fa-solid fa-cart-plus"></i>
                    </button>
                </div>
            </div>
            <div class="card" style="width: 220px">
                <div class="card-header m-auto" style="border-radius: 5px">
                    <img src=" {{ asset('assets/images/contoh.png') }}" alt="salib 1" style="width: 100%;">
                </div>
                <div class="card-body">
                    <p class="m-0 text-justify"> Sayangku Cantikku Duniaku
                    </p>
                    <p class="m-0"><i class="fa-regular fa-star"></i> 5 </p>
                </div>
                <div class="card-footer d-flex flex-row justify-content-between align-items-center">
                    <p class="m-0" style="font-size:16px font-weight:600">Rp.100.000</p>
                    <button class="btn btn-outline-primary" style="font-size:24px">
                        <i class="fa-solid fa-cart-plus"></i>
                    </button>
                </div>
            </div>
            <div class="card" style="width: 220px">
                <div class="card-header m-auto" style="border-radius: 5px">
                    <img src=" {{ asset('assets/images/contoh.png') }}" alt="salib 1" style="width: 100%;">
                </div>
                <div class="card-body">
                    <p class="m-0 text-justify"> Sayangku Cantikku Duniaku
                    </p>
                    <p class="m-0"><i class="fa-regular fa-star"></i> 5 </p>
                </div>
                <div class="card-footer d-flex flex-row justify-content-between align-items-center">
                    <p class="m-0" style="font-size:16px font-weight:600">Rp.100.000</p>
                    <button class="btn btn-outline-primary" style="font-size:24px">
                        <i class="fa-solid fa-cart-plus"></i>
                    </button>
                </div>
            </div>
            <div class="card" style="width: 220px">
                <div class="card-header m-auto" style="border-radius: 5px">
                    <img src=" {{ asset('assets/images/contoh.png') }}" alt="salib 1" style="width: 100%;">
                </div>
                <div class="card-body">
                    <p class="m-0 text-justify"> Sayangku Cantikku Duniaku
                    </p>
                    <p class="m-0"><i class="fa-regular fa-star"></i> 5 </p>
                </div>
                <div class="card-footer d-flex flex-row justify-content-between align-items-center">
                    <p class="m-0" style="font-size:16px font-weight:600">Rp.100.000</p>
                    <button class="btn btn-outline-primary" style="font-size:24px">
                        <i class="fa-solid fa-cart-plus"></i>
                    </button>
                </div>
            </div>
            <div class="card" style="width: 220px">
                <div class="card-header m-auto" style="border-radius: 5px">
                    <img src=" {{ asset('assets/images/contoh.png') }}" alt="salib 1" style="width: 100%;">
                </div>
                <div class="card-body">
                    <p class="m-0 text-justify"> Sayangku Cantikku Duniaku
                    </p>
                    <p class="m-0"><i class="fa-regular fa-star"></i> 5 </p>
                </div>
                <div class="card-footer d-flex flex-row justify-content-between align-items-center">
                    <p class="m-0" style="font-size:16px font-weight:600">Rp.100.000</p>
                    <button class="btn btn-outline-primary" style="font-size:24px">
                        <i class="fa-solid fa-cart-plus"></i>
                    </button>
                </div>
            </div>
            <div class="card" style="width: 220px">
                <div class="card-header m-auto" style="border-radius: 5px">
                    <img src=" {{ asset('assets/images/contoh.png') }}" alt="salib 1" style="width: 100%;">
                </div>
                <div class="card-body">
                    <p class="m-0 text-justify"> Sayangku Cantikku Duniaku
                    </p>
                    <p class="m-0"><i class="fa-regular fa-star"></i> 5 </p>
                </div>
                <div class="card-footer d-flex flex-row justify-content-between align-items-center">
                    <p class="m-0" style="font-size:16px font-weight:600">Rp.100.000</p>
                    <button class="btn btn-outline-primary" style="font-size:24px">
                        <i class="fa-solid fa-cart-plus"></i>
                    </button>
                </div>
            </div>

            <nav class="m-auto">
                <ul class="pagination">
                    <li class="page-item disabled">
                        <a class="page-link">Previous</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item active" aria-current="page">
                        <a class="page-link" href="#">2</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">Next</a>
                    </li>
                </ul>
            </nav>
        </div>


    </div>
@endsection
