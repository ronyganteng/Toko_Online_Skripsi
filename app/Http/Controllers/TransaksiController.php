<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Http\Requests\StoreTransaksiRequest;
use App\Http\Requests\UpdateTransaksiRequest;
use App\Models\product;
use App\Models\TblCart;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class TransaksiController extends Controller
{
    /**
     * Helper: ID pemilik keranjang (customer login / guest)
     */
    protected function getCartOwnerId()
    {
        // kalau customer sudah login → pakai id customer
        if (auth('customer')->check()) {
            return auth('customer')->id();
        }

        // kalau belum login → pakai guest
        return 'guest123';
    }

    /**
     * HALAMAN HOME
     */
    public function index()
    {
        $best  = product::where('quantity_out', '>=', 5)->get();
        $data  = product::paginate(8);

        $ownerId = $this->getCartOwnerId();

        $countKeranjang = TblCart::where('idUser', $ownerId)
            ->where('status', 0)
            ->count();

        return view('pelanggan.page.home', [
            'title' => 'Home',
            'data'  => $data,
            'best'  => $best,
            'count' => $countKeranjang,
        ]);
    }

   public function addToCart(Request $request)
{
    // support banyak nama field: id_barang (baru) / idProduct (lama)
    $idProduct = $request->input('id_barang') 
              ?? $request->input('idProduct') 
              ?? $request->input('id_product');

    if (!$idProduct) {
        Alert::error('Gagal', 'Produk tidak diketahui');
        return redirect()->back();
    }

    $product = product::find($idProduct);

    if (!$product) {
        Alert::error('Gagal', 'Produk tidak ditemukan');
        return redirect()->back();
    }

    // pemilik keranjang (customer / guest)
    $ownerId = auth('customer')->check()
        ? auth('customer')->id()
        : 'guest123';

    // kalau mau support qty dari form, ambil kalau ada, default 1
    $qty = $request->input('qty', 1);

    TblCart::create([
        'idUser'    => $ownerId,
        'id_barang' => $idProduct,
        'qty'       => $qty,
        'price'     => $product->harga,
        'status'    => 0,
    ]);

    Alert::toast('Produk ditambahkan ke keranjang', 'success');
    return redirect()->back();
}


    /**
     * HALAMAN KERANJANG
     */
    public function cart()
    {
        $ownerId = $this->getCartOwnerId();

        $data = TblCart::with('product')
            ->where('idUser', $ownerId)
            ->where('status', 0)
            ->get();

        return view('pelanggan.page.transaksi', [
            'title' => 'Keranjang',
            'data'  => $data,
            'count' => $data->count(),
        ]);
    }

    // sisanya biarin kosong dulu
    public function store(StoreTransaksiRequest $request) {}
    public function show(Transaksi $transaksi) {}
    public function edit(Transaksi $transaksi) {}
    public function update(UpdateTransaksiRequest $request, Transaksi $transaksi) {}
    public function destroy(Transaksi $transaksi) {}
}
