<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Penawaran {{ $quotation->code }}</title>
    <style>
        body { font-family: Helvetica, Arial, sans-serif; color: #111; font-size: 13px; line-height: 1.4; }
        .header { display: flex; justify-content: space-between; border-bottom: 3px solid #d97706; padding-bottom: 12px; }
        .brand { font-size: 26px; font-weight: 900; }
        .brand span { color: #d97706; }
        .tagline { color: #6b7280; font-size: 11px; margin-top: 2px; }
        .doc-title { text-align: right; }
        .doc-title h1 { font-size: 20px; margin: 0; letter-spacing: 1.5px; color: #111827; }
        .code { color: #d97706; font-size: 13px; font-weight: bold; margin-top: 2px; }
        .meta { margin: 18px 0; }
        .meta table { width: 100%; border-collapse: collapse; }
        .meta td { vertical-align: top; font-size: 12px; }
        .badge { display: inline-block; padding: 3px 10px; border-radius: 99px; font-size: 10px; font-weight: bold; }
        .draft { background: #f3f4f6; color: #374151; }
        .sent { background: #e0f2fe; color: #0369a1; }
        .accepted { background: #dcfce7; color: #15803d; }
        .converted { background: #fef3c7; color: #b45309; }
        .rejected { background: #fee2e2; color: #b91c1c; }
        .expired { background: #fef2f2; color: #991b1b; }
        table.items { width: 100%; border-collapse: collapse; margin-top: 14px; }
        table.items th { background: #111827; color: #fff; text-align: left; padding: 8px 10px; font-size: 11px; text-transform: uppercase; }
        table.items td { padding: 8px 10px; border-bottom: 1px solid #e5e7eb; font-size: 12px; }
        table.items .num { text-align: right; }
        table.items .center { text-align: center; }
        .item-category { font-size: 10px; color: #6b7280; text-transform: uppercase; margin-top: 2px; }
        table.totals { margin-top: 14px; margin-left: auto; width: 45%; border-collapse: collapse; }
        table.totals td { padding: 4px 8px; font-size: 12px; }
        table.totals .grand td { font-weight: 900; font-size: 14px; border-top: 2px solid #111827; color: #111827; padding-top: 6px; }
        .section-box { margin-top: 20px; padding: 12px; background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 4px; }
        .section-title { font-size: 11px; font-weight: bold; text-transform: uppercase; color: #374151; margin-bottom: 6px; }
        .section-content { font-size: 11px; color: #4b5563; white-space: pre-line; }
        .footer { margin-top: 36px; border-top: 1px solid #e5e7eb; padding-top: 10px; color: #6b7280; font-size: 10px; text-align: center; }
        .signatures { margin-top: 30px; width: 100%; }
        .signatures td { vertical-align: top; font-size: 11px; }
    </style>
</head>
<body>
    <div class="header">
        <div>
            <div class="brand">Kee<span>Hub</span></div>
            <div class="tagline">PC PARTS • PC BUILDER • IT SERVICE & REPAIR</div>
        </div>
        <div class="doc-title">
            <h1>SURAT PENAWARAN HARGA</h1>
            <div class="code">{{ $quotation->code }}</div>
        </div>
    </div>

    <div class="meta">
        <table>
            <tr>
                <td width="55%">
                    <strong style="color: #6b7280; text-transform: uppercase; font-size: 11px;">Ditujukan Kepada:</strong><br>
                    <strong style="font-size: 13px;">{{ $quotation->customer?->name ?? 'Pelanggan Umum' }}</strong><br>
                    @if ($quotation->customer?->whatsapp)
                        WhatsApp: {{ $quotation->customer->whatsapp }}<br>
                    @endif
                    @if ($quotation->customer?->email)
                        Email: {{ $quotation->customer->email }}<br>
                    @endif
                    @if ($quotation->customer?->address)
                        Alamat: {{ $quotation->customer->address }}<br>
                    @endif
                </td>
                <td width="45%" style="text-align: right;">
                    <strong>Tanggal:</strong> {{ $quotation->quotation_date ? $quotation->quotation_date->format('d M Y') : $quotation->created_at->format('d M Y') }}<br>
                    @if ($quotation->expired_date)
                        <strong>Berlaku Hingga:</strong> {{ $quotation->expired_date->format('d M Y') }}<br>
                    @endif
                    <div style="margin-top: 6px;">
                        <span class="badge {{ $quotation->status }}">STATUS: {{ strtoupper($quotation->status) }}</span>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <table class="items">
        <thead>
            <tr>
                <th width="5%" class="center">No</th>
                <th width="50%">Deskripsi Item / Jasa</th>
                <th class="center" width="10%">Qty</th>
                <th class="num" width="17%">Harga Satuan</th>
                <th class="num" width="18%">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($quotation->items as $index => $item)
                <tr>
                    <td class="center">{{ $index + 1 }}</td>
                    <td>
                        <strong>{{ $item->name }}</strong>
                        @if ($item->description)
                            <div style="color: #6b7280; font-size: 11px;">{{ $item->description }}</div>
                        @endif
                        <div class="item-category">
                            {{ match ($item->item_type) {
                                'product' => 'Produk Toko',
                                'build' => 'Komponen Rakit PC',
                                'service' => 'Layanan Servis',
                                'labor' => 'Jasa Teknisi',
                                'custom' => 'Item Khusus',
                                default => ucfirst($item->item_type ?? 'Item'),
                            } }}
                        </div>
                    </td>
                    <td class="center">{{ $item->quantity }}</td>
                    <td class="num">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td class="num"><strong>Rp {{ number_format($item->total, 0, ',', '.') }}</strong></td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="center" style="padding: 18px; color: #6b7280;">Tidak ada rincian item.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <table class="totals">
        <tr>
            <td>Subtotal Item</td>
            <td class="num">Rp {{ number_format($quotation->subtotal, 0, ',', '.') }}</td>
        </tr>
        @if ($quotation->discount > 0)
            <tr>
                <td style="color: #b91c1c;">Potongan Diskon</td>
                <td class="num" style="color: #b91c1c;">-Rp {{ number_format($quotation->discount, 0, ',', '.') }}</td>
            </tr>
        @endif
        @if ($quotation->shipping > 0)
            <tr>
                <td>Biaya Pengiriman</td>
                <td class="num">Rp {{ number_format($quotation->shipping, 0, ',', '.') }}</td>
            </tr>
        @endif
        <tr class="grand">
            <td>TOTAL PENAWARAN</td>
            <td class="num">Rp {{ number_format($quotation->total, 0, ',', '.') }}</td>
        </tr>
    </table>

    @if ($quotation->terms || $quotation->notes)
        <div class="section-box">
            @if ($quotation->terms)
                <div class="section-title">Syarat & Ketentuan Penawaran:</div>
                <div class="section-content">{{ $quotation->terms }}</div>
            @endif
            @if ($quotation->notes)
                <div class="section-title" style="margin-top: {{ $quotation->terms ? '8px' : '0' }};">Catatan Tambahan:</div>
                <div class="section-content">{{ $quotation->notes }}</div>
            @endif
        </div>
    @endif

    <table class="signatures">
        <tr>
            <td width="60%">
                <p style="color: #6b7280; font-size: 10px;">
                    * Penawaran ini dibuat secara otomatis oleh sistem KeeHub.<br>
                    * Konfirmasi penawaran dapat dilakukan via WhatsApp atau email resmi KeeHub.
                </p>
            </td>
            <td width="40%" style="text-align: center;">
                <p style="margin-bottom: 50px;">Hormat kami,<br><strong>KeeHub Management</strong></p>
                <p style="color: #6b7280; border-top: 1px dashed #9ca3af; padding-top: 4px; display: inline-block; width: 140px;">Tim Sales & Support</p>
            </td>
        </tr>
    </table>

    <div class="footer">
        KeeHub Computer &bull; Spesialis Rakit PC, Komponen &bull; Layanan Perbaikan Komputer &bull; Hubungi kami via WhatsApp resmi
    </div>
</body>
</html>
