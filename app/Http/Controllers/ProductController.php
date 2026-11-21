<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $perPage = (int) $request->input('per_page', 20);
        if (! in_array($perPage, [10, 20, 50, 100], true)) {
            $perPage = 20;
        }

        $products = Product::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search')->trim()->toString();
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('sku', 'like', "%{$search}%")
                        ->orWhere('brand', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('category'), fn ($query) => $query->where('category', trim($request->category)))
            ->when($request->filled('size'), fn ($query) => $query->where('size', trim($request->size)))
            ->orderBy('name')
            ->paginate($perPage)
            ->withQueryString();

        $categories = Product::query()
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        if ($categories->isEmpty()) {
            $categories = collect(['Basecoat', 'Clearcoats', 'Degreaser', 'Hardener', 'Primer', 'Thinner']);
        }

        $sizes = Product::query()
            ->whereNotNull('size')
            ->where('size', '!=', '')
            ->distinct()
            ->orderBy('size')
            ->pluck('size');

        return view('products.index', compact('products', 'categories', 'sizes', 'perPage'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sku' => 'nullable|string|max:50|unique:products,sku',
            'name' => 'required|string',
            'category' => 'nullable|string|max:100',
            'brand' => 'nullable|string|max:100',
            'size' => 'required|string',
            'color_code' => 'nullable|string|max:100',
            'stock' => 'required|integer',
            'box_content' => 'required|integer',
            'unit_per_box' => 'nullable|integer',
            'selling_price' => 'required|numeric',
            'purchase_price' => 'required|numeric',
            'image' => 'nullable|image|max:2048',
        ]);
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }
        $validated['unit_per_box'] = $validated['unit_per_box'] ?? $validated['box_content'];
        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Product created');
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'sku' => 'nullable|string|max:50|unique:products,sku,'.$product->id,
            'name' => 'required|string',
            'category' => 'nullable|string|max:100',
            'brand' => 'nullable|string|max:100',
            'size' => 'required|string',
            'color_code' => 'nullable|string|max:100',
            'stock' => 'required|integer',
            'box_content' => 'required|integer',
            'unit_per_box' => 'nullable|integer',
            'selling_price' => 'required|numeric',
            'purchase_price' => 'required|numeric',
            'image' => 'nullable|image|max:2048',
        ]);
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        } else {
            unset($validated['image']);
        }
        $validated['unit_per_box'] = $validated['unit_per_box'] ?? $validated['box_content'];
        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Product updated');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted');
    }
}
