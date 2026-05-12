<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\SubjectReview;
use App\Models\TeacherCourse;
use App\Services\TeacherProfileCompletionService;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | BASIC STATS
        |--------------------------------------------------------------------------
        */

        $data['courses']['total'] =
            $user->CoursesLaunched->count() ?? 0;

        $data['referral']['total'] =
            $user->referrals->count() ?? 0;

        $data['coins']['total'] =
            $user->wallet->green_balance ?? 0;

        $data['earns']['total'] =
            $user->teacherEarnings()
            ->where('status', 'completed')
            ->sum('amount') ?? 0;

        /*
        |--------------------------------------------------------------------------
        | EXTRA STATS
        |--------------------------------------------------------------------------
        */

        // Total Students
        $data['students']['total'] = TeacherCourse::where(
            'teacher_id',
            $user->id
        )
            ->withCount('enrollments')
            ->get()
            ->sum('enrollments_count');

        // Average Rating
        $data['rating']['average'] = number_format(
            SubjectReview::where('teacher_id', $user->id)
                ->avg('rating') ?? 0,
            1
        );

        /*
        |--------------------------------------------------------------------------
        | PROFILE COMPLETION
        |--------------------------------------------------------------------------
        */

        $profileCompletion =
            TeacherProfileCompletionService::calculate($user);

        /*
        |--------------------------------------------------------------------------
        | LAST 6 MONTHS EARNINGS
        |--------------------------------------------------------------------------
        */

        $last6MonthLabels = [];
        $last6MonthData = [];

        for ($i = 5; $i >= 0; $i--) {

            $month = Carbon::now()->subMonths($i);

            $monthTotal = $user->teacherEarnings()
                ->where('status', 'completed')
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->sum('amount');

            $last6MonthLabels[] = $month->format('M');

            $last6MonthData[] = $monthTotal;
        }

        /*
        |--------------------------------------------------------------------------
        | YEARLY EARNINGS
        |--------------------------------------------------------------------------
        */

        $yearLabels = [];
        $yearData = [];

        for ($i = 4; $i >= 0; $i--) {

            $year = Carbon::now()->subYears($i)->year;

            $yearTotal = $user->teacherEarnings()
                ->where('status', 'completed')
                ->whereYear('created_at', $year)
                ->sum('amount');

            $yearLabels[] = $year;

            $yearData[] = $yearTotal;
        }

        /*
        |--------------------------------------------------------------------------
        | RECENT EARNINGS
        |--------------------------------------------------------------------------
        */

        $recentEarnings = $user->teacherEarnings()
            ->latest()
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | TOP COURSES
        |--------------------------------------------------------------------------
        */

        $topCourses = $user->CoursesLaunched
            ->withCount('enrollments')
            ->orderByDesc('enrollments_count')
            ->take(5);

        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */

        return view('teacher.dashboard.index', compact(
            'data',
            'profileCompletion',
            'last6MonthLabels',
            'last6MonthData',
            'yearLabels',
            'yearData',
            'recentEarnings',
            'topCourses'
        ));
    }
}
