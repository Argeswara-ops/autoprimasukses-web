<?php

namespace Tests\Feature;

use App\Models\Invoice;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvoiceTransactionTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_b2b_invoice_and_deduct_stock(): void
    {
        $user = User::factory()->create();
        $product = Product::create([
            'sku' => 'SKU-001',
            'name' => 'Huber Clear LC 001',
            'size' => '0.8 Lt',
            'stock' => 20,
            'box_content' => 6,
            'selling_price' => 66000,
            'purchase_price' => 50000,
        ]);

        $response = $this->actingAs($user)->post(route('invoices.store'), [
            'customer_name' => 'Bengkel Mobil Sentosa',
            'customer_address' => 'Jl. Basuki Rahmat No. 12 Surabaya',
            'customer_phone' => '081234567890',
            'transaction_date' => now()->toDateString(),
            'due_date' => now()->addDays(30)->toDateString(),
            'sales_person' => 'Budi Santoso',
            'payment_method' => 'Transfer Bank (BCA)',
            'status' => 'Belum Lunas',
            'discount' => 10000,
            'items' => [
                [
                    'product_id' => $product->id,
                    'quantity' => 5,
                    'price' => 66000,
                ],
            ],
        ]);

        $invoice = Invoice::where('customer_name', 'Bengkel Mobil Sentosa')->first();
        $this->assertNotNull($invoice);
        $response->assertRedirect(route('invoices.show', $invoice));

        $this->assertDatabaseHas('invoices', [
            'id' => $invoice->id,
            'customer_name' => 'Bengkel Mobil Sentosa',
            'sales_person' => 'Budi Santoso',
            'status' => 'Belum Lunas',
        ]);

        // Stock should be reduced by 5
        $this->assertEquals(15, $product->fresh()->stock);

        // Subtotal = 5 * 66000 = 330000. DPP = 330000 - 10000 = 320000. Tax 11% = 35200. Grand total = 355200
        $this->assertEquals(330000, (float) $invoice->subtotal);
        $this->assertEquals(355200, (float) $invoice->grand_total);
    }

    public function test_admin_can_mark_invoice_as_paid(): void
    {
        $user = User::factory()->create();
        $invoice = Invoice::create([
            'invoice_number' => 'APS-INV-202611-999',
            'customer_name' => 'Toko Cat Jaya',
            'transaction_date' => now()->toDateString(),
            'due_date' => now()->addDays(14)->toDateString(),
            'status' => 'Belum Lunas',
            'subtotal' => 100000,
            'grand_total' => 111000,
        ]);

        $response = $this->actingAs($user)->patch(route('invoices.pay', $invoice), [
            'payment_method' => 'Transfer Bank (BCA)',
        ]);

        $response->assertRedirect();
        $this->assertEquals('Lunas', $invoice->fresh()->status);
        $this->assertNotNull($invoice->fresh()->payment_date);
    }

    public function test_admin_can_view_invoice_index_and_print_views(): void
    {
        $user = User::factory()->create();
        $product = Product::create([
            'name' => 'Huber Epoxy Primer',
            'size' => '0.8 Lt',
            'stock' => 10,
            'box_content' => 6,
            'selling_price' => 71000,
            'purchase_price' => 60000,
        ]);

        $invoice = Invoice::create([
            'invoice_number' => 'APS-INV-202611-001',
            'customer_name' => 'Body Repair Auto',
            'transaction_date' => now()->toDateString(),
            'due_date' => now()->addDays(30)->toDateString(),
            'status' => 'Belum Lunas',
            'subtotal' => 71000,
            'grand_total' => 78810,
        ]);

        $invoice->items()->create([
            'product_id' => $product->id,
            'quantity' => 1,
            'price' => 71000,
            'total' => 71000,
        ]);

        // Index
        $indexResponse = $this->actingAs($user)->get(route('invoices.index'));
        $indexResponse->assertOk();
        $indexResponse->assertSee('Body Repair Auto');
        $indexResponse->assertSee('Faktur & Invoice Penjualan', false);

        // Show
        $showResponse = $this->actingAs($user)->get(route('invoices.show', $invoice));
        $showResponse->assertOk();
        $showResponse->assertSee('PT AUTO PRIMA SUKSES');

        // Print Commercial Invoice
        $printResponse = $this->actingAs($user)->get(route('invoices.print', $invoice));
        $printResponse->assertOk();
        $printResponse->assertSee('FAKTUR PENJUALAN (SALES INVOICE)');

        // Delivery Order (Surat Jalan)
        $doResponse = $this->actingAs($user)->get(route('invoices.delivery_order', $invoice));
        $doResponse->assertOk();
        $doResponse->assertSee('SURAT JALAN / DELIVERY ORDER');
    }
}
