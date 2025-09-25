<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Webinar;
use App\Models\WebinarRegistration;
use App\Http\Resources\WebinarRegistrationResource;
use Illuminate\Validation\Rule;

class WebinarRegistrationController extends Controller
{
    // Register a user to webinar
    public function store(Request $req, Webinar $webinar)
    {
        $data = $req->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|email',
            'phone'=>'nullable|string|max:30',
            'user_id'=>'nullable|integer' // optional
        ]);

        // unique per webinar + email
        $exists = WebinarRegistration::where('webinar_id',$webinar->id)
                    ->where('email',$data['email'])
                    ->exists();

        if ($exists) {
            return response()->json([
                'message'=>'You are already registered for this webinar.'
            ], 409);
        }

        $reg = WebinarRegistration::create(array_merge($data, ['webinar_id'=>$webinar->id]));

        // TODO: Notify host or send confirmation email

        return new WebinarRegistrationResource($reg);
    }

    // List registrations for a webinar (admin)
    public function index(Webinar $webinar)
    {
        $list = $webinar->registrations()->orderBy('created_at','desc')->paginate(50);
        return WebinarRegistrationResource::collection($list);
    }

    // Get registered webinars for a given user email or user_id
    public function registeredForUser(Request $req)
    {
        $req->validate([
            'email'=>'nullable|email',
            'user_id'=>'nullable|integer'
        ]);

        $query = WebinarRegistration::query();

        if ($req->filled('email')) {
            $query->where('email',$req->email);
        }
        if ($req->filled('user_id')) {
            $query->where('user_id',$req->user_id);
        }

        $items = $query->with('webinar')->orderBy('created_at','desc')->paginate(20);

        return WebinarRegistrationResource::collection($items);
    }
}
