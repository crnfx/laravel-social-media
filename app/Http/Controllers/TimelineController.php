<?php

namespace App\Http\Controllers;

use App\Models\Post;

class TimelineController extends Controller
{
    public function index()
    {
        try {
            $user = auth()->user();
            $followingsIds = $user->followings()->pluck('followed_user_id');
            $posts = Post::with(['user', 'likes', 'comments.user'])->whereIn('user_id', $followingsIds)->latest()->paginate(10);
    
            return view('timeline.index', compact('posts'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
        
    }
}
