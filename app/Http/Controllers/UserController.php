<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\TopTeacher;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
  public function searchUsers(Request $request)
  {
    $search = strtolower($request->key);

    if (!$search) {
      return response()->json([]);
    }

    // If search is mobile and does NOT start with 91, add prefix
    $searchMobile = $search;

    if (is_numeric($search) && !str_starts_with($search, '91')) {
      $searchMobile = '91' . $search;
    }

    $users = User::where(function ($q) use ($search, $searchMobile) {
      // Name
      $q->whereRaw("LOWER(name) LIKE ?", ["{$search}%"])
        // Email
        ->orWhereRaw("LOWER(email) LIKE ?", ["{$search}%"])
        // Mobile (normal)
        ->orWhereRaw("mobile LIKE ?", ["{$search}%"])
        // Mobile (with 91 prefix)
        ->orWhereRaw("mobile LIKE ?", ["{$searchMobile}%"]);
    })
    // ->where('status',1)
      ->select('id', 'name', 'email', 'mobile', 'acc_type')
      ->limit(10)
      ->get();

    return response()->json($users);
  }
}
