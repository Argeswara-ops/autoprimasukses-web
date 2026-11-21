@extends('layouts.admin')

@section('content')
<div class="mx-auto max-w-3xl">
    <div class="mb-6">
        <p class="text-xs font-black uppercase tracking-[0.25em] text-[#D91B24]">Purchase Order — Jawa Timur</p>
        <h1 class="mt-1 text-3xl font-black text-[#0B2D6B]">Hitung Suggest PO</h1>
    </div>

    {{-- Info Box --}}
    <div class="mb-6 rounded-2xl border border-blue-100 bg-blue-50 p-5">
        <p class="text-xs font-black uppercase tracking-widest text-[#0B2D6B] mb-3">Cara Kerja Suggest PO</p>
        <div class="grid gap-3 sm:grid-cols-3 text-sm">
            <div class="flex items-start gap-2">
                <span class="inline-flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-[#0B2D6B] text-xs font-black text-white">1</span>
                <p class="text-slate-600">Hitung <strong>rata-rata penjualan bulanan</strong> tiap produk dari data invoice.</p>
            </div>
            <div class="flex items-start gap-2">
                <span class="inline-flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-[#0B2D6B] text-xs font-black text-white">2</span>
                <p class="text-slate-600">Kalikan dengan <strong>target bulan stok</strong> dan kurangi stok saat ini.</p>
            </div>
            <div class="flex items-start gap-2">
                <span class="inline-flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-[#0B2D6B] text-xs font-black text-white">3</span>
                <p class="text-slate-600">Konversi ke <strong>dus</strong> berdasarkan isi per dus × harga beli = estimasi biaya.</p>
            </div>
        </div>
    </div>

    <form action="{{ route('purchase_orders.calculate') }}" method="POST"
          class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
        @csrf
        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <label for="target_months" class="block text-sm font-black text-slate-800">
                    Target Stok (bulan)
                </label>
                <p class="mt-0.5 text-xs text-slate-400">Berapa bulan ketersediaan stok yang diinginkan?</p>
                <input id="target_months" type="number" name="target_months" min="1" max="12"
                       value="{{ old('target_months', 1) }}"
                       class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3 text-sm tabular-nums focus:border-[#0B2D6B] focus:ring-4 focus:ring-blue-100 outline-none">
            </div>
            <div>
                <label for="month_multiplier" class="block text-sm font-black text-slate-800">
                    Pengali Perkiraan
                </label>
                <p class="mt-0.5 text-xs text-slate-400">Faktor penyesuaian (1.0 = tanpa pengali tambahan).</p>
                <input id="month_multiplier" type="number" name="month_multiplier" min="0.1" max="10" step="0.1"
                       value="{{ old('month_multiplier', 1) }}"
                       class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3 text-sm tabular-nums focus:border-[#0B2D6B] focus:ring-4 focus:ring-blue-100 outline-none">
            </div>
        </div>

        <div class="mt-5 flex flex-wrap items-center gap-y-2 gap-x-4 rounded-xl border border-slate-200 bg-slate-50 px-5 py-4 text-xs font-semibold text-slate-600 sm:text-sm">
            <div class="inline-flex items-center gap-1.5">
                <svg class="h-4 w-4 text-[#0B2D6B]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span class="font-bold text-[#0B2D6B]">Area:</span> Jawa Timur
            </div>
            <span class="text-slate-300 hidden sm:inline">·</span>
            <div class="inline-flex items-center gap-1.5">
                <svg class="h-4 w-4 text-[#0B2D6B]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                <span class="font-bold text-[#0B2D6B]">Data:</span> Rata-rata penjualan seluruh invoice
            </div>
            <span class="text-slate-300 hidden sm:inline">·</span>
            <div class="inline-flex items-center gap-1.5">
                <svg class="h-4 w-4 text-[#0B2D6B]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="font-bold text-[#0B2D6B]">Biaya:</span> Harga beli × isi dus × jumlah dus
            </div>
        </div>

        <div class="mt-6 flex flex-col-reverse gap-3 border-t border-slate-100 pt-6 sm:flex-row sm:justify-end">
            <a href="{{ route('purchase_orders.index') }}"
               class="inline-flex items-center justify-center rounded-xl border border-slate-300 px-5 py-2.5 text-sm font-bold text-slate-700 hover:bg-slate-50 transition">Kembali</a>
            <button type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#D91B24] px-5 py-2.5 text-sm font-black text-white hover:bg-red-700 transition shadow-sm">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                </svg>
                Hitung Suggest PO Jatim
            </button>
        </div>
    </form>
</div>
@endsection
