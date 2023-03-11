<?php

namespace App\Http\Controllers;

use App\Http\Requests\Doctors\StoreDoctorRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Doctor;
use App\Services\DataTableService;
use DataTables;
use Illuminate\Support\Facades\Gate;

class DoctorController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return datatables()->of(DataTableService::makeSearchableBuilder(Doctor::query(), $request->columns))
                ->make(true);
        }

        $gouvnames = Doctor::select('gouvname')->distinct()->pluck('gouvname');
        $localites = Doctor::select('LOCALITE')->distinct()->pluck('LOCALITE');
        $specialites = Doctor::select('SPECIALITE')->distinct()->pluck('SPECIALITE');

        $datatable = new DataTableService();

        $datatable->addColumn('UID');
        $datatable->addColumn('Nom', ['data' => 'FAMNAME']);
        $datatable->addColumn('Prénom', ['data' => 'SHORTNAME']);
        $datatable->addColumn('Spécalité', ['data' => 'SPECIALITE', 'type' => 'select', 'values' => $specialites]);
        $datatable->addColumn('ID.CNAM', ['data' => 'CNAMID']);
        $datatable->addColumn('Gouvern', ['data' => 'GOUVNAME', 'type' => 'select', 'values' => $gouvnames]);
        $datatable->addColumn('Localité', ['data' => 'LOCALITE', 'type' => 'select', 'values' => $localites]);
        $datatable->addColumn('Tél', ['data' => 'TELEPHONE']);
        $datatable->addColumn('Gsm', ['data' => 'GSM']);

        return view('doctors.index', ['datatable' => $datatable, 'gouvnames' => $gouvnames, 'localites' => $localites, 'specialites' => $specialites]);
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

    public function update(Request $request, $RECORD_ID)
    {

        $doctor = Doctor::where('RECORD_ID', $RECORD_ID)
            ->update($request->except('_token', '_method'));

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
