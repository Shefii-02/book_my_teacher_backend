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

class GeneralRequestController extends Controller
{


  public function index(Request $request)
  {
    $query = GeneralRequest::with('user')->latest();

    // 🔎 SEARCH (name / phone)
    if ($request->filled('search')) {
      $search = $request->search;

      $query->whereHas('user', function ($q) use ($search) {
        $q->where('name', 'LIKE', "%$search%")
          ->orWhere('mobile', 'LIKE', "%$search%");
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
        'teachers' => GeneralRequest::where('status', '!=', 'converted_to_admission',)->where('status', '!=', 'closed')->count()
      ],
      'verified' => [
        'teachers' => GeneralRequest::where('status', 'converted_to_admission')->count()
      ],
      'rejected' => [
        'teachers' => GeneralRequest::where('status', 'closed')->count()
      ],
    ];

    return view('company.requests.general-requests', compact('requests', 'data'));
  }

  public function create(Request $request)
  {

    return view('company.requests.general-requests-create');
  }

  public function edit($form_class)
  {
    $company_id = auth()->user()->company_id;

    $form_class = GeneralRequest::with('user')
      ->where('id', $form_class)
      ->where('company_id', $company_id)
      ->firstOrFail();
    // Security check
    if (!$form_class) {
      abort(403);
    }

    return view('company.requests.general-requests-edit', compact('form_class'));
  }

  public function show($form_class)
  {
    $company_id = auth()->user()->company_id;

    $form_class = GeneralRequest::with('user')
      ->where('id', $form_class)
      ->where('company_id', $company_id)
      ->firstOrFail();
    // Security check
    if (!$form_class) {
      abort(403);
    }

    return view('company.requests.general-requests-show', compact('form_class'));
  }

  /**
   * ✏️ Update Lead Status
   */


  public function update(Request $request, $id)
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


  public function destroy($form_class)
  {
    $company_id = auth()->user()->company_id;
    GeneralRequest::where('id', $form_class)->where('company_id', $company_id)->delete();
    return back()->with('success', 'Lead deleted successfully');
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
