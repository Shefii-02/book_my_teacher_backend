<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\CompanyTeacher;
use App\Models\MediaFile;
use App\Models\Teacher;
use App\Models\TeacherGrade;
use App\Models\TeacherProfessionalInfo;
use App\Models\TeacherWorkingDay;
use App\Models\TeacherWorkingHour;
use App\Models\TeachingSubject;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TeacherController extends Controller
{

  public function home(Request $request)
  {
    $teacherId = $request->user();

    $teacher = User::where('id', $teacherId->id)
      ->where('acc_type', 'teacher')
      ->where('company_id', 1)
      ->first();

    if (!$teacher) {
      return response()->json([
        'message' => 'Teacher not found'
      ], 404);
    }

    // Related info
    // $profInfo     = \App\Models\TeacherProfessionalInfo::where('teacher_id', $teacherId)->first();
    // $workingDays  = \App\Models\TeacherWorkingDay::where('teacher_id', $teacherId)->pluck('day');
    // $workingHours = \App\Models\TeacherWorkingHour::where('teacher_id', $teacherId)->pluck('time_slot');
    // $grades       = \App\Models\TeacherGrade::where('teacher_id', $teacherId)->pluck('grade');
    // $subjects     = \App\Models\TeachingSubject::where('teacher_id', $teacherId)->pluck('subject');

    $accountStatusResponse = accountStatus($teacher);
    $accountMsg = $accountStatusResponse['accountMsg'];
    $steps = $accountStatusResponse['steps'];

    Log::info('User data retrieved', [
      'user' => (new UserResource($teacher, $accountMsg, $steps))->toArray(request()),
    ]);


    return response()->json([
      'user'              => new UserResource($teacher, $accountMsg, $steps),
      // 'account_msg'       => $accountStatusResponse['accountMsg'],
      // 'steps'             => $accountStatusResponse['steps'],
      // 'professional_info' => $profInfo,
      // 'working_days'      => $workingDays,
      // 'working_hours'     => $workingHours,
      // 'grades'            => $grades,
      // 'subjects'          => $subjects,
      // 'avatar'            => $teacher->avatar ? asset('storage/' . $teacher->avatar->file_path) : null,
      // 'cv_file'           => $teacher ? asset('storage/' . $teacher->cv->file_path) : null,

    ]);
  }


  public function teacherUpdatePersonal(Request $request)
  {
    DB::beginTransaction();
    $company_id = 1;
    $teacher = $request->user();
    $teacher_id = $teacher->id;
    Log::info($request->all());


    $user = User::where('id', $teacher_id)->where('company_id', $company_id)->first();
    Log::info($user);

    try {
      if ($user) {
        // 1️⃣ Create or Update User
        User::where('id', $teacher_id)
          ->update(
            [
              'name'        => $request->name,
              'email'       => $request->email,
              'address'     => $request->address,
              'city'        => $request->city,
              'postal_code' => $request->postal_code,
              'district'    => $request->district,
              'state'       => $request->state,
              'country'     => $request->country,
            ]
          );

        // 7️⃣ Media Files (Avatar + CV)
        if ($request->hasFile('avatar')) {

          // Delete physical file
          $userAvatarPath = $user->avatar ? $user->avatar->file_path : null;

          if ($userAvatarPath && Storage::disk('public')->exists($userAvatarPath)) {
            Storage::disk('public')->delete($userAvatarPath);
          }

          MediaFile::where('company_id', $company_id)->where('user_id', $user->id)->where('file_type', 'avatar')->delete();
          $file = $request->file('avatar');
          $path = $file->storeAs(
            'uploads/avatars',
            time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension(),
            'public'
          );

          MediaFile::create([
            'user_id' => $user->id,
            'company_id' => $company_id,
            'file_type'  => 'avatar',
            'file_path'  => $path,
            'name'       => $file->getClientOriginalName(),
            'mime_type'  => $file->getMimeType(),
          ]);
        }

        $user->save();
        DB::commit();
        $user->refresh();
        Log::info($user);

        return response()->json([
          'status'            => true,
          'message'           => 'Teacher updated successfully'
        ], 201);
      } else {
        DB::rollBack();
        return response()->json([
          'status'            => false,
          'message' => 'Teacher updation failed',
          'error'   => "User not found",
        ], 500);
      }
    } catch (\Exception $e) {
      DB::rollBack();
      return response()->json([
        'status'            => false,
        'message' => 'Teacher updation failed',
        'error'   => $e->getMessage(),
      ], 500);
    }
  }
  public function teacherUpdateTeachingDetail(Request $request)
  {
    $user = $request->user();

    try {
      // 2️⃣ Professional Info (updateOrCreate to avoid duplicates)
      $profInfo = TeacherProfessionalInfo::updateOrCreate(
        ['teacher_id' => $user->id],
        [
          'profession'    => $request->profession,
          'ready_to_work' => $request->ready_to_work,
          'teaching_mode'    => $request->interest,
          'offline_exp'   => $request->offline_exp,
          'online_exp'    => $request->online_exp,
          'home_exp'      => $request->home_exp,
        ]
      );

      // 3️⃣ Sync Working Days
      if ($request->filled('working_days')) {
        TeacherWorkingDay::where('teacher_id', $user->id)->delete();
        foreach (explode(',', $request->working_days) as $day) {
          TeacherWorkingDay::create([
            'teacher_id' => $user->id,
            'day'        => trim($day),
          ]);
        }
      }

      // 4️⃣ Sync Working Hours
      if ($request->filled('working_hours')) {
        TeacherWorkingHour::where('teacher_id', $user->id)->delete();
        foreach (explode(',', $request->working_hours) as $hour) {
          TeacherWorkingHour::create([
            'teacher_id' => $user->id,
            'time_slot'  => trim($hour),
          ]);
        }
      }

      // 5️⃣ Sync Grades
      if ($request->filled('teaching_grades')) {
        TeacherGrade::where('teacher_id', $user->id)->delete();
        foreach (explode(',', $request->teaching_grades) as $grade) {
          TeacherGrade::create([
            'teacher_id' => $user->id,
            'grade'      => trim($grade),
          ]);
        }
      }

      // 6️⃣ Sync Subjects
      if ($request->filled('teaching_subjects')) {
        TeachingSubject::where('teacher_id', $user->id)->delete();
        foreach (explode(',', $request->teaching_subjects) as $subject) {
          TeachingSubject::create([
            'teacher_id' => $user->id,
            'subject'    => trim($subject),
          ]);
        }
      }

      $user->save();
      DB::commit();
      $user->refresh();
      Log::info($user);

      return response()->json([
        'status'            => true,
        'message'           => 'Teacher updated successfully'
      ], 201);
    } catch (\Exception $e) {
      DB::rollBack();
      return response()->json([
        'status'            => false,
        'message' => 'Teacher updation failed',
        'error'   => $e->getMessage(),
      ], 500);
    }
  }

  public function teacherUpdateCv(Request $request)
  {
    $user = $request->user();
    $company_id = 1;
    Log::info($request->all());
    try {
      if ($request->hasFile('cv_file')) {

        $userCvPath = $user->cv ? $user->cv->file_path : null;
        if ($userCvPath && Storage::disk('public')->exists($userCvPath)) {
          Storage::disk('public')->delete($userCvPath);
        }

        MediaFile::where('company_id', $company_id)->where('user_id', $user->id)->where('file_type', 'cv')->delete();
        $file = $request->file('cv_file');
        $cvPath = $file->storeAs(
          'uploads/cv_files',
          time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension(),
          'public'
        );
        Log::info($cvPath);

        MediaFile::create([
          'user_id' => $user->id,
          'company_id' => $company_id,
          'file_type'  => 'cv', // ✅ FIXED
          'file_path'  => $cvPath, // ✅ FIXED
          'name'       => $file->getClientOriginalName(),
          'mime_type'  => $file->getMimeType(),
        ]);

        Log::info($cvPath);
        $user->save();
        DB::commit();
      }

      return response()->json([
        'status'            => true,
        'message'           => 'Teacher updated successfully'
      ], 201);
    } catch (\Exception $e) {
      DB::rollBack();
      return response()->json([
        'status'            => false,
        'message' => 'Teacher updation failed',
        'error'   => $e->getMessage(),
      ], 500);
    }
  }
}
