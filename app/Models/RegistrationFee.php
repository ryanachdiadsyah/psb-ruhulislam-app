<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistrationFee extends Model
{
    protected $fillable = [
        'registration_path_id',
        'amount',
        'is_active',
    ];

    public function path()
    {
        return $this->belongsTo(RegistrationPath::class, 'registration_path_id');
    }
}
