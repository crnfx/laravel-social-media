<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\Post;

class CommentService
{
    public function createComment(Post $post, array $data): Comment
    {
        return $post->comments()->create([
            'user_id' => auth()->id(),
            'body' => $data['body']
        ]);
    }
}