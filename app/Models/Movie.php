<?php

namespace App\Models;

use App\Filters\MovieFilter;
use App\Traits\FollowableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Maize\Markable\Markable;
use Maize\Markable\Models\Favorite;
use LaravelLegends\EloquentFilter\Concerns\HasFilter;
use Cviebrock\EloquentSluggable\Sluggable;

class Movie extends Model
{
    use HasFactory;
    use FollowableTrait;
    use Markable;
    use HasFilter;
    use Sluggable;

    protected static $marks = [
        Favorite::class,
    ];

    protected $guarded = [];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['director_name', 'name']
            ]
        ];
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
