<?php

namespace App\Models;

use App\Traits\StoreAction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, StoreAction;

    protected $guarded = [];

    protected $casts = [
        'date' => 'datetime',
    ];
}
