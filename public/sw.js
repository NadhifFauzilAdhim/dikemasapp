self.addEventListener('install', event => {
    self.skipWaiting();
});

self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames.map(cacheName => {
                    return caches.delete(cacheName);
                })
            );
        }).then(() => self.clients.claim())
    );
});

self.addEventListener('fetch', event => {
    // Langsung arahkan ke network (tidak ada caching) agar aset CSS/JS selalu up-to-date
    if (!event.request.url.startsWith('http')) return;

    event.respondWith(fetch(event.request));
});
