<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\PostCollection;

class MovieResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $postCollection = new PostCollection($this->posts);

        return [
            'title' => $this->title,
            'directorName' => $this->director_name,
            'release_year' => $this->year,
            'posts' => $postCollection->paginate(25),
        ];
    }
}
