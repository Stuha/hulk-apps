<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use App\Http\Resources\MovieResource;
use App\Repositories\MovieRepository;
use App\Services\HttpResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;


class MovieController extends Controller
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
        $movies = $this->movieRepository->fetchAll();
        $result = $this->httpResponse->setHttpResponse($movies);

        return response()->json($result->response, $result->http_status);
    }

    public function show(string $slug):JsonResource
    {
        $movie = $this->movieRepository->findBySlug($slug);

        return new MovieResource($movie);
    }

    public function store(StoreMovieRequest $request):JsonResponse
    {
        $movie = [];
        $movie['name'] = $request->name;
        $movie['year'] = $request->year;
        $movie['director_name'] = $request->director_name;

        $movie = $this->movieRepository->create($movie);

        $result = $this->httpResponse->setHttpResponseCreatedOneInstance($movie);

        return response()->json($result->response, $result->http_status);
    }

    public function update(UpdateMovieRequest $request, int $id):MovieResource
    {
        $updateDetails = [];
        $updateDetails['name'] = $request->name;
        $updateDetails['year'] = $request->year;
        $updateDetails['director_name'] = $request->director_name;
        
        $updatedMovie = $this->movieRepository->update($updateDetails, $id);

        return new MovieResource($updatedMovie);
    }

    public function destroy(int $id):JsonResponse
    {
        $this->movieRepository->delete($id);

        $result = $this->httpResponse->setHttpResponseItemDeleted();

        return response()->json($result->response, $result->http_status);
    }
}
