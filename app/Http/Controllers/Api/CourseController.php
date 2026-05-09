<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\CourseResource;
use App\Http\Resources\API\WorkshopResource;
use App\Http\Resources\API\WebinarResource;
use App\Http\Resources\API\BannerResource;
use App\Http\Resources\API\ClassLinkResource;
use App\Http\Resources\API\CourseClassLinkResource;
use App\Http\Resources\API\DemoClassResource;
use App\Http\Resources\API\MaterialResource;
use App\Http\Resources\API\WebinarClassLinkResource;
use App\Http\Resources\SubjectResource;
use App\Http\Resources\TeacherResource;
use App\Models\CompanyTeacher;
use App\Models\Course;
use App\Models\CourseRegistration;
use App\Models\DemoClass;
use App\Models\MediaFile;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\TopBanner;
use App\Models\User;
use App\Models\Webinar;
use App\Models\WebinarRegistration;
use App\Models\Workshop;
use App\Models\WorkshopRegistration;
use Carbon\Carbon;
use Google\Service\Classroom\Material;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{

  public function courseStore(Request $request): JsonResponse
  {
    $user = $request->user();
    $courses = Course::with('institute')
      ->where('company_id', 1)
      ->where('is_public', 1)
      ->with(['registrations' => function ($q) use ($user) {
        $q->where('user_id', $user->id);
      }])
      ->orderBy('created_at', 'desc')
      ->get()
      // ->map(fn($c) => tap($c)->is_enrolled = false);
      ->map(function ($item) use ($user) {
        $item->is_registered = $item->registrations->isNotEmpty();
        $item->is_enrolled = $item->studentEnrolled->isNotEmpty();
        return $item;
      });

      // ->map(function ($item) use ($user) {
      //   $item->is_enrolled = $item->registrations->isNotEmpty();
      //   return $item;
      // });



    $webinars = Webinar::where('company_id', 1)
      ->whereIn('status', ['scheduled', 'completed'])
      ->with(['registrations' => function ($q) use ($user) {
        $q->where('user_id', $user->id);
      }])
      ->orderBy('created_at', 'desc')
      ->get()
      ->map(function ($item) use ($user) {
        $item->is_enrolled = $item->registrations->isNotEmpty();
        return $item;
      });


    // ->map(fn($w) => tap($w)->is_enrolled = false);

    $workshops = Workshop::where('company_id', 1)
      ->with(['registrations' => function ($q) use ($user) {
        $q->where('user_id', $user->id);
      }])
      ->orderBy('created_at', 'desc')
      ->get()
      ->map(function ($item) use ($user) {
        $item->is_enrolled = $item->registrations->isNotEmpty();
        return $item;
      });
    // ->map(fn($w) => tap($w)->is_enrolled = false);


    $data = collect([

      [
        'category' => 'Course',
        'items'    => CourseResource::collection($courses),
      ],
      [
        'category' => 'Workshop',
        'items'    => WorkshopResource::collection($workshops),
      ],
      [
        'category' => 'Webinar',
        'items'    => WebinarResource::collection($webinars),
      ]

    ])->filter(fn($g) => $g['items']->isNotEmpty())
      ->values();

    return response()->json([
      'status' => true,
      'message' => 'Courses categorized successfully',
      'data' => $data,
    ]);
  }



  public function myClasses(Request $request): JsonResponse
  {
    $user = $request->user();
    $today = Carbon::today();

    $sections = [
      'Ongoing' => [],
      'Completed' => [],
      'Pending Started Courses' => [],
      'Pending Approval' => [],
    ];

    // 🔹 Mapper
    $mapItem = function ($model, $type) {
      return [
        'id'          => $model->id,
        'title'       => $model->title,
        'description' => $model->description,
        'image'       => $model->banner_image ?? null,
        'duration'    => $model->duration ?? null,
        'level'       => $model->level ?? null,
        'type'        => $type,
        'join_link'   => $model->join_link ?? null,
      ];
    };

    /**
     * --------------------------------
     * WEBINARS
     * --------------------------------
     */
    WebinarRegistration::with('webinar')
      ->where('user_id', $user->id)
      ->get()
      ->each(function ($reg) use (&$sections, $today, $mapItem) {

        if (!$reg->webinar) return;

        $webinar = $reg->webinar;

        // if ($reg->checked_in == 0) {
        //   $sections['Pending Approval'][] = $mapItem($webinar, 'webinar');
        //   return;
        // }

        if ($webinar->started_at > $today) {
          $sections['Pending Started Courses'][] = $mapItem($webinar, 'webinar');
          return;
        }

        if ($webinar->started_at <= $today && $webinar->ended_at >= $today) {
          $sections['Ongoing'][] = $mapItem($webinar, 'webinar');
          return;
        }


        if ($webinar->ended_at < $today) {
          $sections['Completed'][] = $mapItem($webinar, 'webinar');
        }
      });

    /**
     * --------------------------------
     * COURSES
     * --------------------------------
     */
    CourseRegistration::with('course')
      ->where('user_id', $user->id)
      ->get()
      ->each(function ($reg) use (&$sections, $today, $mapItem) {

        if (!$reg->course) return;

        $course = $reg->course;

        // if ($reg->checked_in == 0) {
        //   $sections['Pending Approval'][] = $mapItem($course, 'course');
        //   return;
        // }

        if ($course->start_date > $today) {
          $sections['Pending Started Courses'][] = $mapItem($course, 'course');
          return;
        }

        if ($course->start_date <= $today && $course->end_date >= $today) {
          $sections['Ongoing'][] = $mapItem($course, 'course');
          return;
        }

        if ($course->end_date < $today) {
          $sections['Completed'][] = $mapItem($course, 'course');
        }
      });

    /**
     * --------------------------------
     * WORKSHOPS
     * --------------------------------
     */
    WorkshopRegistration::with('workshop')
      ->where('user_id', $user->id)
      ->get()
      ->each(function ($reg) use (&$sections, $today, $mapItem) {

        if (!$reg->workshop) return;

        $workshop = $reg->workshop;

        // if ($reg->checked_in == 0) {
        //   $sections['Pending Approval'][] = $mapItem($workshop, 'workshop');
        //   return;
        // }

        if ($workshop->started_at > $today) {
          $sections['Pending Started Courses'][] = $mapItem($workshop, 'workshop');
          return;
        }

        if ($workshop->started_at <= $today && $workshop->ended_at >= $today) {
          $sections['Ongoing'][] = $mapItem($workshop, 'workshop');
          return;
        }

        if ($workshop->ended_at < $today) {
          $sections['Completed'][] = $mapItem($workshop, 'workshop');
        }
      });



    return response()->json([
      'status'  => true,
      'message' => 'My classes fetched successfully',
      'data' => [
        'categories' => [
          [
            'sections' => collect($sections)->map(function ($items, $status) {
              return [
                'status' => $status,
                'items'  => array_values($items),
              ];
            })->values()
          ]
        ]
      ]
    ]);
  }
}
