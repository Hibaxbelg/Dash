<?php

namespace App\Http\Controllers;

use App\Http\Requests\Doctors\StoreDoctorRequest;
use App\Http\Requests\Doctors\UpdateDoctorRequest;
use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Product;
use App\Services\DataTableService;
use App\Services\OrderService;
use Illuminate\Support\Facades\Gate;

class DoctorController extends Controller
{
    public function index(Request $request)
    {

        $gouvnames = Doctor::select('gouvname')->distinct()->pluck('gouvname');
        $localites = Doctor::select('LOCALITE')->distinct()->pluck('LOCALITE');
        $specialites = Doctor::select('SPECIALITE')->distinct()->pluck('SPECIALITE');
        $products = Product::all();

        if ($request->ajax()) {

            $table = datatables()::of(Doctor::query());

            $table->addColumn('actions', fn ($row) => view('admin.doctors.includes.datatable.actions', [
                'row' => $row,
                'gouvnames' => $gouvnames,
                'localites' => $localites,
                'specialites' => $specialites,
                'products' => $products,
            ]));

            return $table->make(true);
        }

        $datatable = new DataTableService([
            ['name' => 'UID'],
            ['name' => 'Nom', 'data' => 'FAMNAME'],
            ['name' => 'Prénom', 'data' => 'SHORTNAME'],
            ['name' => 'Spécalité', 'data' => 'SPECIALITE', 'type' => 'select', 'values' => $specialites],
            ['name' => 'ID.CNAM', 'data' => 'CNAMID'],
            ['name' => 'Gouvern', 'data' => 'GOUVNAME', 'type' => 'select', 'values' => $gouvnames],
            ['name' => 'Localité', 'data' => 'LOCALITE', 'type' => 'select', 'values' => $localites],
            ['name' => 'Tél', 'data' => 'TELEPHONE'],
            ['name' => 'Gsm', 'data' => 'GSM'],
            ['name' => '?', 'data' => 'actions', 'searchable' => false]
        ]);

        return view('admin.doctors.index', [
            'datatable' => $datatable, 'gouvnames' => $gouvnames, 'localites' => $localites, 'specialites' => $specialites, 'products' => $products,
            'prix_KM' => OrderService::$prix_KM
        ]);
    }


    public function destroy($RECORD_ID)
    {

        if (!Gate::allows('delete-doctor')) {
            abort(403);
        }

        Doctor::where('RECORD_ID', $RECORD_ID)->delete();

        return redirect()->route('doctors.index')
            ->with([
                'message' => 'Médecin supprimé avec succès',
                'type' => 'success'
            ]);
    }

    public function update(UpdateDoctorRequest $request, $RECORD_ID)
    {

        $doctor = Doctor::where('RECORD_ID', $RECORD_ID)
            ->update($request->validated());

        return redirect()->route('doctors.index')
            ->with([
                'message' => 'Médecin modifié avec succès',
                'type' => 'success'
            ]);
    }

    public function store(StoreDoctorRequest $request)
    {

        Doctor::create($request->validated());

        return redirect()->route('doctors.index')
            ->with([
                'message' => 'Médecin inseré avec succès',
                'type' => 'success'
            ]);
    }
}
