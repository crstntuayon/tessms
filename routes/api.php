<?php

use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\AnnouncementController;
use Illuminate\Support\Facades\Route;

// Public student lookup API (for enrollment)
Route::get('/students/lookup', [StudentController::class, 'lookupByLrn']);

// Authenticated API routes
Route::middleware(['auth'])->group(function () {
    // Announcement unread count
    Route::get('/announcements/unread-count', [AnnouncementController::class, 'unreadCount'])->name('api.announcements.unread-count');
    // Mark all announcements as read
    Route::post('/announcements/mark-all-read', [AnnouncementController::class, 'markAllAsRead'])->name('api.announcements.mark-all-read');
});
