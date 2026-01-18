<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Helpers\MediaHelper;
use App\Models\Teacher;
use App\Models\TopTeacher;
use App\Models\Company;
use App\Models\MediaFile;
use App\Models\SubjectCourse;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
  public function index()
  {
    $data['courses']['total'] = 0;

    $data['referral']['total'] = 0;

    $data['coins']['total'] = 0;

    $data['earns']['total'] = 0;

    return view('teacher.dashboard.index', compact('data'));
  }
}
