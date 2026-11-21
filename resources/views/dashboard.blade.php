@extends('layouts.admin')

@section('content')

{{-- ===== HEADER ===== --}}
<div class="mb-8 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
    <div>
        <div class="inline-flex items-center gap-2 rounded-md bg-blue-50 px-2.5 py-1 text-xs font-bold uppercase tracking-wider text-[#0B2D6B]">
            <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
            Panel Operasional Admin
        </div>
        <h1 class="mt-2 text-3xl font-black tracking-tight text-slate-900">Dashboard &amp; Analitik</h1>
        <p class="mt-1 text-sm text-slate-500 font-medium">
            Selamat datang, <span class="font-bold text-[#0B2D6B]">{{ Auth::user()->name ?? 'Administrator' }}</span>.
            Berikut ringkasan performa penjualan, stok produk, dan rekomendasi PO hari ini.
        </p>
    </div>
    <div class="flex items-center gap-3">
        <a href="{{ route('purchase_orders.suggest') }}"
           class="inline-flex items-center gap-2 rounded-xl bg-[#D91B24] px-4 py-2.5 text-xs font-bold text-white shadow-md shadow-red-600/20 hover:bg-red-700 transition">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
            </svg>
            Hitung Suggest PO
        </a>
        <a href="{{ route('invoices.create') }}"
           class="inline-flex items-center gap-2 rounded-xl bg-[#0B2D6B] px-4 py-2.5 text-xs font-bold text-white shadow-md shadow-blue-900/20 hover:bg-[#09245a] transition">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            Buat Faktur Baru
        </a>
    </div>
</div>

