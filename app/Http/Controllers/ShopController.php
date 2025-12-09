<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\product;
use App\Models\TblCart;
use Illuminate\Support\Facades\Auth;


class ShopController extends Controller
{
    public function index(Request $request)
{
    $query = product::where('is_active', 1);

    // search
    if ($request->filled('search')) {
        $query->where('nama_product', 'like', '%' . $request->search . '%');
    }

    // filter type (salib / patung / aksesoris)
    if ($request->filled('type')) {
        $query->where('type', $request->type);
    }

    // filter kategori
    if ($request->filled('kategori')) {
        $query->where('kategory', $request->kategori);
    }

    $products = $query->paginate(12)->withQueryString();

    // 🔥 hitung keranjang (user login atau guest123)
    $userId = Auth::guard('customer')->check()
        ? Auth::guard('customer')->id()
        : 'guest123';

    $countKeranjang = TblCart::where([
        'idUser' => $userId,
        'status' => 0,
    ])->count();

    return view('pelanggan.page.shop', [
        'title'   => 'Shop',
        'products'=> $products,
        'count'   => $countKeranjang, // 🔥 kirim ke navbar
    ]);
}

}
