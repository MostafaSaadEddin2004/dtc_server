<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'content' => $this->content,
            'attachment' => $this->attachment,
            'department_name' => $this->department?->name,
            'course_name' => $this->course?->name,
            'attachment_type' => $this->attachment_type,
            'likes' => $this->likes->count(),
            'liked_by_me' => $this->likes()->where('user_id', auth()->id())->exists(),
            'saves' => $this->saves->count(),
            'saved_by_me' => $this->saves()->where('user_id', auth()->id())->exists(),
            'created_at' => $this->created_at->since(),
            'is_open' => $this->whenHas('course_id', $this->course?->is_open),
        ];
    }
}
