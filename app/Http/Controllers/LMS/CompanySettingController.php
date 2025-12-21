<?php

namespace App\Http\Controllers\LMS;

use App\Models\CompanyGeneralSetting;
use App\Models\CompanyBranding;
use App\Models\CompanySocialLink;
use App\Models\CompanyPaymentSetting;
use App\Models\CompanySecuritySetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\CompanyContact;
use App\Models\SocialLink;

class CompanySettingController extends Controller
{
  public function index()
  {
    $companyId = auth()->user()->company_id;

    return view('company.settings.index', [
      'general'     => CompanyContact::where('company_id', $companyId)->first(),
      'company'    => Company::where('id', $companyId)->first(),
      'branding'    => CompanyBranding::where('company_id', $companyId)->first(),
      'socialLinks' => SocialLink::where('company_id', $companyId)->get(),
      'payment'     => CompanyPaymentSetting::where('company_id', $companyId)->first(),
      'security'    => CompanySecuritySetting::where('company_id', $companyId)->first(),
    ]);
  }

  public function updateGeneral(Request $request)
  {
    // $companyId = app('company_id');
    $companyId = auth()->user()->company_id;
    CompanyContact::updateOrCreate(
      ['company_id' => $companyId],
      $request->only(['email', 'phone', 'website', 'whatsapp', 'address'])
    );

    return back()->with('success', 'General settings updated');
  }

  public function updateBranding(Request $request)
  {
    // $companyId = app('company_id');
    $companyId = auth()->user()->company_id;
    $branding = Company::firstOrNew(['id' => $companyId]);


      if ($request->hasFile('black_logo')) {
        $file = $request->file('black_logo');
        $filename = time() . "-" . $file->getClientOriginalName();
        $file->move(public_path('uploads/branding'), $filename);
        $branding->black_logo = '/uploads/branding/'.$filename;
      }



      if ($request->hasFile('white_logo')) {
        $file = $request->file('white_logo');
        $filename = time() . "-" . $file->getClientOriginalName();
        $file->move(public_path('uploads/branding'), $filename);
        $branding->white_logo = '/uploads/branding/'.$filename;
      }



      if ($request->hasFile('favicon')) {
        $file = $request->file('favicon');
        $filename = time() . "-" . $file->getClientOriginalName();
        $file->move(public_path('uploads/branding'), $filename);
        $branding->favicon = '/uploads/branding/'.$filename;
      }


    $branding->save();

    $theme = CompanyBranding::firstOrNew(['company_id' => $companyId]);

    $theme->theme_color = $request->theme_color;
    $theme->save();

    return back()->with('success', 'Branding updated');
  }

  public function updateSocial(Request $request)
  {
    $companyId =  auth()->user()->company_id;

    $request->validate([
      'links.*.name'        => 'required|string|max:100',
      'links.*.link'        => 'nullable|url',
      'links.*.sort_order'  => 'required|integer',
      'links.*.icon'        => 'nullable|image|mimes:png,jpg,svg,jpeg|max:2048',
    ]);

    foreach ($request->links as $id => $data) {

      // If ID = 0 → new row
      if ($id == 0) {
        $social = new SocialLink();
        $social->company_id = $companyId;
      } else {
        $social = SocialLink::where('id', $id)->where('company_id', $companyId)->first();
      }

      $social->name = $data['name'];
      $social->link = $data['link'] ?? null;
      $social->sort_order = $data['sort_order'];

      if (isset($data['icon'])) {
        $file = $data['icon'];
        $filename = time() . "-" . $file->getClientOriginalName();
        $file->move(public_path('uploads/social_icons'), $filename);

        $social->icon = '/uploads/social_icons/'.$filename;
      }

      $social->save();
    }

    return back()->with('success', 'Social links updated successfully');
  }


  public function deleteSocial($id)
{
    $link = SocialLink::findOrFail($id);
    $link->delete();

    return back()->with('success', 'Social link deleted');
}


  public function updatePayment(Request $request)
  {
    // $companyId = app('company_id');
    $companyId = auth()->user()->company_id;
    CompanyPaymentSetting::updateOrCreate(
      ['company_id' => $companyId],
      $request->only(['merchant_id', 'salt_key', 'salt_index'])
    );

    return back()->with('success', 'Payment settings updated');
  }

  public function updateSecurity(Request $request)
  {
    // $companyId = app('company_id');
    $companyId = auth()->user()->company_id;
    CompanySecuritySetting::updateOrCreate(
      ['company_id' => $companyId],
      [
        'two_factor_enabled' => $request->has('two_factor_enabled'),
        'maintenance_mode'   => $request->has('maintenance_mode'),
      ]
    );

    return back()->with('success', 'Security settings updated');
  }
}
