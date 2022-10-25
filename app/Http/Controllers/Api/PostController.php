<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Interfaces\PostRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class PostController extends Controller
{

    private PostRepositoryInterface $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->middleware('auth:api');
        $this->postRepository = $postRepository;
    }

    public function store(StorePostRequest $request):JsonResponse
    {
        $post = [];
        $post['content'] = $request->content;
        $post['parent_id'] = $request->parentId;
        $post['movie_id'] = $request->movieId;
        $post['user_id'] = $request->userId;

        return response()->json(['data' => $this->postRepository->createPost($post)], Response::HTTP_CREATED);
    }

    public function show(int $id):PostResource
    {
        $post = $this->postRepository->getPostById($id);

        return new PostResource($post);
    }

    public function update(UpdatePostRequest $request, int $id):PostResource
    {
        $updateDetails = [];
        $updateDetails['content'] = $request->content;

        $updatedPost = $this->postRepository->updatePost($id, $updateDetails);

        return new PostResource($updatedPost);
    }

    public function destroy(int $id):JsonResponse
    {
        $this->postRepository->deletePost($id);

        return response()->json(['item_deleted' => true], Response::HTTP_NO_CONTENT);
    }
}
