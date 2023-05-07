<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $previousHiddenData = [
        'email_verified_at',
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_confirmed_at',
        'two_factor_recovery_codes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getPreviousDataAttribute()
    {
        $data = json_decode($this->attributes['previous_data']);
        foreach ($this->previousHiddenData as $key) {
            unset($data->$key);
        }
        return $data;
    }
}
