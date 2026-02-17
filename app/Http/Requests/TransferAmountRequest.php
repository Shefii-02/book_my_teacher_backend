<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransferAmountRequest extends FormRequest
{
  public function authorize(): bool
  {
    return true;
  }

  public function rules(): array
  {


    if ($this->transaction_method == 'bank') {
      // BANK
      return [
        'transfer_to_account_no' => 'required|string|max:50',
        'transfer_to_ifsc_no' => 'required|string|max:20',
        'transfer_holder_name' => 'required|string|max:100',
      ];
    } else {
      // UPI
      return [
        'transfer_upi_id' => 'required|string|max:100',
        'transfer_upi_number' => 'required|string|max:20',
      ];
    }
  }
}
