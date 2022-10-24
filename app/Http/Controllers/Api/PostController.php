<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Interfaces\PostRepositoryInterface;
use Illuminate\Http\Response;

class PostController extends Controller
{

    private $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->middleware('auth:api');
        $this->postRepository = $postRepository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        $post = [];
        $post['content'] = $request->content;
        $post['parent_id'] = $request->parentId;
        $post['movie_id'] = $request->movieId;
        $post['user_id'] = $request->userId;

        return response()->json(['data' => $this->postRepository->createPost($post)], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = $this->postRepository->getPostById($id);

        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, $id)
    {
        $updateDetails = [];
        $updateDetails['content'] = $request->content;

        $updatedPost = $this->postRepository->updatePost($id, $updateDetails);

        return new PostResource($updatedPost);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->postRepository->deletePost($id);

        return response()->json(['item_deleted' => true], Response::HTTP_NO_CONTENT);
    }
}
