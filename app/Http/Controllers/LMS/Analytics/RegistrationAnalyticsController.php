<?php

namespace App\Http\Controllers\LMS\Analytics;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Course;
use App\Models\CourseInstallment;
use App\Models\StudentCourse;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RegistrationAnalyticsController extends Controller
{
  public function index(Request $request)
  {
    $company_id = auth()->user()->company_id;
    $query = User::where('company_id', $company_id)->latest();

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

    if ($request->search) {
      $query->where('name', 'like', "%{$request->search}%")
        ->orWhere('email', 'like', "%{$request->search}%")
        ->orWhere('mobile', 'like', "%{$request->search}%");
    }

    $registrations = $query->paginate(15)->withQueryString();

    return view('company.analytics.registrations', compact('registrations'));
  }
}
