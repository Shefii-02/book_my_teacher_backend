<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\NotificationRecipient;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $notifications = NotificationRecipient::with([
                'notification',
            ])
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(20);

        $data = [

            'total_notifications' => NotificationRecipient::where('user_id', $user->id)->count(),

            'read_notifications' => NotificationRecipient::where('user_id', $user->id)
                ->where('is_read', 1)
                ->count(),

            'unread_notifications' => NotificationRecipient::where('user_id', $user->id)
                ->where('is_read', 0)
                ->count(),

            'push_failed' => NotificationRecipient::where('user_id', $user->id)
                ->where('is_push_failed', 1)
                ->count(),

        ];

        return view(
            'teacher.notifications.index',
            compact(
                'notifications',
                'data'
            )
        );
    }

    public function markAsRead($id)
    {
        $user = auth()->user();

        $notification = NotificationRecipient::where('user_id', $user->id)
            ->where('id', $id)
            ->firstOrFail();

        $notification->update([
            'is_read' => 1,
            'read_at' => now(),
        ]);

        return back()->with('success', 'Notification marked as read.');
    }

    public function markAllAsRead()
    {
        $user = auth()->user();

        NotificationRecipient::where('user_id', $user->id)
            ->where('is_read', 0)
            ->update([
                'is_read' => 1,
                'read_at' => now(),
            ]);

        return back()->with('success', 'All notifications marked as read.');
    }
}
