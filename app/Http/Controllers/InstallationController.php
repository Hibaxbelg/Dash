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

        if ($request->ajax()) {

            $table = datatables()->of($results);

            $table->addColumn('doctor.name', fn($row) => $row['doctor']['FAMNAME'] . ' ' . $row['doctor']['SHORTNAME']);

            if ($request->type !== 'demo') {
                $table->editColumn('installation_count', fn($row) => $row['installation_count'] . '/' . $row['order']['licenses']);
            }

            $table->addColumn('status', fn($row) => view('admin.installations.includes.datatable.status-field', ['row' => $row]));

            if ($request->type !== 'demo') {
                $table->addColumn('actions', fn($row) => view('admin.installations.includes.datatable.actions', [
                    'row' => $row,
                ]));
            }

            if ($request->type == 'demo') {
                $table->addColumn('expiration_date', fn($row) => $row->created_at);
            }
            return $table->make(true);
        }

        if ($request->type == 'demo') {
            $data = [
                ['name' => 'Medecin', 'data' => 'doctor.name'],
                ['name' => 'CnamId', 'data' => 'doctor.CNAMID'],
                ['name' => 'Telephone', 'data' => 'doctor.TELEPHONE'],
                ['name' => 'Etat', 'data' => 'status', 'searchable' => false],
                ['name' => 'Date Installation', 'data' => 'created_at', 'searchable' => false],
                ['name' => 'Date Expiration', 'data' => 'expiration_date', 'searchable' => false],
            ];
        } else {
            $data = [
                ['name' => 'ID Commande', 'data' => 'order_id', 'searchable' => false],
                ['name' => 'Medecin', 'data' => 'doctor.name'],
                ['name' => 'CnamId', 'data' => 'doctor.CNAMID'],
                ['name' => 'Telephone', 'data' => 'doctor.TELEPHONE'],
                ['name' => 'Nombre des licences utilisées', 'data' => 'installation_count', 'searchable' => false],
                ['name' => 'Etat', 'data' => 'status', 'searchable' => false],
                ['name' => 'Action', 'data' => 'actions', 'searchable' => false],
            ];
        }

        $datatable = new DataTableService($data);

        return view('admin.installations.index', ['datatable' => $datatable]);
    }

    public function updateOrderStatus(Request $request)
    {
        Order::where('id', $request->order_id)->update(['status' => $request->status]);
        return response()->json(['success' => true]);
    }
}
