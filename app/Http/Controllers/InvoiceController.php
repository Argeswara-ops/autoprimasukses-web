<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class InvoiceController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->string('status')->trim()->toString();
        $search = $request->string('search')->trim()->toString();

        $query = Invoice::with('items.product')->latest('transaction_date')->latest('id');

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                    ->orWhere('customer_name', 'like', "%{$search}%")
                    ->orWhere('customer_phone', 'like', "%{$search}%")
                    ->orWhere('sales_person', 'like', "%{$search}%");
            });
        }

        if ($status !== '') {
            if ($status === 'Overdue') {
                $query->where('status', '!=', 'Lunas')
                    ->where('due_date', '<', now()->toDateString());
            } else {
                $query->where('status', $status);
            }
        }

        $invoices = $query->paginate(15)->withQueryString();

        // Metrics for Invoice System
        $totalInvoices = Invoice::count();
        $paidTotal = (float) Invoice::where('status', 'Lunas')->sum('grand_total');
        $paidCount = Invoice::where('status', 'Lunas')->count();
        $unpaidTotal = (float) Invoice::where('status', '!=', 'Lunas')->sum('grand_total');
        $unpaidCount = Invoice::where('status', '!=', 'Lunas')->count();
        $overdueCount = Invoice::where('status', '!=', 'Lunas')
            ->where('due_date', '<', now()->toDateString())
            ->count();

        return view('invoices.index', compact(
            'invoices',
            'search',
            'status',
            'totalInvoices',
            'paidTotal',
            'paidCount',
            'unpaidTotal',
            'unpaidCount',
            'overdueCount'
        ));
    }

    public function create(): View
    {
        $products = Product::orderBy('name')->get();
        $month = now()->format('Ym');
        $last = Invoice::query()->where('invoice_number', 'like', "APS-INV-$month-%")->latest('id')->first();
        $sequence = $last ? (((int) substr((string) $last->invoice_number, -3)) + 1) : 1;
        $suggestedInvoiceNumber = sprintf('APS-INV-%s-%03d', $month, $sequence);

        return view('invoices.create', compact('products', 'suggestedInvoiceNumber'));
    }

    public function show(Invoice $invoice): View
    {
        $invoice->load('items.product');

        return view('invoices.show', compact('invoice'));
    }

    public function print(Invoice $invoice): View
    {
        $invoice->load('items.product');

        return view('invoices.print', compact('invoice'));
    }

    public function deliveryOrder(Invoice $invoice): View
    {
        $invoice->load('items.product');

        return view('invoices.delivery_order', compact('invoice'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:150',
            'customer_address' => 'nullable|string|max:255',
            'customer_phone' => 'nullable|string|max:50',
            'transaction_date' => 'required|date',
            'due_date' => 'nullable|date',
            'payment_method' => 'nullable|string|max:50',
            'sales_person' => 'nullable|string|max:100',
            'discount' => 'nullable|numeric|min:0',
            'status' => 'required|in:Belum Lunas,Lunas,Pending',
            'notes' => 'nullable|string|max:500',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'nullable|numeric|min:0',
        ]);

        $invoice = DB::transaction(function () use ($validated) {
            $month = now()->format('Ym');
            $last = Invoice::query()->where('invoice_number', 'like', "APS-INV-$month-%")->lockForUpdate()->latest('id')->first();
            $sequence = $last ? (((int) substr((string) $last->invoice_number, -3)) + 1) : 1;
            $invoiceNumber = sprintf('APS-INV-%s-%03d', $month, $sequence);

            $dueDate = $validated['due_date'] ?? $validated['transaction_date'];
            $isPaid = $validated['status'] === 'Lunas';

            $invoice = Invoice::create([
                'invoice_number' => $invoiceNumber,
                'customer_name' => $validated['customer_name'],
                'customer_address' => $validated['customer_address'] ?? null,
                'customer_phone' => $validated['customer_phone'] ?? null,
                'invoice_date' => $validated['transaction_date'],
                'invoice_time' => now()->format('H:i'),
                'transaction_date' => $validated['transaction_date'],
                'due_date' => $dueDate,
                'sales_person' => $validated['sales_person'] ?? null,
                'payment_method' => $validated['payment_method'] ?? 'Transfer Bank (BCA)',
                'payment_date' => $isPaid ? now()->toDateString() : null,
                'subtotal' => 0,
                'tax' => 0,
                'total' => 0,
                'discount' => (float) ($validated['discount'] ?? 0),
                'tax_ppn' => 0,
                'grand_total' => 0,
                'status' => $validated['status'],
                'notes' => $validated['notes'] ?? null,
            ]);

            $subtotal = 0;
            foreach ($validated['items'] as $itemData) {
                $product = Product::findOrFail($itemData['product_id']);
                $price = isset($itemData['price']) && (float) $itemData['price'] > 0
                    ? (float) $itemData['price']
                    : (float) $product->selling_price;

                $total = $price * (int) $itemData['quantity'];

                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'product_id' => $product->id,
                    'quantity' => $itemData['quantity'],
                    'price' => $price,
                    'total' => $total,
                    'subtotal' => $total,
                ]);

                $subtotal += $total;

                // Kurangi stok jika tersedia
                if ($product->stock >= $itemData['quantity']) {
                    $product->decrement('stock', $itemData['quantity']);
                } else {
                    $product->update(['stock' => max(0, $product->stock - $itemData['quantity'])]);
                }
            }

            $discount = (float) ($validated['discount'] ?? 0);
            $afterDiscount = max(0, $subtotal - $discount);
            $tax = round($afterDiscount * 0.11, 2);
            $grandTotal = $afterDiscount + $tax;

            $invoice->update([
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $grandTotal,
                'tax_ppn' => $tax,
                'grand_total' => $grandTotal,
            ]);

            return $invoice;
        });

        return redirect()->route('invoices.show', $invoice)
            ->with('success', "Faktur Penjualan {$invoice->invoice_number} berhasil diterbitkan.");
    }

    public function edit(Invoice $invoice): View
    {
        return view('invoices.edit', compact('invoice'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:150',
            'customer_address' => 'nullable|string|max:255',
            'customer_phone' => 'nullable|string|max:50',
            'transaction_date' => 'required|date',
            'due_date' => 'nullable|date',
            'payment_method' => 'nullable|string|max:50',
            'sales_person' => 'nullable|string|max:100',
            'status' => 'required|in:Belum Lunas,Lunas,Pending',
            'notes' => 'nullable|string|max:500',
        ]);

        $isPaid = $validated['status'] === 'Lunas';
        if ($isPaid && ! $invoice->payment_date) {
            $validated['payment_date'] = now()->toDateString();
        } elseif (! $isPaid) {
            $validated['payment_date'] = null;
        }

        $invoice->update($validated);

        return redirect()->route('invoices.show', $invoice)
            ->with('success', 'Faktur Penjualan berhasil diperbarui.');
    }

    public function markAsPaid(Request $request, Invoice $invoice)
    {
        $paymentMethod = $request->input('payment_method', $invoice->payment_method ?: 'Transfer Bank (BCA)');

        $invoice->update([
            'status' => 'Lunas',
            'payment_method' => $paymentMethod,
            'payment_date' => now()->toDateString(),
        ]);

        return redirect()->back()->with('success', "Faktur {$invoice->invoice_number} berhasil ditandai Lunas.");
    }

    public function destroy(Invoice $invoice)
    {
        DB::transaction(function () use ($invoice) {
            foreach ($invoice->items as $item) {
                if ($item->product) {
                    $item->product->increment('stock', $item->quantity);
                }
            }

            $invoice->delete();
        });

        return redirect()->route('invoices.index')
            ->with('success', "Faktur {$invoice->invoice_number} berhasil dihapus dan stok telah dikembalikan.");
    }
}
