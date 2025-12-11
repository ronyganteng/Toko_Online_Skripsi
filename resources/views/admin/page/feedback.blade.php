@extends('admin.layout.index')

@section('content')
<div class="container-fluid py-3">

    <h3 class="mb-3">Kritik & Saran Pelanggan</h3>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"
                    aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body table-responsive">

            @if($feedback->isEmpty())
                <p class="mb-0">Belum ada kritik atau saran dari pelanggan.</p>
            @else
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Email</th>
                            <th>Pesan</th>
                            <th>Waktu</th>
                            <th style="width: 80px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($feedback as $item)
                            <tr>
                                <td>{{ $loop->iteration + ($feedback->currentPage() - 1) * $feedback->perPage() }}</td>
                                <td>{{ $item->email ?? '-' }}</td>
                                <td style="max-width: 400px; white-space: normal;">
                                    {{ $item->message }}
                                </td>
                                <td>
                                    {{ $item->created_at->format('d M Y H:i') }}
                                </td>
                                <td>
                                    <form action="{{ route('admin.feedback.destroy', $item->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Hapus kritik/saran ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-sm btn-outline-danger">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="d-flex justify-content-end">
                    {{ $feedback->links('pagination::bootstrap-5') }}
                </div>
            @endif

        </div>
    </div>
</div>
@endsection
