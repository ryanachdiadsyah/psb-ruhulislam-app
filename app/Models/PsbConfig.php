<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PsbConfig extends Model
{
    protected $fillable = [
        'key',
        'value',
        'group',
        'type',
        'is_active'
    ];
}
