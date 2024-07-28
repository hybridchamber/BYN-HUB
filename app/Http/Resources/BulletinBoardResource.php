<?php

namespace App\Http\Resources;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class BulletinBoardResource extends JsonResource
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
            'caption' => $this->caption,
            'date_time' => $this->date_time,
            'bb_file' => $this->bb_file,
            'bb_file_url' => $this->bb_file ? Storage::url($this->bb_file) : null,
        ];
    }
}
