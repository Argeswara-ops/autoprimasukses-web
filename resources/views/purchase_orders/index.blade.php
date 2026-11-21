@extends('layouts.admin')

@section('content')
<div>
    <div class="mb-6 flex items-end justify-between gap-4">
        <div>
            <p class="text-xs font-black uppercase tracking-[0.25em] text-[#D91B24]">Purchase Order — Jawa Timur</p>
            <h1 class="mt-1 text-3xl font-black text-[#0B2D6B]">Daftar Suggest PO</h1>
            <p class="mt-1 text-sm text-slate-500">Rekomendasi pembelian produk berdasarkan rata-rata penjualan area Jawa Timur.</p>
        </div>
        <a href="{{ route('purchase_orders.suggest') }}"
           class="inline-flex shrink-0 items-center gap-2 rounded-xl bg-[#D91B24] px-4 py-2.5 text-sm font-black text-white shadow-sm hover:bg-red-700 transition">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
            </svg>
            Hitung Suggest PO
        </a>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr class="text-left text-xs font-black uppercase tracking-wide text-slate-500">
                        <th class="px-5 py-3">No. PO / Produk</th>
                        <th class="px-5 py-3 text-right">Stok Saat Ini</th>
                        <th class="px-5 py-3 text-right">Avg Penjualan</th>
                        <th class="px-5 py-3 text-right">Isi/Dus</th>
                        <th class="px-5 py-3 text-right">Dus Disarankan</th>
                        <th class="px-5 py-3 text-right">Est. Biaya (Rp)</th>
                        <th class="px-5 py-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($orders as $order)
                    <tr class="text-sm text-slate-700 hover:bg-slate-50/70 transition">
                        <td class="px-5 py-4">
                            <p class="font-black text-slate-900">{{ $order->po_number }}</p>
                            <p class="mt-0.5 text-xs text-slate-500">{{ $order->product->name ?? '—' }}</p>
                            @if($order->product->size ?? null)
                                <span class="mt-1 inline-block rounded-full bg-blue-50 px-2 py-0.5 text-xs font-bold text-[#0B2D6B]">{{ $order->product->size }}</span>
                            @endif
                        </td>
                        <td class="tabular-nums px-5 py-4 text-right">
                            <span class="font-bold {{ ($order->current_stock ?? 0) <= ($order->product->box_content ?? 999) ? 'text-[#D91B24]' : 'text-slate-700' }}">
                                {{ number_format($order->current_stock ?? 0) }}
                            </span>
                            <span class="text-slate-400"> pcs</span>
                        </td>
                        <td class="tabular-nums px-5 py-4 text-right">
                            {{ number_format($order->avg_monthly_sales ?? $order->average_monthly_sales ?? 0) }}
                            <span class="text-slate-400 text-xs"> unit/bln</span>
                        </td>
                        <td class="tabular-nums px-5 py-4 text-right text-slate-600">
                            {{ $order->product->box_content ?? '—' }}
                        </td>
                        <td class="px-5 py-4 text-right">
                            <span class="tabular-nums rounded-full bg-blue-50 px-3 py-1 text-sm font-black text-[#0B2D6B]">
                                {{ number_format($order->suggest_po_box ?? $order->suggested_boxes ?? 0) }} dus
                            </span>
                        </td>
                        <td class="tabular-nums px-5 py-4 text-right font-black text-[#0B2D6B]">
                            Rp {{ number_format($order->total_amount ?? $order->total_estimated_cost ?? 0, 0, ',', '.') }}
                        </td>
                        <td class="px-5 py-4">
                            <form method="POST" action="{{ route('purchase_orders.status', $order) }}">
                                @csrf @method('PATCH')
                                <select name="status" onchange="this.form.submit()"
                                        class="rounded-xl border border-slate-300 px-3 py-1.5 text-xs font-bold focus:border-[#0B2D6B] outline-none
                                        {{ $order->status === 'Draft' ? 'bg-slate-100 text-slate-600' :
                                           ($order->status === 'Diajukan' ? 'bg-amber-50 text-amber-700' : 'bg-emerald-50 text-emerald-700') }}">
                                    @foreach(['Draft','Diajukan','Selesai'] as $st)
                                        <option value="{{ $st }}" @selected($order->status === $st)>{{ $st }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-5 py-16 text-center">
                            <p class="text-slate-400 font-semibold">Belum ada Purchase Order yang dihitung.</p>
                            <a href="{{ route('purchase_orders.suggest') }}"
                               class="mt-3 inline-block text-sm font-black text-[#D91B24] hover:underline">
                                Hitung Suggest PO Sekarang →
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination & Summary Footer --}}
        <div class="border-t border-slate-100 bg-slate-50/70 px-5 py-4">
            @if(method_exists($orders, 'hasPages') && $orders->hasPages())
                {{ $orders->links() }}
            @elseif(method_exists($orders, 'total'))
                <div class="flex items-center justify-between text-xs text-slate-500 font-medium">
                    <p>Menampilkan seluruh <span class="font-bold text-slate-800">{{ $orders->total() }}</span> purchase order.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
