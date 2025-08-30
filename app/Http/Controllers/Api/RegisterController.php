<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\TeacherProfessionalInfo;
use App\Models\TeacherWorkingDay;
use App\Models\TeacherWorkingHour;
use App\Models\TeacherGrade;
use App\Models\TeachingSubject;
use App\Models\MediaFile;

class RegisterController extends Controller
{
  public function teacherSignup(Request $request)
  {
    DB::beginTransaction();
    $company_id = 1;
    try {
      // 1️⃣ Create User (or find existing)
      $user = User::create([
        'name'       => $request->name,
        'email'      => $request->email,
        'mobile'     => $request->mobile ?? null,
        'address'    => $request->address,
        'city'       => $request->city,
        'postal_code' => $request->postal_code,
        'district'   => $request->district,
        'state'      => $request->state,
        'country'    => $request->country,
        'company_id' => 1,
      ]);

      // 2️⃣ Professional Info
      $profInfo = TeacherProfessionalInfo::create([
        'user_id'        => $user->id,
        'profession'     => $request->profession,
        'ready_to_work'  => $request->ready_to_work,
        'experience'     => $request->experience,
        'offline_exp'    => $request->offline_exp,
        'online_exp'     => $request->online_exp,
        'home_exp'       => $request->home_exp,
      ]);

      // 3️⃣ Working Days
      if ($request->filled('working_days')) {
        $days = explode(',', $request->working_days);
        foreach ($days as $day) {
          TeacherWorkingDay::create([
            'user_id' => $user->id,
            'day'     => trim($day),
          ]);
        }
      }

      // 4️⃣ Working Hours
      if ($request->filled('working_hours')) {
        $hours = explode(',', $request->working_hours);
        foreach ($hours as $hour) {
          TeacherWorkingHour::create([
            'user_id' => $user->id,
            'time_range' => trim($hour),
          ]);
        }
      }

      // 5️⃣ Grades
      if ($request->filled('teaching_grades')) {
        $grades = explode(',', $request->teaching_grades);
        foreach ($grades as $grade) {
          TeacherGrade::create([
            'user_id' => $user->id,
            'grade'   => trim($grade),
          ]);
        }
      }

      // 6️⃣ Subjects
      if ($request->filled('teaching_subjects')) {
        $subjects = explode(',', $request->teaching_subjects);
        foreach ($subjects as $subject) {
          TeachingSubject::create([
            'user_id' => $user->id,
            'subject' => trim($subject),
          ]);
        }
      }

      // 7️⃣ Media Files (Avatar + CV)
      if ($request->hasFile('avatar')) {
        $file = $request->file('avatar');

        // Original file name
        $fileName = $file->getClientOriginalName();

        // File extension
        $fileExtension = $file->getClientOriginalExtension();

        // Mime type
        $fileMimeType = $file->getMimeType();

        // Store file with unique name to avoid overwriting
        $path = $file->storeAs(
          'uploads/avatars',
          time() . '_' . uniqid() . '.' . $fileExtension,
          'public'
        );

        MediaFile::create([
          'user_id' => $user->id,
          'company_id' => $company_id,
          'file_category'  => 'avatar',
          'url'  => $path,
          'name'       => $fileName,
          'file_type'  => $fileMimeType,
        ]);
      }

      if ($request->hasFile('cv_file')) {
        $file = $request->file('cv_file');

        $fileName    = $file->getClientOriginalName();
        $fileMimeType = $file->getMimeType();
        $fileExtension = $file->getClientOriginalExtension();

        $cvPath = $file->storeAs(
          'uploads/cv_files',
          time() . '_' . uniqid() . '.' . $fileExtension,
          'public'
        );

        MediaFile::create([
          'user_id' => $user->id,
          'company_id' => $company_id,
          'file_category'  => 'avatar',
          'url'  => $path,
          'name'       => $fileName,
          'file_type'  => $fileMimeType,

          // 'user_id' => $user->id,
          // 'file_type'  => 'cv',
          // 'file_path'  => $cvPath,
          // 'company_id' => $company_id,
          // 'name'       => $fileName,
          // 'mime_type'  => $fileMimeType,

        ]);
      }

      User::where('id', $user->id)->where('company_id', 1)->update('profile_fill', 1);
      DB::commit();

      return response()->json([
        'message' => 'Teacher registered successfully',
        'user' => $user,
        'professional_info' => $profInfo,
      ], 201);
    } catch (\Exception $e) {
      DB::rollBack();
      return response()->json([
        'message' => 'Registration failed',
        'error'   => $e->getMessage(),
      ], 500);
    }
  }
}
