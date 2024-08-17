<?php

namespace App\Services\TaskService;

use App\Models\Task;
use App\Models\TaskMember;
use App\DTOs\TaskDTO\StoreTaskDTO;
use Illuminate\Support\Facades\DB;

class TaskService
{

    public function createTask(StoreTaskDTO $dto)
    {

        return DB::transaction(function () use ($dto) {

            $task = Task::create([
                'name' => $dto->name,
                'projectId' => $dto->projectId,
                'status' => Task::NOT_STARTED,
            ]);

            for ($i = 0; $i < count($dto->memberIds); $i++) {
                TaskMember::create([
                    'projectId' => $dto->projectId,
                    'taskId' => $task->id,
                    'memberId' => $dto->memberIds[$i]
                ]);
            }
        });
    }
}
