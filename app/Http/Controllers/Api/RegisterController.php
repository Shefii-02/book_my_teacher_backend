<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CompanyTeacher;
use Illuminate\Http\Request;
use App\Models\Teacher;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;

class RegisterController extends Controller
{
    /**
     * Step 3: Complete Profile (after OTP verification)
     */

    public function personalDetails(Request $request)
    {
        $request->validate([
            'teacher_id'  => 'required|exists:teachers,id',
            'avatar'      => 'nullable|string|max:255',
            'full_name'   => 'required|string|max:100',
            'email'       => 'required|email',
            'address'     => 'required|string|max:100',
            'city'        => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'district'    => 'required|string|max:100',
            'state'       => 'required|string|max:100',
            'country'     => 'required|string|max:100',
        ]);

        $teacher = CompanyTeacher::find($request->teacher_id);

        $teacher->update($request->all());

        return response()->json([
            'message' => 'Profile updated successfully',
            'data'    => $teacher,
        ], 200);
    }
}
