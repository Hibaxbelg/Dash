<?php

namespace App\Http\Controllers;

use App\Http\Requests\Clients\StoreClientRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Clients;
use App\Services\DataTableService;
use DataTables;
use Illuminate\Support\Facades\Gate;

class ClientsController extends Controller
{
    //function affiche page index sous dossier clients
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return datatables()->of(DataTableService::makeSearchableBuilder(Clients::query(), $request->columns))
                ->make(true);
        }

        $gouvnames = Clients::select('gouvname')->distinct()->pluck('gouvname');
        $localites = Clients::select('LOCALITE')->distinct()->pluck('LOCALITE');
        $specialites = Clients::select('SPECIALITE')->distinct()->pluck('SPECIALITE');

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

        return view('clients.index', ['datatable' => $datatable, 'gouvnames' => $gouvnames, 'localites' => $localites, 'specialites' => $specialites]);
    }


    public function destroy($RECORD_ID)
    {

        if (!Gate::allows('delete-client')) {
            abort(403);
        }

        Clients::where('RECORD_ID', $RECORD_ID)->delete();

        return redirect()->route('clients.index')
            ->with([
                'message' => 'Client supprimé avec succès',
                'type' => 'success'
            ]);
    }

    public function update(Request $request, $RECORD_ID)
    {

        $client = Clients::where('RECORD_ID', $RECORD_ID)
            ->update($request->except('_token', '_method'));

        return redirect()->route('clients.index')
            ->with([
                'message' => 'Client modifié avec succès',
                'type' => 'success'
            ]);
    }

    public function store(StoreClientRequest $request)
    {

        Clients::create($request->validated());

        return redirect()->route('clients.index')
            ->with([
                'message' => 'Client inseré avec succès',
                'type' => 'success'
            ]);
    }
}
