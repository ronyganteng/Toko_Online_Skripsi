@extends('pelanggan.layout.index')

@section('content')
    <div class="row mt-4 align-items-center">
        <div class="col-md-6">
            <div class="content-text">
                Lorem ipsum dolor, sit amet consectetur adipisicing elit. Enim molestias aut eligendi ea cumque iusto
                repellat consequatur velit omnis, fugit inventore esse qui quasi, laborum iste repellendus perferendis
                possimus sed assumenda dolore, earum dolorem adipisci cum alias? Perferendis nihil minima aperiam rem
                expedita illo sed facere suscipit recusandae sequi illum reprehenderit incidunt animi ipsam vel sunt
                laboriosam, magni, deleniti quasi at error earum odit? Iste nisi soluta nostrum mollitia cupiditate sed
                expedita odio blanditiis consectetur ducimus! Hic eius expedita corrupti magni eveniet maxime nobis atque
                tempora aliquam aspernatur, consectetur possimus a voluptatibus in nemo corporis est sed blanditiis natus.
                Repudiandae deserunt quo eius doloremque! Eius aperiam nemo quibusdam tempore odit! Molestias voluptatum
                delectus cupiditate nam aliquid laboriosam in. Magni, eos!
            </div>
        </div>
        <div class="col-md-6">
            <img src="{{ asset('assets/images/contoh2.png') }}" style="width: 100%" alt="">
        </div>
    </div>
    <div class="d-flex justify-content-lg-between mt-5">
        <div class="d-flex flex align-items-content gap-4">
            <i class="fa fa-users fa-2x"></i>
            <p class="m-0 fs-5"> +300 Pelanggan</p>
        </div>
        <div class="d-flex flex align-items-content gap-4">
            <i class="fa fa-home fa-2x"></i>
            <p class="m-0 fs-5"> +300 Seller</p>
        </div>
        <div class="d-flex flex align-items-content gap-4">
            <i class="fa fa-cross fa-2x"></i>
            <p class="m-0 fs-5"> +300 Salib</p>
        </div>
    </div>

    <h4 class="text-center mt-md-5 mb-md-5">Contact Us</h4>
    <hr>
    <div class="row mb-md-5">
        <div class="col-md-5">
            <div class="bg-secondary" style="width: 100%; height: 50vh; border-radius:10px;"></div>
        </div>
        <div class="col-md-7">
            <div class="card">
                <div class="card-header text-center">
                    <h4>Kritik dan Saran</h4>
                    <div>
                        <div class="card-body">
                            <p class="p-0 mb-5 text-lg-center">Masukan Kritik dan Saran Anda kepada Web kami ini agar kami
                                dapat memberikan apa yang menjadi kebutuhan anda dan kami dapat berkembang
                                lebih baik lagi.
                            </p>
                            <div class="mb-3 row">
                                <label for="email" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control" id="email" value=""
                                        placeholder="Masukan E-mail Anda">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="pesan" class="col-sm-2 col-form-label">Pesan</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="pesan"
                                        placeholder="Masukan Pesan Anda">
                                </div>
                            </div>
                            <button class="btn btn-primary mt-4 w-100">
                                Kirim Pesan Anda
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
