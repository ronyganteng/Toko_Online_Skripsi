<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerAuthController extends Controller
{
    public function showLogin()
    {
        return view('pelanggan.auth.login', [
            'title' => 'Login Pelanggan',
            'count' => 0, // kalau mau pakai badge keranjang, nanti bisa diganti
        ]);
    }

    public function showRegister()
    {
        return view('pelanggan.auth.register', [
            'title' => 'Register Pelanggan',
            'count' => 0,
        ]);
    }

    public function register(Request $r)
    {
        $r->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:customers,email',
            'password'   => 'required|min:6|confirmed',
            'phone'      => 'required|string|max:20',
            'address1'   => 'required|string|max:255',
            'address2'   => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'lat'        => 'nullable|numeric',
            'lng'        => 'nullable|numeric',
        ]);

        $customer = Customer::create([
            'name'       => $r->name,
            'email'      => $r->email,
            'password'   => Hash::make($r->password),
            'phone'      => $r->phone,
            'address1'   => $r->address1,
            'address2'   => $r->address2,
            'birth_date' => $r->birth_date,
            'lat'        => $r->lat,
            'lng'        => $r->lng,
        ]);

        Auth::guard('customer')->login($customer);

        return redirect('/')->with('success', 'Registrasi berhasil, selamat datang!');
    }

    public function login(Request $r)
    {
        $r->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $r->only('email', 'password');

        if (Auth::guard('customer')->attempt($credentials, $r->filled('remember'))) {
            $r->session()->regenerate();
            return redirect('/')->with('success', 'Login berhasil!');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Berhasil logout');
    }

    public function showForgotPassword()
{
    return view('pelanggan.auth.forgot-password', [
        'title' => 'Lupa Password'
    ]);
}

}
