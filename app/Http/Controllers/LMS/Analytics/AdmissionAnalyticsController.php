<?php

namespace App\Http\Controllers\LMS\Analytics;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Course;
use App\Models\CourseInstallment;
use App\Models\Purchase;
use App\Models\StudentCourse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdmissionAnalyticsController extends Controller
{
  public function index(Request $request)
  {
    $query = Purchase::with('student')->latest();

    // Date filter
    if ($request->from && $request->to) {
      // From AND To
      $query->whereBetween('created_at', [
        $request->from . ' 00:00:00',
        $request->to . ' 23:59:59'
      ]);
    } elseif ($request->from) {
      // Only FROM
      $query->where('created_at', '>=', $request->from . ' 00:00:00');
    } elseif ($request->to) {
      // Only TO
      $query->where('created_at', '<=', $request->to . ' 23:59:59');
    }
    // Student search
    if ($request->search) {
      $query->whereHas('student', function ($q) use ($request) {
        $q->where('name', 'like', "%{$request->search}%")
          ->orWhere('email', 'like', "%{$request->search}%")
          ->orWhere('mobile', 'like', "%{$request->search}%");
      });
    }

    $admissions = $query->paginate(15)->withQueryString();

    return view('company.analytics.admissions', compact('admissions'));
  }
}
