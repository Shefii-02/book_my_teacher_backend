<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WalletRequest extends FormRequest
{
  public function authorize(): bool
  {
    return true;
  }

  public function rules(): array
  {
    return [
      'user_id' => 'required|exists:users,id',
      'action' => 'required|in:credit,debit,credit',
      'title' => 'required|string|max:255',
      'amount' => 'required|integer|min:1',
      'note' => 'nullable|string',
    ];
  }
}
