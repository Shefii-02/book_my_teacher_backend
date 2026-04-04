<?php

namespace App\Http\Controllers\ChatModule;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class LabelController extends Controller
{
    public function assign(Request $req)
    {
        DB::connection('mysql2')->table('conversation_label')
            ->insert([
                'conversation_id' => $req->conversation_id,
                'label_id'        => $req->label_id
            ]);

        return response()->json(['status' => true]);
    }

    public function remove(Request $req)
    {
        DB::connection('mysql2')->table('conversation_label')
            ->where('conversation_id', $req->conversation_id)
            ->where('label_id', $req->label_id)
            ->delete();

        return response()->json(['status' => true]);
    }
}
