<?php

namespace App\Http\Requests\Categories;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
  public function authorize(): bool
  {
    return true;
  }

  public function rules(): array
  {
    return [
      'title'       => 'required|string|max:255',
      'description' => 'nullable|string',
      'thumbnail'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
      'position'    => 'nullable|integer',
      'status'      => 'nullable|boolean',
    ];
  }

  public function messages(): array
  {
    return [

      'thumb_id.required'    => 'A thumbnail image is required.',
      'thumb_id.image'       => 'The thumbnail must be a valid image.',
      'thumb_id.mimes'       => 'The thumbnail must be a file of type: jpg, jpeg, png, webp.',
      'thumb_id.max'         => 'The thumbnail image may not be larger than 2MB.',

      'title.required'       => 'The banner title is required.',
      'title.string'         => 'The banner title must be a valid string.',
      'title.max'            => 'The banner title may not be greater than 255 characters.',

      'description.string'   => 'The description must be a valid string.',

      'priority.required'    => 'The banner priority is required.',
      'priority.integer'     => 'The priority value must be a number.',
      'priority.min'         => 'The priority must be at least 1.',


      'status.required'      => 'The status field is required.',
      'status.boolean'       => 'The status must be true or false.',
    ];
  }
}
