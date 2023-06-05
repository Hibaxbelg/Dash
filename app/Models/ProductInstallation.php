<?php

namespace App\Models;

use App\Traits\StoreAction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductInstallation extends Model
{
    use HasFactory,StoreAction;

    protected $guarded = [];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id', 'RECORD_ID');
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
