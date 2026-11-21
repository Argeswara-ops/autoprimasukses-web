@extends('layouts.admin')

@section('content')
<div class="mx-auto max-w-4xl">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <p class="text-xs font-black uppercase tracking-[0.25em] text-[#D91B24]">Sistem Penjualan</p>
            <h1 class="mt-1 text-3xl font-black text-[#0B2D6B]">Edit Faktur {{ $invoice->invoice_number }}</h1>
            <p class="mt-1 text-sm text-slate-500 font-medium">Perbarui status pembayaran, termin jatuh tempo, atau informasi pelanggan.</p>
        </div>
        <a href="{{ route('invoices.show', $invoice) }}"
           class="inline-flex items-center gap-2 rounded-xl border border-slate-300 px-4 py-2 text-xs font-bold text-slate-700 hover:bg-slate-50 transition">
            ← Kembali ke Faktur
        </a>
    </div>

    @if ($errors->any())
    <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4">
        <p class="text-sm font-bold text-[#D91B24]">Mohon periksa data formulir berikut:</p>
        <ul class="mt-2 list-disc pl-5 text-xs text-red-700 space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('invoices.update', $invoice) }}" method="POST"
          class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8 space-y-6">
        @csrf
        @method('PUT')

        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <label class="text-xs font-black uppercase tracking-wider text-slate-400">Nomor Faktur</label>
                <input type="text" value="{{ $invoice->invoice_number }}" readonly
                       class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-100 px-4 py-2.5 text-sm font-bold text-slate-600 outline-none cursor-not-allowed">
            </div>

            <div>
                <label for="status" class="text-xs font-black uppercase tracking-wider text-slate-700">Status Pembayaran <span class="text-[#D91B24]">*</span></label>
                <select id="status" name="status"
                        class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-bold focus:border-[#0B2D6B] outline-none">
                    <option value="Belum Lunas" @selected(old('status', $invoice->status) === 'Belum Lunas')>Belum Lunas (Tempo)</option>
                    <option value="Lunas" @selected(old('status', $invoice->status) === 'Lunas')>Lunas (Sudah Dibayar)</option>
                    <option value="Pending" @selected(old('status', $invoice->status) === 'Pending')>Pending / Menunggu Konfirmasi</option>
                </select>
            </div>

            <div>
                <label for="customer_name" class="text-xs font-black uppercase tracking-wider text-slate-700">Nama Pelanggan / Toko <span class="text-[#D91B24]">*</span></label>
                <input id="customer_name" type="text" name="customer_name"
                       value="{{ old('customer_name', $invoice->customer_name) }}" required
                       class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-[#0B2D6B] outline-none">
            </div>

            <div>
                <label for="customer_phone" class="text-xs font-black uppercase tracking-wider text-slate-700">Telepon / WhatsApp</label>
                <input id="customer_phone" type="text" name="customer_phone"
                       value="{{ old('customer_phone', $invoice->customer_phone) }}"
                       class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-[#0B2D6B] outline-none">
            </div>

            <div class="sm:col-span-2">
                <label for="customer_address" class="text-xs font-black uppercase tracking-wider text-slate-700">Alamat Pengiriman</label>
                <input id="customer_address" type="text" name="customer_address"
                       value="{{ old('customer_address', $invoice->customer_address) }}"
                       class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-[#0B2D6B] outline-none">
            </div>

            <div>
                <label for="transaction_date" class="text-xs font-black uppercase tracking-wider text-slate-700">Tanggal Faktur <span class="text-[#D91B24]">*</span></label>
                <input id="transaction_date" type="date" name="transaction_date"
                       value="{{ old('transaction_date', optional($invoice->transaction_date ?? $invoice->invoice_date)->format('Y-m-d')) }}" required
                       class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-[#0B2D6B] outline-none">
            </div>

            <div>
                <label for="due_date" class="text-xs font-black uppercase tracking-wider text-slate-700">Tanggal Jatuh Tempo</label>
                <input id="due_date" type="date" name="due_date"
                       value="{{ old('due_date', optional($invoice->due_date)->format('Y-m-d')) }}"
                       class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-[#0B2D6B] outline-none">
            </div>

            <div>
                <label for="payment_method" class="text-xs font-black uppercase tracking-wider text-slate-700">Metode Pembayaran</label>
                <select id="payment_method" name="payment_method"
                        class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-[#0B2D6B] outline-none">
                    <option value="Transfer Bank (BCA)" @selected(old('payment_method', $invoice->payment_method) === 'Transfer Bank (BCA)')>Transfer Bank (BCA PT APS)</option>
                    <option value="Transfer Bank (Mandiri)" @selected(old('payment_method', $invoice->payment_method) === 'Transfer Bank (Mandiri)')>Transfer Bank (Mandiri)</option>
                    <option value="Tunai / Cash" @selected(old('payment_method', $invoice->payment_method) === 'Tunai / Cash')>Tunai / Cash</option>
                    <option value="Cek / Bilyet Giro" @selected(old('payment_method', $invoice->payment_method) === 'Cek / Bilyet Giro')>Cek / Bilyet Giro</option>
                </select>
            </div>

            <div>
                <label for="sales_person" class="text-xs font-black uppercase tracking-wider text-slate-700">Salesman / PIC</label>
                <input id="sales_person" type="text" name="sales_person"
                       value="{{ old('sales_person', $invoice->sales_person) }}"
                       class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-[#0B2D6B] outline-none">
            </div>

            <div class="sm:col-span-2">
                <label for="notes" class="text-xs font-black uppercase tracking-wider text-slate-700">Catatan</label>
                <input id="notes" type="text" name="notes"
                       value="{{ old('notes', $invoice->notes) }}"
                       class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-[#0B2D6B] outline-none">
            </div>
        </div>

        <div class="flex justify-end gap-3 border-t border-slate-100 pt-6">
            <a href="{{ route('invoices.show', $invoice) }}"
               class="rounded-xl border border-slate-300 px-5 py-2.5 text-sm font-bold text-slate-700 hover:bg-slate-50 transition">
                Batal
            </a>
            <button type="submit"
                    class="rounded-xl bg-[#0B2D6B] px-6 py-2.5 text-sm font-black text-white hover:bg-[#09245a] transition shadow-sm">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
