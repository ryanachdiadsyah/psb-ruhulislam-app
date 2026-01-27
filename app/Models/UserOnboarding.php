<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserOnboarding extends Model
{
    protected $fillable = [
        'user_id',
        'registration_number',
        'initial_registration_path_id',
        'current_registration_path_id',
        'registration_path_id', // legacy
        'invite_code_used',
        'override_code_used',
        'fee_amount',
        'payment_status',
        'information_source_id',
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

    public static function generateRegistrationNumber()
    {
        $year = date('Y');
        $count = self::whereYear('created_at', $year)->count() + 1;
        return sprintf('%d%04d', $year, $count);
    }

    public function displayPaymentStatus()
    {
        if ($this->payment_status === 'PAID') {
            return 'Lunas';
        }

        if ($this->payment_status === 'UNPAID') {
            return 'Belum Dibayar';
        }

        if ($this->payment_status === 'EXEMPT') {
            return 'Gratis - Tanpa Biaya';
        }
        return "-";
    }

    public function displayPaymentStatusBadge()
    {
        if ($this->payment_status === 'PAID') {
            return '<span class="badge bg-success">Lunas</span>';
        }

        if ($this->payment_status === 'UNPAID') {
            return '<span class="badge bg-danger">Belum Dibayar</span>';
        }

        if ($this->payment_status === 'EXEMPT') {
            return '<span class="badge bg-success">Gratis</span>';
        }

        return "-";
    }
}
