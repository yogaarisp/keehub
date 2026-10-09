<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Work Order {{ $service->code }}</title>
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
            border-bottom: 2.5px solid #0f172a;
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
            font-size: 20px;
            font-weight: 900;
            margin: 0;
            color: #0f172a;
            letter-spacing: 1px;
        }
        .doc-badge {
            display: inline-block;
            background: #e2e8f0;
            color: #334155;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
            margin-top: 4px;
        }
        .info-grid {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14px;
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

        .section-title {
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #0f172a;
            margin: 12px 0 6px 0;
        }

        .desc-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 8px 10px;
            margin-bottom: 10px;
            font-size: 10.5px;
        }
        .desc-box strong { color: #334155; display: block; margin-bottom: 2px; }

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

        .badge-source {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 8.5px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .badge-keehub { background: #dbeafe; color: #1e40af; }
        .badge-vendor { background: #fef3c7; color: #92400e; }
        .badge-labor { background: #f1f5f9; color: #475569; }

        .totals-table {
            width: 45%;
            margin-left: auto;
            margin-top: 10px;
            border-collapse: collapse;
        }
        .totals-table td {
            padding: 3px 6px;
            font-size: 10.5px;
        }
        .totals-table tr.grand-total td {
            border-top: 2px solid #0f172a;
            font-size: 12px;
            font-weight: 800;
            color: #0f172a;
            padding-top: 6px;
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
                        Email: service@keetech.id • Website: {{ config('app.url') }}
                    </div>
                </td>
                <td class="doc-title">
                    <h1>WORK ORDER</h1>
                    <div style="font-size: 12px; font-weight: bold; color: #f59e0b; margin-top: 2px;">{{ $service->code }}</div>
                    <div class="doc-badge">STATUS: {{ strtoupper(str_replace('_', ' ', $service->status)) }}</div>
                    <div style="font-size: 9.5px; color: #64748b; margin-top: 4px;">Tgl Masuk: {{ $service->created_at->format('d M Y H:i') }}</div>
                </td>
            </tr>
        </table>
    </div>

    <table class="info-grid">
        <tr>
            <td class="info-card" style="width: 48%;">
                <h4>Informasi Klien / B2B</h4>
                <table class="info-table">
                    <tr><td class="label">Nama Klien:</td><td class="val">{{ $service->customer?->name ?? 'Walk-in Customer' }}</td></tr>
                    @if($service->company_name)
                        <tr><td class="label">Perusahaan:</td><td class="val" style="color: #2563eb;">{{ $service->company_name }}</td></tr>
                    @endif
                    <tr><td class="label">No. Kontak/WA:</td><td class="val">{{ $service->customer?->whatsapp ?? '-' }}</td></tr>
                    <tr><td class="label">Email:</td><td class="val">{{ $service->customer?->email ?? '-' }}</td></tr>
                    <tr><td class="label">Teknisi PJ:</td><td class="val">{{ $service->technician?->name ?? 'Tim Teknisi KeeHub' }}</td></tr>
                </table>
            </td>
            <td style="width: 4%;"></td>
            <td class="info-card" style="width: 48%;">
                <h4>Informasi Perangkat & Unit PC</h4>
                <table class="info-table">
                    <tr><td class="label">Unit / Model:</td><td class="val">{{ $service->device_name ?: 'PC Desktop / Rig' }}</td></tr>
                    <tr><td class="label">Serial / Asset:</td><td class="val">{{ $service->serial_number ?: 'N/A' }}</td></tr>
                    <tr><td class="label">Jenis Layanan:</td><td class="val">{{ \App\Models\Service::TYPES[$service->service_type] ?? $service->service_type }}</td></tr>
                    <tr><td class="label">Kelengkapan:</td><td class="val">{{ $service->completeness ?: 'Unit Only' }}</td></tr>
                    <tr><td class="label">Target Selesai:</td><td class="val">{{ $service->due_date ? $service->due_date->format('d M Y') : 'Estimasi Standard' }}</td></tr>
                </table>
            </td>
        </tr>
    </table>

    <table style="width: 100%; border-collapse: collapse; margin-bottom: 8px;">
        <tr>
            <td style="width: 49%; vertical-align: top;">
                <div class="desc-box">
                    <strong>Keluhan / Problem Description:</strong>
                    {{ $service->problem_description ?: 'Tidak ada keluhan spesifik dicatat.' }}
                </div>
            </td>
            <td style="width: 2%;"></td>
            <td style="width: 49%; vertical-align: top;">
                <div class="desc-box">
                    <strong>Hasil Diagnosa & Solusi Teknis:</strong>
                    {{ $service->diagnosis ?: 'Pemeriksaan awal komponen hardware & software.' }}
                </div>
            </td>
        </tr>
    </table>

    <div class="section-title">Rincian Pekerjaan & Suku Cadang (Part Log)</div>
    <table class="items-table">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 37%;">Nama Item / Part / Jasa</th>
                <th style="width: 16%;">Sumber Part</th>
                <th style="width: 12%;">Garansi</th>
                <th class="num" style="width: 6%;">Qty</th>
                <th class="num" style="width: 12%;">Harga Asli</th>
                <th class="num" style="width: 12%;">Subtotal</th>
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
                    </td>
                    <td>
                        @if($item->item_type === 'labor')
                            <span class="badge-source badge-labor">JASA / LABOR</span>
                        @elseif($item->part_source === 'vendor')
                            <span class="badge-source badge-vendor">DARI VENDOR</span>
                        @else
                            <span class="badge-source badge-keehub">DARI KEEHUB</span>
                        @endif
                    </td>
                    <td>{{ $item->warranty_info ?: '-' }}</td>
                    <td class="num">{{ $item->quantity }}</td>
                    <td class="num">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td class="num">Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; color: #94a3b8; padding: 14px;">Belum ada item pekerjaan atau suku cadang tercatat.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <table class="totals-table">
        <tr>
            <td>Part dari KeeHub:</td>
            <td class="num">Rp {{ number_format($service->keehubPartsTotal(), 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Part dari Vendor:</td>
            <td class="num">Rp {{ number_format($service->vendorPartsTotal(), 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Biaya Jasa / Labor:</td>
            <td class="num">Rp {{ number_format($service->laborTotal(), 0, ',', '.') }}</td>
        </tr>
        <tr class="grand-total">
            <td>TOTAL PEKERJAAN:</td>
            <td class="num">Rp {{ number_format($service->workOrderTotal(), 0, ',', '.') }}</td>
        </tr>
    </table>

    <table class="signatures">
        <tr>
            <td>
                Teknisi Pelaksana,
                <div class="sig-line"></div>
                <strong>{{ $service->technician?->name ?? 'Tim Keetech/KeeHub' }}</strong>
            </td>
            <td>
                Klien / Authorized Representative,
                <div class="sig-line"></div>
                <strong>{{ $service->customer?->name ?? 'Klien' }}</strong>
                @if($service->company_name)
                    <div style="font-size: 9px; color: #64748b;">{{ $service->company_name }}</div>
                @endif
            </td>
        </tr>
    </table>

    <div class="footer">
        Work Order ini merupakan catatan resmi pekerjaan perbaikan Keetech & KeeHub. Seluruh data suku cadang terarsip untuk riwayat teknis.
    </div>
</body>
</html>
