<?php

namespace App\Http\Controllers\HRMS;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
  public function index(){
    return view('company.hrms.dashboard.index');
  }

}
