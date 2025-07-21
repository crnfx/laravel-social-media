<?php

namespace App\Services;

use App\Models\User;

class FollowService
{
    public function toggleFollow(User $follower, User $userToFollow)
    {
        if ($follower->id === $userToFollow->id) {
            return false;
        }

        $follower->followings()->toggle($userToFollow->id);

        return true;
    }
}