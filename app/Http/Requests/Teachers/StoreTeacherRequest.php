<?php

namespace App\Http\Requests\Teachers;

use Illuminate\Foundation\Http\FormRequest;

class StoreTeacherRequest extends FormRequest
{
  public function authorize(): bool
  {
    return true;
  }

  public function rules(): array
  {
    return [
      'thumb' => 'required|image|max:2048',
      'main'  => 'required|image|max:2048',

      'name' => 'required|string|max:255',
      'qualifications' => 'required|string|max:255',
      'bio' => 'nullable|string',

      'languages' => 'required|array',
      'languages.*' => 'string|max:100',

      'price_per_hour' => 'required|numeric|min:0',
      'experience' => 'required|integer|min:0',

      'is_commission' => 'nullable|boolean',
      'commission_percentage' => 'nullable|integer|min:0|max:100',

      'demo_link' => 'nullable|url|max:1000',

      'certificates.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',

      'is_top' => 'nullable|boolean',

      'subjects' => 'required|array',
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
      'remove_certificates.*' => 'string',
    ];
  }

  public function messages(): array
  {
    return [
      // thumb
      'thumb.required' => 'Teacher thumbnail image is required.',
      'thumb.image'    => 'Thumbnail must be an image.',
      'thumb.max'      => 'Thumbnail size cannot exceed 2MB.',

      // main
      'main.required' => 'Main image is required.',
      'main.image'    => 'Main image must be a valid image file.',
      'main.max'      => 'Main image size cannot exceed 2MB.',

      // Basic info
      'name.required' => 'Teacher name is required.',
      'name.max'      => 'Teacher name cannot be more than 255 characters.',

      'qualifications.required' => 'Qualifications is required.',
      'qualifications.max' => 'Qualifications cannot exceed 255 characters.',

      // Languages
      'languages.required'    => 'Speaking Languages is required.',
      'languages.array'    => 'Speaking Languages must be an array.',
      'languages.*.string' => 'Each language must be a valid string.',

      // Price & Experience
      'price_per_hour.required' => 'Price per hour is required.',
      'price_per_hour.numeric'  => 'Price per hour must be a number.',

      'experience.required' => 'Experience is required.',
      'experience.integer'  => 'Experience must be a whole number.',

      // Commission
      'commission_percentage.integer' => 'Commission percentage must be a number.',
      'commission_percentage.max'     => 'Commission percentage cannot exceed 100%.',

      // Demo Link
      'demo_link.url'  => 'Demo link must be a valid URL.',
      'demo_link.max'  => 'Demo link cannot exceed 1000 characters.',

      // Certificates
      'certificates.*.file'  => 'Each certificate must be a valid file.',
      'certificates.*.mimes' => 'Certificates must be JPG, JPEG, PNG, or PDF.',
      'certificates.*.max'   => 'Certificate file cannot exceed 5MB.',

      // Subjects
      'subjects.required' => 'Subjects is required.',
      'subjects.array' => 'Subjects must be an array.',
      'subjects.*.integer' => 'Invalid subject selected.',
      'subjects.*.exists'  => 'Selected subject does not exist.',

      // Time slots
      'time_slots.json' => 'Time slots must be a valid JSON string.',

      // Rates
      'rates.array' => 'Rates must be an array.',
      'rates.*.rate_below_10.numeric' => 'Rate (Below 10) must be a number.',
      'rates.*.rate_10_30.numeric'    => 'Rate (10–30) must be a number.',
      'rates.*.rate_30_plus.numeric'  => 'Rate (30+) must be a number.',
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
