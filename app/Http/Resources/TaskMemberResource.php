<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskMemberResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "projectId" => $this->projectId,
            "memberId" => $this->memberId,
            "taskId" => $this->taskId,
            'members' => new MemberResource($this->whenLoaded('members'))
        ];
    }
}
