<?php

namespace App\Http\Controllers\LMS;

use App\Http\Controllers\Controller;
use App\Models\BannerRequest;
use App\Models\GeneralRequest;
use App\Models\LivestreamClass;
use App\Models\TeacherClassRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class RequestController extends Controller
{
  public function formClassRequest(Request $request)
  {
    $requests = GeneralRequest::with('user')
      ->latest()
      ->paginate(15);

    return view('company.requests.general-requests', compact('requests'));
  }

  public function updateFormClassStatus(Request $request, $id)
  {
    // dd($request->all());
    $request->validate([
      'status' => 'required|string',
      'note'   => 'nullable|string',
    ]);

    $lead = GeneralRequest::findOrFail($id);

    $lead->status = $request->status;
    $lead->note   = $request->note;
    $lead->save();

    return back()->with('success', 'Lead updated successfully');
  }

  //////////////////////////////////////////////////////////////////////////
  //////////////////////////////////////////////////////////////////////////

  public function bannerRequests()
  {
    $requests = BannerRequest::with(['user', 'banner'])
      ->whereHas('banner', function (Builder $query) {
        $query->where('banner_type', 'top-banner');
      })
      ->where('company_id', auth()->user()->company_id)
      ->latest()
      ->paginate(15);

    return view('company.requests.banner-requests', compact('requests'));
  }

  public function bannerRequestsUpdate(Request $request, $id)
  {
    $request->validate([
      'status' => 'required|string',
      'note'   => 'nullable|string',
    ]);

    $bannerRequest = BannerRequest::findOrFail($id);
    $bannerRequest->update($request->only('status', 'note'));

    return back()->with('success', 'Banner request updated');
  }


  public function courseBanner()
  {
    $requests = BannerRequest::with(['user', 'banner'])
      ->whereHas('banner', function (Builder $query) {
        $query->where('banner_type', 'course-banner');
      })
      ->where('company_id', auth()->user()->company_id)
      ->latest()
      ->paginate(15);

    return view('company.requests.banner-requests', compact('requests'));
  }

  public function courseBannerRequestsUpdate(Request $request, $id)
  {
    $request->validate([
      'status' => 'required|string',
      'note'   => 'nullable|string',
    ]);

    $bannerRequest = BannerRequest::findOrFail($id);
    $bannerRequest->update($request->only('status', 'note'));

    return back()->with('success', 'Banner request updated');
  }

  public function teacherClassRequests()
  {
    $requests = TeacherClassRequest::where(
      'company_id',
      auth()->user()->company_id
    )->latest()->paginate(20);

    return view('company.requests.teacher_class_requests', compact('requests'));
  }

  public function teacherClassRequestsUpdate(Request $request, $id)
  {
    $request->validate([
      'status' => 'required|string',
      'note'   => 'nullable|string',
    ]);

    $bannerRequest = TeacherClassRequest::findOrFail($id);
    $bannerRequest->update($request->only('status', 'lead_note'));

    return back()->with('success', 'Teacher Class request updated');
  }
}
