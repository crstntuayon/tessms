/**
 * TESSMS - Progressive Web App Service Worker
 * Handles caching, offline support, background sync, and push notifications
 */

const CACHE_VERSION = 'v6';
const CACHE_NAME = `tessms-${CACHE_VERSION}`;
const STATIC_CACHE_NAME = `tessms-static-${CACHE_VERSION}`;
const DYNAMIC_CACHE_NAME = `tessms-dynamic-${CACHE_VERSION}`;

// Static assets to cache immediately on install
// NOTE: Update these paths after running `npm run build` if asset hashes change
const STATIC_ASSETS = [
  '/',
  '/login',
  '/dashboard',
  '/student/dashboard',
  '/teacher/dashboard',
  '/admin/dashboard',
  '/build/assets/app-BRD6bzX9.css',
  '/build/assets/app-D4gY5OWJ.js',
  '/build/manifest.json',
  '/js/pwa/offline-support.js',
  '/js/pwa/register.js',
  '/icons/icon-192x192.png',
  '/icons/icon-512x512.png',
  '/manifest.json'
];

// API routes that should NOT be cached
const API_ROUTES = [
  '/api/',
  '/broadcasting/',
  '/sanctum/',
  '/notifications/'
];

// Install Event - Cache static assets
self.addEventListener('install', (event) => {
  console.log('[SW] Installing service worker...');
  
  event.waitUntil(
    caches.open(STATIC_CACHE_NAME)
      .then((cache) => {
        console.log('[SW] Caching static assets');
        return cache.addAll(STATIC_ASSETS);
      })
      .then(() => {
        console.log('[SW] Static assets cached successfully');
        return self.skipWaiting();
      })
      .catch((error) => {
        console.error('[SW] Failed to cache static assets:', error);
      })
  );
});

// Activate Event - Clean up old caches
self.addEventListener('activate', (event) => {
  console.log('[SW] Activating service worker...');
  
  event.waitUntil(
    caches.keys()
      .then((cacheNames) => {
        return Promise.all(
          cacheNames
            .filter((name) => {
              return name.startsWith('tessms-') && 
                     !name.includes(CACHE_VERSION);
            })
            .map((name) => {
              console.log('[SW] Deleting old cache:', name);
              return caches.delete(name);
            })
        );
      })
      .then(() => {
        console.log('[SW] Old caches cleaned up');
        return self.clients.claim();
      })
  );
});

// Helper function to check if request is an API call
function isApiRequest(url) {
  return API_ROUTES.some(route => url.includes(route));
}

// Helper to check if request is a navigation request (HTML page)
function isNavigationRequest(request) {
  return request.mode === 'navigate' || 
         (request.headers.get('accept') && request.headers.get('accept').includes('text/html'));
}

// Helper to check if request is for a static build asset
function isStaticAsset(url) {
  return url.includes('/build/assets/') ||
         url.includes('/icons/') ||
         url.includes('/images/') ||
         url.includes('/js/pwa/') ||
         url.includes('/fonts/') ||
         url.includes('/screenshots/');
}

