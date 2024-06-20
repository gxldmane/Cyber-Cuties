<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Follower;
use App\Models\User;

class FollowerController extends Controller
{
    public function followUser(int $userId)
    {
        $user = User::find($userId);

        if ($user->followers()->where('user_id', auth()->user()->id)->exists()) {
            return response('User already followed', 400);
        }

        Follower::query()->create([
           'user_id' => auth()->user()->id,
           'following_id' => $user->id
        ]);

        return response('User followed', 200);

    }

    public function unfollowUser(int $userId)
    {
        $user = User::find($userId);

        if (!$user->followers()->where('user_id', auth()->user()->id)->exists()) {
            return response('User already unfollowed', 400);
        }

        Follower::query()->where('user_id', auth()->user()->id)->where('following_id', $user->id)->delete();

        return response('User unfollowed', 200);
    }
}
