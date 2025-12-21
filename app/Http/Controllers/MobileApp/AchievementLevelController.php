<?php
namespace App\Http\Controllers\MobileApp;

use App\Http\Controllers\Controller;
use App\Models\AchievementLevel;
use App\Models\AchievementTask;
use Illuminate\Http\Request;

class AchievementLevelController extends Controller
{
    public function index()
    {
        $levels = AchievementLevel::orderBy('role')->orderBy('level_number')->paginate(30);
        return view('company.mobile-app.achievements.index', compact('levels'));
    }

    public function create()
    {
        return view('company.mobile-app.achievements.form', ['level' => new AchievementLevel()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'role' => 'required|string',
            'level_number' => 'required|integer',
            'title'=>'required|string',
            'description'=>'nullable|string',
            'position'=>'nullable|integer',
            'is_active'=>'nullable|boolean',
        ]);

        $data['company_id'] = auth()->user()->company_id;
        $level = AchievementLevel::create($data);
        return redirect()->route('admin.app.achievements.index')->with('success','Level created');
    }

    public function edit(AchievementLevel $achievementLevel)
    {
        $level = $achievementLevel->load('tasks');
        return view('company.mobile-app.achievements.form', compact('level'));
    }

    public function update(Request $request, AchievementLevel $achievementLevel)
    {
        $data = $request->validate([
            'role' => 'required|string',
            'level_number' => 'required|integer',
            'title'=>'required|string',
            'description'=>'nullable|string',
            'position'=>'nullable|integer',
            'is_active'=>'nullable|boolean',
        ]);

        $achievementLevel->update($data);
        return redirect()->route('admin.app.achievements.index')->with('success','Level updated');
    }

    public function destroy(AchievementLevel $achievementLevel)
    {
        $achievementLevel->delete();
        return back()->with('success','Deleted');
    }

    // Tasks CRUD (simple)
    public function storeTask(Request $request, AchievementLevel $achievementLevel)
    {
        $data = $request->validate([
            'task_type'=>'required|string',
            'title'=>'required|string',
            'description'=>'nullable|string',
            'target_value'=>'required|integer|min:1',
            'points'=>'nullable|integer',
            'position'=>'nullable|integer',
            'is_active'=>'nullable|boolean'
        ]);
        $data['achievement_level_id'] = $achievementLevel->id;
        AchievementTask::create($data);
        return back()->with('success','Task added');
    }

    public function updateTask(Request $request, AchievementTask $task)
    {
        $data = $request->validate([
            'task_type'=>'required|string',
            'title'=>'required|string',
            'description'=>'nullable|string',
            'target_value'=>'required|integer|min:1',
            'points'=>'nullable|integer',
            'position'=>'nullable|integer',
            'is_active'=>'nullable|boolean'
        ]);
        $task->update($data);
        return back()->with('success','Task updated');
    }

    public function destroyTask(AchievementTask $task)
    {
        $task->delete();
        return back()->with('success','Task deleted');
    }
}
