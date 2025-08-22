<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Teacher;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;

class RegisterController extends Controller
{
    /**
     * Step 1: Send OTP
     */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'mobile_no' => 'required|string|max:15'
        ]);

        $otp = rand(100000, 999999);

        // store otp in cache for 5 minutes
        Cache::put('otp_' . $request->mobile_no, $otp, now()->addMinutes(5));

        // send OTP via SMS (use SMS gateway like Twilio, MSG91, etc.)
        // For testing purpose, we just return otp
        return response()->json([
            'message' => 'OTP sent successfully',
            'otp' => $otp // ⚠️ remove this in production
        ]);

    }

    /**
     * Step 2: Verify OTP & Register/Login
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'mobile_no' => 'required|string|max:15',
            'otp'       => 'required|numeric'
        ]);

        $cachedOtp = Cache::get('otp_' . $request->mobile_no);

        if (!$cachedOtp || $cachedOtp != $request->otp) {
            return response()->json(['message' => 'Invalid or expired OTP'], 400);
        }

        // $teacher = Teacher::updateOrCreate(
        //     ['mobile_no' => $request->mobile_no],
        //     ['otp' => $otp, 'otp_expires_at' => Carbon::now()->addMinutes(5)]
        // );

        // OTP valid → check if teacher already exists
        $teacher = Teacher::where('mobile_no', $request->mobile_no)->first();

        if (!$teacher) {
            // create new teacher (minimal info for now)
            $teacher = Teacher::create([
                'mobile_no' => $request->mobile_no,
                'password' => Hash::make('default123'), // temporary password
            ]);
        }

        // OTP verified, remove from cache
        Cache::forget('otp_' . $request->mobile_no);

        return response()->json([
            'message' => 'OTP verified successfully',
            'data' => $teacher
        ], 200);
    }

    /**
     * Step 3: Complete Profile (after OTP verification)
     */
    public function personalDetails(Request $request)
    {
        $request->validate([
            'teacher_id'  => 'required|exists:teachers,id',
            'avatar'      => 'nullable|string|max:255',
            'full_name'   => 'required|string|max:100',
            'email'       => 'required|email|unique:teachers,email,' . $request->teacher_id,
            'address'     => 'required|string|max:100',
            'city'        => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'district'    => 'required|string|max:100',
            'state'       => 'required|string|max:100',
            'country'     => 'required|string|max:100',
        ]);

        $teacher = Teacher::find($request->teacher_id);

        $teacher->update($request->all());

        return response()->json([
            'message' => 'Profile updated successfully',
            'data'    => $teacher,
        ], 200);
    }
}
