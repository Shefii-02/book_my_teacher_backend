<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyContactResource extends JsonResource
{
  public function toArray($request)
  {
    return [
      "email" => $this->email,
      "phone" => $this->phone,
      "whatsapp" => $this->whatsapp,
      "website" => $this->website,
      "address" => $this->address
    ];
  }
}
