<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\SubjectReview;
use Illuminate\Http\Request;

class ReviewRatingController extends Controller
{
    public function index()
    {
        $teacherId = auth()->id();

        /*
        |--------------------------------------------------------------------------
        | Reviews
        |--------------------------------------------------------------------------
        */

        $reviews = SubjectReview::with([
            'user:id,name,image',
            'course:id,title',
            'subject:id,name'
        ])
            ->where('teacher_id', $teacherId)
            ->latest()
            ->paginate(20);

        /*
        |--------------------------------------------------------------------------
        | Statistics
        |--------------------------------------------------------------------------
        */

        $totalReviews = SubjectReview::where('teacher_id', $teacherId)->count();

        $averageRating = SubjectReview::where('teacher_id', $teacherId)
            ->avg('rating');

        $fiveStar = SubjectReview::where('teacher_id', $teacherId)
            ->where('rating', 5)
            ->count();

        $fourStar = SubjectReview::where('teacher_id', $teacherId)
            ->where('rating', 4)
            ->count();

        $threeStar = SubjectReview::where('teacher_id', $teacherId)
            ->where('rating', 3)
            ->count();

        $twoStar = SubjectReview::where('teacher_id', $teacherId)
            ->where('rating', 2)
            ->count();

        $oneStar = SubjectReview::where('teacher_id', $teacherId)
            ->where('rating', 1)
            ->count();

        $data = [
            'total_reviews' => $totalReviews,
            'average_rating' => round($averageRating, 1),
            'five_star' => $fiveStar,
            'four_star' => $fourStar,
            'three_star' => $threeStar,
            'two_star' => $twoStar,
            'one_star' => $oneStar,
        ];

        return view(
            'teacher.review_rating.index',
            compact(
                'reviews',
                'data'
            )
        );
    }
}
