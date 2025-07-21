<?php

namespace App\Services;

use App\Models\Post;
use App\Models\User;

class LikeService
{
    public function toggleLike(Post $post, User $user): void
    {
        if ($post->isLikedBy($user)) {
            $post->likes()->where('user_id', $user->id)->delete();
        } else {
            $post->likes()->create([
                'user_id' => $user->id,
            ]);
        }
    }
}