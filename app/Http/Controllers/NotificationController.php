<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\NotificationRecipient;
use App\Models\UserNotificationSetting;
use App\Services\NotificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct(
        protected NotificationService $service
    ) {}

    // =============================================
    // GET USER NOTIFICATIONS
    // GET /api/notifications
    // =============================================
    public function index(Request $request): JsonResponse
    {
        $query = NotificationRecipient::where('user_id', auth()->id())
            ->with(['notification' => fn($q) => $q->select(
                'id', 'title', 'body', 'category', 'action_type',
                'screen', 'screen_id', 'extra_data', 'created_at'
            )])
            ->latest();

        // Filter by category
        if ($request->category) {
            $query->whereHas('notification', fn($q) =>
                $q->where('category', $request->category)
            );
        }

        // Filter unread only
        if ($request->boolean('unread')) {
            $query->where('is_read', false);
        }

        $notifications = $query->paginate($request->per_page ?? 20);

        return response()->json([
            'success'      => true,
            'data'         => $notifications,
            'unread_count' => $this->getUnreadCount(),
        ]);
    }

    // =============================================
    // GET SINGLE NOTIFICATION
    // GET /api/notifications/{id}
    // =============================================
    public function show(int $id): JsonResponse
    {
        $recipient = NotificationRecipient::where('user_id', auth()->id())
            ->where('notification_id', $id)
            ->with('notification')
            ->firstOrFail();

        // Auto mark as read
        if (!$recipient->is_read) {
            $recipient->update(['is_read' => true, 'read_at' => now()]);
            $recipient->notification->increment('read_count');
        }

        return response()->json([
            'success' => true,
            'data'    => $recipient,
        ]);
    }

    // =============================================
    // MARK AS READ
    // POST /api/notifications/{id}/read
    // =============================================
    public function markAsRead(int $id): JsonResponse
    {
        $recipient = NotificationRecipient::where('user_id', auth()->id())
            ->where('notification_id', $id)
            ->firstOrFail();

        if (!$recipient->is_read) {
            $recipient->update(['is_read' => true, 'read_at' => now()]);
            Notification::where('id', $id)->increment('read_count');
        }

        return response()->json([
            'success'      => true,
            'message'      => 'Marked as read',
            'unread_count' => $this->getUnreadCount(),
        ]);
    }

    // =============================================
    // MARK ALL AS READ
    // POST /api/notifications/read-all
    // =============================================
    public function markAllAsRead(): JsonResponse
    {
        $unreadIds = NotificationRecipient::where('user_id', auth()->id())
            ->where('is_read', false)
            ->pluck('notification_id');

        NotificationRecipient::where('user_id', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);

        // Update read counts
        Notification::whereIn('id', $unreadIds)->each(fn($n) => $n->increment('read_count'));

        return response()->json([
            'success'      => true,
            'message'      => 'All notifications marked as read',
            'unread_count' => 0,
        ]);
    }

    // =============================================
    // DELETE NOTIFICATION
    // DELETE /api/notifications/{id}
    // =============================================
    public function destroy(int $id): JsonResponse
    {
        NotificationRecipient::where('user_id', auth()->id())
            ->where('notification_id', $id)
            ->delete();

        return response()->json([
            'success' => true,
            'message' => 'Notification deleted',
        ]);
    }

    // =============================================
    // DELETE ALL NOTIFICATIONS
    // DELETE /api/notifications
    // =============================================
    public function destroyAll(): JsonResponse
    {
        NotificationRecipient::where('user_id', auth()->id())->delete();

        return response()->json([
            'success' => true,
            'message' => 'All notifications cleared',
        ]);
    }

    // =============================================
    // GET UNREAD COUNT
    // GET /api/notifications/unread-count
    // =============================================
    public function unreadCount(): JsonResponse
    {
        return response()->json([
            'success'      => true,
            'unread_count' => $this->getUnreadCount(),
        ]);
    }

    // =============================================
    // GET/UPDATE NOTIFICATION SETTINGS
    // GET /api/notifications/settings
    // =============================================
    public function getSettings(): JsonResponse
    {
        $settings = auth()->user()->notificationSettings
            ?? new UserNotificationSetting(['user_id' => auth()->id()]);

        return response()->json([
            'success' => true,
            'data'    => $settings,
        ]);
    }

    // =============================================
    // UPDATE SETTINGS
    // PUT /api/notifications/settings
    // =============================================
    public function updateSettings(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'admission'      => 'boolean',
            'course'         => 'boolean',
            'webinar'        => 'boolean',
            'workshop'       => 'boolean',
            'demo_class'     => 'boolean',
            'invoice'        => 'boolean',
            'reward'         => 'boolean',
            'achievement'    => 'boolean',
            'transfer'       => 'boolean',
            'spend_time'     => 'boolean',
            'chat'           => 'boolean',
            'custom'         => 'boolean',
            'push_enabled'   => 'boolean',
            'in_app_enabled' => 'boolean',
        ]);

        $settings = UserNotificationSetting::updateOrCreate(
            ['user_id' => auth()->id()],
            $validated
        );

        return response()->json([
            'success' => true,
            'message' => 'Notification settings updated',
            'data'    => $settings,
        ]);
    }

    // =============================================
    // ADMIN - GET ALL NOTIFICATIONS
    // GET /api/admin/notifications
    // =============================================
    public function adminIndex(Request $request): JsonResponse
    {
        $notifications = Notification::with('creator')
            ->when($request->category, fn($q) => $q->where('category', $request->category))
            ->when($request->type, fn($q) => $q->where('type', $request->type))
            ->when($request->search, fn($q) => $q->where('title', 'like', "%{$request->search}%"))
            ->latest()
            ->paginate($request->per_page ?? 20);

        return response()->json([
            'success' => true,
            'data'    => $notifications,
        ]);
    }

    // =============================================
    // ADMIN - SEND CUSTOM NOTIFICATION
    // POST /api/admin/notifications/send
    // =============================================
    public function sendCustom(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'body'         => 'required|string',
            'type'         => 'required|in:push,in_app,both',
            'target_type'  => 'required|in:all,role,specific',
            'target_role'  => 'required_if:target_type,role|in:admin,staff,teacher',
            'user_ids'     => 'required_if:target_type,specific|array',
            'user_ids.*'   => 'exists:users,id',
            'screen'       => 'nullable|string',
            'screen_id'    => 'nullable|string',
            'scheduled_at' => 'nullable|date|after:now',
        ]);

        $notification = $this->service->send(array_merge($validated, [
            'category'    => 'custom',
            'action_type' => 'custom',
        ]));

        return response()->json([
            'success'      => true,
            'message'      => $notification->is_scheduled
                ? 'Notification scheduled successfully'
                : 'Notification sent successfully',
            'notification' => $notification,
        ]);
    }

    // =============================================
    // ADMIN - GET NOTIFICATION STATS
    // GET /api/admin/notifications/{id}/stats
    // =============================================
    public function stats(int $id): JsonResponse
    {
        $notification = Notification::with(['recipients'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data'    => [
                'notification' => $notification,
                'stats'        => [
                    'total_recipients' => $notification->recipients->count(),
                    'sent_count'       => $notification->sent_count,
                    'read_count'       => $notification->read_count,
                    'failed_count'     => $notification->failed_count,
                    'read_rate'        => $notification->sent_count > 0
                        ? round(($notification->read_count / $notification->sent_count) * 100, 2) . '%'
                        : '0%',
                ],
            ],
        ]);
    }

    // =============================================
    // ADMIN - DELETE NOTIFICATION
    // DELETE /api/admin/notifications/{id}
    // =============================================
    public function adminDestroy(int $id): JsonResponse
    {
        Notification::findOrFail($id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Notification deleted',
        ]);
    }

    // =============================================
    // PRIVATE HELPERS
    // =============================================
    private function getUnreadCount(): int
    {
        return NotificationRecipient::where('user_id', auth()->id())
            ->where('is_read', false)
            ->count();
    }
}
