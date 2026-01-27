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
        'payment_proof',
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

    public function displayStatus()
    {
        if ($this->status === 'PAID') {
            return 'Lunas';
        }

        if ($this->status === 'UNPAID') {
            return 'Belum Dibayar';
        }

        if ($this->status === 'WAITING_CONFIRMATION') {
            return 'Menunggu Konfirmasi';
        }
    }

    public function displayStatusBadge()
    {
        if ($this->status === 'PAID') {
            return '<span class="badge bg-success">Lunas</span>';
        }

        if ($this->status === 'UNPAID') {
            return '<span class="badge bg-danger">Belum Dibayar</span>';
        }

        if ($this->status === 'WAITING_CONFIRMATION') {
            return '<span class="badge bg-warning">Menunggu Konfirmasi</span>';
        }
    }
}
