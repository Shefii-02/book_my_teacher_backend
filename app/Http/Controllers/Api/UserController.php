<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CompanyTeacher;
use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
  public function index(Request $request)
  {
    $mobileNo   = '91' . $request->mobile;
    $company_id = 1;

    $user = User::where('mobile', $mobileNo)
      ->where('company_id', $company_id)
      ->first();

    if ($user) {
      return response()->json([
        'success' => true,
        'message' => 'User details found successfully',
        'data'    => [
          'id'        => $user->id,
          'name'      => $user->name,
          'email'     => $user->email,
          'mobile'    => $user->mobile,
        ],
      ], 200);
    }

    return response()->json([
      'success' => false,
      'message' => 'User details not found',
      'data'    => null,
    ], 404);
  }
}
