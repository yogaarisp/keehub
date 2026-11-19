@extends('layouts.storefront')

@section('title', 'Service Tracker & Request — Layanan Servis PC KeeHub')
@section('meta_description', 'Lacak status perbaikan unit PC Anda secara real-time atau ajukan servis baru dengan mudah di KeeHub.')

@section('content')
<div class="x-container py-8 sm:py-12" x-data="{ activeTab: '{{ $activeTab }}' }">
    <!-- Header Hero -->
    <div class="mx-auto max-w-3xl text-center">
        <div class="inline-flex items-center gap-2 rounded-full border border-amber-500/30 bg-amber-500/10 px-3.5 py-1 text-xs font-semibold uppercase tracking-wider text-amber-600 dark:text-amber-400">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085" /></svg>
            Service Tracker & Care Center
        </div>

        <template x-if="activeTab === 'request'">
            <div>
                <h1 class="mt-4 text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl dark:text-slate-100">
                    Ajukan Servis & Perbaikan PC
                </h1>
                <p class="mt-2 text-sm text-slate-600 sm:text-base dark:text-slate-400">
                    Konsultasikan kendala PC atau laptop Anda langsung ke tim teknisi profesional KeeHub. Cepat, transparan, dan bergaransi.
                </p>
            </div>
        </template>

        <template x-if="activeTab === 'track'">
            <div>
                <h1 class="mt-4 text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl dark:text-slate-100">
                    Pantau Progres Servis PC Anda
                </h1>
                <p class="mt-2 text-sm text-slate-600 sm:text-base dark:text-slate-400">
                    Lacak status pengerjaan, hasil diagnosa hardware, dan rincian servis perangkat Anda secara transparan.
                </p>
            </div>
        </template>

        <!-- Segmented Tab Switcher -->
        <div class="mt-6 flex justify-center">
            <div class="inline-flex w-full max-w-md rounded-2xl border border-slate-200/80 bg-slate-100/90 p-1.5 backdrop-blur-sm sm:w-auto dark:border-slate-800 dark:bg-slate-900/90">
                <button type="button"
                        @click="activeTab = 'request'"
                        :class="activeTab === 'request'
                            ? 'bg-white text-amber-600 font-bold shadow-sm dark:bg-slate-800 dark:text-amber-400'
                            : 'text-slate-600 hover:text-slate-900 dark:text-slate-400 dark:hover:text-slate-200 font-medium'"
                        class="flex flex-1 sm:flex-initial items-center justify-center gap-2 rounded-xl px-4 sm:px-6 py-2.5 text-xs sm:text-sm transition-all duration-150">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    <span>Ajukan Servis Baru</span>
                </button>
                <button type="button"
                        @click="activeTab = 'track'"
                        :class="activeTab === 'track'
                            ? 'bg-white text-amber-600 font-bold shadow-sm dark:bg-slate-800 dark:text-amber-400'
                            : 'text-slate-600 hover:text-slate-900 dark:text-slate-400 dark:hover:text-slate-200 font-medium'"
                        class="flex flex-1 sm:flex-initial items-center justify-center gap-2 rounded-xl px-4 sm:px-6 py-2.5 text-xs sm:text-sm transition-all duration-150">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                    <span>Lacak Status Servis</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Alert Success Notification -->
    @if (session('success'))
        <div class="mx-auto mt-6 max-w-3xl rounded-2xl border border-emerald-200 bg-emerald-50/90 p-4 text-sm text-emerald-800 shadow-sm dark:border-emerald-900/50 dark:bg-emerald-950/40 dark:text-emerald-300">
            <div class="flex items-start gap-3">
                <svg class="h-5 w-5 flex-shrink-0 text-emerald-600 dark:text-emerald-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                <div class="flex-1">
                    <p class="font-medium">{{ session('success') }}</p>
                    @if (session('wa_link'))
                        <a href="{{ session('wa_link') }}" target="_blank" rel="noopener" class="mt-2 inline-flex items-center gap-1.5 font-bold text-emerald-700 hover:underline dark:text-emerald-400">
                            Konfirmasi Tiket via WhatsApp →
                        </a>
                    @endif
                </div>
            </div>
        </div>
    @endif

    {{-- TAB 1: FORM PENGAJUAN SERVIS BARU --}}
    <div x-show="activeTab === 'request'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="mt-8">
        <!-- Trust Cards Row -->
        <div class="mx-auto grid max-w-4xl grid-cols-1 gap-3 sm:grid-cols-3">
            <div class="flex items-center gap-3 rounded-2xl border border-slate-200/70 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900/70">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-amber-500/10 text-amber-600 dark:text-amber-400">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                </div>
                <div>
                    <h4 class="text-xs font-bold text-slate-800 dark:text-slate-100">Garansi & Part Asli</h4>
                    <p class="text-[11px] text-slate-500 dark:text-slate-400">Jaminan sparepart original dan garansi pengerjaan.</p>
                </div>
            </div>

            <div class="flex items-center gap-3 rounded-2xl border border-slate-200/70 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900/70">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-500/10 text-blue-600 dark:text-blue-400">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <h4 class="text-xs font-bold text-slate-800 dark:text-slate-100">Diagnosa Transparan</h4>
                    <p class="text-[11px] text-slate-500 dark:text-slate-400">Konfirmasi biaya sebelum part diganti, tanpa jebakan.</p>
                </div>
            </div>

            <div class="flex items-center gap-3 rounded-2xl border border-slate-200/70 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900/70">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z"/></svg>
                </div>
                <div>
                    <h4 class="text-xs font-bold text-slate-800 dark:text-slate-100">Update via WhatsApp</h4>
                    <p class="text-[11px] text-slate-500 dark:text-slate-400">Progres dicek & dikabarkan langsung ke HP Anda.</p>
                </div>
            </div>
        </div>

        <!-- Request Form Card -->
        <div class="mx-auto mt-6 max-w-2xl">
            <div class="x-card p-6 sm:p-8">
                <div class="border-b border-slate-100 pb-4 dark:border-slate-800">
                    <h3 class="text-lg font-bold text-slate-900 sm:text-xl dark:text-white">Formulir Pengajuan Servis PC & Laptop</h3>
                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Lengkapi data perangkat dan keluhan Anda di bawah ini.</p>
                </div>

                <form method="POST" action="{{ route('service.store') }}" class="mt-6 space-y-4 sm:space-y-5">
                    @csrf

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="mb-1.5 block text-xs font-semibold text-slate-700 dark:text-slate-200">
                                Nama Lengkap <span class="text-rose-500">*</span>
                            </label>
                            <input type="text"
                                   name="name"
                                   value="{{ old('name', auth()->user()?->name) }}"
                                   required
                                   class="x-input text-sm !py-2.5"
                                   placeholder="Contoh: Budi Santoso">
                        </div>

                        <div>
                            <label class="mb-1.5 block text-xs font-semibold text-slate-700 dark:text-slate-200">
                                No. WhatsApp Aktif <span class="text-rose-500">*</span>
                            </label>
                            <input type="tel"
                                   name="whatsapp"
                                   value="{{ old('whatsapp', auth()->user()?->phone) }}"
                                   required
                                   class="x-input text-sm !py-2.5"
                                   placeholder="Contoh: 081234567890">
                        </div>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="mb-1.5 block text-xs font-semibold text-slate-700 dark:text-slate-200">
                                Model / Tipe Perangkat <span class="text-rose-500">*</span>
                            </label>
                            <input type="text"
                                   name="device_name"
                                   value="{{ old('device_name') }}"
                                   required
                                   class="x-input text-sm !py-2.5"
                                   placeholder="Contoh: PC Rakitan Gaming / Laptop Asus TUF">
                        </div>

                        <div>
                            <label class="mb-1.5 block text-xs font-semibold text-slate-700 dark:text-slate-200">
                                Jenis Layanan Servis <span class="text-rose-500">*</span>
                            </label>
                            <select name="service_type" required class="x-input text-sm !py-2.5">
                                <option value="">— Pilih Kategori Masalah —</option>
                                @foreach ($serviceTypes as $key => $label)
                                    <option value="{{ $key }}" @selected(old('service_type', 'troubleshooting') === $key)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="mb-1.5 block text-xs font-semibold text-slate-700 dark:text-slate-200">
                            Perusahaan / Instansi B2B <span class="text-[11px] font-normal text-slate-400">(Opsional jika untuk kantor)</span>
                        </label>
                        <input type="text"
                               name="company_name"
                               value="{{ old('company_name') }}"
                               class="x-input text-sm !py-2.5"
                               placeholder="Contoh: PT Solusi Pratama / Kantor Dinas BPS">
                    </div>

                    <div>
                        <label class="mb-1.5 block text-xs font-semibold text-slate-700 dark:text-slate-200">
                            Keluhan / Gejala Kerusakan <span class="text-rose-500">*</span>
                        </label>
                        <textarea name="problem_description"
                                  rows="3"
                                  required
                                  class="x-input text-sm"
                                  placeholder="Jelaskan kendala: sering mati mendadak saat buka game, layar bluescreen, bunyi beep, tidak tampil display, dsb.">{{ old('problem_description') }}</textarea>
                    </div>

                    <div>
                        <label class="mb-1.5 block text-xs font-semibold text-slate-700 dark:text-slate-200">
                            Kelengkapan / Komponen Bawaan <span class="text-[11px] font-normal text-slate-400">(Opsional)</span>
                        </label>
                        <textarea name="owned_components"
                                  rows="2"
                                  class="x-input text-sm"
                                  placeholder="Contoh: Unit PC + Kabel Power + Adaptor, atau SSD & VGA bawaan sendiri"></textarea>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="x-btn-primary w-full !py-3.5 text-sm sm:text-base font-bold shadow-lg shadow-amber-600/20 active:scale-[0.99] transition">
                            Kirim Permohonan Servis Sekarang
                        </button>
                        <p class="mt-2 text-center text-[11px] text-slate-500 dark:text-slate-400">
                            🔒 Data Anda aman. Tim teknisi KeeHub akan menghubungi via WhatsApp untuk konfirmasi penerimaan unit.
                        </p>
                    </div>
                </form>
            </div>

            <!-- Switch to track ticket footer link -->
            <div class="mt-6 text-center text-xs text-slate-500 dark:text-slate-400">
                Sudah memiliki tiket servis?
                <button type="button" @click="activeTab = 'track'" class="font-bold text-amber-600 hover:underline dark:text-amber-400">
                    Lacak Status Servis di Sini →
                </button>
            </div>
        </div>
    </div>

    {{-- TAB 2: LACAK STATUS SERVIS (TRACKER) --}}
    <div x-show="activeTab === 'track'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="mt-8">
        <!-- Search Form Card -->
        <div class="mx-auto max-w-3xl">
            <form method="GET" action="{{ route('service.index') }}" class="x-card p-2 sm:p-2.5 shadow-sm">
                <input type="hidden" name="tab" value="track">
                <div class="flex flex-col gap-2 sm:flex-row">
                    <div class="relative flex-1">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text"
                               name="q"
                               value="{{ $search }}"
                               required
                               placeholder="Masukkan Nomor Invoice, Kode Servis, atau No. WhatsApp..."
                               class="w-full rounded-xl border-0 bg-transparent py-3 pl-11 pr-4 text-sm text-slate-900 placeholder-slate-400 focus:ring-0 dark:text-white dark:placeholder-slate-500">
                    </div>
                    <button type="submit" class="x-btn-primary whitespace-nowrap !py-3">
                        Lacak Servis
                    </button>
                </div>
            </form>

            <div class="mt-2 flex flex-wrap items-center justify-center gap-2 text-xs text-slate-500 dark:text-slate-400">
                <span>Contoh:</span>
                <span class="rounded bg-slate-100 px-2 py-0.5 font-mono text-slate-700 dark:bg-slate-800 dark:text-slate-300">SVC-202610-001</span>
                <span class="rounded bg-slate-100 px-2 py-0.5 font-mono text-slate-700 dark:bg-slate-800 dark:text-slate-300">INV-SVC-202610-001</span>
                <span class="rounded bg-slate-100 px-2 py-0.5 font-mono text-slate-700 dark:bg-slate-800 dark:text-slate-300">08123456789</span>
            </div>
        </div>

        <!-- Search Results Display -->
        @if ($searched)
            @if ($services->isEmpty())
                <div class="mx-auto mt-10 max-w-xl text-center">
                    <div class="x-card p-8">
                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-amber-500/10 text-amber-600 dark:text-amber-400">
                            <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                        </div>
                        <h3 class="mt-4 text-lg font-bold text-slate-900 dark:text-white">Data Servis Tidak Ditemukan</h3>
                        <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
                            Tidak ditemukan tiket servis dengan kata kunci <strong>"{{ $search }}"</strong>. Pastikan Nomor Invoice, Kode Servis (format: SVC-...), atau Nomor HP sudah benar.
                        </p>
                        <div class="mt-6 flex flex-wrap justify-center gap-3">
                            <a href="{{ route('service.index', ['tab' => 'track']) }}" class="x-btn-outline text-xs">Reset Pencarian</a>
                            <button type="button" @click="activeTab = 'request'" class="x-btn-primary text-xs">Ajukan Servis Baru</button>
                        </div>
                    </div>
                </div>
            @else
                <!-- Multi-result Switcher (if customer has multiple tickets) -->
                @if ($services->count() > 1)
                    <div class="mx-auto mt-8 max-w-4xl">
                        <p class="mb-2 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                            Ditemukan {{ $services->count() }} unit servis untuk pencarian ini. Pilih unit:
                        </p>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($services as $srv)
                                <a href="{{ route('service.index', ['q' => $search, 'code' => $srv->code, 'tab' => 'track']) }}"
                                   class="rounded-xl px-3.5 py-2 text-xs font-medium transition {{ $selectedService?->id === $srv->id ? 'bg-amber-600 text-white font-semibold shadow-sm' : 'bg-white text-slate-700 hover:bg-slate-100 dark:bg-slate-900 dark:text-slate-300 dark:hover:bg-slate-800 border border-slate-200/70 dark:border-slate-800' }}">
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
                        <div class="x-card overflow-hidden p-5 sm:p-8">
                            <!-- Top Info Bar -->
                            <div class="flex flex-wrap items-start justify-between gap-4 border-b border-slate-100 pb-6 dark:border-slate-800">
                                <div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Kode Servis</span>
                                        <span class="font-mono text-base font-extrabold text-amber-600 dark:text-amber-400">{{ $selectedService->code }}</span>
                                    </div>
                                    <h2 class="mt-1 text-xl font-bold text-slate-900 sm:text-2xl dark:text-white">
                                        {{ $selectedService->device_name ?: 'Unit PC Desktop' }}
                                    </h2>
                                    <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400">
                                        Pemilik: <span class="font-semibold text-slate-800 dark:text-slate-200">{{ $selectedService->customer?->name }}</span>
                                        @if($selectedService->company_name)
                                            • <span class="text-blue-600 dark:text-blue-400">{{ $selectedService->company_name }}</span>
                                        @endif
                                    </p>
                                </div>

                                <div class="text-left sm:text-right">
                                    @if ($selectedService->invoice_number)
                                        <div class="text-xs text-slate-500 dark:text-slate-400">
                                            No. Invoice: <span class="font-mono font-bold text-slate-900 dark:text-slate-100">{{ $selectedService->invoice_number }}</span>
                                        </div>
                                    @endif
                                    <div class="mt-1.5">
                                        @if ($status === 'cancelled')
                                            <span class="x-badge bg-rose-100 text-rose-700 dark:bg-rose-950/50 dark:text-rose-400">DIBATALKAN</span>
                                        @elseif ($status === 'completed' || $status === 'ready')
                                            <span class="x-badge bg-emerald-100 text-emerald-700 dark:bg-emerald-950/50 dark:text-emerald-400">SELESAI / SIAP DIAMBIL</span>
                                        @elseif ($status === 'processing' || $status === 'testing')
                                            <span class="x-badge bg-blue-100 text-blue-700 dark:bg-blue-950/50 dark:text-blue-400">SEDANG DIKERJAKAN</span>
                                        @elseif ($status === 'checking' || $status === 'waiting_approval')
                                            <span class="x-badge bg-amber-100 text-amber-700 dark:bg-amber-950/50 dark:text-amber-400">TAHAP DIAGNOSA</span>
                                        @else
                                            <span class="x-badge bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300">UNIT DITERIMA</span>
                                        @endif
                                    </div>
                                    <div class="mt-1 text-[11px] text-slate-400">
                                        Masuk: {{ $selectedService->created_at->format('d M Y, H:i') }}
                                    </div>
                                    @if ($selectedService->invoice_number || $selectedService->total_cost > 0)
                                        <div class="mt-2">
                                            <a href="{{ route('service.public.invoice.pdf', $selectedService) }}" target="_blank" rel="noopener" class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-2.5 py-1 text-[11px] font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 hover:text-slate-900 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700">
                                                <svg class="h-3.5 w-3.5 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                                                <span>Unduh Invoice (PDF)</span>
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Stepper Visual Timeline -->
                            @if ($status !== 'cancelled')
                                <div class="py-6 sm:py-8">
                                    <h3 class="mb-5 text-center text-xs font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                                        Tahapan Pengerjaan Unit
                                    </h3>

                                    <div class="relative">
                                        <!-- Progress Background Line -->
                                        <div class="absolute left-0 top-5 h-1 w-full bg-slate-200 dark:bg-slate-800"></div>
                                        <!-- Active Progress Bar -->
                                        <div class="absolute left-0 top-5 h-1 bg-amber-500 transition-all duration-500"
                                             style="width: {{ match($currentStep) { 1 => '12%', 2 => '38%', 3 => '70%', 4 => '100%', default => '0%' } }};"></div>

                                        <!-- 4 Step Nodes -->
                                        <div class="relative grid grid-cols-4 text-center">
                                            <!-- Step 1: Diterima -->
                                            <div class="flex flex-col items-center">
                                                <div class="flex h-9 w-9 sm:h-10 sm:w-10 items-center justify-center rounded-full border-2 transition {{ $currentStep >= 1 ? 'border-amber-600 bg-amber-600 text-white shadow-md ring-4 ring-amber-500/20' : 'border-slate-300 bg-white text-slate-400 dark:border-slate-700 dark:bg-slate-900' }}">
                                                    <svg class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                                </div>
                                                <span class="mt-2 text-[11px] sm:text-xs font-semibold {{ $currentStep >= 1 ? 'text-slate-900 dark:text-slate-100' : 'text-slate-400' }}">Diterima</span>
                                                <span class="hidden text-[10px] text-slate-500 sm:block">Workshop</span>
                                            </div>

                                            <!-- Step 2: Pengecekan -->
                                            <div class="flex flex-col items-center">
                                                <div class="flex h-9 w-9 sm:h-10 sm:w-10 items-center justify-center rounded-full border-2 transition {{ $currentStep >= 2 ? 'border-amber-600 bg-amber-600 text-white shadow-md ring-4 ring-amber-500/20' : ($currentStep == 1 ? 'border-amber-500 bg-white text-amber-600 dark:bg-slate-900 dark:text-amber-400' : 'border-slate-300 bg-white text-slate-400 dark:border-slate-700 dark:bg-slate-900') }}">
                                                    @if ($currentStep >= 2)
                                                        <svg class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                                    @else
                                                        <svg class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                                                    @endif
                                                </div>
                                                <span class="mt-2 text-[11px] sm:text-xs font-semibold {{ $currentStep >= 2 ? 'text-slate-900 dark:text-slate-100' : 'text-slate-400' }}">Diagnosa</span>
                                                <span class="hidden text-[10px] text-slate-500 sm:block">Pemeriksaan</span>
                                            </div>

                                            <!-- Step 3: Proses Perbaikan -->
                                            <div class="flex flex-col items-center">
                                                <div class="flex h-9 w-9 sm:h-10 sm:w-10 items-center justify-center rounded-full border-2 transition {{ $currentStep >= 3 ? 'border-amber-600 bg-amber-600 text-white shadow-md ring-4 ring-amber-500/20' : ($currentStep == 2 ? 'border-amber-500 bg-white text-amber-600 dark:bg-slate-900 dark:text-amber-400' : 'border-slate-300 bg-white text-slate-400 dark:border-slate-700 dark:bg-slate-900') }}">
                                                    @if ($currentStep >= 3)
                                                        <svg class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                                    @else
                                                        <svg class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                                    @endif
                                                </div>
                                                <span class="mt-2 text-[11px] sm:text-xs font-semibold {{ $currentStep >= 3 ? 'text-slate-900 dark:text-slate-100' : 'text-slate-400' }}">Perbaikan</span>
                                                <span class="hidden text-[10px] text-slate-500 sm:block">Part & QC</span>
                                            </div>

                                            <!-- Step 4: Selesai -->
                                            <div class="flex flex-col items-center">
                                                <div class="flex h-9 w-9 sm:h-10 sm:w-10 items-center justify-center rounded-full border-2 transition {{ $currentStep >= 4 ? 'border-emerald-600 bg-emerald-600 text-white shadow-md ring-4 ring-emerald-500/20' : 'border-slate-300 bg-white text-slate-400 dark:border-slate-700 dark:bg-slate-900' }}">
                                                    <svg class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                </div>
                                                <span class="mt-2 text-[11px] sm:text-xs font-semibold {{ $currentStep >= 4 ? 'text-emerald-600 dark:text-emerald-400' : 'text-slate-400' }}">Selesai</span>
                                                <span class="hidden text-[10px] text-slate-500 sm:block">Siap Ambil</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="my-6 rounded-xl bg-rose-50 p-4 text-center text-sm font-semibold text-rose-700 dark:bg-rose-950/40 dark:text-rose-400">
                                    Perbaikan untuk unit ini telah dibatalkan. Silakan hubungi CS KeeHub jika ada pertanyaan.
                                </div>
                            @endif

                            <!-- Details Grid -->
                            <div class="mt-6 grid gap-6 md:grid-cols-2">
                                <!-- Left: Device & Specification -->
                                <div class="rounded-2xl border border-slate-200/70 bg-slate-50/60 p-4 sm:p-5 dark:border-slate-800 dark:bg-slate-900/60">
                                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Informasi Unit & Pengerjaan</h4>
                                    <dl class="mt-3 space-y-2.5 text-xs">
                                        <div class="flex justify-between gap-2">
                                            <dt class="text-slate-500">Tipe Layanan:</dt>
                                            <dd class="font-bold text-slate-800 dark:text-slate-200">{{ \App\Models\Service::TYPES[$selectedService->service_type] ?? $selectedService->service_type }}</dd>
                                        </div>
                                        @if ($selectedService->serial_number)
                                            <div class="flex justify-between gap-2">
                                                <dt class="text-slate-500">No. Serial / Asset:</dt>
                                                <dd class="font-mono font-medium text-slate-800 dark:text-slate-200">{{ $selectedService->serial_number }}</dd>
                                            </div>
                                        @endif
                                        @if ($selectedService->completeness)
                                            <div class="flex justify-between gap-2">
                                                <dt class="text-slate-500">Kelengkapan Unit:</dt>
                                                <dd class="font-medium text-slate-800 dark:text-slate-200">{{ $selectedService->completeness }}</dd>
                                            </div>
                                        @endif
                                        <div class="flex justify-between gap-2">
                                            <dt class="text-slate-500">Teknisi PIC:</dt>
                                            <dd class="font-semibold text-slate-800 dark:text-slate-200">{{ $selectedService->technician?->name ?? 'Tim Teknisi KeeHub' }}</dd>
                                        </div>
                                        @if ($selectedService->due_date)
                                            <div class="flex justify-between gap-2">
                                                <dt class="text-slate-500">Estimasi Selesai:</dt>
                                                <dd class="font-bold text-amber-600 dark:text-amber-400">{{ $selectedService->due_date->format('d M Y') }}</dd>
                                            </div>
                                        @endif
                                    </dl>

                                    @if ($selectedService->problem_description)
                                        <div class="mt-4 border-t border-slate-200/60 pt-3 dark:border-slate-800">
                                            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Keluhan Awal Klien:</span>
                                            <p class="mt-1 text-xs text-slate-700 leading-relaxed dark:text-slate-300">{{ $selectedService->problem_description }}</p>
                                        </div>
                                    @endif

                                    @if ($selectedService->diagnosis)
                                        <div class="mt-3 border-t border-slate-200/60 pt-3 dark:border-slate-800">
                                            <span class="text-[11px] font-bold uppercase tracking-wider text-emerald-600 dark:text-emerald-400">Hasil Diagnosa & Tindakan:</span>
                                            <p class="mt-1 text-xs text-slate-700 leading-relaxed dark:text-slate-300">{{ $selectedService->diagnosis }}</p>
                                        </div>
                                    @endif
                                </div>

                                <!-- Right: Part & Service Items Breakdown -->
                                <div class="rounded-2xl border border-slate-200/70 bg-slate-50/60 p-4 sm:p-5 dark:border-slate-800 dark:bg-slate-900/60">
                                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Rincian Komponen & Jasa</h4>

                                    @if ($selectedService->items->isNotEmpty())
                                        <div class="mt-3 divide-y divide-slate-200/60 text-xs dark:divide-slate-800">
                                            @foreach ($selectedService->items as $item)
                                                <div class="flex items-center justify-between py-2.5">
                                                    <div>
                                                        <div class="font-medium text-slate-800 dark:text-slate-200">
                                                            {{ $item->name }}
                                                            <span class="text-slate-400">×{{ $item->quantity }}</span>
                                                        </div>
                                                        <div class="mt-0.5 flex flex-wrap items-center gap-1.5">
                                                            @if ($item->item_type === 'labor')
                                                                <span class="inline-block rounded bg-slate-100 px-1.5 py-0.5 text-[10px] font-medium text-slate-600 dark:bg-slate-800 dark:text-slate-300">Jasa Servis</span>
                                                            @elseif ($item->part_source === 'vendor')
                                                                <span class="inline-block rounded bg-amber-100 px-1.5 py-0.5 text-[10px] font-semibold text-amber-800 dark:bg-amber-950/50 dark:text-amber-400">
                                                                    {{ ! (bool) $item->bill_to_client ? 'Vendor (Garansi / Non-Tagihan)' : 'Dari Vendor' }}
                                                                </span>
                                                            @else
                                                                <span class="inline-block rounded bg-blue-100 px-1.5 py-0.5 text-[10px] font-semibold text-blue-800 dark:bg-blue-950/50 dark:text-blue-400">Dari KeeHub</span>
                                                            @endif
                                                            @if ($item->warranty_info)
                                                                <span class="text-[10px] text-slate-400">• Garansi: {{ $item->warranty_info }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="text-right">
                                                        <div class="font-semibold text-slate-800 dark:text-slate-200">
                                                            @if (! (bool) $item->bill_to_client)
                                                                <span class="text-slate-400 italic font-normal">Rp 0 (Garansi)</span>
                                                            @else
                                                                Rp {{ number_format($item->total, 0, ',', '.') }}
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="mt-4 border-t border-slate-200/80 pt-3 dark:border-slate-800 flex justify-between items-center text-xs">
                                            <span class="font-bold text-slate-700 dark:text-slate-300">Estimasi / Total Tagihan:</span>
                                            <span class="text-sm font-extrabold text-emerald-600 dark:text-emerald-400">
                                                Rp {{ number_format($selectedService->invoiceTotal(), 0, ',', '.') }}
                                            </span>
                                        </div>
                                    @else
                                        <p class="mt-4 text-center text-xs text-slate-400 py-6">
                                            Komponen suku cadang atau rincian jasa sedang dalam tahap pengecekan oleh teknisi.
                                        </p>
                                    @endif

                                    <!-- Direct WA Contact -->
                                    @php
                                        $inquiryText = "Halo KeeHub, saya ingin menanyakan perkembangan servis unit PC saya dengan Kode Servis: {$selectedService->code}.";
                                        $waTrackLink = \App\Services\WhatsAppService::link($inquiryText);
                                    @endphp
                                    @if ($waTrackLink)
                                        <div class="mt-5 border-t border-slate-200/60 pt-4 dark:border-slate-800">
                                            <a href="{{ $waTrackLink }}" target="_blank" rel="noopener" class="x-btn-dark w-full !py-2.5 text-xs font-semibold">
                                                <svg class="h-4 w-4 text-emerald-400" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                                <span>Hubungi Teknisi via WhatsApp</span>
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Checkpoint Real-time History Log -->
                            @if ($selectedService->statusHistory->isNotEmpty())
                                <div class="mt-8 border-t border-slate-100 pt-6 dark:border-slate-800">
                                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                        Riwayat Status Perbaikan (Audit Log)
                                    </h4>
                                    <div class="mt-4 space-y-3.5">
                                        @foreach ($selectedService->statusHistory as $hist)
                                            <div class="flex items-start gap-3">
                                                <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-amber-500/10 text-amber-600 dark:text-amber-400">
                                                    <svg class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/></svg>
                                                </div>
                                                <div class="flex-1 text-xs">
                                                    <div class="flex items-center gap-2">
                                                        <span class="font-bold text-slate-900 uppercase dark:text-white">{{ str_replace('_', ' ', $hist->to_status) }}</span>
                                                        <span class="text-slate-400">• {{ $hist->created_at->format('d M Y, H:i') }}</span>
                                                    </div>
                                                    @if ($hist->notes)
                                                        <p class="mt-0.5 text-slate-600 dark:text-slate-400 leading-relaxed">{{ $hist->notes }}</p>
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
        @else
            <!-- Default Info When Haven't Searched -->
            <div class="mx-auto mt-12 max-w-2xl text-center">
                <div class="rounded-2xl border border-dashed border-slate-300 p-8 dark:border-slate-800">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-amber-500/10 text-amber-600 dark:text-amber-400">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                    </div>
                    <h3 class="mt-3 text-sm font-bold text-slate-800 dark:text-slate-200">Masukkan Nomor Tiket atau WhatsApp</h3>
                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                        Ketikkan Kode Servis (cth: <code>SVC-202610-001</code>) atau nomor HP yang Anda daftarkan saat menitipkan perangkat di KeeHub.
                    </p>
                    <div class="mt-5">
                        <button type="button" @click="activeTab = 'request'" class="x-btn-primary text-xs">
                            Atau Ajukan Permohonan Servis Baru
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
