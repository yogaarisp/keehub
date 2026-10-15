@php
    $storeName = \App\Models\Setting::get('store_name', 'KeeHub');
    $storeTagline = \App\Models\Setting::get('store_tagline', 'Build Your PC. Your Way.');
    $storeAddress = \App\Models\Setting::get('store_address', 'Jl. Kaliurang KM 5, Sleman, DI Yogyakarta');
    $storePhone = \App\Models\Setting::get('whatsapp_number', '0812-3456-7890');
    $logoUrl = \App\Models\Setting::logoUrl();
@endphp

<div
    x-data="keehubPrinterPreview()"
    class="lg:sticky lg:top-6 space-y-4"
>
    <!-- Card Preview & Actions -->
    <div class="rounded-xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 shadow-sm p-4 md:p-5">
        <!-- Top Toolbar -->
        <div class="flex items-center justify-between pb-3 mb-3 border-b border-gray-100 dark:border-gray-800">
            <div>
                <div class="flex items-center gap-2">
                    <span class="text-sm font-bold text-gray-900 dark:text-white">Live Struk Kasir</span>
                    <span
                        class="text-[10px] font-semibold px-2 py-0.5 rounded-full"
                        :class="(paperSize === '80mm') ? 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300' : 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300'"
                        x-text="'Roll ' + (paperSize || '58mm')"
                    ></span>
                </div>
                <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5">
                    Preview tampilan cetak thermal real-time.
                </p>
            </div>

            <!-- Primary Test Print Button -->
            <button
                type="button"
                @click="printThermalReceipt()"
                class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-bold rounded-lg bg-primary-600 hover:bg-primary-500 active:scale-95 text-white shadow-sm transition shrink-0"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                <span>Test Cetak</span>
            </button>
        </div>

        <!-- Dynamic Connection Pairing Buttons (contextual) -->
        <div class="mb-3 space-y-2" x-show="connectionType === 'bluetooth' || connectionType === 'usb'">
            <!-- Bluetooth Button -->
            <div x-show="connectionType === 'bluetooth'" class="flex items-center justify-between p-2.5 rounded-lg bg-blue-50/70 dark:bg-blue-950/30 border border-blue-200 dark:border-blue-900/50 text-xs">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full" :class="bluetoothStatus === 'connected' ? 'bg-emerald-500' : 'bg-blue-500 animate-pulse'"></span>
                    <span class="text-blue-900 dark:text-blue-200 font-medium" x-text="bluetoothStatus === 'connected' ? (bluetoothDeviceName || 'Bluetooth Terhubung') : 'Printer Bluetooth Belum Terhubung'"></span>
                </div>
                <button
                    type="button"
                    @click="pairBluetooth()"
                    class="px-2.5 py-1 text-[11px] font-semibold rounded bg-blue-600 hover:bg-blue-500 text-white transition"
                    x-text="bluetoothStatus === 'connected' ? 'Ganti Device' : 'Sambungkan'"
                ></button>
            </div>

            <!-- USB Button -->
            <div x-show="connectionType === 'usb'" class="flex items-center justify-between p-2.5 rounded-lg bg-indigo-50/70 dark:bg-indigo-950/30 border border-indigo-200 dark:border-indigo-900/50 text-xs">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full" :class="usbStatus === 'connected' ? 'bg-emerald-500' : 'bg-indigo-500 animate-pulse'"></span>
                    <span class="text-indigo-900 dark:text-indigo-200 font-medium" x-text="usbStatus === 'connected' ? (usbDeviceName || 'USB Terhubung') : 'Pilih Port Printer USB'"></span>
                </div>
                <button
                    type="button"
                    @click="pairUsb()"
                    class="px-2.5 py-1 text-[11px] font-semibold rounded bg-indigo-600 hover:bg-indigo-500 text-white transition"
                    x-text="usbStatus === 'connected' ? 'Ganti Port' : 'Pilih USB'"
                ></button>
            </div>
        </div>

        <!-- Receipt Roll Simulation -->
        <div class="py-2 flex justify-center bg-gray-50/80 dark:bg-gray-950/50 rounded-lg p-3 border border-dashed border-gray-200 dark:border-gray-800">
            <div
                class="relative transition-all duration-300 shadow-md"
                :style="paperSize === '80mm' ? 'width: 290px;' : 'width: 230px;'"
            >
                <!-- Top Torn Paper Edge -->
                <div class="w-full h-2.5 overflow-hidden leading-none text-white dark:text-zinc-100">
                    <svg viewBox="0 0 240 10" preserveAspectRatio="none" class="w-full h-full fill-current">
                        <polygon points="0,10 5,0 10,10 15,0 20,10 25,0 30,10 35,0 40,10 45,0 50,10 55,0 60,10 65,0 70,10 75,0 80,10 85,0 90,10 95,0 100,10 105,0 110,10 115,0 120,10 125,0 130,10 135,0 140,10 145,0 150,10 155,0 160,10 165,0 170,10 175,0 180,10 185,0 190,10 195,0 200,10 205,0 210,10 215,0 220,10 225,0 230,10 235,0 240,10" />
                    </svg>
                </div>

                <!-- Live Receipt Body -->
                <div
                    id="keehub-live-thermal-receipt-body"
                    class="bg-white text-zinc-950 px-3.5 py-2.5 font-mono border-x border-zinc-200"
                    :class="paperSize === '80mm' ? 'text-xs' : 'text-[10.5px]'"
                    style="line-height: 1.25;"
                >
                    <!-- Logo (if enabled) -->
                    <template x-if="printLogo">
                        <div class="text-center mb-1">
                            <img src="{{ $logoUrl }}" alt="Logo" class="receipt-logo max-h-10 mx-auto filter grayscale contrast-150" />
                        </div>
                    </template>

                    <!-- Store Name & Info -->
                    <div class="text-center font-bold tracking-tight uppercase" :class="paperSize === '80mm' ? 'text-sm' : 'text-xs'">
                        {{ $storeName }}
                    </div>
                    <div class="text-center text-[9px] text-zinc-600">
                        {{ $storeTagline }}
                    </div>
                    <div class="text-center text-[9px] text-zinc-600 mt-0.5">
                        {{ $storeAddress }}
                    </div>
                    @if($storePhone)
                    <div class="text-center text-[9px] text-zinc-600">
                        WA: {{ $storePhone }}
                    </div>
                    @endif

                    <!-- Custom Header Note -->
                    <template x-if="headerText && headerText.trim().length > 0">
                        <div class="text-center text-[9.5px] text-zinc-700 mt-1 whitespace-pre-line" x-text="headerText"></div>
                    </template>

                    <!-- Divider -->
                    <div class="dashed-line border-t border-dashed border-zinc-800 my-1.5"></div>

                    <!-- Meta Info -->
                    <div class="flex justify-between text-[9px]">
                        <span>#INV-{{ now()->format('Ymd') }}-001</span>
                        <span>Kasir: Admin</span>
                    </div>
                    <div class="flex justify-between text-[9px]">
                        <span>{{ now()->format('d/m/Y H:i') }}</span>
                        <span class="font-bold">TUNAI / QRIS</span>
                    </div>

                    <!-- Divider -->
                    <div class="dashed-line border-t border-dashed border-zinc-800 my-1.5"></div>

                    <!-- Sample Items -->
                    <div class="space-y-1">
                        <div>
                            <div class="font-bold">Gateron Yellow Pro Switch</div>
                            <div class="flex justify-between text-[9.5px]">
                                <span>1 x @ 140.000</span>
                                <span>Rp 140.000</span>
                            </div>
                        </div>

                        <div>
                            <div class="font-bold">Custom Coiled Cable Type-C</div>
                            <div class="flex justify-between text-[9.5px]">
                                <span>1 x @ 185.000</span>
                                <span>Rp 185.000</span>
                            </div>
                        </div>

                        <div>
                            <div class="font-bold">Jasa Mod & Lube Switch</div>
                            <div class="flex justify-between text-[9.5px]">
                                <span>1 x @ 75.000</span>
                                <span>Rp 75.000</span>
                            </div>
                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="dashed-line border-t border-dashed border-zinc-800 my-1.5"></div>

                    <!-- Totals -->
                    <div class="space-y-0.5 text-[9.5px]">
                        <div class="flex justify-between">
                            <span>Subtotal</span>
                            <span>Rp 400.000</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Diskon Voucher</span>
                            <span>-Rp 25.000</span>
                        </div>
                        <div class="dashed-line border-t border-dashed border-zinc-800 my-1"></div>
                        <div class="flex justify-between font-bold" :class="paperSize === '80mm' ? 'text-xs' : 'text-[11px]'">
                            <span>TOTAL</span>
                            <span>Rp 375.000</span>
                        </div>
                        <div class="flex justify-between text-[9px] text-zinc-600">
                            <span>Bayar Tunai</span>
                            <span>Rp 400.000</span>
                        </div>
                        <div class="flex justify-between text-[9px] text-zinc-600">
                            <span>Kembalian</span>
                            <span>Rp 25.000</span>
                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="dashed-line border-t border-dashed border-zinc-800 my-1.5"></div>

                    <!-- Barcode dummy -->
                    <div class="text-center my-1.5">
                        <div class="w-12 h-12 mx-auto bg-zinc-900 flex items-center justify-center text-[7px] text-white font-mono p-1 text-center">
                            [ QR KASIR ]
                        </div>
                        <div class="text-[8px] tracking-widest mt-0.5">#INV-{{ now()->format('Ymd') }}-001</div>
                    </div>

                    <!-- Custom Footer -->
                    <div class="text-center text-[9.5px] text-zinc-700 whitespace-pre-line mt-1.5" x-text="footerText || 'Terima kasih telah berbelanja di KeeHub!'"></div>

                    <!-- Signals -->
                    <div class="text-center text-[8px] text-zinc-400 mt-1 italic">
                        <span x-show="autoCut">[Perintah Auto-Cut]</span>
                        <span x-show="cashDrawer" class="ml-1">[Buka Laci Uang]</span>
                    </div>
                </div>

                <!-- Bottom Torn Paper Edge -->
                <div class="w-full h-2.5 overflow-hidden leading-none text-white dark:text-zinc-100 rotate-180">
                    <svg viewBox="0 0 240 10" preserveAspectRatio="none" class="w-full h-full fill-current">
                        <polygon points="0,10 5,0 10,10 15,0 20,10 25,0 30,10 35,0 40,10 45,0 50,10 55,0 60,10 65,0 70,10 75,0 80,10 85,0 90,10 95,0 100,10 105,0 110,10 115,0 120,10 125,0 130,10 135,0 140,10 145,0 150,10 155,0 160,10 165,0 170,10 175,0 180,10 185,0 190,10 195,0 200,10 205,0 210,10 215,0 220,10 225,0 230,10 235,0 240,10" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Collapsible Panduan Singkat -->
        <details class="mt-3 text-xs border border-gray-200 dark:border-gray-800 rounded-lg p-2.5 bg-gray-50/70 dark:bg-gray-800/40 group">
            <summary class="font-semibold cursor-pointer text-gray-700 dark:text-gray-300 flex items-center justify-between select-none">
                <span class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Panduan Koneksi Printer Thermal
                </span>
                <span class="text-gray-400 group-open:rotate-180 transition-transform">▾</span>
            </summary>
            <div class="mt-2.5 pt-2 border-t border-gray-200 dark:border-gray-700 space-y-2 text-[11px] text-gray-600 dark:text-gray-400">
                <p>
                    <strong>Bluetooth:</strong> Nyalakan printer, pairing dari HP/Tablet/Laptop (PIN <code>0000</code> / <code>1234</code>).
                </p>
                <p>
                    <strong>USB:</strong> Hubungkan kabel ke komputer kasir. Pasang driver thermal (POS-58/80 atau generic ESC/POS).
                </p>
                <p>
                    <strong>LAN / WiFi:</strong> Masukkan IP statis printer dan port standar <code>9100</code>.
                </p>
            </div>
        </details>
    </div>
</div>
