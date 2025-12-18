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
        return [
            'company_id' => 'required|exists:companies,id',
            'user_id'    => 'required|exists:users,id',
            'transfer_amount' => 'required|numeric|min:1',
            'transaction_source' => 'nullable|string|max:100',
            'transaction_method' => 'required|string|max:100',

            // BANK
            'transfer_to_account_no' => 'nullable|string|max:50',
            'transfer_to_ifsc_no' => 'nullable|string|max:20',
            'transfer_holder_name' => 'nullable|string|max:100',

            // UPI
            'transfer_upi_id' => 'nullable|string|max:100',
            'transfer_upi_number' => 'nullable|string|max:20',
        ];
    }
}
