<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Facades\Storage;

class PostService
{
    public function createPost(array $data, $image = null): Post
    {
        $imagePath = null;
        if ($image) {
            $imagePath = $image->store('posts', 'public');
        }

        return Post::create([
            'content' => $data['content'],
            'user_id' => auth()->id(),
            'image_path' => $imagePath
        ]);
    }

    public function deletePost(Post $post): bool
    {
        if ($post->image_path) {
            Storage::disk('public')->delete($post->image_path);
        }

        return $post->delete();
    }
}