<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        // jika kosong, untuk demo kita isi dummy sementara
        if(Order::count() == 0){
            Order::insert([
                [
                    'order_code' => 'ORD'.rand(1000,9999),
                    'customer_name' => 'Budi',
                    'total_amount' => 350000,
                    'status' => 'paid'
                ],
                [
                    'order_code' => 'ORD'.rand(1000,9999),
                    'customer_name' => 'Sinta',
                    'total_amount' => 200000,
                    'status' => 'pending'
                ],
                [
                    'order_code' => 'ORD'.rand(1000,9999),
                    'customer_name' => 'Andi',
                    'total_amount' => 500000,
                    'status' => 'delivered'
                ]
            ]);
        }

        $todaysSales    = Order::whereDate('created_at', today())->count();
        $todaysRevenue  = Order::whereDate('created_at', today())->sum('total_amount');
        $inEscrow       = Order::where('status','pending')->sum('total_amount');
        $totalRevenue   = Order::whereIn('status',['paid','delivered'])->sum('total_amount');
        $latestOrders   = Order::latest()->take(7)->get();

        return view('admin.page.dashboard',compact(
            'todaysSales','todaysRevenue','inEscrow','totalRevenue','latestOrders'
        ));
    }
}
