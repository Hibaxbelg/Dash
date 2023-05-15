<?php

namespace App\Http\Controllers;

use App\Http\Requests\Products\StoreProductRequest;
use App\Http\Requests\Products\UpdateProductRequest;
use App\Models\Product;
use App\Services\DataTableService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $table = datatables()::of(Product::query());

            $table->editColumn('price', fn ($row) => $row->price . ' DT');
            $table->editColumn('price_without_promo', fn ($row) => $row->price_without_promo ? $row->price_without_promo . ' DT' : '');
            $table->editColumn('price_per_additional_pc', fn ($row) => $row->price_per_additional_pc . ' DT');

            $table->addColumn('actions', fn ($row) => view('admin.products.includes.datatable.actions', [
                'row' => $row
            ]));

            return $table->make(true);
        }

        $datatable = new DataTableService([
            ['name' => 'Nom', 'data' => 'name'],
            ['name' => 'Min posts', 'data' => 'min_pc_number'],
            ['name' => 'Prix', 'data' => 'price'],
            ['name' => 'Prix Hors Promotion', 'data' => 'price_without_promo'],
            ['name' => 'Prix PC supplémentaire', 'data' => 'price_per_additional_pc'],
            ['name' => 'Action', 'data' => 'actions', 'searchable' => false]
        ]);

        return view('admin.products.index', ['datatable' => $datatable]);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();

        Product::create($validated);

        return redirect()->route('products.index')->with([
            'message' => 'Produit ajouté avec succès',
            'type' => 'success'
        ]);
    }

    public function update(UpdateProductRequest $request, string $id)
    {
        $validated = $request->validated();

        Product::find($id)->update($validated);

        return redirect()->route('products.index')->with([
            'message' => 'Produit modifié avec succès',
            'type' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        Product::find($id)->delete();

        return redirect()->route('products.index')->with([
            'message' => 'Produit supprimé avec succès',
            'type' => 'success'
        ]);
    }
}
