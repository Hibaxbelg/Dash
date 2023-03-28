<?php

namespace App\Services;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

enum Fonts
{
    case ARIAL;
    case ARIALBD;
}

class ImageService
{
    private $img;

    private $fonts = [];

    public function __construct($img)
    {
        $this->img = Image::make($img);

        foreach (Fonts::cases() as $font) {
            $this->fonts[$font->name] = Storage::disk('local')->path('fonts/' . $font->name . '.TTF');
        }
    }

    public function text($text, $x, $y, $fontSize, Fonts $font = Fonts::ARIAL, bool $show = true)
    {
        if (!$show) {
            return;
        }
        $this->img->text($text, $x, $y, function ($e) use ($font, $fontSize) {
            $e->file($this->fonts[$font->name]);
            $e->size($fontSize);
        });
    }

    public function save($filename)
    {
        $this->img->save(Storage::disk('local')->path($filename));
    }
}
