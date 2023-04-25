<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users\StoreUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Models\User;
use App\Services\DataTableService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $table = datatables()->of(
                User::query()
                    ->orderBy('id', 'desc')
            );

            $table->addColumn('actions', fn ($row) => view('admin.users.includes.datatable.actions', ['row' => $row]));
            $table->editColumn('avatar', fn ($row) => view('admin.users.includes.datatable.avatar', ['row' => $row]));
            $table->editColumn('is_active', fn ($row) => view('admin.users.includes.datatable.status', ['row' => $row]));
            $table->editColumn('created_at', fn ($row) => $row->created_at?->format('d/m/Y H:i:s'));
            $table->editColumn('updated_at', fn ($row) => $row->updated_at?->format('d/m/Y H:i:s'));
            return $table->make(true);
        }

        $datatable = new DataTableService([
            ['name' => 'ID', 'data' => 'id', 'searchable' => false],
            ['name' => 'Photo', 'data' => 'avatar', 'searchable' => false],
            ['name' => 'Nom', 'data' => 'name'],
            ['name' => 'Email', 'data' => 'email'],
            [
                'name' => 'Role', 'data' => 'role', 'type' => 'select', 'values' => ['admin' => 'admin', 'super-admin' => 'super-admin'],
            ],
            [
                'name' => 'Status', 'data' => 'is_active', 'type' => 'select', 'values' => [
                    '1' => 'Compte Activé',
                    '0' => 'Compte Desactivé',
                ],
            ],
            ['name' => 'Date Creation', 'data' => 'created_at', 'searchable' => false],
            ['name' => 'Date Modification', 'data' => 'updated_at', 'searchable' => false],
            ['name' => 'Action', 'data' => 'actions', 'searchable' => false]
        ]);

        return view('admin.users.index', ['datatable' => $datatable]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        User::create($request->validated());
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        //
    }
}
