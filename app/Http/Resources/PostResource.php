<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'parentId' => $this->parent_Id,
            'user' => $this->user->name,
            'movieId' => $this->movie_id,
            'createdAt' => Carbon::parse($this->created_at)->toDateTimeString(),
            'updatedAt' => Carbon::parse($this->updated_at)->toDateTimeString()
        ];
    }
}
