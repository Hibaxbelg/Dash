<?php

namespace App\Traits;

use App\Models\Action;
use Illuminate\Support\Facades\Auth;

trait StoreAction
{
    protected static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            $model->storeAction('create', $model->toArray());
        });

        static::updated(function ($model) {
            $model->storeAction('update', $model->getOriginal());
        });

        static::deleting(function ($model) {
            $model->storeAction('delete', $model->toArray());
        });
    }

    public function storeAction($action, $previousData = null)
    {
        $data = [
            'user_id' => Auth::user()->id,
            'model_type' => get_class($this),
            'model_id' => $this->getKey(),
            'actions' => $action,
            'previous_data' => $previousData ? json_encode($previousData) : null,
        ];

        $this->actions()->create($data);
    }

    public function actions()
    {
        return $this->morphMany(Action::class, 'model');
    }
}
