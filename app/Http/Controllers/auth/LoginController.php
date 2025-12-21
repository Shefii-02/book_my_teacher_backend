<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
  public function index()
  {
    if (Auth::check()) {
      if (auth()->user()->acc_type == 'super_admin') {
        return redirect()->route('admin.dashboard.index');
      } elseif (auth()->user()->acc_type == 'company') {
        return redirect()->route('company.dashboard.index');
      } elseif (auth()->user()->acc_type == 'teacher') {
        return redirect()->route('teacher.dashboard.index');
      }
    }
    return view('auth.sign-in');
  }
  public function loginPost(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'email' => 'required|string|email|max:255',
      'password' => 'required|string|min:6',
    ], [
      'email.required' => 'The email is required.',
      'email.email' => 'The email needs to have a valid format.',
      'password.required' => 'The password is required.',
    ]);

    if ($validator->fails()) {
      return redirect()->back()
        ->withErrors($validator) // ✅ Send validation errors
        ->withInput();           // ✅ Keep old input values
    }

    $credentials = $request->only('email', 'password');
    $remember = $request->has('remember');

    if (Auth::attempt($credentials, $remember)) {
      if (auth()->user()->acc_type == 'super_admin') {
        return redirect()->route('admin.dashboard.index')
          ->with('success', 'Login successful');
      } elseif (auth()->user()->acc_type == 'company') {
        return redirect()->route('company.dashboard')
          ->with('success', 'Login successful');
      } elseif (auth()->user()->acc_type == 'teacher') {
      } elseif (auth()->user()->acc_type == 'student') {
        abort(404);
      }
    }

    return back()->with('error', 'The provided credentials do not match our records.');
  }
}
