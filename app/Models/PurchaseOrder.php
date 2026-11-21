<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'po_number',
        'area',
        'product_id',
        'current_stock',
        'average_monthly_sales',
        'avg_monthly_sales',
        'suggested_boxes',
        'suggest_po_box',
        'unit_per_box',
        'unit_price',
        'total_estimated_cost',
        'total_amount',
        'status',
        'calculated_at',
    ];

    protected $casts = [
        'calculated_at' => 'date',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
