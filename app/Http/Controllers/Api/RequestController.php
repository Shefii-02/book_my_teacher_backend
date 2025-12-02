<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GeneralRequest;
use App\Models\BannerRequest;
use App\Models\Subject;
use App\Models\TeacherClassRequest;
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
    $company_id = 1;
    Log::info("👨‍🏫 Subject Class Request:", $request->all());
    $subject = Subject::where('id', 'subject_id')->first();
    $user = $request->user();
    TeacherClassRequest::create([
      'teacher_id'     => $request->teacher_id,
      'type'           => 'subject',
      'selected_items' => $subject->name,
      'class_type'     => $request->class_type,
      'days_needed'    => $request->days_needed,
      'notes'          => $request->notes,
      'user_id'        => $user->id,
      'company_id' => $company_id,
    ]);

    return response()->json(['status' => true, 'data' => 'Teacher class request stored.']);
  }
}
