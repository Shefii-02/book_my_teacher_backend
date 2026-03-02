<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GeneralRequest;
use App\Models\BannerRequest;
use App\Models\CourseRegistration;
use App\Models\Subject;
use App\Models\TeacherClassRequest;
use App\Models\WebinarRegistration;
use App\Models\WorkshopRegistration;
use Illuminate\Support\Facades\Log;

class RequestController extends Controller
{
  // -------------------------
  // 1. GENERAL REQUEST
  // -------------------------
  public function general(Request $request)
  {
    Log::info("📝 Request Form Submitted:", $request->all());
    $user = $request->user();
    $company_id = 1;
    GeneralRequest::create([
      'from_location' => $request->from,
      'grade' => $request->grade,
      'board' => $request->board,
      'subject' => $request->subject,
      'note' => $request->note,
      'user_id' => $user->id,
      'company_id' => $company_id,
    ]);

    return response()->json(['status' => true, 'data' =>  'General request stored.']);
  }

  // -------------------------
  // 2. BANNER REQUEST
  // -------------------------
  public function banner(Request $request)
  {
    $company_id = 1;
    Log::info("📢 Top Banner Request:", $request->all());
    $user = $request->user();
    BannerRequest::create([
      'banner_id' => $request->banner_id,
      'user_id' => $user->id,
      'company_id' => $company_id,
    ]);

    return response()->json(['status' => true, 'data' =>  'Banner request stored.']);
  }


  public function course(Request $request)
  {
    $company_id = 1;
    Log::info("📢 course Request-1:", $request->all());
    Log::info("-----");
    $user = $request->user();
    $user                     = $request->user();
    $courseReq = CourseRegistration::where('user_id', $user->id)->where('course_id', $request->course_id)->where('company_id', $company_id)->first();
    if (!$courseReq) {
      $courseReq               = new CourseRegistration();
      $courseReq->course_id    = $request->course_id;
      $courseReq->user_id      = $user->id;
      $courseReq->name         = $user->name;
      $courseReq->email        = $user->email;
      $courseReq->phone        = $user->mobile;
      $courseReq->checked_in   = 0;
      $courseReq->company_id   = 1;
      // $courseReq->attended_status =  0;
      Log::info($courseReq);
      $courseReq->save();
    } else {
      return response()->json(['status' => false, 'message' =>  'Course already requested.']);
    }

    return response()->json(['status' => true, 'message' =>  'Course request stored.']);
  }

  public function webinar(Request $request)
  {
    $company_id = 1;
    Log::info("📢 webinar Request:", $request->all());
    $user                     = $request->user();
    $webinarReq = WebinarRegistration::where('user_id', $user->id)->where('webinar_id', $request->webinar_id)->where('company_id', $company_id)->first();
    if (!$webinarReq) {
      $webinarReq               = new WebinarRegistration();
      $webinarReq->webinar_id   = $request->webinar_id;
      $webinarReq->user_id      = $user->id;
      $webinarReq->name         = $user->name;
      $webinarReq->email        = $user->email;
      $webinarReq->phone        = $user->mobile;
      $webinarReq->checked_in   = 0;
      $webinarReq->company_id   = $company_id;
      $webinarReq->attended_status =  0;
      $webinarReq->save();
    } else {
      return response()->json(['status' => false, 'message' =>  'Webinar already requested.']);
    }

    return response()->json(['status' => true, 'message' =>  'Webinar request stored.']);
  }

  public function workshop(Request $request)
  {
    $company_id = 1;
    Log::info("📢 workshop Request:", $request->all());

    $user                     = $request->user();
    $workshopReq = WorkshopRegistration::where('user_id', $user->id)->where('workshop_id', $request->workshop_id)->where('company_id', $company_id)->first();
    if (!$workshopReq) {
      $workshopReq               = new WorkshopRegistration();
      $workshopReq->workshop_id   = $request->workshop_id;
      $workshopReq->user_id      = $user->id;
      $workshopReq->name         = $user->name;
      $workshopReq->email        = $user->email;
      $workshopReq->phone        = $user->mobile;
      $workshopReq->checked_in   = 0;
      $workshopReq->company_id   = $company_id;
      // $workshopReq->attended_status =  0;
      $workshopReq->save();
    } else {
      return response()->json(['status' => false, 'message' =>  'Workshop already requested.']);
    }

    return response()->json(['status' => true, 'message' =>  'Workshop request stored.']);
  }





