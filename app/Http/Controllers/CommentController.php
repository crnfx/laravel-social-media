<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Post;
use App\Services\CommentService;

class CommentController extends Controller
{
    protected $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    public function store(CommentRequest $request, Post $post)
    {
        try {
            $this->commentService->createComment($post, $request->validated());
            return back();
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
       
    }
}