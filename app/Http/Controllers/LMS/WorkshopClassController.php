<?php

namespace App\Http\Controllers\LMS;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseClass;
use App\Models\TeacherClass;
use App\Models\User;
use App\Models\Workshop;
use App\Models\WorkshopClass;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WorkshopClassController extends Controller
{
  public function index($identity)
  {
    $workshop = Workshop::with('classes')->where('id', $identity)->first() ?? abort(404);
    return view('company.workshops.classes.index', compact('workshop'));
  }

  public function create($identity)
  {
    $workshop = Workshop::where('id', $identity)->first() ?? abort(404);
    $teachers = User::where('acc_type', 'teacher')->get(); // filter teachers
    return view('company.workshops.classes.form', compact('workshop', 'teachers'));
  }

  public function store(Request $request, $identity)
  {

    $workshop = Workshop::where('id', $identity)->first() ?? abort(404);

    $validated = $request->validate([
      'scheduled_at'     => 'required',
      'type'             => 'required|in:online,offline,recorded',
      'title'            => 'required|string|max:255',
      'description'      => 'nullable|string',

      'start_time'       => 'required',
      'end_time'       => 'required',
      'priority' => 'required',
      'status' => 'required',

      // dynamic fields
      'class_mode'       => 'nullable|required_if:type,online',
      'meeting_link'     => 'nullable|required_if:type,online',

      // 'class_address'    => 'nullable|required_if:type,offline',

      'recording_url'    => 'nullable|required_if:type,recorded',
    ]);

    try {

      DB::beginTransaction();
      $data = $validated;
      $data['teacher_id'] = $workshop->host_id;
      $data['workshop_id'] = $workshop->id;

      $data['start_time'] = date('Y-m-d H:i', strtotime($data['scheduled_at'] .' ' .$data['start_time']));
      $data['end_time'] = date('Y-m-d H:i', strtotime($data['scheduled_at'] .' ' .$data['end_time']));


      $class = WorkshopClass::create($data);

      // TeacherClass::create(['teacher_id' => $workshop->host_id,'class_id' => $class->id]);

      DB::commit();
      return redirect()->route('company.workshops.schedule-class.index', $workshop->id)->with('success', 'Course class created successfully.');
    } catch (Exception $e) {
      DB::rollBack();
      return redirect()->back()->with('error', $e->getMessage());
    }
  }

  public function edit($identity, $workshop_class)
  {

    $workshop = Workshop::where('id', $identity)->first() ?? abort(404);
    $class = WorkshopClass::where('workshop_id', $workshop->id)->where('id', $workshop_class)->first() ?? abort(404);

    $teachers = User::where('acc_type', 'teacher')->get();

    return view('company.workshops.classes.form', [
      'class' => $class,
      'workshop' => $workshop,
      'teachers' => $teachers
    ]);
  }

  public function update($identity, Request $request, $workshop_class)
  {

    $workshop = Workshop::where('id', $identity)->first() ?? abort(404);
    $class = WorkshopClass::where('workshop_id', $workshop->id)->where('id', $workshop_class)->first() ?? abort(404);
    $validated = $request->validate([
      'scheduled_at'     => 'required',
      'type'             => 'required|in:online,offline,recorded',
      'title'            => 'required|string|max:255',
      'description'      => 'nullable|string',

      'start_time'       => 'required',
      'end_time'         => 'required',
      'priority'         => 'required',
      'status'           => 'required',

      'class_mode'       => 'nullable|required_if:type,online',
      'meeting_link'     => 'nullable|required_if:type,online',

      'class_address'    => 'nullable|required_if:type,offline',

      'recording_url'    => 'nullable|required_if:type,recorded',
    ]);

    $workshop = Workshop::where('id', $identity)->first() ?? abort(404);
    try {
      DB::beginTransaction();
      $class->update($validated);
      DB::commit();
      return redirect()->route('company.workshops.schedule-class.index', $workshop->id)->with('success', 'Course class updated successfully.');
    } catch (Exception $e) {
      DB::rollBack();
      return redirect()->back()->with('errro', $e->getMessage());
    }
  }

  public function destroy(CourseClass $workshop_class)
  {
    $workshop_class->delete();
    return redirect()->route('company.workshops.schedule-class.index')->with('success', 'Course class deleted successfully.');
  }
}
