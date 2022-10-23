<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    public function posts()
    {
        return $this->belongsTo(User::class);
    }

    public function movies()
    {
        return $this->belongsTo(Movie::class);
    }
}
