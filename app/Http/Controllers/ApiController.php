<?php

namespace App\Http\Controllers;

use App\Http\Requests\Api\InstallationRequest;
use App\Models\Doctor;
use App\Models\Order;
use App\Models\ProductInstallation;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function store(InstallationRequest $request)
    {
        $doctor_id = Doctor::where('CNAMID', $request->cnamid)->first()->RECORD_ID;
        // le medecin dispose d'un code d'installation
        if ($request->has('key')) {

            $order = Order::where('installation_key', $request->key)->first();

            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => 'code d\'installation erroné',
                ]);
            } else if ($order->status !== 'installed') {
                return response()->json([
                    'success' => false,
                    'message' => 'commande non activée',
                ]);
            }

            $licenses = $order->licenses;
            $installations = ProductInstallation::where('order_id', $order->id)->count();


            if (ProductInstallation::where([
                'order_id' => $order->id,
                'hdid' => $request->hdid,
                'cpui' => $request->cpui,
            ])->count() == 0) {
                // une nouvelle installation

                if ($installations >= $licenses) {
                    return response()->json([
                        'status' => false,
                        'message' => 'nombre de licenses dépassé',
                    ]);
                }

                ProductInstallation::create([
                    'order_id' => $order->id,
                    'doctor_id' => $doctor_id,
                    'hdid' => $request->hdid,
                    'cpui' => $request->cpui,
                ]);

                return response()->json([
                    'status' => true,
                    'message' => 'installation réussie',
                ]);
            } else {
                // PC FORMATE

                return response()->json([
                    'status' => true,
                    'message' => 'installation réussie',
                ]);
            }
        } else {
            // le medecin n'a pas de code d'installation (DEMO)

            if (ProductInstallation::where('hdid', $request->hdid)->where('cpui', $request->cpui)->count() != 0) {
                return response()->json([
                    'status' => false,
                    'message' => 'Vous avez déjà installé la version DEMO',
                ]);
            }

            ProductInstallation::create([
                'doctor_id' => $doctor_id,
                'hdid' => $request->hdid,
                'cpui' => $request->cpui,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'installation réussie (DEMO)',
            ]);
        }
    }
}
