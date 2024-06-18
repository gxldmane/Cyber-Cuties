<?php

namespace App\Http\Controllers\api\v1;

use App\Actions\AddAvatarAction;
use App\Actions\AddCoverAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\api\v1\User\UpdateRequest;
use App\Http\Resources\User\UserProfileResource;
use App\Services\ProfileService;
use Illuminate\Support\Facades\Auth;


class ProfileController extends Controller
{
    public ProfileService $service;

    public function __construct(ProfileService $service)
    {
        $this->service = $service;
    }

    public function show()
    {
        return new UserProfileResource(Auth::user());
    }


    public function update(UpdateRequest $request)
    {
        $data = $request->validated();
        $user = Auth::user();

        $this->service->update($data, $user, new AddAvatarAction(), new AddCoverAction());

        return new UserProfileResource($user);

    }

}
