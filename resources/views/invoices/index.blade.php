@extends('layouts.admin')

@section('content')
<div>
    {{-- Header --}}
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-xs font-black uppercase tracking-[0.25em] text-[#D91B24]">Sistem Penjualan &amp; Piutang</p>
            <h1 class="mt-1 text-3xl font-black text-[#0B2D6B]">Faktur & Invoice Penjualan</h1>
            <p class="mt-1 text-sm text-slate-500 font-medium">Kelola seluruh dokumen faktur komersial, pencatatan termin pembayaran, dan pemantauan piutang pelanggan.</p>
        </div>
        <a href="{{ route('invoices.create') }}"
           class="inline-flex shrink-0 items-center justify-center gap-2 rounded-xl bg-[#0B2D6B] px-5 py-2.5 text-sm font-black text-white shadow-sm hover:bg-[#09245a] transition">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            Buat Faktur Baru
        </a>
    </div>

    {{-- Financial Metric Summary Cards --}}
    <div class="mb-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        {{-- Total Invoices --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Faktur</p>
                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-50 text-[#0B2D6B]">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </span>
            </div>
            <p class="mt-2 text-2xl font-black text-slate-900 tabular-nums">{{ $totalInvoices }}</p>
            <p class="mt-1 text-xs text-slate-500 font-semibold">Semua riwayat transaksi penjualan</p>
        </div>

        {{-- Total Terbayar (Lunas) --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-xs font-bold uppercase tracking-wider text-emerald-600">Total Terbayar (Lunas)</p>
                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </span>
            </div>
            <p class="mt-2 text-2xl font-black text-emerald-600 tabular-nums">Rp {{ number_format($paidTotal, 0, ',', '.') }}</p>
            <p class="mt-1 text-xs text-slate-500 font-semibold">{{ $paidCount }} faktur telah lunas</p>
        </div>

        {{-- Piutang Usaha (Belum Lunas) --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-xs font-bold uppercase tracking-wider text-[#D91B24]">Piutang (Belum Lunas)</p>
                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-red-50 text-[#D91B24]">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </span>
            </div>
            <p class="mt-2 text-2xl font-black text-[#D91B24] tabular-nums">Rp {{ number_format($unpaidTotal, 0, ',', '.') }}</p>
            <p class="mt-1 text-xs text-slate-500 font-semibold">{{ $unpaidCount }} tagihan menunggu pembayaran</p>
        </div>

        {{-- Jatuh Tempo (Overdue) --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-xs font-bold uppercase tracking-wider text-amber-600">Lewat Jatuh Tempo</p>
                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-amber-50 text-amber-600">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </span>
            </div>
            <p class="mt-2 text-2xl font-black text-amber-700 tabular-nums">{{ $overdueCount }}</p>
            <p class="mt-1 text-xs text-slate-500 font-semibold">
                @if($overdueCount > 0)
                    <span class="font-bold text-[#D91B24]">Perlu tindak lanjut penagihan</span>
                @else
                    Semua tagihan dalam tempo
                @endif
            </p>
        </div>
    </div>

    {{-- Filter & Search Bar --}}
    <form method="GET" action="{{ route('invoices.index') }}"
          class="mb-5 grid gap-3 rounded-2xl border border-slate-200 bg-white p-4 sm:grid-cols-[1fr_220px_auto]">
        <div class="relative">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <input type="search" name="search" value="{{ $search }}"
                   placeholder="Cari nomor faktur, nama toko/pelanggan, sales, atau telepon..."
                   class="w-full rounded-xl border border-slate-300 pl-10 pr-4 py-2.5 text-sm text-slate-800 placeholder:text-slate-400 focus:border-[#0B2D6B] focus:ring-4 focus:ring-blue-100 outline-none transition">
        </div>
        
        <div class="relative">
            <select name="status"
                    class="w-full appearance-none rounded-xl border border-slate-300 bg-white pl-3.5 pr-9 py-2.5 text-sm font-semibold text-slate-700 focus:border-[#0B2D6B] focus:ring-4 focus:ring-blue-100 outline-none transition cursor-pointer">
                <option value="">Semua Status Faktur</option>
                <option value="Belum Lunas" @selected($status === 'Belum Lunas')>Belum Lunas (Unpaid)</option>
                <option value="Lunas" @selected($status === 'Lunas')>Lunas (Paid)</option>
                <option value="Overdue" @selected($status === 'Overdue')>Jatuh Tempo (Overdue)</option>
                <option value="Pending" @selected($status === 'Pending')>Pending / Menunggu Konfirmasi</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                </svg>
            </div>
        </div>

        <div class="flex gap-2">
            <button type="submit"
                    class="rounded-xl bg-[#0B2D6B] px-5 py-2.5 text-sm font-black text-white hover:bg-[#09245a] transition shadow-sm">
                Filter
            </button>
            @if($search || $status)
            <a href="{{ route('invoices.index') }}"
               class="rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-bold text-slate-600 hover:bg-slate-50 transition">
                Reset
            </a>
            @endif
        </div>
    </form>

    {{-- Invoices Table --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr class="text-left text-xs font-black uppercase tracking-wide text-slate-500">
                        <th class="px-5 py-3.5">No. Faktur</th>
                        <th class="px-5 py-3.5">Pelanggan / Toko</th>
                        <th class="px-5 py-3.5">Tgl Transaksi</th>
                        <th class="px-5 py-3.5">Jatuh Tempo</th>
                        <th class="px-5 py-3.5 text-right">Total Tagihan</th>
                        <th class="px-5 py-3.5 text-center">Status</th>
                        <th class="px-5 py-3.5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($invoices as $invoice)
                    <tr class="text-sm text-slate-700 hover:bg-slate-50/70 transition">
                        {{-- No Faktur --}}
                        <td class="px-5 py-4">
                            <a href="{{ route('invoices.show', $invoice) }}"
                               class="font-black text-[#0B2D6B] hover:underline flex items-center gap-1.5">
                                {{ $invoice->invoice_number ?: 'INV-'.str_pad($invoice->id, 5, '0', STR_PAD_LEFT) }}
                            </a>
                            <p class="mt-0.5 text-xs text-slate-400">
                                {{ $invoice->items->count() }} item barang
                                @if($invoice->sales_person)
                                    · Sales: <span class="font-bold text-slate-600">{{ $invoice->sales_person }}</span>
                                @endif
                            </p>
                        </td>

                        {{-- Pelanggan / Toko --}}
                        <td class="px-5 py-4">
                            <p class="font-black text-slate-900">{{ $invoice->customer_name }}</p>
                            @if($invoice->customer_phone)
                                <p class="mt-0.5 text-xs text-slate-500 flex items-center gap-1">
                                    <svg class="h-3 w-3 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    {{ $invoice->customer_phone }}
                                </p>
                            @endif
                        </td>

                        {{-- Tgl Transaksi --}}
                        <td class="px-5 py-4 text-slate-600">
                            {{ optional($invoice->transaction_date ?? $invoice->invoice_date)->format('d M Y') }}
                            @if($invoice->invoice_time)
                                <span class="text-xs text-slate-400 block">{{ substr($invoice->invoice_time, 0, 5) }} WIB</span>
                            @endif
                        </td>

                        {{-- Jatuh Tempo --}}
                        <td class="px-5 py-4">
                            @if($invoice->due_date)
                                <span class="font-medium {{ $invoice->is_overdue ? 'text-[#D91B24] font-bold' : 'text-slate-600' }}">
                                    {{ $invoice->due_date->format('d M Y') }}
                                </span>
                                @if($invoice->is_overdue)
                                    <span class="block mt-0.5 text-[11px] font-black text-[#D91B24] uppercase tracking-wider">
                                        Lewat Tempo
                                    </span>
                                @endif
                            @else
                                <span class="text-slate-400">—</span>
                            @endif
                        </td>

                        {{-- Total Tagihan --}}
                        <td class="px-5 py-4 tabular-nums text-right font-black text-slate-900">
                            Rp {{ number_format($invoice->grand_total ?: $invoice->total, 0, ',', '.') }}
                            @if($invoice->discount > 0)
                                <p class="text-[11px] font-normal text-slate-400">Disc: Rp {{ number_format($invoice->discount, 0, ',', '.') }}</p>
                            @endif
                        </td>

                        {{-- Status Badge --}}
                        <td class="px-5 py-4 text-center">
                            @if($invoice->status === 'Lunas')
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1 text-xs font-black text-emerald-700 border border-emerald-200">
                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                    Lunas
                                </span>
                            @elseif($invoice->is_overdue)
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-red-50 px-3 py-1 text-xs font-black text-[#D91B24] border border-red-200">
                                    <span class="h-1.5 w-1.5 rounded-full bg-red-600 animate-pulse"></span>
                                    Jatuh Tempo
                                </span>
                            @elseif($invoice->status === 'Pending')
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-3 py-1 text-xs font-black text-amber-700 border border-amber-200">
                                    <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                    Pending
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-3 py-1 text-xs font-black text-slate-700 border border-slate-200">
                                    Belum Lunas
                                </span>
                            @endif
                        </td>

                        {{-- Actions --}}
                        <td class="px-5 py-4 text-center">
                            <div class="flex items-center justify-center gap-1.5">
                                {{-- Quick Mark Paid if Unpaid --}}
                                @if($invoice->status !== 'Lunas')
                                <form action="{{ route('invoices.pay', $invoice) }}" method="POST" id="pay-invoice-{{ $invoice->id }}" class="inline">
                                    @csrf @method('PATCH')
                                    <button type="button"
                                            onclick="confirmAction({
                                                title: 'Konfirmasi Pelunasan Faktur',
                                                message: 'Tandai faktur {{ $invoice->invoice_number }} senilai Rp {{ number_format($invoice->total_amount, 0, ',', '.') }} untuk pelanggan {{ addslashes($invoice->customer_name) }} sebagai LUNAS?',
                                                confirmText: 'Ya, Tandai Lunas',
                                                cancelText: 'Batal',
                                                type: 'success',
                                                formId: 'pay-invoice-{{ $invoice->id }}'
                                            })"
                                            title="Tandai Lunas"
                                            class="inline-flex items-center gap-1 rounded-lg bg-emerald-50 px-2.5 py-1.5 text-xs font-black text-emerald-700 hover:bg-emerald-600 hover:text-white transition">
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        Lunas
                                    </button>
                                </form>
                                @endif

                                {{-- View Detail --}}
                                <a href="{{ route('invoices.show', $invoice) }}"
                                   class="rounded-lg bg-[#0B2D6B]/10 px-2.5 py-1.5 text-xs font-black text-[#0B2D6B] hover:bg-[#0B2D6B] hover:text-white transition"
                                   title="Lihat Detail Faktur">
                                    Lihat
                                </a>

                                {{-- Print Commercial Invoice --}}
                                <a href="{{ route('invoices.print', $invoice) }}" target="_blank"
                                   class="rounded-lg border border-slate-200 px-2.5 py-1.5 text-xs font-black text-slate-600 hover:bg-slate-100 transition"
                                   title="Cetak Faktur Penjualan">
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                                    </svg>
                                </a>

                                {{-- Delete --}}
                                <form action="{{ route('invoices.destroy', $invoice) }}" method="POST"
                                      id="delete-invoice-{{ $invoice->id }}" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="button"
                                            onclick="confirmAction({
                                                title: 'Hapus Faktur {{ $invoice->invoice_number }}?',
                                                message: 'Faktur penjualan ini akan dihapus dan seluruh stok produk terkait akan otomatis dikembalikan ke gudang.',
                                                confirmText: 'Ya, Hapus Faktur',
                                                cancelText: 'Batal',
                                                type: 'danger',
                                                formId: 'delete-invoice-{{ $invoice->id }}'
                                            })"
                                            class="rounded-lg bg-red-50 p-1.5 text-xs font-black text-[#D91B24] hover:bg-[#D91B24] hover:text-white transition"
                                            title="Hapus Faktur">
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-5 py-16 text-center">
                            <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-slate-400">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <p class="font-bold text-slate-500">Belum ada faktur invoice yang tercatat.</p>
                            <a href="{{ route('invoices.create') }}"
                               class="mt-3 inline-block rounded-xl bg-[#0B2D6B] px-4 py-2 text-xs font-black text-white hover:bg-[#09245a] transition">
                                + Terbitkan Faktur Pertama
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination & Summary Footer --}}
        <div class="border-t border-slate-100 bg-slate-50/70 px-5 py-4">
            @if($invoices->hasPages())
                {{ $invoices->links() }}
            @else
                <div class="flex items-center justify-between text-xs text-slate-500 font-medium">
                    <p>Menampilkan seluruh <span class="font-bold text-slate-800">{{ $invoices->total() }}</span> faktur penjualan.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
