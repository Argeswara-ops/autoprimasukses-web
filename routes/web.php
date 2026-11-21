<?php

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\SuggestPoController;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\PurchaseOrder;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/katalog', [PublicController::class, 'catalog'])->name('catalog');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        $productCount = Product::count();
        $lowStockCount = Product::whereColumn('stock', '<=', 'box_content')->where('stock', '>', 0)->count();
        $outOfStockCount = Product::where('stock', '<=', 0)->count();
        $safeStockCount = max(0, $productCount - $lowStockCount - $outOfStockCount);

        $invoiceCount = Invoice::count();
        $unpaidCount = Invoice::where('status', '!=', 'Lunas')->count();
        $paidCount = Invoice::where('status', 'Lunas')->count();
        $totalRevenue = Invoice::where('status', 'Lunas')->sum('grand_total');

        $poCount = PurchaseOrder::count();
        $totalPoCost = PurchaseOrder::sum('total_estimated_cost');

        // Tren Penjualan 6 Bulan Terakhir
        $monthLabels = [];
        $salesData = [];
        $invoiceCountData = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthLabels[] = $date->translatedFormat('M Y');

            $monthInvoices = Invoice::whereYear('invoice_date', $date->year)
                ->whereMonth('invoice_date', $date->month);

            $salesData[] = (float) $monthInvoices->sum('grand_total');
            $invoiceCountData[] = (int) $monthInvoices->count();
        }

        // Produk Kritis / Stok Terendah
        $criticalProducts = Product::orderBy('stock', 'asc')->take(5)->get();

        // Ringkasan Rekomendasi PO Terakhir
        $recentPos = PurchaseOrder::with('product')->latest()->take(5)->get();

        // Distribusi Kategori Produk
        $categories = Product::select('category', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
            ->whereNotNull('category')
            ->groupBy('category')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'productCount',
            'lowStockCount',
            'outOfStockCount',
            'safeStockCount',
            'invoiceCount',
            'unpaidCount',
            'paidCount',
            'totalRevenue',
            'poCount',
            'totalPoCost',
            'monthLabels',
            'salesData',
            'invoiceCountData',
            'criticalProducts',
            'recentPos',
            'categories'
        ));
    })->name('dashboard');

    Route::resource('products', ProductController::class);
    Route::resource('invoices', InvoiceController::class);
    Route::get('invoices/{invoice}/print', [InvoiceController::class, 'print'])->name('invoices.print');
    Route::get('invoices/{invoice}/delivery-order', [InvoiceController::class, 'deliveryOrder'])->name('invoices.delivery_order');
    Route::patch('invoices/{invoice}/pay', [InvoiceController::class, 'markAsPaid'])->name('invoices.pay');

    Route::get('purchase-orders', [SuggestPoController::class, 'index'])->name('purchase_orders.index');
    Route::get('purchase-orders/suggest', [SuggestPoController::class, 'suggest'])->name('purchase_orders.suggest');
    Route::post('purchase-orders/calculate', [SuggestPoController::class, 'calculate'])->name('purchase_orders.calculate');
    Route::patch('purchase-orders/{purchaseOrder}/status', [SuggestPoController::class, 'status'])->name('purchase_orders.status');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
