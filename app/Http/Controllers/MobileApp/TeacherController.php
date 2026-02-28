<?php

namespace App\Http\Controllers\MobileApp;

use App\Helpers\MediaHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Teachers\StoreTeacherRequest;
use App\Http\Requests\Teachers\UpdateTeacherRequest;
use App\Models\Grade;
use App\Models\Teacher;
use App\Models\TeacherSubjectRate;
use App\Models\Subject;
use App\Models\TeacherCertificate;
use App\Models\TeachersTeachingGradeDetail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class TeacherController extends Controller
{
  public function index()
  {
    $teachers = Teacher::orderBy('id', 'desc')->paginate(15);
    return view('company.mobile-app.teachers.index', compact('teachers'));
  }

  public function create()
  {
    // fetch subjects from DB - if none, provide dummy fallback
    $subjects = Subject::orderBy('name')->get() ?? collect([
      (object)['id' => 1, 'name' => 'Mathematics'],
      (object)['id' => 2, 'name' => 'Science'],
      (object)['id' => 3, 'name' => 'English'],
      (object)['id' => 4, 'name' => 'Computer']
    ]);
    // $subjects = [
    //   1 => 'Mathematics',
    //   2 => 'Science',
    //   3 => 'English',
    //   4 => 'Computer Science',
    // ];


    $languages = ['English', 'Hindi', 'Tamil', 'Malayalam', 'Kannada', 'Telugu'];

    return view('company.mobile-app.teachers.form', compact('subjects', 'languages'));
  }


  public function store(StoreTeacherRequest $request)
  {
    $data = $request->validated();
    DB::beginTransaction();
    try {
      $company_id = auth()->user()->company_id;


      // Upload Thumbnail
      $thumbnailPath = null;
      if ($request->hasFile('thumb')) {
        $thumbnailPath = MediaHelper::uploadCompanyFile(
          $company_id,
          'teachers/thumbnails',
          $request->file('thumb'),
          'teacher_thumb'
        );
        $data['thumb'] = $thumbnailPath;
      }

      // Upload Main Image
      $mainImagePath = null;
      if ($request->hasFile('main')) {
        $mainImagePath = MediaHelper::uploadCompanyFile(
          $company_id,
          'teachers/main_images',
          $request->file('main'),
          'teacher_main'
        );
        $data['main'] = $mainImagePath;
      }


      $data['company_id'] = $company_id;


      // subjects/time_slots MUST be arrays
      $data['subjects'] = $data['subjects'] ?? [];
      $data['speaking_languages'] = $data['languages'] ?? [];
      $data['year_exp'] = $data['experience'] ?? 0;
      $data['commission_enabled'] = $data['is_commission'] ?? 0;
      $data['commission_percent'] = $data['commission_percentage'] ?? 0;
      $data['demo_class_link']    = $data['demo_link'];
      $data['include_top_teachers'] = $data['is_top'] ?? 0;

      // time_slots comes as JSON string (or null). decode to array for storage
      // $timeSlots = [];
      // if (!empty($data['time_slots'])) {
      //   $timeSlots = json_decode($data['time_slots'], true) ?: [];
      // }
      // $data['time_slots'] = $timeSlots;

      $timeSlots = [];

      if (!empty($data['time_slots']) && is_array($data['time_slots'])) {
        $timeSlots = $data['time_slots'];
      }

      $data['time_slots'] = json_encode($timeSlots);


      // booleans normalization
      $data['is_commission'] = !empty($data['is_commission']);
      $data['is_top'] = !empty($data['is_top']);
      $data['published'] = !empty($data['published']);

      $teacher = Teacher::create($data);

      // save subject rates (only for selected subjects)
      if ($request->filled('rates') && is_array($request->rates)) {
        foreach ($request->rates as $subjectId => $rates) {
          if (!in_array((int)$subjectId, $data['subjects'])) continue;
          TeacherSubjectRate::create([
            'teacher_id' => $teacher->id,
            'subject_id' => $subjectId,
            'rate_0_10' => Arr::get($rates, 'rate_below_10'),
            'rate_10_30' => Arr::get($rates, 'rate_10_30'),
            'rate_30_plus' => Arr::get($rates, 'rate_30_plus'),
          ]);
        }
      }


      // certificates
      if ($request->hasFile('certificates')) {

        foreach ($request->file('certificates') as $f) {

          // Upload certificate file
          $certificatePath = MediaHelper::uploadCompanyFile(
            $company_id,
            'teachers/certificates',
            $f,
            'teacher_certificate'
          );

          // Insert into teacher_certificates table
          TeacherCertificate::create([
            'teacher_id' => $teacher->id,   // Make sure you have the teacher object
            'file_id'  => $certificatePath,
          ]);
        }
      }
      DB::commit();
      return redirect()->route('company.app.teachers.index')->with('success', 'Teacher created');
    } catch (Exception $e) {
      DB::rollBack();
      return redirect()->back()->with('error', $e->getMessage());
    }
  }

  public function edit(Teacher $teacher)
  {
    $subjects = Subject::orderBy('name')->get() ?? collect();
    $languages = ['English', 'Hindi', 'Tamil', 'Malayalam', 'Kannada', 'Telugu'];

    // existing rates keyed by subject id
    $existingRates = $teacher->subjectRates->keyBy('subject_id')->map(function ($r) {
      return [
        'rate_0_10' => $r->rate_0_10,
        'rate_10_30' => $r->rate_10_30,
        'rate_30_plus' => $r->rate_30_plus,
      ];
    })->toArray();

    return view('company.mobile-app.teachers.form', compact('teacher', 'subjects', 'languages', 'existingRates'));
  }


  public function update(UpdateTeacherRequest $request, Teacher $teacher)
  {
    $data = $request->validated();
    $company_id = auth()->user()->company_id;
    try {

      // Upload Thumbnail
      $thumbnailPath = null;
      if ($request->hasFile('thumb')) {
        MediaHelper::removeCompanyFile($teacher->thumb);
        $thumbnailPath = MediaHelper::uploadCompanyFile(
          $company_id,
          'teachers/thumbnails',
          $request->file('thumb'),
          'teacher_thumb'
        );
        $data['thumb'] = $thumbnailPath;
      }

      // Upload Main Image
      $mainImagePath = null;
      if ($request->hasFile('main')) {
        MediaHelper::removeCompanyFile($teacher->main);
        $mainImagePath = MediaHelper::uploadCompanyFile(
          $company_id,
          'teachers/main_images',
          $request->file('main'),
          'teacher_main'
        );
        $data['main'] = $mainImagePath;
      }


      // subjects/time_slots MUST be arrays
      $data['subjects'] = $data['subjects'] ?? [];
      $data['speaking_languages'] = $data['languages'] ?? [];
      $data['year_exp'] = $data['experience'] ?? 0;
      $data['commission_enabled'] = $data['is_commission'] ?? 0;
      $data['commission_percent'] = $data['commission_percentage'] ?? 0;
      $data['demo_class_link']    = $data['demo_link'];
      $data['include_top_teachers'] = $data['is_top'] ?? 0;

      // time_slots comes as JSON string (or null). decode to array for storage
      // $timeSlots = [];
      // if (!empty($data['time_slots'])) {
      //   $timeSlots = json_decode($data['time_slots'], true) ?: [];
      // }
      // $data['time_slots'] = $timeSlots;

      $timeSlots = [];

      if (!empty($data['time_slots']) && is_array($data['time_slots'])) {
        $timeSlots = $data['time_slots'];
      }

      $data['time_slots'] = json_encode($timeSlots);


      // booleans normalization
      $data['is_commission'] = !empty($data['is_commission']);
      $data['is_top'] = !empty($data['is_top']);
      $data['published'] = !empty($data['published']);


      // $timeSlots = [];
      // if (!empty($data['time_slots'])) $timeSlots = json_decode($data['time_slots'], true) ?: [];
      // $data['time_slots'] = $timeSlots;

      // $data['is_commission'] = !empty($data['is_commission']);
      // $data['is_top'] = !empty($data['is_top']);
      // $data['published'] = !empty($data['published']);

      $teacher->update($data);

      // update rates: remove all then insert new (simple)
      $teacher->subjectRates()->delete();
      if ($request->filled('rates') && is_array($request->rates)) {
        foreach ($request->rates as $subjectId => $rates) {
          if (!in_array((int)$subjectId, $data['subjects'])) continue;
          TeacherSubjectRate::create([
            'teacher_id' => $teacher->id,
            'subject_id' => $subjectId,
            'rate_below_10' => Arr::get($rates, 'rate_below_10'),
            'rate_10_30' => Arr::get($rates, 'rate_10_30'),
            'rate_30_plus' => Arr::get($rates, 'rate_30_plus'),
          ]);
        }
      }

      // certificates
      if ($request->hasFile('certificates')) {

        foreach ($request->file('certificates') as $f) {

          // Upload certificate file
          $certificatePath = MediaHelper::uploadCompanyFile(
            $company_id,
            'teachers/certificates',
            $f,
            'teacher_certificate'
          );

          // Insert into teacher_certificates table
          TeacherCertificate::create([
            'teacher_id' => $teacher->id,   // Make sure you have the teacher object
            'file_id'  => $certificatePath,
          ]);
        }
      }

      // certificates removal
      $existingCerts = $teacher->certificates ?? [];
      if (!empty($data['remove_certificates']) && is_array($data['remove_certificates'])) {
        foreach ($data['remove_certificates'] as $f) {
          TeacherCertificate::where('file_id', $f)->delete();
          MediaHelper::removeCompanyFile($f);
          // if (($k = array_search($f, $existingCerts)) !== false) {
          //   Storage::disk('public')->delete($f);
          //   unset($existingCerts[$k]);
          // }
        }
      }

      DB::commit();
      return redirect()->route('company.app.teachers.index')->with('success', 'Teacher updated');
    } catch (Exception $e) {
      DB::rollBack();
      return redirect()->back()->with('error', $e->getMessage());
    }
  }

  public function destroy(Teacher $teacher)
  {
    MediaHelper::removeCompanyFile($teacher->thumb);
    MediaHelper::removeCompanyFile($teacher->main);
    if ($teacher->certificates)
      foreach ($teacher->certificates as $f) {
        if ($f)
          MediaHelper::removeCompanyFile($f->file_id);
      }
    // Storage::disk('public')->delete($f);
    $teacher->delete();
    return back()->with('success', 'Teacher deleted');
  }


  public function loginSecurity($id)
  {
    $teacher = User::where('id', $id)->where('acc_type', 'teacher')->first();
    return view('company.mobile-app.teachers.login-security', compact('teacher'));
  }


  public function loginSecurityChange($id, Request $request)
  {
    DB::beginTransaction();
    try {
      $teacher = User::where('id', $id)->where('acc_type', 'teacher')->first();

      if (!$teacher) {
        return redirect()->back(['error' => 'Teacher not found'], 404);
      }

      $teacher = User::where('id', $id)->where('acc_type', 'teacher')->first();

      if ($request->filled('password')) {
        $teacher->password = $request->password;
      }

      $teacher->email  = $request->email;
      $teacher->mobile = $request->mobile;
      $teacher->save();

      DB::commit();

      return redirect()->back()->with('success', 'Teacher login security updated successfully');
    } catch (\Exception $e) {
      DB::rollBack();
      return redirect()->back()->with(['error', 'Failed to teacher login security updation' . $e->getMessage()]);
    }
  }

  public function gradeEdit($teacherId)
  {
    $teacher = User::findOrFail($teacherId);

    $grades = Grade::with([
      'boards' => function ($q) {
        $q->where('published', 1)
          ->with(['subjects' => function ($q2) {
            $q2->where('published', 1);
          }]);
      }
    ])->where('published', 1)->get();

    // ✅ Full teaching details for edit
    $teacherDetails = TeachersTeachingGradeDetail::where('user_id', $teacherId)->get();

    return view(
      'company.mobile-app.teachers.teaching-grades',
      compact('grades', 'teacher', 'teacherDetails')
    );
  }

  // =========================
  // SAVE / UPDATE
  // =========================

  public function gradesUpdate(Request $request, $teacherId)
  {
    DB::beginTransaction();
    try {
      $teacher = User::findOrFail($teacherId);

      // delete old
      TeachersTeachingGradeDetail::where('user_id', $teacherId)->delete();

      if ($request->has('data')) {
        foreach ($request->data as $gradeId => $boardIds) {
          foreach ($boardIds as $board_id => $boardId) {
            foreach ($boardId ?? [] as $subjects) {
              foreach ($subjects ?? [] as $subject) {
                if (isset($subject['id'])) {
                  TeachersTeachingGradeDetail::create([
                    'user_id'    => $teacherId,
                    'grade_id'   => $gradeId,
                    'board_id'   => $board_id,
                    'subject_id' => $subject['id'],
                    'online'     => isset($subject['online']) ? 1 : 0,
                    'offline'    => isset($subject['offline']) ? 1 : 0,
                  ]);
                }
              }
            }
          }
        }
      }
      DB::commit();
      return back()->with('success', 'Teaching details updated');
    } catch (Exception $e) {
      DB::rollBack();
      return back()->with('error', 'Teaching details updation filed' . $e->getMessage());
    }
  }
}
