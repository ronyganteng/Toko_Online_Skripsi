@extends('admin.layout.index')

@section('content')
    @if (session('success'))
        <div class="alert alert-success mb-3">
            {{ session('success') }}
        </div>
    @endif

    {{-- Ringkasan saldo --}}
    <div class="card mb-3">
        <div class="card-body d-flex justify-content-between flex-wrap gap-3">
            <div><strong>Total Pemasukan:</strong> Rp {{ number_format($totalMasuk ?? 0, 0, ',', '.') }}</div>
            <div><strong>Total Pengeluaran:</strong> Rp {{ number_format($totalKeluar ?? 0, 0, ',', '.') }}</div>
            <div><strong>Saldo:</strong> Rp {{ number_format($saldo ?? 0, 0, ',', '.') }}</div>
        </div>
    </div>

    {{-- Filter tanggal --}}
    <div class="card mb-3">
        <div class="card-body">
            <form action="{{ route('report') }}" method="GET" class="row g-2">
                <div class="col-md-4">
                    <label class="form-label">Tanggal Awal</label>
                    <input type="date" name="tgl_awal" class="form-control" value="{{ request('tgl_awal') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Tanggal Akhir</label>
                    <input type="date" name="tgl_akhir" class="form-control" value="{{ request('tgl_akhir') }}">
                </div>
                <div class="col-md-4 d-flex align-items-end gap-2">
                    <button class="btn btn-primary">Filter</button>
                    <a href="{{ route('report') }}" class="btn btn-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    {{-- Form Tambah Keuangan --}}
    <div class="card mb-3">
        <div class="card-header bg-transparent"><strong>Tambah Data Keuangan</strong></div>
        <div class="card-body">
            <form action="{{ route('report.store') }}" method="POST" class="row g-3">
                @csrf
                <div class="col-md-3">
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Keterangan</label>
                    <input type="text" name="keterangan" class="form-control" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Tipe</label>
                    <select name="tipe" class="form-control" required>
                        <option value="">Pilih</option>
                        <option value="masuk">Pemasukan</option>
                        <option value="keluar">Pengeluaran</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Jumlah (Rp)</label>
                    <input type="number" name="jumlah" class="form-control" required>
                </div>
                <div class="col-12 text-end">
                    <button class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabel Keuangan --}}
    <div class="card mb-3">
        <div class="card-header bg-transparent"><strong>Data Keuangan</strong></div>
        <div class="card-body">
            <table class="table table-striped table-responsive">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
                        <th>Tipe</th>
                        <th>Jumlah</th>
                        <th>#</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($keuangans as $i => $k)
                        <tr class="align-middle">
                            <td>{{ $keuangans->firstItem() + $i }}</td>
                            <td>{{ $k->tanggal->format('d-m-Y') }}</td>
                            <td>{{ $k->keterangan }}</td>
                            <td><span class="badge text-bg-{{ $k->tipe=='masuk'?'success':'danger' }}">{{ ucfirst($k->tipe) }}</span></td>
                            <td>Rp {{ number_format($k->jumlah,0,',','.') }}</td>
                            <td>
                                <button class="btn btn-sm btn-warning" data-bs-toggle="collapse" data-bs-target="#edit-{{ $k->id }}">Edit</button>

                                <form action="{{ route('report.destroy',$k->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus data ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>

                        {{-- Inline Edit --}}
                        <tr class="collapse" id="edit-{{ $k->id }}">
                            <td colspan="6">
                                <form action="{{ route('report.update',$k->id) }}" method="POST" class="row g-2">
                                    @csrf @method('PUT')
                                    <div class="col-md-2"><input type="date" name="tanggal" class="form-control" value="{{ $k->tanggal->format('Y-m-d') }}" required></div>
                                    <div class="col-md-3"><input type="text" name="keterangan" class="form-control" value="{{ $k->keterangan }}" required></div>
                                    <div class="col-md-2">
                                        <select name="tipe" class="form-control" required>
                                            <option value="masuk" {{ $k->tipe=='masuk'?'selected':'' }}>Pemasukan</option>
                                            <option value="keluar" {{ $k->tipe=='keluar'?'selected':'' }}>Pengeluaran</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3"><input type="number" name="jumlah" class="form-control" value="{{ $k->jumlah }}" required></div>
                                    <div class="col-md-2"><button class="btn btn-primary w-100">Update</button></div>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center">Belum ada data.</td></tr>
                    @endforelse
                </tbody>
            </table>

            <div class="d-flex justify-content-between mt-3">
                <small>Menampilkan {{ $keuangans->firstItem() }} - {{ $keuangans->lastItem() }} dari {{ $keuangans->total() }} data</small>
                {{ $keuangans->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

    {{-- Grafik (crypto style naik turun) --}}
    <div class="card">
        <div class="card-header bg-transparent"><strong>Grafik Keuangan per Bulan</strong></div>
        <div class="card-body"><canvas id="financeChart" height="100"></canvas></div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const labels      = {!! json_encode($labels) !!};
    const incomeData  = {!! json_encode($incomeData) !!};
    const expenseData = {!! json_encode($expenseData) !!};

    new Chart(document.getElementById('financeChart'), {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: "Pemasukan",
                    data: incomeData,
                    borderColor: "green",
                    backgroundColor: "rgba(0,255,0,0.3)",
                    tension: 0.3,
                    borderWidth: 2
                },
                {
                    label: "Pengeluaran",
                    data: expenseData,
                    borderColor: "red",
                    backgroundColor: "rgba(255,0,0,0.3)",
                    tension: 0.3,
                    borderWidth: 2
                }
            ]
        },
        options: {
            responsive:true,
            scales:{y:{beginAtZero:true}}
        }
    });
</script>
@endpush
