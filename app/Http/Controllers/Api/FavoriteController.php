<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\FavoriteCollection;
use App\Interfaces\FavoriteRepositoryInterface;
use App\Interfaces\MovieRepositoryInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Maize\Markable\Models\Favorite;

class FavoriteController extends Controller
{
    private FavoriteRepositoryInterface $favoriteRepository;
    private MovieRepositoryInterface $movieRepository;

    public function __construct(FavoriteRepositoryInterface $favoriteRepository, MovieRepositoryInterface $movieRepository)
    {
        $this->favoriteRepository = $favoriteRepository;
        $this->movieRepository = $movieRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $favoritesCollection = new FavoriteCollection(Cache::remember('favorites', 300, function(){
            return $this->favoriteRepository->getAllFavorites();
        }));
        
        return $favoritesCollection->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $movie = $this->movieRepository->getMovieById($request->id);
        $user = Auth::user();

        return response()->json(['data' => $this->favoriteRepository->createFavorite($movie, $user)], Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $movie = $this->movieRepository->getMovieById($id);
        $user = Auth::user();

        return response()->json(['data' => $this->favoriteRepository->deleteFavorite($movie, $user)], Response::HTTP_OK);
    }
}
