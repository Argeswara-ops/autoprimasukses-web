@extends('layouts.admin')

@section('content')
<div>
    {{-- Header --}}
    <div class="mb-6 flex items-end justify-between gap-4">
        <div>
            <p class="text-xs font-black uppercase tracking-[0.25em] text-[#D91B24]">Inventaris</p>
            <h1 class="mt-1 text-3xl font-black text-[#0B2D6B]">Daftar Produk</h1>
        </div>
        <a href="{{ route('products.create') }}"
           class="inline-flex shrink-0 items-center gap-2 rounded-xl bg-[#0B2D6B] px-4 py-2.5 text-sm font-black text-white shadow-sm hover:bg-[#09245a] transition">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Produk
        </a>
    </div>

    {{-- Filter Bar --}}
    <form method="GET" action="{{ route('products.index') }}"
          class="mb-5 grid gap-3 rounded-2xl border border-slate-200 bg-white p-4 sm:grid-cols-[minmax(180px,1.5fr)_180px_140px_130px_auto]">
        
        {{-- Search Input with Left Icon --}}
        <div class="relative">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <input type="search" name="search" value="{{ request('search') }}"
                   placeholder="Cari nama atau SKU produk..."
                   class="w-full rounded-xl border border-slate-300 pl-10 pr-4 py-2.5 text-sm text-slate-800 placeholder:text-slate-400 focus:border-[#0B2D6B] focus:ring-4 focus:ring-blue-100 outline-none transition">
        </div>

        {{-- Category Dropdown with Pixel-Perfect Centered Arrow --}}
        <div class="relative">
            <select name="category"
                    class="w-full appearance-none rounded-xl border border-slate-300 bg-white pl-3.5 pr-9 py-2.5 text-sm font-semibold text-slate-700 focus:border-[#0B2D6B] focus:ring-4 focus:ring-blue-100 outline-none transition cursor-pointer">
                <option value="">Semua Kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category }}" @selected(request('category') === $category)>{{ $category }}</option>
                @endforeach
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                </svg>
            </div>
        </div>

        {{-- Size Dropdown with Pixel-Perfect Centered Arrow --}}
        <div class="relative">
            <select name="size"
                    class="w-full appearance-none rounded-xl border border-slate-300 bg-white pl-3.5 pr-9 py-2.5 text-sm font-semibold text-slate-700 focus:border-[#0B2D6B] focus:ring-4 focus:ring-blue-100 outline-none transition cursor-pointer">
                <option value="">Semua Ukuran</option>
                @foreach($sizes as $size)
                    <option value="{{ $size }}" @selected(request('size') === $size)>{{ $size }}</option>
                @endforeach
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                </svg>
            </div>
        </div>

        {{-- Per Page Dropdown with Pixel-Perfect Centered Arrow --}}
        <div class="relative">
            <select name="per_page"
                    class="w-full appearance-none rounded-xl border border-slate-300 bg-white pl-3.5 pr-9 py-2.5 text-sm font-semibold text-slate-700 focus:border-[#0B2D6B] focus:ring-4 focus:ring-blue-100 outline-none transition cursor-pointer">
                <option value="20" @selected(request('per_page', 20) == 20)>20 / hal</option>
                <option value="50" @selected(request('per_page') == 50)>50 / hal</option>
                <option value="100" @selected(request('per_page') == 100)>Semua (100)</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                </svg>
            </div>
        </div>

        {{-- Filter & Reset Buttons --}}
        <div class="flex items-center gap-2">
            <button type="submit"
                    class="inline-flex items-center justify-center rounded-xl bg-[#D91B24] px-5 py-2.5 text-sm font-black text-white hover:bg-red-700 transition shadow-sm">
                Filter
            </button>
            @if(request('search') || request('category') || request('size') || request('per_page') != 20)
            <a href="{{ route('products.index') }}"
               class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm font-bold text-slate-600 hover:bg-slate-50 transition"
               title="Reset Filter">
                Reset
            </a>
            @endif
        </div>
    </form>

    {{-- Table --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr class="text-left text-xs font-black uppercase tracking-wide text-slate-500">
                        <th class="px-5 py-3">Produk</th>
                        <th class="px-5 py-3">Kategori</th>
                        <th class="px-5 py-3">Ukuran</th>
                        <th class="px-5 py-3 text-right">Stok</th>
                        <th class="px-5 py-3 text-right">Isi/Dus</th>
                        <th class="px-5 py-3 text-right">Harga Jual</th>
                        <th class="px-5 py-3 text-right">Harga Beli</th>
                        <th class="px-5 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($products as $product)
                    <tr class="text-sm text-slate-700 hover:bg-slate-50/70 transition">
                        <td class="px-5 py-4">
                            <p class="font-black text-slate-900">{{ $product->name }}</p>
                            @if($product->sku)
                            <p class="mt-0.5 text-xs text-slate-400">SKU: {{ $product->sku }}</p>
                            @endif
                        </td>
                        <td class="px-5 py-4">
                            @if($product->category)
                                @php
                                    $catColor = match($product->category) {
                                        'Clearcoats' => 'bg-blue-50 text-[#0B2D6B] border-blue-200/70',
                                        'Hardener' => 'bg-amber-50 text-amber-800 border-amber-200/70',
                                        'Primer' => 'bg-slate-100 text-slate-700 border-slate-200',
                                        'Basecoat' => 'bg-purple-50 text-purple-700 border-purple-200/70',
                                        'Thinner' => 'bg-teal-50 text-teal-800 border-teal-200/70',
                                        'Degreaser' => 'bg-emerald-50 text-emerald-800 border-emerald-200/70',
                                        default => 'bg-blue-50 text-[#0B2D6B] border-blue-200/70',
                                    };
                                @endphp
                                <span class="rounded-full border px-2.5 py-1 text-xs font-bold {{ $catColor }}">
                                    {{ $product->category }}
                                </span>
                            @else
                                <span class="text-slate-400">—</span>
                            @endif
                        </td>
                        <td class="px-5 py-4">
                            <span class="rounded-full border border-slate-200 bg-slate-50 px-2.5 py-1 text-xs font-bold text-slate-600">{{ $product->size }}</span>
                        </td>
                        <td class="px-5 py-4 text-right">
                            <span class="tabular-nums rounded-full px-2.5 py-1 text-sm font-black {{ $product->low_stock ? 'bg-red-100 text-[#D91B24]' : 'bg-slate-100 text-slate-700' }}">
                                {{ number_format($product->stock) }} pcs
                            </span>
                            <p class="mt-1 tabular-nums text-right text-xs text-slate-400">{{ $product->boxes ?? floor($product->stock / max(1,$product->box_content)) }} dus</p>
                        </td>
                        <td class="px-5 py-4 tabular-nums text-right text-slate-600">{{ $product->box_content }}</td>
                        <td class="px-5 py-4 tabular-nums text-right font-bold text-slate-800">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</td>
                        <td class="px-5 py-4 tabular-nums text-right text-slate-600">Rp {{ number_format($product->purchase_price, 0, ',', '.') }}</td>
                        <td class="px-5 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('products.edit', $product) }}"
                                   class="rounded-lg bg-[#0B2D6B]/10 px-3 py-1.5 text-xs font-black text-[#0B2D6B] hover:bg-[#0B2D6B] hover:text-white transition">Edit</a>
                                <form action="{{ route('products.destroy', $product) }}" method="POST"
                                      id="delete-product-{{ $product->id }}" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="button"
                                            onclick="confirmAction({
                                                title: 'Hapus Produk {{ addslashes($product->name) }}?',
                                                message: 'Produk ini akan dihapus permanen dari basis data dan daftar stok gudang.',
                                                confirmText: 'Ya, Hapus Produk',
                                                cancelText: 'Batal',
                                                type: 'danger',
                                                formId: 'delete-product-{{ $product->id }}'
                                            })"
                                            class="rounded-lg bg-red-50 px-3 py-1.5 text-xs font-black text-[#D91B24] hover:bg-[#D91B24] hover:text-white transition">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-5 py-16 text-center">
                            <p class="text-slate-400 font-semibold">Belum ada produk terdaftar.</p>
                            <a href="{{ route('products.create') }}" class="mt-3 inline-block text-sm font-black text-[#0B2D6B] hover:underline">+ Tambah Produk Pertama</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination & Summary Footer --}}
        <div class="border-t border-slate-100 bg-slate-50/70 px-5 py-4">
            @if($products->hasPages())
                {{ $products->links() }}
            @else
                <div class="flex items-center justify-between text-xs text-slate-500 font-medium">
                    <p>Menampilkan seluruh <span class="font-bold text-slate-800">{{ $products->total() }}</span> produk.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
