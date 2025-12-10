<?php

namespace App\Http\Controllers\MobileApp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubjectReview;

class SubjectReviewController extends Controller
{
    // List all reviews
    public function index()
    {
        $reviews = SubjectReview::with(['subject', 'user', 'teacher'])->latest()->paginate(10);
        return view('company.mobile-app.reviews.index', compact('reviews'));
    }

    // Show create form
    public function create()
    {
        return view('company.mobile-app.reviews.form');
    }

    // Store new review
    public function store(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|integer',
            'user_id' => 'required|integer',
            'teacher_id' => 'nullable|integer',
            'subject_course_id' => 'nullable|integer',
            'comments' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        SubjectReview::create($request->all());

        return redirect()->route('admin.app.reviews.index')->with('success', 'Review created successfully!');
    }

    // Show edit form
    public function edit(SubjectReview $review)
    {
        return view('company.mobile-app.reviews.form', compact('review'));
    }

    // Update review
    public function update(Request $request, SubjectReview $review)
    {
        $request->validate([
            'subject_id' => 'required|integer',
            'user_id' => 'required|integer',
            'teacher_id' => 'nullable|integer',
            'subject_course_id' => 'nullable|integer',
            'comments' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $review->update($request->all());

        return redirect()->route('admin.app.reviews.index')->with('success', 'Review updated successfully!');
    }

    // Delete review
    public function destroy(SubjectReview $review)
    {
        $review->delete();
        return redirect()->route('admin.app.reviews.index')->with('success', 'Review deleted successfully!');
    }
}
