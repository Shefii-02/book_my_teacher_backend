<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Models\Teacher;
use App\Models\TopTeacher;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\SubjectCourse;
use App\Models\User;
use Illuminate\Http\Request;

class CompanyController extends Controller
{

  public function index(Request $request){

    $companies = User::where('acc_type','company')->paginate(10);
    return view('super_admin.comapnies.index',compact('companies'));
  }

}
