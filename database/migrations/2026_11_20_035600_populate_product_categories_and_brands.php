<?php

use App\Models\Product;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $products = Product::all();

        foreach ($products as $product) {
            $name = strtolower($product->name);

            // Determine accurate Category
            if (str_contains($name, 'degreaser')) {
                $category = 'Degreaser';
            } elseif (str_contains($name, 'thinner')) {
                $category = 'Thinner';
            } elseif (str_contains($name, 'basecoat') || str_contains($name, 'top coat')) {
                $category = 'Basecoat';
            } elseif (str_contains($name, 'hardener')) {
                $category = 'Hardener';
            } elseif (str_contains($name, 'primer') || str_contains($name, 'filler') || str_contains($name, 'putty')) {
                $category = 'Primer';
            } elseif (str_contains($name, 'clear')) {
                $category = 'Clearcoats';
            } else {
                $category = 'Lainnya';
            }

            // Generate SKU if missing
            $sku = $product->sku ?: 'APS-'.strtoupper(substr(md5($product->name . $product->size), 0, 8));

            $product->update([
                'category' => $category,
                'brand' => $product->brand ?: 'Huber',
                'sku' => $sku,
                'unit_per_box' => $product->unit_per_box ?: $product->box_content,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Keep data intact
    }
};
