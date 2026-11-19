<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Invoice Project - {{ $invoice->code }}</title>
    <style>
        @page {
            margin: 24px 30px;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #1e293b;
            font-size: 10.5px;
            line-height: 1.45;
            margin: 0;
            padding: 0;
        }
        .header {
            width: 100%;
            border-bottom: 2.5px solid #0284c7;
            padding-bottom: 12px;
            margin-bottom: 14px;
        }
        .header table {
            width: 100%;
            border-collapse: collapse;
        }
        .brand-title {
            font-size: 24px;
            font-weight: 900;
            color: #0f172a;
            letter-spacing: 1.5px;
            margin: 0;
            line-height: 1;
        }
        .brand-title span {
            color: #0284c7;
        }
        .brand-company {
            font-size: 10.5px;
            font-weight: 700;
            color: #334155;
            margin-top: 3px;
        }
        .brand-tagline {
            font-size: 9px;
            color: #0284c7;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 1px;
        }
        .brand-contact {
            font-size: 8.5px;
            color: #64748b;
            margin-top: 5px;
            line-height: 1.35;
        }
        .doc-title {
            text-align: right;
            vertical-align: top;
        }
        .doc-title h1 {
            font-size: 22px;
            margin: 0;
            color: #0f172a;
            letter-spacing: 1.5px;
            font-weight: 900;
        }
        .doc-code {
            font-size: 12px;
            font-weight: 800;
            color: #0284c7;
            margin-top: 2px;
        }
        .badge-status {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 9px;
            font-weight: 800;
            text-transform: uppercase;
            margin-top: 4px;
            letter-spacing: 0.5px;
        }
        .status-paid { background: #dcfce7; color: #15803d; border: 1px solid #86efac; }
        .status-unpaid { background: #fee2e2; color: #b91c1c; border: 1px solid #fca5a5; }
        .status-partial { background: #fef3c7; color: #b45309; border: 1px solid #fcd34d; }
        .status-draft { background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; }
        .status-cancelled { background: #f3f4f6; color: #6b7280; border: 1px solid #d1d5db; }

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
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #0284c7;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 4px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9.5px;
        }
        .info-table td {
            padding: 1.5px 0;
            vertical-align: top;
        }
        .info-table .lbl {
            width: 32%;
            color: #64748b;
        }
        .info-table .val {
            width: 68%;
            font-weight: 600;
            color: #0f172a;
        }

        table.items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 4px;
            margin-bottom: 12px;
        }
        table.items-table th {
            background: #0f172a;
            color: #ffffff;
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 7px 8px;
            text-align: left;
        }
        table.items-table th.num, table.items-table td.num {
            text-align: right;
        }
        table.items-table th.center, table.items-table td.center {
            text-align: center;
        }
        table.items-table td {
            padding: 7px 8px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 9.5px;
            vertical-align: top;
        }
        table.items-table tr:nth-child(even) td {
            background-color: #f8fafc;
        }
        .item-title {
            font-weight: 700;
            color: #0f172a;
        }
        .item-desc {
            font-size: 8.5px;
            color: #64748b;
            margin-top: 2px;
            line-height: 1.35;
            white-space: pre-line;
        }

        .summary-container {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }
        .terms-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-left: 3px solid #0284c7;
            border-radius: 4px;
            padding: 8px 10px;
            font-size: 8.5px;
            color: #475569;
            line-height: 1.4;
        }
        .terms-box strong {
            color: #0f172a;
        }
        .totals-table {
            width: 100%;
            border-collapse: collapse;
        }
        .totals-table td {
            padding: 3px 6px;
            font-size: 10px;
        }
        .totals-table td.num {
            text-align: right;
            font-weight: 600;
        }
        .totals-table tr.grand td {
            border-top: 2px solid #0f172a;
            border-bottom: 1px solid #0f172a;
            font-size: 12px;
            font-weight: 900;
            color: #0f172a;
            padding: 6px;
        }
        .totals-table tr.remaining td {
            background: #f0f9ff;
            color: #0369a1;
            font-weight: 800;
            font-size: 11px;
            padding: 5px 6px;
        }

        .signatures {
            margin-top: 26px;
            width: 100%;
            border-collapse: collapse;
        }
        .signatures td {
            width: 50%;
            text-align: center;
            vertical-align: top;
            font-size: 9.5px;
        }
        .sig-line {
            margin: 48px auto 4px auto;
            width: 65%;
            border-bottom: 1px solid #475569;
        }

        .footer {
            margin-top: 22px;
            border-top: 1px solid #e2e8f0;
            padding-top: 6px;
            text-align: center;
            font-size: 8.5px;
            color: #94a3b8;
        }
    </style>
</head>
<body>
    <!-- HEADER RESMI KEETECH (TANPA EMBEL-EMBEL KEEHUB) -->
    <div class="header">
        <table>
            <tr>
                <td style="width: 58%; vertical-align: top;">
                    <div class="brand-title">KEE<span>TECH</span></div>
                    <div class="brand-company">PT KEETECH SOLUSI INDONESIA</div>
                    <div class="brand-tagline">Software Engineering • Web & Mobile Apps • IT Solutions</div>
                    <div class="brand-contact">
                        Jl. Pudaksari V Bumirejo, Semarang • WhatsApp / Telp: {{ \App\Models\Setting::get('whatsapp_number', '0857-9941-0169') }}<br>
                        Email: billing@keetech.id • Website: https://keetech.id
                    </div>
                </td>
                <td class="doc-title" style="width: 42%;">
                    <h1>INVOICE</h1>
                    <div class="doc-code">{{ $invoice->code }}</div>
                    <div style="font-size: 9px; color: #64748b; margin-top: 2px;">
                        Tanggal: <strong>{{ $invoice->invoice_date->format('d M Y') }}</strong>
                        @if($invoice->due_date)
                            &bull; Jatuh Tempo: <strong>{{ $invoice->due_date->format('d M Y') }}</strong>
                        @endif
                    </div>
                    <div>
                        <span class="badge-status status-{{ $invoice->status }}">
                            {{ strtoupper(\App\Models\ProjectInvoice::STATUSES[$invoice->status] ?? $invoice->status) }}
                        </span>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <!-- INFORMASI KLIEN & PROJECT -->
    <table class="info-grid">
        <tr>
            <td class="info-card" style="width: 48%;">
                <h4>Ditagihkan Kepada (Klien / B2B)</h4>
                <table class="info-table">
                    <tr>
                        <td class="lbl">Nama Klien / PIC:</td>
                        <td class="val">{{ $invoice->client_name }}</td>
                    </tr>
                    @if($invoice->client_company)
                        <tr>
                            <td class="lbl">Perusahaan / Instansi:</td>
                            <td class="val" style="color: #0284c7;">{{ $invoice->client_company }}</td>
                        </tr>
                    @endif
                    @if($invoice->client_phone)
                        <tr>
                            <td class="lbl">WhatsApp / Telp:</td>
                            <td class="val">{{ $invoice->client_phone }}</td>
                        </tr>
                    @endif
                    @if($invoice->client_email)
                        <tr>
                            <td class="lbl">Email:</td>
                            <td class="val">{{ $invoice->client_email }}</td>
                        </tr>
                    @endif
                    @if($invoice->client_address)
                        <tr>
                            <td class="lbl">Alamat:</td>
                            <td class="val" style="font-weight: normal; color: #475569;">{{ $invoice->client_address }}</td>
                        </tr>
                    @endif
                </table>
            </td>
            <td style="width: 4%;"></td>
            <td class="info-card" style="width: 48%;">
                <h4>Detail Project & Termin</h4>
                <table class="info-table">
                    <tr>
                        <td class="lbl">Nama Project:</td>
                        <td class="val" style="color: #0f172a; font-size: 10px;">{{ $invoice->project_name }}</td>
                    </tr>
                    <tr>
                        <td class="lbl">Kategori Layanan:</td>
                        <td class="val">{{ $invoice->projectTypeLabel() }}</td>
                    </tr>
                    <tr>
                        <td class="lbl">Tahapan / Termin:</td>
                        <td class="val" style="color: #0284c7;">{{ $invoice->paymentTermLabel() }}</td>
                    </tr>
                    <tr>
                        <td class="lbl">Status Pembayaran:</td>
                        <td class="val">{{ \App\Models\ProjectInvoice::STATUSES[$invoice->status] ?? $invoice->status }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- TABEL RINCIAN SCOPE OF WORK -->
    <table class="items-table">
        <thead>
            <tr>
                <th class="center" style="width: 5%;">No</th>
                <th style="width: 50%;">Deskripsi Pekerjaan / Modul Project</th>
                <th class="center" style="width: 10%;">Qty</th>
                <th class="center" style="width: 10%;">Satuan</th>
                <th class="num" style="width: 12%;">Harga Satuan</th>
                <th class="num" style="width: 13%;">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @forelse($invoice->items as $index => $item)
                <tr>
                    <td class="center">{{ $index + 1 }}</td>
                    <td>
                        <div class="item-title">{{ $item->item_name }}</div>
                        @if($item->description)
                            <div class="item-desc">{{ $item->description }}</div>
                        @endif
                    </td>
                    <td class="center">{{ $item->quantity }}</td>
                    <td class="center">{{ $item->unit }}</td>
                    <td class="num">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td class="num"><strong>Rp {{ number_format($item->total, 0, ',', '.') }}</strong></td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="center" style="padding: 18px; color: #94a3b8;">Tidak ada rincian pekerjaan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- RINGKASAN FINANSIAL & INSTRUKSI PEMBAYARAN -->
    <table class="summary-container">
        <tr>
            <!-- KIRI: INSTRUKSI PEMBAYARAN & SYARAT -->
            <td style="width: 54%; vertical-align: top; padding-right: 14px;">
                <div class="terms-box">
                    <strong>Instruksi Pembayaran Bank Transfer (Keetech):</strong><br>
                    Bank: <strong>{{ $invoice->bank_name ?: \App\Models\Setting::get('bank_name', 'BCA') }}</strong><br>
                    No. Rekening: <strong>{{ $invoice->bank_account_number ?: \App\Models\Setting::get('bank_account_number', '8030808861') }}</strong><br>
                    Atas Nama: <strong>{{ $invoice->bank_account_holder ?: \App\Models\Setting::get('bank_account_holder', 'PT Keetech Solusi Indonesia') }}</strong><br>
                    <span style="font-size: 8px; color: #64748b;">*Mohon cantumkan nomor invoice ({{ $invoice->code }}) pada berita transfer.</span>
                </div>

                @if($invoice->terms || $invoice->notes)
                    <div class="terms-box" style="margin-top: 8px; border-left-color: #64748b;">
                        @if($invoice->terms)
                            <strong>Syarat & Ketentuan Project:</strong><br>
                            {!! nl2br(e($invoice->terms)) !!}<br>
                        @endif
                        @if($invoice->notes)
                            <strong style="margin-top: 4px; display: inline-block;">Catatan Tambahan / Garansi:</strong><br>
                            {!! nl2br(e($invoice->notes)) !!}
                        @endif
                    </div>
                @else
                    <div class="terms-box" style="margin-top: 8px; border-left-color: #64748b; font-size: 8px;">
                        <strong>Ketentuan & Garansi Pembuatan Software:</strong><br>
                        1. Penyerahan source code dan kredensial akses dilakukan setelah kewajiban pembayaran terselesaikan.<br>
                        2. Termasuk garansi perbaikan bug / error teknis selama 30 hari terhitung sejak tanggal serah terima.<br>
                        3. Perubahan fitur baru di luar ruang lingkup (scope) yang tertera akan dicatat sebagai addendum/CR terpisah.
                    </div>
                @endif
            </td>

            <!-- KANAN: TOTALS -->
            <td style="width: 46%; vertical-align: top;">
                <table class="totals-table">
                    <tr>
                        <td>Subtotal Pekerjaan:</td>
                        <td class="num">Rp {{ number_format($invoice->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @if($invoice->discount > 0)
                        <tr>
                            <td style="color: #b91c1c;">Potongan Diskon:</td>
                            <td class="num" style="color: #b91c1c;">-Rp {{ number_format($invoice->discount, 0, ',', '.') }}</td>
                        </tr>
                    @endif
                    @if($invoice->tax > 0)
                        <tr>
                            <td>PPN / Pajak:</td>
                            <td class="num">Rp {{ number_format($invoice->tax, 0, ',', '.') }}</td>
                        </tr>
                    @endif
                    <tr class="grand">
                        <td>TOTAL TAGIHAN:</td>
                        <td class="num">Rp {{ number_format($invoice->total, 0, ',', '.') }}</td>
                    </tr>
                    @if($invoice->paid_amount > 0)
                        <tr>
                            <td style="color: #15803d; font-weight: 600;">Telah Dibayar (DP / Masuk):</td>
                            <td class="num" style="color: #15803d; font-weight: 600;">Rp {{ number_format($invoice->paid_amount, 0, ',', '.') }}</td>
                        </tr>
                    @endif
                    <tr class="remaining">
                        <td>SISA PEMBAYARAN:</td>
                        <td class="num">Rp {{ number_format($invoice->remainingAmount(), 0, ',', '.') }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- TANDA TANGAN (KEETECH FINANCE & KLIEN) -->
    <table class="signatures">
        <tr>
            <td>
                <div>Hormat kami,</div>
                <div style="font-size: 9px; color: #64748b; margin-top: 1px;">PT KEETECH SOLUSI INDONESIA</div>
                <div class="sig-line"></div>
                <strong>{{ $invoice->signer_name ?: 'Keetech Finance & Billing' }}</strong>
            </td>
            <td>
                <div>Diterima & Disetujui Oleh,</div>
                <div style="font-size: 9px; color: #64748b; margin-top: 1px;">Klien / Authorized Representative</div>
                <div class="sig-line"></div>
                <strong>{{ $invoice->client_name }}</strong>
                @if($invoice->client_company)
                    <div style="font-size: 8.5px; color: #64748b;">{{ $invoice->client_company }}</div>
                @endif
            </td>
        </tr>
    </table>

    <!-- FOOTER RESMI KEETECH -->
    <div class="footer">
        PT KEETECH SOLUSI INDONESIA &bull; Software House, Web Development & IT Cloud Solutions &bull; Invoice ini dibuat secara resmi oleh sistem Keetech
    </div>
</body>
</html>
