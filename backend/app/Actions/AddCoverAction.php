<?php

namespace App\Actions;

use App\Models\User;
use App\Models\UserMedia;
use Illuminate\Support\Facades\Storage;

class AddCoverAction
{
    public function handle($cover, User $user): void
    {
        $path = Storage::disk()->put('users/covers', $cover);
        $path = Storage::url($path);

        if ($user->cover_path) {
            Storage::delete($user->cover_path);
        }

        $user->update([
            'cover_path' => $path
        ]);

    }
}
