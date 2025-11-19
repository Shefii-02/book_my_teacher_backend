<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    private $dummyNotifications = [
        [
            "id" => 1,
            "title" => "New Student Joined!",
            "message" => "A student has enrolled in your Mathematics class.",
            "is_read" => false,
            "time" => "2025-11-19 10:20 AM"
        ],
        [
            "id" => 2,
            "title" => "Profile Approved",
            "message" => "Your teacher profile has been successfully approved.",
            "is_read" => false,
            "time" => "2025-11-18 3:15 PM"
        ],
        [
            "id" => 3,
            "title" => "Demo Class Booked",
            "message" => "Parent has booked a demo class with you.",
            "is_read" => true,
            "time" => "2025-11-17 2:12 PM"
        ]
    ];

    // 🔹 GET /notifications/unread-count
    public function unreadCount()
    {
        $count = collect($this->dummyNotifications)
            ->where('is_read', false)
            ->count();

        return response()->json([
            'status' => 200,
            'count' => $count
        ]);
    }

    // 🔹 GET /notifications
    public function list()
    {
        return response()->json([
            'status' => 200,
            'notifications' => $this->dummyNotifications
        ]);
    }

    // 🔹 POST /notifications/mark-read/{id}
    public function markRead($id)
    {
      Log::alert('readed notification:');
      Log::info($id);
        // No DB → fake success
        return response()->json([
            'status' => 200,
            'message' => "Notification #$id marked as read"
        ]);
    }
}
