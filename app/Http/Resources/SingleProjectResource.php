<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SingleProjectResource extends JsonResource
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
            'name' => $this->name,
            'status' => $this->status,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'slug' => $this->slug,
            'tasks' => TaskResource::collection($this->whenLoaded('tasks')),
            // $this->tasks->map(function ($item) {
            //     return [
            //         'id' => $item->id,
            //         'projectId' => $item->projectId,
            //         'name' => $item->name,
            //         'status' => $item->status,
            //         'task_members' => $item->task_members->map(function ($item) {
            //             return [
            //                 "id" => $item->id,
            //                 "projectId" => $item->projectId,
            //                 "memberId" => $item->memberId,
            //                 "taskId" => $item->taskId,
            //                 'members' => [
            //                     'id' => $item->members->id,
            //                     'name' => $item->members->name,
            //                     'email' => $item->members->email
            //                 ]
            //             ];
            //         })
            //     ];
            // }),
            'task_progress' => new TaskProgressResource($this->whenLoaded('task_progress'))
        ];
    }
}
