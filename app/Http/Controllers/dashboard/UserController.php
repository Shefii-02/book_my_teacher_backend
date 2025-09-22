<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\MediaFile;
use App\Models\Otp;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
  public function profile()
  {
    return view('company.dashboard.profile');
  }

  public function update(Request $request)
  {

    try {
      $user = Auth::user();
      DB::beginTransaction();

      $validator = Validator::make($request->all(), [
        'name'   => 'required|string|max:255',
        'email'  => 'required|string|email|max:255|unique:users,email,' . $user->id,
        'avatar' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
      ]);

      if ($validator->fails()) {
        return back()->withErrors($validator)->withInput();
      }

      // Update basic info
      $user->name  = $request->name;
      $user->email = $request->email;
      $user->save();


      // Handle avatar upload
      if ($request->hasFile('avatar')) {
        $file = $request->file('avatar');
        $path = $file->store('avatars', 'public');
        $name = $file->getClientOriginalName();
        $mime_type  = $file->getMimeType();

        // Check if old avatar exists -> remove it
        $oldAvatar = MediaFile::where('user_id', $user->id)
          ->where('file_type', 'avatar')
          ->first();

        if ($oldAvatar) {
          // Delete old file from storage
          if (Storage::disk('public')->exists($oldAvatar->file_path)) {
            Storage::disk('public')->delete($oldAvatar->file_path);
          }
          // Update DB with new path
          $oldAvatar->update(['file_path' => $path]);
        } else {

          // Create new record
          MediaFile::create([
            'user_id'   => $user->id,
            'file_type' => 'avatar',
            'file_path' => $path,
            'name'      => $name,
            'mime_type' => $mime_type,
            'company_id' => $user->company_id,

          ]);
        }
      }
      DB::commit();
      return back()->with('success', 'Profile updated successfully.');
    } catch (Exception $e) {

      DB::rollBack();
      return back()->with('error', 'Profile updation failed.');
    }
  }

  /**
   * Change password
   */
  public function changePassword(Request $request)
  {
    $user = Auth::user();

    $validator = Validator::make($request->all(), [
      // 'current_password'      => 'required',
      'new_password'          => 'required|string|min:6|confirmed',
    ], [
      'new_password.confirmed' => 'The new password confirmation does not match.',
    ]);

    if ($validator->fails()) {
      return back()->withErrors($validator);
    }

    // Check current password
    // if (!Hash::check($request->current_password, $user->password)) {
    //   return back()->withErrors(['current_password' => 'Current password is incorrect']);
    // }

    // Update password
    $user->password = Hash::make($request->new_password);
    $user->save();

    return back()->with('success', 'Password changed successfully.');
  }

  public function logout(Request $request)
  {
    Auth::logout();
    return redirect('/login');
  }



  public function otp(Request $request)
  {
    $otps = Otp::orderBy('created_at', 'desc')->get();
    $data['total_otp'] = $otps->count();
    $data['verified'] = $otps->where('verified', 1)->count();
    $data['unverified'] = $otps->where('verified', 0)->count();
    $otps = Otp::orderBy('created_at', 'desc')->cursorPaginate(30);

    $allMobiles = Otp::pluck('mobile');
    $duplicates = $allMobiles->duplicates()->toArray();

    return view('company.dashboard.otps', compact('otps', 'data','duplicates'));
  }
}
