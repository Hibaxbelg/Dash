<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use App\Models\Command;
use App\Services\DataTableService;
use Illuminate\Http\Request;

class CommandController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return datatables()->of(
                DataTableService::makeSearchableBuilder(
                    Command::query()
                        ->select('id', 'clients_id', 'status', 'date', 'note')
                        ->OrderBy('status', 'DESC')
                        ->with('client:RECORD_ID,LOCALITE,GOUVNAME,SPECIALITE,FAMNAME,SHORTNAME,TELEPHONE'),
                    $request->columns
                )
            )
                ->make(true);
        }

        $localites = Clients::select('LOCALITE')->distinct()->pluck('LOCALITE');
        $gouvnames = Clients::select('gouvname')->distinct()->pluck('gouvname');

        $datatable = new DataTableService();

        $datatable->addColumn('id');
        $datatable->addColumn('Nom Client', ['data' => 'client.FAMNAME']);
        $datatable->addColumn('Prenom Client', ['data' => 'client.SHORTNAME']);
        $datatable->addColumn('Localité', ['data' => 'client.LOCALITE', 'type' => 'select', 'values' => $localites]);
        $datatable->addColumn('GouvName', ['data' => 'client.GOUVNAME', 'type' => 'select', 'values' => $gouvnames]);
        $datatable->addColumn('Telephone', ['data' => 'client.TELEPHONE']);
        $datatable->addColumn('Note', ['data' => 'note']);
        $datatable->addColumn('Date', ['data' => 'date']);
        // $datatable->addColumn('Date Creation', ['data' => 'created_at']);

        // $datatable->addColumn('Nom', ['data' => 'FAMNAME']);


        return view('commandes.index', ['datatable' => $datatable]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:mainmedlist,RECORD_ID',
            'date' => 'required',
            'note' => 'nullable'
        ]);

        Command::create([
            'clients_id' => $request->id,
            'date' => $request->date,
            'note' => $request->note
        ]);

        return redirect()->route('clients.commandes.index');
    }
}
