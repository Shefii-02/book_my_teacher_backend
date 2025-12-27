<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;

class BannerResource extends JsonResource
{
  public function toArray($request)
  {
    // user id from controller
    $user_id = $request->user_id;

    // check booking
    $userBooking = $this->whenLoaded('requestBanner');

    // return [
    //     'id' => (int) $this->id,
    //     'title' => $this->title,
    //     'description' => $this->description,

    //     // images
    //     'main_image' => $this->main_id ? $this->main_image_url : null,
    //     'thumb'      => $this->thumb_id ? $this->thumbnail_url : null,

    //     // priority & type
    //     'priority_order' => (int) $this->priority,
    //     'banner_type'    => $this->banner_type,

    //     // CTA
    //     'cta_label'  => $this->ct_label,
    //     'cta_action' => $this->ct_action,

    //     // user booking check
    //     'is_booked' => $userBooking ? true : false,

    //     // last booked datetime
    //     'last_booked_at' => $userBooking->created_at ?? null,
    // ];

    return [
      'id'             => $this->id,
      'title'          => $this->title,
      'description'    => $this->description,
      'main_image' => $this->main_id ? $this->main_image_url : null,
      'thumb'      => $this->thumb_id ? $this->thumbnail_url : null,
      'priority_order' => $this->priority_order,
      'banner_type'    => $this->banner_type,
      'cta_label'      => $this->cta_label,
      'cta_action'     => $this->cta_action,

      // Booking info
      'is_booked'      => $userBooking ? true : false,
      'last_booked_at' => $userBooking->created_at ?? null,

      // Type info
      'type'           => $this->type,

      // 🔥 Type-based details
      'type_details'   => $this->getTypeDetails(),
    ];
  }

  protected function getTypeDetails()
  {
    switch ($this->type) {

      case 'course':
        return  $this->course ? new CourseResource($this->course)  : null;

      case 'workshop':
        return $this->workshop ? new WorkshopResource($this->workshop) : null;

      case 'webinar':
        return $this->webinar ? new WebinarResource($this->webinar) : null;

      default:
        return null;
    }
  }
}
