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
    public function shop(){

        $data = product::paginate(8);
        $countKeranjang = TblCart::where(['idUser'=>'guest123', 'status' => 0])->count();
        return view('pelanggan.page.shop', [
            'title'     => 'Shop',
            'data' => $data,
            'count' => $countKeranjang,
        ]);
    }
    public function transaksi(){

        $db = TblCart::with('product')->where(['idUser'=>'guest123', 'status' => 0])->get();
        $countKeranjang = TblCart::where(['idUser'=>'guest123', 'status' => 0])->count();
        //dd($db->product->nama_product);die;
        return view('pelanggan.page.transaksi', [
            'title'     => 'Transaksi',
            'count' => $countKeranjang,
            'data' => $db,
            
        ]);
    }
    public function contact(){
        $countKeranjang = TblCart::where(['idUser'=>'guest123', 'status' => 0])->count();
        return view('pelanggan.page.contact', [
            'title'     => 'Contact Us',
            'count' => $countKeranjang,
        ]);
    }
    public function checkout(){
        $countKeranjang = TblCart::where(['idUser'=>'guest123', 'status' => 0])->count();
        $code = transaksi::count();
        $codeTransaksi = date('Ymd') . $code + 1;
        $detailBelanja = modelDetailTransaksi::where(['id_transaksi'=> $codeTransaksi, 'status' => 0])
        ->sum('price');
        $jumlahBarang = modelDetailTransaksi::where(['id_transaksi'=> $codeTransaksi, 'status' => 0])
        ->count('id_barang');
        $qtyBarang = modelDetailTransaksi::where(['id_transaksi'=> $codeTransaksi, 'status' => 0])
        ->sum('qty');
        return view('pelanggan.page.checkOut', [
            'title'     => 'Check Out',
            'count' => $countKeranjang,
            'detailBelanja' => $detailBelanja,
            'jumlahbarang' => $jumlahBarang,
            'qtyOrder'      => $qtyBarang,
            'codeTransaksi' => $codeTransaksi
        ]);
    
    }
    public function prosesCheckout(Request $request ,$id)
    {
        $data = $request->all();
        //$findId = TblCart::where('id', $id)->get();
        $code = transaksi::count();
        $codeTransaksi = date('Ymd') . $code + 1;
        //dd($data);die;

        //simpan detail barang
        $detailTransaksi = new modelDetailTransaksi();
        $fieldDetail = [
            'id_transaksi' => $codeTransaksi,
            'id_barang' => $data['idBarang'],
            'qty'       => $data['qty'],
            'price'     => $data['total']
        ];
        $detailTransaksi::create($fieldDetail);

        // update cart
        $fieldCart = [
            'qty'       => $data['qty'],
            'price'     => $data['total'],
            'status'    => 1,
        ];
        TblCart::where('id', $id)->update($fieldCart);

        Session::flash('success', 'Checkout berhasil!');

        return redirect()->route('checkout'); // redirect balik ke halaman checkout

    }

    public function prosesPembayaran(Request $request)
    {
        $data = $request->all();
        $dbTransaksi = new transaksi();
        // dd($data);die;

        $dbTransaksi->code_transaksi    = $data['code'];
        $dbTransaksi->total_qty         = $data['totalQty'];
        $dbTransaksi->total_harga       = $data['dibayarkan'];
        $dbTransaksi->nama_customer     = $data['namaPenerima'];
        $dbTransaksi->alamat            = $data['alamatPenerima'];
        $dbTransaksi->no_tlp            = $data['tlp'];
        $dbTransaksi->ekspedisi         = $data['ekspedisi'];
    $dbTransaksi->save();

    $dataCart = modelDetailTransaksi::where('id_transaksi' , $data['code'])->get();
    foreach($dataCart as $x){
        $dataUp = modelDetailTransaksi::where('id', $x->id)->first();
        $dataUp->status    = 1;
        $dataUp->save();

        $idProduct = product::where('id', $x->id_barang)->first();
        $idProduct->quantity = $idProduct->quantity - $x->qty;
        $idProduct->quantity_out = $x->qty;
        $idProduct->save();
    }

    Session::flash('success', 'Transaksi berhasil!');
    return redirect()->route('home'); // redirect balik ke halaman checkout



    }
    
}