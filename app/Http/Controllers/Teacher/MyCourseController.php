<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;

class MyCourseController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $teacher = Teacher::where(
            'user_id',
            $user->id
        )->first();

        /*
        |--------------------------------------------------------------------------
        | MY COURSES
        |--------------------------------------------------------------------------
        */

        $my_courses = Course::whereHas(
            'teacherCourses',
            function ($q) use ($user) {

                $q->where('teacher_id', $user->id);

            }
        )
        ->latest()
        ->get();

        /*
        |--------------------------------------------------------------------------
        | COUNTS
        |--------------------------------------------------------------------------
        */

        // Total
        $data['courses']['total'] =
            $my_courses->count();

        // Ongoing
        $data['on_going']['total'] =
            $my_courses
                ->where('started_at', '<=', now())
                ->filter(function ($course) {

                    return is_null($course->ended_at)
                        || $course->ended_at >= now();
                })
                ->count();

        // Completed
        $data['completed']['total'] =
            $my_courses
                ->whereNotNull('ended_at')
                ->where('ended_at', '<', now())
                ->count();

        // Draft
        $data['draft']['total'] =
            $my_courses
                ->where('status', 'draft')
                ->count();

        /*
        |--------------------------------------------------------------------------
        | RECENT COURSES
        |--------------------------------------------------------------------------
        */

        $recent_courses =
            $my_courses->take(5);

        /*
        |--------------------------------------------------------------------------
        | RETURN
        |--------------------------------------------------------------------------
        */

        return view(
            'teacher.my_courses.index',
            compact(
                'my_courses',
                'data',
                'recent_courses'
            )
        );
    }

    public function show($course_id)
    {
        $user = auth()->user();

        $teacher = Teacher::where(
            'user_id',
            $user->id
        )->first();

        $course = Course::whereHas(
            'teacherCourses',
            function ($q) use ($user) {

                $q->where('teacher_id', $user->id);

            }
        )
        ->where(
            'course_identity',
            $course_id
        )
        ->first() ?? abort(404);

        return view(
            'teacher.my_courses.show',
            compact('course')
        );
    }
}