// Fetch Event - Serve from cache or network
self.addEventListener('fetch', (event) => {
  const { request } = event;
  const url = new URL(request.url);
  
  // Let the browser handle non-GET requests (POST, PUT, DELETE, etc.) normally.
  // Intercepting POST requests (form submissions) and returning JSON breaks
  // Laravel's redirect-with-errors flow and masks real server errors.
  if (request.method !== 'GET') {
    return;
  }
  
  // Handle API requests - Network first, no cache
  if (isApiRequest(url.href)) {
    event.respondWith(
      fetch(request)
        .then((response) => {
          if (response.status === 200) {
            const responseClone = response.clone();
            caches.open(DYNAMIC_CACHE_NAME).then((cache) => {
              cache.put(request, responseClone);
            });
          }
          return response;
        })
        .catch(() => {
          return caches.match(request).then((cached) => {
            if (cached) {
              return cached;
            }
            return new Response(
              JSON.stringify({ 
                error: 'You are offline',
                offline: true 
              }),
              { 
                status: 503, 
                headers: { 'Content-Type': 'application/json' } 
              }
            );
          });
        })
    );
    return;
  }

  // Navigation requests (HTML pages) - Network first, cache fallback
  if (isNavigationRequest(request)) {
    event.respondWith(
      fetch(request)
        .then((response) => {
          if (response.status === 200) {
            const responseClone = response.clone();
            caches.open(DYNAMIC_CACHE_NAME).then((cache) => {
              cache.put(request, responseClone);
            });
          }
          return response;
        })
        .catch(() => {
          return caches.match(request).then((cached) => {
            if (cached) {
              return cached;
            }
            return caches.match('/offline.html');
          });
        })
    );
    return;
  }
  
  // Static assets - Cache first, network fallback
  event.respondWith(
    caches.match(request)
      .then((cached) => {
        if (cached) {
          // Return cached version but also fetch updated version in background
          fetch(request)
            .then((response) => {
              if (response.status === 200) {
                caches.open(STATIC_CACHE_NAME).then((cache) => {
                  cache.put(request, response);
                });
              }
            })
            .catch(() => {});
          
          return cached;
        }
        
        // Not in cache, fetch from network
        return fetch(request)
          .then((response) => {
            if (response.status === 200) {
              const responseClone = response.clone();
              const cacheName = isStaticAsset(url.href) ? STATIC_CACHE_NAME : DYNAMIC_CACHE_NAME;
              caches.open(cacheName).then((cache) => {
                cache.put(request, responseClone);
              });
            }
            return response;
          })
          .catch((error) => {
            console.log('[SW] Fetch failed:', error);
            throw error;
          });
      })
  );
});

// Background Sync - Queue and sync offline actions
self.addEventListener('sync', (event) => {
  console.log('[SW] Background sync triggered:', event.tag);
  
  switch (event.tag) {
    case 'sync-attendance':
      event.waitUntil(syncAttendanceData());
      break;
    case 'sync-grades':
      event.waitUntil(syncGradesData());
      break;
    case 'sync-messages':
      event.waitUntil(syncMessagesData());
      break;
    default:
      console.log('[SW] Unknown sync tag:', event.tag);
  }
});

// Sync attendance data from IndexedDB
async function syncAttendanceData() {
  console.log('[SW] Syncing attendance data...');
  
  try {
    const db = await openIndexedDB('tessms-offline', 1);
    const attendanceQueue = await db.getAll('attendance-queue');
    
    for (const record of attendanceQueue) {
      try {
        const response = await fetch('/teacher/attendance/bulk-store', {
          method: 'POST',
          headers: { 
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
          },
          body: JSON.stringify(record.data)
        });
        
        if (response.ok) {
          await db.delete('attendance-queue', record.id);
          console.log('[SW] Attendance synced:', record.id);
          
          await notifyClients({
            type: 'SYNC_SUCCESS',
            message: 'Attendance synced successfully',
            recordId: record.id
          });
        } else {
          throw new Error(`HTTP ${response.status}`);
        }
      } catch (error) {
        console.error('[SW] Failed to sync attendance:', error);
      }
    }
  } catch (error) {
    console.error('[SW] Error in syncAttendanceData:', error);
  }
}

// Sync grades data from IndexedDB
async function syncGradesData() {
  console.log('[SW] Syncing grades data...');
  
  try {
    const db = await openIndexedDB('tessms-offline', 1);
    const gradesQueue = await db.getAll('grades-queue');
    
    for (const record of gradesQueue) {
      try {
        const response = await fetch('/teacher/grades/quick-save', {
          method: 'POST',
          headers: { 
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
          },
          body: JSON.stringify(record.data)
        });
        
        if (response.ok) {
          await db.delete('grades-queue', record.id);
          console.log('[SW] Grades synced:', record.id);
        } else {
          throw new Error(`HTTP ${response.status}`);
        }
      } catch (error) {
        console.error('[SW] Failed to sync grades:', error);
      }
    }
  } catch (error) {
    console.error('[SW] Error in syncGradesData:', error);
  }
}

