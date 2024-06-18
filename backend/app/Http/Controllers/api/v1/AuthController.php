<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\v1\Auth\LoginRequest;
use App\Http\Requests\api\v1\Auth\RegistrationRequest;
use App\Services\AuthService;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{

    public AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegistrationRequest $request)
    {
        $data = $request->validated();

        $data = $this->authService->register($data);

        return response(
            [
                'data' => [
                    'user' => $data['user'],
                    'token' => $data['token']
                ]
            ],
            Response::HTTP_CREATED
        );

    }

    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        $data = $this->authService->login($data);

        if ($data) {
            return response(
                [
                    'data' => [
                        'user' => $data['user'],
                        'token' => $data['token']
                    ]
                ],
                Response::HTTP_OK
            );
        }

        return response('Invalid credentials', Response::HTTP_UNAUTHORIZED);


    }
}
