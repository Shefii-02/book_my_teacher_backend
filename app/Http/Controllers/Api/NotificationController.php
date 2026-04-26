<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NotificationRecipient;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
  /*
      GET /notifications
    */
  public function notifications(Request $request)
  {
    $user = $request->user();
    Log::info($user);
    $userId = $user->id;

    $rows = NotificationRecipient::with('notification')
      ->where('user_id', $userId)
      ->latest('id')
      ->get();

    $count = NotificationRecipient::where(
      'user_id',
      $userId
    )->where(
      'is_read',
      0
    )->count();


    $notifications = $rows->map(function ($row) {

      return [
        'id' => $row->id, // recipient row id
        'notification_id' => $row->notification_id,

        'title' => optional(
          $row->notification
        )->title,

        'message' => optional(
          $row->notification
        )->body,

        'is_read' => (bool)$row->is_read,

        'time' => optional(
          $row->created_at
        )?->format('Y-m-d h:i A'),

        'screen' => optional(
          $row->notification
        )->screen,

        'screen_id' => optional(
          $row->notification
        )->screen_id,

        'extra_data' => optional(
          $row->notification
        )->extra_data,
      ];
    });

    return response()->json([
      'status' => 200,
      'count' => $count,
      'notifications' => $notifications
    ]);
  }


  /*
      POST /notifications/mark-read/{id}
      id = notification_recipients.id
    */
  public function markRead(Request $request,$id)
  {
    $user = $request->user();
    $userId = $user->id;

    $recipient = NotificationRecipient::where(
      'id',
      $id
    )
      ->where(
        'user_id',
        $userId
      )
      ->firstOrFail();

    if (!$recipient->is_read) {

      $recipient->update([
        'is_read' => 1,
        'read_at' => now()
      ]);

      /*
             optional:
             increment parent read count
            */
      if ($recipient->notification) {
        $recipient->notification
          ->increment('read_count');
      }
    }

    return response()->json([
      'status' => 200,
      'message' => 'Marked as read'
    ]);
  }


  /*
      POST /notifications/mark-all-read
    */
  public function markAllRead(Request $request)
  {
    $user = $request->user();
    $userId = $user->id;

    NotificationRecipient::where(
      'user_id',
      $userId
    )
      ->where(
        'is_read',
        0
      )
      ->update([
        'is_read' => 1,
        'read_at' => now()
      ]);

    return response()->json([
      'status' => 200,
      'message' => 'All notifications marked read'
    ]);
  }
}
