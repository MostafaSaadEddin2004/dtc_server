<?php

namespace App\Http\Resources\Api;

use App\Http\Resources\DepartmentResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MoveResource extends JsonResource
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
            'text' => $this->text,
            'user_id' => new UserResource($this->user),
            'department_id' => new DepartmentResource($this->department),
        ];
    }
}
