<?php

namespace App\Models;

use App\Traits\StoreAction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reclamation extends Model
{
    use HasFactory,StoreAction;

    protected $fillable = ['objet','user_id','description','solution'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }
}
