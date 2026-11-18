{{-- PWA In-App Install Prompt (Android, Desktop & iOS Guide) --}}
<div x-data="{
        deferredPrompt: null,
        isIOS: /iphone|ipad|ipod/.test(window.navigator.userAgent.toLowerCase()) && !window.MSStream,
        isStandalone: window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true,
        showBanner: false,
        showIOSGuide: false,
        init() {
            if (this.isStandalone) return;
            if (localStorage.getItem('keehub_pwa_dismissed')) return;

            window.addEventListener('beforeinstallprompt', (e) => {
                e.preventDefault();
                this.deferredPrompt = e;
                this.showBanner = true;
            });

            // On iOS Safari, show prompt after 2 seconds if not installed
            if (this.isIOS && !this.isStandalone) {
                setTimeout(() => {
                    this.showBanner = true;
                }, 2000);
            }
        },
        async install() {
            if (this.deferredPrompt) {
                this.deferredPrompt.prompt();
                const choiceResult = await this.deferredPrompt.userChoice;
                if (choiceResult.outcome === 'accepted') {
                    this.showBanner = false;
                }
                this.deferredPrompt = null;
            } else if (this.isIOS) {
                this.showIOSGuide = true;
            }
        },
        dismiss() {
            this.showBanner = false;
            this.showIOSGuide = false;
            localStorage.setItem('keehub_pwa_dismissed', 'true');
        }
    }"
    x-cloak
    class="pointer-events-none">

    {{-- Floating Install Bar --}}
    <div x-show="showBanner && !isStandalone"
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="opacity-0 translate-y-6"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200 transform"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-6"
         class="pointer-events-auto fixed bottom-24 inset-x-3 sm:inset-x-auto sm:right-6 sm:bottom-6 sm:max-w-md z-40 mx-auto">
        <div class="flex items-center gap-3 rounded-2xl border border-white/80 bg-white/90 p-3 shadow-[0_12px_36px_rgba(0,0,0,0.16)] backdrop-blur-xl dark:border-white/10 dark:bg-slate-900/90 dark:shadow-[0_12px_36px_rgba(0,0,0,0.5)]">
            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-amber-500/15 p-1.5 ring-1 ring-amber-500/25">
                <img src="/logo-96.png" alt="KeeHub App" class="h-full w-full object-contain">
            </div>

            <div class="min-w-0 flex-1">
                <div class="flex items-center gap-1.5">
                    <span class="text-xs font-bold text-slate-900 dark:text-white">Pasang Aplikasi KeeHub</span>
                    <span class="rounded-full bg-amber-500/15 px-1.5 py-0.2 text-[9px] font-semibold text-amber-600 dark:text-amber-400">PWA</span>
                </div>
                <p class="text-[11px] leading-tight text-slate-500 dark:text-slate-400 truncate">
                    Akses lebih cepat & tampilan fullscreen tanpa address bar.
                </p>
            </div>

            <div class="flex items-center gap-1.5 shrink-0">
                <button type="button"
                        x-on:click="install()"
                        class="rounded-full bg-amber-600 px-3 py-1.5 text-xs font-semibold text-white shadow-sm shadow-amber-600/25 transition active:scale-95 hover:bg-amber-500">
                    <span x-text="isIOS ? 'Pasang' : 'Install'"></span>
                </button>
                <button type="button"
                        x-on:click="dismiss()"
                        class="flex h-7 w-7 items-center justify-center rounded-full text-slate-400 hover:bg-slate-100 hover:text-slate-600 dark:hover:bg-slate-800 dark:hover:text-slate-200"
                        aria-label="Tutup">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>
    </div>

    {{-- iOS Instructions Modal --}}
    <div x-show="showIOSGuide"
         class="pointer-events-auto fixed inset-0 z-50 flex items-end sm:items-center justify-center bg-slate-950/60 p-3 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        <div class="w-full max-w-sm rounded-3xl border border-white/80 bg-white p-5 shadow-2xl dark:border-white/10 dark:bg-slate-900"
             @click.away="showIOSGuide = false">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800">
                <div class="flex items-center gap-2.5">
                    <img src="/logo-96.png" alt="KeeHub" class="h-7 w-7 object-contain">
                    <h3 class="text-sm font-bold text-slate-900 dark:text-white">Pasang di iPhone / iPad</h3>
                </div>
                <button type="button"
                        x-on:click="showIOSGuide = false"
                        class="rounded-full p-1 text-slate-400 hover:bg-slate-100 hover:text-slate-700 dark:hover:bg-slate-800 dark:hover:text-white">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <p class="mt-3 text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                Untuk menjalankan KeeHub secara <strong>fullscreen</strong> tanpa address bar di Safari:
            </p>

            <ol class="mt-3 space-y-2.5 text-xs text-slate-700 dark:text-slate-200">
                <li class="flex items-center gap-2.5 rounded-xl bg-slate-50 p-2.5 dark:bg-slate-800/60">
                    <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-amber-500/15 text-[11px] font-bold text-amber-600 dark:text-amber-400">1</span>
                    <span class="flex-1">Ketuk tombol <strong>Bagikan</strong> (ikon kotak dengan panah ke atas <svg class="inline h-4 w-4 align-sub text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>) di Safari.</span>
                </li>
                <li class="flex items-center gap-2.5 rounded-xl bg-slate-50 p-2.5 dark:bg-slate-800/60">
                    <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-amber-500/15 text-[11px] font-bold text-amber-600 dark:text-amber-400">2</span>
                    <span class="flex-1">Gulir ke bawah lalu pilih <strong>"Tambahkan ke Layar Utama" (Add to Home Screen)</strong>.</span>
                </li>
                <li class="flex items-center gap-2.5 rounded-xl bg-slate-50 p-2.5 dark:bg-slate-800/60">
                    <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-amber-500/15 text-[11px] font-bold text-amber-600 dark:text-amber-400">3</span>
                    <span class="flex-1">Ketuk <strong>Tambah</strong> di pojok kanan atas. Buka aplikasi dari layar utama Anda!</span>
                </li>
            </ol>

            <button type="button"
                    x-on:click="showIOSGuide = false"
                    class="mt-4 w-full rounded-full bg-slate-900 py-2.5 text-xs font-semibold text-white transition active:scale-95 dark:bg-white dark:text-slate-900">
                Saya Mengerti
            </button>
        </div>
    </div>
</div>
