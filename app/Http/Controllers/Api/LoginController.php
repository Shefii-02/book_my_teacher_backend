<?php

namespace App\Http\Controllers\Api;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Teacher;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use App\Traits\JsonResponseTrait;
use Illuminate\Http\Response;

class LoginController extends Controller
{
    use AuthorizesRequests, ValidatesRequests, JsonResponseTrait;

    public function userExistNot(Request $request)
    {
        $emailId  = $request->email;
        $mobileNo = $request->mobile;
        $type     = $request->type;
        $company  = $request->company;

        if ($emailId) {
            $user = [
                'name'   => $emailId,
                'email'  => $emailId,
                'mobile' => $mobileNo,
            ];

            return $this->success('User found', $user);
        } else {
            return $this->error('User not found', Response::HTTP_NOT_FOUND);
        }
    }






}
