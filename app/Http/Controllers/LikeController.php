<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\LikeService;

class LikeController extends Controller
{
    protected LikeService $likeService;

    public function __construct(LikeService $likeService)
    {
        $this->likeService = $likeService;
    }

    public function toggle(Post $post)
    {
        $this->likeService->toggleLike($post, auth()->user());

        return back();
    }
}