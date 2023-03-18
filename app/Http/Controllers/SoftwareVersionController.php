<?php

namespace App\Http\Controllers;

use App\Http\Requests\SoftwareVersions\StoreSoftwareVersionRequest;
use App\Http\Requests\SoftwareVersions\UpdateSoftwareVersionRequest;
use App\Models\SoftwareVersion;
use App\Services\DataTableService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SoftwareVersionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $table = datatables()::of(SoftwareVersion::query());

            $table->editColumn('price', fn ($row) => $row->price . ' DT');
            $table->editColumn('price_per_additional_pc', fn ($row) => $row->price_per_additional_pc . ' DT');
            $table->editColumn('tva', fn ($row) => $row->tva . '%');

            $table->addColumn('actions', fn ($row) => view('admin.softwareVersions.includes.datatable.actions', [
                'row' => $row
            ]));

            return $table->make(true);
        }

        $datatable = new DataTableService([
            ['name' => 'Nom Verions', 'data' => 'name'],
            ['name' => 'Min posts', 'data' => 'min_pc_number'],
            ['name' => 'Prix', 'data' => 'price'],
            ['name' => 'Prix PC supplémentaire', 'data' => 'price_per_additional_pc'],
            ['name' => 'TVA', 'data' => 'tva'],
            ['name' => '?', 'data' => 'actions', 'searchable' => false]
        ]);

        return view('admin.softwareVersions.index', ['datatable' => $datatable]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSoftwareVersionRequest $request)
    {
        $validated = $request->validated();

        SoftwareVersion::create($validated);

        return redirect()->route('softwareVersions.index')->with([
            'message' => 'Version ajoutée avec succès',
            'type' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): Response
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): Response
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSoftwareVersionRequest $request, string $id): RedirectResponse
    {
        $validated = $request->validated();

        SoftwareVersion::where('id', $id)->update($validated);

        return redirect()->route('softwareVersions.index')->with([
            'message' => 'Version modifiée avec succès',
            'type' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        SoftwareVersion::where('id', $id)->delete();

        return redirect()->route('softwareVersions.index')->with([
            'message' => 'Version supprimée avec succès',
            'type' => 'success'
        ]);
    }
}
