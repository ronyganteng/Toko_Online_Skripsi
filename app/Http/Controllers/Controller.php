<?php

namespace App\Http\Controllers;
use App\Models\product;


use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;


class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public function shop(){

        $data = product::paginate(8);
        return view('pelanggan.page.shop', [
            'title'     => 'Shop',
            'data' => $data,
        ]);
    }
    public function transaksi(){
        return view('pelanggan.page.transaksi', [
            'title'     => 'Transaksi'
        ]);
    }
    public function contact(){
        return view('pelanggan.page.contact', [
            'title'     => 'Contact Us'
        ]);
    }
    public function checkout(){
        return view('pelanggan.page.checkOut', [
            'title'     => 'Check Out'
        ]);
    
    }
    
}