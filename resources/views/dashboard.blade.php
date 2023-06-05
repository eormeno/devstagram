@extends('layouts.app')

@section('title')
    Perfil de {{ $user->name }}
@endsection

@section('content')
    <div class="flex justify-center">
        <div class="w-full md:w-8/12 lg:w-6/12 flex flex-col items-center md:flex-row">
            <div class="md:w-8/12 lg:w-6/12 px-5">
                <img class="rounded-full shadow-black" src="{{ asset('profile_images') . '/' . $user->profile_image }}"
                    alt="User's profile image" />
            </div>

            <div class="md:w-8/12 lg:w-6/12 px-5 flex flex-col items-center md:justify-center md:items-start py-8 md:py-8">
                <div class="flex items-center gap-2">
                    <p class="text-gray-700 text-2xl">{{ $user->username }}</p>

                    @auth
                        @if (auth()->user()->id == $user->id)
                            <a href="{{ route('profile.index', $user) }}"
                                class="text-gray-500 hover:text-gray-600 cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                </svg>
                            </a>
                        @endif
                    @endauth
                </div>
                <p class="text-gray-800 text-sm mb-3 font-bold mt-4">
                    {{ $user->followers->count() }}
                    <span class="font-normal"> @choice('Follower|Followerd', $user->followers->count())</span>
                </p>
                <p class="text-gray-800 text-sm mb-3 font-bold mt-4">
                    {{ $user->following->count() }}
                    <span class="font-normal"> Following</span>
                </p>
                <p class="text-gray-800 text-sm mb-3 font-bold mt-4">
                    {{ $posts->count() }}
                    <span class="font-normal"> Posts</span>
                </p>

                @auth
                    @if ($user->id != auth()->user()->id)
                        @if (!$user->isFollowedBy(auth()->user()))
                            <form action="{{ route('users.follow', $user) }}" method="POST">
                                @csrf
                                <input type="submit" value="Follow"
                                    class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full px-3 py-1 text-xs text-white rounded-lg" />
                            </form>
                        @else
                            <form action="{{ route('users.unfollow', $user) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="submit" value="Unfollow"
                                    class="bg-red-500 hover:bg-red-600 transition-colors cursor-pointer uppercase font-bold w-full px-3 py-1 text-xs text-white rounded-lg" />
                            </form>
                        @endif
                    @endif
                @endauth
            </div>
        </div>
    </div>

    <section class="container mx-auto mt-10">
        <h2 class="text-4xl text-center font-black my-10">Posts</h2>

        <x-post-list :posts="$posts" />

    </section>
@endsection
