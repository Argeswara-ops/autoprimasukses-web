<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Jalan {{ $invoice->invoice_number }} — PT Auto Prima Sukses</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', Tahoma, Arial, sans-serif; color: #0f172a; font-size: 12px; line-height: 1.5; padding: 24px 32px; background: white; }

        .no-print { text-align: right; margin-bottom: 20px; }
        .btn-print {
            background: #0B2D6B; color: white; border: none; padding: 8px 18px;
            font-weight: 800; font-size: 12px; border-radius: 8px; cursor: pointer;
        }

        /* Header */
        .inv-header { display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 2px solid #0B2D6B; padding-bottom: 16px; margin-bottom: 16px; }
        .logo-box { display: flex; align-items: center; gap: 12px; }
        .logo-box img { height: 60px; width: 60px; object-fit: contain; border: 1px solid #cbd5e1; border-radius: 8px; padding: 2px; }
        .company-name { font-size: 16px; font-weight: 900; color: #0B2D6B; }
        .company-sub { font-size: 11px; color: #475569; margin-top: 1px; }

        .meta-box { text-align: right; }
        .doc-title { font-size: 11px; font-weight: 900; letter-spacing: 0.15em; text-transform: uppercase; color: #0B2D6B; }
        .inv-number { font-size: 18px; font-weight: 900; color: #0B2D6B; margin: 2px 0; }
        .meta-line { font-size: 11px; color: #475569; }

        /* Grid Info */
        .info-grid { display: grid; grid-template-columns: 1.3fr 1fr; gap: 16px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 12px 16px; margin-bottom: 16px; }
        .info-col p { font-size: 11px; margin-bottom: 3px; }
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

        /* Signatures */
        .sig-grid { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; text-align: center; margin-top: 40px; page-break-inside: avoid; }
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
            Cetak Surat Jalan (Print / PDF)
        </button>
    </div>

    <!-- Header -->
    <div class="inv-header">
        <div class="logo-box">
            <img src="{{ public_path('images/logo-aps.jpeg') }}" alt="PT APS" onerror="this.style.display='none'">
            <div>
                <p class="company-name">PT AUTO PRIMA SUKSES</p>
                <p class="company-sub">Gudang &amp; Distribusi Logistik Huber</p>
                <p class="company-sub">Jawa Timur, Indonesia</p>
            </div>
        </div>
        <div class="meta-box">
            <p class="doc-title">SURAT JALAN / DELIVERY ORDER</p>
            <p class="inv-number">{{ str_replace('APS-INV-', 'APS-SJ-', $invoice->invoice_number) }}</p>
            <p class="meta-line">Ref. Faktur: <strong>{{ $invoice->invoice_number }}</strong></p>
            <p class="meta-line">Tanggal Kirim: <strong>{{ optional($invoice->transaction_date ?? $invoice->invoice_date)->format('d F Y') }}</strong></p>
        </div>
    </div>

    <!-- Info Grid -->
    <div class="info-grid">
        <div class="info-col">
            <p class="info-title">Tujuan Pengiriman / Penerima:</p>
            <p>Toko/Bengkel: <strong>{{ $invoice->customer_name }}</strong></p>
            <p>Alamat Pengiriman: <strong>{{ $invoice->customer_address ?: '—' }}</strong></p>
            <p>Kontak Telepon: {{ $invoice->customer_phone ?: '—' }}</p>
        </div>
        <div class="info-col">
            <p class="info-title">Keterangan Ekspedisi &amp; Armada:</p>
            <p>Salesman: <strong>{{ $invoice->sales_person ?: 'Direct Sales' }}</strong></p>
            @if($invoice->notes)
            <p>Instruksi Supir: <em>{{ $invoice->notes }}</em></p>
            @endif
            <p style="margin-top:6px; font-size:10px; color:#64748b;">
                *Barang telah diperiksa dalam kondisi baik dan lengkap sebelum diberangkatkan dari gudang.
            </p>
        </div>
    </div>

    <!-- Items Table -->
    <table>
        <thead>
            <tr>
                <th class="center" style="width: 36px;">No</th>
                <th>Nama Produk &amp; Spesifikasi</th>
                <th class="center" style="width: 80px;">Ukuran</th>
                <th class="right" style="width: 90px;">Jumlah Fisik</th>
                <th class="center" style="width: 100px;">Kondisi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->items as $idx => $item)
            <tr>
                <td class="center">{{ $idx + 1 }}</td>
                <td>
                    <p style="font-weight:700; color:#0f172a;">{{ $item->product->name ?? 'Produk Huber' }}</p>
                    @if(optional($item->product)->sku)
                    <p style="font-size:10px; color:#64748b; font-family:monospace;">SKU: {{ $item->product->sku }}</p>
                    @endif
                </td>
                <td class="center">{{ $item->product->size ?? '-' }}</td>
                <td class="right font-bold" style="font-size:12px;">{{ $item->quantity }} pcs</td>
                <td class="center text-xs">[ &nbsp; ] Baik</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Signatures -->
    <div class="sig-grid">
        <div class="sig-box">
            <p class="sig-role">Penerima Toko / Bengkel</p>
            <p style="font-size:9px; color:#64748b; margin-bottom:auto;">Barang diterima lengkap &amp; baik</p>
            <p class="sig-name">( Nama &amp; Cap Toko )</p>
        </div>
        <div class="sig-box">
            <p class="sig-role">Pengantar / Driver</p>
            <p style="font-size:9px; color:#64748b; margin-bottom:auto;">Telah diserahkan</p>
            <p class="sig-name">( Sopir / Kurir )</p>
        </div>
        <div class="sig-box">
            <p class="sig-role">Petugas Gudang APS</p>
            <p style="font-size:9px; color:#64748b; margin-bottom:auto;">Dikeluarkan dari gudang</p>
            <p class="sig-name">PT AUTO PRIMA SUKSES</p>
        </div>
    </div>

</body>
</html>
