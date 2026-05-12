<?php

namespace App\Http\Controllers\LMS;

use App\Models\TeacherEarning;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TeacherEarningController extends Controller
{
  /**
   * Display a listing.
   */
  public function index()
  {
    $earnings = TeacherEarning::latest()->paginate(20);

    return view('teacher_earnings.index', compact('earnings'));
  }

  /**
   * Show create form.
   */
  public function create()
  {
    return view('teacher_earnings.create');
  }

  /**
   * Store.
   */
  public function store(Request $request)
  {
    $request->validate([
      'teacher_id' => 'required|exists:users,id',
      'created_by' => 'required|exists:users,id',

      'type' => 'required',

      'title' => 'nullable|string|max:255',

      'course_id' => 'nullable|required_if:type,course',

      'amount' => 'required|numeric|min:1',

      'status' => 'required',

      'remarks' => 'nullable|string',
    ]);

    $title = $request->title;

    /*
    |--------------------------------------------------------------------------
    | AUTO TITLE FROM COURSE
    |--------------------------------------------------------------------------
    */

    if ($request->type == 'course') {

      $course = Course::find($request->course_id);

      $title = $course?->title;
    }

    TeacherEarning::create([
      'teacher_id' => $request->teacher_id,
      'created_by' => $request->created_by,
      'type' => $request->type,
      'source_id' => $request->course_id,
      'title' => $title,
      'amount' => $request->amount,
      'status' => $request->status,
      'remarks' => $request->remarks,
      'earned_at' => now(),
    ]);

    return redirect()
      ->back()
      ->with('success', 'Teacher earning created successfully');
  }

  /**
   * Show single.
   */
  public function show(TeacherEarning $teacherEarning)
  {
    return view('teacher_earnings.show', compact('teacherEarning'));
  }

  /**
   * Edit form.
   */
  public function edit(TeacherEarning $teacherEarning)
  {
    return view('teacher_earnings.edit', compact('teacherEarning'));
  }

  /**
   * Update.
   */
  public function update(Request $request, TeacherEarning $teacherEarning)
  {
    $request->validate([
      'teacher_id' => 'required|exists:users,id',
      'created_by' => 'required|exists:users,id',
      'type' => 'nullable|string|max:255',
      'source_id' => 'nullable|integer',
      'amount' => 'required|numeric|min:0',
      'status' => 'required',
      'remarks' => 'nullable|string',
      'earned_at' => 'nullable|date',
    ]);

    $teacherEarning->update($request->all());

    return redirect()
      ->route('teacher-earnings.index')
      ->with('success', 'Teacher earning updated successfully');
  }

  /**
   * Delete.
   */
  public function destroy(TeacherEarning $teacherEarning)
  {
    $teacherEarning->delete();

    return redirect()
      ->route('teacher-earnings.index')
      ->with('success', 'Teacher earning deleted successfully');
  }
}
