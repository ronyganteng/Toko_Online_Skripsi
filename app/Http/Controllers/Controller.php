<?php

namespace App\Http\Controllers;

use App\Models\product;
use App\Models\TblCart;
use App\Models\transaksi;
use App\Models\modelDetailTransaksi;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * ID yang dipakai untuk keranjang
     * - kalau customer login -> pakai id customer
     * - kalau belum login     -> pakai 'guest123'
     */
    protected function getCartUserId()
    {
        return auth('customer')->check()
            ? auth('customer')->id()
            : 'guest123';
    }

    // ================== SHOP ==================
    public function shop()
    {
        $userId        = $this->getCartUserId();
        $data          = product::paginate(8);
        $countKeranjang = TblCart::where(['idUser' => $userId, 'status' => 0])->count();

        return view('pelanggan.page.shop', [
            'title' => 'Shop',
            'data'  => $data,
            'count' => $countKeranjang,
        ]);
    }

    // ================== KERANJANG ==================
    public function transaksi()
    {
        $userId = $this->getCartUserId();

        $db = TblCart::with('product')
            ->where(['idUser' => $userId, 'status' => 0])
            ->get();

        $countKeranjang = TblCart::where([
            'idUser' => $userId,
            'status' => 0
        ])->count();

        return view('pelanggan.page.transaksi', [
            'title' => 'Transaksi',
            'count' => $countKeranjang,
            'data'  => $db,
        ]);
    }

    // HAPUS SATU ITEM KERANJANG
    public function deleteCartItem($id)
    {
        TblCart::where('id', $id)->delete();

        Session::flash('success', 'Barang dihapus dari keranjang.');
        return redirect()->route('transaksi');
    }

    // ================== CONTACT ==================
    public function contact()
    {
        $userId        = $this->getCartUserId();
        $countKeranjang = TblCart::where(['idUser' => $userId, 'status' => 0])->count();

        return view('pelanggan.page.contact', [
            'title' => 'Contact Us',
            'count' => $countKeranjang,
        ]);
    }

    // ================== CHECKOUT ==================
    public function checkout()
    {
        $userId        = $this->getCartUserId();
        $countKeranjang = TblCart::where(['idUser' => $userId, 'status' => 0])->count();

        $code          = transaksi::count();
        $codeTransaksi = date('Ymd') . ($code + 1);

        $detailBelanja = modelDetailTransaksi::where([
                'id_transaksi' => $codeTransaksi,
                'status'       => 0
            ])->sum('price');

        $jumlahBarang = modelDetailTransaksi::where([
                'id_transaksi' => $codeTransaksi,
                'status'       => 0
            ])->count('id_barang');

        $qtyBarang = modelDetailTransaksi::where([
                'id_transaksi' => $codeTransaksi,
                'status'       => 0
            ])->sum('qty');

        return view('pelanggan.page.checkOut', [
            'title'         => 'Check Out',
            'count'         => $countKeranjang,
            'detailBelanja' => $detailBelanja,
            'jumlahbarang'  => $jumlahBarang,
            'qtyOrder'      => $qtyBarang,
            'codeTransaksi' => $codeTransaksi,
        ]);
    }

    // PROSES CHECKOUT (DARI KERANJANG -> DETAIL TRANSAKSI)
    public function prosesCheckout(Request $request, $id)
    {
        $data = $request->all();

        $code          = transaksi::count();
        $codeTransaksi = date('Ymd') . ($code + 1);

        // total numeric (bersihin format Rp / titik)
        $rawTotal = $data['total'] ?? 0;
        $price    = (int) preg_replace('/[^\d]/', '', $rawTotal);

        // SIMPAN DETAIL BARANG
        $fieldDetail = [
            'id_transaksi' => $codeTransaksi,
            'id_barang'    => $data['idBarang'],
            'qty'          => (int) $data['qty'],
            'price'        => $price,
        ];
        modelDetailTransaksi::create($fieldDetail);

        // UPDATE CART
        $fieldCart = [
            'qty'    => (int) $data['qty'],
            'price'  => $price,
            'status' => 1,
        ];
        TblCart::where('id', $id)->update($fieldCart);

        Session::flash('success', 'Checkout berhasil!');
        return redirect()->route('checkout');
    }

    // PROSES PEMBAYARAN
    public function prosesPembayaran(Request $request)
    {
        $data        = $request->all();
        $dbTransaksi = new transaksi();

        $dbTransaksi->code_transaksi = $data['code'];
        $dbTransaksi->total_qty      = $data['totalQty'];
        $dbTransaksi->total_harga    = $data['dibayarkan'];
        $dbTransaksi->nama_customer  = $data['namaPenerima'];
        $dbTransaksi->alamat         = $data['alamatPenerima'];
        $dbTransaksi->no_tlp         = $data['tlp'];
        $dbTransaksi->ekspedisi      = $data['ekspedisi'];
        $dbTransaksi->save();

        $dataCart = modelDetailTransaksi::where('id_transaksi', $data['code'])->get();

        foreach ($dataCart as $x) {
            $dataUp         = modelDetailTransaksi::where('id', $x->id)->first();
            $dataUp->status = 1;
            $dataUp->save();

            $idProduct               = product::where('id', $x->id_barang)->first();
            $idProduct->quantity     = $idProduct->quantity - $x->qty;
            $idProduct->quantity_out = $x->qty;
            $idProduct->save();
        }

        Session::flash('success', 'Transaksi berhasil!');
        return redirect()->route('home');
    }
}
