<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Order;
use App\Models\Product;
use App\Models\Reclamation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StatisticController extends Controller
{
    public function index()
    {
        $govs = Doctor::distinct('gouvname')->pluck('gouvname');
        $products = Product::all();

        $doctors_gov = collect([]);
        $orders = Order::with('doctor')->get();

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

        $doctors_gov = $doctors_gov->sortByDesc('orders_count');

//
        $specialites = Doctor::distinct('SPECIALITE')->pluck('SPECIALITE');

        $doctors_spec = collect([]);

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

        $doctors_spec = $doctors_spec->sortByDesc('orders_count');

        //

        $labos = ['MEDIS', 'ADWYA', 'OPALIA', 'VITAL', 'PHILADELPHIA'];

        $labo_orders = collect([]);

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

        $labo_orders = $labo_orders->sortByDesc('orders_count');

        return view('admin.statistics', [
            'doctors_gov' => $doctors_gov,
            'doctors_spec' => $doctors_spec,
            'labo_orders' => $labo_orders,
            'products' => $products,
        ]);

    }

    public function orders(Request $request)
    {
        $month = request('month') ?? Carbon::now()->month;
        $year = Carbon::now()->year;
        $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth();

        $orders = Order::
            selectRaw('date_format(created_at,"%Y-%m-%d") as order_date , count(*) as orders_count')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupByRaw('Date(created_at)')
            ->orderBy('created_at')
            ->get();

        return $orders;
    }

    public function reclamations(Request $request)
    {

        $reclamations_responses_in_minutes_per_day = [];
        $month = request('month') ?? Carbon::now()->month;
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
                // $reclamations_responses_in_minutes_per_day[$key][$key2] = $value2 / 60;
                $sum += $value2;
            }

            $data[] = [
                'date' => $key,
                'response_in_minutes' => $sum,
            ];
        }

        return $data;
    }
}
