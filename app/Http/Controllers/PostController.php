<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['show', 'index']);
    }

    public function index(User $user)
    {

        $posts = Post::where('user_id', $user->id)->latest()->paginate(4);

        return view('dashboard', [
            'user' => $user,
            'posts' => $posts,
        ]);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => ['required', 'min:5', 'max:255'],
            'description' => ['required'],
            'image' => ['required'],
        ]);

        /*   Post::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'image' => $request->image,
            'slug' => Str::slug($request->title),
            'is_published' => true,
        ]); */

        $request->user()->posts()->create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $request->image,
            'slug' => Str::slug($request->title),
            'is_published' => true,
        ]);

        return redirect()->route('posts.index', auth()->user());
    }

    public function show(User $user, Post $post)
    {
        return view('posts.show', [
            'post' => $post,
            'user' => $user,
        ]);
    }

    public function destroy(Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            abort(403);
        }
        $this->authorize('delete', $post);
        $post->delete();

        // remove the uploaded image if exists
        $image_path = public_path('uploads/' . $post->image);
        if (file_exists($image_path)) {
            unlink($image_path);
        }

        return redirect()->route('posts.index', auth()->user());
    }
}
