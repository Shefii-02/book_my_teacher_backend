<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\DemoClass;
use App\Models\SubjectReview;
use App\Models\TeacherClass;
use App\Models\TeacherEarning;
use App\Models\WorkshopClass;
use Carbon\Carbon;

class PerformanceController extends Controller
{
    public function index()
    {
        $teacherId = auth()->id();

        /*
        |--------------------------------------------------------------------------
        | COURSE CLASS TOTAL MINUTES
        |--------------------------------------------------------------------------
        */

        $courseMinutes = TeacherClass::where('teacher_id', $teacherId)
            ->with('course_classes')
            ->get()
            ->flatMap(function ($teacherClass) {

                return $teacherClass->course_classes;

            })
            ->sum(function ($class) {

                if (!$class->start_time || !$class->end_time) {
                    return 0;
                }

                return Carbon::parse($class->start_time)
                    ->diffInMinutes(
                        Carbon::parse($class->end_time)
                    );

            });

        /*
        |--------------------------------------------------------------------------
        | WORKSHOP CLASS TOTAL MINUTES
        |--------------------------------------------------------------------------
        */

        $workshopMinutes = WorkshopClass::whereHas('workshop', function ($q) use ($teacherId) {

            $q->where('host_id', $teacherId);

        })
            ->get()
            ->sum(function ($class) {

                if (!$class->start_time || !$class->end_time) {
                    return 0;
                }

                return Carbon::parse($class->start_time)
                    ->diffInMinutes(
                        Carbon::parse($class->end_time)
                    );

            });

        /*
        |--------------------------------------------------------------------------
        | DEMO CLASS TOTAL MINUTES
        |--------------------------------------------------------------------------
        */

        $demoMinutes = DemoClass::where('host_id', $teacherId)
            ->get()
            ->sum(function ($class) {

                if (!$class->started_at || !$class->ended_at) {
                    return 0;
                }

                return Carbon::parse($class->started_at)
                    ->diffInMinutes(
                        Carbon::parse($class->ended_at)
                    );

            });

        /*
        |--------------------------------------------------------------------------
        | TOTAL TIME
        |--------------------------------------------------------------------------
        */

        $totalMinutes = $courseMinutes + $workshopMinutes + $demoMinutes;

        $hours = floor($totalMinutes / 60);

        $minutes = $totalMinutes % 60;

        /*
        |--------------------------------------------------------------------------
        | TOTAL COURSE SESSIONS
        |--------------------------------------------------------------------------
        */

        $totalCourseClasses = TeacherClass::where('teacher_id', $teacherId)
            ->with('course_classes')
            ->get()
            ->flatMap(function ($teacherClass) {

                return $teacherClass->course_classes;

            })
            ->count();

        /*
        |--------------------------------------------------------------------------
        | TOTAL WORKSHOP SESSIONS
        |--------------------------------------------------------------------------
        */

        $totalWorkshopClasses = WorkshopClass::whereHas('workshop', function ($q) use ($teacherId) {

            $q->where('host_id', $teacherId);

        })->count();

        /*
        |--------------------------------------------------------------------------
        | TOTAL DEMO SESSIONS
        |--------------------------------------------------------------------------
        */

        $totalDemoClasses = DemoClass::where('host_id', $teacherId)
            ->count();

        /*
        |--------------------------------------------------------------------------
        | TOTAL SESSIONS
        |--------------------------------------------------------------------------
        */

        $totalSessions =
            $totalCourseClasses +
            $totalWorkshopClasses +
            $totalDemoClasses;

        /*
        |--------------------------------------------------------------------------
        | AVERAGE RATING
        |--------------------------------------------------------------------------
        */

        $averageRating = SubjectReview::where('teacher_id', $teacherId)
            ->avg('rating');

        $averageRating = number_format($averageRating ?? 0, 1);

        /*
        |--------------------------------------------------------------------------
        | TOTAL GROWTH / EARNINGS
        |--------------------------------------------------------------------------
        */

        $totalGrowth = TeacherEarning::where('teacher_id', $teacherId)
            ->where('status', 'completed')
            ->sum('amount');

        /*
        |--------------------------------------------------------------------------
        | MONTHLY PERFORMANCE
        |--------------------------------------------------------------------------
        */

        $performances = collect();

        for ($i = 5; $i >= 0; $i--) {

            $monthStart = Carbon::now()
                ->subMonths($i)
                ->startOfMonth();

            $monthEnd = Carbon::now()
                ->subMonths($i)
                ->endOfMonth();

            /*
            |--------------------------------------------------------------------------
            | MONTHLY COURSES
            |--------------------------------------------------------------------------
            */

            $courses =  auth()->user()->courses()
                ->whereBetween('started_at', [$monthStart, $monthEnd])
                ->count();

            /*
            |--------------------------------------------------------------------------
            | MONTHLY COURSE SESSIONS
            |--------------------------------------------------------------------------
            */

            $monthlyCourseSessions = TeacherClass::where('teacher_id', $teacherId)
                ->with([
                    'course_classes' => function ($q) use ($monthStart, $monthEnd) {

                        $q->whereBetween('created_at', [$monthStart, $monthEnd]);

                    }
                ])
                ->get()
                ->flatMap(function ($teacherClass) {

                    return $teacherClass->course_classes;

                })
                ->count();

            /*
            |--------------------------------------------------------------------------
            | MONTHLY WORKSHOP SESSIONS
            |--------------------------------------------------------------------------
            */

            $monthlyWorkshopSessions = WorkshopClass::whereHas('workshop', function ($q) use ($teacherId) {

                $q->where('host_id', $teacherId);

            })
                ->whereBetween('created_at', [$monthStart, $monthEnd])
                ->count();

            /*
            |--------------------------------------------------------------------------
            | MONTHLY DEMO SESSIONS
            |--------------------------------------------------------------------------
            */

            $monthlyDemoSessions = DemoClass::where('host_id', $teacherId)
                ->whereBetween('created_at', [$monthStart, $monthEnd])
                ->count();

            /*
            |--------------------------------------------------------------------------
            | TOTAL MONTHLY SESSIONS
            |--------------------------------------------------------------------------
            */

            $sessions =
                $monthlyCourseSessions +
                $monthlyWorkshopSessions +
                $monthlyDemoSessions;

            /*
            |--------------------------------------------------------------------------
            | MONTHLY EARNINGS
            |--------------------------------------------------------------------------
            */

            $earning = TeacherEarning::where('teacher_id', $teacherId)
                ->where('status', 'completed')
                ->whereBetween('earned_at', [$monthStart, $monthEnd])
                ->sum('amount');

            /*
            |--------------------------------------------------------------------------
            | STORE DATA
            |--------------------------------------------------------------------------
            */

            $performances->push([

                'month' => $monthStart->format('M Y'),

                'courses' => $courses,

                'sessions' => $sessions,

                'earning' => $earning,

            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | FINAL DATA
        |--------------------------------------------------------------------------
        */

        $data = [

            'total_time' => $hours . 'h ' . $minutes . 'm',

            'total_sessions' => $totalSessions,

            'average_rating' => $averageRating,

            'total_growth' => $totalGrowth,

        ];
        return view(
            'teacher.my_performance.index',
            compact(
                'data',
                'performances'
            )
        );
    }
}
