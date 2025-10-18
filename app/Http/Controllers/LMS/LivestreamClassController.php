<?php

namespace App\Http\Controllers\LMS;
use App\Http\Controllers\Controller;
use App\Models\LivestreamClass;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LivestreamClassController extends Controller
{
    public function index()
    {
        $livestreams = LivestreamClass::with(['teachers', 'permissions'])->latest()->paginate(10);
        return view('livestream_classes.index', compact('livestreams'));
    }

    public function create()
    {
        $teachers = User::where('type', 'teacher')->get();
        return view('livestream_classes.create', compact('teachers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration'    => 'required|integer|min:10',
            'teachers'    => 'required|array',
        ]);

        $livestream = LivestreamClass::create([
            'title'       => $request->title,
            'description' => $request->description,
            'duration'    => $request->duration,
            'created_by'  => Auth::id(),
        ]);

        $livestream->teachers()->sync($request->teachers);

        LivestreamClassPermission::create([
            'livestream_id'    => $livestream->id,
            'allow_voice'      => $request->has('allow_voice'),
            'allow_video'      => $request->has('allow_video'),
            'allow_screen_share'=> $request->has('allow_screen_share'),
            'allow_chat'       => $request->has('allow_chat'),
        ]);

        return redirect()->route('livestream_classes.index')->with('success', 'Livestream class created successfully.');
    }

    public function edit(LivestreamClass $livestream_class)
    {
        $teachers = User::where('type', 'teacher')->get();
        return view('livestream_classes.edit', [
            'livestream' => $livestream_class,
            'teachers' => $teachers
        ]);
    }

    public function update(Request $request, LivestreamClass $livestream_class)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration'    => 'required|integer|min:10',
            'teachers'    => 'required|array',
        ]);

        $livestream_class->update([
            'title'       => $request->title,
            'description' => $request->description,
            'duration'    => $request->duration,
        ]);

        $livestream_class->teachers()->sync($request->teachers);

        $livestream_class->permissions()->updateOrCreate(
            ['livestream_id' => $livestream_class->id],
            [
                'allow_voice'       => $request->has('allow_voice'),
                'allow_video'       => $request->has('allow_video'),
                'allow_screen_share'=> $request->has('allow_screen_share'),
                'allow_chat'        => $request->has('allow_chat'),
            ]
        );

        return redirect()->route('livestream_classes.index')->with('success', 'Livestream class updated successfully.');
    }

    public function destroy(LivestreamClass $livestream_class)
    {
        $livestream_class->delete();
        return redirect()->route('livestream_classes.index')->with('success', 'Livestream class deleted successfully.');
    }
}
