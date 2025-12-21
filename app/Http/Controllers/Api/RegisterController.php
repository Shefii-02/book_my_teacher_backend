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
use App\Models\StudentAvailableDay;
use App\Models\StudentAvailableHour;
use App\Models\StudentGrade;
use App\Models\StudentPersonalInfo;
use App\Models\StudentRecommendedSubject;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
  public function teacherSignup(Request $request)
  {

    DB::beginTransaction();
    $company_id = auth()->user()->company_id;
    $teacher_id = $request->teacher_id;

    Log::info($request->all());
    // )->
    $source = $request->header('X-Request-Source', 'Unknown');


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
              'acc_type'    => 'teacher',
              'city'        => $request->city,
              'postal_code' => $request->postal_code,
              'district'    => $request->district,
              'state'       => $request->state,
              'country'     => $request->country,
              'registration_source' => $source,
            ]
          );


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

        // 7️⃣ Media Files (Avatar + CV)
        if ($request->hasFile('avatar')) {
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

        if ($request->hasFile('cv_file')) {
          MediaFile::where('company_id', $company_id)->where('user_id', $user->id)->where('file_type', 'cv')->delete();
          $file = $request->file('cv_file');
          $cvPath = $file->storeAs(
            'uploads/cv_files',
            time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension(),
            'public'
          );

          MediaFile::create([
            'user_id' => $user->id,
            'company_id' => $company_id,
            'file_type'  => 'cv', // ✅ FIXED
            'file_path'  => $cvPath, // ✅ FIXED
            'name'       => $file->getClientOriginalName(),
            'mime_type'  => $file->getMimeType(),
          ]);
        }

        // 8️⃣ Mark profile as filled
        $user->profile_fill = 1;
        $user->save();
        DB::commit();
        $user->refresh();
        Log::info($user);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
          'message'           => 'Teacher registered successfully',
          'user'              => $user,
          'token'             => $token,
          'professional_info' => $profInfo,
        ], 201);
      } else {
        DB::rollBack();
        return response()->json([
          'message' => 'Registration failed',
          'error'   => "User not found",
        ], 500);
      }
    } catch (\Exception $e) {
      DB::rollBack();
      return response()->json([
        'message' => 'Registration failed',
        'error'   => $e->getMessage(),
      ], 500);
    }
  }

  public function studentSignup(Request $request)
  {

    DB::beginTransaction();
    $company_id = auth()->user()->company_id;
    $student_id = $request->student_id;

    Log::info($request->all());

    $user = User::where('id', $student_id)->where('company_id', $company_id)->first();
    $source = $request->header('X-Request-Source', 'Unknown');
    try {
      if ($user) {
        User::where('id', $student_id)
          ->update(
            [
              'name'        => $request->student_name,
              'email'       => $request->email,
              'address'     => $request->address,
              'acc_type'    => 'student',
              'city'        => $request->city,
              'postal_code' => $request->postal_code,
              'district'    => $request->district,
              'state'       => $request->state,
              'country'     => $request->country,
              'registration_source' => $source,
            ]
          );

        // 7️⃣ Media Files (Avatar + CV)
        if ($request->hasFile('avatar')) {
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

        $user->profile_fill = 1;
        $user->save();

        $personal = new StudentPersonalInfo();
        $personal->student_id = $user->id;
        $personal->parent_name = $request->parent_name;
        $personal->parent_relation;
        $personal->current_eduction;
        $personal->study_mode = $request->interest;
        $personal->save();


        // 3️⃣ Sync Working Days
        if ($request->filled('working_days')) {
          StudentAvailableDay::where('student_id', $user->id)->delete();
          foreach (explode(',', $request->working_days) as $day) {
            StudentAvailableDay::create([
              'student_id' => $user->id,
              'day'        => trim(strtolower($day)),
            ]);
          }
        }

        // 4️⃣ Sync Working Hours
        if ($request->filled('working_hours')) {
          StudentAvailableHour::where('student_id', $user->id)->delete();
          foreach (explode(',', $request->working_hours) as $hour) {
            StudentAvailableHour::create([
              'student_id' => $user->id,
              'time_slot'  => trim($hour),
            ]);
          }
        }

        // 5️⃣ Sync Grades
        if ($request->filled('teaching_grades')) {
          StudentGrade::where('student_id', $user->id)->delete();
          foreach (explode(',', $request->teaching_grades) as $grade) {
            StudentGrade::create([
              'student_id' => $user->id,
              'grade'      => trim(strtolower($grade)),
            ]);
          }
        }

        // 6️⃣ Sync Subjects
        if ($request->filled('teaching_subjects')) {
          StudentRecommendedSubject::where('student_id', $user->id)->delete();
          foreach (explode(',', $request->teaching_subjects) as $subject) {
            StudentRecommendedSubject::create([
              'student_id' => $user->id,
              'subject'    => trim(strtolower($subject)),
            ]);
          }
        }

        DB::commit();
        $user->refresh();
        Log::info($user);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
          'message'           => 'Student registered successfully',
          'user'              => $user,
          'token'             => $token,
        ], 201);
      } else {
        return response()->json([
          'message' => 'Registration failed',
          'error'   => "User not found",
        ], 500);
      }
    } catch (\Exception $e) {
      DB::rollBack();
      return response()->json([
        'message' => 'Registration failed',
        'error'   => $e->getMessage(),
      ], 500);
    }
  }


  public function guestSignup(Request $request)
  {
    // Log::info($request->header());
    // Log::info($request->all());

    DB::beginTransaction();
    $company_id = auth()->user()->company_id;

    try {
      // Get the logged-in user via Sanctum
      $user = $request->user();
      if (!$user) {
        return response()->json([
          'message' => 'Authentication required',
          'error'   => 'No user found from token',
        ], 401);
      }

      $source = $request->header('X-Request-Source', 'Unknown');

      // Validate incoming request
      $validated = $request->validate([
        'full_name' => 'required|string|max:255',
        'email'        => 'nullable|email|unique:users,email,' . $user->id,
        'avatar'       => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
      ]);

      // Update user details
      $user->update([
        'name'                => $validated['full_name'],
        'email'               => $validated['email'] ?? $user->email,
        'acc_type'            => 'guest',
        'registration_source' => $source,
        'profile_fill'        => 1,
      ]);

      // 🔹 Handle avatar upload
      if ($request->hasFile('avatar')) {
        // Delete old avatar entry
        MediaFile::where('company_id', $company_id)
          ->where('user_id', $user->id)
          ->where('file_type', 'avatar')
          ->delete();

        $file = $request->file('avatar');
        $path = $file->storeAs(
          'uploads/avatars',
          time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension(),
          'public'
        );

        MediaFile::create([
          'user_id'    => $user->id,
          'company_id' => $company_id,
          'file_type'  => 'avatar',
          'file_path'  => $path,
          'name'       => $file->getClientOriginalName(),
          'mime_type'  => $file->getMimeType(),
        ]);
      }

      DB::commit();

      // Refresh to return updated data
      $user->refresh();

      // Revoke old tokens and issue new one (guest is "fresh start")
      // $user->tokens()->delete();
      // $token = $user->createToken('auth_token')->plainTextToken;

      $token = request()->user()->currentAccessToken()->token;

      return response()->json([
        'message' => 'Guest account registered successfully',
        'user'    => $user,
        'token'   => $token,
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
