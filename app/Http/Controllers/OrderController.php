<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
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
                        ->select('id', 'doctor_id', 'status', 'date', 'note', 'posts')
                        ->OrderBy('status', 'DESC')
                        ->with('doctor:RECORD_ID,LOCALITE,GOUVNAME,SPECIALITE,FAMNAME,SHORTNAME,TELEPHONE'),
                    $request->columns
                )
            )
                ->make(true);
        }

        $localites = Doctor::select('LOCALITE')->distinct()->pluck('LOCALITE');
        $gouvnames = Doctor::select('gouvname')->distinct()->pluck('gouvname');

        $datatable = new DataTableService();

        $datatable->addColumn('id');
        $datatable->addColumn('Nom Client', ['data' => 'doctor.FAMNAME']);
        $datatable->addColumn('Prenom Client', ['data' => 'doctor.SHORTNAME']);
        $datatable->addColumn('Localité', ['data' => 'doctor.LOCALITE', 'type' => 'select', 'values' => $localites]);
        $datatable->addColumn('GouvName', ['data' => 'doctor.GOUVNAME', 'type' => 'select', 'values' => $gouvnames]);
        $datatable->addColumn('Telephone', ['data' => 'doctor.TELEPHONE']);
        $datatable->addColumn('Note', ['data' => 'note']);
        $datatable->addColumn('Date', ['data' => 'date']);
        $datatable->addColumn('Nb_Postes', ['data' => 'posts']);

        return view('orders.index', ['datatable' => $datatable]);
    }

    public function store(Request $request)
    {
        // TODO: move validation to a request class
        $request->validate([
            'id' => 'required|exists:doctors,RECORD_ID',
            'date' => 'required|date',
            'note' => 'nullable',
            'posts' => 'required|numeric|min:1'
        ]);

        Order::create([
            'doctor_id' => $request->id,
            'date' => $request->date,
            'note' => $request->note,
            'posts' => $request->posts,
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
            'posts' => 'required|numeric|min:1'
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

        if (!Gate::allows('delete-order')) {
            abort(403);
        }

        Order::where('id', $id)->firstOrFail()->delete();

        return redirect()->route('orders.index')
            ->with([
                'message' => 'Commande supprimée avec succès',
                'type' => 'success',
            ]);
    }
}
