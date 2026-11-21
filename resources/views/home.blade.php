@extends('layouts.app')

@section('content')
<section class="overflow-hidden rounded-3xl bg-slate-950 px-6 py-12 text-white shadow-xl sm:px-10 lg:px-14 lg:py-16">
    <div class="max-w-3xl">
        <span class="inline-flex rounded-full border border-blue-400/30 bg-blue-400/10 px-3 py-1 text-xs font-bold uppercase tracking-widest text-blue-300">Dashboard Operasional</span>
        <h1 class="mt-5 text-4xl font-bold tracking-tight sm:text-5xl">Kelola bisnis otomotif dengan lebih rapi.</h1>
        <p class="mt-5 max-w-2xl text-base leading-7 text-slate-300 sm:text-lg">Pantau stok produk, buat invoice, dan tentukan rekomendasi pembelian dalam satu tempat.</p>
    </div>
</section>
<div class="mt-6 grid gap-5 md:grid-cols-3">
    <a href="{{ route('products.index') }}" class="group rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:border-blue-200 hover:shadow-lg">
        <div class="grid h-11 w-11 place-items-center rounded-xl bg-blue-50 text-blue-700">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
        </div>
        <h2 class="mt-5 text-lg font-bold text-slate-900">Manajemen Produk</h2>
        <p class="mt-2 text-sm leading-6 text-slate-500">Kelola nama, ukuran, stok, dan harga.</p>
        <span class="mt-5 inline-flex text-sm font-bold text-blue-700">Buka produk <span class="ml-1 transition group-hover:translate-x-1">→</span></span>
    </a>
    <a href="{{ route('invoices.index') }}" class="group rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:border-emerald-200 hover:shadow-lg">
        <div class="grid h-11 w-11 place-items-center rounded-xl bg-emerald-50 text-emerald-700">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5l5 5v11a2 2 0 01-2 2z"/></svg>
        </div>
        <h2 class="mt-5 text-lg font-bold text-slate-900">Invoice & Kasir</h2>
        <p class="mt-2 text-sm leading-6 text-slate-500">Buat transaksi dan pantau penjualan.</p>
        <span class="mt-5 inline-flex text-sm font-bold text-emerald-700">Buka invoice <span class="ml-1 transition group-hover:translate-x-1">→</span></span>
    </a>
    <a href="{{ route('purchase_orders.index') }}" class="group rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:border-violet-200 hover:shadow-lg">
        <div class="grid h-11 w-11 place-items-center rounded-xl bg-violet-50 text-violet-700">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 5h12M9 21a1 1 0 100-2 1 1 0 000 2zm8 0a1 1 0 100-2 1 1 0 000 2z"/></svg>
        </div>
        <h2 class="mt-5 text-lg font-bold text-slate-900">Suggest PO</h2>
        <p class="mt-2 text-sm leading-6 text-slate-500">Hitung rekomendasi pembelian dari data penjualan.</p>
        <span class="mt-5 inline-flex text-sm font-bold text-violet-700">Hitung PO <span class="ml-1 transition group-hover:translate-x-1">→</span></span>
    </a>
    </div>
@endsection