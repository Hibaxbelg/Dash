<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Services\DataTableService;
use Illuminate\Http\Request;

class ActionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $table = datatables()->of(
                Action::query()->with('user:id,name')->orderBy('id', 'desc')
            );

            $table->addColumn('actions', fn ($row) => view('admin.actions.includes.show', [
                'row' => $row
            ]));

            $table->editColumn('action', fn ($row) => view('admin.actions.includes.action', ['row' => $row]));
            $table->editColumn('created_at', fn ($row) => $row->created_at->format('d/m/Y H:i:s'));

            return $table->make(true);
        }

        $datatable = new DataTableService([
            ['name' => 'ID', 'data' => 'id'],
            ['name' => 'L\'utilisateur', 'data' => 'user.name'],
            ['name' => 'Resource', 'data' => 'model_type'],
            [
                'name' => 'Type Action', 'data' => 'action', 'type' => 'select', 'values' => [
                    'create' => 'Ajout',
                    'update' => 'Modification',
                    'delete' => 'Suppression'
                ],
            ],
            ['name' => 'Date', 'data' => 'created_at'],
            ['name' => 'Les Détails', 'data' => 'actions', 'searchable' => false],
        ]);

        return view('admin.actions.index', ['datatable' => $datatable]);
    }
}
