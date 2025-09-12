<?php

namespace App\Http\Controllers\LMS;

use App\Http\Controllers\Controller;
use App\Models\CourseCategory;
use App\Models\CourseSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CourseSubCategoryController extends Controller
{
  public function index()
  {
    $subCategories = CourseSubCategory::with('category')->latest()->paginate(10);
    return view('company.courses.sub_category.index', compact('subCategories'));
  }

  public function create()
  {
    $categories = CourseCategory::all();
    return view('company.courses.sub_category.form', compact('categories'));
  }

  public function store(Request $request)
  {
    $request->validate([
      'category_id' => 'required|exists:course_category,id',
      'title'       => 'required|string|max:255',
      'description' => 'nullable|string',
      'thumbnail'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $thumbnailPath = null;
    if ($request->hasFile('thumbnail')) {
      $thumbnailPath = $request->file('thumbnail')->store('course_sub_categories', 'public');
    }

    CourseSubCategory::create([
      'category_id' => $request->category_id,
      'title'       => $request->title,
      'description' => $request->description,
      'thumbnail'   => $thumbnailPath,
      'company_id'  => Auth::user()->company_id ?? null,
      'created_by'  => Auth::id(),
    ]);

    return redirect()->route('admin.courses.sub_category.index')->with('success', 'Sub Category created successfully.');
  }

  public function edit(CourseSubCategory $course_sub_category)
  {
    $categories = CourseCategory::all();
    $subCategory = $course_sub_category;
    return view('admin.courses.sub_category.form', compact('subCategory', 'categories'));
  }

  public function update(Request $request, CourseSubCategory $course_sub_category)
  {
    $request->validate([
      'category_id' => 'required|exists:course_category,id',
      'title'       => 'required|string|max:255',
      'description' => 'nullable|string',
      'thumbnail'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $thumbnailPath = $course_sub_category->thumbnail;
    if ($request->hasFile('thumbnail')) {
      if ($thumbnailPath && Storage::disk('public')->exists($thumbnailPath)) {
        Storage::disk('public')->delete($thumbnailPath);
      }
      $thumbnailPath = $request->file('thumbnail')->store('course_sub_categories', 'public');
    }

    $course_sub_category->update([
      'category_id' => $request->category_id,
      'title'       => $request->title,
      'description' => $request->description,
      'thumbnail'   => $thumbnailPath,
    ]);

    return redirect()->route('admin.courses.sub_category.index')->with('success', 'Sub Category updated successfully.');
  }

  public function destroy(CourseSubCategory $course_sub_category)
  {
    if ($course_sub_category->thumbnail && Storage::disk('public')->exists($course_sub_category->thumbnail)) {
      Storage::disk('public')->delete($course_sub_category->thumbnail);
    }

    $course_sub_category->delete();

    return redirect()->route('admin.courses.sub_category.index')->with('success', 'Sub Category deleted successfully.');
  }
}
