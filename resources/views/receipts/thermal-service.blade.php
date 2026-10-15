<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Struk Servis #{{ $service->code }} - KeeHub</title>
    @php
        $width = ($paperSize ?? '58mm') === '80mm' ? '80mm' : '58mm';
        $storeName = \App\Models\Setting::get('store_name', 'KeeHub');
        $storeTagline = \App\Models\Setting::get('store_tagline', 'Build Your PC. Your Way.');
        $storeAddress = \App\Models\Setting::get('store_address', 'Jl. Kaliurang KM 5, Sleman, DI Yogyakarta');
        $storePhone = \App\Models\Setting::get('whatsapp_number', '0812-3456-7890');
        $logoUrl = \App\Models\Setting::logoUrl();
        $warrantyTerms = \App\Models\Setting::get('service_warranty_terms', 'Garansi servis berlaku selama 14 hari terhitung sejak tanggal unit selesai dikerjakan.');
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
        <button class="btn-print" onclick="window.print()">🖨️ Cetak Struk Servis ({{ $width }})</button>
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
            TANDA TERIMA / NOTA SERVIS
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
            <span>No: #{{ $service->code }}</span>
            <span class="uppercase font-bold">{{ $service->status }}</span>
        </div>
        <div class="flex-between" style="font-size: 9.5px;">
            <span>Tgl: {{ $service->created_at?->format('d/m/Y H:i') }}</span>
            <span>Teknisi: {{ $service->technician?->name ?? 'Staff' }}</span>
        </div>
        @if($service->customer)
        <div class="flex-between" style="font-size: 9.5px;">
            <span>Klien: {{ $service->customer->name }}</span>
            <span>{{ $service->customer->whatsapp ?? '' }}</span>
        </div>
        @endif

        <div class="dashed-line"></div>

        <!-- Device Info -->
        <div style="font-size: 9.5px; margin: 3px 0;">
            <div class="flex-between">
                <span>Unit:</span>
                <span class="font-bold">{{ $service->device_name ?? 'PC / Keyboard' }}</span>
            </div>
            @if($service->serial_number)
            <div class="flex-between">
                <span>SN:</span>
                <span>{{ $service->serial_number }}</span>
            </div>
            @endif
            @if($service->problem_description)
            <div style="margin-top: 2px;">
                <span>Keluhan:</span>
                <span style="font-style: italic;">{{ $service->problem_description }}</span>
            </div>
            @endif
        </div>

        <div class="dashed-line"></div>

        <!-- Service Items (if any) -->
        @if($service->items && $service->items->count() > 0)
        <div style="margin: 3px 0;">
            @foreach($service->items as $item)
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
        @endif

        <!-- Total Cost -->
        <div style="font-size: 9.5px;">
            <div class="flex-between font-bold" style="font-size: {{ $width === '80mm' ? '13px' : '11.5px' }};">
                <span>TOTAL BIAYA</span>
                <span>Rp {{ number_format($service->total_cost ?? $service->estimated_cost ?? 0, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="dashed-line"></div>

        <!-- QR verification -->
        <div class="text-center" style="margin: 6px 0;">
            <div style="display: inline-block; padding: 2px; border: 1px solid #333; background: #fff;">
                <div style="width: 48px; height: 48px; background: #000; color: #fff; font-size: 7px; display: flex; align-items: center; justify-content: center; text-align: center;">
                    [ QR SERVIS ]
                </div>
            </div>
            <div style="font-size: 8px; letter-spacing: 1px; margin-top: 2px;">#{{ $service->code }}</div>
        </div>

        <!-- Warranty & Footer -->
        <div class="text-center" style="font-size: 8.5px; color: #444; margin-top: 4px; line-height: 1.2;">
            {{ $warrantyTerms }}
        </div>
        <div class="text-center" style="font-size: 9.5px; white-space: pre-line; margin-top: 4px; font-weight: bold;">
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
        if (new URLSearchParams(window.location.search).get('print') === '1') {
            window.onload = function() {
                window.print();
            };
        }
    </script>
</body>
</html>
