<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\TopTeacher;
use App\Http\Controllers\Controller;
use App\Models\SubjectCourse;
use App\Models\User;
use Illuminate\Http\Request;

class GlobalSearchController extends Controller
{
  public function search(Request $request)
  {
    $q = $request->q;

    if (!$q) {
      return response()->json([]);
    }

    // ============================
    // STUDENTS
    // ============================
    $students = User::where('acc_type', 'student')
      ->where(function ($query) use ($q) {
        $query->where('name', 'like', "%$q%")
          ->orWhere('email', 'like', "%$q%")
          ->orWhere('mobile', 'like', "%$q%");
      })
      ->limit(5)
      ->get()
      ->map(function ($s) {
        return [
          'type' => 'Student',
          'name' => $s->name,
          'sub'  => $s->email,
          'mobile' => $s->mobile,
          'url'  => route('company.student-details', $s->id)
        ];
      });

    // ============================
    // TEACHERS
    // ============================
    $teachers = User::where('acc_type', 'teacher')
      ->where(function ($query) use ($q) {
        $query->where('name', 'like', "%$q%")
          ->orWhere('email', 'like', "%$q%")
          ->orWhere('mobile', 'like', "%$q%");
      })
      ->limit(5)
      ->get()
      ->map(function ($t) {
        return [
          'type' => 'Teacher',
          'name' => $t->name,
          'sub'  => $t->email,
          'mobile' => $t->mobile,
          'url'  => route('company.teachers.index', $t->id)
        ];
      });

    // ============================
    // STAFF / ADMINS
    // ============================
    $staff = User::where('acc_type', 'staff')
      ->where(function ($query) use ($q) {
        $query->where('name', 'like', "%$q%")
          ->orWhere('email', 'like', "%$q%")
          ->orWhere('mobile', 'like', "%$q%");
      })
      ->limit(5)
      ->get()
      ->map(function ($s) {
        return [
          'type' => 'Staff',
          'name' => $s->name,
          'mobile' => $s->mobile,
          'sub'  => $s->email,
          'url'  => route('company.staffs', $s->id)
        ];
      });

    // ============================
    // QUICK LINKS (Static)
    // ============================
    $links = collect([
      ['type' => 'Page', 'name' => 'All Teachers', 'sub' => 'List', 'url' => route('company.teachers.index')],
      ['type' => 'Page', 'name' => 'Students', 'sub' => 'List', 'url' => route('company.students.index')],
      ['type' => 'Page', 'name' => 'Banners', 'sub' => 'Manage', 'url' => route('company.app.top-banners.index')],
      ['type' => 'Page', 'name' => 'Courses', 'sub' => 'Manage', 'url' => route('company.courses.index')],
    ]);

    return response()->json([
      'students' => $students,
      'teachers' => $teachers,
      'staff'    => $staff,
      'links'    => $links,
    ]);
  }
}
