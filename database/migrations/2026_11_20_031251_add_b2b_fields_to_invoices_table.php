<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->date('due_date')->nullable()->after('transaction_date');
            $table->string('payment_method', 50)->nullable()->default('Transfer Bank')->after('status');
            $table->date('payment_date')->nullable()->after('payment_method');
            $table->string('sales_person', 100)->nullable()->after('payment_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn(['due_date', 'payment_method', 'payment_date', 'sales_person']);
        });
    }
};
