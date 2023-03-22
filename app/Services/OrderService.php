<?php

namespace App\Services;

use App\Models\Product;

class OrderService
{
    public static $prix_KM = 2;

    public function calculeFraisDeplacement(float $km): float
    {
        return $km * self::$prix_KM;
    }

    public function calculePrixProduct(Product $product, $licenses)
    {
        $price = $product->price;

        $additional_pc = $licenses - $product->min_pc_number;

        if ($additional_pc > 0) {
            $price += $additional_pc * $product->price_per_additional_pc;
        }

        return $price;
    }
}
