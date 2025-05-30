<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function index()
    {
        $data = User::paginate(3);
        return view('admin.page.user', [
            'name'  => 'User Management',
            'data' => $data,
            'title' => 'Admin User Management'
            
        ]);
    }

    public function addModalUser()
    {
        return view('admin.modal.modalUser',[
            'title'     => 'Tambah Data User',
            'nik'       => date('Ymd').rand(000,999),
        ]);
    }
    
    public function store(UserRequest $request)
    {
        $data = new User;
        $data->nik          = $request->nik;
        $data->name         = $request->nama;
        $data->email        = $request->email;
        $data->password     = bcrypt($request->password);
        $data->alamat       = $request->alamat;
        $data->tlp          = $request->tlp;
        $data->role     = $request->role;
        $data->tglLahir     = $request->tglLahir;
        $data->is_active    = 1;
        $data->is_member    = 0;
        $data->is_admin     = 1;
        
        if($request->hasFile('foto')){
            $photo = $request->file('foto');
            $filename = date('Ymd').'_'.$photo->getClientOriginalName();
            $photo->move(public_path('storage/user'),$filename);
            $data->foto = $filename;
        }
        $data->save();
        session()->flash('clear', 'Data Berhasil Disimpan');
        Alert::toast('Berhasil', 'Data berhasil disimpan');
        return redirect()->route('product');
    }

    public function show()
    {
        
    }

    public function update()
    {
        
    }

    public function destroy()
    {
        
    }
}
