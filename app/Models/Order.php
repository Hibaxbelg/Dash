<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id', 'RECORD_ID');
    }
}
