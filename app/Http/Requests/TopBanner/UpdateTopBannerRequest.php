<?php

namespace App\Http\Requests\TopBanner;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTopBannerRequest extends FormRequest
{
  public function authorize(): bool
  {
    return true;
  }


  public function rules(): array
  {
    // return [
    //   'thumb_id'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    //   'main_id'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    //   'title'       => 'required|string|max:255',
    //   'description' => 'nullable|string',
    //   'priority'    => 'required|integer|min:1',
    //   'ct_label'    => 'required|string|max:150',
    //   'ct_action'   => 'required|string|max:255',
    //   'status'      => 'nullable|boolean',
    // ];
     return [
      'type' => 'required|in:course,workshop,webinar,other',

      'course_id'   => 'required_if:type,course',
      'workshop_id' => 'required_if:type,workshop',
      'webinar_id'  => 'required_if:type,webinar',

      'thumb_id' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
      'main_id'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

      'title'       => 'exclude_unless:type,other|required|string|max:255',
      'description' => 'exclude_unless:type,other|required|string',

      'ct_label'  => 'exclude_unless:type,other|required|string|max:150',
      'ct_action' => 'exclude_unless:type,other|required|string|max:255',

      'priority' => 'required|integer|min:1',
      'status'   => 'nullable|boolean',
    ];
  }

  public function messages(): array
  {
    return [

      'thumb_id.required'    => 'A thumbnail image is required.',
      'thumb_id.image'       => 'The thumbnail must be a valid image.',
      'thumb_id.mimes'       => 'The thumbnail must be a file of type: jpg, jpeg, png, webp.',
      'thumb_id.max'         => 'The thumbnail image may not be larger than 2MB.',

      'main_id.required'     => 'A main banner image is required.',
      'main_id.image'        => 'The main banner must be a valid image.',
      'main_id.mimes'        => 'The main banner must be a file of type: jpg, jpeg, png, webp.',
      'main_id.max'          => 'The main banner image may not be larger than 2MB.',

      'title.required'       => 'The banner title is required.',
      'title.string'         => 'The banner title must be a valid string.',
      'title.max'            => 'The banner title may not be greater than 255 characters.',

      'description.string'   => 'The description must be a valid string.',

      'priority.required'    => 'The banner priority is required.',
      'priority.integer'     => 'The priority value must be a number.',
      'priority.min'         => 'The priority must be at least 1.',

      'banner_type.required' => 'Please select a banner type.',
      'banner_type.string'   => 'Invalid banner type format.',
      'banner_type.max'      => 'The banner type may not exceed 100 characters.',

      'ct_label.required'    => 'The call-to-label  is required.',
      'ct_label.string'      => 'The call-to-action label must be a valid string.',
      'ct_label.max'         => 'The CTA label may not exceed 150 characters.',

      'ct_action.required'    => 'The call-to-action is required.',
      'ct_action.string'     => 'The call-to-action link must be a valid string.',
      'ct_action.max'        => 'The CTA action may not exceed 255 characters.',

      'status.required'      => 'The status field is required.',
      'status.boolean'       => 'The status must be true or false.',
    ];
  }
}
