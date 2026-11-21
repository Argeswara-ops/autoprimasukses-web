<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\PurchaseOrder;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SuggestPoController extends Controller
{
    public function index(): View
    {
        $orders = PurchaseOrder::with('product')->latest()->paginate(20);

        return view('purchase_orders.index', compact('orders'));
    }

    public function suggest(): View
    {
        $products = Product::orderBy('name')->get();

        return view('purchase_orders.suggest', compact('products'));
    }

    public function calculate(Request $request)
    {
        $validated = $request->validate([
            'month_multiplier' => 'nullable|numeric|min:0.1|max:10',
            'target_months' => 'nullable|integer|min:1|max:12',
        ]);

        $targetMonths = (int) ($validated['target_months'] ?? 1);
        $poNumberPrefix = 'PO-JATIM-'.now()->format('Ym');
        $count = PurchaseOrder::where('po_number', 'like', $poNumberPrefix.'-%')->count();

        foreach (Product::where('stock', '>=', 0)->get() as $product) {
            $unitPerBox = $product->unit_per_box ?: $product->box_content ?: 1;
            $avgMonthlySales = (int) ceil(max(0, $product->invoiceItems()->sum('quantity')) / 12);
            $suggestedBoxes = (int) ceil((($avgMonthlySales * $targetMonths) - $product->stock) / $unitPerBox);
            $suggestedBoxes = max(0, $suggestedBoxes);

            $count++;
            PurchaseOrder::updateOrCreate(
                ['product_id' => $product->id, 'area' => 'Jawa Timur'],
                [
                    'po_number' => sprintf('%s-%03d', $poNumberPrefix, $count),
                    'current_stock' => $product->stock,
                    'average_monthly_sales' => $avgMonthlySales,
                    'avg_monthly_sales' => $avgMonthlySales,
                    'suggested_boxes' => $suggestedBoxes,
                    'suggest_po_box' => $suggestedBoxes,
                    'unit_per_box' => $unitPerBox,
                    'unit_price' => $product->purchase_price,
                    'total_estimated_cost' => $suggestedBoxes * $unitPerBox * $product->purchase_price,
                    'total_amount' => $suggestedBoxes * $unitPerBox * $product->purchase_price,
                    'status' => 'Draft',
                    'calculated_at' => now()->toDateString(),
                ],
            );
        }

        return redirect()->route('purchase_orders.index')
            ->with('success', 'Rekomendasi purchase order Jawa Timur berhasil dihitung.');
    }

    public function status(Request $request, PurchaseOrder $purchaseOrder)
    {
        $validated = $request->validate([
            'status' => 'required|in:Draft,Diajukan,Selesai',
        ]);

        $purchaseOrder->update($validated);

        return back()->with('success', 'Status purchase order diperbarui.');
    }
}
