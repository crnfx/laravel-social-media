<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Services\PostService;

class PostController extends Controller
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index()
    {
        try {
            $posts = Post::with('user')->latest()->get();
            return view('posts.index', compact('posts'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
       
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(PostRequest $request)
    {
        try {
            $this->postService->createPost($request->validated(), $request->file('image'));

            return redirect()->route('post.index')->with('success', 'Post created successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
       
    }

    public function destroy(Post $post)
    {
        try {
            $this->postService->deletePost($post);

            return redirect()->route('post.index')->with('success', 'Post deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
        
    }
}