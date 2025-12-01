<?php

namespace App\Http\Controllers\MobileApp;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
  public function index(){
    return view('company.mobile-app.dashboard.index');
  }

}
