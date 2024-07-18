var staticCacheName = "pwa-v" + new Date().getTime();
var filesToCache = [
    "/",
    "/offline",
    "/profile-saya",
    "/products",
    "/products/load-more",
    "/search",
    "/faqs",
    "/blogs",
    "/kategori/{slug}",
    "/dashboard/profile",
    "/dashboard/profile/edit",
    "/dashboard/profile/destroy",
    "/dashboard/admin",
    "/dashboard/users",
    "/dashboard/carousels",
    "/dashboard/categories",
    "/dashboard/blogs",
    "/dashboard/blogs/autocomplete/tags",
    "/dashboard/ckeditor/upload",
    "/dashboard/blogs/{id}/mark-as-recommended",
    "/dashboard/blogs/{id}/unmark-as-recommended",
    "/dashboard/product/{product}/verify",
    "/dashboard/faqs/create",
    "/dashboard/faqs",
    "/dashboard/faqs/{faq}/edit",
    "/dashboard/faqs/{faq}",
    "/dashboard/produk",
    "/dashboard/produk/tambah",
    "/dashboard/produk/edit/{slug}",
    "/dashboard/produk/{slug}",
    "/notifications",
    "/foo",
    "/css/app.css",
    "/js/app.js",
    "/images/icons/icon-72x72.png",
    "/images/icons/icon-96x96.png",
    "/images/icons/icon-128x128.png",
    "/images/icons/icon-144x144.png",
    "/images/icons/icon-152x152.png",
    "/images/icons/icon-192x192.png",
    "/images/icons/icon-384x384.png",
    "/images/icons/icon-512x512.png",
];

self.addEventListener("install", (event) => {
    event.waitUntil(
        caches
            .open(staticCacheName)
            .then((cache) => {
                return cache.addAll(filesToCache);
            })
            .catch((error) => {
                console.error("Failed to cache files:", error);
            })
    );
    self.skipWaiting();
});

self.addEventListener("activate", (event) => {
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames
                    .filter(
                        (cacheName) =>
                            cacheName.startsWith("pwa-") &&
                            cacheName !== staticCacheName
                    )
                    .map((cacheName) => caches.delete(cacheName))
            );
        })
    );
});

self.addEventListener("fetch", (event) => {
    event.respondWith(
        caches.match(event.request).then((response) => {
            return (
                response ||
                fetch(event.request)
                    .then((fetchResponse) => {
                        return caches.open(staticCacheName).then((cache) => {
                            cache.put(event.request, fetchResponse.clone());
                            return fetchResponse;
                        });
                    })
                    .catch(() => {
                        return caches.match("/offline");
                    })
            );
        })
    );
});
