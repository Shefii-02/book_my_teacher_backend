<?php

namespace App\Http\Requests\Teachers;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTeacherRequest extends FormRequest
{
  public function authorize(): bool
  {
    return true;
  }

  public function rules(): array
  {
    return [
      'thumb' => 'nullable|image|max:2048',
      'main'  => 'nullable|image|max:2048',

      'name' => 'required|string|max:255',
      'qualifications' => 'nullable|string|max:255',
      'bio' => 'nullable|string',

      'languages' => 'nullable|array',
      'languages.*' => 'string|max:100',

      'price_per_hour' => 'required|numeric|min:0',
      'experience' => 'required|integer|min:0',

      'is_commission' => 'nullable|boolean',
      'commission_percentage' => 'nullable|integer|min:0|max:100',

      'demo_link' => 'nullable|url|max:1000',

      'certificates.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',

      'is_top' => 'nullable|boolean',

      'subjects' => 'nullable|array',
      'subjects.*' => 'integer|exists:subjects,id',

      // 'time_slots' => 'nullable|json', // front-end provides JSON string
      'time_slots' => 'nullable|array',
      'time_slots.*' => 'array',
      'time_slots.*.*.from' => 'required|string',
      'time_slots.*.*.to'   => 'required|string',

      'rates' => 'nullable|array',
      'rates.*.rate_below_10' => 'nullable|numeric|min:0',
      'rates.*.rate_10_30'   => 'nullable|numeric|min:0',
      'rates.*.rate_30_plus' => 'nullable|numeric|min:0',

      'published' => 'nullable|boolean',
      'remove_certificates' => 'nullable|array',
      // 'remove_certificates.*' => 'string',
    ];
  }

  public function prepareForValidation()
  {
    // normalize boolean checkboxes
    $this->merge([
      'is_commission' => $this->has('is_commission') ? true : false,
      'is_top' => $this->has('is_top') ? true : false,
      'published' => $this->has('published') ? true : false,
    ]);
  }
}
