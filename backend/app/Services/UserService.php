<?php

namespace App\Services;

use App\Http\Resources\User\CutieProfileResource;
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
            ->defaultSort('-created_at')
            ->paginate();

        return CutieResource::collection($cuties);
    }

    public function getUserById(int $id)
    {
        $user = User::query()->find($id);



        if ($user) {
            return new CutieProfileResource($user);
        }

        return null;
    }
}
