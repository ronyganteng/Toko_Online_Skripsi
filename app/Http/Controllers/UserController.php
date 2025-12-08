<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Models\User;

class UserController extends Controller
{
    // LIST USER + FILTER + SEARCH
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('tgl_awal')) {
            $query->whereDate('created_at', '>=', $request->tgl_awal);
        }

        if ($request->filled('tgl_akhir')) {
            $query->whereDate('created_at', '<=', $request->tgl_akhir);
        }

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        $data = $query->orderBy('created_at', 'desc')->paginate(5)->withQueryString();

        return view('admin.page.user', [
            'name'  => 'User Management',
            'title' => 'Admin User Management',
            'data'  => $data,
        ]);
    }
        


    // BUKA MODAL TAMBAH USER
    public function addModalUser()
    {
        return view('admin.modal.modalUser', [
            'title' => 'Tambah Data User',
            'nik'   => date('Ymd').rand(000,999),
        ]);
    }


    // SIMPAN USER BARU
    public function store(UserRequest $request)
    {
        $data = new User;
        $data->nik       = $request->nik;
        $data->name      = $request->nama;
        $data->email     = $request->email;
        $data->password  = bcrypt($request->password);
        $data->alamat    = $request->alamat;
        $data->tlp       = $request->tlp;
        $data->role      = $request->role;
        $data->tglLahir  = $request->tglLahir;
        $data->is_active = 1;
        $data->is_member = 0;
        $data->is_admin  = 1;

        if ($request->hasFile('foto')) {
            $photo    = $request->file('foto');
            $filename = date('Ymd').'_'.$photo->getClientOriginalName();
            $photo->move(public_path('storage/user'), $filename);
            $data->foto = $filename;
        }

        $data->save();

        return redirect()->route('userManagement')->with('clear', 'User berhasil ditambahkan.');
    }


    // BUKA MODAL EDIT USER (AJAX)
    public function show($id)
    {
        $data = User::findOrFail($id);

        return view('admin.modal.editUser', [
            'title' => 'Edit User',
            'data'  => $data,
        ])->render();
    }


    // UPDATE USER
    public function update(Request $request, $id)
    {
        $data = User::findOrFail($id);

        $data->name     = $request->nama;
        $data->email    = $request->email;
        $data->alamat   = $request->alamat;
        $data->tlp      = $request->tlp;
        $data->role     = $request->role;
        $data->tglLahir = $request->tglLahir;

        if ($request->filled('password')) {
            $data->password = bcrypt($request->password);
        }

        if ($request->hasFile('foto')) {
            $photo    = $request->file('foto');
            $filename = date('Ymd').'_'.$photo->getClientOriginalName();
            $photo->move(public_path('storage/user'), $filename);
            $data->foto = $filename;
        }

        $data->save();

        return redirect()->route('userManagement')->with('clear', 'User berhasil diperbarui.');
    }


    // HAPUS USER
    public function destroy($id)
    {
        User::findOrFail($id)->delete();

        return redirect()->route('userManagement')->with('clear', 'User berhasil dihapus.');
    }
}
