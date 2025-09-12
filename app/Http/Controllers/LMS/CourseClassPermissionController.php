<?php

namespace App\Http\Controllers\LMS;
use App\Http\Controllers\Controller;
use App\Models\CourseClassPermission;
use Illuminate\Http\Request;

class CourseClassPermissionController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    //
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $data = $request->validate([
      'class_id' => 'required|exists:course_classes,id',
      'allow_voice' => 'boolean',
      'allow_video' => 'boolean',
      'allow_chat' => 'boolean',
      'allow_screen_share' => 'boolean',
    ]);

    return CourseClassPermission::create($data);
  }



  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */

  public function update(Request $request, $id)
  {
    $permission = CourseClassPermission::findOrFail($id);

    $data = $request->validate([
      'allow_voice' => 'boolean',
      'allow_video' => 'boolean',
      'allow_chat' => 'boolean',
      'allow_screen_share' => 'boolean',
    ]);

    $permission->update($data);

    return $permission;
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    //
  }
}
