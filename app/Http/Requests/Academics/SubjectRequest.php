<?php

namespace App\Http\Requests\Academics;

use Illuminate\Foundation\Http\FormRequest;

class SubjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'icon'             => $this->isMethod('POST') ? 'required|image|mimes:png,jpg,jpeg,webp|max:2048' : 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
            'name'            => 'required|string|max:255',
            'color_code'       => 'required|string',
            'difficulty_level' => 'required|String',
            'position'         => 'nullable|integer|min:0',
            'published'        => 'nullable|boolean',
        ];
    }
}
