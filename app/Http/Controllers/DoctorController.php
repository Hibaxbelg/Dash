<?php

namespace App\Http\Controllers;

use App\Http\Requests\Doctors\StoreDoctorRequest;
use App\Http\Requests\Doctors\UpdateDoctorRequest;
use App\Models\Doctor;
use App\Models\Product;
use App\Services\DataTableService;
use App\Services\OrderService;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function search(Request $request)
    {
        $doctors = Doctor::where('SPECIALITE', $request->get('SPECIALITE'))
        ?->where('GOUVNAME', $request->get('GOUVNAME'))
            ->get();
        return response()->json($doctors);
    }
    public function index(Request $request)
    {

        $gouvnames = Doctor::select('gouvname')->distinct()->pluck('gouvname');
        $localites = Doctor::select('LOCALITE')->distinct()->pluck('LOCALITE');
        $specialites = Doctor::select('SPECIALITE')->distinct()->pluck('SPECIALITE');
        $products = Product::all();

        if ($request->ajax()) {

            $table = datatables()::of(Doctor::query());

            $table->addColumn('actions', fn($row) => view('admin.doctors.includes.datatable.actions', [
                'row' => $row,
                'gouvnames' => $gouvnames,
                'localites' => $localites,
                'specialites' => $specialites,
                'products' => $products,
            ]));

            return $table->make(true);
        }

        $datatable = new DataTableService([
            ['name' => 'Id', 'data' => 'RECORD_ID', 'searchable' => false],
            ['name' => 'Nom', 'data' => 'FAMNAME'],
            ['name' => 'Prénom', 'data' => 'SHORTNAME'],
            ['name' => 'Spécalité', 'data' => 'SPECIALITE', 'type' => 'select', 'values' => $specialites],
            ['name' => 'Id CNAM', 'data' => 'CNAMID'],
            ['name' => 'Gouvern', 'data' => 'GOUVNAME', 'type' => 'select', 'values' => $gouvnames],
            ['name' => 'Localité', 'data' => 'LOCALITE', 'type' => 'select', 'values' => $localites],
            ['name' => 'Tél', 'data' => 'TELEPHONE'],
            ['name' => 'Gsm', 'data' => 'GSM'],
            ['name' => 'Action', 'data' => 'actions', 'searchable' => false],
        ]);

        return view('admin.doctors.index', [
            'datatable' => $datatable, 'gouvnames' => $gouvnames, 'localites' => $localites, 'specialites' => $specialites, 'products' => $products,
            'prix_KM' => OrderService::$prix_KM,
        ]);
    }

    public function destroy($RECORD_ID)
    {

        $doctor = Doctor::findOrFail($RECORD_ID);
        $orders = $doctor->orders()->get();

        foreach ($orders as $order) {
            $order->productInstallations()->delete();
            $order->delete();
        }

        $doctor->delete();

        return redirect()->route('doctors.index')
            ->with([
                'message' => 'Médecin supprimé avec succès',
                'type' => 'success',
            ]);
    }

    public function update(UpdateDoctorRequest $request, $RECORD_ID)
    {

        $doctor = Doctor::find($RECORD_ID)
            ->update($request->validated());

        $request->session()->put('message', 'Médecin modifié avec succès');
        $request->session()->put('type', 'success');
    }

    public function store(StoreDoctorRequest $request)
    {

        Doctor::create($request->validated());

        return redirect()->route('doctors.index')
            ->with([
                'message' => 'Médecin ajouté avec succès',
                'type' => 'success',
            ]);

    }
}
