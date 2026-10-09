<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $service->invoice_number ?: $service->code }}</title>
    <style>
        @page { margin: 24px 30px; }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #1e293b;
            font-size: 11.5px;
            line-height: 1.4;
            margin: 0;
            padding: 0;
        }
        .header {
            border-bottom: 2.5px solid #f59e0b;
            padding-bottom: 12px;
            margin-bottom: 16px;
        }
        .header table { width: 100%; border-collapse: collapse; }
        .brand-name {
            font-size: 24px;
            font-weight: 900;
            letter-spacing: -0.5px;
            color: #0f172a;
            margin: 0;
        }
        .brand-name span { color: #f59e0b; }
        .brand-tagline {
            font-size: 9.5px;
            font-weight: bold;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-top: 2px;
        }
        .brand-contact {
            font-size: 9.5px;
            color: #64748b;
            margin-top: 4px;
            line-height: 1.3;
        }
        .doc-title {
            text-align: right;
            vertical-align: top;
        }
        .doc-title h1 {
            font-size: 22px;
            font-weight: 900;
            margin: 0;
            color: #0f172a;
            letter-spacing: 1px;
        }
        .doc-badge {
            display: inline-block;
            background: #fef3c7;
            color: #92400e;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
            margin-top: 4px;
        }
        .info-grid {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
        }
        .info-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 10px 12px;
            vertical-align: top;
        }
        .info-card h4 {
            margin: 0 0 6px 0;
            font-size: 10.5px;
            text-transform: uppercase;
            color: #475569;
            letter-spacing: 0.5px;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 4px;
        }
        .info-table { width: 100%; font-size: 10.5px; }
        .info-table td { padding: 2px 0; vertical-align: top; }
        .info-table td.label { color: #64748b; width: 35%; }
        .info-table td.val { font-weight: 600; color: #0f172a; }

        table.items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }
        table.items-table th {
            background: #0f172a;
            color: #ffffff;
            font-size: 9.5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 7px 8px;
            text-align: left;
        }
        table.items-table th.num, table.items-table td.num { text-align: right; }
        table.items-table td {
            padding: 7px 8px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 10.5px;
            vertical-align: middle;
        }
        table.items-table tr:nth-child(even) td { background: #fcfcfd; }

        .vendor-tag {
            display: inline-block;
            background: #f1f5f9;
            color: #475569;
            border: 1px dashed #cbd5e1;
            padding: 1px 6px;
            border-radius: 3px;
            font-size: 8.5px;
            font-weight: 600;
        }

        .totals-table {
            width: 48%;
            margin-left: auto;
            margin-top: 12px;
            border-collapse: collapse;
        }
        .totals-table td {
            padding: 3px 6px;
            font-size: 10.5px;
        }
        .totals-table tr.grand-total td {
            border-top: 2px solid #0f172a;
            font-size: 13px;
            font-weight: 900;
            color: #0f172a;
            padding-top: 6px;
        }

        .payment-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-left: 3px solid #f59e0b;
            border-radius: 4px;
            padding: 8px 12px;
            font-size: 10px;
            margin-top: 14px;
        }

        .signatures {
            margin-top: 30px;
            width: 100%;
            border-collapse: collapse;
        }
        .signatures td {
            width: 50%;
            text-align: center;
            vertical-align: top;
            font-size: 10px;
        }
        .sig-line {
            margin: 50px auto 4px auto;
            width: 65%;
            border-bottom: 1px solid #475569;
        }
        .footer {
            margin-top: 24px;
            border-top: 1px solid #e2e8f0;
            padding-top: 6px;
            text-align: center;
            font-size: 9px;
            color: #94a3b8;
        }
    </style>
</head>
<body>
    <div class="header">
        <table>
            <tr>
                <td style="width: 55%; vertical-align: top;">
                    <div class="brand-name">KEETECH <span>• KEEHUB</span></div>
                    <div class="brand-tagline">IT Solutions & PC Hardware Specialist</div>
                    <div class="brand-contact">
                        Jl. IT Technology Hub • WhatsApp: {{ \App\Models\Setting::get('whatsapp_number', '0812-3456-7890') }}<br>
                        Email: billing@keetech.id • Website: {{ config('app.url') }}
                    </div>
                </td>
                <td class="doc-title">
                    <h1>INVOICE</h1>
                    <div style="font-size: 12px; font-weight: bold; color: #f59e0b; margin-top: 2px;">
                        {{ $service->invoice_number ?: $service->code }}
                    </div>
                    <div class="doc-badge">NO. SERVIS: {{ $service->code }}</div>
                    <div style="font-size: 9.5px; color: #64748b; margin-top: 4px;">Tanggal: {{ now()->format('d M Y') }}</div>
                </td>
            </tr>
        </table>
    </div>

    <table class="info-grid">
        <tr>
            <td class="info-card" style="width: 48%;">
                <h4>Ditagihkan Kepada (Klien / B2B)</h4>
                <table class="info-table">
                    <tr><td class="label">Nama:</td><td class="val">{{ $service->customer?->name ?? 'Walk-in Customer' }}</td></tr>
                    @if($service->company_name)
                        <tr><td class="label">Perusahaan:</td><td class="val" style="color: #2563eb;">{{ $service->company_name }}</td></tr>
                    @endif
                    <tr><td class="label">WhatsApp/Telp:</td><td class="val">{{ $service->customer?->whatsapp ?? '-' }}</td></tr>
                    <tr><td class="label">Email:</td><td class="val">{{ $service->customer?->email ?? '-' }}</td></tr>
                </table>
            </td>
            <td style="width: 4%;"></td>
            <td class="info-card" style="width: 48%;">
                <h4>Informasi Perangkat & Layanan</h4>
                <table class="info-table">
                    <tr><td class="label">Unit PC / Device:</td><td class="val">{{ $service->device_name ?: 'PC Desktop' }}</td></tr>
                    <tr><td class="label">Serial / Asset:</td><td class="val">{{ $service->serial_number ?: 'N/A' }}</td></tr>
                    <tr><td class="label">Jenis Servis:</td><td class="val">{{ \App\Models\Service::TYPES[$service->service_type] ?? $service->service_type }}</td></tr>
                    <tr><td class="label">Jatuh Tempo:</td><td class="val">{{ $service->due_date ? $service->due_date->format('d M Y') : now()->addDays(7)->format('d M Y') }}</td></tr>
                </table>
            </td>
        </tr>
    </table>

    <table class="items-table">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 45%;">Deskripsi Barang / Jasa</th>
                <th style="width: 15%;">Sumber Part</th>
                <th class="num" style="width: 6%;">Qty</th>
                <th class="num" style="width: 14%;">Harga</th>
                <th class="num" style="width: 15%;">Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($service->items as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <strong>{{ $item->name }}</strong>
                        @if($item->description)
                            <div style="font-size: 9px; color: #64748b;">{{ $item->description }}</div>
                        @endif
                        @if($item->warranty_info)
                            <div style="font-size: 8.5px; color: #0284c7;">Garansi: {{ $item->warranty_info }}</div>
                        @endif
                    </td>
                    <td>
                        @if($item->item_type === 'labor')
                            <span style="font-size: 9px; color: #475569;">Jasa Servis</span>
                        @elseif($item->part_source === 'vendor')
                            <span class="vendor-tag">Disediakan Vendor</span>
                        @else
                            <span style="font-size: 9px; color: #1e40af; font-weight: bold;">KeeHub</span>
                        @endif
                    </td>
                    <td class="num">{{ $item->quantity }}</td>
                    <td class="num">
                        @if($item->part_source === 'vendor')
                            <span style="color: #64748b; font-style: italic;">Rp 0</span>
                        @else
                            Rp {{ number_format($item->price, 0, ',', '.') }}
                        @endif
                    </td>
                    <td class="num">
                        @if($item->part_source === 'vendor')
                            <span style="color: #64748b; font-style: italic;">Rp 0</span>
                        @else
                            Rp {{ number_format($item->total, 0, ',', '.') }}
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: #94a3b8; padding: 14px;">Belum ada rincian tagihan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <table class="totals-table">
        <tr>
            <td>Subtotal Part (KeeHub):</td>
            <td class="num">Rp {{ number_format($service->keehubPartsTotal(), 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Biaya Jasa / Pengerjaan:</td>
            <td class="num">Rp {{ number_format($service->laborTotal(), 0, ',', '.') }}</td>
        </tr>
        @if($service->vendorPartsTotal() > 0)
            <tr>
                <td style="color: #64748b; font-style: italic;">Part Disediakan Vendor:</td>
                <td class="num" style="color: #64748b; font-style: italic;">Rp 0 (Termasuk)</td>
            </tr>
        @endif
        <tr class="grand-total">
            <td>TOTAL TAGIHAN:</td>
            <td class="num" style="color: #0f172a;">Rp {{ number_format($service->invoiceTotal(), 0, ',', '.') }}</td>
        </tr>
    </table>

    <div class="payment-box">
        <strong>Instruksi Pembayaran Bank Transfer:</strong><br>
        BCA: <strong>123-456-7890</strong> a/n PT Keetech Solusi Indonesia<br>
        Mandiri: <strong>137-000-123-4567</strong> a/n PT Keetech Solusi Indonesia<br>
        <em>*Mohon cantumkan No. Invoice ({{ $service->invoice_number ?: $service->code }}) pada berita transfer.</em>
    </div>

    <table class="signatures">
        <tr>
            <td>
                Finance / Billing Keetech,
                <div class="sig-line"></div>
                <strong>Keetech Finance Dept.</strong>
            </td>
            <td>
                Penerima Tagihan,
                <div class="sig-line"></div>
                <strong>{{ $service->customer?->name ?? 'Klien' }}</strong>
                @if($service->company_name)
                    <div style="font-size: 9px; color: #64748b;">{{ $service->company_name }}</div>
                @endif
            </td>
        </tr>
    </table>

    <div class="footer">
        Terima kasih atas kepercayaan Anda kepada Keetech & KeeHub. Hubungi tim kami jika terdapat pertanyaan terkait tagihan ini.
    </div>
</body>
</html>
