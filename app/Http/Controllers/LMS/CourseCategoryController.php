<?php

namespace App\Http\Controllers\LMS;

use App\Helpers\MediaHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Categories\StoreCategoryRequest;
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
  public function store(StoreCategoryRequest $request)
  {
    DB::beginTransaction();
    $company_id = auth()->user()->company_id;
    try {

      $data = $request->validated();

      $thumbnailPath = null;
      if ($request->hasFile('thumbnail')) {
        // $thumbnailPath = $request->file('thumbnail')->store('course_categories', 'public');
        // Upload Thumbnail
        if ($request->hasFile('thumbnail')) {
          $thumbnailPath = MediaHelper::uploadCompanyFile(
            $company_id,
            'courses/categories',
            $request->file('thumbnail'),
            'categories'
          );
        }
      }



      CourseCategory::create([
        'title'       => $data['title'],
        'description' => $data['description'],
        'thumbnail'   => $thumbnailPath,
        'status'      => $data['status'] ? '1' : 0,
        'position'    => $data['position'],
        'company_id'  => $company_id,
        'created_by'  => Auth::id(),
      ]);
      DB::commit();

      return redirect()->route('company.categories.index')->with('success', 'Category created successfully.');
    } catch (\Exception $e) {
      DB::rollBack();
      return redirect()->back()->with('error', 'Category creation failed! ' . $e->getMessage());
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
  public function update(StoreCategoryRequest $request,  $course_category)
  {
    $course_category = CourseCategory::where('id', $course_category)->where('company_id', 1)->first() ?? abort(404);

    $company_id = auth()->user()->company_id;
    $thumbnailPath = $course_category->thumbnail;


    if ($request->hasFile('thumbnail')) {
      // delete old
      // Upload Thumbnail
      if ($course_category->thumbnail && Storage::disk('public')->exists($course_category->thumbnail_url))
        MediaHelper::removeCompanyFile($course_category->thumbnail);

      $thumbnailPath = MediaHelper::uploadCompanyFile(
        $company_id,
        'courses/categories',
        $request->file('thumbnail'),
        'courses'
      );
      $data['thumb_id'] = $thumbnailPath;
    }

    $course_category->update([
      'title'       => $request->title,
      'description' => $request->description,
      'thumbnail'   => $thumbnailPath,
      'status'      => $request->status ? '1' : 0,
      'position'    => $request->position,
    ]);

    return redirect()->route('company.categories.index')->with('success', 'Category updated successfully.');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy($course_category)
  {
    $category = CourseCategory::where('id', $course_category)->first() ?? abort(404);

    if ($category->thumbnail && Storage::disk('public')->exists($category->thumbnail_url)) {
      MediaHelper::removeCompanyFile($course_category->thumbnail);
    }

    $category->delete();

    return redirect()->route('company.categories.index')->with('success', 'Category deleted successfully.');
  }
}
