<?php

namespace App\Services\ProjectService;

use App\Models\Task;
use App\Models\Project;
use App\Models\TaskProgress;
use App\Events\NewProjectCreated;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\DB;
use App\Exceptions\CustomException;
use App\DTOs\ProjectDTO\StoreProjectDTO;

class ProjectService
{

    public function getProject($slug)
    {
        $project = Project::with(['tasks.task_members.members', 'task_progress'])->where('projects.slug', $slug)->first();

        return $project;
    }

    public function index($query)
    {
        $projects = Project::with(['task_progress']);
        if (!is_null($query) && $query !== '') {
            $projects->where('name', 'like', '%' . $query . '%')->orderBy('id', 'desc');
            return $projects->paginate(10);
        }
        return $projects->paginate(10);
    }

    public function store(StoreProjectDTO $dto)
    {
        return DB::transaction(function () use ($dto) {

            $project = Project::create([
                'name' => $dto->name,
                'startDate' => $dto->startDate,
                'endDate' => $dto->endDate,
                'status' => Project::NOT_STARTED,
                'slug' => Project::createSlug($dto->name)
            ]);
            TaskProgress::create([
                'ProjectId' => $project->id,
                'pinned_on_dashboard' => TaskProgress::NOT_PINNED_ON_DASHBOARD,
                'progress' => TaskProgress::INITIAL_PROGRESS_PERCENT,
            ]);

            // $count = Project::count();
            // NewProjectCreated::dispatch($count);

            return $project;
        });
    }

    public function update(StoreProjectDTO $dto, $id)
    {
        Project::where('id', $id)->update([
            'name' => $dto->name,
            'startDate' => $dto->startDate,
            'endDate' => $dto->endDate,
            'slug' => Project::createSlug($dto->name)
        ]);
    }

    public function pinnedProject($projectId)
    {
        return DB::transaction(function () use ($projectId) {
            TaskProgress::where('pinned_on_dashboard', TaskProgress::PINNED_ON_DASHBOARD)
                ->update(['pinned_on_dashboard' => TaskProgress::NOT_PINNED_ON_DASHBOARD]);

            TaskProgress::where('projectId', $projectId)
                ->update([
                    'pinned_on_dashboard' => TaskProgress::PINNED_ON_DASHBOARD,
                ]);
        });
    }

    public function getPinnedProject()
    {
        try {
            $project = DB::table('task_progress')
                ->join('projects', 'task_progress.projectId', '=', 'projects.id')
                ->select('projects.id', 'projects.name')
                ->where('pinned_on_dashboard', TaskProgress::PINNED_ON_DASHBOARD)->first();
            return $project;
        } catch (\Throwable $th) {
            throw new CustomException('Somethig went wrong.', 400);
        }
    }

    public function getProjectChartData($projectId)
    {
        $taskProgress = TaskProgress::where('projectId', $projectId)->select('progress')->first();

        $taskArray = Task::countCompletedAndPendingTask($projectId);

        return [
            'taskArray' => $taskArray,
            'taskProgress' => $taskProgress,
        ];
    }
}
