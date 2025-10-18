<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserActivityController extends Controller
{
    public function store(Request $request)
    {
        UserActivity::create([
            'user_id' => Auth::id() ?? $request->user_id,
            'action' => $request->action,
            'details' => $request->details,
            'page' => $request->page,
            'device_info' => $request->header('User-Agent'),
            'ip_address' => $request->ip(),
        ]);

        return response()->json(['message' => 'Activity logged successfully']);
    }
}
