<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\WebinarResource;
use App\Models\Webinar;
use Illuminate\Http\Request;
use App\Services\ZegoTokenService;
use Illuminate\Support\Facades\Log;

class WebinarController extends Controller
{

  // List webinars
  public function index(Request $request)
  {
    Log::info('************************');
    Log::info('//Webinar Requests');
    Log::info($request->header());
    Log::info($request->all());
    Log::info('************************');

    $user = $request->user(); // current logged in user
    $accType = $request->input('acc_type'); // teacher/student/guest filter

    $query = Webinar::with(['streamProvider', 'host', 'registrations.user'])
      ->when($accType, function ($q) use ($accType) {
        $q->whereHas('registrations.user', function ($subQ) use ($accType) {
          $subQ->where('acc_type', $accType);
        });
      });

    $webinars = $query->latest()->get();

    $data = $webinars->map(function ($webinar) use ($user) {
      $isRegistered = $user
        ? $webinar->registrations()->where('user_id', $user->id)->exists()
        : false;

      $hasJoined = $user
        ? $webinar->registrations()
        ->where('user_id', $user->id)
        ->where('attended_status', true)
        ->exists()
        : false;

      return [
        'id' => $webinar->id,
        'title' => $webinar->title,
        'description' => $webinar->description,
        'thumbnail' => $webinar->thumbnail_image ? asset('storage/' . $webinar->thumbnail_image) : null,
        'main_image' => $webinar->main_image ? asset('storage/' . $webinar->main_image) : null,
        'start_at' => $webinar->started_at,
        'end_at' => $webinar->ended_at,
        'register_end_at' => $webinar->registration_end_at,
        'status' => $webinar->status,
        'is_registered' => $isRegistered,
        'has_joined' => $hasJoined,
        'stream_provider' => $webinar->streamProvider?->only(['id', 'name', 'slug', 'type']),
      ];
    });



    return response()->json([
      'status' => true,
      'data' => $data,
    ]);
  }

  // Show single webinar details
  public function show(Request $request, $id)
  {
    $user = $request->user();

    $webinar = Webinar::with(['streamProvider', 'host', 'registrations.user'])
      ->findOrFail($id);

    $isRegistered = $user
      ? $webinar->registrations()->where('user_id', $user->id)->exists()
      : false;

    $hasJoined = $user
      ? $webinar->registrations()
      ->where('user_id', $user->id)
      ->where('attended_status', true)
      ->exists()
      : false;

    return response()->json([
      'status' => true,
      'data' => [
        'id' => $webinar->id,
        'title' => $webinar->title,
        'description' => $webinar->description,
        'thumbnail' => $webinar->thumbnail_image ? asset('storage/' . $webinar->thumbnail_image) : null,
        'main_image' => $webinar->main_image ? asset('storage/' . $webinar->main_image) : null,
        'start_at' => $webinar->started_at,
        'end_at' => $webinar->ended_at,
        'register_end_at' => $webinar->registration_end_at,
        'status' => $webinar->status,
        'is_registered' => $isRegistered,
        'has_joined' => $hasJoined,
        'stream_provider' => $webinar->streamProvider?->only(['id', 'name', 'slug', 'type']),
        'meta' => $webinar->meta,
      ],
    ]);
  }


  // Live screen details (room ID, token, provider credentials)
  public function liveDetails(Request $request, $id)
  {

    $user = $request->user();
    $webinar = Webinar::with('streamProvider')->findOrFail($id);

    // Check registration
    $registration = $webinar->registrations()->where('user_id', $user->id)->first();
    if (!$registration) {
      return response()->json(['status' => false, 'message' => 'You are not registered'], 403);
    }

    // Mark as attended
    $registration->update(['attended_status' => true]);


    // $token = $zegoService->generateToken($user->id, $webinar->live_id);


    // Generate token (example, integrate Zego/Agora here)
    $liveData = new WebinarResource($webinar);



    return response()->json([
      'status' => true,
      'data' => $liveData,
    ]);
  }

