<?php

namespace App\Http\Controllers\LMS;

use App\Http\Controllers\Controller;
use App\Models\BannerRequest;
use App\Models\LivestreamClass;
use App\Models\TeacherClassRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class BannerRequestController extends Controller
{


  public function index(Request $request)
  {
    $query = BannerRequest::with('user')->latest();

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
        'teachers' => BannerRequest::count()
      ],
      'unverified' => [
        'teachers' => BannerRequest::where('status', '!=', 'converted_to_admission',)->where('status', '!=', 'closed')->count()
      ],
      'verified' => [
        'teachers' => BannerRequest::where('status', 'converted_to_admission')->count()
      ],
      'rejected' => [
        'teachers' => BannerRequest::where('status', 'closed')->count()
      ],
    ];

    return view('company.requests.banner-requests', compact('requests', 'data'));
  }

  public function create(Request $request)
  {

    return view('company.requests.banner-requests-create');
  }

  public function edit($form_class)
  {
    $company_id = auth()->user()->company_id;

    $form_class = BannerRequest::with('user')
      ->where('id', $form_class)
      ->where('company_id', $company_id)
      ->firstOrFail();
    // Security check
    if (!$form_class) {
      abort(403);
    }

    return view('company.requests.banner-requests-edit', compact('form_class'));
  }

  public function show($form_class)
  {
    $company_id = auth()->user()->company_id;

    $form_class = BannerRequest::with('user')
      ->where('id', $form_class)
      ->where('company_id', $company_id)
      ->firstOrFail();
    // Security check
    if (!$form_class) {
      abort(403);
    }

    return view('company.requests.banner-requests-show', compact('form_class'));
  }

  /**
   * ✏️ Update Lead Status
   */


  public function update(Request $request, $id)
  {

    $request->validate([
      'status' => 'required|string',
      'notes'   => 'nullable|string|max:1000',
    ]);

    $lead = BannerRequest::findOrFail($id);

    $lead->update([
      'status' => $request->status,
      'notes'   => $request->note,
    ]);

    return back()->with('success', 'Lead updated successfully');
  }


  public function destroy($form_class)
  {
    $company_id = auth()->user()->company_id;
    BannerRequest::where('id', $form_class)->where('company_id', $company_id)->delete();
    return back()->with('success', 'Lead deleted successfully');
  }


  //////////////////////////////////////////////////////////////////////////
  //////////////////////////////////////////////////////////////////////////


}
