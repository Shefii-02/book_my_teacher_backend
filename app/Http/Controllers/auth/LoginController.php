<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
  public function index()
  {
    if (Auth::check()) {
      return redirect()->route('admin.dashboard');
    }
    return view('content.authentications.auth-login');
  }
  public function loginPost(Request $request)
  {
    $credetials = [
      'email' => $request->email_username,
      'password' => $request->password,
    ];
    if (Auth::attempt($credetials)) {
      return redirect()->route('admin.dashboard')->with('success', 'Login berhasil');
    }

    return back()->with('error', 'Email or Password salah');
  }
}
