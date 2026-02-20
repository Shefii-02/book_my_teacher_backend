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
    $query = GeneralRequest::with('user')->latest();

    // 🔎 SEARCH (name / phone)
    if ($request->filled('search')) {
      $search = $request->search;

      $query->whereHas('user', function ($q) use ($search) {
        $q->where('name', 'LIKE', "%$search%")
          ->orWhere('phone', 'LIKE', "%$search%");
      });
    }

    // // 📊 TAB FILTER
    $tab = $request->get('tab', 'pending');

    if ($tab === 'pending') {
      $query->where('status', '!=', 'converted_to_admission',)->where('status', '!=', 'closed');
    } elseif ($tab === 'approved') {
      $query->where('status', 'converted_to_admission');
    } elseif ($tab === 'rejected') {
      $query->where('status', 'closed');
    }

    $requests = $query->paginate(15)->withQueryString();

    // 📈 Stats for cards
    $data = [
      'total' => [
        'teachers' => GeneralRequest::count()
      ],
      'unverified' => [
        'teachers' => GeneralRequest::where('status', 'PENDING')->count()
      ],
      'verified' => [
        'teachers' => GeneralRequest::where('status', 'CONVERTED_TO_ADMISSION')->count()
      ],
      'rejected' => [
        'teachers' => GeneralRequest::where('status', 'CLOSED')->count()
      ],
    ];

    return view('company.requests.general-requests', compact('requests', 'data'));
  }

  /**
   * ✏️ Update Lead Status
   */
  public function updateFormClassStatus(Request $request, $id)
  {
    $request->validate([
      'status' => 'required|string',
      'note'   => 'nullable|string|max:1000',
    ]);

    $lead = GeneralRequest::findOrFail($id);

    $lead->update([
      'status' => $request->status,
      'note'   => $request->note,
    ]);

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
