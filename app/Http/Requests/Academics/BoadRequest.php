<?php

namespace App\Http\Requests\Academics;

use Illuminate\Foundation\Http\FormRequest;

class BoadRequest extends FormRequest
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
      'description'       => 'required|string',
      'grade_ids'   => 'array',
      'subject_ids' => 'array',
      'position'         => 'nullable|integer|min:0',
      'published'        => 'nullable|boolean',
    ];
  }
}
