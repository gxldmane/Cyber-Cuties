<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CutieProfileResource extends JsonResource
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
            'birthData' => $this->birth_date,
            'bio' => $this->bio,
            'avatarPath' => $this->avatar_path,
            'coverPath' => $this->cover_path,
            'email' => $this->email,
            'services' => $this->services,
            'media' => $this->media
        ];
    }
}
