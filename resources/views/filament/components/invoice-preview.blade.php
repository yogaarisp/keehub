@php
    $storeName = \App\Models\Setting::get('store_name', 'KeeHub');
    $storeTagline = \App\Models\Setting::get('store_tagline', 'IT Solutions & PC Specialist');
    $storeAddress = \App\Models\Setting::get('store_address', 'Jl. IT Technology Hub');
    $storePhone = \App\Models\Setting::get('whatsapp_number', '0812-3456-7890');
    $storeEmail = \App\Models\Setting::get('store_email', 'billing@keetech.id');
    $bankName = \App\Models\Setting::get('bank_name', 'BCA');
    $bankAcc = \App\Models\Setting::get('bank_account_number', '123-456-7890');
    $bankHolder = \App\Models\Setting::get('bank_account_holder', 'PT Keetech Solusi Indonesia');

    $defaultBrand = 'KEETECH • KEEHUB';
    $defaultTagline = 'IT Solutions & PC Hardware Specialist';
    $defaultContact = $storeAddress . ' • WhatsApp: ' . $storePhone . "\nEmail: " . $storeEmail . ' • Website: ' . config('app.url');
    $defaultPayment = "Instruksi Pembayaran Bank Transfer:\n" . $bankName . ": " . $bankAcc . ($bankHolder ? " a/n " . $bankHolder : "") . "\n*Mohon cantumkan No. Invoice pada berita transfer.";
    $defaultSignature = 'Keetech Finance Dept.';
    $defaultServiceFooter = 'Terima kasih atas kepercayaan Anda kepada Keetech & KeeHub. Hubungi tim kami jika terdapat pertanyaan terkait tagihan ini.';
    $defaultWarranty = 'Garansi servis berlaku selama 14 hari terhitung sejak tanggal unit selesai dikerjakan. Tidak mencakup kerusakan akibat cairan atau kelalaian pengguna.';
@endphp

