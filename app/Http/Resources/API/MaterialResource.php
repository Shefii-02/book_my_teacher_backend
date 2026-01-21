<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;

class MaterialResource extends JsonResource
{
  public function toArray($request)
  {
    return [
      'id'                => $this->id,
      'title'             => $this->title,
      'file_url'          => $this->file_url,
      'file_type'         => $this->file_type
    ];
  }
}
