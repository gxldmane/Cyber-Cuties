<?php

namespace App\Services;

use App\Actions\AddAvatarAction;
use App\Actions\AddCoverAction;
use App\Http\Resources\User\UserProfileResource;
use App\Http\Resources\User\CutieResource;
use App\Models\User;
use Spatie\QueryBuilder\QueryBuilder;

class ProfileService
{
    public function update(array $data, User $user, AddAvatarAction $avatarAction, AddCoverAction $coverAction)
    {
        $avatar = $data['avatar'] ?? null;
        $cover = $data['cover'] ?? null;

        unset($data['cover']);
        unset($data['avatar']);


        $user->update($data);

        if ($avatar) {
            $avatarAction->handle($avatar, $user);
        }

        if ($cover) {
            $coverAction->handle($cover, $user);
        }

    }

}
