<?php

// namespace App\Http\Controllers\ChatModule;

// use App\Http\Controllers\Controller;
// use App\Models\ChatModule\Conversation;
// use App\Models\ChatModule\ConversationMember;
// use App\Models\ChatModule\MessageRead;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Redis;

// class ChatController extends Controller
// {
//   public function index()
//   {
//     $conversations = DB::connection('mysql2')->table('conversations')->get();
//     return view('company.chat.index', compact('conversations'));
//   }

//   public function show($id)
//   {
//     $messages = DB::connection('mysql2')->table('messages')
//       ->where('conversation_id', $id)
//       ->orderBy('id', 'asc')
//       ->get();

//     return view('chat.show', compact('messages', 'id'));
//   }

//   public function send(Request $req)
//   {
//     $msg = DB::connection('mysql2')->table('messages')->insertGetId([
//       'conversation_id' => $req->conversation_id,
//       'sender_id' => auth()->user()->id,
//       'content' => $req->message,
//       'message_type' => 'text',
//       'created_at' => now()
//     ]);

//     $message = DB::table('messages')->where('id', $msg)->first();

//     // 🔥 Redis Publish
//     Redis::publish('chat', json_encode([
//       'type' => 'message',
//       'data' => $message
//     ]));

//     return response()->json($message);
//   }

//   public function delete(Request $req)
//   {
//     DB::connection('mysql2')->table('messages')->where('id', $req->id)->delete();

//     Redis::publish('chat', json_encode([
//       'type' => 'delete',
//       'data' => ['id' => $req->id]
//     ]));

//     return response()->json(['success' => true]);
//   }

//   public function report(Request $req)
//   {
//     DB::connection('mysql2')->table('message_report')->insert([
//       'message_id' => $req->id,
//       'reported_by' => auth()->user()->id(),
//       'reported_at' => now(),
//       'status' => 'pending'
//     ]);

//     return response()->json(['success' => true]);
//   }
//   // public function getConversations(Request $req)
//   // {
//   //   $query = DB::connection('mysql2')
//   //     ->table('conversations as c')
//   //     ->leftJoin('labeled_conversation as cl', 'cl.conversation_id', '=', 'c.id')
//   //     ->leftJoin('conversation_labels as l', 'l.id', '=', 'cl.label_id')
//   //     ->leftJoin('messages as m', 'm.conversation_id', '=', 'c.id')
//   //     ->select(
//   //       'c.*',
//   //       DB::raw('MAX(m.created_at) as last_time'),
//   //       DB::raw('GROUP_CONCAT(l.name) as labels')
//   //     )
//   //     ->groupBy('c.id');

//   //   if ($req->label) {
//   //     $query->where('l.name', $req->label);
//   //   }

//   //   return response()->json(
//   //     $query->orderByDesc('last_time')->get()
//   //   );
//   // }
//   public function getConversations()
//   {
//     $userId = auth()->user()->id;

//     $conversations = ConversationMember::with([
//       'messages' => function ($q) {
//         $q->latest()->limit(1);
//       },
//       'user',
//       // 'lastMessage'
//     ])
//       // ->withMax('messages', 'created_at') // ✅ important

//       ->where('user_id', '!=', $userId)
//       // ->orderByDesc('messages_max_created_at') // ✅ WhatsApp style sorting
//       // better than created_at
//       ->get()



//       ->map(function ($c) use ($userId) {

//         $last = $c->messages->first();

//         // ✅ FIX 1: correct read check
//         $isRead = false;

//         if ($last) {
//           $isRead = DB::connection('mysql2')
//             ->table('message_reads')
//             ->where('message_id', $last->id)
//             ->where('user_id', $userId)
//             ->exists();
//         }

//         // ✅ FIX 2: correct unread count
//         $unreadCount = DB::connection('mysql2')
//           ->table('messages as m')
//           ->leftJoin('message_reads as r', function ($join) use ($userId) {
//             $join->on('m.id', '=', 'r.message_id')
//               ->where('r.user_id', '=', $userId);
//           })
//           ->where('m.conversation_id', $c->id)
//           ->where('m.sender_id', '!=', $userId)
//           ->whereNull('r.id') // NOT read
//           ->count();

//         // ✅ Get other user (for direct chat)
//         $otherUser = $c->users->firstWhere('id', '!=', $userId);

//         return [
//           'id'           => $c->conversation_id,
//           'name'         => $c->user?->name ?? 'Chat',
//           'avatar'       => $c->user?->avatar_url ?? 'https://ui-avatars.com/api/' . trim($c->user?->name) ?? 'Chat',
//           'acc_type'     => $c->user?->role ?? 'user',
//           'last_message' => $last?->content ?? '',
//           'last_time'    => $c->user?->last_seen ?? '',
//           'is_read'      => $isRead,
//           'unread_count' => $unreadCount,
//           'labels'       => $c->labels ?? [],
//         ];
//       });


//     // ->map(function ($m) use ($userId) {

//     //   $isRead = DB::connection('mysql2')
//     //     ->table('message_reads')
//     //     ->where('message_id', $m->id)
//     //     ->where('user_id', $userId)
//     //     ->exists();

//     //   return [
//     //     'id'        => $m->id,
//     //     'content'   => $m->content,
//     //     'sender_id' => $m->sender_id,
//     //     'time'      => date('H:i', strtotime($m->created_at)),
//     //     'is_read'   => $isRead,

//     //     'name'         => $c->user?->name ?? 'User #' . $c->user_id,
//     //     'avatar'       => $c->user?->avatar_url ?? null,
//     //     'last_message' => $last?->content ?? '',
//     //     'last_time'    => $last?->created_at?->diffForHumans() ?? '',
//     //     'unread_count' => $c->messages()
//     //       ->where('sender_id', '!=', auth()->user()->id)
//     //       ->whereNull('read_at')
//     //       ->count(),
//     //     'labels'       => $c->labels ?? '',
//     //   ];
//     // });

