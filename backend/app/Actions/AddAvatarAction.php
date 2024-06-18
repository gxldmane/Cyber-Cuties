<?php

namespace App\Actions;

use App\Models\User;
use Illuminate\Support\Facades\Storage;

class AddAvatarAction
{
    public function handle($avatar, User $user): void
    {
        $path = Storage::disk()->put('users/avatars', $avatar);
        $path = Storage::url($path);
        $user->update([
            'avatar_path' => $path
        ]);
    }
}
