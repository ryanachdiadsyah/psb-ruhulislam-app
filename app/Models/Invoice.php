<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'user_id',
        'code',
        'title',
        'total_amount',
        'due_date',
        'status',
    ];

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function isPaid(): bool
    {
        return $this->status === 'PAID';
    }

    public function displayStatus()
    {
        if ($this->status === 'PAID') {
            return 'Lunas';
        }

        if ($this->status === 'UNPAID') {
            return 'Belum Dibayar';
        }

        if ($this->status === 'PARTIAL' && $this->items->where('status', 'PAID')->count() > 0) {
            return 'Sebagian Dibayar';
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

        if ($this->status === 'PARTIAL' && $this->items->where('status', 'PAID')->count() > 0) {
            return '<span class="badge bg-warning">Sebagian Dibayar</span>';
        }
    }

    

    public function remainingAmount(): int
    {
        return $this->total_amount - $this->items
            ->where('status', 'PAID')
            ->sum('amount');
    }

}
