<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;

class LikePost extends Component
{
    public Post $post;
    public bool $isLiked;

    public function mount(Post $post)
    {
        $this->post = $post;
        $this->isLiked = $post->isLike(auth()->user());
    }

    public function like()
    {
        $this->post->setLike(auth()->user());
        $this->isLiked = $this->post->isLike(auth()->user());
    }

    public function render()
    {
        return view('livewire.like-post');
    }
}
