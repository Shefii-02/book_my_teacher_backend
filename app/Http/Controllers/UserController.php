<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\TopTeacher;
use App\Http\Controllers\Controller;
use App\Models\SubjectCourse;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
  public function searchUsers(Request $request)
  {
    $search = strtolower($request->key);

    if (!$search) {
      return response()->json([]);
    }

    // If search is mobile and does NOT start with 91, add prefix
    $searchMobile = $search;

    if (is_numeric($search) && !str_starts_with($search, '91')) {
      $searchMobile = '91' . $search;
    }

    $users = User::where(function ($q) use ($search, $searchMobile) {
      // Name
      $q->whereRaw("LOWER(name) LIKE ?", ["{$search}%"])
        // Email
        ->orWhereRaw("LOWER(email) LIKE ?", ["{$search}%"])
        // Mobile (normal)
        ->orWhereRaw("mobile LIKE ?", ["{$search}%"])
        // Mobile (with 91 prefix)
        ->orWhereRaw("mobile LIKE ?", ["{$searchMobile}%"]);
    })
      // ->where('status',1)
      ->select('id', 'name', 'email', 'mobile', 'acc_type')
      ->limit(10)
      ->get();

    return response()->json($users);
  }


  public function courses($id)
  {
    $user = User::findOrFail($id);
    return $user->courses()->get(['id', 'title']);
  }



  public function subjects($id)
  {
    $course = SubjectCourse::findOrFail($id);
    return $course->subjects()->get(['id', 'name']);
  }


  public function teachers($id)
  {
    $course = SubjectCourse::findOrFail($id);
    return $course->teachers()->get(['id', 'name']);
  }


  public function studentDetails($id)
  {
    $company_id = auth()->user()->company_id;
    $user = User::where('id', $id)->where('company_id')->first();

    return view('company.students.detailed-information', compact('user'));
  }
}
