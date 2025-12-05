<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyContactResource extends JsonResource
{
  public function toArray($request)
  {
    return [
      // 'email' => $this->email,
      // 'phone' => $this->phone,
      // 'whatsapp' => $this->whatsapp,
      // 'website' => $this->website,
      // 'address' => $this->address
      "email" => "support@bookmyteacher.com",
      "phone" => "+91 98765 43210",
      "whatsapp" => "917510114455",
      "website" => "https://bookmyteacher.co.in",
      "address" => "Trivandrum, Kerala, India"
    ];
  }
}
