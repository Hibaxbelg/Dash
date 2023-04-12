<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ProductInstallation;
use Illuminate\Http\Request;

class InstallationController extends Controller
{
    public function index(Request $request)
    {
        if ($request->type == 'demo') {
            $results = ProductInstallation::whereNull('order_id')
                ->with('doctor')
                ->get();
        } else {
            $installations = ProductInstallation::whereNotNull('order_id')
                ->with('order', 'doctor')
                ->select('order_id', 'doctor_id', 'hdid', 'cpui', 'created_at')
                ->get();

            $results = $installations->groupBy('order_id')->map(function ($group) {
                $order = $group->first()->order;
                return [
                    'order_id' => $order->id,
                    'order' => $order,
                    'doctor' => $group->first()->doctor,
                    'installation_count' => $group->count(),
                    'installation' => $group->map(function ($installation) {
                        return [
                            'hdid' => $installation->hdid,
                            'cpui' => $installation->cpui,
                            'created_at' => $installation->created_at,
                        ];
                    })->toArray(),
                ];
            })->values();
        }

        return view('admin.installations.index', ['installations' => $results]);
    }

    public function updateOrderStatus(Request $request)
    {
        Order::where('id', $request->order_id)->update(['status' => $request->status]);
        return response()->json(['success' => true]);
    }
}
