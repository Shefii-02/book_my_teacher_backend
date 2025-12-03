<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WalletHistoryResource extends JsonResource
{

  public function toArray($request)
  {
    return [
      'id'        => $this->id,
      'title'     => $this->title,
      'type'      => $this->type,
      'amount'    => $this->amount,
      'status'    => $this->status,
      'date'      => $this->date,
      'notes'     => $this->notes,
    ];
  }
}
