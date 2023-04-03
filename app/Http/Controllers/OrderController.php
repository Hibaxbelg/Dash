<?php

namespace App\Http\Controllers;

use App\Http\Requests\Orders\StoreOrderRequest;
use App\Http\Requests\Orders\UpdateOrderRequest;
use App\Models\Doctor;
use App\Models\Order;
use App\Models\Product;
use App\Models\SoftwareVersion;
use App\Models\User;
use App\Services\DataTableService;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function __construct(private OrderService $orderService)
    {
    }

    public function index(Request $request)
    {
        $localites = Doctor::select('LOCALITE')->distinct()->pluck('LOCALITE');
        $gouvnames = Doctor::select('gouvname')->distinct()->pluck('gouvname');
        $users = User::all();
        $products = Product::all();

        if ($request->ajax()) {

            $table = datatables()->of(
                Order::query()
                    ->with('doctor:RECORD_ID,LOCALITE,GOUVNAME,SPECIALITE,FAMNAME,SHORTNAME,TELEPHONE')
                    ->with('product')
                    ->select('id', 'doctor_id', 'qualite', 'formation', 'formateur', 'product_id', 'status', 'date', 'note', 'licenses', 'price', 'dep_price', 'user_id', 'os', 'distance', 'payment_by')
                    ->orderBy('status', 'desc')
            );

            $table->addColumn('actions', fn ($row) => view('admin.orders.includes.datatable.actions', [
                'row' => $row,
                'users' => $users,
                'gouvnames' => $gouvnames,
                'products' => $products,
            ]));

            $table->addColumn('status', fn ($row) => view('admin.orders.includes.datatable.status-field', ['row' => $row]));

            $table->editColumn('price', fn ($row) => $row->price + $row->dep_price . ' DT');

            return $table->make(true);
        }

        $datatable = new DataTableService([
            ['name' => 'ID', 'data' => 'id'],
            ['name' => 'Nom Client', 'data' => 'doctor.FAMNAME'],
            ['name' => 'Prenom Client', 'data' => 'doctor.SHORTNAME'],
            ['name' => 'Localité', 'data' => 'doctor.LOCALITE', 'type' => 'select', 'values' => $localites, 'visible' => false],
            ['name' => 'GouvName', 'data' => 'doctor.GOUVNAME', 'type' => 'select', 'values' => $gouvnames, 'visible' => false],
            ['name' => 'Telephone', 'data' => 'doctor.TELEPHONE', 'visible' => false],
            ['name' => 'Note', 'data' => 'note', 'visible' => false],
            ['name' => 'Date', 'data' => 'date'],
            ['name' => 'Produit', 'data' => 'product.name'],
            ['name' => 'Licences', 'data' => 'licenses'],
            ['name' => 'Prix', 'data' => 'price'],
            ['name' => 'Etat', 'data' => 'status', 'searchable' => false, 'type' => 'select', 'values' => ['En attente', 'En cours', 'Terminé', 'Annulé']],
            ['name' => '?', 'data' => 'actions', 'searchable' => false]
        ]);

        return view('admin.orders.index', ['datatable' => $datatable, 'products' => $products, 'prix_KM' => $this->orderService::$prix_KM]);
    }

    public function store(StoreOrderRequest $request)
    {
        $data = $request->safe()->merge([
            'date' => $request->date . ' ' . $request->time,
            'price' => $this->orderService->calculePrixProduct(Product::find($request->product_id), $request->licenses),
            'dep_price' => $this->orderService->calculeFraisDeplacement($request->distance),
        ])->collect()->forget('time')->toArray();


        $order = Order::create($data);

        return redirect()->route('orders.index')
            ->with([
                'message' => 'Commande ajoutée avec succès',
                'type' => 'success',
            ]);
    }

    public function update(UpdateOrderRequest $request, $id)
    {
        $data = $request->safe()->merge([
            'date' => $request->date . ' ' . $request->time,
            'price' => $this->orderService->calculePrixProduct(Product::find($request->product_id), $request->licenses),
            'dep_price' => $this->orderService->calculeFraisDeplacement($request->distance),
        ])->collect()->forget('time')->toArray();

        $order = Order::find($id)->update($data);
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
