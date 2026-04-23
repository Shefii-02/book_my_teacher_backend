<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;

class BannerResource extends JsonResource
{
    public function toArray($request)
    {
        $userBooking = $this->whenLoaded('requestBanner');

        return [
            'id'             => (int)$this->id,
            'title'          => $this->title,
            'description'    => $this->description,

            'main_image'     => $this->main_id
                                ? $this->main_image_url
                                : null,

            'thumb'          => $this->thumb_id
                                ? $this->thumbnail_url
                                : null,

            'priority_order' => $this->priority_order,
            'banner_type'    => $this->banner_type,

            'cta_label'      => $this->cta_label,
            'cta_action'     => $this->cta_action,

            'type'           => $this->type,

            // booking request
            'is_booked'      => !empty($userBooking),
            'last_booked_at' => $userBooking->created_at ?? null,

            // enrollment / registration flags
            'is_enrolled'    => (bool) ($this->is_enrolled ?? false),

            'is_registered'  => $this->resolveRegistrationStatus(),

            // optional button text for app
            'action_status'  => $this->resolveActionStatus(),

            // section details
            'type_details'   => $this->getTypeDetails(),
        ];
    }


    protected function resolveRegistrationStatus()
    {
        switch ($this->type) {

            case 'course':
                return (bool) ($this->is_course_registered ?? false);

            case 'webinar':
                return (bool) ($this->is_webinar_registered ?? false);

            case 'workshop':
                return (bool) ($this->is_workshop_registered ?? false);

            default:
                return false;
        }
    }


    protected function resolveActionStatus()
    {
        if ($this->is_enrolled) {
            return 'continue_learning';
        }

        if ($this->resolveRegistrationStatus()) {
            return 'registered';
        }

        if ($this->is_booked) {
            return 'booked';
        }

        return 'apply_now';
    }


    protected function getTypeDetails()
    {
        switch ($this->type) {

            case 'course':
                return $this->course
                    ? new CourseResource($this->course)
                    : null;

            case 'workshop':
                return $this->workshop
                    ? new WorkshopResource($this->workshop)
                    : null;

            case 'webinar':
                return $this->webinar
                    ? new WebinarResource($this->webinar)
                    : null;

            default:
                return null;
        }
    }
}
