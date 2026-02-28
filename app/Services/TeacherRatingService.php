<?php
use App\Models\TeacherActivity;
use App\Models\User;
use App\Models\UserRatingActivity;

class TeacherRatingService
{
    public static function updateRating($teacherId)
    {
        $activities = UserRatingActivity::where('teacher_id', $teacherId)->get();
        $totalScore = $activities->sum('score');
        $totalOutOf = $activities->sum('out_of_score');

        if ($totalOutOf == 0) {
            $rating = 0;
        } else {
            $rating = ($totalScore / $totalOutOf) * 5;
        }

        User::where('id', $teacherId)->update([
            'rating' => round($rating, 2)
        ]);
    }
}
