<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'customer_name',
        'customer_address',
        'customer_phone',
        'invoice_date',
        'invoice_time',
        'transaction_date',
        'due_date',
        'subtotal',
        'discount',
        'tax_ppn',
        'tax',
        'total',
        'grand_total',
        'status',
        'payment_method',
        'payment_date',
        'sales_person',
        'notes',
    ];

    protected $casts = [
        'invoice_date' => 'date',
        'transaction_date' => 'date',
        'due_date' => 'date',
        'payment_date' => 'date',
    ];

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    protected static function booted(): void
    {
        static::creating(function (Invoice $invoice) {
            if (! $invoice->invoice_date && $invoice->transaction_date) {
                $invoice->invoice_date = $invoice->transaction_date;
            } elseif (! $invoice->transaction_date && $invoice->invoice_date) {
                $invoice->transaction_date = $invoice->invoice_date;
            } elseif (! $invoice->invoice_date && ! $invoice->transaction_date) {
                $invoice->invoice_date = now()->toDateString();
                $invoice->transaction_date = now()->toDateString();
            }
        });
    }

    public function getIsOverdueAttribute(): bool
    {
        if ($this->status === 'Lunas') {
            return false;
        }

        $due = $this->due_date ?? $this->transaction_date ?? $this->invoice_date;

        return $due && $due->isPast();
    }
}
