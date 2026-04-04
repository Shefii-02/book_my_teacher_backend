<?php

namespace App\Http\Controllers\ChatModule;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class MessageController extends Controller
{
    public function send(Request $req)
    {
        DB::connection('mysql2')->table('messages')->insert([
            'conversation_id' => $req->conversation_id,
            'sender_id'       => auth()->id(),
            'content'         => $req->content,
            'message_type'    => 'text',
            'created_at'      => now()
        ]);

        return response()->json(['status' => 'ok']);
    }

    public function delete($id)
    {
        DB::connection('mysql2')->table('messages')
            ->where('id', $id)
            ->delete();

        return response()->json(['deleted' => true]);
    }

    public function report($id)
    {
        DB::connection('mysql2')->table('message_report')->insert([
            'message_id' => $id,
            'reported_by'=> auth()->id(),
            'reported_at'=> now(),
            'status'     => 'pending'
        ]);

        return response()->json(['reported' => true]);
    }
}
