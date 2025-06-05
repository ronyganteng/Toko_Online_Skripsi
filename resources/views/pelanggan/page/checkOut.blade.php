@extends('pelanggan.layout.index')

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <form action="{{ route('checkout.bayar') }}" method="POST">
        @csrf
        <div class="row mt-3">
            <div class="col-sm-7">
                <div class="card">
                    <div class="card-body">
                        <h3>Masukkan Alamat Penerima</h3>

                        <div class="row mb-3">
                            <label for="nama_penerima" class="col-form-label col-sm-3">Nama Penerima</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control col-sm-9" id="nama_penerima" name="namaPenerima"
                                    placeholder="Masukkan Nama Penerima" autofocus required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="alamat_penerima" class="col-form-label col-sm-3">Alamat</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control col-sm-9" id="alamat_penerima"
                                    name="alamatPenerima" placeholder="Masukkan Alamat Penerima" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="tlp" class="col-form-label col-sm-3">nomor telp Penerima</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control col-sm-9" id="tlp" name="tlp"
                                    placeholder="Masukkan No Telp" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="ekspedisi" class="col-form-label col-sm-3">Ekspedisi</label>
                            <div class="col-sm-9">
                                <select name="ekspedisi" class="form-control eksp" id="ekspedisi">
                                    <option value="">-- Pilih Ekspedisi --</option>
                                    <option value="jnt">J&T Ekspress</option>
                                    <option value="jne">J&E Ekspress</option>
                                    <option value="sicepat">Sicepat Ekspress</option>
                                    <option value="ninja">Ninja Ekspress</option>
                                </select>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-header text-center p-4">
                        <h3>Total Belanja</h3>
                    </div>
                    <div class="card-body pembayaran">
                        <h3 class="mb-3">{{$codeTransaksi}}</h3>
                    <input type="hidden" name="code" value="{{$codeTransaksi}}">
                        <div class="row mb-3">
                            <label for="totalBelanja" class="col-form-label col-sm-6">Total Belanja </label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control totalBelanja" id="totalBelanja"
                                    name="totalBelanja" value="{{ $detailBelanja }}" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="discount" class="col-form-label col-sm-6">Discount </label>
                            <div class="col-sm-6">
                                @if (Auth::user())
                                    <input type="number" class="form-control discount" id="discount" name="discount"
                                        value="0">
                                @else
                                    <input type="number" class="form-control discount" id="discount" name="discount"
                                        value="0">
                                @endif

                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="PPn" class="col-form-label col-sm-6">PPn </label>
                            <div class="col-sm-6">
                                <input type="number" class="form-control ppn " id="PPn" name="PPn"
                                    value="0">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="ongkir" class="col-form-label col-sm-6">Ongkir </label>
                            <div class="col-sm-6">
                                <input type="number" class="form-control ongkir" id="ongkir" name="ongkir"
                                    value="0">
                            </div>
                        </div>
                        <hr>
                        <div class="row mb-3">
                            <label for="dibayarkan" class="col-form-label col-sm-6">Total </label>
                            <div class="col-sm-6">
                                <input type="number" class="form-control dibayarkan" id="dibayarkan" name="dibayarkan"
                                    value="0" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="dibayarkan" class="col-form-label col-sm-6">Jumlah Barang </label>
                            <div class="col-sm-6">
                                <input type="number" class="form-control dibayarkan" id="dibayarkan"
                                    name="jumlahBarang" value="{{ $jumlahbarang }}" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="dibayarkan" class="col-form-label col-sm-6">Total Quantity </label>
                            <div class="col-sm-6">
                                <input type="number" class="form-control dibayarkan" id="dibayarkan" name="totalQty"
                                    value="{{ $qtyOrder }}" readonly>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success w-100">
                            <i class="fas fa-print"></i>
                            print struk
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
