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
        Schema::table('invoices', function (Blueprint $table) {
            $table->time('invoice_time')->nullable()->after('invoice_date');
        });

        DB::table('invoices')
            ->whereNull('invoice_time')
            ->orderBy('id')
            ->eachById(function (object $invoice): void {
                $time = $invoice->created_at
                    ? substr((string) $invoice->created_at, 11, 5)
                    : '09:00';

                DB::table('invoices')
                    ->where('id', $invoice->id)
                    ->update(['invoice_time' => $time]);
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn('invoice_time');
        });
    }
};
