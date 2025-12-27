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
    dd($request->all());
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
      dd($courseReq);
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
}
