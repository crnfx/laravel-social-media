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
        try {
            $me = auth()->user();

            $this->likeService->toggleLike($post, $me);

            return back();
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
        
    }
}