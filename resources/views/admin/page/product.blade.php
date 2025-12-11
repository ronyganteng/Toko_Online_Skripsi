@extends('admin.layout.index')

@section('content')

    @if (session('berhasil_update') || session('Berhasil'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('berhasil_update') ?? session('Berhasil') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- FILTER TANGGAL --}}
    <div class="card mb-1">
        <div class="card-body d-flex flex-row justify-content-between">
            <div class="filter d-flex flex-lg-row gap-3">
                <form action="{{ route('product') }}" method="GET" class="d-flex flex-lg-row gap-3">
                    <input type="date" class="form-control" placeholder="tgl_awal"
                           name="tgl_awal" value="{{ request('tgl_awal') }}">
                    <input type="date" class="form-control" placeholder="tgl_akhir"
                           name="tgl_akhir" value="{{ request('tgl_akhir') }}">
                    <button class="btn btn-primary" type="submit">Filter</button>
                </form>
            </div>
        </div>
    </div>

    <div class="card rounded-full">
        <div class="card-header bg-transparent d-flex justify-content-between align-items-center">

            {{-- TOMBOL TAMBAH --}}
            <button class="btn btn-info" id="addData">
                <i class="fa fa-plus"></i>
                <span>Tambah Product</span>
            </button>

            {{-- SEARCH --}}
            <form action="{{ route('product') }}" method="GET"
                  class="d-flex align-items-center" style="max-width: 350px; width: 100%;">
                <input type="hidden" name="tgl_awal" value="{{ request('tgl_awal') }}">
                <input type="hidden" name="tgl_akhir" value="{{ request('tgl_akhir') }}">

                <input type="text"
                       name="q"
                       class="form-control"
                       placeholder="Search...."
                       value="{{ request('q') }}">

                <button class="btn btn-primary ms-2" type="submit">Cari</button>
            </form>

        </div>

        <div class="card-body">
            <table class="table table-responsive table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Date In</th>
                        <th>SKU</th>
                        <th>Product Name</th>
                        <th>Type</th>       {{-- <=== baru --}}
                        <th>Category</th>   {{-- <=== baru, khusus kategory --}}
                        <th>Price</th>
                        <th>Stock</th>
                        <th>#</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($data->isEmpty())
                        <tr class="text-center">
                            <td colspan="10">Belum ada barang</td>
                        </tr>
                    @else
                        @foreach ($data as $y => $x)
                            <tr class="align-middle">
                                <td>{{ $data->firstItem() + $y }}</td>

                                <td>
    @if ($x->foto)
        <img src="{{ asset('storage/product/' . $x->foto) }}" style="width: 100px">
    @else
        <span class="text-muted">No image</span>
    @endif
</td>

                                <td>{{ $x->created_at }}</td>
                                <td>{{ $x->sku }}</td>

                                <td>{{ $x->nama_product }}</td>

                                {{-- TYPE dipisah --}}
                                <td>{{ ucfirst($x->type) }}</td>

                                {{-- CATEGORY khusus dari field kategory --}}
                                <td>{{ $x->kategory }}</td>

                                <td>Rp. {{ number_format($x->harga, 0, ',', '.') }}</td>

                                <td>{{ $x->quantity }}</td>

                                <td>
                                    {{-- EDIT --}}
                                    <button class="btn btn-success btn-edit" data-id="{{ $x->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    {{-- DELETE --}}
                                    <form action="{{ route('product.destroy', $x->id) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus produk ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>

            <div class="d-flex justify-content-between align-items-center mt-4">
                <div>
                    <strong>
                        Menampilkan {{ $data->firstItem() }} - {{ $data->lastItem() }}
                        dari total {{ $data->total() }} data
                    </strong>
                </div>
                <div>
                    {{ $data->links('pagination::bootstrap-5') }}
                </div>
            </div>

            {{-- TEMPAT MODAL AJAX --}}
            <div class="tampilData" style="display: none;"></div>
            <div class="tampilEditData" style="display: none;"></div>

            <script>
                // BUKA MODAL TAMBAH
                $('#addData').click(function() {
                    $.ajax({
                        url: '{{ route('addModal') }}',
                        method: 'GET',
                        success: function(response) {
                            $('.tampilData').html(response).show();
                            $('#addModal').modal('show');
                        },
                        error: function(xhr) {
                            console.error(xhr.responseText);
                            alert('Gagal membuka form tambah product');
                        }
                    });
                });

                // BUKA MODAL EDIT
                $(document).on('click', '.btn-edit', function(e) {
                    e.preventDefault();

                    var id = $(this).data('id');

                    $.ajax({
                        url: '{{ url("/admin/editModal") }}/' + id,
                        method: 'GET',
                        success: function(response) {
                            $('.tampilEditData').html(response).show();
                            $('#editModal').modal('show');
                        },
                        error: function(xhr) {
                            console.error(xhr.responseText);
                            alert('Gagal mengambil data product untuk edit');
                        }
                    });
                });
            </script>

        </div>
    </div>

@endsection
