var staticCacheName = "pwa-v" + new Date().getTime();
var filesToCache = [
    "/",
    "/offline",
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
    // Tambahkan rute lainnya yang perlu di-cache
];

// Cache on install
self.addEventListener("install", (event) => {
    this.skipWaiting();
    event.waitUntil(
        caches.open(staticCacheName).then((cache) => {
            return cache.addAll(filesToCache);
        })
    );
});

// Clear cache on activate
self.addEventListener("activate", (event) => {
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames
                    .filter((cacheName) => cacheName.startsWith("pwa-"))
                    .filter((cacheName) => cacheName !== staticCacheName)
                    .map((cacheName) => caches.delete(cacheName))
            );
        })
    );
});

// Serve from Cache
self.addEventListener("fetch", (event) => {
    event.respondWith(
        caches
            .match(event.request)
            .then((response) => {
                return response || fetch(event.request);
            })
            .catch(() => {
                return caches.match("/offline");
            })
    );
});
