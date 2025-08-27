<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CompanyTeacher;
use Illuminate\Http\Request;
use App\Models\Teacher;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Validator;

class RegisterController extends Controller
{


  public function teacherSignup(Request $request)
  {

        Log::info($request->all());

    $validator = Validator::make($request->all(), [
      'name'        => 'required|string|max:100',
      'email'       => 'required|email',
      'address'     => 'required|string|max:100',
      'city'        => 'required|string|max:100',
      'postal_code' => 'required|string|max:20',
      'district'    => 'required|string|max:100',
      'state'       => 'required|string|max:100',
      'country'     => 'required|string|max:100',
      'profession'  => 'required|string|max:100',
      'teacher_id'  => 'required|exists:users,id',
      'avatar'      => 'nullable|string|max:255',
    ]);

    if ($validator->fails()) {
      return response()->json([
        'message' => 'The given data was invalid.',
        'errors' => $validator->errors()
      ], 422);
    }




    // $teacher = CompanyTeacher::find($request->teacher_id);

    // $teacher->update($request->all());


    return response()->json([
      'message' => 'Profile updated successfully',
      'data'    => '123',
    ], 200);
  }
}
