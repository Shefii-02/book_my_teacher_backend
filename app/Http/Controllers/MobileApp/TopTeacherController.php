<?php

namespace App\Http\Controllers\MobileApp;

use App\Models\Teacher;
use App\Models\TopTeacher;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TopTeacherController extends Controller
{
  public function index()
  {
    $teachers = Teacher::with('topTeacher')->Where('published', 1)
      ->orderByRaw('ISNULL(top_teachers.position), top_teachers.position ASC')
      ->leftJoin('top_teachers', 'teachers.id', '=', 'top_teachers.teacher_id')
      ->select('teachers.*', 'top_teachers.position')
      ->get();

    return view('company.mobile-app.top-teachers.index', compact('teachers'));
  }

  public function toggle(Request $request)
  {
    $teacherId = $request->teacher_id;

    $record = TopTeacher::where('teacher_id', $teacherId)->first();

    if ($record) {
      $record->delete();
      return response()->json(['status' => 'removed']);
    }

    $max = TopTeacher::max('position') ?? 0;

    TopTeacher::create([
      'teacher_id' => $teacherId,
      'position'   => $max + 1,
    ]);

    return response()->json(['status' => 'added']);
  }

  public function reorder(Request $request)
  {
    foreach ($request->positions as $pos => $id) {
      TopTeacher::where('teacher_id', $id)->update([
        'position' => $pos + 1
      ]);
    }

    return response()->json(['success' => true]);
  }



  public function teachersRanking(Request $request)
  {
    $query = Teacher::query();

    /* ===============================
        SEARCH
    =============================== */
    if ($request->filled('search')) {
      $search = $request->search;

      $query->where(function ($q) use ($search) {
        $q->where('name', 'like', "%$search%")
          ->orWhere('email', 'like', "%$search%")
          ->orWhere('mobile', 'like', "%$search%");
      });
    }

    /* ===============================
        ORDERING
    =============================== */
    $teachers = $query
      ->orderByDesc('ranking')
      ->orderByDesc('rating')
      ->paginate(10);

    // /* ===============================
    //     POSITION CALCULATION
    // =============================== */
    // $start = ($teachers->currentPage() - 1) * $teachers->perPage();

    // foreach ($teachers as $index => $teacher) {
    //   $teacher->position = $start + $index + 1;
    // }



    return view('company.mobile-app.teachers.teachers-ranking', compact('teachers'));
  }


  /* ===============================
    UPDATE RANKING
=============================== */
  public function updateTeacherRanking(Request $request, $id)
  {
    $request->validate([
      'ranking' => 'required|integer|min:0',
      'rating' => 'nullable|numeric|min:0|max:5',
    ]);

    $teacher = Teacher::findOrFail($id);

    $teacher->ranking = $request->ranking ?? 0;
    $teacher->rating = $request->rating ?? 0;
    $teacher->save();

    return back()->with('success', 'Updated successfully');
  }
}