<style>
    /* ========================================================
       KEEHUB INVOICE & RECEIPT PREVIEW - DEDICATED DARK MODE
       ======================================================== */
    /* Invoice Sheet (A4) Dark Mode */
    .dark .keehub-invoice-sheet {
        background-color: #0b0f19 !important;
        border-color: #1e293b !important;
        color: #f1f5f9 !important;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.5), 0 8px 10px -6px rgba(0, 0, 0, 0.5) !important;
    }
    .dark .keehub-invoice-sheet .brand-title {
        color: #ffffff !important;
    }
    .dark .keehub-invoice-sheet .brand-tagline {
        color: #fbbf24 !important;
    }
    .dark .keehub-invoice-sheet .brand-contact {
        color: #94a3b8 !important;
    }
    .dark .keehub-invoice-sheet .doc-title {
        color: #ffffff !important;
    }
    .dark .keehub-invoice-sheet .doc-number {
        color: #fbbf24 !important;
    }
    .dark .keehub-invoice-sheet .doc-badge {
        background-color: rgba(245, 158, 11, 0.15) !important;
        border: 1px solid rgba(245, 158, 11, 0.4) !important;
        color: #fde68a !important;
    }
    .dark .keehub-invoice-sheet .doc-date {
        color: #94a3b8 !important;
    }
    .dark .keehub-invoice-sheet .info-card {
        background-color: rgba(17, 24, 39, 0.8) !important;
        border: 1px solid #1e293b !important;
    }
    .dark .keehub-invoice-sheet .info-card-header {
        color: #94a3b8 !important;
        border-bottom: 1px solid #1e293b !important;
    }
    .dark .keehub-invoice-sheet .info-card-name {
        color: #ffffff !important;
    }
    .dark .keehub-invoice-sheet .info-card-sub {
        color: #60a5fa !important;
    }
    .dark .keehub-invoice-sheet .info-card-muted {
        color: #94a3b8 !important;
    }
    .dark .keehub-invoice-sheet .item-table thead tr {
        background-color: #1e293b !important;
        color: #f8fafc !important;
        border: 1px solid #334155 !important;
    }
    .dark .keehub-invoice-sheet .item-table tbody tr {
        border-bottom: 1px solid #1e293b !important;
    }
    .dark .keehub-invoice-sheet .item-table td {
        color: #e2e8f0 !important;
    }
    .dark .keehub-invoice-sheet .item-table .item-src {
        color: #94a3b8 !important;
    }
    .dark .keehub-invoice-sheet .item-table .item-src-store {
        color: #60a5fa !important;
    }
    .dark .keehub-invoice-sheet .subtotal-row span:first-child {
        color: #94a3b8 !important;
    }
    .dark .keehub-invoice-sheet .subtotal-row span:last-child {
        color: #e2e8f0 !important;
    }
    .dark .keehub-invoice-sheet .total-row {
        border-top: 2px solid #334155 !important;
        color: #ffffff !important;
    }
    .dark .keehub-invoice-sheet .total-row .total-amount {
        color: #fbbf24 !important;
    }
    .dark .keehub-invoice-sheet .payment-box {
        background-color: rgba(17, 24, 39, 0.8) !important;
        border: 1px solid #1e293b !important;
        border-left: 3px solid #3b82f6 !important;
        color: #e2e8f0 !important;
    }
    .dark .keehub-invoice-sheet .sig-label {
        color: #94a3b8 !important;
    }
    .dark .keehub-invoice-sheet .sig-line {
        border-color: #475569 !important;
    }
    .dark .keehub-invoice-sheet .sig-name {
        color: #ffffff !important;
    }
    .dark .keehub-invoice-sheet .footer-notes {
        border-top: 1px solid #1e293b !important;
        color: #94a3b8 !important;
    }

    /* Thermal Receipt Dark Mode */
    .dark .keehub-thermal-sheet {
        background-color: #121215 !important;
        border: 1px solid #27272a !important;
        border-top: 4px solid #f59e0b !important;
        color: #f4f4f5 !important;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.6) !important;
    }
    .dark .keehub-thermal-sheet .thermal-brand {
        color: #ffffff !important;
    }
    .dark .keehub-thermal-sheet .thermal-subtext {
        color: #a1a1aa !important;
    }
    .dark .keehub-thermal-sheet .thermal-divider {
        border-color: #3f3f46 !important;
    }
    .dark .keehub-thermal-sheet .thermal-row {
        color: #e4e4e7 !important;
    }
    .dark .keehub-thermal-sheet .thermal-row-highlight {
        color: #ffffff !important;
    }
    .dark .keehub-thermal-sheet .thermal-total-amount {
        color: #fbbf24 !important;
    }
    .dark .keehub-thermal-sheet .thermal-warranty-box {
        background-color: rgba(39, 39, 42, 0.8) !important;
        border: 1px dashed #52525b !important;
    }
    .dark .keehub-thermal-sheet .thermal-warranty-title {
        color: #fbbf24 !important;
    }
    .dark .keehub-thermal-sheet .thermal-warranty-body {
        color: #e4e4e7 !important;
    }
    .dark .keehub-thermal-sheet .thermal-footer-note {
        color: #a1a1aa !important;
    }
    .dark .keehub-thermal-sheet .thermal-qr {
        background-color: #27272a !important;
        border: 1px solid #3f3f46 !important;
        color: #f4f4f5 !important;
    }
    .dark .keehub-thermal-sheet .thermal-qr-code {
        color: #a1a1aa !important;
    }

    /* Switcher & Badges Dark Mode */
    .dark .keehub-preview-switcher-btn.inactive {
        color: #94a3b8 !important;
    }
    .dark .keehub-preview-switcher-btn.inactive:hover {
        color: #ffffff !important;
        background-color: rgba(255, 255, 255, 0.08) !important;
    }
    .dark .keehub-preview-badges {
        background-color: rgba(17, 24, 39, 0.7) !important;
        border-color: #1e293b !important;
    }
    .dark .keehub-preview-badges span {
        color: #cbd5e1 !important;
    }
</style>

<div
    x-data="keehubInvoicePreview({
        brand: @js($defaultBrand),
        tagline: @js($defaultTagline),
        contact: @js($defaultContact),
        payment: @js($defaultPayment),
        signature: @js($defaultSignature),
        serviceFooter: @js($defaultServiceFooter),
        warranty: @js($defaultWarranty)
    })"
    class="lg:sticky lg:top-6 space-y-4"
