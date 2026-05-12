<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\TeacherClass;
use App\Models\TeacherEarning;
use App\Models\Workshop;
use App\Models\Webinar;
use App\Models\DemoClass;
use App\Models\TeacherCourse;
use Carbon\Carbon;

class StatisticsController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | OVERVIEW
        |--------------------------------------------------------------------------
        */

        $totalCourses = $user->CoursesLaunched->count();

        $totalStudents = TeacherCourse::where(
            'teacher_id',
            $user->id
        )
            ->withCount('enrollments')
            ->get()
            ->sum('enrollments_count');

        $totalClasses = TeacherClass::where('teacher_id', $user->id)->count();

        $totalEarnings = TeacherEarning::where('teacher_id', $user->id)
            ->where('status', 'approved')
            ->sum('amount');

        /*
        |--------------------------------------------------------------------------
        | COURSES
        |--------------------------------------------------------------------------
        */

        $publishedCourses = $user->teacher?->courses()->where('status', 'published')->count();

        $draftCourses = $user->teacher->courses()
            ->where('status', 'draft')
            ->count();

        /*
        |--------------------------------------------------------------------------
        | LIVE SESSIONS
        |--------------------------------------------------------------------------
        */

        $totalWebinars = Webinar::where('host_id', $user->id)->count();

        $totalWorkshops = Workshop::where('host_id', $user->id)->count();

        $totalDemoClasses = DemoClass::where('host_id', $user->id)->count();

        /*
        |--------------------------------------------------------------------------
        | MONTHLY EARNINGS
        |--------------------------------------------------------------------------
        */

        $monthlyEarnings = TeacherEarning::selectRaw('MONTH(created_at) as month, SUM(amount) as total')
            ->where('teacher_id', $user->id)
            ->whereYear('created_at', now()->year)
            ->where('status', 'approved')
            ->groupBy('month')
            ->pluck('total', 'month');

        $earningsChart = [];

        for ($i = 1; $i <= 12; $i++) {

            $earningsChart[] = [
                'month' => Carbon::create()->month($i)->format('M'),
                'amount' => $monthlyEarnings[$i] ?? 0,
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | RECENT ACTIVITIES
        |--------------------------------------------------------------------------
        */

        $recentEarnings = TeacherEarning::where('teacher_id', $user->id)
            ->latest()
            ->take(10)
            ->get();

        $data = [
            'total_courses'       => $totalCourses,
            'published_courses'   => $publishedCourses,
            'draft_courses'       => $draftCourses,
            'total_students'      => $totalStudents,
            'total_classes'       => $totalClasses,
            'total_earnings'      => $totalEarnings,
            'total_webinars'      => $totalWebinars,
            'total_workshops'     => $totalWorkshops,
            'total_demo_classes'  => $totalDemoClasses,
        ];

        return view(
            'teacher.statistics.index',
            compact(
                'data',
                'earningsChart',
                'recentEarnings'
            )
        );
    }
}
