<?php

namespace App\Services;

use App\Models\Doctor;
use App\Models\Order;
use App\Models\Product;
use App\Models\Reclamation;
use Carbon\Carbon;

class StatisticService
{
    public function ordersByGov()
    {
        $govs = Doctor::distinct('gouvname')->pluck('gouvname');
        $doctors_gov = collect([]);
        $orders = Order::with('doctor')->get();
        $products = Product::all();

        foreach ($govs as $gov) {
            $doctors_gov[$gov] = [
                'orders_count' => $orders->where('doctor.GOUVNAME', $gov)->count(),
                'products' => $products->map(function ($product) use ($gov, $orders) {
                    return [
                        'name' => $product->name,
                        'count' => $orders
                            ->where('doctor.GOUVNAME', $gov)
                            ->where('product_id', $product->id)
                            ->count(),
                    ];
                }),
            ];
        }

        return $doctors_gov = $doctors_gov->sortByDesc('orders_count');
    }

    public function orderBySpecialite()
    {
        $specialites = Doctor::distinct('SPECIALITE')->pluck('SPECIALITE');
        $doctors_spec = collect([]);
        $products = Product::all();
        $orders = Order::with('doctor')->get();

        foreach ($specialites as $specialite) {
            $doctors_spec[$specialite] = [
                'orders_count' => $orders->where('doctor.SPECIALITE', $specialite)->count(),
                'products' => $products->map(function ($product) use ($specialite, $orders) {
                    return [
                        'name' => $product->name,
                        'count' => $orders
                            ->where('doctor.SPECIALITE', $specialite)
                            ->where('product_id', $product->id)
                            ->count(),
                    ];
                }),
            ];
        }

        return $doctors_spec = $doctors_spec->sortByDesc('orders_count');
    }

    public function ordersByLabo()
    {
        $labos = ['MEDIS', 'ADWYA', 'OPALIA', 'VITAL', 'PHILADELPHIA'];

        $labo_orders = collect([]);
        $products = Product::all();
        $orders = Order::with('doctor')->get();

        foreach ($labos as $labo) {
            $labo_orders[$labo] = [
                'orders_count' => $orders->where('payment_by', $labo)->count(),
                'products' => $products->map(function ($product) use ($labo, $orders) {
                    return [
                        'name' => $product->name,
                        'count' => $orders
                            ->where('payment_by', $labo)
                            ->where('product_id', $product->id)
                            ->count(),
                    ];
                }),
            ];
        }

        return $labo_orders = $labo_orders->sortByDesc('orders_count');
    }

    public function ordersPerMonthChartData($month)
    {
        $year = Carbon::now()->year;
        $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth();

        return Order::
            selectRaw('date_format(created_at,"%Y-%m-%d") as order_date , count(*) as orders_count')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupByRaw('Date(created_at)')
            ->orderBy('created_at')
            ->get();

    }
    public function reclamationsAvgTimeChartData($month)
    {
        $reclamations_responses_in_minutes_per_day = [];
        $year = Carbon::now()->year;
        $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth();

        $reclamations = Reclamation::whereBetween('created_at', [$startDate, $endDate])->get();
        $data = [];
        foreach ($reclamations as $reclamation) {
            $reclamations_responses_in_minutes_per_day[$reclamation->updated_at->format('Y-m-d')][] = $reclamation->updated_at->diffInMinutes($reclamation->created_at);
        }

        foreach ($reclamations_responses_in_minutes_per_day as $key => $value) {

            $sum = 0;
            foreach ($reclamations_responses_in_minutes_per_day[$key] as $key2 => $value2) {
                $sum += $value2;
            }

            $data[] = [
                'date' => $key,
                'response_in_minutes' => $sum,
            ];
        };

        return $data;
    }

    public function reclamationsAvgTimeText()
    {
        $reclamations_responses_in_minutes = [];

        $reclamations = Reclamation::select('created_at', 'updated_at')->get();

        foreach ($reclamations as $reclamation) {
            $reclamations_responses_in_minutes[] = $reclamation->updated_at->diffInMinutes($reclamation->created_at);
        }

        if (count($reclamations_responses_in_minutes) == 0) {
            return "0 minute";
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

        return $average_time_text;
    }

    public function ordersQuality()
    {
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

        return $qualites;
    }
}
