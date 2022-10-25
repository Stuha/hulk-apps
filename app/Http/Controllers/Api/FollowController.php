<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\FollowCollection;
use App\Interfaces\MovieRepositoryInterface;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    private MovieRepositoryInterface $movieRepository;

    public function __construct(MovieRepositoryInterface $movieRepository)
    {
        $this->middleware('auth:api');
        $this->movieRepository = $movieRepository;
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
        $movie = $this->movieRepository->getMovieById($request->id);
        $user = User::find(Auth::user()->id);

        $user->follow($movie);

        return response()->json(['follow' => 'true'], Response::HTTP_OK);
    }

    public function destroy(int $id):JsonResponse
    {
        $movie = $this->movieRepository->getMovieById($id);
        $user = User::find(Auth::user()->id);

        $user->unfollow($movie);

        return response()->json(['unfollow' => 'true'], Response::HTTP_OK);
    }
}
