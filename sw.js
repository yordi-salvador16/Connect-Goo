const CACHE_NAME = 'connectgoo-v2'; // Versión 2 para forzar actualización
const urlsToCache = [
  './',
  './index.php',
  './categorias.php',
  './assets/css/styles.css',
  './assets/css/premium-home.css'
];

self.addEventListener('install', event => {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(cache => {
        return cache.addAll(urlsToCache);
      })
  );
  self.skipWaiting(); // Forzar activación inmediata
});

self.addEventListener('activate', event => {
  event.waitUntil(
    caches.keys().then(cacheNames => {
      return Promise.all(
        cacheNames.map(cacheName => {
          if (cacheName !== CACHE_NAME) {
            return caches.delete(cacheName); // Borrar el caché viejo
          }
        })
      );
    })
  );
});

// Estrategia: Network First (Red primero, si falla usa el caché)
self.addEventListener('fetch', event => {
  // Ignorar peticiones POST (como la de nuestra métrica)
  if (event.request.method !== 'GET') return;

  event.respondWith(
    fetch(event.request)
      .then(response => {
        // Clonamos la respuesta y la guardamos fresca en caché
        if (response && response.status === 200 && response.type === 'basic') {
          const responseToCache = response.clone();
          caches.open(CACHE_NAME).then(cache => {
            cache.put(event.request, responseToCache);
          });
        }
        return response;
      })
      .catch(() => {
        // Si no hay internet, devolver del caché
        return caches.match(event.request);
      })
  );
});
