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
                        <h1 class="text-xl font-bold mb-4">Create post</h1>
                        @if ($errors->any())
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-4">
                                <label for="content" class="block font-semibold text-gray-700 mb-2">Post
                                    Content:</label>
                                <textarea rows="3" id="content" class="w-full p-2 border border-gray-300 rounded"
                                    name="content" placeholder="Post content"></textarea>
                            </div>
                            <div class="mb-4">
                                <label for="image" class="block font-semibold text-gray-700">Attach image:</label>
                                <input type="file" name="image" accept="image/*"
                                    class="block w-full border border-gray-300 p-2 rounded">
                            </div>
                            <button class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded"
                                type="submit">Post</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>