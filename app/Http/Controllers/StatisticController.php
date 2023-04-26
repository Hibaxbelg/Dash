<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\StatisticService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StatisticController extends Controller
{
    public function __construct(private StatisticService $statisticService)
    {

    }
    public function index()
    {
        $products = Product::all();

        return view('admin.statistics', [
            'doctors_gov' => $this->statisticService->ordersByGov(),
            'doctors_spec' => $this->statisticService->orderBySpecialite(),
            'labo_orders' => $this->statisticService->ordersByLabo(),
            'products' => $products,
        ]);

    }

    public function orders(Request $request)
    {
        return $this->statisticService->ordersPerMonthChartData(request('month') ?? Carbon::now()->month);
    }

    public function reclamations(Request $request)
    {
        return $this->statisticService->reclamationsAvgTimeChartData(request('month') ?? Carbon::now()->month);
    }
}
