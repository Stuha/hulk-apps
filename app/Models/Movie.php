<?php

namespace App\Models;

use App\Traits\FollowableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Maize\Markable\Markable;
use Maize\Markable\Models\Favorite;

class Movie extends Model
{
    use HasFactory;
    use FollowableTrait;
    use Markable;

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    protected static $marks = [
        Favorite::class,
    ];
}
