<div class="modal fade" id="addModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content modal-md">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">{{ $title }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            {{-- onsubmit: cegah double submit --}}
            <form action="{{ route('addData') }}" enctype="multipart/form-data" method="POST"
                  onsubmit="this.querySelector('button[type=submit]').disabled = true;">
                @csrf
                <div class="modal-body">

                    <div class="mb-3 row">
                        <label class="col-sm-5 col-form-label">SKU</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control-plaintext" value="{{ $sku }}" name="sku" readonly>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-5 col-form-label">Nama Product</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" name="nama">
                        </div>
                    </div>

                    {{-- TYPE --}}
                    <div class="mb-3 row">
                        <label class="col-sm-5 col-form-label">Type Product</label>
                        <div class="col-sm-7">
                            <select class="form-control" name="type" id="typeAdd"
                                    onchange="changeKategoriAdd(this.value)">
                                <option value="">Pilih Type</option>
                                <option value="salib">Salib</option>
                                <option value="patung">Patung</option>
                                <option value="aksesoris">Aksesoris</option>
                            </select>
                        </div>
                    </div>

                    {{-- KATEGORI --}}
                    <div class="mb-3 row">
                        <label class="col-sm-5 col-form-label">Kategori</label>
                        <div class="col-sm-7">
                            <select class="form-control" id="kategoriAdd" name="kategori">
                                <option value="">Pilih Kategori</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-5 col-form-label">Harga Product</label>
                        <div class="col-sm-7">
                            <input type="number"  class="form-control" name="harga">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-5 col-form-label">Quantity</label>
                        <div class="col-sm-7">
                            <input type="number" class="form-control" name="quantity">
                        </div>
                    </div>
                    {{-- DESKRIPSI PRODUK --}}
<div class="mb-3 row">
    <label class="col-sm-5 col-form-label">Deskripsi Produk</label>
    <div class="col-sm-7">
        <textarea class="form-control" name="deskripsi" rows="4"
                  placeholder="Tulis deskripsi singkat produk, bahan, ukuran, warna, dll..."></textarea>
    </div>
</div>


                    {{-- FOTO --}}
                    <div class="mb-3 row">
                        <label class="col-sm-5 col-form-label">Foto Product</label>
                        <div class="col-sm-7">
                            <img src="#" class="mb-2 preview" style="width:100px; display:none;">
                            <input type="file" accept=".png,.jpg,.jpeg" class="form-control"
                                   id="inputFotoAdd" name="foto" onchange="previewAdd()">
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
/* PREVIEW FOTO */
function previewAdd() {
    const foto = document.querySelector('#inputFotoAdd');
    const prev = document.querySelector('.preview');
    prev.style.display = 'block';

    const reader = new FileReader();
    reader.onload = e => prev.src = e.target.result;
    reader.readAsDataURL(foto.files[0]);
}

/* DATA KATEGORI */
const CATEGORY_DATA = {
    salib: [
        {value:'salibkayu', label:'Salib Kayu'},
        {value:'salibbesi', label:'Salib Besi'},
        {value:'salibcustom', label:'Salib Custom'},
        {value:'salibgantungan', label:'Salib Gantungan'},
        {value:'salibmeja', label:'Salib Meja'},
        {value:'salibdinding', label:'Salib Dinding'},
    ],
    patung: [
        {value:'patungmaria', label:'Patung Maria'},
        {value:'patungyesus', label:'Patung Yesus'},
        {value:'patungsanto', label:'Patung Santo/Santa'},
        {value:'patunglainnya', label:'Patung Lainnya'},
    ],
    aksesoris: [
        {value:'rosario', label:'Rosario'},
        {value:'gelang', label:'Gelang'},
        {value:'kalung', label:'Kalung'},
        {value:'baju', label:'Baju'},
        {value:'kemeja', label:'Kemeja'},
        {value:'aksesorislain', label:'Aksesoris Lainnya'},
    ]
};

/* GENERATE DROPDOWN KATEGORI */
function changeKategoriAdd(type){
    const select = document.getElementById('kategoriAdd');
    select.innerHTML = `<option value="">Pilih Kategori</option>`;
    if(!CATEGORY_DATA[type]) return;

    CATEGORY_DATA[type].forEach(opt=>{
        const o=document.createElement('option');
        o.value=opt.value;
        o.textContent=opt.label;
        select.appendChild(o);
    });
}
</script>
