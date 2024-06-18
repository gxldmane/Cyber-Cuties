<?php

namespace App\Services;

use App\Http\Resources\User\UserAuthResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function register(array $data): array
    {
        $user = User::query()->create($data);

        $token = null;

        if ($user['role'] == 'user') {
            $token = $user->createToken('user_token', ['user'])->plainTextToken;
        }

        if ($user['role'] == 'cutie') {
            $token = $user->createToken('cutie_token', ['cutie'])->plainTextToken;
        }

        Auth::login($user);

        return [
            'user' => new UserAuthResource($user),
            'token' => $token
        ];
    }

    public function login(array $data): ?array
    {
        if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
            $user = Auth::user();
            $token = $user->createToken($user['role'].'_token', [$user['role']])->plainTextToken;

            return [
                'user' => new UserAuthResource($user),
                'token' => $token
            ];
        }

        return null;
    }
}
