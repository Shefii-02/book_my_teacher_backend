<?php

namespace App\Http\Controllers\LMS;

use App\Http\Controllers\Controller;
use App\Models\CourseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CourseCategoryController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $categories = CourseCategory::with(['creator'])->where('company_id', '1')->latest()->paginate(10);
    return view('company.courses.category.index', compact('categories'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('company.courses.category.form');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    try {
      DB::beginTransaction();
      $request->validate([
        'title'       => 'required|string|max:255',
        'description' => 'nullable|string',
        'thumbnail'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
      ]);

      $thumbnailPath = null;
      if ($request->hasFile('thumbnail')) {
        $thumbnailPath = $request->file('thumbnail')->store('course_categories', 'public');
      }

      CourseCategory::create([
        'title'       => $request->title,
        'description' => $request->description,
        'thumbnail'   => $thumbnailPath,
        'company_id'  => 1,
        'created_by'  => Auth::id(),
      ]);
      DB::commit();

      return redirect()->route('admin.courses.categories.index')->with('success', 'Category created successfully.');
    } catch (\Exception $e) {
      DB::rollBack();
      return redirect()->back()->with('success', 'Category creation failed! ' . $e->getMessage());
    }
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit($course_category)
  {

    $category = CourseCategory::where('id', $course_category)->where('company_id', 1)->first() ?? abort(404);

    return view('company.courses.category.form', compact('category'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request,  $course_category)
  {
    $course_category = CourseCategory::where('id', $course_category)->where('company_id', 1)->first() ?? abort(404);

    $request->validate([
      'title'       => 'required|string|max:255',
      'description' => 'nullable|string',
      // 'thumbnail'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $thumbnailPath = $course_category->thumbnail;
    if ($request->hasFile('thumbnail')) {
      // delete old
      if ($thumbnailPath && Storage::disk('public')->exists($thumbnailPath)) {
        Storage::disk('public')->delete($thumbnailPath);
      }
      $thumbnailPath = $request->file('thumbnail')->store('course_categories', 'public');
    }

    $course_category->update([
      'title'       => $request->title,
      'description' => $request->description,
      'thumbnail'   => $thumbnailPath,
    ]);

    return redirect()->route('admin.courses.categories.index')->with('success', 'Category updated successfully.');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy($course_category)
  {
    $category = CourseCategory::where('id', $course_category)->first() ?? abort(404);

    if ($category->thumbnail && Storage::disk('public')->exists($category->thumbnail)) {
      Storage::disk('public')->delete($category->thumbnail);
    }

    $category->delete();

    return redirect()->route('admin.courses.categories.index')->with('success', 'Category deleted successfully.');
  }
}
