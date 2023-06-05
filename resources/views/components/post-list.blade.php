<div>
    @if ($posts->isEmpty())
        <p class="text-gray-600 uppercase font-bold text-sm text-center">There are not posts</p>
    @endif

    <div class="grid md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-5">
        @foreach ($posts as $post)
            <div class="rounded-xl bg-gray-300 shadow p-2">
                <a href="{{ route('posts.show', ['post' => $post, 'user' => $post->user]) }}">
                    <img class="rounded-xl" src="{{ asset('uploads') . '/' . $post->image }}"
                        alt="Post image {{ $post->title }}" />
                </a>
                <p class="text-white bg-gray-700 hover:bg-gray-600 cursor-pointer rounded-md text-center p-1 my-2 font-semibold">{{ $post->title }}
                </p>
            </div>
        @endforeach
    </div>

    <div class="my-10">
        {{ $posts->links() }}
    </div>
</div>
