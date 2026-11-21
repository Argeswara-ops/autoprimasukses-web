<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained('invoices')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products');
            $table->integer('quantity');
            $table->decimal('price', 12, 2);
            $table->decimal('total', 12, 2);
            $table->timestamps();
        });

        // MySQL trigger to decrement stock after insert
        DB::unprepared(
            'CREATE TRIGGER decrement_product_stock AFTER INSERT ON invoice_items FOR EACH ROW 
            BEGIN 
                UPDATE products SET stock = stock - NEW.quantity WHERE id = NEW.product_id; 
            END;'
        );
    }

    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS decrement_product_stock');
        Schema::dropIfExists('invoice_items');
    }
};
