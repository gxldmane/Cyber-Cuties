<?php

namespace App\Actions;

use App\Models\Service;
use Illuminate\Support\Facades\Storage;

class AddServiceCoverAction
{
    public function handle($cover, Service $service): void
    {
        $path = Storage::disk()->put('services/covers', $cover);
        $path = Storage::url($path);
        $service->update(['image_path' => $path]);
    }
}
