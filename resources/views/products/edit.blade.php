@extends('layouts.admin')

@section('content')
<div class="mx-auto max-w-3xl">
    <div class="mb-6">
        <p class="text-xs font-black uppercase tracking-[0.25em] text-[#D91B24]">Inventaris</p>
        <h1 class="mt-1 text-3xl font-black text-[#0B2D6B]">Edit Produk</h1>
        <p class="mt-1 text-sm text-slate-500">{{ $product->name }}</p>
    </div>

    <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data"
          class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
        @csrf @method('PUT')
        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <label class="text-sm font-black text-slate-700">SKU / Kode Barang</label>
                <input type="text" name="sku" value="{{ old('sku', $product->sku) }}"
                       class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-[#0B2D6B] focus:ring-4 focus:ring-blue-100 outline-none">
            </div>
            <div>
                <label class="text-sm font-black text-slate-700">Merk</label>
                <input type="text" name="brand" value="{{ old('brand', $product->brand) }}"
                       class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-[#0B2D6B] focus:ring-4 focus:ring-blue-100 outline-none">
            </div>
            <div class="sm:col-span-2">
                <label class="text-sm font-black text-slate-700">Nama Produk <span class="text-[#D91B24]">*</span></label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}" required
                       class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-[#0B2D6B] focus:ring-4 focus:ring-blue-100 outline-none">
            </div>
            <div>
                <label class="text-sm font-black text-slate-700">Kategori / Jenis</label>
                <input type="text" name="category" value="{{ old('category', $product->category) }}"
                       class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-[#0B2D6B] focus:ring-4 focus:ring-blue-100 outline-none">
            </div>
            <div>
                <label class="text-sm font-black text-slate-700">Ukuran <span class="text-[#D91B24]">*</span></label>
                <input type="text" name="size" value="{{ old('size', $product->size) }}" required
                       class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-[#0B2D6B] focus:ring-4 focus:ring-blue-100 outline-none">
            </div>
            <div>
                <label class="text-sm font-black text-slate-700">Stok (pcs) <span class="text-[#D91B24]">*</span></label>
                <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" min="0" required
                       class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm tabular-nums focus:border-[#0B2D6B] focus:ring-4 focus:ring-blue-100 outline-none">
                <p class="mt-1 text-xs text-slate-400">Setara ≈ {{ floor($product->stock / max(1,$product->box_content)) }} dus</p>
            </div>
            <div>
                <label class="text-sm font-black text-slate-700">Isi per Dus <span class="text-[#D91B24]">*</span></label>
                <input type="number" name="box_content" value="{{ old('box_content', $product->box_content) }}" min="1" required
                       class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm tabular-nums focus:border-[#0B2D6B] focus:ring-4 focus:ring-blue-100 outline-none">
            </div>
            <div>
                <label class="text-sm font-black text-slate-700">Harga Jual (Rp) <span class="text-[#D91B24]">*</span></label>
                <input type="number" step="0.01" name="selling_price" value="{{ old('selling_price', $product->selling_price) }}" required
                       class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm tabular-nums focus:border-[#0B2D6B] focus:ring-4 focus:ring-blue-100 outline-none">
            </div>
            <div>
                <label class="text-sm font-black text-slate-700">Harga Beli / Modal (Rp) <span class="text-[#D91B24]">*</span></label>
                <input type="number" step="0.01" name="purchase_price" value="{{ old('purchase_price', $product->purchase_price) }}" required
                       class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm tabular-nums focus:border-[#0B2D6B] focus:ring-4 focus:ring-blue-100 outline-none">
            </div>
            <div class="sm:col-span-2">
                <label class="text-sm font-black text-slate-700">Gambar Produk</label>
                <input type="file" name="image" accept="image/*"
                       class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm">
            </div>
        </div>
        <div class="mt-6 flex flex-col-reverse gap-3 border-t border-slate-100 pt-6 sm:flex-row sm:justify-end">
            <a href="{{ route('products.index') }}"
               class="inline-flex items-center justify-center rounded-xl border border-slate-300 px-5 py-2.5 text-sm font-bold text-slate-700 hover:bg-slate-50 transition">Batal</a>
            <button type="submit"
                    class="inline-flex items-center justify-center rounded-xl bg-[#0B2D6B] px-5 py-2.5 text-sm font-black text-white hover:bg-[#09245a] transition shadow-sm">
                Update Produk
            </button>
        </div>
    </form>
</div>
@endsection
