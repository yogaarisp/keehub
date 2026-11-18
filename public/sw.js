const CACHE_NAME = 'keehub-pwa-v4';
const SHELL_URLS = [
    '/',
    '/offline.html',
    '/manifest.json',
    '/logo-96.png',
    '/logo-192.png',
    '/logo.png',
    '/favicon-32.png'
];

self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => cache.addAll(SHELL_URLS))
    );
    self.skipWaiting();
});

self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((keys) =>
            Promise.all(
                keys.filter((k) => k !== CACHE_NAME).map((k) => caches.delete(k))
            )
        )
    );
    self.clients.claim();
});

self.addEventListener('fetch', (event) => {
    const { request } = event;

    if (request.method !== 'GET') return;

    const url = new URL(request.url);

    // Jangan cache endpoint admin filament atau livewire update internals
    if (url.pathname.startsWith('/admin') || url.pathname.startsWith('/livewire')) {
        return;
    }

    // Network-first untuk HTML navigasi (selalu update data real-time, offline fallback ke offline.html)
    if (request.mode === 'navigate' || request.headers.get('accept')?.includes('text/html')) {
        event.respondWith(
            fetch(request).catch(async () => {
                const cachedResponse = await caches.match(request);
                if (cachedResponse) {
                    return cachedResponse;
                }
                const offlinePage = await caches.match('/offline.html');
                return offlinePage || new Response('Offline', { status: 503, statusText: 'Offline' });
            })
        );
        return;
    }

    // API Builder / Cart / Service: network-first
    if (url.pathname.includes('/builder/api/') || url.pathname.includes('/cart') || url.pathname.includes('/api/')) {
        event.respondWith(
            fetch(request).catch(() => caches.match(request))
        );
        return;
    }

    // Static assets (Vite CSS, JS, images, fonts): Cache-first dengan background revalidate
    if (
        request.destination === 'style' ||
        request.destination === 'script' ||
        request.destination === 'image' ||
        request.destination === 'font'
    ) {
        event.respondWith(
            caches.match(request).then((cached) => {
                if (cached) return cached;

                return fetch(request).then((response) => {
                    if (response && response.status === 200) {
                        const copy = response.clone();
                        caches.open(CACHE_NAME).then((cache) => cache.put(request, copy));
                    }
                    return response;
                }).catch(() => null);
            })
        );
    }
});
