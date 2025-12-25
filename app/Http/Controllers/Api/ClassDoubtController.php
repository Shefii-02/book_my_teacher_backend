<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CourseClassDoubt;
use App\Models\WebinarClassDoubt;
use App\Models\WorkshopClassDoubt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ClassDoubtController extends Controller
{
  public function CourseClassDoubts(Request $request)
  {
    $user = $request->user();
    Log::info($request->all());
    $doubt = CourseClassDoubt::create([
      'user_id' => $user->id,
      'class_id' => $request->class_id,
      'doubt' => $request->doubt,
      'reply' => "",
      'status' => "pending",
    ]);

    return response()->json([
      'status' => true,
      'message' => 'Doubt submitted successfully',
      'data' => $doubt,
    ]);
  }

  public function WorskshopClassDoubts(Request $request)
  {
    $user = $request->user();

    Log::info($request->all());
    $doubt = WorkshopClassDoubt::create([
      'user_id' => $user->id,
      'class_id' => $request->class_id,
      'doubt' => $request->doubt,
      'reply' => "",
      'status' => "pending",
    ]);

    return response()->json([
      'status' => true,
      'message' => 'Doubt submitted successfully',
      'data' => $doubt,
    ]);
  }

  public function WebinarClassDoubts(Request $request)
  {
    $user = $request->user();

    Log::info($request->all());
    $doubt = WebinarClassDoubt::create([
      'user_id' => $user->id,
      'class_id' => $request->class_id,
      'doubt' => $request->doubt,
      'reply' => "",
      'status' => "pending",
    ]);

    return response()->json([
      'status' => true,
      'message' => 'Doubt submitted successfully',
      'data' => $doubt,
    ]);
  }
}
