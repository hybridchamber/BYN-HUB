<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class YouthProfileResource extends JsonResource
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
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'suffix' => $this->suffix,
            'region' => $this->region,
            'province' => $this->province,
            'municipality' => $this->municipality,
            'baranggay' => $this->baranggay,
            'purok' => $this->purok,
            'sex' => $this->sex,
            'age' => $this->age,
            'birthdate' => $this->birthdate,
            'email' => $this->email,
            'contact_no' => $this->contact_no,
            'demographic' => new DemographicResource($this->whenLoaded('demographic')), // Ensure demographic relationship is loaded
        ];
    }
}

