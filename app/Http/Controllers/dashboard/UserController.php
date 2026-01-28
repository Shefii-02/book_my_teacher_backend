<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\LoginActivity;
use App\Models\MediaFile;
use App\Models\Otp;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;

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
    // Base query
    $query = Otp::query()->with('user')->orderBy('created_at', 'desc');

    /** 🔍 Mobile search */
    if ($request->filled('mobile')) {
      $query->where('mobile', 'like', '%' . $request->mobile . '%');
    }

    /** 📌 Status filter */
    if ($request->filled('status')) {

      if ($request->status === 'verified') {
        $query->where('verified', 1);
      }

      if ($request->status === 'unverified') {
        $query->where('verified', 0);
      }

      if ($request->status === 'uncompleted') {
        $query->whereHas('user');
      }
    }

    /** 📅 Date range filter */
    if ($request->filled('start_date')) {
      $query->whereDate('created_at', '>=', $request->start_date);
    }

    if ($request->filled('end_date')) {
      $query->whereDate('created_at', '<=', $request->end_date);
    }

    /** 📄 Cursor pagination (best for large data) */
    $otps = $query->cursorPaginate(30)->withQueryString();

    /** 📊 Dashboard stats (GLOBAL, not filtered) */
    // $data = [
    //     'total_otp'   => Otp::count(),
    //     'verified'    => Otp::where('verified', 1)->count(),
    //     'unverified'  => Otp::where('verified', 0)->count(),
    // ];
    $data = [
      'total_otp'   => (clone $query)->count(),
      'verified'    => (clone $query)->where('verified', 1)->count(),
      'unverified'  => (clone $query)->where('verified', 0)->count(),
    ];

    /** 🔁 Duplicate mobile detection */
    $duplicates = Otp::select('mobile')
      ->groupBy('mobile')
      ->havingRaw('COUNT(*) > 1')
      ->pluck('mobile')
      ->toArray();

    return view('company.dashboard.otps', compact('otps', 'data', 'duplicates'));
  }

  // public function otp(Request $request)
  // {
  //   $otps = Otp::orderBy('created_at', 'desc')->get();
  //   $data['total_otp'] = $otps->count();
  //   $data['verified'] = $otps->where('verified', 1)->count();
  //   $data['unverified'] = $otps->where('verified', 0)->count();
  //   $otps = Otp::orderBy('created_at', 'desc')->cursorPaginate(30);

  //   $allMobiles = Otp::pluck('mobile');
  //   $duplicates = $allMobiles->duplicates()->toArray();

  //   return view('company.dashboard.otps', compact('otps', 'data', 'duplicates'));
  // }




  public function appleSignInList(Request $request)
  {
    $logins = LoginActivity::where('provider', 'apple')
      ->when(
        $request->filled('email'),
        fn($q) =>
        $q->where('email', 'like', '%' . $request->email . '%')
      )
      ->when(
        $request->filled('start_date'),
        fn($q) =>
        $q->whereDate('logged_in_at', '>=', $request->start_date)
      )
      ->when(
        $request->filled('end_date'),
        fn($q) =>
        $q->whereDate('logged_in_at', '<=', $request->end_date)
      )
      ->latest('logged_in_at')
      ->paginate(30)
      ->withQueryString();
    $data = [
      'total_otp'   => (clone $logins)->count(),
      'verified'    => (clone $logins)->where('verified', 1)->count(),
      'unverified'  => (clone $logins)->where('verified', 0)->count(),
    ];

    return view('company.dashboard.apple-logins', compact('logins', 'data'));
  }





  public function googleSignInList(Request $request)
  {
    $logins = LoginActivity::where('provider', 'google')
      ->when(
        $request->filled('email'),
        fn($q) =>
        $q->where('email', 'like', '%' . $request->email . '%')
      )
      ->when(
        $request->filled('start_date'),
        fn($q) =>
        $q->whereDate('logged_in_at', '>=', $request->start_date)
      )
      ->when(
        $request->filled('end_date'),
        fn($q) =>
        $q->whereDate('logged_in_at', '<=', $request->end_date)
      )
      ->latest('logged_in_at')
      ->paginate(30)
      ->withQueryString();
    $data = [
      'total_otp'   => (clone $logins)->count(),
      'verified'    => (clone $logins)->where('verified', 1)->count(),
      'unverified'  => (clone $logins)->where('verified', 0)->count(),
    ];
    return view('company.dashboard.google-logins', compact('logins', 'data'));
  }

  public function editOtp($id)
  {
    $otp = Otp::findOrFail($id);
    return view('company.dashboard.otp-form', compact('otp'));
  }


  public function updateOtp(Request $request, $id)
  {
    $otp = Otp::findOrFail($id);
    $otp->update($request->only('mobile', 'otp', 'verified', 'expires_at'));

    return back()->with('success', 'OTP updated successfully');
  }
}
