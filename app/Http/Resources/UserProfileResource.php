<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'email' => $this->email,
            'first_name_en' => $this->first_name_en,
            'first_name_ar' => $this->first_name_ar,
            'last_name_en' => $this->last_name_en,
            'last_name_ar' => $this->last_name_ar,
            'phone' => $this->phone,
            'address' => $this->address,
            'image' => $this->image,
            'department' => $this->department?->name,
            'section' => $this->section?->name,
        ];
    }
}
