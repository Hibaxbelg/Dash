<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Order;
use App\Models\SoftwareVersion;
use App\Services\DataTableService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index(Request $request)
    {

        $localites = Doctor::select('LOCALITE')->distinct()->pluck('LOCALITE');
        $gouvnames = Doctor::select('gouvname')->distinct()->pluck('gouvname');

        if ($request->ajax()) {

            $table = datatables()->of(
                Order::query()
                    ->with('doctor:RECORD_ID,LOCALITE,GOUVNAME,SPECIALITE,FAMNAME,SHORTNAME,TELEPHONE')
                    ->with('softwareVersion')
                    ->select('id', 'doctor_id', 'software_version_id', 'status', 'date', 'note', 'posts', 'price_with_tax', 'price')
            );

            $table->editColumn('price_with_tax', fn ($row) => $row->price_with_tax . 'DT');

            $table->addColumn('actions', fn ($row) => view('admin.orders.includes.datatable.actions', ['row' => $row]));

            $table->addColumn('status', fn ($row) => view('admin.orders.includes.datatable.status-field', ['row' => $row]));

            return $table->make(true);
        }

        $datatable = new DataTableService([
            ['name' => 'ID', 'data' => 'id'],
            ['name' => 'Nom Client', 'data' => 'doctor.FAMNAME'],
            ['name' => 'Prenom Client', 'data' => 'doctor.SHORTNAME'],
            // ['name' => 'Localité', 'data' => 'doctor.LOCALITE', 'type' => 'select', 'values' => $localites],
            // ['name' => 'GouvName', 'data' => 'doctor.GOUVNAME', 'type' => 'select', 'values' => $gouvnames],
            // ['name' => 'Telephone', 'data' => 'doctor.TELEPHONE'],
            // ['name' => 'Note', 'data' => 'note'],
            // ['name' => 'Date', 'data' => 'date'],
            ['name' => 'Version Programme', 'data' => 'software_version.name'],
            ['name' => 'Nb_Postes', 'data' => 'posts'],
            ['name' => 'Prix', 'data' => 'price_with_tax'],
            ['name' => 'Etat', 'data' => 'status'],
            ['name' => '?', 'data' => 'actions', 'searchable' => false]
        ]);

        return view('admin.orders.index', ['datatable' => $datatable]);
    }

    public function store(Request $request)
    {
        // TODO: move validation to a request class
        $data =  $request->validate([
            'doctor_id' => 'required|exists:doctors,RECORD_ID',
            'software_version_id' => 'required|exists:software_versions,id',
            'date' => 'required|date',
            'note' => 'nullable',
            'posts' => 'required|integer|min:1'
        ]);



        $software =  SoftwareVersion::findOrFail($request->software_version_id);
        $price = $software->price;

        $additional_pc = $request->posts - $software->min_pc_number;

        if ($additional_pc > 0) {
            $price += $additional_pc * $software->price_per_additional_pc;
        }

        $price_with_tax =  $price + ($price * $software->tva) / 100;

        $data['price'] = $price;
        $data['price_with_tax'] = $price_with_tax;

        Order::create($data);

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
