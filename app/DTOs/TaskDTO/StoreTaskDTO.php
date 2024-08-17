<?php

namespace App\DTOs\TaskDTO;

use App\Http\Requests\TaskRequest\CreateTaskRequest;

class StoreTaskDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $projectId,
        public readonly array $memberIds,
    ) {
    }

    public static function formRequest(CreateTaskRequest $request)
    {
        return new self(
            name: $request->validated('name'),
            projectId: $request->validated('projectId'),
            memberIds: $request->validated('memberIds')
        );
    }
}
