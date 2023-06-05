<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    
    public function __invoke()
    {
        $followingIds = auth()->user()->following->pluck('id')->toArray();
        $posts = Post::whereIn('user_id', $followingIds)->latest()->paginate(10);
        return view('home', [
            'posts' => $posts
        ]);
    }
}
