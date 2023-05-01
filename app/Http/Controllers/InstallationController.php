<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ProductInstallation;
use App\Services\DataTableService;
use Illuminate\Http\Request;

class InstallationController extends Controller
{
    public function index(Request $request)
    {
        // if ($request->type == 'demo') {
        //     $results = ProductInstallation::whereNull('order_id')
        //         ->with('doctor')
        //         ->get();
        // } else {
        //     $installations = ProductInstallation::whereNotNull('order_id')
        //         ->with('order', 'doctor')
        //         ->select('order_id', 'doctor_id', 'hdid', 'cpui', 'created_at')
        //         ->get();

        //     $results = $installations->groupBy('order_id')->map(function ($group) {
        //         $order = $group->first()->order;
        //         return [
        //             'order_id' => $order->id,
        //             'order' => $order,
        //             'doctor' => $group->first()->doctor,
        //             'installation_count' => $group->count(),
        //             'installation' => $group->map(function ($installation) {
        //                 return [
        //                     'hdid' => $installation->hdid,
        //                     'cpui' => $installation->cpui,
        //                     'created_at' => $installation->created_at,
        //                 ];
        //             })->toArray(),
        //         ];
        //     })->values();
        // }

        if ($request->ajax()) {
            $results = ProductInstallation::whereNull('order_id')
                ->with('doctor')
                ->get();

            $table = datatables()->of(
                ProductInstallation::query()
                    ->with('doctor:RECORD_ID,LOCALITE,GOUVNAME,SPECIALITE,FAMNAME,SHORTNAME,TELEPHONE,CNAMID')
                    ->with('doctor')
                // ->select('id', 'doctor_id', 'qualite', 'formation', 'formateur', 'product_id', 'status', 'date', 'note', 'licenses', 'price', 'dep_price', 'user_id', 'os', 'distance', 'payment_by')
                // ->orderBy('status', 'desc')
            );

            return $table->make(true);
        }

        $datatable = new DataTableService([
            ['name' => 'ID', 'data' => 'id', 'searchable' => false],
            ['name' => 'Nom Client', 'data' => 'doctor.FAMNAME'],
            ['name' => 'Prenom Client', 'data' => 'doctor.SHORTNAME'],
            //['name' => 'Localité', 'data' => 'doctor.LOCALITE', 'type' => 'select', 'values' => $localites, 'visible' => false],
            //['name' => 'GouvName', 'data' => 'doctor.GOUVNAME', 'type' => 'select', 'values' => $gouvnames, 'visible' => false],
            ['name' => 'Telephone', 'data' => 'doctor.TELEPHONE', 'visible' => false],
            ['name' => 'CnamId', 'data' => 'doctor.CNAMID'],
            ['name' => 'CnamId', 'data' => 'installation'],
            // ['name' => 'Note', 'data' => 'note', 'visible' => false, 'searchable' => false],
            // ['name' => 'Date', 'data' => 'date'],
            // ['name' => 'Produit', 'data' => 'product.name'],
            // ['name' => 'Licences', 'data' => 'licenses'],
            // ['name' => 'Prix', 'data' => 'price'],
            // ['name' => 'Etat', 'data' => 'status', 'searchable' => false, 'type' => 'select', 'values' => ['En attente', 'En cours', 'Terminé', 'Annulé']],
            // ['name' => 'Action', 'data' => 'actions', 'searchable' => false],
        ]);

        return view('admin.installations.index', ['datatable' => $datatable]);
    }

    public function updateOrderStatus(Request $request)
    {
        Order::where('id', $request->order_id)->update(['status' => $request->status]);
        return response()->json(['success' => true]);
    }
}
