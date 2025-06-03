<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Notification extends Model
{
    // Use UUID for primary key
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'to_email',
        'subject',
        'body',
        'type',
        'notifiable_type',
        'notifiable_id',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }
}
