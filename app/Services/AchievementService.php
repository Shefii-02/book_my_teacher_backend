<?php
namespace App\Services;

use App\Models\AchievementTask;
use App\Models\AchievementUserLevel;
use App\Models\AchievementUserProgress;
use App\Models\AchievementLevel;
use Illuminate\Support\Facades\DB;

class AchievementService
{
    /**
     * Update progress for a user for the given task_type.
     * $amount = increment value (default 1)
     */
    public static function updateProgress(int $userId, string $taskType, int $amount = 1)
    {
        // find active user level for user's role (must exist)
        $user = \App\Models\User::find($userId);
        if (!$user) return false;

        // ensure user has at least one active level for their role
        $userLevel = AchievementUserLevel::where('user_id', $userId)
            ->where('is_completed', false)
            ->with('level.tasks')
            ->first();

        // if none found, automatically assign the first level for role
        if (!$userLevel) {
            $first = AchievementLevel::where('role', $user->role)->orderBy('level_number')->first();
            if (!$first) return false;

            $userLevel = AchievementUserLevel::create(['user_id'=>$userId,'level_id'=>$first->id,'is_completed'=>false]);
            $userLevel->load('level.tasks');
        }

        // locate the task in current level by type
        $task = $userLevel->level->tasks->firstWhere('task_type', $taskType);
        if (!$task) return false;

        // update or create progress
        $progress = AchievementUserProgress::firstOrCreate(
            ['user_id' => $userId, 'task_id' => $task->id],
            ['current_value' => 0, 'completed' => false]
        );

        // if already completed, do nothing
        if ($progress->completed) {
            return true;
        }

        $progress->current_value = $progress->current_value + $amount;
        if ($progress->current_value >= $task->target_value) {
            $progress->completed = true;
            $progress->completed_at = now();
        }
        $progress->save();

        // check level completion
        static::checkAllTasksCompleted($userId, $userLevel->level_id);

        return true;
    }

    public static function checkAllTasksCompleted(int $userId, int $levelId)
    {
        $pending = AchievementUserProgress::where('user_id', $userId)
            ->whereHas('task', function($q) use ($levelId) {
                $q->where('achievement_level_id', $levelId);
            })
            ->where('completed', false)
            ->count();

        // Also consider tasks that have no progress entries yet
        $totalTasks = AchievementTask::where('achievement_level_id', $levelId)->count();
        $completedCount = AchievementUserProgress::where('user_id', $userId)
            ->whereHas('task', function($q) use ($levelId) {
                $q->where('achievement_level_id', $levelId);
            })
            ->where('completed', true)
            ->count();

        if ($totalTasks > 0 && $completedCount >= $totalTasks) {
            // mark user-level completed
            AchievementUserLevel::updateOrCreate(
                ['user_id' => $userId, 'level_id' => $levelId],
                ['is_completed' => true, 'completed_at' => now()]
            );

            // unlock next level (if exists)
            $current = AchievementLevel::find($levelId);
            $next = AchievementLevel::where('role', $current->role)
                ->where('level_number', $current->level_number + 1)
                ->first();

            if ($next) {
                AchievementUserLevel::firstOrCreate([
                    'user_id' => $userId,
                    'level_id' => $next->id
                ], ['is_completed' => false]);
            }

            // you can dispatch notifications here
        }
    }

    /**
     * Get full user progress for current user levels (for dashboard)
     */
    public static function getUserProgress(int $userId)
    {
        $levels = AchievementUserLevel::with(['level.tasks', 'level.tasks.progress' => function($q) use ($userId) {
            $q->where('user_id', $userId);
        }])->where('user_id', $userId)->get();

        return $levels;
    }
}
