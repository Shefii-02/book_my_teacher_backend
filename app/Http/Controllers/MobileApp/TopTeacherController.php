<?php
namespace App\Http\Controllers\MobileApp;

use App\Models\Teacher;
use App\Models\TopTeacher;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TopTeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::with('topTeacher')
            ->orderByRaw('ISNULL(top_teachers.position), top_teachers.position ASC')
            ->leftJoin('top_teachers', 'teachers.id', '=', 'top_teachers.teacher_id')
            ->select('teachers.*', 'top_teachers.position')
            ->get();

        return view('company.mobile-app.top-teachers.index', compact('teachers'));
    }

    public function toggle(Request $request)
    {
        $teacherId = $request->teacher_id;

        $record = TopTeacher::where('teacher_id', $teacherId)->first();

        if ($record) {
            $record->delete();
            return response()->json(['status' => 'removed']);
        }

        $max = TopTeacher::max('position') ?? 0;

        TopTeacher::create([
            'teacher_id' => $teacherId,
            'position'   => $max + 1,
        ]);

        return response()->json(['status' => 'added']);
    }

    public function reorder(Request $request)
    {
        foreach ($request->positions as $pos => $id) {
            TopTeacher::where('teacher_id', $id)->update([
                'position' => $pos + 1
            ]);
        }

        return response()->json(['success' => true]);
    }
}
