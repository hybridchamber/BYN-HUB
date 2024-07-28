<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateDemographicProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Youth Profile Validation Rules
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'suffix' => ['nullable', 'string', 'max:255'],
            'region' => ['required', 'string', 'max:255'],
            'province' => ['required', 'string', 'max:255'],
            'municipality' => ['required', 'string', 'max:255'],
            'baranggay' => ['required', 'string', 'max:255'],
            'purok' => ['nullable', 'string', 'max:255'],
            'sex' => ['required', 'string'],
            'age' => ['required', 'string'],
            'birthdate' => ['required', 'date_format:Y-m-d'],
            'email' => ['required', 'string', 'email', 'max:255',
                Rule::unique('youth_profiles')->ignore($this->route('youthprofile'))
            ],            
            'contact_no' => ['nullable', 'string'],

            // Demographic Validation Rules
            'civil_status' => ['required', 'string', 'max:255'],
            'youth_age_group' => ['nullable', 'string', 'max:255'],
            'educational_background' => ['required', 'string', 'max:255'],
            'youth_classification' => ['required', 'string', 'max:255'],
            'specific_needs_detail' => ['nullable', 'string', 'max:255'],
            'work_status' => ['required', 'string', 'max:255'],
            'registered_sk_voter' => ['required', 'string'],
            'registered_national_voter' => ['required', 'string'],
            'sk_assembly' => ['required', 'string'],
            'sk_assembly_times_attended' => ['nullable', 'string'],
            'sk_assembly_not_attended' => ['nullable', 'string'],
            'vote_last_sk_election' => ['required', 'string'],
        ];
    }
}



