<?php

namespace App\DTOs\ProjectDTO;

use App\Http\Requests\ProjectsRequest\StoreProjectRequest;
use App\Http\Requests\ProjectsRequest\UpdateProjectRequest;

class StoreProjectDTO
{

    public function __construct(
        public readonly string $name,
        public readonly string $startDate,
        public readonly string $endDate
    ) {
    }

    public static function formStoreRequest(StoreProjectRequest $request)
    {
        return new self(
            name: $request->validated('name'),
            startDate: $request->validated('startDate'),
            endDate: $request->validated('endDate'),
        );
    }

    public static function formUpdateRequest(UpdateProjectRequest $request)
    {
        return new self(
            name: $request->validated('name'),
            startDate: $request->validated('startDate'),
            endDate: $request->validated('endDate'),
        );
    }
}
