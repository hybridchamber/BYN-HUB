<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DemographicResource extends JsonResource
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
            'youth_profile_id' => $this->youth_profile_id,
            'civil_status' => $this->civil_status,
            'youth_age_group' => $this->youth_age_group,
            'educational_background' => $this->educational_background,
            'youth_classification' => $this->youth_classification,
            'specific_needs_detail' => $this->specific_needs_detail,
            'work_status' => $this->work_status,
            'registered_sk_voter' => $this->registered_sk_voter,
            'registered_national_voter' => $this->registered_national_voter,
            'sk_assembly' => $this->sk_assembly,
            'sk_assembly_times_attended' => $this->sk_assembly_times_attended,
            'sk_assembly_not_attended' => $this->sk_assembly_not_attended,
            'vote_last_sk_election' => $this->vote_last_sk_election,
        ];
    }
}

