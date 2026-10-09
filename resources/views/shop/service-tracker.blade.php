@extends('layouts.storefront')

@section('title', 'Service Tracker — Pantau Progres Servis PC KeeHub')
@section('meta_description', 'Lacak status perbaikan unit PC Anda secara real-time dengan Nomor Invoice, Kode Servis, atau Nomor WhatsApp di KeeHub.')

@section('content')
<div class="x-container py-8 sm:py-12">
    <!-- Header Hero -->
    <div class="mx-auto max-w-3xl text-center">
        <div class="inline-flex items-center gap-2 rounded-full border border-amber-500/30 bg-amber-500/10 px-3.5 py-1 text-xs font-semibold uppercase tracking-wider text-amber-600 dark:text-amber-400">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            Real-Time Service Tracker
        </div>
        <h1 class="mt-4 text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl dark:text-white">
            Pantau Progres Servis PC Anda
        </h1>
        <p class="mt-2 text-sm text-gray-600 sm:text-base dark:text-gray-400">
            Ketahui status pengerjaan, hasil diagnosa hardware, dan riwayat perbaikan perangkat PC Anda secara transparan.
        </p>

        <!-- Search Form -->
        <form method="GET" action="{{ route('service.index') }}" class="x-card mt-6 p-2 sm:p-2.5">
            <div class="flex flex-col gap-2 sm:flex-row">
                <div class="relative flex-1">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text"
                           name="q"
                           value="{{ $search }}"
                           required
                           placeholder="Masukkan Nomor Invoice, Kode Servis, atau No. WhatsApp (cth: INV-SVC..., 0812...)"
                           class="w-full rounded-xl border-0 bg-transparent py-3 pl-11 pr-4 text-sm text-gray-900 placeholder-gray-400 focus:ring-0 dark:text-white dark:placeholder-gray-500">
                </div>
                <button type="submit" class="x-btn-primary whitespace-nowrap !py-3">
                    Lacak Servis
                </button>
            </div>
        </form>

        <div class="mt-2 flex flex-wrap items-center justify-center gap-2 text-xs text-gray-500 dark:text-gray-400">
            <span>Contoh pencarian:</span>
            <span class="rounded bg-gray-100 px-2 py-0.5 font-mono text-gray-700 dark:bg-gray-800 dark:text-gray-300">SVC-202610-001</span>
            <span class="rounded bg-gray-100 px-2 py-0.5 font-mono text-gray-700 dark:bg-gray-800 dark:text-gray-300">INV-SVC-202610-001</span>
            <span class="rounded bg-gray-100 px-2 py-0.5 font-mono text-gray-700 dark:bg-gray-800 dark:text-gray-300">08123456789</span>
        </div>
    </div>

    <!-- Alert Success from intake -->
    @if (session('success'))
        <div class="mx-auto mt-6 max-w-3xl rounded-2xl border border-green-200 bg-green-50 p-4 text-sm text-green-800 dark:border-green-900/50 dark:bg-green-950/40 dark:text-green-300">
            <div class="flex items-start gap-3">
                <svg class="h-5 w-5 flex-shrink-0 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                <div class="flex-1">
                    <p class="font-medium">{{ session('success') }}</p>
                    @if (session('wa_link'))
                        <a href="{{ session('wa_link') }}" target="_blank" rel="noopener" class="mt-2 inline-flex items-center gap-1.5 font-bold text-green-700 hover:underline dark:text-green-400">
                            Konfirmasi Pesanan via WhatsApp →
                        </a>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <!-- Search Results / Selected Service Display -->
    @if ($searched)
        @if ($services->isEmpty())
            <div class="mx-auto mt-10 max-w-xl text-center">
                <div class="x-card p-8">
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-amber-100 text-amber-600 dark:bg-amber-950/50 dark:text-amber-400">
                        <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                    </div>
                    <h3 class="mt-4 text-lg font-bold text-gray-900 dark:text-white">Data Servis Tidak Ditemukan</h3>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        Tidak ditemukan catatan servis dengan kata kunci <strong>"{{ $search }}"</strong>. Pastikan Nomor Invoice, Kode Servis (format: SVC-...), atau Nomor HP sudah benar.
                    </p>
                    <div class="mt-6">
                        <a href="{{ route('service.index') }}" class="x-btn-outline text-xs">Reset Pencarian</a>
                    </div>
                </div>
            </div>
        @else
            <!-- Multi-result Switcher (if customer has multiple devices registered under phone number) -->
            @if ($services->count() > 1)
                <div class="mx-auto mt-8 max-w-4xl">
                    <p class="mb-2 text-xs font-semibold uppercase tracking-wider text-gray-500">
                        Ditemukan {{ $services->count() }} unit servis untuk pencarian ini. Pilih unit:
                    </p>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($services as $srv)
                            <a href="{{ route('service.index', ['q' => $search, 'code' => $srv->code]) }}"
                               class="rounded-xl px-3.5 py-2 text-xs font-medium transition {{ $selectedService?->id === $srv->id ? 'bg-kee-500 text-gray-950 font-bold shadow-sm' : 'bg-white text-gray-700 hover:bg-gray-100 dark:bg-gray-900 dark:text-gray-300 dark:hover:bg-gray-800' }}">
                                {{ $srv->code }} — {{ $srv->device_name ?: 'PC Unit' }}
                                <span class="ml-1 opacity-75">({{ ucfirst($srv->status) }})</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            @if ($selectedService)
                @php
                    $status = $selectedService->status;
                    // Map to 4 visual timeline steps:
                    // 1: Diterima (received)
                    // 2: Pengecekan & Diagnosa (checking, waiting_approval)
                    // 3: Proses Perbaikan & Testing (processing, testing)
                    // 4: Selesai / Siap Diambil (ready, completed)
                    $currentStep = match($status) {
                        'received' => 1,
                        'checking', 'waiting_approval' => 2,
                        'processing', 'testing' => 3,
                        'ready', 'completed' => 4,
                        'cancelled' => 0,
                        default => 1,
                    };
                @endphp

                <div class="mx-auto mt-8 max-w-4xl space-y-6">
                    <!-- Main Tracker Card -->
                    <div class="x-card overflow-hidden p-6 sm:p-8">
                        <!-- Top Info Bar -->
                        <div class="flex flex-wrap items-center justify-between gap-4 border-b border-gray-100 pb-6 dark:border-gray-800">
                            <div>
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Kode Servis</span>
                                    <span class="font-mono text-base font-extrabold text-kee-600 dark:text-kee-400">{{ $selectedService->code }}</span>
                                </div>
                                <h2 class="mt-1 text-xl font-bold text-gray-900 sm:text-2xl dark:text-white">
                                    {{ $selectedService->device_name ?: 'Unit PC Desktop' }}
                                </h2>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    Pemilik: <span class="font-semibold text-gray-800 dark:text-gray-200">{{ $selectedService->customer?->name }}</span>
                                    @if($selectedService->company_name)
                                        • <span class="text-blue-600 dark:text-blue-400">{{ $selectedService->company_name }}</span>
                                    @endif
                                </p>
                            </div>

                            <div class="text-right">
                                @if ($selectedService->invoice_number)
                                    <div class="text-xs text-gray-500 dark:text-gray-400">No. Invoice: <span class="font-mono font-bold text-gray-900 dark:text-gray-100">{{ $selectedService->invoice_number }}</span></div>
                                @endif
                                <div class="mt-1">
                                    @if ($status === 'cancelled')
                                        <span class="x-badge bg-red-100 text-red-700 dark:bg-red-950/50 dark:text-red-400">DIBATALKAN</span>
                                    @elseif ($status === 'completed' || $status === 'ready')
                                        <span class="x-badge bg-green-100 text-green-700 dark:bg-green-950/50 dark:text-green-400">SELESAI / SIAP DIAMBIL</span>
                                    @elseif ($status === 'processing' || $status === 'testing')
                                        <span class="x-badge bg-blue-100 text-blue-700 dark:bg-blue-950/50 dark:text-blue-400">SEDANG DIKERJAKAN</span>
                                    @elseif ($status === 'checking' || $status === 'waiting_approval')
                                        <span class="x-badge bg-amber-100 text-amber-700 dark:bg-amber-950/50 dark:text-amber-400">TAHAP DIAGNOSA</span>
                                    @else
                                        <span class="x-badge bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300">UNIT DITERIMA</span>
                                    @endif
                                </div>
                                <div class="mt-1 text-[11px] text-gray-400">
                                    Masuk: {{ $selectedService->created_at->format('d M Y, H:i') }}
                                </div>
                            </div>
                        </div>

                        <!-- Stepper Visual Timeline -->
                        @if ($status !== 'cancelled')
                            <div class="py-8">
                                <h3 class="mb-6 text-center text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500">
                                    Status Perjalanan Perbaikan
                                </h3>

                                <div class="relative">
                                    <!-- Progress Background Line -->
                                    <div class="absolute left-0 top-5 h-1 w-full bg-gray-200 dark:bg-gray-800"></div>
                                    <!-- Active Progress Bar -->
                                    <div class="absolute left-0 top-5 h-1 bg-kee-500 transition-all duration-500"
                                         style="width: {{ match($currentStep) { 1 => '12%', 2 => '38%', 3 => '70%', 4 => '100%', default => '0%' } }};"></div>

                                    <!-- 4 Step Nodes -->
                                    <div class="relative grid grid-cols-4 text-center">
                                        <!-- Step 1: Diterima -->
                                        <div class="flex flex-col items-center">
                                            <div class="flex h-10 w-10 items-center justify-center rounded-full border-2 transition {{ $currentStep >= 1 ? 'border-kee-500 bg-kee-500 text-gray-950 shadow-md ring-4 ring-kee-500/20' : 'border-gray-300 bg-white text-gray-400 dark:border-gray-700 dark:bg-gray-900' }}">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                            </div>
                                            <span class="mt-2.5 text-xs font-bold {{ $currentStep >= 1 ? 'text-gray-900 dark:text-white' : 'text-gray-400' }}">Diterima</span>
                                            <span class="hidden text-[10px] text-gray-500 sm:block">Unit di workshop</span>
                                        </div>

                                        <!-- Step 2: Pengecekan -->
                                        <div class="flex flex-col items-center">
                                            <div class="flex h-10 w-10 items-center justify-center rounded-full border-2 transition {{ $currentStep >= 2 ? 'border-kee-500 bg-kee-500 text-gray-950 shadow-md ring-4 ring-kee-500/20' : ($currentStep == 1 ? 'border-kee-500 bg-white text-kee-600 dark:bg-gray-900' : 'border-gray-300 bg-white text-gray-400 dark:border-gray-700 dark:bg-gray-900') }}">
                                                @if ($currentStep >= 2)
                                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                                @else
                                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                                                @endif
                                            </div>
                                            <span class="mt-2.5 text-xs font-bold {{ $currentStep >= 2 ? 'text-gray-900 dark:text-white' : 'text-gray-400' }}">Pengecekan</span>
                                            <span class="hidden text-[10px] text-gray-500 sm:block">Diagnosa hardware</span>
                                        </div>

                                        <!-- Step 3: Proses Perbaikan -->
                                        <div class="flex flex-col items-center">
                                            <div class="flex h-10 w-10 items-center justify-center rounded-full border-2 transition {{ $currentStep >= 3 ? 'border-kee-500 bg-kee-500 text-gray-950 shadow-md ring-4 ring-kee-500/20' : ($currentStep == 2 ? 'border-kee-500 bg-white text-kee-600 dark:bg-gray-900' : 'border-gray-300 bg-white text-gray-400 dark:border-gray-700 dark:bg-gray-900') }}">
                                                @if ($currentStep >= 3)
                                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                                @else
                                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                                @endif
                                            </div>
                                            <span class="mt-2.5 text-xs font-bold {{ $currentStep >= 3 ? 'text-gray-900 dark:text-white' : 'text-gray-400' }}">Perbaikan</span>
                                            <span class="hidden text-[10px] text-gray-500 sm:block">Ganti part & testing</span>
                                        </div>

                                        <!-- Step 4: Selesai -->
                                        <div class="flex flex-col items-center">
                                            <div class="flex h-10 w-10 items-center justify-center rounded-full border-2 transition {{ $currentStep >= 4 ? 'border-green-500 bg-green-500 text-white shadow-md ring-4 ring-green-500/20' : 'border-gray-300 bg-white text-gray-400 dark:border-gray-700 dark:bg-gray-900' }}">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            </div>
                                            <span class="mt-2.5 text-xs font-bold {{ $currentStep >= 4 ? 'text-green-600 dark:text-green-400' : 'text-gray-400' }}">Selesai</span>
                                            <span class="hidden text-[10px] text-gray-500 sm:block">Siap diambil / kirim</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="my-6 rounded-xl bg-red-50 p-4 text-center text-sm font-semibold text-red-700 dark:bg-red-950/40 dark:text-red-400">
                                Perbaikan untuk unit ini telah dibatalkan. Silakan hubungi CS jika ada pertanyaan.
                            </div>
                        @endif

                        <!-- Details Grid -->
                        <div class="mt-6 grid gap-6 md:grid-cols-2">
                            <!-- Left: Device & Specification -->
                            <div class="rounded-xl border border-gray-100 bg-gray-50/50 p-4 dark:border-gray-800 dark:bg-gray-900/50">
                                <h4 class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Informasi Unit & Pengerjaan</h4>
                                <dl class="mt-3 space-y-2 text-xs">
                                    <div class="flex justify-between">
                                        <dt class="text-gray-500">Tipe Layanan:</dt>
                                        <dd class="font-bold text-gray-800 dark:text-gray-200">{{ \App\Models\Service::TYPES[$selectedService->service_type] ?? $selectedService->service_type }}</dd>
                                    </div>
                                    @if ($selectedService->serial_number)
                                        <div class="flex justify-between">
                                            <dt class="text-gray-500">Serial / Asset Number:</dt>
                                            <dd class="font-mono font-medium text-gray-800 dark:text-gray-200">{{ $selectedService->serial_number }}</dd>
                                        </div>
                                    @endif
                                    @if ($selectedService->completeness)
                                        <div class="flex justify-between">
                                            <dt class="text-gray-500">Kelengkapan:</dt>
                                            <dd class="font-medium text-gray-800 dark:text-gray-200">{{ $selectedService->completeness }}</dd>
                                        </div>
                                    @endif
                                    <div class="flex justify-between">
                                        <dt class="text-gray-500">Teknisi Penanggung Jawab:</dt>
                                        <dd class="font-semibold text-gray-800 dark:text-gray-200">{{ $selectedService->technician?->name ?? 'Tim KeeHub' }}</dd>
                                    </div>
                                    @if ($selectedService->due_date)
                                        <div class="flex justify-between">
                                            <dt class="text-gray-500">Estimasi Selesai:</dt>
                                            <dd class="font-bold text-amber-600 dark:text-amber-400">{{ $selectedService->due_date->format('d M Y') }}</dd>
                                        </div>
                                    @endif
                                </dl>

                                @if ($selectedService->problem_description)
                                    <div class="mt-4 border-t border-gray-200/60 pt-3 dark:border-gray-800">
                                        <span class="text-[11px] font-bold text-gray-500 uppercase">Keluhan Awal:</span>
                                        <p class="mt-1 text-xs text-gray-700 dark:text-gray-300">{{ $selectedService->problem_description }}</p>
                                    </div>
                                @endif

                                @if ($selectedService->diagnosis)
                                    <div class="mt-3 border-t border-gray-200/60 pt-3 dark:border-gray-800">
                                        <span class="text-[11px] font-bold text-green-700 dark:text-green-400 uppercase">Hasil Diagnosa & Tindakan Teknisi:</span>
                                        <p class="mt-1 text-xs text-gray-700 dark:text-gray-300">{{ $selectedService->diagnosis }}</p>
                                    </div>
                                @endif
                            </div>

                            <!-- Right: Part & Service Items Breakdown -->
                            <div class="rounded-xl border border-gray-100 bg-gray-50/50 p-4 dark:border-gray-800 dark:bg-gray-900/50">
                                <h4 class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Rincian Komponen & Jasa</h4>

                                @if ($selectedService->items->isNotEmpty())
                                    <div class="mt-3 divide-y divide-gray-200/60 text-xs dark:divide-gray-800">
                                        @foreach ($selectedService->items as $item)
                                            <div class="flex items-center justify-between py-2">
                                                <div>
                                                    <div class="font-medium text-gray-800 dark:text-gray-200">
                                                        {{ $item->name }}
                                                        <span class="text-gray-400">×{{ $item->quantity }}</span>
                                                    </div>
                                                    <div class="flex items-center gap-2 mt-0.5">
                                                        @if ($item->item_type === 'labor')
                                                            <span class="text-[10px] text-gray-500">Jasa Servis</span>
                                                        @elseif ($item->part_source === 'vendor')
                                                            <span class="inline-block rounded bg-amber-100 px-1.5 py-0.2 text-[10px] font-semibold text-amber-800 dark:bg-amber-950/50 dark:text-amber-400">Dari Vendor (Garansi)</span>
                                                        @else
                                                            <span class="inline-block rounded bg-blue-100 px-1.5 py-0.2 text-[10px] font-semibold text-blue-800 dark:bg-blue-950/50 dark:text-blue-400">Dari KeeHub</span>
                                                        @endif
                                                        @if ($item->warranty_info)
                                                            <span class="text-[10px] text-gray-400">• Garansi: {{ $item->warranty_info }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="mt-4 text-center text-xs text-gray-400">
                                        Komponen suku cadang atau rincian jasa sedang dalam tahap pengecekan oleh teknisi.
                                    </p>
                                @endif

                                <!-- Direct WA Contact -->
                                @php
                                    $inquiryText = "Halo KeeHub, saya ingin menanyakan perkembangan servis unit PC saya dengan Kode Servis: {$selectedService->code}.";
                                    $waTrackLink = \App\Services\WhatsAppService::link($inquiryText);
                                @endphp
                                @if ($waTrackLink)
                                    <div class="mt-6 border-t border-gray-200/60 pt-4 dark:border-gray-800">
                                        <a href="{{ $waTrackLink }}" target="_blank" rel="noopener" class="x-btn-dark w-full !py-2 text-xs">
                                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                            Hubungi Teknisi via WhatsApp
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Checkpoint Real-time History Log -->
                        @if ($selectedService->statusHistory->isNotEmpty())
                            <div class="mt-8 border-t border-gray-100 pt-6 dark:border-gray-800">
                                <h4 class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                    Riwayat Pembaruan Status (Audit Log)
                                </h4>
                                <div class="mt-4 space-y-4">
                                    @foreach ($selectedService->statusHistory as $hist)
                                        <div class="flex items-start gap-3">
                                            <div class="flex h-6 w-6 flex-shrink-0 items-center justify-center rounded-full bg-kee-500/10 text-kee-600 dark:text-kee-400">
                                                <svg class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/></svg>
                                            </div>
                                            <div class="flex-1 text-xs">
                                                <div class="flex items-center gap-2">
                                                    <span class="font-bold text-gray-900 uppercase dark:text-white">{{ str_replace('_', ' ', $hist->to_status) }}</span>
                                                    <span class="text-gray-400">• {{ $hist->created_at->format('d M Y, H:i') }}</span>
                                                </div>
                                                @if ($hist->notes)
                                                    <p class="mt-0.5 text-gray-600 dark:text-gray-400">{{ $hist->notes }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        @endif
    @endif

    <!-- Section Permohonan Servis Baru (Form Intake) -->
    <div class="mx-auto mt-14 max-w-2xl" x-data="{ openForm: false }">
        <div class="text-center">
            <button @click="openForm = !openForm" type="button" class="x-btn-outline inline-flex items-center gap-2 !py-2.5 text-sm">
                <svg class="h-4 w-4 text-kee-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                <span x-text="openForm ? 'Tutup Formulir Request Servis' : 'Ingin Memperbaiki PC Baru? Ajukan Servis di Sini'"></span>
            </button>
        </div>

        <div x-show="openForm" x-cloak class="x-card mt-6 p-6 sm:p-8">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Formulir Pengajuan Servis PC</h3>
            <p class="mt-1 text-xs text-gray-500">Isi keluhan PC Anda. Tim teknisi KeeHub akan menghubungi untuk estimasi pengerjaan.</p>

            <form method="POST" action="{{ route('service.store') }}" class="mt-5 space-y-4">
                @csrf
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1 block text-xs font-semibold">Nama Lengkap *</label>
                        <input type="text" name="name" value="{{ old('name', auth()->user()?->name) }}" required class="x-input text-sm" placeholder="Nama Anda">
                    </div>
                    <div>
                        <label class="mb-1 block text-xs font-semibold">Nama Perusahaan (B2B) <span class="font-normal text-gray-400">(opsional)</span></label>
                        <input type="text" name="company_name" value="{{ old('company_name') }}" class="x-input text-sm" placeholder="PT / Kantor">
                    </div>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1 block text-xs font-semibold">No. WhatsApp *</label>
                        <input type="text" name="whatsapp" value="{{ old('whatsapp') }}" required class="x-input text-sm" placeholder="08xxxxxxxxxx">
                    </div>
                    <div>
                        <label class="mb-1 block text-xs font-semibold">Model / Tipe PC *</label>
                        <input type="text" name="device_name" value="{{ old('device_name') }}" required class="x-input text-sm" placeholder="Contoh: PC Rakitan Gaming / Dell OptiPlex">
                    </div>
                </div>

                <div>
                    <label class="mb-1 block text-xs font-semibold">Jenis Masalah / Layanan *</label>
                    <select name="service_type" required class="x-input text-sm">
                        <option value="">— Pilih Jenis Servis —</option>
                        @foreach ($serviceTypes as $key => $label)
                            <option value="{{ $key }}" @selected(old('service_type') === $key)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="mb-1 block text-xs font-semibold">Deskripsi Kendala *</label>
                    <textarea name="problem_description" rows="3" required class="x-input text-sm" placeholder="Jelaskan kendala: bluescreen, tidak mau nyala, kipas berisik, dsb.">{{ old('problem_description') }}</textarea>
                </div>

                <div>
                    <label class="mb-1 block text-xs font-semibold">Komponen Bawaan Klien <span class="font-normal text-gray-400">(opsional)</span></label>
                    <textarea name="owned_components" rows="2" class="x-input text-sm" placeholder="Contoh: VGA bawaan sendiri, SSD bawaan sendiri"></textarea>
                </div>

                <button type="submit" class="x-btn-primary w-full !py-3 font-bold">Kirim Permohonan Servis</button>
            </form>
        </div>
    </div>
</div>
@endsection