{{-- ===== STAT CARDS ===== --}}
<div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-4">
    {{-- Card 1: Produk --}}
    <a href="{{ route('products.index') }}"
       class="group rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm hover:border-[#0B2D6B] hover:shadow-md transition">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Katalog</p>
                <p class="mt-2 text-3xl font-black text-slate-900 tabular-nums">{{ $productCount }}</p>
            </div>
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-[#0B2D6B] transition group-hover:bg-[#0B2D6B] group-hover:text-white">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
        </div>
        <div class="mt-4 flex items-center justify-between border-t border-slate-100 pt-3 text-xs">
            <span class="font-semibold text-emerald-600">{{ $safeStockCount }} stok aman</span>
            @if($lowStockCount > 0 || $outOfStockCount > 0)
                <span class="rounded-md bg-red-50 px-2 py-0.5 font-bold text-[#D91B24]">
                    {{ $lowStockCount + $outOfStockCount }} butuh reorder
                </span>
            @else
                <span class="text-slate-400">Semua aman</span>
            @endif
        </div>
    </a>

    {{-- Card 2: Invoice --}}
    <a href="{{ route('invoices.index') }}"
       class="group rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm hover:border-[#0B2D6B] hover:shadow-md transition">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Faktur Penjualan</p>
                <p class="mt-2 text-3xl font-black text-slate-900 tabular-nums">{{ $invoiceCount }}</p>
            </div>
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-[#0B2D6B] transition group-hover:bg-[#0B2D6B] group-hover:text-white">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
        </div>
        <div class="mt-4 flex items-center justify-between border-t border-slate-100 pt-3 text-xs">
            <span class="font-semibold text-slate-500">{{ $paidCount }} Lunas</span>
            @if($unpaidCount > 0)
                <span class="rounded-md bg-amber-50 px-2 py-0.5 font-bold text-amber-700">
                    {{ $unpaidCount }} belum lunas
                </span>
            @else
                <span class="text-emerald-600 font-semibold">Semua lunas</span>
            @endif
        </div>
    </a>

    {{-- Card 3: Suggest PO Jatim --}}
    <a href="{{ route('purchase_orders.index') }}"
       class="group rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm hover:border-[#0B2D6B] hover:shadow-md transition">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Suggest PO Jatim</p>
                <p class="mt-2 text-3xl font-black text-slate-900 tabular-nums">{{ $poCount }}</p>
            </div>
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-[#0B2D6B] transition group-hover:bg-[#0B2D6B] group-hover:text-white">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                </svg>
            </div>
        </div>
        <div class="mt-4 flex items-center justify-between border-t border-slate-100 pt-3 text-xs">
            <span class="font-semibold text-slate-500">Estimasi Kebutuhan</span>
            <span class="font-bold text-[#0B2D6B] tabular-nums">Rp {{ number_format($totalPoCost, 0, ',', '.') }}</span>
        </div>
    </a>

    {{-- Card 4: Total Omzet Lunas --}}
    <div class="rounded-2xl border border-slate-200/80 bg-gradient-to-br from-[#0B2D6B] to-[#082252] p-6 text-white shadow-sm">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-blue-200">Total Pendapatan</p>
                <p class="mt-2 text-2xl font-black tracking-tight text-white tabular-nums sm:text-3xl">
                    Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                </p>
            </div>
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-white/10 text-white backdrop-blur border border-white/15">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
        <div class="mt-4 flex items-center justify-between border-t border-white/10 pt-3 text-xs text-blue-200">
            <span>Status Transaksi</span>
            <span class="font-bold text-emerald-300">Tervalidasi Sistem</span>
        </div>
    </div>
</div>

{{-- ===== GRAFIK / CHARTS SECTION ===== --}}
<div class="mt-8 grid gap-6 lg:grid-cols-[1.5fr_1fr]">
    {{-- Chart 1: Tren Penjualan & Invoice --}}
    <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm">
        <div class="flex flex-col justify-between gap-2 sm:flex-row sm:items-center">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Grafik Penjualan</p>
                <h3 class="text-lg font-black text-slate-900">Tren Pendapatan &amp; Volume Invoice</h3>
            </div>
            <div class="flex items-center gap-3 text-xs font-semibold">
                <div class="flex items-center gap-1.5">
                    <span class="h-3 w-3 rounded bg-[#0B2D6B]"></span>
                    <span class="text-slate-600">Omzet (Rp)</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <span class="h-3 w-3 rounded bg-[#D91B24]"></span>
                    <span class="text-slate-600">Jumlah Invoice</span>
                </div>
            </div>
        </div>

        <div class="mt-6 relative h-72 w-full">
            <canvas id="salesTrendChart"></canvas>
        </div>

        <div class="mt-4 flex items-center justify-between border-t border-slate-100 pt-3 text-xs text-slate-500">
            <span>Periode: 6 Bulan Terakhir</span>
            <span class="font-medium text-[#0B2D6B]">Dihitung real-time dari riwayat invoice</span>
        </div>
    </div>

    {{-- Chart 2: Komposisi Kesehatan Stok & Suggest PO --}}
    <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Status Inventaris</p>
                    <h3 class="text-lg font-black text-slate-900">Kesehatan Stok Produk</h3>
                </div>
                <span class="rounded-full bg-blue-50 px-2.5 py-1 text-[11px] font-bold text-[#0B2D6B]">
                    {{ $productCount }} SKU
                </span>
            </div>

            <div class="mt-4 relative h-56 w-full flex items-center justify-center">
                <canvas id="stockHealthChart"></canvas>
            </div>
        </div>

        <div class="mt-4 space-y-2.5 border-t border-slate-100 pt-4">
            <div class="flex items-center justify-between text-xs font-semibold">
                <div class="flex items-center gap-2">
                    <span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                    <span class="text-slate-600">Stok Aman (> 1 dus)</span>
                </div>
                <span class="tabular-nums font-bold text-slate-800">{{ $safeStockCount }} produk</span>
            </div>
            <div class="flex items-center justify-between text-xs font-semibold">
                <div class="flex items-center gap-2">
                    <span class="h-2.5 w-2.5 rounded-full bg-amber-500"></span>
                    <span class="text-slate-600">Stok Menipis (≤ isi dus)</span>
                </div>
                <span class="tabular-nums font-bold text-amber-600">{{ $lowStockCount }} produk</span>
            </div>
            <div class="flex items-center justify-between text-xs font-semibold">
                <div class="flex items-center gap-2">
                    <span class="h-2.5 w-2.5 rounded-full bg-[#D91B24]"></span>
                    <span class="text-slate-600">Stok Kosong (0 pcs)</span>
                </div>
                <span class="tabular-nums font-bold text-[#D91B24]">{{ $outOfStockCount }} produk</span>
            </div>
        </div>
    </div>
</div>

{{-- ===== TABEL REKOMENDASI ORDER & PINTASAN ===== --}}
<div class="mt-8 grid gap-6 lg:grid-cols-[1.5fr_1fr]">
    {{-- Tabel Produk Perlu Perhatian / Suggest PO --}}
    <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-[#D91B24]">Prioritas Reorder</p>
                <h3 class="text-base font-black text-slate-900">Produk Stok Kritis (Perlu Order Jatim)</h3>
            </div>
            <a href="{{ route('purchase_orders.index') }}" class="text-xs font-bold text-[#0B2D6B] hover:underline">
                Buka Suggest PO →
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b border-slate-100 text-[11px] font-extrabold uppercase tracking-wider text-slate-400">
                        <th class="pb-3">Nama Produk</th>
                        <th class="pb-3 text-center">Ukuran</th>
                        <th class="pb-3 text-right">Stok</th>
                        <th class="pb-3 text-right">Isi/Dus</th>
                        <th class="pb-3 text-right">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($criticalProducts as $prod)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="py-3 font-bold text-slate-800">
                            <a href="{{ route('products.edit', $prod) }}" class="hover:text-[#0B2D6B]">
                                {{ $prod->name }}
                            </a>
                        </td>
                        <td class="py-3 text-center text-xs font-semibold text-slate-500">
                            {{ $prod->size ?: '—' }}
                        </td>
                        <td class="py-3 text-right font-black tabular-nums {{ $prod->stock <= 0 ? 'text-[#D91B24]' : ($prod->stock <= $prod->box_content ? 'text-amber-600' : 'text-slate-700') }}">
                            {{ number_format($prod->stock) }} pcs
                        </td>
                        <td class="py-3 text-right text-xs text-slate-500 tabular-nums">
                            {{ $prod->box_content }} pcs/dus
                        </td>
                        <td class="py-3 text-right">
                            @if($prod->stock <= 0)
                                <span class="inline-flex rounded-full bg-red-100 px-2 py-0.5 text-[10px] font-bold text-red-700">Habis</span>
                            @elseif($prod->stock <= $prod->box_content)
                                <span class="inline-flex rounded-full bg-amber-100 px-2 py-0.5 text-[10px] font-bold text-amber-700">Menipis</span>
                            @else
                                <span class="inline-flex rounded-full bg-emerald-100 px-2 py-0.5 text-[10px] font-bold text-emerald-700">Aman</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-6 text-center text-xs text-slate-400">
                            Belum ada produk yang terdaftar.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pintasan Cepat & Ringkasan Kategori --}}
    <div class="space-y-6">
        {{-- Kategori Terbanyak --}}
        <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm">
            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400">Distribusi Kategori</h4>
            <h3 class="mt-1 text-base font-black text-slate-900">Kategori Produk Unggulan</h3>
            <div class="mt-4 space-y-3">
                @forelse($categories as $cat)
                <div>
                    <div class="flex items-center justify-between text-xs font-bold">
                        <span class="text-slate-700">{{ $cat->category ?: 'Lainnya' }}</span>
                        <span class="tabular-nums text-slate-500">{{ $cat->total }} SKU</span>
                    </div>
                    <div class="mt-1.5 h-2 w-full rounded-full bg-slate-100 overflow-hidden">
                        <div class="h-full rounded-full bg-[#0B2D6B]"
                             style="width: {{ $productCount > 0 ? min(100, round(($cat->total / $productCount) * 100)) : 0 }}%"></div>
                    </div>
                </div>
                @empty
                <p class="text-xs text-slate-400">Belum ada kategori produk.</p>
                @endforelse
            </div>
        </div>

        {{-- Pintasan Cepat --}}
        <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm">
            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400">Aksi Langsung</h4>
            <div class="mt-3 grid gap-2.5">
                <a href="{{ route('invoices.create') }}"
                   class="flex items-center justify-between rounded-xl border border-slate-200 p-3 text-xs font-bold text-slate-700 hover:border-[#0B2D6B] hover:text-[#0B2D6B] hover:bg-blue-50/50 transition">
                    <span class="flex items-center gap-2">
                        <svg class="h-4 w-4 text-[#0B2D6B]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                        Buat Invoice Baru
                    </span>
                    <span>→</span>
                </a>
                <a href="{{ route('products.create') }}"
                   class="flex items-center justify-between rounded-xl border border-slate-200 p-3 text-xs font-bold text-slate-700 hover:border-[#0B2D6B] hover:text-[#0B2D6B] hover:bg-blue-50/50 transition">
                    <span class="flex items-center gap-2">
                        <svg class="h-4 w-4 text-[#0B2D6B]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        Tambah Produk Baru
                    </span>
                    <span>→</span>
                </a>
                <a href="{{ route('purchase_orders.suggest') }}"
                   class="flex items-center justify-between rounded-xl border border-slate-200 p-3 text-xs font-bold text-slate-700 hover:border-[#D91B24] hover:text-[#D91B24] hover:bg-red-50/50 transition">
                    <span class="flex items-center gap-2">
                        <svg class="h-4 w-4 text-[#D91B24]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                        Kalkulasi Suggest PO Jatim
                    </span>
                    <span>→</span>
                </a>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // --- DATA DARI CONTROLLER ---
        const monthLabels = @json($monthLabels);
        const salesData = @json($salesData);
        const invoiceCountData = @json($invoiceCountData);

        const safeStockCount = {{ $safeStockCount }};
        const lowStockCount = {{ $lowStockCount }};
        const outOfStockCount = {{ $outOfStockCount }};

        // --- 1. CHART TREN PENJUALAN ---
        const salesCtx = document.getElementById('salesTrendChart');
        if (salesCtx) {
            new Chart(salesCtx, {
                type: 'bar',
                data: {
                    labels: monthLabels,
                    datasets: [
                        {
                            label: 'Omzet Penjualan (Rp)',
                            data: salesData,
                            backgroundColor: 'rgba(11, 45, 107, 0.85)',
                            hoverBackgroundColor: 'rgba(11, 45, 107, 1)',
                            borderRadius: 8,
                            yAxisID: 'y',
                            order: 2
                        },
                        {
                            label: 'Jumlah Invoice',
                            data: invoiceCountData,
                            type: 'line',
                            borderColor: '#D91B24',
                            backgroundColor: '#D91B24',
                            borderWidth: 3,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            tension: 0.3,
                            yAxisID: 'y1',
                            order: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#0B2D6B',
                            titleFont: { family: 'Plus Jakarta Sans', weight: 'bold' },
                            bodyFont: { family: 'Plus Jakarta Sans' },
                            padding: 12,
                            cornerRadius: 10,
                            callbacks: {
                                label: function(context) {
                                    if (context.dataset.yAxisID === 'y') {
                                        return ' Omzet: Rp ' + new Intl.NumberFormat('id-ID').format(context.raw);
                                    }
                                    return ' Transaksi: ' + context.raw + ' Invoice';
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: {
                                font: { family: 'Plus Jakarta Sans', weight: '600', size: 11 },
                                color: '#64748b'
                            }
                        },
                        y: {
                            type: 'linear',
                            display: true,
                            position: 'left',
                            grid: { color: '#f1f5f9' },
                            ticks: {
                                font: { family: 'Plus Jakarta Sans', size: 10 },
                                color: '#64748b',
                                callback: function(value) {
                                    if (value >= 1000000) return 'Rp ' + (value / 1000000) + ' jt';
                                    if (value >= 1000) return 'Rp ' + (value / 1000) + ' rb';
                                    return 'Rp ' + value;
                                }
                            }
                        },
                        y1: {
                            type: 'linear',
                            display: true,
                            position: 'right',
                            grid: { drawOnChartArea: false },
                            ticks: {
                                precision: 0,
                                font: { family: 'Plus Jakarta Sans', size: 10 },
                                color: '#D91B24'
                            }
                        }
                    }
                }
            });
        }

        // --- 2. CHART KESEHATAN STOK (DOUGHNUT) ---
        const stockCtx = document.getElementById('stockHealthChart');
        if (stockCtx) {
            new Chart(stockCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Stok Aman', 'Stok Menipis', 'Stok Habis'],
                    datasets: [{
                        data: [safeStockCount, lowStockCount, outOfStockCount],
                        backgroundColor: [
                            '#10B981', // Emerald
                            '#F59E0B', // Amber
                            '#D91B24'  // APS Red
                        ],
                        borderWidth: 2,
                        borderColor: '#ffffff',
                        hoverOffset: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '72%',
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#0B2D6B',
                            titleFont: { family: 'Plus Jakarta Sans', weight: 'bold' },
                            bodyFont: { family: 'Plus Jakarta Sans' },
                            padding: 10,
                            cornerRadius: 8,
                            callbacks: {
                                label: function(context) {
                                    return ' ' + context.label + ': ' + context.raw + ' Produk';
                                }
                            }
                        }
                    }
                }
            });
        }
    });
</script>
@endpush