>
    <!-- Card Preview & Actions -->
    <div class="rounded-xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 shadow-sm p-4 md:p-5">
        <!-- Top Toolbar & Switcher -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 mb-3 border-b border-gray-100 dark:border-gray-800">
            <div>
                <div class="flex items-center gap-2">
                    <span class="text-sm font-bold text-gray-900 dark:text-white">Live Nota & Invoice</span>
                    <span class="inline-flex items-center gap-1 text-[10px] font-semibold px-2 py-0.5 rounded-full bg-amber-100 text-amber-800 dark:bg-amber-900/40 dark:text-amber-300">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                        Real-time
                    </span>
                </div>
                <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5">
                    Preview tampilan cetak langsung saat mengedit form.
                </p>
            </div>

            <!-- View Mode Switcher -->
            <div class="inline-flex rounded-lg bg-gray-100 dark:bg-gray-800 p-0.5 text-xs font-medium">
                <button
                    type="button"
                    @click="previewMode = 'invoice'"
                    :class="previewMode === 'invoice' ? 'bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-xs font-bold active' : 'text-gray-600 dark:text-gray-300 hover:text-gray-900 keehub-preview-switcher-btn inactive'"
                    class="px-2.5 py-1 rounded-md transition text-[11px] flex items-center gap-1.5"
                >
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Invoice PDF (A4)
                </button>
                <button
                    type="button"
                    @click="previewMode = 'thermal'"
                    :class="previewMode === 'thermal' ? 'bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-xs font-bold active' : 'text-gray-600 dark:text-gray-300 hover:text-gray-900 keehub-preview-switcher-btn inactive'"
                    class="px-2.5 py-1 rounded-md transition text-[11px] flex items-center gap-1.5"
                >
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    Struk Thermal
                </button>
            </div>
        </div>

        <!-- Indicator Guide Badges -->
        <div class="keehub-preview-badges flex flex-wrap items-center gap-2 text-[10px] mb-3 px-2.5 py-1.5 rounded-lg bg-gray-50 border border-gray-100">
            <span class="font-bold text-gray-700">Penanda:</span>
            <span class="flex items-center gap-1 text-gray-600 font-medium"><span class="w-2 h-2 rounded-full bg-amber-500"></span> Header</span>
            <span class="flex items-center gap-1 text-gray-600 font-medium"><span class="w-2 h-2 rounded-full bg-blue-500"></span> Rekening</span>
            <span class="flex items-center gap-1 text-gray-600 font-medium"><span class="w-2 h-2 rounded-full bg-emerald-500"></span> Footer / Garansi</span>
        </div>

        <!-- 1. PREVIEW LEMBAR INVOICE A4 -->
        <div x-show="previewMode === 'invoice'" class="transition-all">
            <div class="keehub-invoice-sheet bg-white text-slate-800 rounded-lg shadow-sm border border-slate-200 p-4 text-[11px] leading-relaxed relative overflow-hidden select-none">
                <!-- Header Box (Amber) -->
                <div class="border-b-2 border-amber-500 pb-3 mb-3 relative">
                    <div class="flex justify-between items-start gap-3">
                        <div class="space-y-0.5 max-w-[65%]">
                            <div class="brand-title font-black text-base text-slate-900 tracking-tight" x-text="headerBrand || defaults.brand"></div>
                            <div class="brand-tagline text-[9px] font-bold text-slate-500 uppercase tracking-widest" x-text="headerTagline || defaults.tagline"></div>
                            <div class="brand-contact text-[9.5px] text-slate-600 whitespace-pre-line mt-1 line-clamp-3 leading-snug" x-text="headerContact || defaults.contact"></div>
                        </div>
                        <div class="text-right shrink-0">
                            <div class="doc-title font-black text-lg text-slate-900 tracking-wider">INVOICE</div>
                            <div class="doc-number text-[10px] font-bold text-amber-600">INV-{{ now()->format('Ymd') }}-0042</div>
                            <div class="doc-badge mt-0.5 inline-block px-1.5 py-0.5 rounded bg-amber-100 text-amber-900 text-[8.5px] font-bold">
                                NO. SERVIS: SRV-0042
                            </div>
                            <div class="doc-date text-[8.5px] text-slate-400 mt-1">Tgl: {{ now()->format('d M Y') }}</div>
                        </div>
                    </div>
                </div>

                <!-- Info Grid Sample -->
                <div class="grid grid-cols-2 gap-2 mb-3 text-[10px]">
                    <div class="info-card p-2 rounded bg-slate-50 border border-slate-200">
                        <div class="info-card-header font-bold text-slate-700 uppercase text-[8.5px] border-b border-slate-200 pb-1 mb-1">Ditagihkan Kepada</div>
                        <div class="info-card-name font-semibold text-slate-900">Bpk. Hendra Wijaya</div>
                        <div class="info-card-sub text-blue-600 font-medium text-[9px]">PT Mandiri Kreasi Nusantara</div>
                        <div class="info-card-muted text-slate-500">WA: 0812-9876-5432</div>
                    </div>
                    <div class="info-card p-2 rounded bg-slate-50 border border-slate-200">
                        <div class="info-card-header font-bold text-slate-700 uppercase text-[8.5px] border-b border-slate-200 pb-1 mb-1">Perangkat & Layanan</div>
                        <div class="info-card-name font-semibold text-slate-900">PC Custom RTX 4070</div>
                        <div class="info-card-muted text-slate-600">Layanan: General Service & Clean</div>
                        <div class="info-card-muted text-slate-500">Jatuh Tempo: {{ now()->addDays(7)->format('d M Y') }}</div>
                    </div>
                </div>

                <!-- Items Sample -->
                <table class="item-table w-full text-[9.5px] mb-3 border-collapse">
                    <thead>
                        <tr class="bg-slate-900 text-white text-[8.5px] uppercase">
                            <th class="p-1.5 text-left rounded-tl">Deskripsi Item / Jasa</th>
                            <th class="p-1.5 text-center">Sumber</th>
                            <th class="p-1.5 text-right">Qty</th>
                            <th class="p-1.5 text-right rounded-tr">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-[9px]">
                        <tr>
                            <td class="p-1.5 font-medium">Jasa Deep Clean & Repaste</td>
                            <td class="item-src p-1.5 text-center text-slate-500">Jasa Servis</td>
                            <td class="p-1.5 text-right">1</td>
                            <td class="p-1.5 text-right font-semibold">Rp 150.000</td>
                        </tr>
                        <tr>
                            <td class="p-1.5 font-medium">Thermal Grizzly Kryonaut Extreme</td>
                            <td class="item-src-store p-1.5 text-center text-blue-600 font-bold">KeeHub</td>
                            <td class="p-1.5 text-right">1</td>
                            <td class="p-1.5 text-right font-semibold">Rp 195.000</td>
                        </tr>
                    </tbody>
                </table>

                <!-- Totals Sample -->
                <div class="w-1/2 ml-auto space-y-0.5 text-[9.5px] mb-3">
                    <div class="subtotal-row flex justify-between text-slate-600">
                        <span>Subtotal Part:</span>
                        <span>Rp 195.000</span>
                    </div>
                    <div class="subtotal-row flex justify-between text-slate-600">
                        <span>Biaya Jasa:</span>
                        <span>Rp 150.000</span>
                    </div>
                    <div class="total-row flex justify-between font-black text-slate-900 text-xs border-t-2 border-slate-900 pt-1">
                        <span>TOTAL:</span>
                        <span class="total-amount text-amber-600">Rp 345.000</span>
                    </div>
                </div>

                <!-- Payment Box (Blue Highlight) -->
                <div class="mb-3">
                    <div class="payment-box p-2.5 rounded bg-slate-50 border-l-3 border-blue-500 border border-slate-200 text-[9px] text-slate-700 whitespace-pre-line leading-relaxed" x-text="paymentInstructions || defaults.payment"></div>
                </div>

                <!-- Signatures (Emerald) -->
                <div class="pt-1 pb-2">
                    <div class="grid grid-cols-2 text-center text-[9px] text-slate-600">
                        <div>
                            <div class="sig-label">Finance / Billing,</div>
                            <div class="sig-line w-20 border-b border-slate-400 mx-auto mt-6 mb-1"></div>
                            <div class="sig-name font-bold text-slate-900" x-text="signatureName || defaults.signature"></div>
                        </div>
                        <div>
                            <div class="sig-label">Penerima Tagihan,</div>
                            <div class="sig-line w-20 border-b border-slate-400 mx-auto mt-6 mb-1"></div>
                            <div class="sig-name font-bold text-slate-900">Bpk. Hendra Wijaya</div>
                        </div>
                    </div>
                </div>

                <!-- Footer (Emerald) -->
                <div class="footer-notes mt-2 pt-2 border-t border-slate-200">
                    <div class="text-center text-[8.5px] text-slate-500 whitespace-pre-line" x-text="serviceFooter || invoiceFooterNotes || defaults.serviceFooter"></div>
                </div>
            </div>
        </div>

        <!-- 2. PREVIEW STRUK THERMAL KASIR -->
        <div x-show="previewMode === 'thermal'" class="transition-all" style="display: none;">
            <div class="py-2 flex justify-center bg-gray-50/80 dark:bg-gray-950/50 rounded-lg p-3 border border-dashed border-gray-200 dark:border-gray-800">
                <div class="keehub-thermal-sheet w-[260px] bg-white text-zinc-900 shadow-lg rounded-t-sm font-mono text-[9.5px] p-3 leading-tight select-none border-t-4 border-amber-500">
                    <!-- Header -->
                    <div class="text-center space-y-0.5">
                        <div class="thermal-brand font-black text-sm tracking-wider" x-text="headerBrand || defaults.brand"></div>
                        <div class="thermal-subtext text-[8.5px] text-zinc-600" x-text="headerTagline || defaults.tagline"></div>
                        <div class="thermal-subtext text-[8px] text-zinc-500 whitespace-pre-line mt-1" x-text="headerContact || defaults.contact"></div>
                    </div>

                    <div class="thermal-divider border-t border-dashed border-zinc-800 my-2"></div>

                    <!-- Service info -->
                    <div class="text-[8.5px] space-y-0.5">
                        <div class="thermal-row flex justify-between"><span>No. Servis</span><span class="thermal-row-highlight font-bold">#SRV-0042</span></div>
                        <div class="thermal-row flex justify-between"><span>Pelanggan</span><span>Hendra Wijaya</span></div>
                        <div class="thermal-row flex justify-between"><span>Unit</span><span>PC RTX 4070</span></div>
                    </div>

                    <div class="thermal-divider border-t border-dashed border-zinc-800 my-2"></div>

                    <!-- Items -->
                    <div class="space-y-0.5 text-[8.5px]">
                        <div class="thermal-row flex justify-between">
                            <span>Deep Clean + Repaste</span>
                            <span>150.000</span>
                        </div>
                        <div class="thermal-row flex justify-between">
                            <span>Kryonaut Extreme</span>
                            <span>195.000</span>
                        </div>
                        <div class="thermal-divider border-t border-dashed border-zinc-800 my-1"></div>
                        <div class="thermal-row-highlight flex justify-between font-bold text-[10px]">
                            <span>TOTAL TAGIHAN</span>
                            <span class="thermal-total-amount text-amber-600">Rp 345.000</span>
                        </div>
                    </div>

                    <div class="thermal-divider border-t border-dashed border-zinc-800 my-2"></div>

                    <!-- Syarat Garansi Box -->
                    <div class="thermal-warranty-box border border-dashed border-zinc-500 p-1.5 my-1.5 rounded-xs bg-zinc-50">
                        <div class="thermal-warranty-title text-[7.5px] font-bold text-zinc-700 uppercase text-center mb-0.5">KETENTUAN GARANSI SERVIS:</div>
                        <div class="thermal-warranty-body text-[7.5px] text-zinc-600 whitespace-pre-line leading-tight" x-text="warrantyTerms || defaults.warranty"></div>
                    </div>

                    <!-- Footer Note -->
                    <div class="thermal-footer-note text-center text-[8px] text-zinc-600 whitespace-pre-line mt-2" x-text="serviceFooter || invoiceFooterNotes || defaults.serviceFooter"></div>

                    <!-- Barcode dummy -->
                    <div class="text-center my-2">
                        <div class="thermal-qr w-10 h-10 mx-auto bg-zinc-900 flex items-center justify-center text-[6px] text-white font-mono p-1">
                            [ QR ]
                        </div>
                        <div class="thermal-qr-code text-[7.5px] tracking-widest mt-0.5 text-zinc-500">#SRV-0042-TRACK</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
