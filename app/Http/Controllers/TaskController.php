<?php

namespace App\Http\Controllers;

use App\DTOs\TaskDTO\StoreTaskDTO;
use App\Exceptions\CustomException;
use App\Http\Requests\TaskRequest\CreateTaskRequest;
use App\Models\Task;
use App\Services\TaskService\TaskService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct(protected TaskService $taskService)
    {
    }
    public function createTask(CreateTaskRequest $request)
    {
        try {
            $this->taskService->createTask(StoreTaskDTO::formRequest($request));

            return response([
                'message' => 'Task created.'
            ], 200);
        } catch (\Throwable $th) {
            throw new CustomException('Query failed.', 500);
        }
    }

    public function deleteTask(Request $request)
    {
        dd($request->all());
    }

    public function TaskToNotStartedToPending(Request $request)
    {
        Task::changeStatusTask($request->taskId, Task::PENDING);
        Task::handleProjectProgress($request->projectId);

        return response(['message' => 'Task move to pending.'], 200);
    }
    public function TaskToPendingToCompleted(Request $request)
    {
        Task::changeStatusTask($request->taskId, Task::COMPLETED);
        Task::handleProjectProgress($request->projectId);

        return response(['message' => 'Task move to completed.'], 200);
    }

    public function TaskToCompletedToPending(Request $request)
    {
        Task::changeStatusTask($request->taskId, Task::PENDING);
        Task::handleProjectProgress($request->projectId);

        return response(['message' => 'Task move to Pending.'], 200);
    }

    public function TaskToCompletedToNotStarted(Request $request)
    {
        Task::changeStatusTask($request->taskId, Task::NOT_STARTED);

        return response(['message' => 'Task move to not started.'], 200);
    }

    public function TaskToNotStartedToCompleted(Request $request)
    {
        Task::changeStatusTask($request->taskId, Task::COMPLETED);

        return response(['message' => 'Task move to completed.'], 200);
    }

    public function TaskToPendingToNotStarted(Request $request)
    {
        Task::changeStatusTask($request->taskId, Task::NOT_STARTED);


        return response(['message' => 'Task move to not started.'], 200);
    }
}
