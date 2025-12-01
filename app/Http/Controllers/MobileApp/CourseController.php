<?php

namespace App\Http\Controllers\MobileApp;

use App\Http\Controllers\Controller;

class CourseController extends Controller
{
  public function index(){
    return view('company.mobile-app.dashboard.index');
  }

}
