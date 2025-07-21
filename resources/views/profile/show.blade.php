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
                    <img src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : asset('images/avatar.png') }}" alt="Avatar" class="w-32 h-32 rounded-full object-cover shadow mb-2">
                    <h1 class="text-2xl font-bold mb-4">{{ $user->name }}'s profile</h1>
                    <div class="mb-6">
                        <p class="text-gray-600">
                            Joined on {{ $user->created_at->format('M d, Y') }}
                        </p>
                    </div>

                    <div class="flex items-center gap-6 mt-4">
                        <span><strong>{{ $user->followers()->count() }}</strong> followers</span>
                        <span><strong>{{ $user->followings()->count() }}</strong> following</span>
                        @auth
                            @if (auth()->id() !== $user->id)
                                <form action="{{ route('users.follow', $user) }}" method="POST">
                                    @csrf
                                    <button class="px-3 py-1 rounded  {{ auth()->user()->isFollowing($user)
                                        ? 'bg-gray-400 hover:bg-gray-400'
                                        : 'bg-blue-500 hover:bg-blue-600 text-white'
                                        }}">
                                        {{ auth()->user()->isFollowing($user) ? 'Unfollow' : 'Follow' }}
                                    </button>
                                </form>
                            @endif
                        @endauth
                    </div>

                    <section class="mb-10 mt-4">
                        <h2 class="text-xl font-semibold mb-2">About me</h2>
                        <div class="prose max-w-none">{{ $user->about }}</div>
                    </section>

                    <h2 class="text-xl font-bold mb-2">Posts by {{ $user->name }}</h2>

                    @forelse($posts as $post)
                    <div class="bg-white p-4 mb-4 rounded shadow-md hover:bg-gray-50">
                        <div class="flex items-center justify-between mb-2">
                            <h2 class="font-semibold">{{ $user->name }}</h2>
                            <small class="text-gray-500">{{ $post->created_at->diffForHumans() }}"></small>
                        </div>
                        <p class="mb-2">{{ $post->content }}</p>

                        @if ($post->image_path)
                        <div class="mb-2">
                            <img class="w-1/2 h-auto rounded" src="{{ asset('storage/' . $post->image_path) }}" alt="">
                        </div>
                        @endif
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
                        <form action="{{ route('post.destroy', $post) }}" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-1 px-3 rounded">Delete post</button>
                        </form>
                        @endif
                    </div>
                    @empty
                        <p class="text-gray-600">No posts yet</p>
                    @endempty
                </div>
            </div>
        </div>
    </div>
</x-app-layout>