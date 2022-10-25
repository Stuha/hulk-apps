<?php

namespace App\Interfaces;

use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;

interface PostRepositoryInterface
{
    public function getPostById(int $postId):Post;
    public function deletePost(int $postId):void;
    public function createPost(array $postDetails):Post;
    public function updatePost(int $postId, array $newDetails):Post;
}