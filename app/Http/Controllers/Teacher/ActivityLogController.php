<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\ActivityEvent;
use App\Models\ActivityLog;
use App\Models\LoginActivity;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | Activity Logs
        |--------------------------------------------------------------------------
        */
        $activityLogs = ActivityLog::where('user_id', $user->id)
            ->latest()
            ->get()
            ->map(function ($log) {

                return [

                    'type' => 'activity',

                    'title' => $log->action,

                    'description' => $log->notes,

                    'reference_name' => $log->reference_name,

                    'reference_url' => $log->reference_url,

                    'platform' => $log->platform,

                    'device' => $log->device,

                    'ip_address' => $log->ip_address,

                    'created_at' => $log->created_at,

                    'icon' => 'ni ni-active-40',

                    'color' => 'blue',

                ];
            });

        /*
        |--------------------------------------------------------------------------
        | Login Activities
        |--------------------------------------------------------------------------
        */
        $loginActivities = LoginActivity::where('user_id', $user->id)
            ->latest()
            ->get()
            ->map(function ($login) {

                return [

                    'type' => 'login',

                    'title' => 'User Login',

                    'description' => $login->email,

                    'reference_name' => $login->provider,

                    'reference_url' => null,

                    'platform' => $login->source,

                    'device' => $login->user_agent,

                    'ip_address' => $login->ip_address,

                    'created_at' => $login->logged_in_at,

                    'icon' => 'ni ni-key-25',

                    'color' => 'emerald',

                ];
            });

        /*
        |--------------------------------------------------------------------------
        | Events
        |--------------------------------------------------------------------------
        */
        $events = ActivityEvent::where('user_id', $user->id)
            ->latest()
            ->get()
            ->map(function ($event) {

                return [

                    'type' => 'event',

                    'title' => $event->event,

                    'description' => is_array($event->meta_json)
                        ? json_encode($event->meta_json)
                        : $event->meta_json,

                    'reference_name' => null,

                    'reference_url' => null,

                    'platform' => $event->platform,

                    'device' => '-',

                    'ip_address' => $event->ip_address,

                    'created_at' => $event->created_at,

                    'icon' => 'ni ni-world',

                    'color' => 'orange',

                ];
            });

        /*
        |--------------------------------------------------------------------------
        | Merge Timeline
        |--------------------------------------------------------------------------
        */
        $activities = collect()
            ->merge($activityLogs)
            ->merge($loginActivities)
            ->merge($events)
            ->sortByDesc('created_at')
            ->values();

        /*
        |--------------------------------------------------------------------------
        | Statistics
        |--------------------------------------------------------------------------
        */
        $data = [

            'total_logs' => $activityLogs->count(),

            'total_logins' => $loginActivities->count(),

            'total_events' => $events->count(),

            'today_activities' => $activities
                ->where('created_at', '>=', now()->startOfDay())
                ->count(),

        ];

        return view(
            'teacher.activity_logs.index',
            compact(
                'activities',
                'data'
            )
        );
    }
}
