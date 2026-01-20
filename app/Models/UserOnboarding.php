<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserOnboarding extends Model
{
    protected $fillable = [
        'user_id',
        'registration_path_id',
        'information_source_id',
        'invite_code_used',
        'override_code_used',
        'fee_amount',
        'completed_at',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
    ];

    public function initialPath()
    {
        return $this->belongsTo(RegistrationPath::class, 'initial_registration_path_id');
    }

    public function currentPath()
    {
        return $this->belongsTo(RegistrationPath::class, 'current_registration_path_id');
    }

}
