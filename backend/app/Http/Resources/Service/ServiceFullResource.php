<?php

namespace App\Http\Resources\Service;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\ServiceTypeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceFullResource extends JsonResource
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
            'cutie_id' => $this->cutie_id,
            'description' => $this->description,
            'image_path' => $this->image_path,
            'category' => new CategoryResource($this->category),
            'types' => ServiceTypeResource::collection($this->types),
        ];
    }
}
