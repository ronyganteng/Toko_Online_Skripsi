<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\product;
use RealRashid\SweetAlert\Facades\Alert;


use Illuminate\Http\Request;

class ProductController extends Controller

{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
        $data = product::orderBy('created_at', 'desc')->paginate(5);

        return view('admin.page.product', [
            'name'  => 'Product',
            'title' => 'Admin Product',
            'data'  => $data,
    ]);
}

    public function addModal(){
        return view('admin/modal/addModal',[
            'title'     => 'Tambah Data Produk',
            'sku'       => 'BRG' .rand(1000, 99999),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $data = new product;
        $data->sku          = $request->sku;
        $data->nama_product = $request->nama;
        $data->type         = $request->type;
        $data->kategory     = $request->kategori;
        $data->harga        = $request->harga;
        $data->quantity     = $request->quantity;
        $data->discount     = 10/100;
        $data->is_active    = 1;
        
        if($request->hasFile('foto')){
            $photo = $request->file('foto');
            $filename = date('Ymd').'_'.$photo->getClientOriginalName();
            $photo->move(public_path('storage/product'),$filename);
            $data->foto = $filename;
        }
        $data->save();
        session()->flash('Berhasil', 'Data Berhasil Disimpan');
        Alert::toast('Berhasil', 'Data berhasil disimpan');
        return redirect()->route('product');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = product::findOrFail($id);

        return view(
            'admin.modal.editModal',
            [
                'title' => 'Edit data product',
                'data' => $data,

            ]
        )->render();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, product $product, $id)
    {
        $data = product::findOrFail($id);

        if($request->file('foto')){
            $photo = $request->file('foto');
            $filename = date('Ymd').'_'.$photo->getClientOriginalName();
            $photo->move(public_path('storage/product'),$filename);
            $data->foto = $filename;     
        }else{
            $filename = $request->foto;
        }

        $field = [
            'sku'                   =>$request->sku,
            'nama_product'          =>$request->nama,
            'type'                  =>$request->type,
            'kategory'              =>$request->kategori,
            'harga'                 =>$request->harga,
            'quantity'              =>$request->quantity,
            'discount'              =>10/100,
            'is_active'              =>1,
            'foto'                  => $filename,
            
        ];

        $data::where('id', $id)->update($field);
        session()->flash('Berhasil', 'Data Berhasil Disimpan');
        Alert::toast('Berhasil', 'Data berhasil disimpan');
        return redirect()->route('product');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