  // -------------------------
  // 3. TEACHER CLASS REQUEST
  // -------------------------
  public function teacher(Request $request)
  {
    Log::info("👨‍🏫 Teacher Class Request:", $request->all());
    $user = $request->user();
    $company_id = 1;
    TeacherClassRequest::create([
      'teacher_id'     => $request->teacher_id,
      'type'           => $request->type,
      'selected_items' => $request->selected_items,
      'class_type'     => $request->class_type,
      'days_needed'    => $request->days_needed,
      'notes'          => $request->notes,
      'user_id'        => $user->id,
      'company_id' => $company_id,
    ]);

    return response()->json(['status' => true, 'data' => 'Teacher class request stored.']);
  }


  public function subject(Request $request)
  {
    Log::info("👨‍🏫 Subject Class Request:", $request->all());
    $user = $request->user();
    $company_id = 1;
    $subject = Subject::where('id', $request->subject_id)->first();
    TeacherClassRequest::create([
      'teacher_id'     => $request->teacher_id,
      'type'           => 'subject',
      'selected_items' => $subject->name,
      'class_type'     => $request->class_type,
      'days_needed'    => $request->days,
      'notes'          => $request->note,
      'user_id'        => $user->id,
      'company_id' => $company_id,
    ]);

    return response()->json(['status' => true, 'data' => 'Teacher class request stored.']);
  }


  public function getGeneralRequests(Request $request)
  {
    $user = $request->user();
    $items = GeneralRequest::where('user_id', $user->id)->latest()->get()->map(function ($req) {
      return [
        'id'         => $req->id,
        'title'      => $req->subject . ' - ' . ($req->grade ?? ''),
        'grade'      => $req->grade,
        'board'      => $req->board,
        'subject'    => $req->subject,
        'note'       => $req->note,
        'status'     => $req->status,
        'created_at' => $req->created_at->format('Y-m-d'),
      ];
    });

    return response()->json([
      'success' => true,
      'data' => $items,
    ]);
  }

  // public function findingTeachers(Request $request)
  // {
  //   Log::info($request->all());
  //   return response()->json([
  //     "status" => true,
  //     "message" => "Teachers found",
  //     "request" => $request->all(),
  //     "data" => [
  //       "multi_subject_teachers" => [
  //         // [
  //         //   "id" => '1',
  //         //   "name" => "Rahul Kumar",
  //         //   "qualification" => "BTech Cs,NET",
  //         //   "imageUrl" => "https://dummyimage.com/200x200",
  //         //   "experience" => 5,
  //         //     "ranking" => 1,
  //         //   "rating" => 4.5,
  //         //   "subjects" => "Maths, Physics",
  //         //   "mode" => ["Online"],
  //         //   "location" => "Kochi",
  //         //   "is_premium" => true
  //         // ]
  //       ],
  //       "single_subject_teachers" => [
  //         "Maths" => [
  //           // [
  //           //   "id" => '2',
  //           //   "name" => "Anjali Menon",
  //           //   "qualification" => "MSc Cs,NET",
  //           //   "imageUrl" => "https://dummyimage.com/200x200",
  //           //   "experience" => 3,
  //           //   "ranking" => 4,
  //           //   "rating" => 4.2,
  //           //   "subjects" => "Maths",
  //           //   "mode" => ["Online", "Offline"],
  //           //   "location" => "Malappuram",
  //           //   "is_premium" => false
  //           // ]
  //         ],
  //         "Physics" => [
  //         //   [
  //         //     "id" => '3',
  //         //     "name" => "Anoop Das",
  //         //     "qualification" => "MSc Physics,NET",
  //         //     "imageUrl" => "https://dummyimage.com/200x200",
  //         //     "experience" => 7,
  //         //     "ranking" => 3,
  //         //     "rating" => 4.8,
  //         //     "subjects" => "Physics",
  //         //     "mode" => ["Online"],
  //         //     "location" => "Thrissur",
  //         //     "is_premium" => true
  //         //   ]
  //         ]
  //       ]
  //     ]
  //   ]);
  // }
  // public function findingTeachers(Request $request)
  // {
  //   Log::info($request->all());

