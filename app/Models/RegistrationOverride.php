<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistrationOverride extends Model
{
    protected $fillable = [
        'code',
        'allowed_paths',
        'expires_at',
        'used_at',
        'used_by_user_id',
        'is_active',
    ];

    protected $casts = [
        'allowed_paths' => 'array',
        'expires_at' => 'datetime',
        'used_at' => 'datetime',
    ];
}
