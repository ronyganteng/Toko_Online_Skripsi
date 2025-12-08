<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keuangan;

class KeuanganController extends Controller
{
    // HALAMAN REPORT
    public function index(Request $request)
    {
        // Filter tanggal (opsional)
        $query = Keuangan::query();

        if ($request->filled('tgl_awal')) {
            $query->whereDate('tanggal', '>=', $request->tgl_awal);
        }

        if ($request->filled('tgl_akhir')) {
            $query->whereDate('tanggal', '<=', $request->tgl_akhir);
        }

        $keuangans = $query->orderBy('tanggal', 'DESC')->paginate(10);

        // Hitung total
        $totalMasuk  = Keuangan::where('tipe', 'masuk')->sum('jumlah');
        $totalKeluar = Keuangan::where('tipe', 'keluar')->sum('jumlah');
        $saldo       = $totalMasuk - $totalKeluar;

        // Data grafik: pemasukan & pengeluaran per bulan
        $chartData = Keuangan::selectRaw('
                DATE_FORMAT(tanggal, "%Y-%m") as bulan,
                SUM(CASE WHEN tipe = "masuk" THEN jumlah ELSE 0 END) as total_masuk,
                SUM(CASE WHEN tipe = "keluar" THEN jumlah ELSE 0 END) as total_keluar
            ')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $labels      = $chartData->pluck('bulan');
        $incomeData  = $chartData->pluck('total_masuk');
        $expenseData = $chartData->pluck('total_keluar');

        return view('admin.page.report', [
            'name'        => 'Report',
            'title'       => 'Admin Report',
            'keuangans'   => $keuangans,
            'totalMasuk'  => $totalMasuk,
            'totalKeluar' => $totalKeluar,
            'saldo'       => $saldo,
            'labels'      => $labels,
            'incomeData'  => $incomeData,
            'expenseData' => $expenseData,
        ]);
    }

    // SIMPAN DATA BARU
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal'    => 'required|date',
            'keterangan' => 'required|string|max:255',
            'tipe'       => 'required|in:masuk,keluar',
            'jumlah'     => 'required|integer|min:0',
        ]);

        // ⛔ hanya sekali create, tidak diulang-ulang
        Keuangan::create($validated);

        return redirect()
            ->route('report')
            ->with('success', 'Data keuangan berhasil ditambahkan.');
    }

    // UPDATE DATA
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'tanggal'    => 'required|date',
            'keterangan' => 'required|string|max:255',
            'tipe'       => 'required|in:masuk,keluar',
            'jumlah'     => 'required|integer|min:0',
        ]);

        $item = Keuangan::findOrFail($id);
        $item->update($validated);

        return redirect()
            ->route('report')
            ->with('success', 'Data keuangan berhasil diupdate.');
    }

    // HAPUS DATA
    public function destroy($id)
    {
        $item = Keuangan::findOrFail($id);
        $item->delete();

        return redirect()
            ->route('report')
            ->with('success', 'Data keuangan berhasil dihapus.');
    }
}
