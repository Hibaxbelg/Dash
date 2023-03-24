<?php

namespace App\Http\Controllers;

use App\Models\Order;
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

        $filename = '';

        $fontsize = 14;
        $fontfamily = Storage::disk('local')->path('fonts/ARIAL.TTF');
        $fontfamilybold = Storage::disk('local')->path('fonts/ARIALBD.TTF');

        if (!$order->product->price_without_promo) {
            $img = Image::make(Storage::disk('local')->path('contacts/default.png'));
        } else {
            $img = Image::make(Storage::disk('local')->path('contacts/default_avec_promo.png'));
        }

        if ($order->payment_by !== $order->doctor->FAMNAME . ' ' . $order->doctor->SHORTNAME) {
            $img->text('OFFERTE PAR LES LABORATOIRES ' . $order->payment_by, 262, 85, function ($font) use ($fontsize, $fontfamily) {
                $font->file($fontfamily);
                $font->size($fontsize + 1);
            });
        }


        $img->text($order->doctor->FAMNAME . ' ' . $order->doctor->SHORTNAME, 112, 156, function ($font) use ($fontsize, $fontfamily) {
            $font->file($fontfamily);
            $font->size($fontsize);
        });

        $img->text($order->product->name, 112, 177, function ($font) use ($fontsize, $fontfamily) {
            $font->file($fontfamily);
            $font->size($fontsize);
        });

        $img->text($order->doctor->ADRESSE, 112, 199, function ($font) use ($fontsize, $fontfamily) {
            $font->file($fontfamily);
            $font->size($fontsize);
        });

        $img->text($order->doctor->GSM, 112, 220, function ($font) use ($fontsize, $fontfamily) {
            $font->file($fontfamily);
            $font->size($fontsize);
        });

        $img->text($order->date->format('d/m/Y'), 720, 158, function ($font) use ($fontsize, $fontfamily) {
            $font->file($fontfamily);
            $font->size($fontsize);
        });

        $img->text($order->licenses, 750, 178, function ($font) use ($fontsize, $fontfamilybold) {
            $font->file($fontfamilybold);
            $font->size($fontsize);
        });

        $img->text($order->doctor->EMAIL, 580, 220, function ($font) use ($fontsize, $fontfamily) {
            $font->file($fontfamily);
            $font->size($fontsize);
        });

        $img->text(str_replace('Medwin', '', $order->product->name), 317, 532, function ($font) use ($fontsize, $fontfamilybold) {
            $font->file($fontfamilybold);
            $font->size($fontsize - 1);
        });

        $img->text($order->product->price_without_promo ? $order->product->price_without_promo : $order->product->price, 437, 532, function ($font) use ($fontsize, $fontfamilybold) {
            $font->file($fontfamilybold);
            $font->size($fontsize);
        });

        if ($order->product->price_without_promo) {
            $img->text($order->product->price, 425, 550, function ($font) use ($fontsize, $fontfamilybold) {
                $font->file($fontfamilybold);
                $font->size($fontsize);
            });
        }

        $filename = 'contacts/' . $order->id . '.jpeg';
        $img->save(Storage::disk('local')->path($filename));

        // return "<img src='storage/{$filename}'>";
        return Storage::disk('local')->download($filename, 'contrat' . $order->id . '.png');
    }
}
