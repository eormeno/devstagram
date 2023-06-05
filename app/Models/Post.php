<?php

namespace App\Models;

use App\Models\Like;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'slug',
        'is_published',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->select(['id', 'name', 'username']);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function likesCount()
    {
        return $this->likes->where('liked', true)->count();
    }

    public function didUserLikeIt(User $user)
    {
        //return $this->likes()->where('user_id', $user->id)->exists();
        return $this->likes->contains('user_id', $user->id);
    }

    public function setLike(User $user)
    {
        if ($this->didUserLikeIt($user)) {
            $this->changeLikeStatus($user);
        } else {
            $this->likes()->create([
                'user_id' => auth()->user()->id,
                'liked' => true,
            ]);
        }
    }

    public function isLike(User $user) {
        if ($this->didUserLikeIt($user)) {
            return $this->likes->where('user_id', $user->id)->first()->liked;
        }
        return false;
    }

    public function changeLikeStatus(User $user)
    {
        $like = $this->likes->where('user_id', $user->id)->first();
        $like->liked = !$like->liked;
        $like->save();
        return $like->liked;
    }
}
