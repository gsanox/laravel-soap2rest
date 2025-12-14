<?php

namespace gsanox\Soap2Rest\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'wsdl',
        'operations',
    ];

    protected $casts = [
        'operations' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
