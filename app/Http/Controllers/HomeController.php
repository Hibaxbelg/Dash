<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ProductInstallation;
use App\Models\Reclamation;
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

        $reclamations_responses_in_minutes = [];

        $reclamations = Reclamation::select('created_at', 'updated_at')->get();

        foreach ($reclamations as $reclamation) {
            $reclamations_responses_in_minutes[] = $reclamation->updated_at->diffInMinutes($reclamation->created_at);
        }

        $average_time_minutes = array_sum($reclamations_responses_in_minutes) / count($reclamations_responses_in_minutes);

        if ($average_time_minutes < 60) {
            if ($average_time_minutes == 1) {
                $average_time_text = "1 minute";
            } else {
                $average_time_text = $average_time_minutes . " minutes";
            }
        } else {
            $hours = floor($average_time_minutes / 60);
            $minutes = $average_time_minutes % 60;

            if ($hours == 1) {
                $hours_text = "1 heure";
            } else {
                $hours_text = "$hours heures";
            }

            if ($minutes == 1) {
                $minutes_text = "1 minute";
            } elseif ($minutes == 0) {
                $minutes_text = "";
            } else {
                $minutes_text = "$minutes minutes";
            }

            $average_time_text = $hours_text;

            if (!empty($minutes_text)) {
                $average_time_text .= " et " . $minutes_text;
            }
        }

        // dd($reclamations_responses_in_minutes_per_day);

        return view('home', [
            'orders_count' => $orders_count,
            'demo_count' => $demo_count,
            'users_count' => $users_count,
            'orders_this_week' => $orders_this_week,
            'products_order_counts' => $products_order_counts,
            'qualites' => $qualites,
            'reclamation_response_average_time' => $average_time_text,
        ]);
    }
}
