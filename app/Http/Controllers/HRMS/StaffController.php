<?php

namespace App\Http\Controllers\HRMS;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

use App\Traits\ActivityLogger;

class StaffController extends Controller
{
  public function index(){
      return view('company.staff.index');
  }
}
