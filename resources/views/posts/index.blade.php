<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="container">
                        <h1>All Posts</h1>
                        @if (session('success'))
                            <div сlass="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded">
                                {{ session('success') }}
                            </div>
                        @endif
                        <div style="display: flex; justify-content: end; margin-bottom: 4px;">
                            <a сlass="bg-blue-500 bg:hover-blue-600 text-white font-semibold py-2 px-4 rounded"
                                href="{{ route('post.create') }}">Create a new post</a>
                        </div>
                        <ul>
                            @foreach ($posts as $post)
                                <div class="bg-white shadow-md rounded p-4 mb-4">
                                    <div class="flex items-center justify-between mb-2">
                                        <h2 class="font-bold ">
                                            <a class="text-blue-600 hover:underline"
                                                href="{{ route('users.show', $post->user_id) }}">
                                                {{ $post->user->name }}
                                            </a>
                                        </h2>
                                        <small class="text-gray-500">{{ $post->created_at->diffForHumans() }}</small>
                                    </div>

                                    @if ($post->image_path)
                                        <div class="mb-2">
                                            <img class="w-1/2 h-auto rounded" src="{{ asset('storage/' . $post->image_path) }}"
                                                alt="">
                                        </div>
                                    @endif

                                    <p class="mb-2">{{ $post->content }}</p>

                                    <div class="flex items-center gap-4 mb-2">
                                        <form action="{{ route('posts.like', $post) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="flex items-center gap-1">
                                                @auth
                                                    @if ($post->isLikedBy(auth()->user()))
                                                        <svg class="w-5 h-5 fill-red-600">
                                                            <use xlink:href="#icon-heart" />
                                                        </svg>
                                                        <span class="text-red-600">Unlike</span>
                                                    @else
                                                        <svg class="w-5 h-5 fill-none stroke-gray-600">
                                                            <use xlink:href="#icon-heart" />
                                                        </svg>
                                                        <span class="text-red-600">Like</span>
                                                    @endif
                                                @endauth
                                            </button>
                                        </form>
                                        <span class="text-gray-600">{{ $post->likes()->count() }} likes</span>
                                    </div>

                                    <div class="space-y-2 mb-4">
                                        @foreach ($post->comments as $comment)
                                            <div class="border-l-4 border-blue-200 pl-2">
                                                <strong>{{ $comment->user->name }}</strong>
                                                <small class="text-gray-500">
                                                    {{ $comment->created_at->diffForHumans() }}
                                                </small>
                                                <p>{{ $comment->body }}</p>
                                            </div>
                                        @endforeach
                                    </div>

                                    @auth
                                        <form action="{{ route('posts.comments.store', $post) }}" method="POST">
                                            @csrf
                                            <textarea name="body" rows="2" placeholder="Add a comment..."
                                                class="w-full border border-gray-300 rounded p-2 mb-2"></textarea>
                                            <button
                                                class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-1 px-3 rounded">
                                                Comment
                                            </button>
                                        </form>
                                    @endauth
                                    @if (auth()->check() && auth()->id() === $post->user_id)
                                        <form action="{{ route('post.destroy', $post) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                class="bg-red-300 hover:bg-red-600 text-white font-semibold py-1 px-3 rounded"
                                                type="submit">Delete post</button>
                                        </form>
                                    @endif
                                </div>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>