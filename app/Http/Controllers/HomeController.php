<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ProductInstallation;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (!Auth::check()) {
            return view('auth.login');
        }

        $orders_count = Order::count();
        $demo_count = ProductInstallation::whereNull('order_id')->count();
        $users_count = ProductInstallation::whereNotNull('order_id')->count();

        $orders_this_week = Order::where('status', 'in_progress')
            ->whereBetween('date', [now()->subWeek(), now()])
            ->with('doctor', 'product')
            ->limit(7)
            ->orderBy('date', 'asc')
            ->get();

        $products_order_counts = Order::join('products', 'products.id', '=', 'orders.product_id')
            ->groupBy('products.name')
            ->select('products.name')
            ->selectRaw('count(*) as order_count')
            ->orderBy('order_count', 'desc')
            ->get();

        $qualites = [
            1 => ['name' => 'bonne', 'icon' => '<i style="color:#00b894" class="fa-3x fa-solid fa-face-laugh-beam"></i>', 'count' => 0],
            2 => ['name' => 'Acceptable', 'icon' => '<i style="color:#00cec9" class="fa-3x fa-solid fa-face-smile"></i>', 'count' => 0],
            3 => ['name' => 'Mauvaise', 'icon' => '<i style="color:#e17055" class="fa-3x fa-solid fa-face-frown"></i>', 'count' => 0],
            4 => ['name' => 'Hors vue', 'icon' => '<i style="color:#d63031" class="fa-3x fa-sharp fa-solid fa-face-sad-cry"></i>', 'count' => 0],
        ];

        $order_qualites = Order::selectRaw('qualite , count(*) as count')
            ->whereNotNull('qualite')
            ->groupBy('qualite')
            ->get();

        foreach ($qualites as $key => $value) {
            $qualites[$key]['count'] = $order_qualites->where('qualite', $key)->first()->count ?? 0;
        }

        return view('home', [
            'orders_count' => $orders_count,
            'demo_count' => $demo_count,
            'users_count' => $users_count,
            'orders_this_week' => $orders_this_week,
            'products_order_counts' => $products_order_counts,
            'qualites' => $qualites,
        ]);
    }
}
