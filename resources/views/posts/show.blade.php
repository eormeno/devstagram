@extends('layouts.app')

@section('title')
    {{ $post->title }}
@endsection

@section('content')
    <div class="container mx-auto flex">
        <div class="md:w-1/2">
            <img class="rounded-xl shadow-xl max-w-md" src="{{ asset('uploads') . '/' . $post->image }}"
                alt="Post image {{ $post->title }}" />
            <div class="p-3 flex items-center gap-4">
                @auth
                    <livewire:like-post :post="$post" />
                @endauth
            </div>
            <div class="p-3">
                <p class="font-bold">{{ $post->user->name }}</p>
            </div>
            <div class="p-3">
                <p class="font-bold">{{ $post->title }}</p>
                <p class="text-sm">{{ $post->description }}</p>
                <p class="text-sm">{{ $post->created_at->diffForHumans() }}</p>
            </div>
            @auth
                @if ($post->user->id == auth()->user()->id)
                    <form action="{{ route('posts.destroy', $post) }}" method="POST">
                        @method('DELETE')
                        @csrf
                        <input type="submit" value="Remove post"
                            class="bg-red-500 hover:bg-red-600 p-2 rounded text-white font-bold cursor-pointer uppercase mt-4">
                    </form>
                @endif
            @endauth
        </div>
        <div class="md:w-1/2 p-5">
            <label for="comment" class="mb-2 block uppercase text-gray-500 font-bold">Comment</label>
            @if (@session('success'))
                <div class="bg-green-500 text-white p-2 mb-6 rounded-lg text-center uppercase font-bold">
                    {{ session('success') }}
                </div>
            @endif
            @auth
                <div class="shadow bg-white p-5 mb-5">
                    <p class="text-xl font-bold text-center mb-4">Comments</p>
                </div>
                <form action="{{ route('comments.store', ['user' => $user, 'post' => $post]) }}" method="POST">
                    @csrf
                    <div class="mb-5">
                        <textarea id="comment" name="comment" placeholder="Add a comment to the post"
                            class="border p-4 w-full rounded-lg @error('description') border-red-500 @enderror"></textarea>
                        @error('comment')
                            <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
                        @enderror
                    </div>
                    <input type="submit" value="Send comment"
                        class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg" />
                </form>
            @endauth

            <div class="bg-white shadow mb-5 max-h-96 overflow-y-scroll">
                @if ($post->comments->count())
                    @foreach ($post->comments as $commet)
                        <div class="p-5 border-gray-300 border-b">
                            <a href="{{ route('posts.index', $commet->user) }}">{{ $commet->user->username }}</a>
                            <p class="font-black">{{ $commet->comment }}</p>
                            <p class="text-sm text-gray-500 font-mono">{{ $commet->created_at->diffForHumans() }}</p>
                        </div>
                    @endforeach
                @else
                    <p class="p-10 text-center text-xl font-bold">No comments yet</p>
                @endif
            </div>
        </div>
    </div>
@endsection
