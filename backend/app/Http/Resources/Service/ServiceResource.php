<?php

namespace App\Http\Resources\Service;

use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
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
            'cutieId' => $this->cutie_id,
            'description' => $this->description,
            'categoryId' => $this->category_id,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'imagePath' => $this->image_path,

        ];
    }
}
