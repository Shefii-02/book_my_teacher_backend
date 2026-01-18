<?php

namespace App\Http\Controllers\Teacher;

use App\Helpers\MediaHelper;
use App\Models\Course;
use App\Models\CourseMaterial;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CompanyContact;
use App\Models\DeleteAccountRequest;
use App\Models\SocialLink;
use Illuminate\Support\Facades\Log;

class SettingsController extends Controller
{

  public function index()
  {
    $company_id = auth()->user()->company_id;
    $socials = SocialLink::where('company_id', $company_id)->get();
    $company = CompanyContact::where('company_id', $company_id)->first();

    return view('teacher.settings.index', compact('socials', 'company'));
  }


  public function accountDeleteRequest(Request $request)
  {
    $user = auth()->user();

    // Check existing pending request
    $existing = DeleteAccountRequest::where('user_id', $user->id)
      ->where('status', 'pending')
      ->first();

    if ($existing) {
      return response()->json([
        'status' => false,
        'message' => 'A delete account request is already pending.'
      ], 400);
    }

    $deleteReq = DeleteAccountRequest::create([
      'company_id' => $user->company_id,
      'user_id' => $user->id,
      'reason' => $request->reason,
      'description' => $request->description,
    ]);

    return redirect()->back()->with('success', 'Your account deletion requested successfully');
  }


  public function feedbackStore(Request $request)
  {
    Log::info($request->all());
    return redirect()->back()->with('success', 'Your feedback saved successfully');
  }
}
