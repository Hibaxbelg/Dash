<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\Fonts;
use App\Services\ImageService;
use App\Services\Status;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class BonDeCommandeController extends Controller
{
    public function download($id)
    {
        $order =  Order::with('doctor', 'product')
            ->where('id', $id)
            ->firstOrFail();

        $img = new ImageService(Storage::disk('local')->path('bon-de-commandes/default.png'));
        $img->text("{$order->id} / {$order->date->format('Y')}", 538, 57, 40, Fonts::ARIALBD);
        $img->text(number_format($order->price + $order->dep_price, 2, '.', ''), 1300, 57, 40, Fonts::ARIALBD);

        $img->text($order->created_at->format('d. m .Y'), 195, 125, 25, Fonts::ARIAL);
        $img->text($order->created_at->format('d. m .Y'), 195, 165, 25, Fonts::ARIAL);

        $img->text($order->doctor->FAMNAME . ' ' . $order->doctor->SHORTNAME, 255, 285, 50, Fonts::ARIALBD);
        $img->text($order->doctor->CNAMID, 1125, 275, 25, Fonts::ARIAL);
        $img->text($order->doctor->SPECIALITE, 255, 327, 25, Fonts::ARIAL);
        $img->text($order->doctor->GOUVNAME, 255, 368, 25, Fonts::ARIAL);
        $img->text($order->doctor->LOCALITE, 662, 368, 25, Fonts::ARIAL);
        $img->text($order->doctor->ADRESSE, 255, 408, 25, Fonts::ARIAL);
        $img->text($order->doctor->TELEPHONE, 625, 455, 25, Fonts::ARIAL);
        $img->text($order->doctor->GSM, 255, 452, 25, Fonts::ARIAL);
        $img->text($order->date->format('d-m-Y'), 255, 500, 25, Fonts::ARIAL);
        $img->text($order->date->format('H:s'), 1174, 500, 25, Fonts::ARIAL);

        // type produit

        switch ($order->product->id) {
            case 1;
                $img->text('X', 45, 750, 30, Fonts::ARIALBD);
                break;
            case 2;
                $img->text('X', 352, 790, 30, Fonts::ARIALBD);
                break;
            case 3:
                $img->text('X', 352, 647, 30, Fonts::ARIALBD);
                break;
            case 4:
                $img->text('X', 45, 687, 30, Fonts::ARIALBD);
                break;
            default:
        }

        // OS
        switch ($order->os) {
            case 'Windows XP':
                $img->text('X', 901, 640, 30, Fonts::ARIALBD);
                break;
            case 'Windows 7':
                $img->text('X', 901, 677, 30, Fonts::ARIALBD);
                break;
            case 'Windows 8':
                $img->text('X', 901, 713, 30, Fonts::ARIALBD);
                break;
            case 'Windows 10':
                $img->text('X', 901, 750, 30, Fonts::ARIALBD);
                break;
            default:
        }

        $img->text($order->distance . ' KM', 250, 937, 30, Fonts::ARIALBD);
        $img->text(number_format($order->price, 2, '.', ''), 250, 980, 30, Fonts::ARIALBD);
        $img->text(number_format($order->dep_price, 2, '.', ''), 990, 980, 30, Fonts::ARIALBD);
        $img->text(number_format($order->price + $order->dep_price, 2, '.', ''), 1370, 980, 30, Fonts::ARIALBD);

        // formateur
        $img->text($order->formateur, 330, 1186, 25, Fonts::ARIAL);
        $img->text($order->licenses, 1000, 1135, 35, Fonts::ARIALBD);
        $img->text('X', 1370, 1135, 30, Fonts::ARIALBD, $order->status == 'installed');
        $img->text('X', 1470, 1135, 30, Fonts::ARIALBD, $order->status !== 'installed');


        // element de la formation

        $formations = json_decode($order->formation ?? '[]');

        $img->text('X', 55, 1435, 30, Fonts::ARIALBD, in_array('1', $formations));
        $img->text('X', 55, 1475, 30, Fonts::ARIALBD, in_array('2', $formations));
        $img->text('X', 55, 1510, 30, Fonts::ARIALBD, in_array('3', $formations));
        $img->text('X', 55, 1545, 30, Fonts::ARIALBD, in_array('4', $formations));
        $img->text('X', 55, 1585, 30, Fonts::ARIALBD, in_array('5', $formations));

        $img->text('X', 957, 1435, 30, Fonts::ARIALBD, in_array('6', $formations));
        $img->text('X', 957, 1475, 30, Fonts::ARIALBD, in_array('7', $formations));
        $img->text('X', 957, 1510, 30, Fonts::ARIALBD, in_array('8', $formations));
        $img->text('X', 957, 1545, 30, Fonts::ARIALBD, in_array('9', $formations));
        $img->text('X', 957, 1585, 30, Fonts::ARIALBD, in_array('10', $formations));


        // qualite +60

        $img->text('X', 165, 1985, 30, Fonts::ARIALBD, $order->qualite == 1);
        $img->text('X', 165, 2025, 30, Fonts::ARIALBD, $order->qualite == 2);
        $img->text('X', 165, 2060, 30, Fonts::ARIALBD, $order->qualite == 3);
        $img->text('X', 165, 2095, 30, Fonts::ARIALBD, $order->qualite == 4);

        $filename = 'bon-de-commandes/' . $order->id . '.png';
        $img->save($filename);

        // return "<img src='../storage/$filename' />";
        return Storage::disk('local')->download($filename, 'bon-de-commande' . $order->id . '.png');
    }
}