//     return response()->json($conversations);
//   }

//   /**
//    * Load messages for a given conversation.
//    */
//   public function messages(int $conversationId)
//   {
//     $userId = auth()->user()->id;

//     $conversation = Conversation::findOrFail($conversationId);

//     // ✅ Get messages
//     $messages = $conversation->messages()
//       ->orderBy('created_at')
//       ->get();

//     // ✅ Insert read records (IMPORTANT FIX)
//     foreach ($messages as $msg) {
//       if ($msg->sender_id != $userId) {

//         MessageRead::firstOrCreate([
//           'message_id' => $msg->id,
//           'user_id'    => $userId,
//         ], [
//           'read_at' => now()
//         ]);
//       }
//     }

//     // ✅ Format response
//     $formatted = $messages->map(function ($m) use ($userId) {

//       return [
//         'id'         => $m->id,
//         'content'    => $m->content,
//         'sender_id'  => $m->sender_id,
//         'created_at' => $m->created_at->format('H:i'),

//         // ✅ soft delete
//         'is_deleted' => !is_null($m->deleted_at),

//         // ✅ reported check (if column exists)
//         'reported'   => !is_null($m->reported_at),

//         // ✅ read status
//         'is_read'    => $m->reads()
//           ->where('user_id', $userId)
//           ->exists(),
//       ];
//     });

//     return response()->json($formatted);
//   }

//   public function labels()
//   {
//     return DB::connection('mysql2')->table('conversation_labels')->get();
//   }

//   public function addLabel(Request $req)
//   {
//     DB::connection('mysql2')->table('conversation_label')->insert([
//       'conversation_id' => $req->conversation_id,
//       'label_id'        => $req->label_id
//     ]);

//     return ['success' => true];
//   }
// }



namespace App\Http\Controllers\ChatModule;

use App\Http\Controllers\Controller;
use App\Models\ChatModule\ConversationMember;
use App\Models\ChatModule\MessageRead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    public function index()
    {
        return view('company.chat.index');
    }

    // ✅ GET CONVERSATIONS
    public function getConversations()
    {
        $userId = auth()->id();

        $conversations = DB::connection('mysql2')
            ->table('conversation_members as cm')
            ->join('users as u', 'u.id', '=', 'cm.user_id')
            ->where('cm.user_id', '!=', $userId)
            ->get()
            ->map(function ($c) use ($userId) {

                // last message
                $last = DB::connection('mysql2')
                    ->table('messages')
                    ->where('conversation_id', $c->conversation_id)
                    ->latest()
                    ->first();

                // unread count
                $unread = DB::connection('mysql2')
                    ->table('messages as m')
                    ->leftJoin('message_reads as r', function ($join) use ($userId) {
                        $join->on('m.id', '=', 'r.message_id')
                            ->where('r.user_id', $userId);
                    })
                    ->where('m.conversation_id', $c->conversation_id)
                    ->where('m.sender_id', '!=', $userId)
                    ->whereNull('r.id')
                    ->count();

                return [
                    'id' => $c->conversation_id,
                    'name' => $c->name ?? 'User',
                    'avatar' => $c->avatar ?? 'https://i.pravatar.cc/40?u='.$c->id,
                    'last_message' => $last?->content ?? '',
                    'last_time' => $last?->created_at ? date('H:i', strtotime($last->created_at)) : '',
                    'unread_count' => $unread
                ];
            });

        return response()->json($conversations);
    }

    // ✅ GET MESSAGES (OPTIMIZED)
    public function messages($conversationId, Request $req)
    {
        $userId = auth()->id();
        $lastId = $req->last_id;

        $query = DB::connection('mysql2')
            ->table('messages')
            ->where('conversation_id', $conversationId)
            ->orderBy('id');

        if ($lastId) {
            $query->where('id', '>', $lastId);
        }

        $messages = $query->get();

        // mark read
        foreach ($messages as $msg) {
            if ($msg->sender_id != $userId) {
                DB::connection('mysql2')
                    ->table('message_reads')
                    ->updateOrInsert([
                        'message_id' => $msg->id,
                        'user_id' => $userId
                    ], [
                        'read_at' => now()
                    ]);
            }
        }

        return response()->json($messages->map(function ($m) use ($userId) {
            return [
                'id' => $m->id,
                'content' => $m->content,
                'sender_id' => $m->sender_id,
                'created_at' => date('H:i', strtotime($m->created_at)),
                'is_deleted' => !is_null($m->deleted_at),
            ];
        }));
    }

    // ✅ SEND MESSAGE
    public function send(Request $req)
    {
        $id = DB::connection('mysql2')->table('messages')->insertGetId([
            'conversation_id' => $req->conversation_id,
            'sender_id' => auth()->id(),
            'content' => $req->message, // ✅ FIXED
            'created_at' => now()
        ]);

        return response()->json(
            DB::connection('mysql2')->table('messages')->where('id', $id)->first()
        );
    }

    // ✅ DELETE
    public function delete($id)
    {
        DB::connection('mysql2')->table('messages')
            ->where('id', $id)
            ->update(['deleted_at' => now()]);

        return ['success' => true];
    }

    // ✅ REPORT
    public function report($id)
    {
        DB::connection('mysql2')->table('message_report')->insert([
            'message_id' => $id,
            'reported_by' => auth()->id(), // ✅ FIXED
            'created_at' => now()
        ]);

        return ['success' => true];
    }
}