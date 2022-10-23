<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MovieCollection;
use App\Http\Resources\MovieResource;
use App\Interfaces\MovieRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieController extends Controller
{

    private MovieRepositoryInterface $movieRepository;

    public function __construct(MovieRepositoryInterface $movieRepository)
    {
        $this->middleware('auth:api');
        $this->movieRepository = $movieRepository;
    }

    public function index():JsonResponse
    {
        $movies = $this->movieRepository->getAllMovies();
        $moviesCollection = new MovieCollection($movies);

        return $moviesCollection->response();
    }

    public function show(int $id):JsonResource
    {
        $movie = $this->movieRepository->getMovieById($id);

        return new MovieResource($movie);
    }
}