  public function register(Request $request, $id)
  {
    $user = $request->user();
    $webinar = Webinar::findOrFail($id);

    // 1. Check registration deadline
    if ($webinar->registration_end_at && now()->gt($webinar->registration_end_at)) {
      return response()->json([
        'status' => false,
        'message' => 'Registration period has ended.',
      ], 400);
    }

    // 2. Check if already registered
    $exists = $webinar->registrations()->where('user_id', $user->id)->exists();
    if ($exists) {
      return response()->json([
        'status' => false,
        'message' => 'You are already registered for this webinar.',
      ], 400);
    }

    // 3. Max participants limit check
    if ($webinar->max_participants && $webinar->registrations()->count() >= $webinar->max_participants) {
      return response()->json([
        'status' => false,
        'message' => 'This webinar has reached the maximum number of participants.',
      ], 400);
    }

    // 4. Create registration
    $registration = $webinar->registrations()->create([
      'user_id' => $user->id,
      'name'    => $user->name,
      'email'   => $user->email,
      'phone'   => $user->mobile ?? null,
      'checked_in' => false,
      'attended_status' => false,
    ]);

    return response()->json([
      'status' => true,
      'message' => 'Registration successful.',
      'data' => $registration,
    ]);
  }

  public function join(Request $request, $id)
  {
    $user = $request->user();
    $webinar = Webinar::with(['streamProvider', 'providerCredential'])->findOrFail($id);

    // 1. Ensure user registered
    $registration = $webinar->registrations()->where('user_id', $user->id)->first();
    if (!$registration) {
      return response()->json([
        'status' => false,
        'message' => 'You are not registered for this webinar.',
      ], 403);
    }

    // 2. Ensure webinar started
    if (!$webinar->started_at || now()->lt($webinar->started_at)) {
      return response()->json([
        'status' => false,
        'message' => 'The host has not started the webinar yet. Please wait.',
        'waiting' => true,
      ], 200);
    }

    // 3. Mark attendance
    $registration->update([
      'attended_status' => true,
      'checked_in' => true, // optional: auto-check-in when joining
    ]);

    // 4. Build stream data payload
    $streamData = [
      'provider' => $webinar->streamProvider->name ?? null,
      'meeting_url' => $webinar->meeting_url,
      'recording_url' => $webinar->recording_url,
      'credentials' => [
        'app_id' => $webinar->providerCredential->app_id ?? null,
        'server_secret' => $webinar->providerCredential->server_secret ?? null,
        'app_sign' => $webinar->providerCredential->app_sign ?? null,
      ],
      'meta' => $webinar->meta,
    ];

    return response()->json([
      'status' => true,
      'message' => 'Joined successfully.',
      'data' => [
        'webinar_id' => $webinar->id,
        'title' => $webinar->title,
        'description' => $webinar->description,
        'live_id' => $webinar->live_id,
        'started_at' => $webinar->started_at,
        'ended_at' => $webinar->ended_at,
        'stream' => $streamData,
      ]
    ]);
  }
}


// namespace App\Http\Controllers\Api;

// use App\Http\Controllers\Controller;
// use App\Http\Resources\WebinarResource;
// use App\Models\Webinar;
// use Illuminate\Http\Request;

// class WebinarController extends Controller
// {
//     // List webinars
//     public function index(Request $request)
//     {
//         $accType = $request->input('acc_type'); // teacher, student, guest

//         $webinars = Webinar::with(['provider', 'registrations.user', 'host'])
//             ->when($accType, function ($query, $accType) {
//                 if ($accType === 'teacher') {
//                     $query->where('is_teacher_allowed', true);
//                 } elseif ($accType === 'student') {
//                     $query->where('is_student_allowed', true);
//                 } elseif ($accType === 'guest') {
//                     $query->where('is_guest_allowed', true);
//                 }
//             })
//             ->latest()
//             ->get();

//         return response()->json([
//             'status' => true,
//             'data' => WebinarResource::collection($webinars)
//         ]);
//     }

//     // Show single webinar
//     public function show(Request $request, $id)
//     {
//         $webinar = Webinar::with(['provider', 'registrations.user', 'host'])
//             ->findOrFail($id);

//         return response()->json([
//             'status' => true,
//             'data' => new WebinarResource($webinar)
//         ]);
//     }

//     // Live screen details
//     public function liveDetails(Request $request, $id)
//     {
//         $webinar = Webinar::with('provider')->findOrFail($id);

//         // Example: generate secure token (replace with actual provider SDK)
//         $token = 'generated-secure-token';

//         return response()->json([
//             'status' => true,
//             'data' => [
//                 'webinar_id' => $webinar->id,
//                 'title' => $webinar->title,
//                 'provider' => $webinar->provider->name,
//                 'room_id' => $webinar->live_id,
//                 'token' => $token,
//                 'meeting_url' => $webinar->meeting_url,
//             ]
//         ]);
//     }
// }
