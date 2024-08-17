<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\TaskMemberResource;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'projectId' => $this->projectId,
            'name' => $this->name,
            'status' => $this->status,
            'task_members' => TaskMemberResource::collection($this->whenLoaded('task_members'))
        ];
    }
}
