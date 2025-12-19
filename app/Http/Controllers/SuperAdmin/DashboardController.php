<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Models\Teacher;
use App\Models\TopTeacher;
use App\Http\Controllers\Controller;
use App\Models\SubjectCourse;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

  public function index(Request $request){

    return view('super_admin.dashboard');
  }

}
