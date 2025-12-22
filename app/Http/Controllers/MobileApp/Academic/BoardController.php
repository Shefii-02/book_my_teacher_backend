<?php

namespace App\Http\Controllers\MobileApp\Academic;

use App\Helpers\MediaHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Academics\BoadRequest;
use App\Models\Board;
use App\Models\CourseSubCategory;
use App\Models\Grade;
use App\Models\Subject;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BoardController extends Controller
{
  public function index()
  {
    $boards = Board::with(['grades', 'subjects'])
      ->orderBy('position')
      ->paginate(20);

    return view('company.mobile-app.academic.boards.index', compact('boards'));
  }

  public function create()
  {
    $board = new Board();
    $grades = Grade::orderBy('position')->get();
    $subjects = Subject::orderBy('position')->get();
    return view('company.mobile-app.academic.boards.form', compact('board', 'grades', 'subjects'));
  }

  public function store(BoadRequest $request)
  {

    $data = $request->validated();
    try {
      DB::beginTransaction();

      $company_id = auth()->user()->company_id;

      $data['value'] = $data['name'];
      $data['company_id'] = $company_id;
      // Upload Thumbnail
      $thumbnailPath = null;
      if ($request->hasFile('icon')) {
        $thumbnailPath = MediaHelper::uploadCompanyFile(
          $company_id,
          'academic/board',
          $request->file('icon'),
          'board_icon'
        );
        $data['icon'] = $thumbnailPath;
      }


      $board = Board::create($data);

      // Sync relations
      $board->grades()->sync($request->grade_ids ?? []);
      $board->subjects()->sync($request->subject_ids ?? []);

      if ($request->has('attach_sub_category')) {

        $subjects = Subject::whereIn('id', $request->subject_ids ?? [])
          ->get()
          ->keyBy('id');

        foreach ($request->grade_ids ?? [] as $gradeId) {
          foreach ($request->subject_ids ?? [] as $subjectId) {

            $subject = $subjects->get($subjectId);
            if (!$subject) {
              continue;
            }

            CourseSubCategory::updateOrCreate(
              [
                'category_id' => $gradeId,
                'title'       => $subject->name,
                'company_id'  => $company_id,
              ],
              [
                'description' => null,
                'thumbnail'   => $subject->icon,
                'status'      => $subject->published ? 1 : 0,
                'position'    => $subject->position,
                'created_by'  => Auth::id(),
              ]
            );
          }
        }
      }


      DB::commit();
      return redirect()->route('company.app.boards.index')->with('success', 'Board created successfully.');
    } catch (Exception $e) {
      DB::rollBack();
      return redirect()
        ->back()
        ->with('error', $e->getMessage());
    }
  }

  public function edit(Board $board)
  {
    $grades = Grade::orderBy('position')->get();
    $subjects = Subject::orderBy('position')->get();

    // load pivot relations
    $board->load(['grades', 'subjects']);

    return view('company.mobile-app.academic.boards.form', compact('board', 'grades', 'subjects'));
  }

  public function update(BoadRequest $request, Board $board)
  {
    $data = $request->validated();
    try {
      DB::beginTransaction();
      $company_id = auth()->user()->company_id;
      $data['value'] = $data['name'];
      if ($request->hasFile('icon')) {
        if ($board->icon) {
          MediaHelper::removeCompanyFile($board->icon);
        }
        $thumbnailPath = null;

        $thumbnailPath = MediaHelper::uploadCompanyFile(
          $company_id,
          'academic/board',
          $request->file('icon'),
          'board_icon'
        );
        $data['icon'] = $thumbnailPath;
      }

      $board->update($data);

      // Sync relations
      $board->grades()->sync($request->grade_ids ?? []);
      $board->subjects()->sync($request->subject_ids ?? []);
      if ($request->has('attach_sub_category')) {

        $subjects = Subject::whereIn('id', $request->subject_ids ?? [])
          ->get()
          ->keyBy('id');

        foreach ($request->grade_ids ?? [] as $gradeId) {
          $grade = Grade::where('id',$gradeId)->first();
          $category = $grade->category;
          foreach ($request->subject_ids ?? [] as $subjectId) {
            $subject = $subjects->get($subjectId);
            if (!$subject) {
              continue;
            }

            CourseSubCategory::updateOrCreate(
              [
                'category_id' => $category->id,
                'title'       => $subject->name,
                'company_id'  => $company_id,
              ],
              [
                'description' => null,
                'thumbnail'   => $subject->icon,
                'status'      => $subject->published ? 1 : 0,
                'position'    => $subject->position,
                'created_by'  => Auth::id(),
              ]
            );
          }
        }
      }


      DB::commit();
      return redirect()->route('company.app.boards.index')->with('success', 'Board updated successfully.');
    } catch (Exception $e) {
      DB::rollBack();
      return redirect()
        ->back()
        ->with('error', $e->getMessage());
    }
  }

  public function destroy(Board $board)
  {
    $board->grades()->detach();
    $board->subjects()->detach();
    if ($board->icon) {
      MediaHelper::removeCompanyFile($board->icon);
    }

    $board->delete();

    return back()->with('success', 'Board deleted successfully.');
  }
}
