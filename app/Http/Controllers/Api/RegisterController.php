<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CompanyTeacher;
use Illuminate\Http\Request;
use App\Models\Teacher;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{


    public function teacherSignup(Request $request)
    {


        // 'ready_to_work' => 'Yes',
        // 'experience' => '5,5,3',
        // 'working_days' => 'Sun,Mon,Fri,Thu',
        // 'working_hours' => '06.00-07.00 AM,09.00-10.00 AM,10.00-11.00 AM,01.00-02.00 PM,02.00-03.00 PM,05.00-06.00 PM,06.00-07.00 PM,09.00-10.00 PM,10.00-11.00 PM',
        // 'teaching_grades' => 'lowerPrimary,graduate,postGraduate',
        // 'teaching_subjects' => 'all,Other Sub',


        // 'cv_file' =>
        // \Illuminate\Http\UploadedFile::__set_state(array(
        //   'test' => false,
        //   'originalName' => 'sample-local-pdf (1).pdf',
        //   'mimeType' => 'application/pdf',
        //   'error' => 0,
        //   'originalPath' => 'sample-local-pdf (1).pdf',
        //   'hashName' => NULL,
        // )),


        $request->validate([
            'name'        => 'required|string|max:100',
            'email'       => 'required|email',
            'address'     => 'required|string|max:100',
            'city'        => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'district'    => 'required|string|max:100',
            'state'       => 'required|string|max:100',
            'country'     => 'required|string|max:100',
            'profession'  => 'required|string|max:100',

            'teacher_id'  => 'required|exists:teachers,id',
            'avatar'      => 'nullable|string|max:255',
        ]);

        // $teacher = CompanyTeacher::find($request->teacher_id);

        // $teacher->update($request->all());

        Log::info($request->all());
        return response()->json([
            'message' => 'Profile updated successfully',
            'data'    => '123',
        ], 200);
    }
}
