@extends('layouts.admin')

@section('content')
<div class="mx-auto max-w-4xl">
    {{-- Action Bar --}}
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between print:hidden">
        <a href="{{ route('invoices.index') }}"
           class="inline-flex items-center gap-2 text-xs font-bold text-slate-500 hover:text-[#0B2D6B] transition">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke Daftar Faktur
        </a>

        <div class="flex flex-wrap items-center gap-2">
            {{-- Quick Mark Paid Button --}}
            @if($invoice->status !== 'Lunas')
            <form action="{{ route('invoices.pay', $invoice) }}" method="POST" id="pay-invoice-detail-{{ $invoice->id }}" class="inline">
                @csrf @method('PATCH')
                <button type="button"
                        onclick="confirmAction({
                            title: 'Konfirmasi Pelunasan Faktur',
                            message: 'Tandai faktur {{ $invoice->invoice_number }} senilai Rp {{ number_format($invoice->total_amount, 0, ',', '.') }} untuk pelanggan {{ addslashes($invoice->customer_name) }} sebagai LUNAS?',
                            confirmText: 'Ya, Tandai Lunas',
                            cancelText: 'Batal',
                            type: 'success',
                            formId: 'pay-invoice-detail-{{ $invoice->id }}'
                        })"
                        class="inline-flex items-center gap-1.5 rounded-xl bg-emerald-600 px-4 py-2 text-xs font-black text-white hover:bg-emerald-700 shadow-sm transition">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    Tandai Lunas
                </button>
            </form>
            @endif

            {{-- Edit --}}
            <a href="{{ route('invoices.edit', $invoice) }}"
               class="inline-flex items-center gap-1.5 rounded-xl border border-slate-300 bg-white px-3.5 py-2 text-xs font-bold text-slate-700 hover:bg-slate-50 shadow-sm transition">
                <svg class="h-3.5 w-3.5 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit
            </a>

            {{-- Print Delivery Order --}}
            <a href="{{ route('invoices.delivery_order', $invoice) }}" target="_blank"
               class="inline-flex items-center gap-1.5 rounded-xl border border-blue-200 bg-blue-50 px-3.5 py-2 text-xs font-bold text-[#0B2D6B] hover:bg-blue-100 shadow-sm transition">
                <svg class="h-3.5 w-3.5 text-[#0B2D6B]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                </svg>
                Surat Jalan (DO)
            </a>

            {{-- Print Commercial Invoice --}}
            <a href="{{ route('invoices.print', $invoice) }}" target="_blank"
               class="inline-flex items-center gap-1.5 rounded-xl bg-[#0B2D6B] px-4 py-2 text-xs font-black text-white hover:bg-[#09245a] shadow-sm transition">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Cetak Faktur
            </a>

            {{-- Delete --}}
            <form action="{{ route('invoices.destroy', $invoice) }}" method="POST"
                  id="delete-invoice-detail-{{ $invoice->id }}" class="inline">
                @csrf @method('DELETE')
                <button type="button"
                        onclick="confirmAction({
                            title: 'Hapus Faktur {{ $invoice->invoice_number }}?',
                            message: 'Faktur penjualan ini akan dihapus secara permanen dan seluruh stok produk terkait akan otomatis dikembalikan ke gudang.',
                            confirmText: 'Ya, Hapus Faktur',
                            cancelText: 'Batal',
                            type: 'danger',
                            formId: 'delete-invoice-detail-{{ $invoice->id }}'
                        })"
                        class="inline-flex items-center justify-center rounded-xl border border-red-200 bg-white p-2 text-xs font-bold text-[#D91B24] hover:bg-red-50 transition"
                        title="Hapus Faktur">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </button>
            </form>
        </div>
    </div>

    {{-- Status Banner --}}
    @if($invoice->status === 'Lunas')
    <div class="mb-5 flex items-center justify-between rounded-2xl border border-emerald-200 bg-emerald-50 px-6 py-4 text-emerald-800">
        <div class="flex items-center gap-3">
            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-emerald-600 text-white">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
            </span>
            <div>
                <p class="font-black text-sm text-emerald-950">FAKTUR SUDAH LUNAS</p>
                <p class="text-xs text-emerald-700">
                    Pembayaran diterima via <strong>{{ $invoice->payment_method ?: 'Transfer Bank' }}</strong>
                    @if($invoice->payment_date) pada tanggal {{ $invoice->payment_date->format('d M Y') }} @endif.
                </p>
            </div>
        </div>
        <span class="rounded-full bg-emerald-600 px-3 py-1 text-xs font-black text-white uppercase tracking-wider">
            Lunas
        </span>
    </div>
    @elseif($invoice->is_overdue)
    <div class="mb-5 flex items-center justify-between rounded-2xl border border-red-200 bg-red-50 px-6 py-4 text-red-800">
        <div class="flex items-center gap-3">
            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-[#D91B24] text-white">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </span>
            <div>
                <p class="font-black text-sm text-red-950">FAKTUR LEWAT JATUH TEMPO (OVERDUE)</p>
                <p class="text-xs text-red-700">
                    Tenggat pembayaran telah lewat sejak <strong>{{ $invoice->due_date ? $invoice->due_date->format('d M Y') : '-' }}</strong>. Mohon segera hubungi pelanggan untuk penagihan.
                </p>
            </div>
        </div>
        <span class="rounded-full bg-[#D91B24] px-3 py-1 text-xs font-black text-white uppercase tracking-wider">
            Jatuh Tempo
        </span>
    </div>
    @else
    <div class="mb-5 flex items-center justify-between rounded-2xl border border-blue-200 bg-blue-50 px-6 py-4 text-blue-900">
        <div class="flex items-center gap-3">
            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-[#0B2D6B] text-white">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </span>
            <div>
                <p class="font-black text-sm text-[#0B2D6B]">FAKTUR BELUM LUNAS (TEMPO)</p>
                <p class="text-xs text-slate-600">
                    Jatuh tempo pada <strong>{{ $invoice->due_date ? $invoice->due_date->format('d M Y') : 'Cash on Delivery' }}</strong> via {{ $invoice->payment_method ?: 'Transfer Bank' }}.
                </p>
            </div>
        </div>
        <span class="rounded-full bg-slate-200 px-3 py-1 text-xs font-black text-slate-700 uppercase tracking-wider">
            Belum Lunas
        </span>
    </div>
    @endif

    {{-- Invoice Document Card --}}
    <article class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        {{-- Header --}}
        <header class="border-b border-slate-200 bg-[#0B2D6B] px-6 py-8 text-white sm:px-10">
            <div class="flex flex-col gap-6 sm:flex-row sm:items-start sm:justify-between">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('images/logo-aps.jpeg') }}" alt="PT Auto Prima Sukses"
                         class="h-16 w-16 rounded-xl bg-white object-contain p-1 shadow">
                    <div>
                        <h1 class="text-xl font-black text-white">PT AUTO PRIMA SUKSES</h1>
                        <p class="mt-0.5 text-xs text-blue-200">Distributor Resmi Cat &amp; Pelapis Otomotif Huber</p>
                        <p class="text-[11px] text-blue-300 mt-0.5">Jawa Timur, Indonesia · autoprimasukses.my.id</p>
                    </div>
                </div>
                <div class="text-left sm:text-right">
                    <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-blue-300">FAKTUR PENJUALAN (INVOICE)</p>
                    <p class="mt-1 text-2xl font-black text-white tabular-nums">{{ $invoice->invoice_number }}</p>
                    <p class="mt-1 text-xs text-blue-200">
                        Tgl Terbit: {{ optional($invoice->transaction_date ?? $invoice->invoice_date)->format('d M Y') }}
                    </p>
                    @if($invoice->due_date)
                    <p class="text-xs text-blue-200 mt-0.5">
                        Jatuh Tempo: <strong>{{ $invoice->due_date->format('d M Y') }}</strong>
                    </p>
                    @endif
                </div>
            </div>
        </header>

        <div class="px-6 py-8 sm:px-10">
            {{-- Info Pelanggan & Termin --}}
            <div class="mb-8 grid gap-4 rounded-xl bg-slate-50 p-5 sm:grid-cols-3 border border-slate-200/80">
                <div>
                    <p class="text-[10px] font-black uppercase tracking-wider text-slate-400">Kepada Yth. (Pelanggan)</p>
                    <p class="mt-1.5 text-base font-black text-slate-900">{{ $invoice->customer_name }}</p>
                    @if($invoice->customer_phone)
                        <p class="mt-1 text-xs font-semibold text-slate-600">Telp: {{ $invoice->customer_phone }}</p>
                    @endif
                </div>
                <div>
                    <p class="text-[10px] font-black uppercase tracking-wider text-slate-400">Alamat Workshop / Kirim</p>
                    <p class="mt-1.5 text-xs leading-relaxed text-slate-700">{{ $invoice->customer_address ?: '—' }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-black uppercase tracking-wider text-slate-400">Ketentuan Pembayaran</p>
                    <p class="mt-1.5 text-xs text-slate-700">Metode: <strong>{{ $invoice->payment_method ?: 'Transfer Bank' }}</strong></p>
                    @if($invoice->sales_person)
                        <p class="mt-1 text-xs text-slate-700">Salesman: <strong>{{ $invoice->sales_person }}</strong></p>
                    @endif
                    @if($invoice->notes)
                        <p class="mt-1 text-xs text-slate-500 italic">Catatan: {{ $invoice->notes }}</p>
                    @endif
                </div>
            </div>

            {{-- Items Table --}}
            <div class="overflow-x-auto rounded-xl border border-slate-200">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr class="text-left text-xs font-black uppercase tracking-wide text-slate-500">
                            <th class="px-4 py-3 w-10 text-center">No</th>
                            <th class="px-4 py-3">Nama Produk &amp; Spesifikasi</th>
                            <th class="px-4 py-3 text-center w-28">Ukuran</th>
                            <th class="px-4 py-3 text-right w-24">Qty</th>
                            <th class="px-4 py-3 text-right w-36">Harga Satuan</th>
                            <th class="px-4 py-3 text-right w-40">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($invoice->items as $index => $item)
                        <tr class="text-sm text-slate-700 hover:bg-slate-50/50">
                            <td class="px-4 py-3.5 text-center text-xs font-bold text-slate-400">{{ $index + 1 }}</td>
                            <td class="px-4 py-3.5">
                                <p class="font-black text-slate-900">{{ $item->product->name ?? 'Produk Huber' }}</p>
                                @if(optional($item->product)->sku)
                                    <p class="text-[11px] text-slate-400 font-mono">SKU: {{ $item->product->sku }}</p>
                                @endif
                            </td>
                            <td class="px-4 py-3.5 text-center">
                                <span class="rounded-full border border-slate-200 bg-slate-100 px-2.5 py-1 text-xs font-bold text-slate-700">
                                    {{ $item->product->size ?? '-' }}
                                </span>
                            </td>
                            <td class="px-4 py-3.5 text-right font-black tabular-nums">
                                {{ $item->quantity }} pcs
                            </td>
                            <td class="px-4 py-3.5 text-right tabular-nums text-slate-600">
                                Rp {{ number_format($item->price, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-3.5 text-right tabular-nums font-black text-slate-900">
                                Rp {{ number_format($item->total ?: ($item->quantity * $item->price), 0, ',', '.') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Totals & Bank Account --}}
            <div class="mt-8 grid gap-6 lg:grid-cols-[1.1fr_0.9fr] items-start">
                {{-- Payment Instructions --}}
                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
                    <p class="text-xs font-black uppercase tracking-wider text-[#0B2D6B] mb-2 flex items-center gap-1.5">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                        Instruksi Rekening Pembayaran
                    </p>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Pembayaran tagihan faktur penjualan dapat ditransfer secara resmi ke rekening perusahaan kami:
                    </p>
                    <div class="mt-3 space-y-2 rounded-xl bg-white p-3.5 border border-slate-200/80 text-xs font-medium text-slate-700">
                        <div class="flex justify-between items-center">
                            <span class="text-slate-400 font-bold">Bank:</span>
                            <strong class="text-slate-900 font-black">Bank Central Asia (BCA)</strong>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-slate-400 font-bold">Atas Nama:</span>
                            <strong class="text-slate-900 font-black">PT AUTO PRIMA SUKSES</strong>
                        </div>
                        <div class="flex justify-between items-center border-t border-slate-100 pt-2">
                            <span class="text-slate-400 font-bold">Nomor Rekening:</span>
                            <span class="font-mono font-black text-[#0B2D6B] text-sm">8290-888-999</span>
                        </div>
                    </div>
                    <p class="mt-3 text-[11px] text-slate-400">
                        *Harap cantumkan nomor faktur <strong class="text-slate-600">{{ $invoice->invoice_number }}</strong> pada berita transfer.
                    </p>
                </div>

                {{-- Financial Totals Box --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <dl class="space-y-3 text-sm">
                        <div class="flex justify-between text-slate-600">
                            <dt>Subtotal Barang</dt>
                            <dd class="tabular-nums font-bold text-slate-900">
                                Rp {{ number_format($invoice->subtotal, 0, ',', '.') }}
                            </dd>
                        </div>
                        @if($invoice->discount > 0)
                        <div class="flex justify-between text-[#D91B24]">
                            <dt>Potongan Diskon</dt>
                            <dd class="tabular-nums font-bold">
                                - Rp {{ number_format($invoice->discount, 0, ',', '.') }}
                            </dd>
                        </div>
                        @endif
                        <div class="flex justify-between text-slate-600">
                            <dt>Dasar Pengenaan Pajak (DPP)</dt>
                            <dd class="tabular-nums font-bold text-slate-900">
                                Rp {{ number_format(max(0, $invoice->subtotal - $invoice->discount), 0, ',', '.') }}
                            </dd>
                        </div>
                        <div class="flex justify-between text-slate-600">
                            <dt>PPN (11%)</dt>
                            <dd class="tabular-nums font-bold text-slate-900">
                                Rp {{ number_format($invoice->tax_ppn ?: $invoice->tax, 0, ',', '.') }}
                            </dd>
                        </div>
                        <div class="flex justify-between border-t-2 border-slate-200 pt-3 text-base">
                            <dt class="font-black text-[#0B2D6B]">Grand Total</dt>
                            <dd class="tabular-nums font-black text-xl text-[#0B2D6B]">
                                Rp {{ number_format($invoice->grand_total ?: $invoice->total, 0, ',', '.') }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </article>
</div>
@endsection
