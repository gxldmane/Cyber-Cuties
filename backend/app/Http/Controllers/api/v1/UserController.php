<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;


class UserController extends Controller
{
    public UserService $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }


    public function getAllCuties()
    {
        return $this->service->getAllCuties();
    }


    public function show(int $id)
    {
        $user = $this->service->getUserById($id);

        if (!$user) {
            return response('User not found', ResponseAlias::HTTP_NOT_FOUND);
        }

        return $user;
    }

}