// Push Notification Events
self.addEventListener('push', (event) => {
  console.log('[SW] Push received:', event);
  
  let data = {};
  try {
    data = event.data.json();
  } catch (e) {
    data = {
      title: 'TESSMS Notification',
      body: event.data.text(),
      url: '/dashboard'
    };
  }
  
  const options = {
    body: data.body || 'You have a new notification',
    icon: data.icon || '/icons/icon-192x192.png',
    badge: data.badge || '/icons/badge-72x72.png',
    tag: data.tag || 'default',
    requireInteraction: data.requireInteraction || false,
    vibrate: data.vibrate || [100, 50, 100],
    data: {
      url: data.url || '/dashboard',
      action: data.action || 'open'
    },
    actions: data.actions || [
      {
        action: 'open',
        title: 'Open'
      },
      {
        action: 'dismiss',
        title: 'Dismiss'
      }
    ]
  };
  
  event.waitUntil(
    self.registration.showNotification(
      data.title || 'TESSMS',
      options
    )
  );
});

// Notification click handler
self.addEventListener('notificationclick', (event) => {
  console.log('[SW] Notification clicked:', event);
  
  event.notification.close();
  
  const notificationData = event.notification.data;
  const action = event.action;
  
  if (action === 'dismiss') {
    return;
  }
  
  event.waitUntil(
    self.clients.matchAll({ type: 'window', includeUncontrolled: true })
      .then((clientList) => {
        const url = notificationData?.url || '/dashboard';
        
        for (const client of clientList) {
          if (client.url.includes(self.location.origin) && 'focus' in client) {
            return client.navigate(url).then(() => client.focus());
          }
        }
        
        if (self.clients.openWindow) {
          return self.clients.openWindow(url);
        }
      })
  );
});

// Message handler from client
self.addEventListener('message', (event) => {
  console.log('[SW] Message from client:', event.data);
  
  if (event.data && event.data.type === 'SKIP_WAITING') {
    self.skipWaiting();
  }
  
  if (event.data && event.data.type === 'GET_VERSION') {
    event.ports[0].postMessage({ version: CACHE_VERSION });
  }
});

// Periodic background sync (if supported)
self.addEventListener('periodicsync', (event) => {
  if (event.tag === 'sync-data') {
    event.waitUntil(syncAllData());
  }
});

// Helper: Open IndexedDB
function openIndexedDB(name, version) {
  return new Promise((resolve, reject) => {
    const request = indexedDB.open(name, version);
    
    request.onerror = () => reject(request.error);
    request.onsuccess = () => resolve(request.result);
    
    request.onupgradeneeded = (event) => {
      const db = event.target.result;
      
      if (!db.objectStoreNames.contains('attendance-queue')) {
        db.createObjectStore('attendance-queue', { keyPath: 'id', autoIncrement: true });
      }
      if (!db.objectStoreNames.contains('grades-queue')) {
        db.createObjectStore('grades-queue', { keyPath: 'id', autoIncrement: true });
      }
      if (!db.objectStoreNames.contains('messages-queue')) {
        db.createObjectStore('messages-queue', { keyPath: 'id', autoIncrement: true });
      }
    };
  });
}

// Helper: Notify all clients
async function notifyClients(message) {
  const clients = await self.clients.matchAll({ type: 'window' });
  clients.forEach(client => {
    client.postMessage(message);
  });
}

// Helper: Sync all data
async function syncAllData() {
  await Promise.all([
    syncAttendanceData(),
    syncGradesData(),
    syncMessagesData()
  ]);
}

async function syncMessagesData() {
  console.log('[SW] Syncing messages data...');
}
