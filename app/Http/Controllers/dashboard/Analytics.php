<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Analytics extends Controller
{
  public function index()
  {
    $data['teachers']['total'] = 0;
    $data['teachers']['last_week'] = 0;

    $data['students']['total'] = 0;
    $data['students']['last_week'] = 0;

    $data['classes']['total'] = 0;
    $data['classes']['last_week'] = 0;

    $data['revenue']['total'] = 0;
    $data['revenue']['last_week'] = 0;

    return view('company.dashboard.index',compact('data'));
  }
}
