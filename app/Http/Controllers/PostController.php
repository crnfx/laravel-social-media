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
        $posts = Post::with('user')->latest()->get();
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(PostRequest $request)
    {
        $this->postService->createPost($request->validated(), $request->file('image'));

        return redirect()->route('post.index')->with('success', 'Post created successfully.');
    }

    public function destroy(Post $post)
    {
        $this->postService->deletePost($post);

        return redirect()->route('post.index')->with('success', 'Post deleted successfully.');
    }
}