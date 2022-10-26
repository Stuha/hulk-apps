<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\FavoriteCollection;
use App\Interfaces\FavoriteRepositoryInterface;
use App\Repositories\MovieRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;


class FavoriteController extends Controller
{
    private FavoriteRepositoryInterface $favoriteRepository;
    private MovieRepository $movieRepository;


    public function __construct(FavoriteRepositoryInterface $favoriteRepository, MovieRepository $movieRepository)
    {
        $this->middleware('auth:api');
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
        $movie = $this->movieRepository->findById($request->id);
        $user = Auth::user();

        $favoiriteMovie =  $this->favoriteRepository->createFavorite($movie, $user);
        $result = $this->httpResponse->setHttpResponseCreatedOneInstance($favoiriteMovie);

        return response()->json($result->response, $result->http_status);
    }

    public function destroy(int $id):JsonResponse
    {
        $movie = $this->movieRepository->findById($id);
        $user = Auth::user();

        $this->favoriteRepository->deleteFavorite($movie, $user);
        $result = $this->httpResponse->setHttpResponseItemDeleted();

        return response()->json($result->response, $result->http_status);
    }
}
