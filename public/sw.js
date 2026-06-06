const CACHE_NAME = 'dikemasops-pwa-v1';
const urlsToCache = [
    '/',
    '/manifest.json',
    '/image/logo-header.png',
    '/favicon.ico'
];

self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => {
                return cache.addAll(urlsToCache);
            })
    );
});

self.addEventListener('fetch', event => {
    // Hanya tangkap request HTTP/HTTPS
    if (!event.request.url.startsWith('http')) return;

    event.respondWith(
        caches.match(event.request)
            .then(response => {
                // Cache hit - kembalikan dari cache
                if (response) {
                    return response;
                }
                // Fetch dari network, tangkap error jika gagal (offline/server down)
                return fetch(event.request).catch(error => {
                    console.warn('PWA Fetch failed:', event.request.url, error);
                    // TODO: Return offline fallback page di masa depan jika diperlukan
                });
            })
    );
});
