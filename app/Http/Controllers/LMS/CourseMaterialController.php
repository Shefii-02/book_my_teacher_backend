<?php

namespace App\Http\Controllers\LMS;

use App\Helpers\MediaHelper;
use App\Models\Course;
use App\Models\CourseMaterial;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CourseMaterialController extends Controller
{
  public function index($courseId)
  {
    $course = Course::where('course_identity', $courseId)->first() ?? abort(404);
    $materials = $course->materials;

    return view('company.courses.materials.index', compact('course', 'materials'));
  }

  public function create($courseId)
  {
    $course = Course::where('course_identity', $courseId)->first() ?? abort(404);
    return view('company.courses.materials.form', compact('course'));
  }

  public function store(Request $request, $courseId)
  {

    $request->validate([
      'title' => 'required|string|max:255',
      'file'  => 'required|file|max:10240', // 10 MB
      'position' => 'required|numeric',
    ]);

    $course = Course::where('course_identity', $courseId)->first() ?? abort(404);
    $file = $request->file('file');
    $company_id = 1;
    $path = null;
    if ($request->hasFile('file')) {
      $mainImagePath = MediaHelper::uploadCompanyFile(
        $company_id,
        'courses/' . $course->course_identity . '/material',
        $file,
        'material'
      );
      $path = $mainImagePath;
    }


    CourseMaterial::create([
      'course_id' => $course->id,
      'title' => $request->title,
      'file_path' => $path,
      'file_type' => $file->getClientOriginalExtension(),
      'position' => $request->position,
      'status' => $request->status ?? 'published',
    ]);
    return redirect()->route('admin.courses.materials.index', $course->course_identity)->with('success', 'Material added successfully!');
  }

  public function edit($courseId, $id)
  {
    $course = Course::findOrFail($courseId);
    $material = CourseMaterial::findOrFail($id);

    return view('company.courses.materials.form', compact('course', 'material'));
  }

  public function update(Request $request, $courseId, $id)
  {
    $material = CourseMaterial::findOrFail($id);
    $course = Course::where('course_identity', $courseId)->first() ?? abort(404);

    $request->validate([
      'title' => 'required|string|max:255',
      'position' => 'required|numeric',
    ]);

    if ($request->hasFile('file')) {
      if ($material->file_path) {
        MediaHelper::removeCompanyFile($material->file_path);
      }

      $file = $request->file('file');
      $company_id = 1;
      $mainImagePath = MediaHelper::uploadCompanyFile(
        $company_id,
        'courses/' . $course->course_identity . '/material',
        $file,
        'material'
      );
      $path = $mainImagePath;
      $material->update([
        'file_path' => $path,
        'file_type' => $file->getClientOriginalExtension()
      ]);
    }

    $material->update([
      'title' => $request->title,
      'position' => $request->position,
      'status' => $request->status,
    ]);
    return redirect()->route('admin.courses.materials.index', $course->course_identity)->with('success', 'Material updated!');
  }

  public function destroy($courseId, $id)
  {
    $material =   CourseMaterial::find($id);

    if ($material->file_path) {
      MediaHelper::removeCompanyFile($material->file_path);
    }
    $material->delete();
    return redirect()->back()->with('success', 'Material deleted!');
  }
}
