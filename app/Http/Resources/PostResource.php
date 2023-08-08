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
            'attachment_type' => $this->attachment_type,
            'likes' => $this->likes->count(),
            'liked_by_me' => $this->likes()->where('user_id', auth()->id())->exists(),
            'saves' => $this->saves->count(),
            'saved_by_me' => $this->saves()->where('user_id', auth()->id())->exists(),
        ];
    }
}
