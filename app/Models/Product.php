<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku',
        'name',
        'category',
        'brand',
        'size',
        'color_code',
        'stock',
        'box_content',
        'unit_per_box',
        'selling_price',
        'purchase_price',
        'image',
    ];

    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class);
    }

    public function getCatalogCategoryAttribute(): string
    {
        $category = strtolower($this->category ?: $this->category_from_name);

        if (str_contains($category, 'basecoat') || str_contains($category, 'top coat')) {
            return 'Basecoat & Top Coat';
        }
        if (str_contains($category, 'thinner') || str_contains($category, 'degreaser')) {
            return 'Thinner & Degreaser';
        }
        if (str_contains($category, 'primer') || str_contains($category, 'epoxy') || str_contains($category, 'putty')) {
            return 'Primer & Epoxy';
        }

        return 'Clearcoats & Hardener';
    }

    public function getCatalogSeriesAttribute(): string
    {
        $name = $this->name;
        $knownSeries = [
            'Clear MS 201',
            'Clear GP 101',
            'Clear LC 001',
            'PU Clear Doff',
            'PU Clear Base 2K',
            'PU QS 401',
            'PU Thinner',
            'T200 Basecoat',
            'T200',
            'NC Top Coat',
            'PP Primer',
            'Epoxy Filler EF',
            'Epoxy FD',
            'Epoxy Primer',
            'Epoxy Hardener',
            'Degreaser',
        ];

        foreach ($knownSeries as $series) {
            if (stripos($name, $series) !== false) {
                $brand = $this->brand ?: 'Huber';
                return str_starts_with($series, $brand) ? $series : $brand.' '.$series;
            }
        }

        return $this->brand ?: 'Huber';
    }

    public function getCategoryFromNameAttribute(): string
    {
        $name = strtolower($this->name);

        if (str_contains($name, 'degreaser')) {
            return 'Degreaser';
        }
        if (str_contains($name, 'thinner')) {
            return 'Thinner';
        }
        if (str_contains($name, 'top coat') || str_contains($name, 'basecoat')) {
            return 'Basecoat';
        }
        if (str_contains($name, 'hardener')) {
            return 'Hardener';
        }
        if (str_contains($name, 'primer') || str_contains($name, 'epoxy') || str_contains($name, 'putty') || str_contains($name, 'filler')) {
            return 'Primer';
        }

        return 'Clearcoats';
    }

    public function getBoxesAttribute(): int
    {
        $unitPerBox = $this->unit_per_box ?: $this->box_content;

        return $unitPerBox > 0 ? intdiv((int) $this->stock, $unitPerBox) : 0;
    }

    public function getLowStockAttribute(): bool
    {
        $unitPerBox = $this->unit_per_box ?: $this->box_content;

        return $this->stock > 0 && $this->stock < max(1, $unitPerBox * 2);
    }
}
