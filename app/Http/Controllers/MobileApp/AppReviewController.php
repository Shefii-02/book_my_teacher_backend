<?php

namespace App\Http\Controllers\MobileApp;

use App\Http\Controllers\Controller;
use App\Models\AppReview;
use Illuminate\Http\Request;

class AppReviewController extends Controller
{
    public function index(Request $request)
    {
        $companyId = auth()->user()->company_id;
        $tab = $request->get('tab', 'pending');
        $status = $tab === 'verified' ? 'approved' : 'pending';
        $sort = $request->get('sort', $tab === 'verified' ? 'app_order' : 'latest');

        $reviews = AppReview::query()
            ->with('user')
            ->where('company_id', $companyId)
            ->where('status', $status)
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = trim($request->search);

                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('feedback', 'like', "%{$search}%")
                        ->orWhere('rating', 'like', "%{$search}%")
                        ->orWhere('id', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($userQuery) use ($search) {
                            $userQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%")
                                ->orWhere('mobile', 'like', "%{$search}%");
                        });
                });
            });

        if ($tab === 'verified' && $sort === 'app_order') {
            $reviews->orderBy('position')->orderByDesc('created_at');
        } elseif ($sort === 'oldest') {
            $reviews->orderBy('created_at');
        } else {
            $reviews->orderByDesc('created_at');
        }

        $reviews = $reviews->paginate(20)->withQueryString();

        return view('company.mobile-app.app_reviews.index', compact('reviews', 'tab', 'sort'));
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'positions' => ['required', 'array'],
            'positions.*' => ['integer'],
        ]);

        $companyId = auth()->user()->company_id;

        foreach ($request->positions as $index => $reviewId) {
            AppReview::where('company_id', $companyId)
                ->where('status', 'approved')
                ->where('id', $reviewId)
                ->update(['position' => $index + 1]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Review order updated successfully.',
        ]);
    }

    public function show($id)
    {
        $companyId = auth()->user()->company_id;

        $review = AppReview::with('user')
            ->where('company_id', $companyId)
            ->where('id', $id)
            ->firstOrFail();

        return view('company.mobile-app.app_reviews.show', compact('review'));
    }

    public function edit($id)
    {
        $companyId = auth()->user()->company_id;

        $review = AppReview::with('user')
            ->where('company_id', $companyId)
            ->where('id', $id)
            ->firstOrFail();

        return view('company.mobile-app.app_reviews.edit', compact('review'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => ['required', 'in:approved,rejected'],
        ]);

        $companyId = auth()->user()->company_id;

        $review = AppReview::where('company_id', $companyId)->where('id', $id)->firstOrFail();
        $review->status = $request->status;
        $review->save();

        if ($request->wantsJson()) {
            return response()->json([
                'status' => true,
                'message' => 'Review status updated successfully.',
            ]);
        }

        return redirect()->route('company.app.app-reviews.index', ['tab' => $review->status === 'approved' ? 'verified' : 'pending'])
            ->with('success', 'Review status updated successfully.');
    }

    public function destroy($id)
    {
        $companyId = auth()->user()->company_id;

        $review = AppReview::where('company_id', $companyId)
            ->where('id', $id)
            ->firstOrFail();

        $review->delete();

        return redirect()->back()->with('success', 'Review deleted successfully.');
    }
}
