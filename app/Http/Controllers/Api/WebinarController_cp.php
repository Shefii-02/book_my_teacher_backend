<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Webinar;
use App\Http\Resources\WebinarResource;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class WebinarController extends Controller
{
    // List (with optional filters)
    public function index(Request $req)
    {
        $query = Webinar::query();

        if ($req->filled('status')) {
            $query->where('status', $req->status);
        }
        if ($req->filled('search')) {
            $s = $req->search;
            $query->where(function($q) use($s){
                $q->where('title','like',"%$s%")
                  ->orWhere('description','like',"%$s%")
                  ->orWhere('host_name','like',"%$s%");
            });
        }

        $webinars = $query->orderBy('starts_at','desc')->paginate(12);

        return WebinarResource::collection($webinars);
    }

    // Store
    public function store(Request $req)
    {
        $data = $req->validate([
            'title'=>'required|string|max:255',
            'description'=>'nullable|string',
            'host_name'=>'nullable|string',
            'live_id'=>'nullable|string|unique:webinars,live_id',
            'starts_at'=>'nullable|date',
            'ends_at'=>'nullable|date|after_or_equal:starts_at',
            'status'=>['nullable', Rule::in(['draft','scheduled','live','ended'])],
            'is_public'=>'nullable|boolean',
            'meta'=>'nullable|array'
        ]);

        $data['slug'] = Str::slug($data['title']).'-'.Str::random(6);
        if (empty($data['live_id'])) {
            // generate a unique live id if not provided
            $data['live_id'] = 'live_'.Str::random(12);
        }

        $webinar = Webinar::create($data);

        return new WebinarResource($webinar);
    }

    // Show single
    public function show(Webinar $webinar)
    {
        return new WebinarResource($webinar);
    }

    // Update
    public function update(Request $req, Webinar $webinar)
    {
        $data = $req->validate([
            'title'=>'sometimes|required|string|max:255',
            'description'=>'nullable|string',
            'host_name'=>'nullable|string',
            'live_id'=>['nullable','string',Rule::unique('webinars','live_id')->ignore($webinar->id)],
            'starts_at'=>'nullable|date',
            'ends_at'=>'nullable|date|after_or_equal:starts_at',
            'status'=>['nullable', Rule::in(['draft','scheduled','live','ended'])],
            'is_public'=>'nullable|boolean',
            'meta'=>'nullable|array'
        ]);

        $webinar->update($data);

        return new WebinarResource($webinar);
    }

    // Delete
    public function destroy(Webinar $webinar)
    {
        $webinar->delete();
        return response()->json(['message'=>'Deleted']);
    }

    // Mark webinar live (host triggers) -> updates status to 'live'
    public function start(Webinar $webinar)
    {
        $webinar->update(['status'=>'live']);
        // TODO: you might broadcast an event, notify registrants, etc.
        return new WebinarResource($webinar);
    }

    // End webinar (host triggers)
    public function end(Webinar $webinar)
    {
        $webinar->update(['status'=>'ended']);
        return new WebinarResource($webinar);
    }
}
