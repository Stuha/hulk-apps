<?php

namespace App\Repositories;

use App\Interfaces\PostRepositoryInterface;
use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;

class PostRepository implements PostRepositoryInterface
{
    public function getAllPosts():Collection
    {
        return Post::all();
    }

    public function getPostById(int $id):Post
    {
        return Post::findOrFail($id);
    }

    public function deletePost(int $id):void
    {
        Post::destroy($id);
    }

    public function createPost(array $movieDetails):Post
    {
        return Post::create($movieDetails);
    }

    public function updatePost(int $id, array $newData):Post
    {
        return Post::whereId($id)->update($newData)->get();
    }
}
