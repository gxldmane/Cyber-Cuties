<?php

namespace App\Http\Resources\User;

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
            'id' => $this->id,
            'role' => $this->role,
            'username' => $this->username,
            'gender' => $this->gender,
            'birth_data' => $this->birth_date,
            'bio' => $this->bio,
            'avatar_path' => $this->avatar_path,
            'cover_path' => $this->cover_path,
            'email' => $this->email,
        ];
    }
}
