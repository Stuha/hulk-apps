<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Movie;
use Carbon\Carbon;

class FollowResource extends JsonResource
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
            'movieTitle' => Movie::find($this->followable_id)->name,
            'followedAt' => Carbon::parse($this->followed_at)->toDateTimeString()
        ];
    }
}
