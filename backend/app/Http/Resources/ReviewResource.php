<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
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
            'service_id' => $this->service_id,
            'user_id' => $this->user_id,
            'review' => $this->review,
            'type' => $this->type,
            'rating' => $this->rating,
            'created_at' => $this->created_at->format('d.m.Y'),
            'updated_at' => $this->updated_at->format('d.m.Y'),
        ];
    }
}
