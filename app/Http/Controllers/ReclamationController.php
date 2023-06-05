<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Doctor;
use Illuminate\Http\Request;
use App\Http\Requests\Reclamations\StoreReclamationRequest;
use App\Http\Requests\Reclamations\UpdateReclamationRequest;
use App\Models\Reclamation;
use App\Services\DataTableService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class ReclamationController extends Controller
{
    //

    public function index(Request $request)
    {
        $users = User::all();

        if ($request->ajax()) {

            $table = datatables()::of(Reclamation::query()
            ->orderBy('status', 'desc')
        );

            $table->addColumn('actions', fn ($row) => view('admin.reclamations.includes.datatable.actions', [
                'row' => $row,
                'users' => $users,
            ]));
            $table->editColumn('created_at', fn ($row) => $row->created_at?->format('d/m/Y H:i:s'));
            $table->addColumn('status', fn ($row) => view('admin.reclamations.includes.datatable.status-field', ['row' => $row]));
            return $table->make(true);
        }

        $datatable = new DataTableService([
            ['name' => 'id', 'data' => 'id','searchable' => false],
            ['name' => 'CNAMID', 'data' => 'cnamId'],
            ['name' => 'objet', 'data' => 'objet'],
            ['name' => 'solution', 'data' => 'solution','searchable' => false,'visible' => false],
            ['name' => 'description', 'data' => 'description','searchable' => false, 'visible' => false],
            ['name' => 'Etat', 'data' => 'status', 'searchable' => false, 'type' => 'select', 'values' => ['résolue', 'en attente', 'fermée']],
            ['name' => 'Date', 'data' => 'created_at'],
            ['name' => 'Action', 'data' => 'actions', 'searchable' => false]
        ]);

        return view('admin.reclamations.index', ['datatable' => $datatable]);
    }

    public function store(StoreReclamationRequest $request)
    {

        Reclamation::create($request->validated());

        return redirect()->route('reclamations.index')
            ->with([
                'message' => 'Réclamation ajoutée avec succès',
                'type' => 'success'
            ]);
    }

    public function destroy($id, Request $request)
    {

        Reclamation::where('id', $id)->firstOrFail()->delete();

        return redirect()->route('reclamations.index')
            ->with([
                'message' => 'Réclamation supprimée avec succès',
                'type' => 'success',
            ]);
    }

    public function update(UpdateReclamationRequest $request, string $id)
    {
        $validated = $request->validated();

        Reclamation::find($id)->update($validated);

        return redirect()->route('reclamations.index')->with([
            'message' => 'réclamation modifiée avec succès',
            'type' => 'success'
        ]);
    }
}
