<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'category' => $this->category,
            'cover_photo' => $this->cover_photo,
            'cover_photo_url' => $this->cover_photo ? Storage::url($this->cover_photo) : null,
            'location' => $this->location,
            'date_time' => $this->date_time,
            'invite' => $this->invite,
        ];
    }
}