  //   // 🔎 Example Filters
  //   $grade = $request->grade;
  //   $board = $request->board;
  //   $subjects = $request->subjects ?? [];
  //   $modes = $request->modes ?? [];

  //   /*
  //   |--------------------------------------------------------------------------
  //   | 1️⃣ Multi Subject Teachers
  //   |--------------------------------------------------------------------------
  //   */

  //   $multiTeachers = \App\Models\Teacher::query()
  //     ->where('is_multi_subject', true)
  //     ->when($grade, fn($q) => $q->where('grade', $grade))
  //     ->when($board, fn($q) => $q->where('board', $board))
  //     ->when(!empty($modes), fn($q) => $q->whereIn('mode', $modes))
  //     ->get()
  //     ->map(function ($teacher) {
  //       return [
  //         "id" => $teacher->id,
  //         "name" => $teacher->name,
  //         "qualification" => $teacher->qualification,
  //         "imageUrl" => $teacher->image_url,
  //         "experience" => $teacher->experience,
  //         "ranking" => $teacher->ranking,
  //         "rating" => (float) $teacher->rating,
  //         "subjects" => $teacher->subjects,
  //         "mode" => $teacher->mode,
  //         "location" => $teacher->location,
  //         "is_premium" => $teacher->is_premium,
  //       ];
  //     })
  //     ->values()
  //     ->toArray();

  //   /*
  //   |--------------------------------------------------------------------------
  //   | 2️⃣ Single Subject Teachers (Grouped by Subject)
  //   |--------------------------------------------------------------------------
  //   */

  //   $singleSubjectTeachers = [];

  //   foreach ($subjects as $subject) {

  //     $teachers = \App\Models\Teacher::query()
  //       ->where('is_multi_subject', false)
  //       ->where('subjects', 'like', "%$subject%")
  //       ->get()
  //       ->map(function ($teacher) {
  //         return [
  //           "id" => $teacher->id,
  //           "name" => $teacher->name,
  //           "qualification" => $teacher->qualification,
  //           "imageUrl" => $teacher->image_url,
  //           "experience" => $teacher->experience,
  //           "ranking" => $teacher->ranking,
  //           "rating" => (float) $teacher->rating,
  //           "subjects" => $teacher->subjects,
  //           "mode" => $teacher->mode,
  //           "location" => $teacher->location,
  //           "is_premium" => $teacher->is_premium,
  //         ];
  //       })
  //       ->values()
  //       ->toArray();

  //     $singleSubjectTeachers[$subject] = $teachers;
  //   }

  //   /*
  //   |--------------------------------------------------------------------------
  //   | 3️⃣ Recommended Teachers (Example Logic)
  //   |--------------------------------------------------------------------------
  //   */

  //   $recommendedTeachers = \App\Models\Teacher::query()
  //     ->where('rating', '>=', 4.5)
  //     ->orderByDesc('ranking')
  //     ->limit(5)
  //     ->get()
  //     ->map(function ($teacher) {
  //       return [
  //         "id" => $teacher->id,
  //         "name" => $teacher->name,
  //         "qualification" => $teacher->qualification,
  //         "imageUrl" => $teacher->image_url,
  //         "experience" => $teacher->experience,
  //         "ranking" => $teacher->ranking,
  //         "rating" => (float) $teacher->rating,
  //         "subjects" => $teacher->subjects,
  //         "mode" => $teacher->mode,
  //         "location" => $teacher->location,
  //         "is_premium" => $teacher->is_premium,
  //       ];
  //     })
  //     ->values()
  //     ->toArray();

  //   /*
  //   |--------------------------------------------------------------------------
  //   | Final Response
  //   |--------------------------------------------------------------------------
  //   */

  //   return response()->json([
  //     "status" => true,
  //     "message" => "Teachers fetched successfully",
  //     "data" => [
  //       "multi_subject_teachers" => $multiTeachers ?? [],
  //       "single_subject_teachers" => $singleSubjectTeachers ?? [],
  //       "recommended_teachers" => $recommendedTeachers ?? [],
  //     ]
  //   ]);
  // }

