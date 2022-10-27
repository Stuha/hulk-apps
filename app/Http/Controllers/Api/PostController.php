<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Repositories\PostRepository;
use Illuminate\Http\JsonResponse;
use App\Services\HttpResponse;

class PostController extends Controller
{

    private PostRepository $postRepository;
    private HttpResponse $httpResponse;

    public function __construct(PostRepository $postRepository, HttpResponse $httpResponse)
    {
        $this->middleware('auth:api');
        $this->postRepository = $postRepository;
        $this->httpResponse = $httpResponse;
    }

    public function store(StorePostRequest $request):JsonResponse
    {
        $post = [];
        $post['title'] = $request->title;
        $post['content'] = $request->content;
        $post['parent_id'] = $request->parent_id;
        $post['movie_id'] = $request->movie_id;
        $post['user_id'] = $request->user_id;

        $post = $this->postRepository->create($post);
        $result = $this->httpResponse->setHttpResponseCreatedOneInstance($post);

        return response()->json($result->response, $result->http_status);
    }

    public function show(string $slug):PostResource
    {
        $post = $this->postRepository->findBySlug($slug);

        return new PostResource($post);
    }

    public function update(UpdatePostRequest $request, int $id):PostResource
    {
        $updateDetails = [];
        $updateDetails['content'] = $request->content;

        $updatedPost = $this->postRepository->update($updateDetails, $id);

        return new PostResource($updatedPost);
    }

    public function destroy(int $id):JsonResponse
    {
        $this->postRepository->delete($id);

        $result = $this->httpResponse->setHttpResponseItemDeleted();

        return response()->json($result->response, $result->http_status);
    }
}
