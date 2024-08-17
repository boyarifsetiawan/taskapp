<?php

namespace App\Http\Controllers;

use App\DTOs\ProjectDTO\StoreProjectDTO;
use App\Models\Task;
use App\Models\Project;
use App\Models\TaskProgress;
use Illuminate\Http\Request;
use App\Events\NewProjectCreated;
use App\Http\Requests\ProjectsRequest\PinnedProjectRequest;
use App\Http\Requests\ProjectsRequest\StoreProjectRequest;
use App\Http\Requests\ProjectsRequest\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\SingleProjectResource;
use App\Services\ProjectService\ProjectService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    public function __construct(
        protected ProjectService $projectService
    ) {
    }
    public function getProject($slug)
    {
        $project = $this->projectService->getProject($slug);
        return (new SingleProjectResource($project))
            ->response()
            ->setStatusCode(200);
    }
    public function index()
    {
        $query = request('query');
        $projects = $this->projectService->index($query);

        return (ProjectResource::collection($projects))
            ->response()
            ->setStatusCode(200);
    }

    public function store(StoreProjectRequest $request)
    {
        $this->projectService->store(StoreProjectDTO::formStoreRequest($request));

        return response([
            'message' => 'Project created.'
        ], 200);
    }

    public function update(UpdateProjectRequest $request, $id)
    {
        $this->projectService->update(StoreProjectDTO::formUpdateRequest($request), $id);

        return response([
            'message' => 'Project Updated.',
        ], 200);
    }

    public function pinnedProject(PinnedProjectRequest $request)
    {
        $this->projectService->pinnedProject($request->validated('projectId'));

        return response([
            'message' => 'Project pinned on dashboard'
        ], 200);
    }

    public function getPinnedProject()
    {
        $project = $this->projectService->getPinnedProject();
        if (!is_null($project)) {
            return response([
                'data' => $project
            ], 200);
        }
        return response(['data' => null]);
    }

    public function countProject()
    {
        $count = Project::count();
        return response([
            'count' => $count
        ]);
    }

    public function getProjectChartData(Request $request)
    {
        $result = $this->projectService->getProjectChartData($request->projectId);
        $tasks = $result['taskArray'];
        $progress = $result['taskProgress'];
        return response([
            'tasks' => $tasks,
            'progress' =>  intval($progress->progress)
        ]);
    }
}
