<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Webinar;
use Illuminate\Support\Facades\Config;

class ZegoTokenController extends Controller
{
    /**
     * Returns the token and appID to be used by Flutter client to join live streaming
     *
     * IMPORTANT: In production you must generate a short-lived token on the server
     * using ZEGOCLOUD server SDK or REST API with your server secret.
     *
     * This endpoint is a placeholder. Replace token generation with actual method per ZEGOCLOUD docs.
     */
    public function generate(Request $req, Webinar $webinar)
    {
        $req->validate([
            'user_id'=>'required|string',
            'user_name'=>'required|string',
            'role' => 'nullable|in:host,audience'
        ]);

        $appID = env('ZEGO_APP_ID');
        $serverSecret = env('ZEGO_SERVER_SECRET');

        // -------------------------
        // PLACEHOLDER TOKEN
        // -------------------------
        // For development only: DO NOT expose server secret to client.
        // Replace the following block with:
        //  - use ZEGOCLOUD server SDK to create a token for the user and room (live_id)
        //  - OR create JWT per ZEGOCLOUD guidance
        //
        // Example (pseudo):
        // $token = ZegoServerSDK::generateToken($appID, $serverSecret, $req->user_id, $webinar->live_id, $ttl);
        //
        // For now we return an object telling the client to use appSign in development.
        // -------------------------

        $response = [
            'appID' => (int)$appID,
            // dev-only: you may return APP_SIGN if you don't have server SDK. In production avoid this.
            'appSign' => env('ZEGO_APP_SIGN'),
            'liveID' => $webinar->live_id,
            'token' => null,
            'note' => 'Replace this endpoint with actual token generation using ZEGOCLOUD server SDK. See README in project.'
        ];

        return response()->json($response);
    }
}
