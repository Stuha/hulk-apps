<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Movie;
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
        $posts = Movie::find($this->id)->posts;
        $postCollection = new PostCollection($posts);

        return [
            'name' => $this->name,
            'posts' => $postCollection->paginate(25),
        ];
    }
}
