<?php

namespace App\Models;

use App\Traits\StoreAction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory, StoreAction;

    protected $guarded = [];

    protected $casts = [
        'date' => 'datetime',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id', 'RECORD_ID');
    }

    public function productInstallations()
    {
        return $this->hasMany(ProductInstallation::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }
}
