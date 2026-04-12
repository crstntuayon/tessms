@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-50 py-8">
    <div class="max-w-2xl mx-auto px-4">
        
        {{-- Header --}}
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-slate-800">PWA Settings</h1>
            <p class="text-slate-600">Manage your mobile app experience</p>
        </div>

        {{-- PWA Status Component --}}
        @include('components.pwa-status')

        {{-- Notification Settings --}}
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mt-6">
            <h2 class="text-lg font-semibold text-slate-800 mb-4">
                <i class="fas fa-bell text-blue-500 mr-2"></i>
                Notification Preferences
            </h2>
            
            <div class="space-y-4">
                <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                    <div>
                        <p class="font-medium text-slate-800">Grade Alerts</p>
                        <p class="text-sm text-slate-500">Get notified when new grades are posted</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" checked class="sr-only peer">
                        <div class="w-11 h-6 bg-slate-200 peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    </label>
                </div>

                <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                    <div>
                        <p class="font-medium text-slate-800">Announcements</p>
                        <p class="text-sm text-slate-500">School and class announcements</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" checked class="sr-only peer">
                        <div class="w-11 h-6 bg-slate-200 peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    </label>
                </div>

                <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                    <div>
                        <p class="font-medium text-slate-800">Assignment Reminders</p>
                        <p class="text-sm text-slate-500">Due date reminders for assignments</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer">
                        <div class="w-11 h-6 bg-slate-200 peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    </label>
                </div>

                <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                    <div>
                        <p class="font-medium text-slate-800">Attendance Alerts</p>
                        <p class="text-sm text-slate-500">Notify when marked absent or late</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" checked class="sr-only peer">
                        <div class="w-11 h-6 bg-slate-200 peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    </label>
                </div>

                <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                    <div>
                        <p class="font-medium text-slate-800">Messages</p>
                        <p class="text-sm text-slate-500">New message notifications</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" checked class="sr-only peer">
                        <div class="w-11 h-6 bg-slate-200 peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    </label>
                </div>
            </div>
        </div>

        {{-- Offline Data --}}
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mt-6">
            <h2 class="text-lg font-semibold text-slate-800 mb-4">
                <i class="fas fa-database text-green-500 mr-2"></i>
                Offline Data
            </h2>
            
            <div class="space-y-3">
                <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <div>
                            <p class="font-medium text-slate-800">Cached Grades</p>
                            <p class="text-sm text-slate-500" id="cached-grades">Loading...</p>
                        </div>
                    </div>
                    <button onclick="clearCachedData('grades')" class="text-red-500 hover:text-red-700 text-sm font-medium">
                        Clear
                    </button>
                </div>

                <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-green-100 text-green-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-clipboard-check"></i>
                        </div>
                        <div>
                            <p class="font-medium text-slate-800">Cached Attendance</p>
                            <p class="text-sm text-slate-500" id="cached-attendance">Loading...</p>
                        </div>
                    </div>
                    <button onclick="clearCachedData('attendance')" class="text-red-500 hover:text-red-700 text-sm font-medium">
                        Clear
                    </button>
                </div>

                <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-amber-100 text-amber-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-bullhorn"></i>
                        </div>
                        <div>
                            <p class="font-medium text-slate-800">Cached Announcements</p>
                            <p class="text-sm text-slate-500" id="cached-announcements">Loading...</p>
                        </div>
                    </div>
                    <button onclick="clearCachedData('announcements')" class="text-red-500 hover:text-red-700 text-sm font-medium">
                        Clear
                    </button>
                </div>
            </div>

            <div class="mt-4 pt-4 border-t border-slate-200">
                <button onclick="clearAllCachedData()" class="w-full py-2.5 border-2 border-red-200 text-red-600 rounded-lg font-medium hover:bg-red-50 transition">
                    <i class="fas fa-trash-alt mr-2"></i>
                    Clear All Cached Data
                </button>
            </div>
        </div>

        {{-- App Info --}}
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mt-6">
            <h2 class="text-lg font-semibold text-slate-800 mb-4">
                <i class="fas fa-info-circle text-slate-500 mr-2"></i>
                App Information
            </h2>
            
            <div class="space-y-2 text-sm">
                <div class="flex justify-between py-2">
                    <span class="text-slate-500">App Version</span>
                    <span class="font-medium text-slate-800">1.0.0</span>
                </div>
                <div class="flex justify-between py-2">
                    <span class="text-slate-500">PWA Status</span>
                    <span id="pwa-status" class="font-medium text-slate-800">Checking...</span>
                </div>
                <div class="flex justify-between py-2">
                    <span class="text-slate-500">Service Worker</span>
                    <span id="sw-status" class="font-medium text-slate-800">Checking...</span>
                </div>
                <div class="flex justify-between py-2">
                    <span class="text-slate-500">Push Notifications</span>
                    <span id="push-status" class="font-medium text-slate-800">Checking...</span>
                </div>
                <div class="flex justify-between py-2">
                    <span class="text-slate-500">Cache Storage</span>
                    <span id="cache-size" class="font-medium text-slate-800">Calculating...</span>
                </div>
            </div>
        </div>

        {{-- Debug Tools (Admin Only) --}}
        @if(auth()->user()->role?->name === 'System Admin' || auth()->user()->role?->name === 'Admin')
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mt-6">
            <h2 class="text-lg font-semibold text-slate-800 mb-4">
                <i class="fas fa-tools text-purple-500 mr-2"></i>
                Developer Tools
            </h2>
            
            <div class="grid grid-cols-2 gap-3">
                <button onclick="location.reload()" class="p-3 bg-slate-100 hover:bg-slate-200 rounded-lg text-slate-700 font-medium transition">
                    <i class="fas fa-sync mr-2"></i>
                    Reload App
                </button>
                <button onclick="updateServiceWorker()" class="p-3 bg-slate-100 hover:bg-slate-200 rounded-lg text-slate-700 font-medium transition">
                    <i class="fas fa-download mr-2"></i>
                    Update SW
                </button>
                <button onclick="unregisterServiceWorker()" class="p-3 bg-red-100 hover:bg-red-200 rounded-lg text-red-700 font-medium transition">
                    <i class="fas fa-power-off mr-2"></i>
                    Unregister SW
                </button>
                <button onclick="testPushNotification()" class="p-3 bg-blue-100 hover:bg-blue-200 rounded-lg text-blue-700 font-medium transition">
                    <i class="fas fa-bell mr-2"></i>
                    Test Push
                </button>
            </div>
        </div>
        @endif

    </div>
