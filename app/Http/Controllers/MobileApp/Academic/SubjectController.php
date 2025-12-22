<?php

namespace App\Http\Controllers\MobileApp\Academic;

use App\Helpers\MediaHelper;
use App\Models\Subject;
use App\Http\Controllers\Controller;
use App\Http\Requests\Academics\SubjectRequest;
use App\Models\ProvidingSubject;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SubjectController extends Controller
{
  public function index()
  {
    $subjects = Subject::orderBy('position')->get();
    return view('company.mobile-app.academic.subjects.index', compact('subjects'));
  }

  public function create()
  {
    return view('company.mobile-app.academic.subjects.form');
  }

  public function store(SubjectRequest $request)
  {
    $data = $request->validated();
    try {
      DB::beginTransaction();
      $company_id = auth()->user()->company_id;
      // Upload Thumbnail
      $thumbnailPath = null;
      if ($request->hasFile('icon')) {
        $thumbnailPath = MediaHelper::uploadCompanyFile(
          $company_id,
          'academic/subjects',
          $request->file('icon'),
          'icon'
        );
        $data['icon'] = $thumbnailPath;
      }
      $data['company_id'] = $company_id;
      $data['value'] = $data['name'];
      $data['published'] = $request->published ? 1 : 0;

      Subject::create($data);
      DB::commit();
      return redirect()->route('company.app.subjects.index')->with('success', 'Subject created successfully.');
    } catch (Exception $e) {
      DB::rollBack();
      return redirect()->back()->with('error', $e->getMessage());
    }
  }

  public function edit(Subject $subject)
  {
    return view('company.mobile-app.academic.subjects.form', compact('subject'));
  }

  public function update(SubjectRequest $request, Subject $subject)
  {
    $data = $request->validated();
    $company_id = auth()->user()->company_id;
    if ($request->hasFile('icon')) {
      if ($subject->icon) {
        MediaHelper::removeCompanyFile($subject->icon);
      }
      $thumbnailPath = null;

      $thumbnailPath = MediaHelper::uploadCompanyFile(
        $company_id,
        'academic/subjects',
        $request->file('icon'),
        'subjetc_icon'
      );
      $data['icon'] = $thumbnailPath;
    }

    $data['value'] = $data['name'];
    $data['published'] = $request->published ? 1 : 0;

    $subject->update($data);

    return redirect()->route('company.app.subjects.index')->with('success', 'Subject updated successfully.');
  }

  public function destroy(Subject $subject)
  {
    if ($subject->icon) {
      MediaHelper::removeCompanyFile($subject->icon);
    }

    $subject->delete();

    return redirect()->route('company.app.subjects.index')->with('success', 'Subject deleted successfully.');
  }





  public function setup()
  {
    $companyId =auth()->user()->company_id;

    // $subjects = Subject::leftJoin('providing_subjects', function ($join) use ($companyId) {
    //   $join->on('subjects.id', '=', 'providing_subjects.subject_id')
    //     ->where('providing_subjects.company_id', $companyId);
    // })
    //   ->orderByRaw('ISNULL(providing_subjects.position), providing_subjects.position ASC')
    //   ->select('subjects.*', 'providing_subjects.position')
    //   ->get();

    $subjects = Subject::with('providingSubjects')
      ->orderByRaw('ISNULL(providing_subjects.position), providing_subjects.position ASC')
      ->leftJoin('providing_subjects', 'subjects.id', '=', 'providing_subjects.subject_id')
      ->select('subjects.*', 'providing_subjects.position')
      ->get();

    return view('company.mobile-app.academic.providing_subjects', compact('subjects'));
  }


  public function reorder(Request $request)
  {
    $companyId = auth()->user()->company_id;

    $checkedIds = $request->positions;

    // Delete all old entries NOT in checked list
    ProvidingSubject::where('company_id', $companyId)
      ->whereNotIn('subject_id', $checkedIds)
      ->delete();

    // Update positions only for checked subjects
    foreach ($checkedIds as $index => $subjectId) {
      ProvidingSubject::updateOrCreate(
        [
          'company_id' => $companyId,
          'subject_id' => $subjectId
        ],
        [
          'position' => $index + 1
        ]
      );
    }

    return response()->json(['status' => true]);
  }


  public function toggle(Request $request)
  {
    $companyId = auth()->user()->company_id;
    $subjectId = $request->subject_id;

    if ($request->checked) {
      // Create if checked
      $max = ProvidingSubject::max('position') ?? 0;
      ProvidingSubject::firstOrCreate([
        'company_id' => $companyId,
        'subject_id' => $subjectId,
        'position'   => $max + 1,
      ]);
    } else {
      // Remove if unchecked
      ProvidingSubject::where([
        'company_id' => $companyId,
        'subject_id' => $subjectId
      ])->delete();
    }

    return response()->json(['status' => true]);
  }
}
