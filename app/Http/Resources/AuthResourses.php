<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthResourses extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user' => [
                'id' => $this['user']->id,
                'email' => $this['user']->email,
            ],
            'token' => $this['token'],
            'isLoggedIn' => $this['isLoggedIn'],
            'message' => $this['message'],
        ];
    }
}