</div>

@push('scripts')
<script>
// Check PWA status
document.addEventListener('DOMContentLoaded', async () => {
    // Check if running as PWA
    const isStandalone = window.matchMedia('(display-mode: standalone)').matches || 
                        window.navigator.standalone === true;
    document.getElementById('pwa-status').textContent = isStandalone ? 'Installed' : 'Browser';
    document.getElementById('pwa-status').className = isStandalone ? 'font-medium text-green-600' : 'font-medium text-amber-600';

    // Check Service Worker
    if ('serviceWorker' in navigator) {
        const registration = await navigator.serviceWorker.ready;
        document.getElementById('sw-status').textContent = registration.active ? 'Active' : 'Inactive';
        document.getElementById('sw-status').className = registration.active ? 'font-medium text-green-600' : 'font-medium text-red-600';
    } else {
        document.getElementById('sw-status').textContent = 'Not Supported';
        document.getElementById('sw-status').className = 'font-medium text-red-600';
    }

    // Check Push
    if ('PushManager' in window) {
        const permission = Notification.permission;
        document.getElementById('push-status').textContent = permission === 'granted' ? 'Enabled' : 
                                                             permission === 'denied' ? 'Blocked' : 'Not Set';
        document.getElementById('push-status').className = permission === 'granted' ? 'font-medium text-green-600' : 
                                                           permission === 'denied' ? 'font-medium text-red-600' : 'font-medium text-amber-600';
    } else {
        document.getElementById('push-status').textContent = 'Not Supported';
        document.getElementById('push-status').className = 'font-medium text-red-600';
    }

    // Get cache size
    if ('caches' in window) {
        const cacheNames = await caches.keys();
        let totalSize = 0;
        for (const name of cacheNames) {
            const cache = await caches.open(name);
            const requests = await cache.keys();
            // Approximate size
            totalSize += requests.length * 1024; // Rough estimate
        }
        const sizeMB = (totalSize / 1024 / 1024).toFixed(2);
        document.getElementById('cache-size').textContent = sizeMB + ' MB (approx)';
    }

    // Get pending sync count
    if (window.getPendingSyncCount) {
        const count = await window.getPendingSyncCount();
        if (count > 0) {
            document.getElementById('cached-grades').textContent = count + ' pending uploads';
        } else {
            document.getElementById('cached-grades').textContent = 'Up to date';
        }
    }
});

async function clearCachedData(type) {
    if (!confirm('Clear cached ' + type + '?')) return;
    
    if ('caches' in window) {
        const cacheNames = await caches.keys();
        for (const name of cacheNames) {
            if (name.includes(type) || name.includes('dynamic')) {
                const cache = await caches.open(name);
                const requests = await cache.keys();
                for (const request of requests) {
                    if (request.url.includes(type)) {
                        await cache.delete(request);
                    }
                }
            }
        }
    }
    
    // Also clear IndexedDB if needed
    if (window.tessmsOffline && window.tessmsOffline.db) {
        // Implementation depends on your offline support
    }
    
    alert('Cached ' + type + ' cleared!');
    location.reload();
}

async function clearAllCachedData() {
    if (!confirm('Clear ALL cached data? This will require re-downloading.')) return;
    
    if ('caches' in window) {
        const cacheNames = await caches.keys();
        await Promise.all(cacheNames.map(name => caches.delete(name)));
    }
    
    // Clear IndexedDB
    const dbs = await indexedDB.databases();
    dbs.forEach(db => {
        if (db.name) indexedDB.deleteDatabase(db.name);
    });
    
    alert('All cached data cleared!');
    location.reload();
}

async function updateServiceWorker() {
    if ('serviceWorker' in navigator) {
        const registration = await navigator.serviceWorker.ready;
        await registration.update();
        alert('Service Worker updated!');
    }
}

async function unregisterServiceWorker() {
    if (!confirm('Unregister Service Worker? The app will not work offline.')) return;
    
    if ('serviceWorker' in navigator) {
        const registration = await navigator.serviceWorker.ready;
        await registration.unregister();
        alert('Service Worker unregistered. Reloading...');
        location.reload();
    }
}

async function testPushNotification() {
    try {
        const response = await fetch('/api/notifications/test', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        
        if (response.ok) {
            alert('Test notification sent! Check your device.');
        } else {
            alert('Failed to send test notification. Make sure you have granted permission.');
        }
    } catch (error) {
        alert('Error: ' + error.message);
    }
}
</script>
@endpush
@endsection
