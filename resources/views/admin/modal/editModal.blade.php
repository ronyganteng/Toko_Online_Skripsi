@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="modal fade" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content modal-md">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">{{ $title }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            {{-- onsubmit: disable tombol Save supaya tidak ke-klik dua kali --}}
            <form action="{{ route('updateData', $data->id) }}" method="POST" enctype="multipart/form-data"
                  onsubmit="this.querySelector('button[type=submit]').disabled = true;">
                @method('PUT')
                @csrf
                <div class="modal-body">
                    <div class="mb-3 row">
                        <label for="SKU" class="col-sm-5 col-form-label">SKU</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control-plaintext" id="SKU" name="sku"
                                value="{{ $data->sku }}" readonly>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="nameProduct" class="col-sm-5 col-form-label">Nama Product</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="nameProduct" name="nama"
                                value="{{ $data->nama_product }}">
                        </div>
                    </div>

                    {{-- TYPE PRODUCT --}}
                    <div class="mb-3 row">
                        <label for="type" class="col-sm-5 col-form-label">Type Product</label>
                        <div class="col-sm-7">
                            <select class="form-control" id="type" name="type">
                                <option value="">Pilih Type</option>
                                <option value="salib" {{ $data->type === 'salib' ? 'selected' : '' }}>Salib</option>
                                <option value="alkitab" {{ $data->type === 'alkitab' ? 'selected' : '' }}>Alkitab</option>
                                <option value="aksesoris" {{ $data->type === 'aksesoris' ? 'selected' : '' }}>Aksesoris</option>
                            </select>
                        </div>
                    </div>

                    {{-- KATEGORI SALIB --}}
                    <div class="mb-3 row">
                        <label for="kategori" class="col-sm-5 col-form-label">Kategori</label>
                        <div class="col-sm-7">
                            <select class="form-control" id="kategori" name="kategori">
                                <option value="">Pilih Kategori</option>
                                <option value="salibkayu"      {{ $data->kategory === 'salibkayu' ? 'selected' : '' }}>Salib Kayu</option>
                                <option value="salibbesi"      {{ $data->kategory === 'salibbesi' ? 'selected' : '' }}>Salib Besi</option>
                                <option value="salibcustom"    {{ $data->kategory === 'salibcustom' ? 'selected' : '' }}>Salib Custom</option>
                                <option value="salibgantungan" {{ $data->kategory === 'salibgantungan' ? 'selected' : '' }}>Salib Gantungan</option>
                                <option value="salibmeja"      {{ $data->kategory === 'salibmeja' ? 'selected' : '' }}>Salib Meja</option>
                                <option value="salibdinding"   {{ $data->kategory === 'salibdinding' ? 'selected' : '' }}>Salib Dinding</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="harga" class="col-sm-5 col-form-label">Harga Product</label>
                        <div class="col-sm-7">
                            <input type="number" class="form-control" id="harga" name="harga"
                                value="{{ $data->harga }}">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="quantity" class="col-sm-5 col-form-label">Quantity</label>
                        <div class="col-sm-7">
                            <input type="number" class="form-control" id="quantity" name="quantity"
                                value="{{ $data->quantity }}">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="foto" class="col-sm-5 col-form-label">Foto Product</label>
                        <div class="col-sm-7">
                            <input type="hidden" name="foto" value="{{ $data->foto }}">
                            <img src="{{ asset('storage/product/' . $data->foto) }}" class="mb-2 preview"
                                style="width:100px;">
                            <input type="file" class="form-control" accept=".png, .jpg, .jpeg" id="inputFoto"
                                name="foto" onchange="previewImgEdit()">
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function previewImgEdit() {
        const fotoIn = document.querySelector('#inputFoto');
        const preview = document.querySelector('.preview');

        if (!fotoIn.files[0]) return;

        preview.style.display = 'block';

        const ofReader = new FileReader();
        ofReader.readAsDataURL(fotoIn.files[0]);

        ofReader.onload = function(oFREvent) {
            preview.src  = oFREvent.target.result;
        }
    }
</script>
    