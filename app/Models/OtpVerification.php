<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtpVerification extends Model
{
    protected $fillable = [
        'user_id',
        'channel',
        'purpose',
        'code',
        'expires_at',
        'attempts',
    ];
}
