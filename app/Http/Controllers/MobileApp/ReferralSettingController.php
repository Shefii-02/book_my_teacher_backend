<?php
namespace App\Http\Controllers\MobileApp;

use App\Http\Controllers\Controller;
use App\Models\ReferralSetting;
use App\Http\Requests\ReferralSettingRequest;

class ReferralSettingController extends Controller
{
    public function edit()
    {
        $settings = ReferralSetting::first() ?? new ReferralSetting();

        return view('admin.referral.edit', compact('settings'));
    }

    public function update(ReferralSettingRequest $request)
    {
        $settings = ReferralSetting::first();

        if (!$settings) {
            $settings = ReferralSetting::create($request->validated());
        } else {
            $settings->update($request->validated());
        }

        return back()->with('success', 'Referral settings updated successfully.');
    }
}
