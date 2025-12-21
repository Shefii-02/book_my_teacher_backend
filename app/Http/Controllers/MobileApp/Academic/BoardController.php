<?php

namespace App\Http\Controllers\MobileApp\Academic;

use App\Helpers\MediaHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Academics\BoadRequest;
use App\Models\Board;
use App\Models\Grade;
use App\Models\Subject;
use Exception;
use Illuminate\Http\Request;
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
      DB::commit();
      return redirect()->route('admin.app.boards.index')->with('success', 'Board created successfully.');
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
      DB::commit();
      return redirect()->route('admin.app.boards.index')->with('success', 'Board updated successfully.');
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
