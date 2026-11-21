<?php

namespace Tests\Feature;

use App\Models\Invoice;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_profile_is_available_without_admin_links(): void
    {
        Product::create([
            'name' => 'Huber Clear GP 101',
            'size' => '0.8 Lt',
            'stock' => 0,
            'box_content' => 6,
            'selling_price' => 80000,
            'purchase_price' => 80000,
        ]);

        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('CONNECTING BUSINESS');
        $response->assertDontSee('Suggest PO');
        $response->assertDontSee('Login Admin');

        $catalog = $this->get('/katalog');
        $catalog->assertOk();
        $catalog->assertSee('Huber Clear GP 101');
        $catalog->assertSee('0.8 Lt');
        $catalog->assertDontSee('Login Admin');
    }

    public function test_admin_pages_redirect_guests_to_login(): void
    {
        $response = $this->get('/dashboard');

        $response->assertRedirect(route('login'));
    }

    public function test_admin_can_login_and_open_dashboard(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@autoprimasukses.com',
            'password' => 'Admin123!',
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'Admin123!',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_invalid_credentials_are_rejected(): void
    {
        $response = $this->from('/login')->post('/login', [
            'email' => 'admin@autoprimasukses.com',
            'password' => 'incorrect',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_admin_can_create_invoice_with_time(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@autoprimasukses.com',
            'password' => 'Admin123!',
        ]);
        $product = Product::create([
            'name' => 'Huber Test Product',
            'size' => '1 Lt',
            'stock' => 10,
            'box_content' => 6,
            'selling_price' => 100000,
            'purchase_price' => 90000,
        ]);

        $response = $this->actingAs($user)->post('/invoices', [
            'customer_name' => 'Bengkel Test',
            'customer_address' => 'Jalan Test',
            'customer_phone' => '08123456789',
            'transaction_date' => '2026-11-19',
            'discount' => 10000,
            'status' => 'Lunas',
            'items' => [
                [
                    'product_id' => $product->id,
                    'quantity' => 2,
                ],
            ],
        ]);

        $invoice = Invoice::firstOrFail();
        $response->assertRedirect(route('invoices.show', $invoice));
        $this->assertDatabaseHas('invoices', [
            'id' => $invoice->id,
            'customer_name' => 'Bengkel Test',
            'status' => 'Lunas',
            'discount' => 10000,
        ]);

        $this->get(route('invoices.show', $invoice))
            ->assertOk()
            ->assertSee('Bengkel Test')
            ->assertSee('PPN (11%)');
    }

    public function test_catalog_separates_series_and_sizes_uniquely(): void
    {
        Product::create([
            'name' => 'Huber Epoxy Primer KL 0.2 Lt HB009 - GREY',
            'size' => '0.2 Lt',
            'category' => 'Primer',
            'stock' => 5,
            'box_content' => 12,
            'selling_price' => 21000,
            'purchase_price' => 21000,
        ]);
        Product::create([
            'name' => 'Huber Epoxy Primer KL 0.8 Lt HB009 - GREY',
            'size' => '0.8 Lt',
            'category' => 'Primer',
            'stock' => 5,
            'box_content' => 6,
            'selling_price' => 71000,
            'purchase_price' => 71000,
        ]);
        Product::create([
            'name' => 'Huber Epoxy Hardener KL 0.2 Lt 0000 - CLEAR',
            'size' => '0.2 Lt',
            'category' => 'Hardener',
            'stock' => 5,
            'box_content' => 6,
            'selling_price' => 22000,
            'purchase_price' => 22000,
        ]);

        $response = $this->get('/katalog');
        $response->assertOk();
        $response->assertSee('Huber Epoxy Primer');
        $response->assertSee('Huber Epoxy Hardener');
    }

    public function test_products_index_renders_pagination_links_and_per_page(): void
    {
        $user = User::factory()->create();

        for ($i = 1; $i <= 25; $i++) {
            Product::create([
                'sku' => 'SKU-'.$i,
                'name' => 'Produk Test '.$i,
                'size' => '1 Lt',
                'category' => 'Clearcoats',
                'stock' => 10,
                'box_content' => 6,
                'selling_price' => 50000,
                'purchase_price' => 40000,
            ]);
        }

        $response = $this->actingAs($user)->get('/products');
        $response->assertOk();
        $response->assertSee('Selanjutnya');
        $response->assertSee('Sebelumnya');
        $response->assertSee('total data');

        $page2 = $this->actingAs($user)->get('/products?page=2');
        $page2->assertOk();
        $page2->assertSee('Produk Test 9');
        $page2->assertSee('Halaman 2 / 2');
    }
}
