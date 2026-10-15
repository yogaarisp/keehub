<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Struk #{{ $order->code }} - KeeHub</title>
    @php
        $width = ($paperSize ?? '58mm') === '80mm' ? '80mm' : '58mm';
        $storeName = \App\Models\Setting::get('store_name', 'KeeHub');
        $storeTagline = \App\Models\Setting::get('store_tagline', 'Build Your PC. Your Way.');
        $storeAddress = \App\Models\Setting::get('store_address', 'Jl. Kaliurang KM 5, Sleman, DI Yogyakarta');
        $storePhone = \App\Models\Setting::get('whatsapp_number', '0812-3456-7890');
        $logoUrl = \App\Models\Setting::logoUrl();
    @endphp
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: {{ $width === '80mm' ? '12px' : '10.5px' }};
            line-height: 1.25;
            color: #000;
            background: #e2e8f0;
            margin: 0;
            padding: 15px 0;
            -webkit-print-color-adjust: exact;
        }
        .receipt-card {
            width: {{ $width }};
            margin: 0 auto;
            background: #fff;
            padding: {{ $width === '80mm' ? '5mm 4mm' : '3mm 2.5mm' }};
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-left { text-align: left; }
        .font-bold { font-weight: bold; }
        .uppercase { text-transform: uppercase; }
        .dashed-line {
            border-top: 1px dashed #000;
            margin: 5px 0;
        }
        .double-line {
            border-top: 2px solid #000;
            margin: 6px 0;
        }
        .flex-between {
            display: flex;
            justify-content: space-between;
        }
        img.receipt-logo {
            max-width: {{ $width === '80mm' ? '45mm' : '32mm' }};
            max-height: 16mm;
            margin: 0 auto 4px auto;
            display: block;
            filter: grayscale(100%) contrast(150%);
        }
        .no-print {
            text-align: center;
            margin-bottom: 15px;
        }
        .btn-print {
            background: #ea580c;
            color: #fff;
            border: none;
            padding: 8px 16px;
            font-size: 13px;
            font-weight: bold;
            border-radius: 6px;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0,0,0,0.15);
        }
        .btn-close {
            background: #64748b;
            color: #fff;
            border: none;
            padding: 8px 14px;
            font-size: 13px;
            border-radius: 6px;
            cursor: pointer;
            margin-left: 6px;
        }
        @media print {
            body {
                background: #fff;
                padding: 0;
            }
            .no-print {
                display: none !important;
            }
            .receipt-card {
                width: {{ $width }};
                margin: 0;
                padding: {{ $width === '80mm' ? '4mm 3mm' : '2.5mm 1.5mm' }};
                box-shadow: none;
            }
            @page {
                size: {{ $width }} auto;
                margin: 0;
            }
        }
    </style>
</head>
<body>
    <div class="no-print">
        <button class="btn-print" onclick="window.print()">🖨️ Cetak Struk ({{ $width }})</button>
        <button class="btn-close" onclick="window.close()">Tutup</button>
    </div>

    <div class="receipt-card">
        @if($printLogo && $logoUrl)
        <div class="text-center">
            <img src="{{ $logoUrl }}" alt="Logo" class="receipt-logo" />
        </div>
        @endif

        <div class="text-center font-bold {{ $width === '80mm' ? '' : 'uppercase' }}" style="font-size: {{ $width === '80mm' ? '14px' : '12px' }};">
            {{ $storeName }}
        </div>
        <div class="text-center" style="font-size: 9px; color: #333;">
            {{ $storeTagline }}
        </div>
        <div class="text-center" style="font-size: 9px; color: #333; margin-top: 2px;">
            {{ $storeAddress }}
        </div>
        @if($storePhone)
        <div class="text-center" style="font-size: 9px; color: #333;">
            WA: {{ $storePhone }}
        </div>
        @endif

        @if(!empty($headerText))
        <div class="text-center" style="font-size: 9.5px; margin-top: 4px; white-space: pre-line;">
            {{ $headerText }}
        </div>
        @endif

        <div class="dashed-line"></div>

        <div class="flex-between" style="font-size: 9.5px;">
            <span>No: #{{ $order->code }}</span>
            <span>Kasir: {{ auth()->user()?->name ?? 'Admin' }}</span>
        </div>
        <div class="flex-between" style="font-size: 9.5px;">
            <span>Tgl: {{ $order->created_at?->format('d/m/Y H:i') }}</span>
            <span class="uppercase">{{ $order->channel ?? 'KASIR' }}</span>
        </div>
        @if($order->customer)
        <div class="flex-between" style="font-size: 9.5px;">
            <span>Klien: {{ $order->customer->name }}</span>
            <span>{{ $order->customer->phone ?? '' }}</span>
        </div>
        @endif

        <div class="dashed-line"></div>

        <!-- Order Items -->
        <div style="margin: 3px 0;">
            @foreach($order->items as $item)
            <div style="margin-bottom: 4px;">
                <div class="font-bold">{{ $item->name }}</div>
                <div class="flex-between" style="font-size: 9.5px;">
                    <span>{{ $item->quantity }} x @ {{ number_format($item->price, 0, ',', '.') }}</span>
                    <span>Rp {{ number_format($item->total, 0, ',', '.') }}</span>
                </div>
            </div>
            @endforeach
        </div>

        <div class="dashed-line"></div>

        <!-- Totals -->
        <div style="font-size: 9.5px;">
            <div class="flex-between">
                <span>Subtotal</span>
                <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
            </div>
            @if($order->discount > 0)
            <div class="flex-between">
                <span>Diskon</span>
                <span>-Rp {{ number_format($order->discount, 0, ',', '.') }}</span>
            </div>
            @endif
            @if($order->shipping_cost > 0)
            <div class="flex-between">
                <span>Ongkir</span>
                <span>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
            </div>
            @endif
            <div class="dashed-line" style="margin: 4px 0;"></div>
            <div class="flex-between font-bold" style="font-size: {{ $width === '80mm' ? '13px' : '11.5px' }};">
                <span>TOTAL</span>
                <span>Rp {{ number_format($order->total, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="dashed-line"></div>

        <!-- QR verification -->
        <div class="text-center" style="margin: 6px 0;">
            <div style="display: inline-block; padding: 2px; border: 1px solid #333; background: #fff;">
                <div style="width: 48px; height: 48px; background: #000; color: #fff; font-size: 7px; display: flex; align-items: center; justify-content: center; text-align: center;">
                    [ QR KASIR ]
                </div>
            </div>
            <div style="font-size: 8px; letter-spacing: 1px; margin-top: 2px;">#{{ $order->code }}</div>
        </div>

        <!-- Footer Notes -->
        <div class="text-center" style="font-size: 9.5px; white-space: pre-line; margin-top: 4px;">
            {{ $footerText }}
        </div>

        @if($autoCut || $cashDrawer)
        <div class="text-center" style="font-size: 8px; color: #888; margin-top: 4px; font-style: italic;">
            @if($autoCut) [Auto-Cut] @endif
            @if($cashDrawer) [Kick Drawer] @endif
        </div>
        @endif
    </div>

    <script>
        // Auto print if ?print=1 in URL
        if (new URLSearchParams(window.location.search).get('print') === '1') {
            window.onload = function() {
                window.print();
            };
        }
    </script>
</body>
</html>
