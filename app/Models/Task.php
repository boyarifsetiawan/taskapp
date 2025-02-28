<?php

namespace App\Models;

use App\Events\NewProjectCreated;
use App\Events\TrackProjectProgress;
use Illuminate\Database\Eloquent\Model;
use App\Events\TrackCompletedAndPendingTask;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    const NOT_STARTED = 0;
    const PENDING = 1;
    const COMPLETED = 2;

    protected $guarded = [];

    public function task_members()
    {
        return $this->hasMany(TaskMember::class, 'taskId');
    }

    public static function changeStatusTask($taskId, $status)
    {
        Task::where('id', $taskId)->update([
            'status' => $status
        ]);
    }

    public static function countCompletedAndPendingTask($projectId)
    {
        $tasks = Task::where('projectId', $projectId)->get();

        $pending = 0;
        $completed = 0;
        foreach ($tasks as $row) {
            if (intval($row->status) === Task::PENDING) {
                $pending++;
            }
            if (intval($row->status) === Task::COMPLETED) {
                $completed++;
            }
        }
        return [$pending, $completed];
    }

    public static  function countProjectTask($projectId)
    {
        $count = Task::where('projectId', $projectId)->count();
        return $count;
    }

    public static function countCompletedTask($projectId)
    {
        $count = Task::where('projectId', $projectId)->where('status', Task::COMPLETED)->count();
        return $count;
    }


    public static function handleProjectProgress($projectId)
    {
        $totalTask = Task::countProjectTask($projectId);
        $totalCompletedTask = Task::countCompletedTask($projectId);

        $progress = Task::aroundNumber(($totalCompletedTask * 100) / $totalTask);

        $taskProgress = TaskProgress::where('projectId', $projectId)->first();
        if (!is_null($taskProgress)) {

            $taskProgress->where('projectId', $projectId)
                ->update(['progress' => $progress]);

            $tasks = Task::countCompletedAndPendingTask($projectId);

            TrackCompletedAndPendingTask::dispatch($tasks);
            TrackProjectProgress::dispatch($progress);

            return $progress;
        }
    }


    public static function aroundNumber($number)
    {
        if (strpos($number, '.')) {
            $position = strpos($number, '.') + 1;
            return substr($number, 0, $position + 1);
        } else {
            return $number;
        }
    }
}
