<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReferralSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'reward_per_join' => 'required|integer|min:0',
            'bonus_on_first_class' => 'required|integer|min:0',
            'how_it_works' => 'nullable|string|max:255',
            'how_it_works_description' => 'nullable|string',
            'badge_title' => 'nullable|string|max:255',
            'badge_description' => 'nullable|string',
            'share_link_description' => 'nullable|string',
        ];
    }
}
