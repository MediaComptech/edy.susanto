// Service Worker untuk PWA Sapa Warga Tampirkulon (Edy Susanto No. 2)
const CACHE_NAME = 'sapa-warga-v1';
const ASSETS_TO_CACHE = [
  './',
  './index.php?page=beranda',
  './index.php?page=sapa-warga',
  './assets/css/style.css',
  './assets/js/main.js',
  './assets/images/logo/logo_no2.png',
  './assets/images/icons/icon-192.png',
  './assets/images/icons/icon-512.png',
  './assets/images/banner/edy_susanto_hero.jpg'
];

// Install event - caching basic shell
self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME).then((cache) => {
      return cache.addAll(ASSETS_TO_CACHE).catch((err) => {
        console.warn('Cache pre-fetch warning:', err);
      });
    })
  );
  self.skipWaiting();
});

// Activate event - clean old caches
self.addEventListener('activate', (event) => {
  event.waitUntil(
    caches.keys().then((keys) => {
      return Promise.all(
        keys.map((key) => {
          if (key !== CACHE_NAME) {
            return caches.delete(key);
          }
        })
      );
    })
  );
  self.clients.claim();
});

// Fetch event - network first with cache fallback
self.addEventListener('fetch', (event) => {
  // Hanya tangani GET requests
  if (event.request.method !== 'GET') return;

  event.respondWith(
    fetch(event.request)
      .then((networkResponse) => {
        // Jika response valid, clone ke cache jika berasal dari origin yang sama
        if (networkResponse && networkResponse.status === 200 && networkResponse.type === 'basic') {
          const responseToCache = networkResponse.clone();
          caches.open(CACHE_NAME).then((cache) => {
            cache.put(event.request, responseToCache);
          });
        }
        return networkResponse;
      })
      .catch(() => {
        return caches.match(event.request).then((cachedResponse) => {
          if (cachedResponse) {
            return cachedResponse;
          }
          // Fallback sederhana jika offline
          if (event.request.headers.get('accept') && event.request.headers.get('accept').includes('text/html')) {
            return caches.match('./index.php?page=beranda');
          }
        });
      })
  );
});

// Push Notification Event
self.addEventListener('push', (event) => {
  let data = {
    title: 'Sapa Warga - Edy Susanto',
    body: 'Ada pembaruan informasi atau status aspirasi di Tampirkulon!',
    icon: 'assets/images/icons/icon-192.png',
    badge: 'assets/images/icons/icon-192.png',
    url: 'index.php?page=sapa-warga'
  };

  if (event.data) {
    try {
      data = Object.assign(data, event.data.json());
    } catch (e) {
      data.body = event.data.text();
    }
  }

  const options = {
    body: data.body,
    icon: data.icon || 'assets/images/icons/icon-192.png',
    badge: data.badge || 'assets/images/icons/icon-192.png',
    vibrate: [100, 50, 100],
    data: {
      url: data.url || 'index.php?page=sapa-warga'
    },
    actions: [
      { action: 'open', title: 'Lihat Detail' },
      { action: 'close', title: 'Tutup' }
    ]
  };

  event.waitUntil(
    self.registration.showNotification(data.title, options)
  );
});

// Notification Click Event
self.addEventListener('notificationclick', (event) => {
  event.notification.close();
  if (event.action === 'close') return;

  const targetUrl = event.notification.data && event.notification.data.url 
    ? event.notification.data.url 
    : 'index.php?page=sapa-warga';

  event.waitUntil(
    clients.matchAll({ type: 'window', includeUncontrolled: true }).then((windowClients) => {
      for (let client of windowClients) {
        if (client.url.includes('edy_susanto') && 'focus' in client) {
          client.navigate(targetUrl);
          return client.focus();
        }
      }
      if (clients.openWindow) {
        return clients.openWindow(targetUrl);
      }
    })
  );
});
