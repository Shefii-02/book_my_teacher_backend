<?php

namespace App\Http\Controllers\LMS;

use App\Http\Controllers\Controller;
use App\Models\TeacherActivity;
use App\Models\User;
use App\Models\UserRatingActivity;
use Google\Service\CloudSearch\UserActivity;
use Illuminate\Http\Request;

class UserActivityRatingController extends Controller
{
    // LIST
    public function index(Request $request)
    {
        $activities = UserRatingActivity::with('user')
            ->latest()
            ->paginate(20);

        return view('company.teacher_activities.index', compact('activities'));
    }

    // CREATE FORM
    public function create()
    {
        $teachers = User::where('role', 'teacher')->get();
        return view('company.teacher_activities.create', compact('teachers'));
    }

    // STORE
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'activity' => 'required|string|max:255',
            'score' => 'required|numeric|min:0',
            'out_of_score' => 'required|numeric|min:1',
        ]);

        UserRatingActivity::create($request->all());

        $this->recalculateRating($request->user_id);

        return redirect()->route('teacher-activities.index')
            ->with('success', 'Activity added');
    }

    // EDIT
    public function edit($id)
    {
        $activity = UserRatingActivity::findOrFail($id);
        $teachers = User::where('role', 'teacher')->get();

        return view('admin.teacher_activities.edit', compact('activity', 'teachers'));
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $activity = UserRatingActivity::findOrFail($id);

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'activity' => 'required|string|max:255',
            'score' => 'required|numeric|min:0',
            'out_of_score' => 'required|numeric|min:1',
        ]);

        $activity->update($request->all());

        $this->recalculateRating($request->user_id);

        return back()->with('success', 'Activity updated');
    }

    // DELETE
    public function destroy($id)
    {
        $activity = UserRatingActivity::findOrFail($id);
        $teacherId = $activity->user_id;

        $activity->delete();

        $this->recalculateRating($teacherId);

        return back()->with('success', 'Deleted');
    }

    // ⭐ CORE LOGIC: Recalculate rating
    private function recalculateRating($teacherId)
    {
        $totalScore = UserRatingActivity::where('user_id', $teacherId)->sum('score');
        $totalOutOf = UserRatingActivity::where('user_id', $teacherId)->sum('out_of_score');

        $rating = 0;

        if ($totalOutOf > 0) {
            $rating = ($totalScore / $totalOutOf) * 5;
        }

        User::where('id', $teacherId)->update([
            'rating' => round($rating, 2)
        ]);
    }
}
