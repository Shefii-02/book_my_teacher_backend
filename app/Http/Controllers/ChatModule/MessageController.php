<?php

// namespace App\Http\Controllers\ChatModule;

// use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;


// class MessageController extends Controller
// {
//     public function send(Request $req)
//     {
//         DB::connection('mysql2')->table('messages')->insert([
//             'conversation_id' => $req->conversation_id,
//             'sender_id'       => auth()->id(),
//             'content'         => $req->content,
//             'message_type'    => 'text',
//             'created_at'      => now()
//         ]);

//         return response()->json(['status' => 'ok']);
//     }

//     public function delete($id)
//     {
//         DB::connection('mysql2')->table('messages')
//             ->where('id', $id)
//             ->delete();

//         return response()->json(['deleted' => true]);
//     }

//     public function report($id)
//     {
//         DB::connection('mysql2')->table('message_report')->insert([
//             'message_id' => $id,
//             'reported_by'=> auth()->id(),
//             'reported_at'=> now(),
//             'status'     => 'pending'
//         ]);

//         return response()->json(['reported' => true]);
//     }
// }


namespace App\Http\Controllers\ChatModule;

use App\Http\Controllers\Controller;
use App\Models\ChatModule\MessageRead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    /**
     * Send a message and persist to mysql2.
     * Returns the saved message so the frontend can swap the temp ID.
     */
    public function send(Request $request)
    {
        $request->validate([
            'conversation_id' => 'required|integer',
            'content'         => 'required|string|max:5000',
        ]);

        $id = DB::connection('mysql2')->table('messages')->insertGetId([
            'conversation_id' => $request->conversation_id,
            'sender_id'       => auth()->id(),
            'content'         => $request->content,
            'message_type'    => 'text',
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);

        $message = DB::connection('mysql2')
            ->table('messages')
            ->where('id', $id)
            ->first();

        // Mark as read for the sender immediately
        MessageRead::firstOrCreate(
            ['message_id' => $id, 'user_id' => auth()->id()],
            ['read_at' => now()]
        );

        return response()->json([
            'id'         => $message->id,
            'content'    => $message->content,
            'sender_id'  => $message->sender_id,
            'created_at' => now()->format('H:i'),
            'is_deleted' => false,
            'reported'   => false,
            'is_read'    => true,
        ]);
    }

    /**
     * Load all messages for a conversation, marking unread ones as read.
     */
    public function messages(int $conversationId)
    {
        $userId = auth()->id();

        // Verify the user is a member of this conversation
        $isMember = DB::connection('mysql2')
            ->table('conversation_members')
            ->where('conversation_id', $conversationId)
            ->where('user_id', $userId)
            ->exists();

        if (! $isMember) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        $messages = DB::connection('mysql2')
            ->table('messages')
            ->where('conversation_id', $conversationId)
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'asc')
            ->get();

        // Batch mark as read (messages not sent by me that haven't been read yet)
        $unreadIds = $messages
            ->where('sender_id', '!=', $userId)
            ->pluck('id');

        if ($unreadIds->isNotEmpty()) {
            $alreadyRead = DB::connection('mysql2')
                ->table('message_reads')
                ->where('user_id', $userId)
                ->whereIn('message_id', $unreadIds)
                ->pluck('message_id');

            $toMark = $unreadIds->diff($alreadyRead);

            if ($toMark->isNotEmpty()) {
                $inserts = $toMark->map(fn($mid) => [
                    'message_id' => $mid,
                    'user_id'    => $userId,
                    'read_at'    => now(),
                ])->values()->toArray();

                DB::connection('mysql2')->table('message_reads')->insert($inserts);
            }
        }

        // Format for the frontend
        $formatted = $messages->map(function ($m) use ($userId) {
            $isRead = DB::connection('mysql2')
                ->table('message_reads')
                ->where('message_id', $m->id)
                ->where('user_id', $userId)
                ->exists();

            $reported = DB::connection('mysql2')
                ->table('message_report')
                ->where('message_id', $m->id)
                ->where('reported_by', $userId)
                ->exists();

            return [
                'id'         => $m->id,
                'content'    => $m->content,
                'sender_id'  => $m->sender_id,
                'created_at' => date('H:i', strtotime($m->created_at)),
                'is_deleted' => ! is_null($m->deleted_at),
                'reported'   => $reported,
                'is_read'    => $isRead,
            ];
        });

        return response()->json($formatted);
    }

    /**
     * Soft-delete a message (sets deleted_at).
     */
    public function delete(int $id)
    {
        $userId = auth()->id();

        $message = DB::connection('mysql2')
            ->table('messages')
            ->where('id', $id)
            ->first();

        if (! $message) {
            return response()->json(['error' => 'Not found'], 404);
        }

        // Only the sender can delete their own message
        if ($message->sender_id != $userId) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        DB::connection('mysql2')
            ->table('messages')
            ->where('id', $id)
            ->update(['deleted_at' => now()]);

        return response()->json(['deleted' => true]);
    }

    /**
     * Report a message.
     */
    public function report(int $id)
    {
        $userId = auth()->id();

        // Prevent duplicate reports
        $already = DB::connection('mysql2')
            ->table('message_report')
            ->where('message_id', $id)
            ->where('reported_by', $userId)
            ->exists();

        if ($already) {
            return response()->json(['reported' => true, 'duplicate' => true]);
        }

        DB::connection('mysql2')->table('message_report')->insert([
            'message_id'  => $id,
            'reported_by' => $userId,
            'reported_at' => now(),
            'status'      => 'pending',
        ]);

        return response()->json(['reported' => true]);
    }
}