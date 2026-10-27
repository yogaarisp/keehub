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
                    :class="previewMode === 'invoice' ? 'bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-xs font-bold' : 'text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white'"
                    class="px-2.5 py-1 rounded-md transition text-[11px] flex items-center gap-1.5"
                >
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Invoice PDF (A4)
                </button>
                <button
                    type="button"
                    @click="previewMode = 'thermal'"
                    :class="previewMode === 'thermal' ? 'bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-xs font-bold' : 'text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white'"
                    class="px-2.5 py-1 rounded-md transition text-[11px] flex items-center gap-1.5"
                >
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    Struk Thermal
                </button>
            </div>
        </div>

        <!-- Indicator Guide Badges -->
        <div class="flex flex-wrap items-center gap-2 text-[10px] mb-3 px-2.5 py-1.5 rounded-lg bg-gray-50 dark:bg-gray-800/60 border border-gray-100 dark:border-gray-700/60">
            <span class="font-bold text-gray-700 dark:text-gray-200">Penanda:</span>
            <span class="flex items-center gap-1 text-gray-600 dark:text-gray-300 font-medium"><span class="w-2 h-2 rounded-full bg-amber-500"></span> Header</span>
            <span class="flex items-center gap-1 text-gray-600 dark:text-gray-300 font-medium"><span class="w-2 h-2 rounded-full bg-blue-500"></span> Rekening</span>
            <span class="flex items-center gap-1 text-gray-600 dark:text-gray-300 font-medium"><span class="w-2 h-2 rounded-full bg-emerald-500"></span> Footer / Garansi</span>
        </div>

        <!-- 1. PREVIEW LEMBAR INVOICE A4 -->
        <div x-show="previewMode === 'invoice'" class="transition-all">
            <div class="bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-100 rounded-lg shadow-sm border border-slate-200 dark:border-slate-800 p-4 text-[11px] leading-relaxed relative overflow-hidden select-none">
                <!-- Header Box (Amber) -->
                <div class="border-b-2 border-amber-500 pb-3 mb-3 relative">
                    <div class="flex justify-between items-start gap-3">
                        <div class="space-y-0.5 max-w-[65%]">
                            <div class="font-black text-base text-slate-900 dark:text-white tracking-tight" x-text="headerBrand || defaults.brand"></div>
                            <div class="text-[9px] font-bold text-slate-500 dark:text-amber-400 uppercase tracking-widest" x-text="headerTagline || defaults.tagline"></div>
                            <div class="text-[9.5px] text-slate-600 dark:text-slate-300 whitespace-pre-line mt-1 line-clamp-3 leading-snug" x-text="headerContact || defaults.contact"></div>
                        </div>
                        <div class="text-right shrink-0">
                            <div class="font-black text-lg text-slate-900 dark:text-white tracking-wider">INVOICE</div>
                            <div class="text-[10px] font-bold text-amber-600 dark:text-amber-400">INV-{{ now()->format('Ymd') }}-0042</div>
                            <div class="mt-0.5 inline-block px-1.5 py-0.5 rounded bg-amber-100 dark:bg-amber-950/80 text-amber-900 dark:text-amber-300 border border-amber-200 dark:border-amber-800/60 text-[8.5px] font-bold">
                                NO. SERVIS: SRV-0042
                            </div>
                            <div class="text-[8.5px] text-slate-500 dark:text-slate-400 mt-1">Tgl: {{ now()->format('d M Y') }}</div>
                        </div>
                    </div>
                </div>

                <!-- Info Grid Sample -->
                <div class="grid grid-cols-2 gap-2 mb-3 text-[10px]">
                    <div class="p-2 rounded bg-slate-50 dark:bg-slate-800/70 border border-slate-200 dark:border-slate-700">
                        <div class="font-bold text-slate-700 dark:text-slate-200 uppercase text-[8.5px] border-b border-slate-200 dark:border-slate-700 pb-1 mb-1">Ditagihkan Kepada</div>
                        <div class="font-semibold text-slate-900 dark:text-white">Bpk. Hendra Wijaya</div>
                        <div class="text-blue-600 dark:text-blue-400 font-medium text-[9px]">PT Mandiri Kreasi Nusantara</div>
                        <div class="text-slate-600 dark:text-slate-400">WA: 0812-9876-5432</div>
                    </div>
                    <div class="p-2 rounded bg-slate-50 dark:bg-slate-800/70 border border-slate-200 dark:border-slate-700">
                        <div class="font-bold text-slate-700 dark:text-slate-200 uppercase text-[8.5px] border-b border-slate-200 dark:border-slate-700 pb-1 mb-1">Perangkat & Layanan</div>
                        <div class="font-semibold text-slate-900 dark:text-white">PC Custom RTX 4070</div>
                        <div class="text-slate-600 dark:text-slate-300">Layanan: General Service & Clean</div>
                        <div class="text-slate-600 dark:text-slate-400">Jatuh Tempo: {{ now()->addDays(7)->format('d M Y') }}</div>
                    </div>
                </div>

                <!-- Items Sample -->
                <table class="w-full text-[9.5px] mb-3 border-collapse">
                    <thead>
                        <tr class="bg-slate-900 dark:bg-slate-800 text-white dark:text-slate-100 text-[8.5px] uppercase">
                            <th class="p-1.5 text-left rounded-tl">Deskripsi Item / Jasa</th>
                            <th class="p-1.5 text-center">Sumber</th>
                            <th class="p-1.5 text-right">Qty</th>
                            <th class="p-1.5 text-right rounded-tr">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-[9px]">
                        <tr>
                            <td class="p-1.5 font-medium text-slate-800 dark:text-slate-200">Jasa Deep Clean & Repaste</td>
                            <td class="p-1.5 text-center text-slate-500 dark:text-slate-400">Jasa Servis</td>
                            <td class="p-1.5 text-right text-slate-700 dark:text-slate-300">1</td>
                            <td class="p-1.5 text-right font-semibold text-slate-900 dark:text-white">Rp 150.000</td>
                        </tr>
                        <tr>
                            <td class="p-1.5 font-medium text-slate-800 dark:text-slate-200">Thermal Grizzly Kryonaut Extreme</td>
                            <td class="p-1.5 text-center text-blue-600 dark:text-blue-400 font-bold">KeeHub</td>
                            <td class="p-1.5 text-right text-slate-700 dark:text-slate-300">1</td>
                            <td class="p-1.5 text-right font-semibold text-slate-900 dark:text-white">Rp 195.000</td>
                        </tr>
                    </tbody>
                </table>

                <!-- Totals Sample -->
                <div class="w-1/2 ml-auto space-y-0.5 text-[9.5px] mb-3">
                    <div class="flex justify-between text-slate-600 dark:text-slate-400">
                        <span>Subtotal Part:</span>
                        <span class="text-slate-800 dark:text-slate-200">Rp 195.000</span>
                    </div>
                    <div class="flex justify-between text-slate-600 dark:text-slate-400">
                        <span>Biaya Jasa:</span>
                        <span class="text-slate-800 dark:text-slate-200">Rp 150.000</span>
                    </div>
                    <div class="flex justify-between font-black text-slate-900 dark:text-white text-xs border-t-2 border-slate-900 dark:border-slate-700 pt-1">
                        <span>TOTAL:</span>
                        <span class="text-amber-600 dark:text-amber-400">Rp 345.000</span>
                    </div>
                </div>

                <!-- Payment Box (Blue Highlight) -->
                <div class="mb-3">
                    <div class="p-2.5 rounded bg-slate-50 dark:bg-slate-800/70 border-l-3 border-blue-500 border border-slate-200 dark:border-slate-700 text-[9px] text-slate-700 dark:text-slate-200 whitespace-pre-line leading-relaxed" x-text="paymentInstructions || defaults.payment"></div>
                </div>

                <!-- Signatures (Emerald) -->
                <div class="pt-1 pb-2">
                    <div class="grid grid-cols-2 text-center text-[9px] text-slate-600 dark:text-slate-400">
                        <div>
                            <div>Finance / Billing,</div>
                            <div class="w-20 border-b border-slate-400 dark:border-slate-600 mx-auto mt-6 mb-1"></div>
                            <div class="font-bold text-slate-900 dark:text-white" x-text="signatureName || defaults.signature"></div>
                        </div>
                        <div>
                            <div>Penerima Tagihan,</div>
                            <div class="w-20 border-b border-slate-400 dark:border-slate-600 mx-auto mt-6 mb-1"></div>
                            <div class="font-bold text-slate-900 dark:text-white">Bpk. Hendra Wijaya</div>
                        </div>
                    </div>
                </div>

                <!-- Footer (Emerald) -->
                <div class="mt-2 pt-2 border-t border-slate-200 dark:border-slate-800">
                    <div class="text-center text-[8.5px] text-slate-500 dark:text-slate-400 whitespace-pre-line" x-text="serviceFooter || invoiceFooterNotes || defaults.serviceFooter"></div>
                </div>
            </div>
        </div>

        <!-- 2. PREVIEW STRUK THERMAL KASIR -->
        <div x-show="previewMode === 'thermal'" class="transition-all" style="display: none;">
            <div class="py-2 flex justify-center bg-gray-50/80 dark:bg-gray-950/50 rounded-lg p-3 border border-dashed border-gray-200 dark:border-gray-800">
                <div class="w-[260px] bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 shadow-lg rounded-t-sm font-mono text-[9.5px] p-3 leading-tight select-none border-t-4 border-amber-500 border-x border-b border-zinc-200 dark:border-zinc-800">
                    <!-- Header -->
                    <div class="text-center space-y-0.5">
                        <div class="font-black text-sm tracking-wider text-zinc-900 dark:text-white" x-text="headerBrand || defaults.brand"></div>
                        <div class="text-[8.5px] text-zinc-600 dark:text-zinc-400" x-text="headerTagline || defaults.tagline"></div>
                        <div class="text-[8px] text-zinc-500 dark:text-zinc-400 whitespace-pre-line mt-1" x-text="headerContact || defaults.contact"></div>
                    </div>

                    <div class="border-t border-dashed border-zinc-800 dark:border-zinc-700 my-2"></div>

                    <!-- Service info -->
                    <div class="text-[8.5px] space-y-0.5 text-zinc-800 dark:text-zinc-200">
                        <div class="flex justify-between"><span>No. Servis</span><span class="font-bold text-zinc-900 dark:text-white">#SRV-0042</span></div>
                        <div class="flex justify-between"><span>Pelanggan</span><span>Hendra Wijaya</span></div>
                        <div class="flex justify-between"><span>Unit</span><span>PC RTX 4070</span></div>
                    </div>

                    <div class="border-t border-dashed border-zinc-800 dark:border-zinc-700 my-2"></div>

                    <!-- Items -->
                    <div class="space-y-0.5 text-[8.5px] text-zinc-800 dark:text-zinc-200">
                        <div class="flex justify-between">
                            <span>Deep Clean + Repaste</span>
                            <span>150.000</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Kryonaut Extreme</span>
                            <span>195.000</span>
                        </div>
                        <div class="border-t border-dashed border-zinc-800 dark:border-zinc-700 my-1"></div>
                        <div class="flex justify-between font-bold text-[10px] text-zinc-900 dark:text-white">
                            <span>TOTAL TAGIHAN</span>
                            <span class="text-amber-600 dark:text-amber-400">Rp 345.000</span>
                        </div>
                    </div>

                    <div class="border-t border-dashed border-zinc-800 dark:border-zinc-700 my-2"></div>

                    <!-- Syarat Garansi Box -->
                    <div class="border border-dashed border-zinc-400 dark:border-zinc-700 p-1.5 my-1.5 rounded-xs bg-zinc-50 dark:bg-zinc-800/80">
                        <div class="text-[8px] font-bold text-zinc-800 dark:text-zinc-200 uppercase text-center mb-0.5">KETENTUAN GARANSI SERVIS:</div>
                        <div class="text-[8px] text-zinc-700 dark:text-zinc-300 whitespace-pre-line leading-tight" x-text="warrantyTerms || defaults.warranty"></div>
                    </div>

                    <!-- Footer Note -->
                    <div class="text-center text-[8.5px] text-zinc-600 dark:text-zinc-400 whitespace-pre-line mt-2" x-text="serviceFooter || invoiceFooterNotes || defaults.serviceFooter"></div>

                    <!-- Barcode dummy -->
                    <div class="text-center my-2">
                        <div class="w-10 h-10 mx-auto bg-zinc-900 dark:bg-zinc-800 flex items-center justify-center text-[6px] text-white dark:text-zinc-300 font-mono p-1 border dark:border-zinc-700">
                            [ QR ]
                        </div>
                        <div class="text-[7.5px] tracking-widest mt-0.5 text-zinc-500 dark:text-zinc-400">#SRV-0042-TRACK</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
