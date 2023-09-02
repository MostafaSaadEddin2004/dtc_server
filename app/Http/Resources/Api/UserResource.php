<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'first_name_en'=>$this->first_name_en,
            'last_name_en'=>$this->last_name_en,
            'first_name_ar'=>$this->first_name_ar,
            'last_name_ar'=>$this->last_name_ar,
            'email'=>$this->email,
            'phone'=>$this->phone,
            'password'=>$this->password,
        ];
    }
}
