@extends('layouts.admin')

@section('content')
<div class="mx-auto max-w-5xl">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <p class="text-xs font-black uppercase tracking-[0.25em] text-[#D91B24]">Sistem Penjualan</p>
            <h1 class="mt-1 text-3xl font-black text-[#0B2D6B]">Terbitkan Faktur Penjualan (Invoice)</h1>
            <p class="mt-1 text-sm text-slate-500 font-medium">Buat dokumen faktur resmi B2B untuk bengkel, toko cat, atau dealer mitra.</p>
        </div>
        <a href="{{ route('invoices.index') }}"
           class="inline-flex items-center gap-2 rounded-xl border border-slate-300 px-4 py-2 text-xs font-bold text-slate-700 hover:bg-slate-50 transition">
            ← Kembali ke Daftar
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

    <form action="{{ route('invoices.store') }}" method="POST" id="invoice-form"
          class="space-y-6">
        @csrf

        {{-- Section 1: Data Faktur & Pelanggan --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            <h2 class="text-base font-black text-[#0B2D6B] border-b border-slate-100 pb-3 mb-5 flex items-center gap-2">
                <span class="flex h-6 w-6 items-center justify-center rounded-lg bg-[#0B2D6B] text-white text-xs">1</span>
                Informasi Dokumen &amp; Pelanggan
            </h2>

            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                {{-- No. Faktur --}}
                <div>
                    <label class="text-xs font-black uppercase tracking-wider text-slate-500">Nomor Faktur (Auto)</label>
                    <input type="text" value="{{ $suggestedInvoiceNumber }}" readonly
                           class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm font-bold text-slate-600 outline-none cursor-not-allowed">
                    <p class="mt-1 text-[11px] text-slate-400">Nomor faktur berurutan otomatis</p>
                </div>

                {{-- Tanggal Transaksi --}}
                <div>
                    <label for="transaction_date" class="text-xs font-black uppercase tracking-wider text-slate-700">Tanggal Faktur <span class="text-[#D91B24]">*</span></label>
                    <input id="transaction_date" type="date" name="transaction_date"
                           value="{{ old('transaction_date', date('Y-m-d')) }}" required
                           class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-[#0B2D6B] focus:ring-4 focus:ring-blue-100 outline-none">
                </div>

                {{-- Termin / Jatuh Tempo --}}
                <div>
                    <label for="due_date" class="text-xs font-black uppercase tracking-wider text-slate-700">Tanggal Jatuh Tempo</label>
                    <input id="due_date" type="date" name="due_date"
                           value="{{ old('due_date', date('Y-m-d', strtotime('+30 days'))) }}"
                           class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-[#0B2D6B] focus:ring-4 focus:ring-blue-100 outline-none">
                    <div class="mt-1 flex gap-2 text-[11px]">
                        <button type="button" onclick="setDueDate(0)" class="text-blue-600 font-bold hover:underline">Cash/COD</button>
                        <span class="text-slate-300">·</span>
                        <button type="button" onclick="setDueDate(14)" class="text-blue-600 font-bold hover:underline">14 Hari</button>
                        <span class="text-slate-300">·</span>
                        <button type="button" onclick="setDueDate(30)" class="text-blue-600 font-bold hover:underline">30 Hari</button>
                    </div>
                </div>

                {{-- Nama Pelanggan / Toko --}}
                <div>
                    <label for="customer_name" class="text-xs font-black uppercase tracking-wider text-slate-700">Nama Toko / Pelanggan <span class="text-[#D91B24]">*</span></label>
                    <input id="customer_name" type="text" name="customer_name"
                           value="{{ old('customer_name') }}" placeholder="Contoh: Bengkel Cat Maju Jaya" required
                           class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-[#0B2D6B] focus:ring-4 focus:ring-blue-100 outline-none">
                </div>

                {{-- Telepon / WA --}}
                <div>
                    <label for="customer_phone" class="text-xs font-black uppercase tracking-wider text-slate-700">Telepon / WhatsApp</label>
                    <input id="customer_phone" type="text" name="customer_phone"
                           value="{{ old('customer_phone') }}" placeholder="Contoh: 08123456789"
                           class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-[#0B2D6B] focus:ring-4 focus:ring-blue-100 outline-none">
                </div>

                {{-- Sales Person --}}
                <div>
                    <label for="sales_person" class="text-xs font-black uppercase tracking-wider text-slate-700">Salesman / PIC</label>
                    <input id="sales_person" type="text" name="sales_person"
                           value="{{ old('sales_person') }}" placeholder="Nama sales penanggung jawab"
                           class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-[#0B2D6B] focus:ring-4 focus:ring-blue-100 outline-none">
                </div>

                {{-- Alamat Pengiriman --}}
                <div class="sm:col-span-2">
                    <label for="customer_address" class="text-xs font-black uppercase tracking-wider text-slate-700">Alamat Pengiriman / Workshop</label>
                    <input id="customer_address" type="text" name="customer_address"
                           value="{{ old('customer_address') }}" placeholder="Jalan, Kota, Kabupaten"
                           class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-[#0B2D6B] focus:ring-4 focus:ring-blue-100 outline-none">
                </div>

                {{-- Metode Pembayaran --}}
                <div>
                    <label for="payment_method" class="text-xs font-black uppercase tracking-wider text-slate-700">Metode Pembayaran</label>
                    <select id="payment_method" name="payment_method"
                            class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-[#0B2D6B] outline-none">
                        <option value="Transfer Bank (BCA)">Transfer Bank (BCA PT APS)</option>
                        <option value="Transfer Bank (Mandiri)">Transfer Bank (Mandiri)</option>
                        <option value="Tunai / Cash">Tunai / Cash</option>
                        <option value="Cek / Bilyet Giro">Cek / Bilyet Giro</option>
                    </select>
                </div>

                {{-- Status Pembayaran Awal --}}
                <div>
                    <label for="status" class="text-xs font-black uppercase tracking-wider text-slate-700">Status Pembayaran</label>
                    <select id="status" name="status"
                            class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-bold focus:border-[#0B2D6B] outline-none">
                        <option value="Belum Lunas" @selected(old('status') === 'Belum Lunas')>Belum Lunas (Tempo)</option>
                        <option value="Lunas" @selected(old('status') === 'Lunas')>Lunas (Sudah Dibayar)</option>
                        <option value="Pending" @selected(old('status') === 'Pending')>Pending / Menunggu Konfirmasi</option>
                    </select>
                </div>

                {{-- Catatan --}}
                <div class="sm:col-span-2">
                    <label for="notes" class="text-xs font-black uppercase tracking-wider text-slate-700">Catatan Khusus Faktur</label>
                    <input id="notes" type="text" name="notes"
                           value="{{ old('notes') }}" placeholder="Misal: Nomor PO pelanggan, plat nomor armada pengantar, dll."
                           class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-[#0B2D6B] focus:ring-4 focus:ring-blue-100 outline-none">
                </div>
            </div>
        </div>

        {{-- Section 2: Item Barang --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            <div class="mb-4 flex items-center justify-between border-b border-slate-100 pb-3">
                <h2 class="text-base font-black text-[#0B2D6B] flex items-center gap-2">
                    <span class="flex h-6 w-6 items-center justify-center rounded-lg bg-[#0B2D6B] text-white text-xs">2</span>
                    Daftar Item Produk &amp; Pelapis Cat
                </h2>
                <button type="button" id="add-row"
                        class="inline-flex items-center gap-1.5 rounded-xl bg-[#0B2D6B] px-4 py-2 text-xs font-black text-white hover:bg-[#09245a] transition">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Baris
                </button>
            </div>

            <div class="overflow-x-auto rounded-xl border border-slate-200">
                <table class="min-w-full divide-y divide-slate-200" id="items-table">
                    <thead class="bg-slate-50">
                        <tr class="text-left text-xs font-black uppercase tracking-wide text-slate-500">
                            <th class="px-4 py-3 min-w-[260px]">Produk &amp; Ukuran</th>
                            <th class="px-3 py-3 text-right w-24">Stok</th>
                            <th class="px-3 py-3 text-right w-24">Qty (pcs)</th>
                            <th class="px-4 py-3 text-right w-40">Harga Jual (Rp)</th>
                            <th class="px-4 py-3 text-right w-44">Subtotal</th>
                            <th class="px-3 py-3 text-center w-12"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100" id="items-body"></tbody>
                </table>
            </div>

            {{-- Summary Financial Calculation --}}
            <div class="mt-6 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between border-t border-slate-100 pt-6">
                <div class="max-w-xs text-xs text-slate-500 leading-relaxed">
                    <p class="font-bold text-slate-700 mb-1">Informasi Perhitungan:</p>
                    <p>• PPN 11% dihitung otomatis setelah nilai diskon dikurangkan.</p>
                    <p>• Stok produk akan otomatis dikurangi dari gudang saat faktur disimpan.</p>
                </div>

                <div class="w-full max-w-sm rounded-xl bg-slate-50 p-5 border border-slate-200/80">
                    <dl class="space-y-3 text-sm">
                        <div class="flex justify-between text-slate-600">
                            <dt>Subtotal Barang</dt>
                            <dd id="subtotal" class="tabular-nums font-bold text-slate-800">Rp 0</dd>
                        </div>
                        <div class="flex items-center justify-between text-slate-600 gap-3">
                            <dt>Potongan Diskon (Rp)</dt>
                            <dd>
                                <input id="discount" type="number" min="0" step="1000" name="discount"
                                       value="{{ old('discount', 0) }}"
                                       class="w-32 rounded-lg border border-slate-300 px-3 py-1 text-right text-sm font-bold text-slate-800 outline-none focus:border-[#0B2D6B]">
                            </dd>
                        </div>
                        <div class="flex justify-between text-slate-600">
                            <dt>Dasar Pengenaan Pajak (DPP)</dt>
                            <dd id="dpp-display" class="tabular-nums font-bold text-slate-800">Rp 0</dd>
                        </div>
                        <div class="flex justify-between text-slate-600">
                            <dt>PPN (11%)</dt>
                            <dd id="tax" class="tabular-nums font-bold text-slate-800">Rp 0</dd>
                        </div>
                        <div class="flex justify-between border-t border-slate-200 pt-3 text-base">
                            <dt class="font-black text-[#0B2D6B]">Total Faktur</dt>
                            <dd id="grand-total" class="tabular-nums font-black text-xl text-[#0B2D6B]">Rp 0</dd>
                        </div>
                    </dl>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="mt-8 flex justify-end gap-3 border-t border-slate-100 pt-6">
                <a href="{{ route('invoices.index') }}"
                   class="rounded-xl border border-slate-300 px-5 py-2.5 text-sm font-bold text-slate-700 hover:bg-slate-50 transition">
                    Batal
                </a>
                <button type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#D91B24] px-6 py-2.5 text-sm font-black text-white hover:bg-red-700 transition shadow-sm">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    Terbitkan Faktur Invoice
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    const products = @json($products);
    let rowIdx = 0;

    function setDueDate(days) {
        const transInput = document.getElementById('transaction_date');
        const dueInput = document.getElementById('due_date');
        const baseDate = transInput.value ? new Date(transInput.value) : new Date();
        baseDate.setDate(baseDate.getDate() + days);
        dueInput.value = baseDate.toISOString().split('T')[0];
    }

    function addRow() {
        const tbody = document.getElementById('items-body');
        const tr = document.createElement('tr');
        tr.className = 'text-sm text-slate-700';
        tr.id = `row-${rowIdx}`;

        let options = '<option value="">-- Pilih Produk Huber --</option>';
        products.forEach(p => {
            options += `<option value="${p.id}" data-price="${p.selling_price}" data-stock="${p.stock}" data-box="${p.box_content || 1}">${p.name} (${p.size})</option>`;
        });

        tr.innerHTML = `
            <td class="px-4 py-3">
                <select name="items[${rowIdx}][product_id]" required
                        onchange="onProductSelect(this, ${rowIdx})"
                        class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:border-[#0B2D6B] outline-none">
                    ${options}
                </select>
            </td>
            <td class="px-3 py-3 text-right tabular-nums text-xs font-bold text-slate-500" id="stock-${rowIdx}">
                —
            </td>
            <td class="px-3 py-3 text-right">
                <input type="number" min="1" value="1" name="items[${rowIdx}][quantity]" required
                       oninput="calcRow(${rowIdx})"
                       class="w-20 rounded-xl border border-slate-300 px-2 py-1.5 text-right text-sm font-bold tabular-nums focus:border-[#0B2D6B] outline-none">
            </td>
            <td class="px-4 py-3 text-right">
                <input type="number" min="0" step="1000" name="items[${rowIdx}][price]"
                       oninput="calcRow(${rowIdx})"
                       class="w-32 rounded-xl border border-slate-300 px-3 py-1.5 text-right text-sm font-bold tabular-nums focus:border-[#0B2D6B] outline-none" id="price-${rowIdx}">
            </td>
            <td class="px-4 py-3 text-right font-black tabular-nums text-slate-800" id="subtotal-${rowIdx}">
                Rp 0
            </td>
            <td class="px-3 py-3 text-center">
                <button type="button" onclick="removeRow(${rowIdx})"
                        class="rounded-lg p-1 text-slate-400 hover:bg-red-50 hover:text-[#D91B24] transition">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </td>
        `;

        tbody.appendChild(tr);
        rowIdx++;
    }

    function removeRow(idx) {
        const row = document.getElementById(`row-${idx}`);
        if (row) row.remove();
        calcTotals();
    }

    function onProductSelect(select, idx) {
        const opt = select.selectedOptions[0];
        const price = opt ? opt.dataset.price : 0;
        const stock = opt ? opt.dataset.stock : 0;
        
        document.getElementById(`price-${idx}`).value = price || 0;
        document.getElementById(`stock-${idx}`).innerText = `${stock || 0} pcs`;
        calcRow(idx);
    }

    function calcRow(idx) {
        const tr = document.getElementById(`row-${idx}`);
        if (!tr) return;
        const qty = parseFloat(tr.querySelector('input[name*="[quantity]"]').value) || 0;
        const price = parseFloat(document.getElementById(`price-${idx}`).value) || 0;
        const sub = qty * price;
        document.getElementById(`subtotal-${idx}`).innerText = `Rp ${sub.toLocaleString('id-ID')}`;
        calcTotals();
    }

    function calcTotals() {
        let subtotal = 0;
        const tbody = document.getElementById('items-body');
        tbody.querySelectorAll('tr').forEach(tr => {
            const qty = parseFloat(tr.querySelector('input[name*="[quantity]"]')?.value) || 0;
            const price = parseFloat(tr.querySelector('input[name*="[price]"]')?.value) || 0;
            subtotal += (qty * price);
        });

        const discount = parseFloat(document.getElementById('discount').value) || 0;
        const dpp = Math.max(0, subtotal - discount);
        const tax = Math.round(dpp * 0.11);
        const grand = dpp + tax;

        document.getElementById('subtotal').innerText = `Rp ${subtotal.toLocaleString('id-ID')}`;
        document.getElementById('dpp-display').innerText = `Rp ${dpp.toLocaleString('id-ID')}`;
        document.getElementById('tax').innerText = `Rp ${tax.toLocaleString('id-ID')}`;
        document.getElementById('grand-total').innerText = `Rp ${grand.toLocaleString('id-ID')}`;
    }

    document.getElementById('add-row').addEventListener('click', addRow);
    document.getElementById('discount').addEventListener('input', calcTotals);

    // Tambah 1 baris pertama saat halaman siap
    addRow();
</script>
@endsection
