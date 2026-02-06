self.addEventListener('install', (e) => {
  console.log('[Service Worker] Install');
});

const cacheName = 'js13kPWA-v1';
const appShellFiles = [
  '/gds/view/donyaye_parvaz/project_files/pwa-manifest.json',
  '/gds/view/client/assets/images/spinner.jpg',
  '/gds/view/donyaye_parvaz/project_files/js/script.js',
  '/gds/view/donyaye_parvaz/project_files/js/jquery-3.6.0.min.js',
  '/gds/view/donyaye_parvaz/project_files/js/bootstrap.min.js',
  '/gds/view/client/assets/js/vueScripts/pwaApp.js',
  '/gds/app/',
];

self.addEventListener('install', (e) => {
  console.log('[Service Worker] Install');

  e.waitUntil((async () => {
    const cache = await caches.open(cacheName);
    console.log('[Service Worker] Caching all: app shell and content');
    await cache.addAll(appShellFiles);
  })());
});

self.addEventListener('fetch', function(event) {})



// self.addEventListener('fetch', (e) => {
//     e.respondWith((async () => {
//         const r = await caches.match(e.request);
//         console.log(`[Service Worker] Fetching resource: ${e.request.url}`);
//         if (r) { return r; }
//         const response = await fetch(e.request);
//         const cache = await caches.open(cacheName);
//         console.log(`%c [Service Worker] Caching new resource: ${e.request.url}`, 'background: #222; color: #bada55');
//          cache.put(e.request, response.clone());
//         return response;
//     })());
// });
