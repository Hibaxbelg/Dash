<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use App\Models\Order;
use App\Services\DataTableService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return datatables()->of(
                DataTableService::makeSearchableBuilder(
                    Order::query()
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

        return view('orders.index', ['datatable' => $datatable]);
    }

    public function store(Request $request)
    {
        // TODO: move validation to a request class
        $request->validate([
            'id' => 'required|exists:mainmedlist,RECORD_ID',
            'date' => 'required|date',
            'note' => 'nullable',
        ]);

        Order::create([
            'clients_id' => $request->id,
            'date' => $request->date,
            'note' => $request->note,
        ]);

        return redirect()->route('orders.index')
            ->with([
                'message' => 'Commande ajoutée avec succès',
                'type' => 'success',
            ]);
    }

    public function update(Request $request, $id)
    {
        // TODO: move validation to a request class
        $validator = Validator::make($request->all(), [
            'status' => 'required',
            'date' => 'date',
            'note' => 'nullable',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->with([
                    'modal' => 'order-edit-' . $id . '-modal',
                ]);
        }

        Order::where('id', $id)->firstOrFail()->update([
            'status' => $request->status,
            'date' => $request->date,
            'note' => $request->note,
        ]);

        return redirect()->route('orders.index')
            ->with([
                'message' => 'Commande modifiée avec succès',
                'type' => 'success',
            ]);
    }

    public function destroy($id, Request $request)
    {

        Order::where('id', $id)->firstOrFail()->delete();

        return redirect()->route('orders.index')
            ->with([
                'message' => 'Commande supprimée avec succès',
                'type' => 'success',
            ]);
    }
}
