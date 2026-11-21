<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Faktur Penjualan {{ $invoice->invoice_number }} — PT Auto Prima Sukses</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', Tahoma, Arial, sans-serif; color: #0f172a; font-size: 12px; line-height: 1.5; padding: 24px 32px; background: white; }

        .no-print { text-align: right; margin-bottom: 20px; }
        .btn-print {
            background: #0B2D6B; color: white; border: none; padding: 8px 18px;
            font-weight: 800; font-size: 12px; border-radius: 8px; cursor: pointer;
        }
        .btn-print:hover { background: #09245a; }

        /* Header */
        .inv-header { display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 2px solid #0B2D6B; padding-bottom: 16px; margin-bottom: 16px; }
        .logo-box { display: flex; align-items: center; gap: 12px; }
        .logo-box img { height: 60px; width: 60px; object-fit: contain; border: 1px solid #cbd5e1; border-radius: 8px; padding: 2px; }
        .company-name { font-size: 16px; font-weight: 900; color: #0B2D6B; letter-spacing: -0.02em; }
        .company-sub { font-size: 11px; color: #475569; margin-top: 1px; }

        .meta-box { text-align: right; }
        .doc-title { font-size: 10px; font-weight: 900; letter-spacing: 0.15em; text-transform: uppercase; color: #D91B24; }
        .inv-number { font-size: 18px; font-weight: 900; color: #0B2D6B; margin: 2px 0; }
        .meta-line { font-size: 11px; color: #475569; }

        /* Grid Info */
        .info-grid { display: grid; grid-template-columns: 1.2fr 1fr; gap: 16px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 12px 16px; margin-bottom: 16px; }
        .info-col p { font-size: 11px; margin-bottom: 3px; }
        .info-col strong { color: #0f172a; }
        .info-title { font-size: 9px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.1em; color: #64748b; margin-bottom: 6px; }

        /* Items Table */
        table { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
        thead th { background: #0B2D6B; color: white; padding: 8px 10px; text-align: left; font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; }
        thead th.right { text-align: right; }
        thead th.center { text-align: center; }
        tbody tr { border-bottom: 1px solid #e2e8f0; }
        tbody td { padding: 8px 10px; font-size: 11px; vertical-align: top; }
        td.right { text-align: right; font-variant-numeric: tabular-nums; }
        td.center { text-align: center; }
        .prod-title { font-weight: 700; color: #0f172a; }
        .prod-sku { font-size: 10px; color: #64748b; font-family: monospace; }

        /* Bottom Grid: Instructions & Totals */
        .bottom-grid { display: grid; grid-template-columns: 1.1fr 0.9fr; gap: 16px; margin-bottom: 24px; align-items: start; }
        .bank-box { border: 1px solid #e2e8f0; border-radius: 8px; padding: 10px 14px; background: #fafafa; font-size: 10.5px; }
        .bank-box .bank-title { font-weight: 800; color: #0B2D6B; margin-bottom: 4px; text-transform: uppercase; font-size: 9.5px; letter-spacing: 0.05em; }
        
        .totals-table { width: 100%; border-collapse: collapse; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden; }
        .totals-table td { padding: 5px 12px; font-size: 11px; }
        .totals-table tr.grand td { background: #0B2D6B; color: white; font-weight: 900; font-size: 13px; }

        /* Signatures */
        .sig-grid { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; text-align: center; margin-top: 32px; page-break-inside: avoid; }
        .sig-box { border: 1px dashed #cbd5e1; border-radius: 8px; padding: 12px 8px; min-height: 110px; display: flex; flex-direction: column; justify-content: space-between; }
        .sig-role { font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; color: #475569; }
        .sig-name { font-size: 11px; font-weight: 700; border-top: 1px solid #94a3b8; padding-top: 4px; margin: 0 12px; }

        @media print {
            .no-print { display: none !important; }
            body { padding: 12px 16px; }
        }
    </style>
</head>
<body>

    <div class="no-print">
        <button class="btn-print" onclick="window.print()">
            Cetak Faktur (Print / PDF)
        </button>
    </div>

    <!-- Header -->
    <div class="inv-header">
        <div class="logo-box">
            <img src="{{ public_path('images/logo-aps.jpeg') }}" alt="PT APS" onerror="this.style.display='none'">
            <div>
                <p class="company-name">PT AUTO PRIMA SUKSES</p>
                <p class="company-sub">Distributor Cat &amp; Pelapis Otomotif Huber</p>
                <p class="company-sub">Jawa Timur, Indonesia · autoprimasukses.my.id</p>
            </div>
        </div>
        <div class="meta-box">
            <p class="doc-title">FAKTUR PENJUALAN (SALES INVOICE)</p>
            <p class="inv-number">{{ $invoice->invoice_number }}</p>
            <p class="meta-line">Tanggal: <strong>{{ optional($invoice->transaction_date ?? $invoice->invoice_date)->format('d F Y') }}</strong></p>
            <p class="meta-line">Jatuh Tempo: <strong>{{ $invoice->due_date ? $invoice->due_date->format('d F Y') : 'Cash / COD' }}</strong></p>
        </div>
    </div>

    <!-- Customer & Terms Info -->
    <div class="info-grid">
        <div class="info-col">
            <p class="info-title">Kepada Yth. (Pelanggan / Toko):</p>
            <p>Nama: <strong>{{ $invoice->customer_name }}</strong></p>
            <p>Alamat: {{ $invoice->customer_address ?: '—' }}</p>
            <p>Telepon: {{ $invoice->customer_phone ?: '—' }}</p>
        </div>
        <div class="info-col">
            <p class="info-title">Ketentuan Transaksi:</p>
            <p>Metode Pembayaran: <strong>{{ $invoice->payment_method ?: 'Transfer Bank' }}</strong></p>
            <p>Salesman: <strong>{{ $invoice->sales_person ?: 'Direct / Sales Kantor' }}</strong></p>
            <p>Status: <strong>{{ strtoupper($invoice->status) }}</strong></p>
            @if($invoice->notes)
            <p>Catatan: <em>{{ $invoice->notes }}</em></p>
            @endif
        </div>
    </div>

    <!-- Items Table -->
    <table>
        <thead>
            <tr>
                <th class="center" style="width: 32px;">No</th>
                <th>Nama Barang &amp; Deskripsi Produk</th>
                <th class="center" style="width: 70px;">Ukuran</th>
                <th class="right" style="width: 60px;">Qty</th>
                <th class="right" style="width: 110px;">Harga Satuan</th>
                <th class="right" style="width: 120px;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->items as $idx => $item)
            <tr>
                <td class="center">{{ $idx + 1 }}</td>
                <td>
                    <p class="prod-title">{{ $item->product->name ?? 'Produk Huber' }}</p>
                    @if(optional($item->product)->sku)
                    <p class="prod-sku">SKU: {{ $item->product->sku }}</p>
                    @endif
                </td>
                <td class="center">{{ $item->product->size ?? '-' }}</td>
                <td class="right font-bold">{{ $item->quantity }} pcs</td>
                <td class="right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                <td class="right font-bold">Rp {{ number_format($item->total ?: ($item->quantity * $item->price), 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Bottom Totals & Payment Info -->
    <div class="bottom-grid">
        <div class="bank-box">
            <p class="bank-title">Instruksi Pembayaran Transfer Bank:</p>
            <p>Pembayaran resmi ditujukan ke rekening perusahaan:</p>
            <p style="margin-top:4px;"><strong>Bank Central Asia (BCA)</strong></p>
            <p>No. Rekening: <strong style="font-size:12px; font-family:monospace; color:#0B2D6B;">8290-888-999</strong></p>
            <p>Atas Nama: <strong>PT AUTO PRIMA SUKSES</strong></p>
            <p style="margin-top:6px; font-size:9.5px; color:#64748b;">
                *Mohon mencantumkan no faktur <strong>{{ $invoice->invoice_number }}</strong> saat transfer.
            </p>
        </div>

        <div>
            <table class="totals-table">
                <tr>
                    <td>Subtotal</td>
                    <td class="right font-bold">Rp {{ number_format($invoice->subtotal, 0, ',', '.') }}</td>
                </tr>
                @if($invoice->discount > 0)
                <tr>
                    <td style="color:#D91B24;">Diskon</td>
                    <td class="right font-bold" style="color:#D91B24;">- Rp {{ number_format($invoice->discount, 0, ',', '.') }}</td>
                </tr>
                @endif
                <tr>
                    <td>Dasar Pengenaan Pajak (DPP)</td>
                    <td class="right font-bold">Rp {{ number_format(max(0, $invoice->subtotal - $invoice->discount), 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>PPN (11%)</td>
                    <td class="right font-bold">Rp {{ number_format($invoice->tax_ppn ?: $invoice->tax, 0, ',', '.') }}</td>
                </tr>
                <tr class="grand">
                    <td>TOTAL FAKTUR</td>
                    <td class="right">Rp {{ number_format($invoice->grand_total ?: $invoice->total, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Signatures -->
    <div class="sig-grid">
        <div class="sig-box">
            <p class="sig-role">Penerima / Toko</p>
            <p class="sig-name">( {{ $invoice->customer_name }} )</p>
        </div>
        <div class="sig-box">
            <p class="sig-role">Pengirim / Ekspedisi</p>
            <p class="sig-name">( Sopir / Ekspedisi )</p>
        </div>
        <div class="sig-box">
            <p class="sig-role">Hormat Kami</p>
            <p class="sig-name">PT AUTO PRIMA SUKSES</p>
        </div>
    </div>

</body>
</html>
