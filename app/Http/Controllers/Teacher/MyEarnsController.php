<?php

namespace App\Http\Controllers\Teacher;

use App\Helpers\MediaHelper;
use App\Models\Course;
use App\Models\CourseMaterial;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MyEarnsController extends Controller
{

  public function index() {
    $data['courses']['total'] = 0;

    $data['materials']['total'] = 0;

    $data['refferal']['total'] = 0;

    $data['earns']['total'] = 0;

    $myEarns = collect();

    return view('teacher.my_earns.index', compact('data','myEarns'));
  }
}
