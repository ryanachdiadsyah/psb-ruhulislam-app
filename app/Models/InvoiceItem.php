<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    protected $fillable = [
        'invoice_id',
        'label',
        'amount',
        'due_date',
        'status',
        'payment_method',
        'payment_channel',
        'paid_at',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function isPaid(): bool
    {
        return $this->status === 'PAID';
    }

    public function isManual(): bool
    {
        return $this->payment_method === 'MANUAL';
    }
}
