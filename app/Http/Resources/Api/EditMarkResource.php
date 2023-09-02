<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EditMarkResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'subject'=>$this->id,
            'subject'=>$this->subject,
            'mark'=>$this->mark,
            'reason'=>$this->reason,
            'teacher'=>$this->teacher,
            'user'=>new UserResource($this->user),
        ];
    }
}
