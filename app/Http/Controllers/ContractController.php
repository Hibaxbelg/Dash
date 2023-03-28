<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\Fonts;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class ContractController extends Controller
{
    public function __construct()
    {
        if (!extension_loaded('gd')) {
            dd('GD is not loaded');
        }
    }

    public function store(Request $request)
    {
        $order =  Order::with('doctor', 'product')
            ->where('id', $request->order_id)
            ->firstOrFail();


        if (!$order->product->price_without_promo) {
            $default = 'contacts/default.png';
        } else {
            $default = 'contacts/default_avec_promo.png';
        }

        $img = new ImageService(Storage::disk('local')->path($default));

        $img->text('OFFERTE PAR LES LABORATOIRES ' . $order->payment_by, 262, 85, 15, Fonts::ARIAL, $order->payment_by !== $order->doctor->FAMNAME . ' ' . $order->doctor->SHORTNAME);
        $img->text($order->doctor->FAMNAME . ' ' . $order->doctor->SHORTNAME, 112, 156, 14, Fonts::ARIAL);
        $img->text($order->product->name, 112, 177, 14, Fonts::ARIAL);
        $img->text($order->doctor->ADRESSE, 112, 199, 14, Fonts::ARIAL);
        $img->text($order->doctor->GSM, 112, 220, 14, Fonts::ARIAL);
        $img->text($order->date->format('d/m/Y'), 720, 158, 14, Fonts::ARIAL);
        $img->text($order->licenses, 750, 178, 14, Fonts::ARIALBD);
        $img->text($order->doctor->EMAIL, 580, 220, 14, Fonts::ARIAL);
        $img->text(str_replace('Medwin', '', $order->product->name), 317, 532, 13, Fonts::ARIALBD);
        $img->text($order->product->price_without_promo ? $order->product->price_without_promo : $order->product->price, 437, 532, 14, Fonts::ARIALBD);
        $img->text($order->product->price, 425, 550, 14, Fonts::ARIALBD, $order->product->price_without_promo != null);


        $filename = 'contacts/' . $order->id . '.jpeg';
        $img->save($filename);

        // return "<img src='storage/{$filename}'>";
        return Storage::disk('local')->download($filename, 'contrat' . $order->id . '.png');
    }
}
