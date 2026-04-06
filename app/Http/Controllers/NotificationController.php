<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\UserNotificationSetting;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Get notifications for the authenticated user
     */
    public function index(Request $request): JsonResponse
    {
        $user = Auth::user();
        $perPage = $request->get('per_page', 10);
        
        $notifications = $user->notifications()
            ->paginate($perPage);

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $user->unreadNotifications()->count(),
        ]);
    }

    /**
     * Get recent notifications (for dropdown)
     */
    public function recent(): JsonResponse
    {
        $user = Auth::user();
        
        $notifications = $user->notifications()
            ->take(10)
            ->get();

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $user->unreadNotifications()->count(),
        ]);
    }

    /**
     * Mark a notification as read
     */
    public function markAsRead(Notification $notification): JsonResponse
    {
        // Ensure user owns this notification
        if ($notification->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $notification->markAsRead();

        return response()->json([
            'success' => true,
            'unread_count' => Auth::user()->unreadNotifications()->count(),
        ]);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead(): JsonResponse
    {
        NotificationService::markAllAsRead(Auth::id());

        return response()->json([
            'success' => true,
            'unread_count' => 0,
        ]);
    }

    /**
     * Delete a notification
     */
    public function destroy(Notification $notification): JsonResponse
    {
        if ($notification->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $notification->delete();

        return response()->json([
            'success' => true,
            'unread_count' => Auth::user()->unreadNotifications()->count(),
        ]);
    }

    /**
     * Get notification settings
     */
    public function getSettings(): JsonResponse
    {
        $settings = UserNotificationSetting::forUser(Auth::id());

        return response()->json($settings);
    }

    /**
     * Update notification settings
     */
    public function updateSettings(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email_new_message' => 'boolean',
            'email_announcement' => 'boolean',
            'email_grade_posted' => 'boolean',
            'email_attendance_alert' => 'boolean',
            'email_assignment_due' => 'boolean',
            'sms_new_message' => 'boolean',
            'sms_announcement' => 'boolean',
            'sms_grade_posted' => 'boolean',
            'sms_attendance_alert' => 'boolean',
            'sms_assignment_due' => 'boolean',
            'phone_number' => 'nullable|string|max:20',
        ]);

        $settings = UserNotificationSetting::forUser(Auth::id());
        $settings->update($validated);

        return response()->json([
            'success' => true,
            'settings' => $settings->fresh(),
        ]);
    }

    /**
     * Get unread count (for badge)
     */
    public function unreadCount(): JsonResponse
    {
        return response()->json([
            'count' => Auth::user()->unreadNotifications()->count(),
        ]);
    }
}