  public function findingTeachers(Request $request)
  {
    $type = $request->get('type', 2); // default case 1

    switch ($type) {

      /*
        |--------------------------------------------------------------------------
        | 1️⃣ FULL DATA (All Sections Visible)
        |--------------------------------------------------------------------------
        */
      case 1:
        return response()->json([
          "status" => true,
          "message" => "Full dummy data",
          "data" => [
            "multi_subject_teachers" => [
              [
                "id" => 1,
                "name" => "Rahul Kumar",
                "qualification" => "BTech, NET",
                "imageUrl" => "https://dummyimage.com/200x200",
                "experience" => 6,
                "ranking" => 1,
                "rating" => 4.7,
                "subjects" => "Maths, Physics",
                "mode" => ["Online"],
                "location" => "Kochi",
                "is_premium" => true
              ]
            ],
            "single_subject_teachers" => [
              "Maths" => [
                [
                  "id" => 2,
                  "name" => "Anjali Menon",
                  "qualification" => "MSc Maths",
                  "imageUrl" => "https://dummyimage.com/200x200",
                  "experience" => 4,
                  "ranking" => 3,
                  "rating" => 4.3,
                  "subjects" => "Maths",
                  "mode" => ["Online", "Offline"],
                  "location" => "Malappuram",
                  "is_premium" => false
                ]
              ],
              "Physics" => []
            ],
            "recommended_teachers" => [
              [
                "id" => 3,
                "name" => "Anoop Das",
                "qualification" => "MSc Physics",
                "imageUrl" => "https://dummyimage.com/200x200",
                "experience" => 8,
                "ranking" => 2,
                "rating" => 4.9,
                "subjects" => "Physics",
                "mode" => ["Online"],
                "location" => "Thrissur",
                "is_premium" => true
              ]
            ]
          ]
        ]);

        /*
        |--------------------------------------------------------------------------
        | 2️⃣ ONLY RECOMMENDED
        |--------------------------------------------------------------------------
        */
      case 2:
        return response()->json([
          "status" => true,
          "message" => "Only recommended teachers",
          "data" => [
            "multi_subject_teachers" => [],
            "single_subject_teachers" => new \stdClass(), // empty object
            "recommended_teachers" => [
              [
                "id" => 10,
                "name" => "Meera Nair",
                "qualification" => "MEd English",
                "imageUrl" => "https://dummyimage.com/200x200",
                "experience" => 10,
                "ranking" => 1,
                "rating" => 4.8,
                "subjects" => "English",
                "mode" => ["Online"],
                "location" => "Calicut",
                "is_premium" => true
              ]
            ]
          ]
        ]);

        /*
        |--------------------------------------------------------------------------
        | 3️⃣ ONLY SUBJECT-WISE
        |--------------------------------------------------------------------------
        */
      case 3:
        return response()->json([
          "status" => true,
          "message" => "Subject wise teachers",
          "data" => [
            "multi_subject_teachers" => [],
            "single_subject_teachers" => [
              "Maths" => [
                [
                  "id" => 21,
                  "name" => "Nithin Raj",
                  "qualification" => "BSc Maths",
                  "imageUrl" => "https://dummyimage.com/200x200",
                  "experience" => 3,
                  "ranking" => 5,
                  "rating" => 4.1,
                  "subjects" => "Maths",
                  "mode" => ["Offline"],
                  "location" => "Kannur",
                  "is_premium" => false
                ]
              ],
              "Physics" => [
                [
                  "id" => 22,
                  "name" => "Sreeraj P",
                  "qualification" => "MSc Physics",
                  "imageUrl" => "https://dummyimage.com/200x200",
                  "experience" => 5,
                  "ranking" => 4,
                  "rating" => 4.4,
                  "subjects" => "Physics",
                  "mode" => ["Online"],
                  "location" => "Palakkad",
                  "is_premium" => false
                ]
              ]
            ],
            "recommended_teachers" => []
          ]
        ]);

        /*
        |--------------------------------------------------------------------------
        | 4️⃣ NO TEACHERS (Triggers Blur UI)
        |--------------------------------------------------------------------------
        */
      case 4:
      default:
        return response()->json([
          "status" => true,
          "message" => "No teachers found",
          "data" => [
            "multi_subject_teachers" => [],
            "single_subject_teachers" => new \stdClass(),
            "recommended_teachers" => []
          ]
        ]);
    }
  }
}
