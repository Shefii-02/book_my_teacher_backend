<?php
namespace App\Http\Controllers;

use App\Models\SocialLink;
use App\Models\CompanyContact;
use Illuminate\Http\Request;

class CompanySettingController extends Controller
{
    public function index($company_id)
    {
        return response()->json([
            'status' => true,
            'socials' => SocialLink::where('company_id', $company_id)->get(),
            'contact' => CompanyContact::where('company_id', $company_id)->first(),
        ]);
    }

    public function storeSocial(Request $request)
    {
        $data = $request->validate([
            'company_id' => 'required|integer',
            'name' => 'required|string',
            'icon' => 'nullable|image',
            'link' => 'required|string',
            'type' => 'nullable|string',
        ]);

        // icon upload
        if ($request->hasFile('icon')) {
            $data['icon'] = $request->file('icon')->store('social-icons');
        }

        SocialLink::create($data);

        return response()->json(['status' => true, 'message' => 'Social link added']);
    }

    public function updateContact(Request $request)
    {
        $data = $request->validate([
            'company_id' => 'required|integer',
            'email' => 'nullable|string',
            'phone' => 'nullable|string',
            'whatsapp' => 'nullable|string',
            'website' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        CompanyContact::updateOrCreate(
            ['company_id' => $request->company_id],
            $data
        );

        return response()->json(['status' => true, 'message' => 'Contact updated']);
    }


    ///////////////////////////////////////


    public function edit($company_id)
    {
        $contact = CompanyContact::firstOrCreate(['company_id' => $company_id]);

        return view('admin.company-contact.edit', compact('contact'));
    }

    public function update(Request $request, $company_id)
    {
        $data = $request->validate([
            'email' => 'nullable',
            'phone' => 'nullable',
            'whatsapp' => 'nullable',
            'website' => 'nullable',
            'address' => 'nullable',
        ]);

        CompanyContact::updateOrCreate(
            ['company_id' => $company_id],
            $data
        );

        return redirect()->back()->with('success', 'Contact details updated!');
    }
}
