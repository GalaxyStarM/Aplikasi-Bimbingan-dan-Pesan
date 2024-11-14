// public/firebase-messaging-sw.js

// Import Firebase scripts yang diperlukan
importScripts('https://www.gstatic.com/firebasejs/9.0.0/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/9.0.0/firebase-messaging-compat.js');

// Ambil konfigurasi dari endpoint yang aman
fetch('/firebase-config')
    .then(response => response.json())
    .then(config => {
        // Inisialisasi Firebase dengan konfigurasi dari server
        firebase.initializeApp(config);
        
        // Inisialisasi Firebase Cloud Messaging
        const messaging = firebase.messaging();

        // Handle pesan background
        messaging.onBackgroundMessage((payload) => {
            console.log('[firebase-messaging-sw.js] Received background message:', payload);

            // Customize notifikasi
            const notificationTitle = payload.notification.title || 'Notifikasi Baru';
            const notificationOptions = {
                body: payload.notification.body || 'Ada pesan baru untuk Anda',
                icon: '/images/notification-icon.png', 
                badge: '/images/notification-badge.png', 
                data: payload.data || {},
                // Tambahan opsi notifikasi
                tag: 'notification-' + Date.now(), 
                requireInteraction: true, // Notifikasi tidak akan hilang sampai user berinteraksi
                vibrate: [200, 100, 200], // Pattern vibrasi
                actions: [
                    {
                        action: 'view',
                        title: 'Lihat'
                    }
                ]
            };

            return self.registration.showNotification(notificationTitle, notificationOptions);
        });
    })
    .catch(error => {
        console.error('[firebase-messaging-sw.js] Error loading config:', error);
    });

// Handle klik notifikasi
self.addEventListener('notificationclick', function(event) {
    console.log('[firebase-messaging-sw.js] Notification clicked:', event);
    
    event.notification.close(); // Tutup notifikasi

    // Logika ketika notifikasi diklik
    const clickedNotification = event.notification;
    const action = event.action;
    
    // URL yang akan dibuka ketika notifikasi diklik
    let urlToOpen = '/notifications'; // Default URL

    // Jika ada URL spesifik di data notifikasi
    if (clickedNotification.data && clickedNotification.data.url) {
        urlToOpen = clickedNotification.data.url;
    }

    // Handle action spesifik
    if (action === 'view' && clickedNotification.data.viewUrl) {
        urlToOpen = clickedNotification.data.viewUrl;
    }

    // Buka window/tab baru dengan URL yang sesuai
    const promiseChain = clients.matchAll({
        type: 'window',
        includeUncontrolled: true
    })
    .then((windowClients) => {
        // Cek apakah ada window yang sudah terbuka
        for (let i = 0; i < windowClients.length; i++) {
            const client = windowClients[i];
            if (client.url === urlToOpen && 'focus' in client) {
                return client.focus();
            }
        }
        // Jika tidak ada window yang terbuka, buka yang baru
        if (clients.openWindow) {
            return clients.openWindow(urlToOpen);
        }
    });

    event.waitUntil(promiseChain);
});

// Handle pesan error
self.addEventListener('error', function(event) {
    console.error('[firebase-messaging-sw.js] Service Worker Error:', event.error);
});

// Handle aktivasi service worker
self.addEventListener('activate', function(event) {
    console.log('[firebase-messaging-sw.js] Service Worker activated');
});

// Handle instalasi service worker
self.addEventListener('install', function(event) {
    console.log('[firebase-messaging-sw.js] Service Worker installed');
    self.skipWaiting(); // Aktifkan service worker segera
});