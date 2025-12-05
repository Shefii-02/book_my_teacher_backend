<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SocialLinkResource extends JsonResource
{
  public function toArray($request)
  {
    return [
      'name' => $this->name,
      'icon' => asset($this->icon),
      'link' => $this->link,
      'type' => $this->type,
    ];
  }
}
