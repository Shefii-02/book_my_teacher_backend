<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
  public function toArray(Request $request): array
  {
    return [
      'id'                => $this->id,
      'title'             => $this->title,


      'thumbnail_url' => $this->thumbnail_url ?  $this->thumbnail_url : null,
      'main_image_url' => $this->main_image_url ? $this->main_image_url : null,

      'description'       => $this->description,
      'notes'             => $this->notes,
      'duration_type'     => $this->duration_type,
      'duration'          => $this->duration,
      'total_hours'       => $this->total_hours,
      'started_at'        => $this->started_at,
      'ended_at'          => $this->ended_at,

      // 💰 Pricing
      'actual_price'      => $this->actual_price,
      'discount_price'    => $this->discount_price,
      'discount_type'     => $this->discount_type,
      'discount_amount'   => $this->discount_amount,
      'net_price'         => $this->net_price,
      'gross_price'       => $this->gross_price,
      'is_tax'            => $this->is_tax,
      'tax_percentage'    => $this->tax_percentage,

      // 🎓 Course Meta
      'level'             => $this->level,
      'class_type'        => $this->class_type,
      'class_mode'        => $this->class_mode,
      'course_type'       => $this->course_type,
      'course_identity'   => $this->course_identity,
      'status'            => $this->status,

      // 📦 Features
      'has_material'              => (bool) $this->has_material,
      'has_material_download'     => (bool) $this->has_material_download,
      'has_exam'                  => (bool) $this->has_exam,
      'is_counselling'            => (bool) $this->is_counselling,
      'is_career_guidance'        => (bool) $this->is_career_guidance,
      'allow_installment'         => (bool) $this->allow_installment,

      // 🏫 Institute (Relationship)
      'institute' => $this->whenLoaded('institute', function () {
        return [
          'id'    => $this->institute->id,
          'name'  => $this->institute->name,
          'logo'  => $this->institute->logo ?? null,
        ];
      }),

      'is_enrolled' => $this->whenLoaded('registrations')->count() ? true : false,

      // 'is_enrolled' => (bool) ($this->is_enrolled ?? false),
    ];
  }
}
