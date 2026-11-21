<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicController extends Controller
{
    public function home(): View
    {
        $products = Product::query()
            ->orderBy('brand')
            ->orderBy('category')
            ->orderBy('name')
            ->get();

        $catalog = $products
            ->groupBy(fn (Product $product): string => $product->catalog_category)
            ->map(function ($categoryProducts) {
                return $categoryProducts
                    ->groupBy(fn (Product $product): string => $product->catalog_series)
                    ->map(fn ($seriesProducts) => $seriesProducts
                        ->unique(fn (Product $product): string => $product->size.'|'.$product->color_code.'|'.$product->name)
                        ->values());
            });

        return view('public.home', compact('catalog'));
    }

    public function catalog(Request $request): View
    {
        $category = $request->string('category')->trim()->toString();
        $search = $request->string('search')->trim()->toString();

        $products = Product::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('size', 'like', "%{$search}%")
                        ->orWhere('category', 'like', "%{$search}%")
                        ->orWhere('brand', 'like', "%{$search}%");
                });
            })
            ->orderBy('category')
            ->orderBy('name')
            ->get();

        if ($category !== '') {
            $products = $products->filter(
                fn (Product $product): bool => $product->catalog_category === $category
            )->values();
        }

        $catalog = $products
            ->groupBy(fn (Product $product): string => $product->catalog_category)
            ->map(fn ($items) => $items
                ->groupBy(fn (Product $product): string => $product->catalog_series)
                ->map(fn ($series) => $series
                    ->unique(fn (Product $product): string => $product->size.'|'.$product->name)
                    ->values()));

        return view('public.catalog', compact('catalog', 'category', 'search'));
    }
}
