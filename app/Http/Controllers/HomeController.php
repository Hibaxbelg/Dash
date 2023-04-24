<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ProductInstallation;
use App\Models\Reclamation;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $orders=Order::InProgress()->count();
        $reclamations=Reclamation::InProgress()->count();
        $medUsers=ProductInstallation::count();

        return view('home',compact('orders','reclamations','medUsers'));
    }
}
