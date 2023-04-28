<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ProductInstallation;
use App\Models\Reclamation;
use App\Services\StatisticService;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct(private StatisticService $statisticService)
    {

    }
    public function index()
    {
        if (!Auth::check()) {
            return view('auth.login');
        }

        $orders_count = Order::count();
        $demo_count = ProductInstallation::whereNull('order_id')->count();
        $users_count = ProductInstallation::whereNotNull('order_id')->count();
        $reclamation_count=Reclamation::count();

        $orders_this_week = Order::where('status', 'in_progress')
            ->whereBetween('date', [now(),now()->addWeek()])
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

        return view('home', [
            'orders_count' => $orders_count,
            'reclamation_count'=>$reclamation_count,
            'demo_count' => $demo_count,
            'users_count' => $users_count,
            'resolved_tickets' => Reclamation::where('status', 'resolved')->count(),
            'orders_this_week' => $orders_this_week,
            'products_order_counts' => $products_order_counts,
            'qualites' => $this->statisticService->ordersQuality(),
            'reclamation_response_average_time' => $this->statisticService->reclamationsAvgTimeText(),
        ]);
    }
}
