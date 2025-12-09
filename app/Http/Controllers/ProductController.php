<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\product;
use RealRashid\SweetAlert\Facades\Alert;

class ProductController extends Controller
{
    /**
     * Tampilkan list product admin
     */
    public function index(Request $request)
    {
        $query = product::where('is_active', 1)->orderBy('created_at', 'desc');

        // filter tanggal
        if ($request->filled('tgl_awal')) {
            $query->whereDate('created_at', '>=', $request->tgl_awal);
        }
        if ($request->filled('tgl_akhir')) {
            $query->whereDate('created_at', '<=', $request->tgl_akhir);
        }

        // search
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('sku', 'like', "%{$search}%")
                  ->orWhere('nama_product', 'like', "%{$search}%")
                  ->orWhere('kategory', 'like', "%{$search}%")
                  ->orWhere('type', 'like', "%{$search}%");
            });
        }

        $data = $query->paginate(10)->withQueryString();

        return view('admin.page.product', [
            'name'  => 'Product',
            'title' => 'Admin Product',
            'data'  => $data,
        ]);
    }

    

    public function show($id)
{
    $data = product::findOrFail($id);   // gunakan model product kamu

    return view('admin.modal.editModal', [
        'title' => 'Edit data product',
        'data'  => $data,
    ])->render();
}

    /**
     * View modal tambah product
     */
    public function addModal()
    {
        return view('admin.modal.addModal', [
            'title' => 'Tambah Data Produk',
            'sku'   => 'BRG' . rand(1000, 99999),
        ]);
    }

    /**
     * Simpan product baru
     */
    public function store(Request $request)
{
    $request->validate([
        'sku'      => 'required',
        'nama'     => 'required|string',
        'type'     => 'required|string',
        'kategori' => 'required|string',
        'harga'    => 'required|numeric',
        'quantity' => 'required|numeric',
    ]);

    $data = new product;
    $data->sku          = $request->sku;
    $data->nama_product = $request->nama;
    $data->type         = $request->type;
    $data->kategory     = $request->kategori;
    $data->harga        = $request->harga;
    $data->quantity     = $request->quantity;
    $data->discount     = 10/100;
    $data->is_active    = 1;

    if ($request->hasFile('foto')) {
        $photo    = $request->file('foto');
        $filename = date('Ymd') . '_' . $photo->getClientOriginalName();
        $photo->move(public_path('storage/product'), $filename);
        $data->foto = $filename;
    }

    $data->save();

    // NOTIFIKASI TAMBAH
    return redirect()
        ->route('product')
        ->with('Berhasil', 'Barang berhasil ditambahkan.');
}

// app/Http/Controllers/ProductController.php

public function update(Request $request, $id)
{
    $request->validate([
        'sku'      => 'required',
        'nama'     => 'required|string',
        'type'     => 'required|string',
        'kategori' => 'required|string',
        'harga'    => 'required|numeric',
        'quantity' => 'required|numeric',
    ]);

    $product = product::findOrFail($id);

    $product->sku          = $request->sku;
    $product->nama_product = $request->nama;
    $product->type         = $request->type;        // salib / patung / aksesoris
    $product->kategory     = $request->kategori;    // salibkayu / rosario / dll
    $product->harga        = $request->harga;
    $product->quantity     = $request->quantity;
    $product->discount     = 10 / 100;
    $product->is_active    = 1;

    // kalau user upload foto baru, ganti
    if ($request->hasFile('foto')) {
        $photo    = $request->file('foto');
        $filename = date('Ymd') . '_' . $photo->getClientOriginalName();
        $photo->move(public_path('storage/product'), $filename);
        $product->foto = $filename;
    }

    $product->save();

    return redirect()
        ->route('product')
        ->with('berhasil_update', 'Barang berhasil disimpan.');
}


public function destroy($id)
{
    $product = product::findOrFail($id);

    // kalau sudah dipakai di detail_transaksis → nonaktifkan aja
    if (\DB::table('detail_transaksis')->where('id_barang', $id)->exists()) {
        $product->is_active = 0;
        $product->save();

        $message = 'Produk terkait transaksi. Status diubah menjadi tidak aktif.';
    } else {
        $product->delete();
        $message = 'Barang berhasil dihapus.';
    }

    // NOTIFIKASI HAPUS
    return redirect()
        ->route('product')
        ->with('Berhasil', $message);
}
}
