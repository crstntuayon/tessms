<?php

use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\AnnouncementController;
use App\Http\Controllers\Api\PushNotificationController;
use App\Http\Controllers\Api\BiometricAuthController;
use App\Http\Controllers\Api\LocationController;
use Illuminate\Support\Facades\Route;

Route::middleware(\App\Http\Middleware\ApiKeyAuth::class)->group(function () {

// Public student lookup API (for enrollment)
Route::get('/students/lookup', [StudentController::class, 'lookupByLrn']);

// Authenticated API routes
Route::middleware(['auth'])->group(function () {
    // Announcement unread count
    Route::get('/announcements/unread-count', [AnnouncementController::class, 'unreadCount'])->name('api.announcements.unread-count');
    // Mark all announcements as read
    Route::post('/announcements/mark-all-read', [AnnouncementController::class, 'markAllAsRead'])->name('api.announcements.mark-all-read');
    
    // Push Notification Routes
    Route::prefix('notifications')->group(function () {
        Route::post('/subscribe', [PushNotificationController::class, 'subscribe'])->name('api.notifications.subscribe');
        Route::post('/unsubscribe', [PushNotificationController::class, 'unsubscribe'])->name('api.notifications.unsubscribe');
        Route::get('/subscriptions', [PushNotificationController::class, 'getSubscriptions'])->name('api.notifications.subscriptions');
        Route::post('/test', [PushNotificationController::class, 'test'])->name('api.notifications.test');
    });
    
    // Biometric Authentication Routes
    Route::prefix('biometric')->group(function () {
        Route::get('/check', [BiometricAuthController::class, 'checkAvailability'])->name('api.biometric.check');
        Route::get('/register-options', [BiometricAuthController::class, 'getRegistrationOptions'])->name('api.biometric.register-options');
        Route::post('/register', [BiometricAuthController::class, 'register'])->name('api.biometric.register');
        Route::get('/credentials', [BiometricAuthController::class, 'getCredentials'])->name('api.biometric.credentials');
        Route::delete('/credentials/{id}', [BiometricAuthController::class, 'removeCredential'])->name('api.biometric.remove');
    });
});

// Public biometric authentication routes
Route::prefix('biometric')->group(function () {
    Route::get('/auth-options', [BiometricAuthController::class, 'getAuthenticationOptions'])->name('api.biometric.auth-options');
    Route::post('/authenticate', [BiometricAuthController::class, 'authenticate'])->name('api.biometric.authenticate');
});

// Location / Geolocation Routes
Route::prefix('location')->group(function () {
    Route::get('/schools', [LocationController::class, 'getSchoolLocations'])->name('api.location.schools');
    Route::post('/verify', [LocationController::class, 'verifyLocation'])->name('api.location.verify');
    Route::get('/nearest', [LocationController::class, 'getNearestLocation'])->name('api.location.nearest');
    
    // Admin routes
    Route::middleware(['auth'])->group(function () {
        Route::get('/all', [LocationController::class, 'getAllLocations'])->name('api.location.all');
        Route::post('/create', [LocationController::class, 'createLocation'])->name('api.location.create');
        Route::put('/update/{id}', [LocationController::class, 'updateLocation'])->name('api.location.update');
        Route::delete('/delete/{id}', [LocationController::class, 'deleteLocation'])->name('api.location.delete');
    });
});

}); // End API key middleware group
