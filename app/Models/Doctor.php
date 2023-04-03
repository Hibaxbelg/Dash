<?php

namespace App\Models;

use App\Traits\StoreAction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory, StoreAction;

    protected $primaryKey = 'RECORD_ID';

    protected $guarded = [];
}
