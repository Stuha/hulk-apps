<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\FollowCollection;
use App\Models\User;
use App\Repositories\MovieRepository;
use App\Services\HttpResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    private MovieRepository $movieRepository;
    private HttpResponse $httpResponse;

    public function __construct(MovieRepository $movieRepository, HttpResponse $httpResponse)
    {
        $this->middleware('auth:api');
        $this->movieRepository = $movieRepository;
        $this->httpResponse = $httpResponse;
    }

    public function index():JsonResponse
    {
        $user = User::find(Auth::user()->id);
        $followings = $user->followings;

        $followingsCollection = new FollowCollection($followings);

        return $followingsCollection->response();
    }

    public function store(Request $request):JsonResponse
    {
        $movie = $this->movieRepository->findById($request->id);
        $user = User::find(Auth::user()->id);

        $followMovie = $user->follow($movie);
        $result = $this->httpResponse->setHttpResponseCreatedOneInstance($followMovie);

        return response()->json($result->response, $result->http_status);
    }

    public function destroy(int $id):JsonResponse
    {
        $movie = $this->movieRepository->findById($id);
        $user = User::find(Auth::user()->id);

        $user->unfollow($movie);
        $result = $this->httpResponse->setHttpResponseItemDeleted();

        return response()->json($result->response, $result->http_status);
    }
}
