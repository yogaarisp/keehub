const CACHE_NAME = 'keehub-shell-v2';
const SHELL_URLS = ['/', '/manifest.json', '/logo-96.png', '/favicon-32.png'];

self.addEventListener('install', (event) => {
    event.waitUntil(caches.open(CACHE_NAME).then((cache) => cache.addAll(SHELL_URLS)));
    self.skipWaiting();
});

self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((keys) => Promise.all(keys.filter((k) => k !== CACHE_NAME).map((k) => caches.delete(k))))
    );
    self.clients.claim();
});

self.addEventListener('fetch', (event) => {
    const { request } = event;

    if (request.method !== 'GET') return;

    // Network-first untuk halaman & API (data tidak boleh stale)
    if (request.headers.get('accept')?.includes('text/html') || request.url.includes('/builder/api/')) {
        event.respondWith(fetch(request).catch(() => caches.match(request)));
        return;
    }

    // Cache-first untuk static assets
    if (request.destination === 'style' || request.destination === 'script' || request.destination === 'image' || request.destination === 'font') {
        event.respondWith(
            caches.match(request).then((cached) => cached ?? fetch(request).then((res) => {
                const copy = res.clone();
                caches.open(CACHE_NAME).then((cache) => cache.put(request, copy));
                return res;
            }))
        );
    }
});
