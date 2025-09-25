<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Webinar;
use Illuminate\Http\Request;

class WebinarController extends Controller
{
    // List webinars
    public function index(Request $request)
    {
        $accType = $request->query('acc_type'); // teacher, student, guest

        $webinars = Webinar::with(['provider', 'registrations.user'])
            ->when($accType, function ($query, $accType) {
                if ($accType === 'teacher') {
                    $query->where('is_teacher_allowed', true);
                } elseif ($accType === 'student') {
                    $query->where('is_student_allowed', true);
                } elseif ($accType === 'guest') {
                    $query->where('is_guest_allowed', true);
                }
            })
            ->latest()
            ->get();

        return response()->json([
            'status' => true,
            'data' => $webinars
        ]);
    }

    // Show single webinar details
    public function show($id)
    {
        $webinar = Webinar::with([
            'provider',
            'registrations.user',
            'host'
        ])->findOrFail($id);

        return response()->json([
            'status' => true,
            'data' => $webinar
        ]);
    }

    // Live screen details (room ID, token, provider credentials)
    public function liveDetails($id)
    {
        $webinar = Webinar::with('provider')->findOrFail($id);

        // Here you’d call your provider’s SDK/ServerAssistant to generate secure token
        $token = 'sample-generated-token';

        return response()->json([
            'status' => true,
            'data' => [
                'webinar_id' => $webinar->id,
                'title' => $webinar->title,
                'provider' => $webinar->provider->name,
                'room_id' => $webinar->live_id,
                'token' => $token,
                'meeting_url' => $webinar->meeting_url,
            ]
        ]);
    }
}
