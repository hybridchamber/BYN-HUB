<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'cover_photo' => ['nullable', 'mimes:jpeg,png,jpg,gif,pdf', 'max:2048'],
            'description' => ['required', 'string'],
            'location' => ['required', 'string', 'max:255'],
            'date_time' => ['required', 'date_format:Y-m-d\TH:i'],
            'category' => ['required', 'string', 'max:255'],
            'invite' => 'boolean',
        ];
    }
}
