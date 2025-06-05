<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Penting untuk Auth::attempt()
use Illuminate\Support\Facades\Session; // ⬅️ Ini yang penting
use App\Models\User; // ⬅️ Pastikan juga ini ada kalau pakai User model

class AdminController extends Controller
{
    public function admin()
    {
        return view('admin.page.dashboard', [
            'name'  => 'Dashboard',
            'title' => 'Admin Dashboard',
            ''
        ]);
    }
    
    public function report()
    {
    
        return view('admin.page.report', [
            'name'  => 'Report',
            'title' => 'Admin Report'
        ]);
    }
    public function login()
    {
        return view('admin.page.login', [
            'name'  => 'Login',
            'title' => 'Admin Login'
        ]);
    }
    public function loginProses(Request $request)
{
    Session::flash('error', $request->email);

    $dataLogin = [
        'email' => $request->email,
        'password' => $request->password,
    ];

    $user = User::where('email', $request->email)->first();

    if (!$user) {
        Session::flash('error', 'Akun tidak ditemukan.');
        return back();
    }

    if ($user->is_admin == 0) {
        Session::flash('error', 'Kamu bukan admin!');
        return back();
    }

    if (Auth::attempt($dataLogin)) {
        session()->flash('Berhasil', 'Data Berhasil Disimpan');
        $request->session()->regenerate();
        return redirect('/admin/dashboard');
    } else {
        Session::flash('error', 'Email dan password kamu tidak valid!');
        return redirect('/admin');
    }
}

    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('admin');

    }

}
