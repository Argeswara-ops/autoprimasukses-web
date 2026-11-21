<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS decrement_product_stock');

        Schema::table('products', function (Blueprint $table) {
            $table->string('sku', 50)->nullable()->unique()->after('id');
            $table->string('category', 100)->nullable()->after('name');
            $table->string('brand', 100)->nullable()->after('category');
            $table->string('color_code', 100)->nullable()->after('size');
            $table->integer('unit_per_box')->nullable()->after('box_content');
            $table->string('image')->nullable()->after('purchase_price');
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->string('invoice_number', 30)->nullable()->unique()->after('id');
            $table->string('customer_address')->nullable()->after('customer_name');
            $table->string('customer_phone', 30)->nullable()->after('customer_address');
            $table->date('transaction_date')->nullable()->after('invoice_date');
            $table->string('status', 20)->default('Belum Lunas')->after('total');
            $table->text('notes')->nullable()->after('status');
            $table->decimal('discount', 12, 2)->default(0)->after('subtotal');
            $table->decimal('tax_ppn', 12, 2)->default(0)->after('discount');
            $table->decimal('grand_total', 12, 2)->default(0)->after('tax_ppn');
        });

        Schema::table('purchase_orders', function (Blueprint $table) {
            $table->string('po_number', 30)->nullable()->unique()->after('id');
            $table->string('area', 100)->default('Jawa Timur')->after('po_number');
            $table->integer('current_stock')->default(0)->after('area');
            $table->integer('avg_monthly_sales')->nullable()->after('current_stock');
            $table->integer('suggest_po_box')->default(0)->after('avg_monthly_sales');
            $table->integer('unit_per_box')->default(1)->after('suggest_po_box');
            $table->decimal('unit_price', 12, 2)->default(0)->after('unit_per_box');
            $table->decimal('total_amount', 12, 2)->default(0)->after('unit_price');
            $table->string('status', 20)->default('Draft')->after('total_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchase_orders', function (Blueprint $table) {
            $table->dropUnique(['po_number']);
            $table->dropColumn([
                'po_number', 'area', 'current_stock', 'avg_monthly_sales',
                'suggest_po_box', 'unit_per_box', 'unit_price', 'total_amount', 'status',
            ]);
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->dropUnique(['invoice_number']);
            $table->dropColumn([
                'invoice_number', 'customer_address', 'customer_phone',
                'transaction_date', 'status', 'notes', 'discount', 'tax_ppn', 'grand_total',
            ]);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropUnique(['sku']);
            $table->dropColumn([
                'sku', 'category', 'brand', 'color_code', 'unit_per_box', 'image',
            ]);
        });
    }
};
