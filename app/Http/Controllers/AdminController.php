<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Keuangan;
use App\Models\Order;
use App\Models\OrderItem; // <-- penting, tambahkan ini

class AdminController extends Controller
{
    // DASHBOARD
    public function admin()
    {
        // Hitung statistik untuk dashboard
        $today_sales      = Order::whereDate('created_at', today())->count();
        $today_revenue    = Order::whereDate('created_at', today())->sum('total_amount');
        $total_orders     = Order::count();
        $pending_orders   = Order::where('status', 'pending')->count();
        $paid_orders      = Order::where('status', 'paid')->count();
        $cancelled_orders = Order::where('status', 'cancelled')->count();

        // Ambil 5 order terbaru
        $orders = Order::latest()->take(5)->get();

        return view('admin.page.dashboard', [
            'name'              => 'Dashboard',
            'title'             => 'Admin Dashboard',

            // kirim ke blade:
            'today_sales'       => $today_sales,
            'today_revenue'     => $today_revenue,
            'total_orders'      => $total_orders,
            'pending_orders'    => $pending_orders,
            'paid_orders'       => $paid_orders,
            'cancelled_orders'  => $cancelled_orders,
            'orders'            => $orders,
        ]);
    }

    // HALAMAN LOGIN
    public function login()
    {
        return view('admin.page.login', [
            'name'  => 'Login',
            'title' => 'Admin Login'
        ]);
    }

    // PROSES LOGIN
    public function loginProses(Request $request)
    {
        Session::flash('error', $request->email);

        $dataLogin = [
            'email'    => $request->email,
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

    // LOGOUT
    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('admin');
    }
}
