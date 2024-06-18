<?php

namespace App\Services;

use App\Actions\AddAvatarAction;
use App\Actions\AddCoverAction;
use App\Http\Resources\User\UserProfileResource;
use App\Http\Resources\User\CutieResource;
use App\Models\User;
use Spatie\QueryBuilder\QueryBuilder;

class UserService
{

    public function getAllCuties()
    {
        $cuties = QueryBuilder::for(User::cuties())
            ->allowedFilters(['gender'])
            ->paginate();

        return CutieResource::collection($cuties);
    }

    public function getUserById(int $id)
    {
        $user = User::query()->find($id);

        if ($user) {
            return new UserProfileResource($user);
        }

        return null;
    }
}
