<?php

namespace App\Http\Controllers\MobileApp\Academic;

use App\Helpers\MediaHelper;
use App\Http\Controllers\Controller;
use App\Models\CourseCategory;
use App\Models\Grade;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class GradeController extends Controller
{
  public function index()
  {
    $company_id = auth()->user()->company_id;
    $grades = Grade::where('company_id', $company_id)->orderBy('position')->get();
    return view('company.mobile-app.academic.grades.index', compact('grades'));
  }

  public function create()
  {
    return view('company.mobile-app.academic.grades.form');
  }

  public function store(Request $request)
  {
    $company_id = auth()->user()->company_id;
    $request->validate([
      'thumb' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
      'name' => 'required|string|max:255',
      'description' => 'nullable|string',
      'position' => 'required|integer|min:0',
      'published' => 'nullable|boolean',
    ]);

    DB::beginTransaction();

    try {

      $data = $request->except('thumb');

      $data['company_id'] = $company_id;
      $data['value'] = $data['name'];

      // Upload Thumbnail
      $thumbnailPath = null;
      if ($request->hasFile('thumb')) {
        $thumbnailPath = MediaHelper::uploadCompanyFile(
          $company_id,
          'academic/grades',
          $request->file('thumb'),
          'grade_thumb'
        );
        $data['thumb'] = $thumbnailPath;
      }


      Grade::create($data);

      if ($request->has('attach_category')) {
        CourseCategory::create([
          'title'       => $data['name'],
          'description' => $data['description'],
          'thumbnail'   => $thumbnailPath,
          'status'      => $data['published'] ? '1' : 0,
          'position'    => $data['position'],
          'company_id'  => $company_id,
          'created_by'  => Auth::id(),
        ]);
      }

      DB::commit();
      return redirect()
        ->route('company.app.grades.index')
        ->with('success', 'Grade created successfully');
    } catch (Exception $e) {
      DB::rollBack();
      return redirect()
        ->route('company.app.grades.index')
        ->with('error', $e->getMessage());
    }
  }

  public function edit(Grade $grade)
  {
    return view('company.mobile-app.academic.grades.form', compact('grade'));
  }

  public function update(Request $request, Grade $grade)
  {
    $request->validate([
      'thumb' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
      'name' => 'required|string|max:255',
      'description' => 'nullable|string',
      'position' => 'required|integer|min:0',
      'published' => 'nullable|boolean',
    ]);

    $company_id = auth()->user()->company_id;
    $data = $request->except('thumb');


      $thumbnailPath = null;
    if ($request->hasFile('thumb')) {
      if ($grade->thumb) {
        MediaHelper::removeCompanyFile($grade->thumb);
      }
      // $thumbnailPath = null;

      $thumbnailPath = MediaHelper::uploadCompanyFile(
        $company_id,
        'academic/grades',
        $request->file('thumb'),
        'grade_thumb'
      );
      $data['thumb'] = $thumbnailPath;
    }
    $data['value'] = $data['name'];

if ($request->has('attach_category')) {
    CourseCategory::updateOrCreate(
        [
            'title'      => $grade->name,
            'company_id' => $company_id,
        ],
        [
            'title'       => $data['name'],
            'description' => $data['description'],
            'thumbnail'   => $thumbnailPath != null ? $thumbnailPath : $grade->thumb,
            'status'      => $data['published'] ? 1 : 0,
            'position'    => $data['position'],
            'company_id'  => $company_id,
            'created_by'  => Auth::id(),
        ]
    );
}


    $grade->update($data);

    return redirect()
      ->route('company.app.grades.index')
      ->with('success', 'Grade updated successfully');
  }

  public function destroy(Grade $grade)
  {
    if ($grade->thumb) {
      MediaHelper::removeCompanyFile($grade->thumb);
    }

    $grade->delete();

    return redirect()
      ->route('company.app.grades.index')
      ->with('success', 'Grade removed successfully');
  }
}
