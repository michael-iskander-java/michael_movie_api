<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MovieResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'MoviesDataBase_ID' => $this->mdb_id,
            'Popularity' => $this->popularity,
            'Vote Count' => $this->vote_count,
            'Is Video' => $this->video=== 0 ? 'false' : 'true',
            'Is Adult' => $this->adult=== 0 ? 'false' : 'true',
            'Original Language' => $this->original_language,
            'Original Title' => $this->original_title,
            'title' => $this->title,
            'Vote Average' => $this->vote_average,
            'Overview' => $this->overview,
            'Release Date' => $this->release_date,
            'genres' => $this->genres->map(function ($event) {
                return $event->name;
            }),

        ];
    }
}
