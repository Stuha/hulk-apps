<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\FavoriteCollection;
use App\Interfaces\FavoriteRepositoryInterface;
use App\Interfaces\MovieRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;


class FavoriteController extends Controller
{
    private FavoriteRepositoryInterface $favoriteRepository;
    private MovieRepositoryInterface $movieRepository;

    public function __construct(FavoriteRepositoryInterface $favoriteRepository, MovieRepositoryInterface $movieRepository)
    {
        $this->favoriteRepository = $favoriteRepository;
        $this->movieRepository = $movieRepository;
    }

    public function index():JsonResponse
    {
        $favoritesCollection = new FavoriteCollection(Cache::remember('favorites', 300, function(){
            return $this->favoriteRepository->getAllFavorites();
        }));
        
        return $favoritesCollection->response();
    }

    public function store(Request $request):JsonResponse
    {
        $movie = $this->movieRepository->getMovieById($request->id);
        $user = Auth::user();

        return response()->json(['data' => $this->favoriteRepository->createFavorite($movie, $user)], Response::HTTP_CREATED);
    }

    public function destroy(int $id):JsonResponse
    {
        $movie = $this->movieRepository->getMovieById($id);
        $user = Auth::user();

        return response()->json(['data' => $this->favoriteRepository->deleteFavorite($movie, $user)], Response::HTTP_OK);
    }
}
