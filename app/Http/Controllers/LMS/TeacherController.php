<?php

namespace App\Http\Controllers\LMS;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
  public function index()
  {
    $analytics = [
      [
        "icon"  => asset("assets/img/icons/unicons/chart-success.png"),
        "url"   => "#",
        "title" => "Total Teachers",
        "count" => 12628,
        "growth" => "+72.80%",
        "growth_icon" => "bx bx-up-arrow-alt",
        "growth_color" => "text-success",
      ],
      [
        "icon"  => asset("assets/img/icons/unicons/chart-success.png"),
        "url"   => "#",
        "title" => "Pending Teachers",
        "count" => 12628,
        "growth" => "+72.80%",
        "growth_icon" => "bx bx-up-arrow-alt",
        "growth_color" => "text-success",
      ],
      [
        "icon"  => asset("assets/img/icons/unicons/chart-success.png"),
        "url"   => "#",
        "title" => "Selected Teachers",
        "count" => 12628,
        "growth" => "+72.80%",
        "growth_icon" => "bx bx-up-arrow-alt",
        "growth_color" => "text-success",
      ],
      [
        "icon"  => asset("assets/img/icons/unicons/chart-success.png"),
        "url"   => "#",
        "title" => "Rejected Teachers",
        "count" => 12628,
        "growth" => "+72.80%",
        "growth_icon" => "bx bx-up-arrow-alt",
        "growth_color" => "text-success",
      ],
    ];
    return view('admin.teachers.index', compact('analytics'));
  }
}
