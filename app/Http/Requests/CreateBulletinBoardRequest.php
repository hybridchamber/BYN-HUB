<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateBulletinBoardRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'caption' => ['required', 'string', 'max:255'],
            'date_time' => ['required', 'date_format:Y-m-d'],
            'bb_file' => ['nullable', 'file', 'max:2048'],
        ];
    }
}

