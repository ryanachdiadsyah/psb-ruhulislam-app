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

    public function displayStatus(): string
    {
        if ($this->status === 'PAID') {
            return 'Lunas';
        }

        if ($this->items->where('status', 'PAID')->count() > 0) {
            return 'Sebagian Dibayar';
        }

        return 'Belum Dibayar';
    }

    public function remainingAmount(): int
    {
        return $this->total_amount - $this->items
            ->where('status', 'PAID')
            ->sum('amount');
    }

}
