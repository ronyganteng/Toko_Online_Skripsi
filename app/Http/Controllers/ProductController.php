<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * LIST PRODUCT ADMIN
     */
    public function index(Request $request)
    {
        $query = Product::where('is_active', 1)->orderBy('created_at', 'desc');

        // Filter tanggal
        if ($request->filled('tgl_awal')) {
            $query->whereDate('created_at', '>=', $request->tgl_awal);
        }
        if ($request->filled('tgl_akhir')) {
            $query->whereDate('created_at', '<=', $request->tgl_akhir);
        }

        // Search
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

    /**
     * MODAL EDIT PRODUCT (AJAX)
     */
    public function show($id)
    {
        $data = Product::findOrFail($id);

        return view('admin.modal.editModal', [
            'title' => 'Edit data product',
            'data'  => $data,
        ])->render();
    }

    /**
     * MODAL TAMBAH PRODUCT (AJAX)
     */
    public function addModal()
    {
        return view('admin.modal.addModal', [
            'title' => 'Tambah Data Produk',
            'sku'   => 'BRG' . rand(1000, 99999),
        ]);
    }

    /**
     * SIMPAN PRODUCT BARU
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'sku'       => 'required|string|max:100',
            'nama'      => 'required|string|max:255',
            'type'      => 'required|string',
            'kategori'  => 'required|string',
            'harga'     => 'required|numeric|min:0',
            'quantity'  => 'required|integer|min:0',
            'foto'      => 'required|image|mimes:jpg,jpeg,png|max:4096',
            'deskripsi' => 'nullable|string',
        ]);

        // === SIMPAN FOTO KE public/storage/product (tanpa perlu storage:link ribet) ===
        $file = $request->file('foto');
        $namaFile = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());

        // pastikan foldernya ada
        $destination = public_path('storage/product');
        if (!is_dir($destination)) {
            mkdir($destination, 0775, true);
        }

        $file->move($destination, $namaFile);

        // SIMPAN KE DATABASE
        Product::create([
            'sku'          => $validated['sku'],
            'nama_product' => $validated['nama'],
            'type'         => $validated['type'],
            'kategory'     => $validated['kategori'],
            'harga'        => $validated['harga'],
            'quantity'     => $validated['quantity'],
            'foto'         => $namaFile,
            'discount'     => 0.10,                       // default biar nggak error NOT NULL
            'deskripsi'    => $validated['deskripsi'] ?? null,
            'is_active'    => 1,
        ]);

        return redirect()->route('product')->with('Berhasil', 'Product berhasil ditambahkan.');
    }

    /**
     * UPDATE PRODUCT
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'nama'      => 'required|string|max:255',
            'type'      => 'required|string',
            'kategori'  => 'required|string',
            'harga'     => 'required|numeric|min:0',
            'quantity'  => 'required|integer|min:0',
            'foto'      => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
            'deskripsi' => 'nullable|string',
        ]);

        $dataUpdate = [
            'nama_product' => $validated['nama'],
            'type'         => $validated['type'],
            'kategory'     => $validated['kategori'],
            'harga'        => $validated['harga'],
            'quantity'     => $validated['quantity'],
            // kalau kosong, pakai yang lama (biar edit bisa hapus & isi lagi)
            'deskripsi'    => $validated['deskripsi'] ?? $product->deskripsi,
        ];

        // Kalau ada foto baru, simpan & update
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $namaFile = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());

            $destination = public_path('storage/product');
            if (!is_dir($destination)) {
                mkdir($destination, 0775, true);
            }

            $file->move($destination, $namaFile);
            $dataUpdate['foto'] = $namaFile;
        }

        $product->update($dataUpdate);

        return redirect()->route('product')->with('berhasil_update', 'Data produk berhasil diupdate.');
    }

    /**
     * HAPUS / NONAKTIFKAN PRODUCT
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if (DB::table('detail_transaksis')->where('id_barang', $id)->exists()) {
            $product->is_active = 0;
            $product->save();
            $message = 'Produk terkait transaksi. Status diubah menjadi tidak aktif.';
        } else {
            $product->delete();
            $message = 'Barang berhasil dihapus.';
        }

        return redirect()->route('product')->with('Berhasil', $message);
    }
}
