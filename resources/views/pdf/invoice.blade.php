<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $invoice->code }}</title>
    <style>
        body { font-family: Helvetica, Arial, sans-serif; color: #111; font-size: 13px; }
        .header { display: flex; justify-content: space-between; border-bottom: 3px solid #f59e0b; padding-bottom: 12px; }
        .brand { font-size: 26px; font-weight: 900; }
        .brand span { color: #f59e0b; }
        .tagline { color: #6b7280; font-size: 11px; margin-top: 2px; }
        .doc-title { text-align: right; }
        .doc-title h1 { font-size: 22px; margin: 0; letter-spacing: 2px; }
        .code { color: #6b7280; font-size: 12px; }
        .meta { margin: 18px 0; }
        .meta table { width: 100%; }
        .meta td { vertical-align: top; font-size: 12px; }
        .badge { display: inline-block; padding: 3px 10px; border-radius: 99px; font-size: 11px; font-weight: bold; }
        .paid { background: #dcfce7; color: #166534; }
        .partial { background: #fef3c7; color: #92400e; }
        .unpaid { background: #fee2e2; color: #991b1b; }
        table.items { width: 100%; border-collapse: collapse; margin-top: 14px; }
        table.items th { background: #111827; color: #fff; text-align: left; padding: 8px 10px; font-size: 11px; text-transform: uppercase; }
        table.items td { padding: 8px 10px; border-bottom: 1px solid #e5e7eb; }
        table.items .num { text-align: right; }
        table.totals { margin-top: 12px; margin-left: auto; width: 45%; }
        table.totals td { padding: 4px 8px; font-size: 12px; }
        table.totals .grand td { font-weight: 900; font-size: 14px; border-top: 2px solid #111827; }
        .footer { margin-top: 40px; border-top: 1px solid #e5e7eb; padding-top: 10px; color: #6b7280; font-size: 10px; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <div>
            <div class="brand">Kee<span>Hub</span></div>
            <div class="tagline">PC PARTS • PC BUILDER • IT SERVICE</div>
        </div>
        <div class="doc-title">
            <h1>INVOICE</h1>
            <div class="code">{{ $invoice->code }}</div>
        </div>
    </div>

    <div class="meta">
        <table>
            <tr>
                <td width="55%">
                    <strong>Kepada:</strong><br>
                    {{ $invoice->customer?->name ?? '-' }}<br>
                    @if ($invoice->customer?->whatsapp) WhatsApp: {{ $invoice->customer->whatsapp }}<br>@endif
                    @if ($invoice->order?->shipping_address) {{ $invoice->order->shipping_address }}<br>@endif
                </td>
                <td>
                    <strong>Tanggal:</strong> {{ $invoice->created_at->format('d M Y') }}<br>
                    <strong>Order:</strong> {{ $invoice->order?->code }}<br>
                    @if ($invoice->due_date) <strong>Jatuh Tempo:</strong> {{ $invoice->due_date->format('d M Y') }}<br>@endif
                    <span class="badge {{ $invoice->status }}">STATUS: {{ strtoupper($invoice->status) }}</span>
                </td>
            </tr>
        </table>
    </div>

    <table class="items">
        <thead>
            <tr><th>Item</th><th class="num" width="10%">Qty</th><th class="num" width="20%">Harga</th><th class="num" width="20%">Total</th></tr>
        </thead>
        <tbody>
            @foreach ($invoice->items as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td class="num">{{ $item->quantity }}</td>
                    <td class="num">Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                    <td class="num">Rp{{ number_format($item->total, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="totals">
        <tr><td>Subtotal</td><td class="num">Rp{{ number_format($invoice->subtotal, 0, ',', '.') }}</td></tr>
        <tr><td>Discount</td><td class="num">-Rp{{ number_format($invoice->discount, 0, ',', '.') }}</td></tr>
        <tr><td>Shipping</td><td class="num">Rp{{ number_format($invoice->shipping, 0, ',', '.') }}</td></tr>
        <tr class="grand"><td>TOTAL</td><td class="num">Rp{{ number_format($invoice->total, 0, ',', '.') }}</td></tr>
        <tr><td>Dibayar</td><td class="num">Rp{{ number_format($invoice->paid_amount, 0, ',', '.') }}</td></tr>
        <tr><td>Sisa</td><td class="num">Rp{{ number_format($invoice->remainingAmount(), 0, ',', '.') }}</td></tr>
    </table>

    @if ($invoice->payments->isNotEmpty())
        <p style="font-size: 11px; margin-top: 16px;"><strong>Riwayat Payment:</strong></p>
        <table class="items" style="margin-top: 4px;">
            <tr><th>Kode</th><th>Metode</th><th>Referensi</th><th class="num">Jumlah</th><th>Tanggal</th></tr>
            @foreach ($invoice->payments as $payment)
                <tr>
                    <td>{{ $payment->code }}</td>
                    <td>{{ ucfirst($payment->method) }}</td>
                    <td>{{ $payment->reference ?? '-' }}</td>
                    <td class="num">Rp{{ number_format($payment->amount, 0, ',', '.') }}</td>
                    <td>{{ $payment->paid_at->format('d M Y') }}</td>
                </tr>
            @endforeach
        </table>
    @endif

    <div class="footer">
        KeeHub — Build. Buy. Upgrade. • Invoice ini dibuat otomatis oleh sistem • {{ config('app.name') }}
    </div>
</body>
</html>
