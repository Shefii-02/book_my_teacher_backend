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
      'main_image'     => asset($this->main_image),
      'thumb'          => asset($this->thumb),
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
        return $this->course ? [
          'id'       => $this->course->id,
          'title'    => $this->course->title,
          'duration' => $this->course->duration,
          'price'    => $this->course->price,
        ] : null;

      case 'workshop':
        return $this->workshop ? [
          'id'    => $this->workshop->id,
          'title' => $this->workshop->title,
          'date'  => $this->workshop->date,
          'time'  => $this->workshop->time,
        ] : null;

      case 'webinar':
        return $this->webinar ? [
          'id'    => $this->webinar->id,
          'title' => $this->webinar->title,
          'date'  => $this->webinar->date,
          'link'  => $this->webinar->meeting_link,
        ] : null;

      default:
        return null;
    }
  }
}
