@php
    $storeName = \App\Models\Setting::get('store_name', 'KeeHub');
    $storeTagline = \App\Models\Setting::get('store_tagline', 'Build Your PC. Your Way.');
    $storeAddress = \App\Models\Setting::get('store_address', 'Jl. Kaliurang KM 5, Sleman, DI Yogyakarta');
    $storePhone = \App\Models\Setting::get('whatsapp_number', '0812-3456-7890');
    $logoUrl = \App\Models\Setting::logoUrl();
@endphp

<div
    x-data="keehubPrinterPreview()"
    class="rounded-xl border border-gray-200 dark:border-gray-800 bg-gray-50/70 dark:bg-gray-900/50 p-4 md:p-6"
>
    <!-- Header / Banner Status -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-5 border-b border-gray-200 dark:border-gray-800">
        <div class="flex items-start gap-3">
            <div class="w-10 h-10 rounded-lg bg-primary-500/10 dark:bg-primary-500/20 text-primary-600 dark:text-primary-400 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
            </div>
            <div>
                <h4 class="text-base font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                    Simulasi & Uji Coba Cetak Struk Kasir
                    <span
                        class="text-xs font-medium px-2 py-0.5 rounded-full"
                        :class="(paperSize === '80mm') ? 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300' : 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300'"
                        x-text="'Format Roll ' + (paperSize || '58mm')"
                    ></span>
                </h4>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                    Pastikan tampilan struk belanja Anda sudah rapi dan printer terhubung sebelum digunakan di transaksi kasir harian.
                </p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-wrap items-center gap-2">
            <!-- Bluetooth Pair Button (visible when bluetooth selected) -->
            <button
                type="button"
                x-show="connectionType === 'bluetooth'"
                @click="pairBluetooth()"
                class="inline-flex items-center gap-1.5 px-3 py-2 text-xs font-medium rounded-lg border border-blue-200 dark:border-blue-800 bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 hover:bg-blue-100 transition shadow-sm"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3l6 6-6 6V3zm0 18l6-6-6-6v12z" />
                </svg>
                <span x-text="bluetoothStatus === 'connected' ? '✓ ' + (bluetoothDeviceName || 'Bluetooth Terhubung') : 'Hubungkan Bluetooth'"></span>
            </button>

            <!-- USB Pair Button (visible when usb selected) -->
            <button
                type="button"
                x-show="connectionType === 'usb'"
                @click="pairUsb()"
                class="inline-flex items-center gap-1.5 px-3 py-2 text-xs font-medium rounded-lg border border-indigo-200 dark:border-indigo-800 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 hover:bg-indigo-100 transition shadow-sm"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span x-text="usbStatus === 'connected' ? '✓ ' + (usbDeviceName || 'USB Terhubung') : 'Pilih Printer USB'"></span>
            </button>

            <!-- Test Print Button -->
            <button
                type="button"
                @click="printThermalReceipt()"
                class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold rounded-lg bg-primary-600 hover:bg-primary-500 text-white shadow-sm transition active:scale-95"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                <span>Cetak Uji Coba Struk</span>
            </button>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mt-6 items-start">
        <!-- Left Column: Receipt Visual Mockup -->
        <div class="lg:col-span-5 flex flex-col items-center">
            <div class="w-full text-center mb-2">
                <span class="text-xs uppercase tracking-wider font-bold text-gray-500 dark:text-gray-400">
                    Preview Tampilan Fisik Kertas Thermal
                </span>
            </div>

            <!-- Receipt Container with Paper Roll Aesthetics -->
            <div
                class="relative transition-all duration-300 mx-auto shadow-xl"
                :style="paperSize === '80mm' ? 'width: 320px;' : 'width: 250px;'"
            >
                <!-- Torn Paper Top Edge (SVG ZigZag) -->
                <div class="w-full h-3 overflow-hidden leading-none text-white dark:text-zinc-100">
                    <svg viewBox="0 0 240 10" preserveAspectRatio="none" class="w-full h-full fill-current">
                        <polygon points="0,10 5,0 10,10 15,0 20,10 25,0 30,10 35,0 40,10 45,0 50,10 55,0 60,10 65,0 70,10 75,0 80,10 85,0 90,10 95,0 100,10 105,0 110,10 115,0 120,10 125,0 130,10 135,0 140,10 145,0 150,10 155,0 160,10 165,0 170,10 175,0 180,10 185,0 190,10 195,0 200,10 205,0 210,10 215,0 220,10 225,0 230,10 235,0 240,10" />
                    </svg>
                </div>

                <!-- Printable Live Thermal Receipt Body -->
                <div
                    id="keehub-live-thermal-receipt-body"
                    class="bg-white text-zinc-950 px-4 py-3 font-mono border-x border-zinc-200"
                    :class="paperSize === '80mm' ? 'text-xs' : 'text-[11px]'"
                    style="line-height: 1.3;"
                >
                    <!-- Logo (if enabled) -->
                    <template x-if="printLogo">
                        <div class="text-center mb-1">
                            <img src="{{ $logoUrl }}" alt="Logo" class="receipt-logo max-h-12 mx-auto filter grayscale contrast-150" />
                        </div>
                    </template>

                    <!-- Store Name & Info -->
                    <div class="text-center font-bold tracking-tight text-sm uppercase">
                        {{ $storeName }}
                    </div>
                    <div class="text-center text-[10px] text-zinc-600">
                        {{ $storeTagline }}
                    </div>
                    <div class="text-center text-[10px] text-zinc-600 mt-0.5">
                        {{ $storeAddress }}
                    </div>
                    @if($storePhone)
                    <div class="text-center text-[10px] text-zinc-600">
                        WA: {{ $storePhone }}
                    </div>
                    @endif

                    <!-- Custom Header Note (if filled) -->
                    <template x-if="headerText && headerText.trim().length > 0">
                        <div class="text-center text-[10px] text-zinc-700 mt-1 whitespace-pre-line" x-text="headerText"></div>
                    </template>

                    <!-- Divider -->
                    <div class="dashed-line border-t border-dashed border-zinc-800 my-2"></div>

                    <!-- Meta Transaction Info -->
                    <div class="flex justify-between text-[10px]">
                        <span>No: #INV-20261015-089</span>
                        <span>Kasir: Admin</span>
                    </div>
                    <div class="flex justify-between text-[10px]">
                        <span>Tgl: {{ now()->format('d/m/Y H:i') }}</span>
                        <span class="uppercase">TUNAI / QRIS</span>
                    </div>

                    <!-- Divider -->
                    <div class="dashed-line border-t border-dashed border-zinc-800 my-2"></div>

                    <!-- Items List -->
                    <div class="space-y-1">
                        <div>
                            <div class="font-bold">Gateron Yellow Pro Switch (35pcs)</div>
                            <div class="flex justify-between text-[10px]">
                                <span>1 x @ Rp 140.000</span>
                                <span>Rp 140.000</span>
                            </div>
                        </div>

                        <div>
                            <div class="font-bold">Custom Coiled Cable Type-C</div>
                            <div class="flex justify-between text-[10px]">
                                <span>1 x @ Rp 185.000</span>
                                <span>Rp 185.000</span>
                            </div>
                        </div>

                        <div>
                            <div class="font-bold">Jasa Lube & Holee Mod Switch</div>
                            <div class="flex justify-between text-[10px]">
                                <span>1 x @ Rp 75.000</span>
                                <span>Rp 75.000</span>
                            </div>
                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="dashed-line border-t border-dashed border-zinc-800 my-2"></div>

                    <!-- Calculations -->
                    <div class="space-y-0.5 text-[10px]">
                        <div class="flex justify-between">
                            <span>Subtotal</span>
                            <span>Rp 400.000</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Diskon Voucher</span>
                            <span>-Rp 25.000</span>
                        </div>
                        <div class="dashed-line border-t border-dashed border-zinc-800 my-1"></div>
                        <div class="flex justify-between font-bold text-xs">
                            <span>TOTAL</span>
                            <span>Rp 375.000</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Bayar</span>
                            <span>Rp 400.000</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Kembali</span>
                            <span>Rp 25.000</span>
                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="dashed-line border-t border-dashed border-zinc-800 my-2"></div>

                    <!-- QR / Barcode dummy preview -->
                    <div class="text-center my-2">
                        <div class="inline-block p-1 border border-zinc-400 bg-white">
                            <div class="w-16 h-16 mx-auto bg-zinc-900 flex items-center justify-center text-[8px] text-white font-mono p-1 text-center">
                                [ QR VERIFIKASI ]
                            </div>
                        </div>
                        <div class="text-[9px] tracking-widest mt-1">#INV-20261015-089</div>
                    </div>

                    <!-- Custom Footer Text -->
                    <div class="text-center text-[10px] text-zinc-700 whitespace-pre-line mt-2" x-text="footerText || 'Terima kasih telah berbelanja di KeeHub!'"></div>

                    <!-- Hardware Status Signals -->
                    <div class="text-center text-[9px] text-zinc-400 mt-2 italic">
                        <span x-show="autoCut">[Perintah Auto-Cut Dikirim]</span>
                        <span x-show="cashDrawer" class="ml-1">[Laci Kasir Dibuka]</span>
                    </div>
                </div>

                <!-- Torn Paper Bottom Edge (SVG ZigZag) -->
                <div class="w-full h-3 overflow-hidden leading-none text-white dark:text-zinc-100 rotate-180">
                    <svg viewBox="0 0 240 10" preserveAspectRatio="none" class="w-full h-full fill-current">
                        <polygon points="0,10 5,0 10,10 15,0 20,10 25,0 30,10 35,0 40,10 45,0 50,10 55,0 60,10 65,0 70,10 75,0 80,10 85,0 90,10 95,0 100,10 105,0 110,10 115,0 120,10 125,0 130,10 135,0 140,10 145,0 150,10 155,0 160,10 165,0 170,10 175,0 180,10 185,0 190,10 195,0 200,10 205,0 210,10 215,0 220,10 225,0 230,10 235,0 240,10" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Right Column: Setup Instructions & Connection Details -->
        <div class="lg:col-span-7 space-y-4">
            <!-- Connection Mode Card -->
            <div class="bg-white dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-700 shadow-sm">
                <h5 class="text-sm font-semibold text-gray-900 dark:text-white mb-2 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    Panduan Koneksi Printer Thermal
                </h5>

                <div class="space-y-3 text-xs text-gray-600 dark:text-gray-300">
                    <!-- Bluetooth Guide -->
                    <div class="p-3 rounded-md bg-blue-50/70 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-900/50">
                        <div class="font-semibold text-blue-900 dark:text-blue-300 flex items-center gap-1.5 mb-1">
                            <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3l6 6-6 6V3zm0 18l6-6-6-6v12z" />
                            </svg>
                            1. Printer Bluetooth (Mobile POS / Tablet / HP Android)
                        </div>
                        <ul class="list-disc list-inside space-y-1 text-blue-800/90 dark:text-blue-200/90">
                            <li>Nyalakan printer Bluetooth dan pastikan roll kertas thermal 58mm/80mm terpasang.</li>
                            <li>Buka Bluetooth pada perangkat Anda (HP Android / iPad / Laptop) lalu sambungkan ke printer (PIN default biasanya <strong>0000</strong> atau <strong>1234</strong>).</li>
                            <li>Pilih metode <strong>Bluetooth Thermal POS</strong> atau <strong>Sistem Driver / Browser</strong> saat mencetak.</li>
                        </ul>
                    </div>

                    <!-- USB Guide -->
                    <div class="p-3 rounded-md bg-indigo-50/70 dark:bg-indigo-900/20 border border-indigo-100 dark:border-indigo-900/50">
                        <div class="font-semibold text-indigo-900 dark:text-indigo-300 flex items-center gap-1.5 mb-1">
                            <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            2. Printer USB (Kabel USB Kasir / OTG)
                        </div>
                        <ul class="list-disc list-inside space-y-1 text-indigo-800/90 dark:text-indigo-200/90">
                            <li>Tancapkan kabel USB printer ke komputer kasir atau tablet via USB OTG.</li>
                            <li>Pastikan driver printer (seperti POS-58, POS-80, Epson TM Series, atau driver generic ESC/POS) sudah terpasang di OS.</li>
                            <li>Pilih printer tersebut di dialog cetak browser sebagai printer utama.</li>
                        </ul>
                    </div>

                    <!-- LAN/WiFi Guide -->
                    <div class="p-3 rounded-md bg-emerald-50/70 dark:bg-emerald-900/20 border border-emerald-100 dark:border-emerald-900/50">
                        <div class="font-semibold text-emerald-900 dark:text-emerald-300 flex items-center gap-1.5 mb-1">
                            <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                            </svg>
                            3. Printer Jaringan LAN / WiFi (IP Address)
                        </div>
                        <ul class="list-disc list-inside space-y-1 text-emerald-800/90 dark:text-emerald-200/90">
                            <li>Printer terhubung ke router toko melalui kabel LAN RJ45 atau WiFi internal.</li>
                            <li>Masukkan IP Address statis printer (misal <code>192.168.1.200</code>) dan Port <code>9100</code> (RAW ESC/POS).</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Printer Hardware Settings Summary -->
            <div class="bg-white dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-700 shadow-sm">
                <h5 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">Ringkasan Konfigurasi Aktif</h5>
                <dl class="grid grid-cols-2 gap-3 text-xs">
                    <div class="p-2.5 rounded bg-gray-50 dark:bg-gray-900/50">
                        <dt class="text-gray-500 dark:text-gray-400">Jenis Sambungan:</dt>
                        <dd class="font-semibold text-gray-900 dark:text-white uppercase mt-0.5" x-text="connectionType || 'Browser'"></dd>
                    </div>
                    <div class="p-2.5 rounded bg-gray-50 dark:bg-gray-900/50">
                        <dt class="text-gray-500 dark:text-gray-400">Roll Kertas:</dt>
                        <dd class="font-semibold text-gray-900 dark:text-white mt-0.5" x-text="paperSize || '58mm'"></dd>
                    </div>
                    <div class="p-2.5 rounded bg-gray-50 dark:bg-gray-900/50">
                        <dt class="text-gray-500 dark:text-gray-400">Auto Cut:</dt>
                        <dd class="font-semibold mt-0.5" :class="autoCut ? 'text-emerald-600 dark:text-emerald-400' : 'text-gray-400'" x-text="autoCut ? 'Aktif' : 'Nonaktif'"></dd>
                    </div>
                    <div class="p-2.5 rounded bg-gray-50 dark:bg-gray-900/50">
                        <dt class="text-gray-500 dark:text-gray-400">Laci Kasir (RJ11):</dt>
                        <dd class="font-semibold mt-0.5" :class="cashDrawer ? 'text-emerald-600 dark:text-emerald-400' : 'text-gray-400'" x-text="cashDrawer ? 'Aktif' : 'Nonaktif'"></dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</div>
