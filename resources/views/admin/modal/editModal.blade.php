{{-- resources/views/admin/modal/editModal.blade.php --}}
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

            {{-- penting: method POST + @method('PUT') + enctype --}}
            <form action="{{ route('updateData', $data->id) }}"
                  method="POST" enctype="multipart/form-data"
                  onsubmit="this.querySelector('button[type=submit]').disabled = true;">
                @csrf
                @method('PUT')

                <div class="modal-body">
                    <div class="mb-3 row">
                        <label class="col-sm-5 col-form-label">SKU</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control-plaintext" name="sku"
                                   value="{{ $data->sku }}" readonly>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-5 col-form-label">Nama Product</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="nameProduct"
                                   name="nama" value="{{ $data->nama_product }}">
                        </div>
                    </div>

                    {{-- TYPE PRODUCT --}}
                    <div class="mb-3 row">
                        <label class="col-sm-5 col-form-label">Type Product</label>
                        <div class="col-sm-7">
                            <select class="form-control" id="typeEdit" name="type"
                                    onchange="loadKategoriEdit(this.value)">
                                <option value="">Pilih Type</option>
                                <option value="salib"     {{ $data->type === 'salib' ? 'selected' : '' }}>Salib</option>
                                <option value="patung"    {{ $data->type === 'patung' ? 'selected' : '' }}>Patung</option>
                                <option value="aksesoris" {{ $data->type === 'aksesoris' ? 'selected' : '' }}>Aksesoris</option>
                            </select>
                        </div>
                    </div>

                    {{-- KATEGORI (DINAMIS) --}}
                    <div class="mb-3 row">
                        <label class="col-sm-5 col-form-label">Kategori</label>
                        <div class="col-sm-7">
                            <select class="form-control" id="kategoriEdit" name="kategori"
                                    data-value="{{ $data->kategory }}">
                                {{-- opsi diisi via JS --}}
                            </select>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-5 col-form-label">Harga Product</label>
                        <div class="col-sm-7">
                            <input type="number" class="form-control" id="harga"
                                   name="harga" value="{{ $data->harga }}">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-5 col-form-label">Quantity</label>
                        <div class="col-sm-7">
                            <input type="number" class="form-control" id="quantity"
                                   name="quantity" value="{{ $data->quantity }}">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-5 col-form-label">Foto Product</label>
                        <div class="col-sm-7">
                            <img src="{{ asset('storage/product/' . $data->foto) }}" class="mb-2 preview"
                                 style="width:100px;">
                            <input type="file" class="form-control" accept=".png, .jpg, .jpeg"
                                   id="fotoEdit" name="foto" onchange="previewEdit()">
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
const CATEGORY_DATA = {
    salib: [
        {value:'salibkayu',      label:'Salib Kayu'},
        {value:'salibbesi',      label:'Salib Besi'},
        {value:'salibcustom',    label:'Salib Custom'},
        {value:'salibgantungan', label:'Salib Gantungan'},
        {value:'salibmeja',      label:'Salib Meja'},
        {value:'salibdinding',   label:'Salib Dinding'},
    ],
    patung: [
        {value:'patungmaria',   label:'Patung Maria'},
        {value:'patungyesus',   label:'Patung Yesus'},
        {value:'patungsanto',   label:'Patung Santo/Santa'},
        {value:'patunglainnya', label:'Patung Lainnya'},
    ],
    aksesoris: [
        {value:'rosario',       label:'Rosario'},
        {value:'gelang',        label:'Gelang'},
        {value:'kalung',        label:'Kalung'},
        {value:'baju',          label:'Baju'},
        {value:'kemeja',        label:'Kemeja'},
        {value:'aksesorislain', label:'Aksesoris Lainnya'},
    ]
};

function previewEdit() {
    const fileInput = document.getElementById('fotoEdit');
    const preview   = document.querySelector('.preview');
    if (!fileInput.files[0]) return;

    const reader = new FileReader();
    reader.onload = e => preview.src = e.target.result;
    reader.readAsDataURL(fileInput.files[0]);
}

function loadKategoriEdit(type) {
    const select = document.getElementById('kategoriEdit');
    if (!select) return;

    const currentVal = select.getAttribute('data-value');
    select.innerHTML = '<option value="">Pilih Kategori</option>';

    if (!CATEGORY_DATA[type]) return;

    CATEGORY_DATA[type].forEach(item => {
        const opt = document.createElement('option');
        opt.value = item.value;
        opt.textContent = item.label;
        if (item.value === currentVal) opt.selected = true;
        select.appendChild(opt);
    });
}

// langsung jalan ketika modal dimuat via AJAX
(function initEditModal() {
    const typeEl = document.getElementById('typeEdit');
    if (typeEl) {
        loadKategoriEdit(typeEl.value);
    }
})();
</script>
