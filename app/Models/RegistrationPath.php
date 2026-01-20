<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistrationPath extends Model
{
    protected $fillable = [
        'code',
        'name',
        'requires_invite_code',
        'is_free',
        'is_active',
    ];
}
