<?php

namespace App\Http\Controllers\LMS;

use App\Helpers\MediaHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Categories\StoreSubCategoryRequest;
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

  public function store(StoreSubCategoryRequest $request)
  {
    $request->validate([
      'category_id' => 'required|exists:course_categories,id',
      'title'       => 'required|string|max:255',
      'description' => 'nullable|string',
      'thumbnail'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $company_id = auth()->user()->company_id;

    $thumbnailPath = null;
    if ($request->hasFile('thumbnail')) {
      // $thumbnailPath = $request->file('thumbnail')->store('course_categories', 'public');
      // Upload Thumbnail
      if ($request->hasFile('thumbnail')) {
        $thumbnailPath = MediaHelper::uploadCompanyFile(
          $company_id,
          'subcategories/thumbnails',
          $request->file('thumbnail'),
          'subcategories'
        );
      }
    }

    CourseSubCategory::create([
      'category_id' => $request->category_id,
      'title'       => $request->title,
      'description' => $request->description,
      'thumbnail'   => $thumbnailPath,
      'company_id'  => $company_id ?? null,
      'status'      => $request->status ? '1' : 0,
      'position'    => $request->position,
      'created_by'  => Auth::id(),
    ]);

    return redirect()->route('company.subcategories.index')->with('success', 'Sub Category created successfully.');
  }

  public function edit(Request $request, $course_sub_category)
  {
    $categories = CourseCategory::where('company_id', 1)->get();
    $subCategory = CourseSubCategory::where('id', $course_sub_category)->where('company_id', 1)->first();

    return view('company.courses.sub_category.form', compact('subCategory', 'categories'));
  }

  public function update(StoreSubCategoryRequest $request, $course_sub_category)
  {
    $course_sub_category = CourseSubCategory::where('id', $course_sub_category)->where('company_id', 1)->first() ?? abort(404);

    $company_id = auth()->user()->company_id;

    $thumbnailPath = $course_sub_category->thumbnail;
    if ($request->hasFile('thumbnail')) {
      // delete old
      // Upload Thumbnail
      if ($course_sub_category->thumbnail && Storage::disk('public')->exists($course_sub_category->thumbnail_url))
        MediaHelper::removeCompanyFile($course_sub_category->thumbnail);

      $thumbnailPath = MediaHelper::uploadCompanyFile(
        $company_id,
        'subcategories/thumbnails',
        $request->file('thumbnail'),
        'subcategories'
      );
      $data['thumb_id'] = $thumbnailPath;
    }

    $course_sub_category->update([
      'category_id' => $request->category_id,
      'title'       => $request->title,
      'description' => $request->description,
      'thumbnail'   => $thumbnailPath,
      'status'      => $request->status ? '1' : 0,
      'position'    => $request->position,
    ]);



    return redirect()->route('company.subcategories.index')->with('success', 'Sub Category updated successfully.');
  }

  public function destroy(CourseSubCategory $course_sub_category)
  {
    if ($course_sub_category->thumbnail && Storage::disk('public')->exists($course_sub_category->thumbnail_url)) {
      MediaHelper::removeCompanyFile($course_sub_category->thumbnail);
    }

    $course_sub_category->delete();

    return redirect()->route('company.subcategories.index')->with('success', 'Sub Category deleted successfully.');
  }
}
