<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Helpers\MediaHelper;
use App\Models\Teacher;
use App\Models\TopTeacher;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\MediaFile;
use App\Models\SubjectCourse;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CompanyController extends Controller
{

  public function index(Request $request)
  {

    $companies = Company::with('user')->paginate(10);
    return view('super_admin.companies.index', compact('companies'));
  }


  public function create()
  {
    return view('super_admin.companies.form');
  }

  public function store(Request $request)
  {
    DB::beginTransaction();

    $title = $request->title;
    $email = $request->email;
    $phone = $request->phone;
    $whatsapp = $request->whatsapp;
    $webiste = $request->website;
    $address_1 = $request->address_1;
    $address_2 = $request->address_2;
    $city = $request->city;
    $state = $request->state;
    $country = $request->country;
    $pincode = $request->pincode;
    $description = $request->description;
    $personal_name = $request->name;
    $personal_email = $request->personal_email;
    $personal_mobile = $request->personal_mobile;
    $password = $request->password;

    $black_logo = $request->black_logo;
    $white_logo = $request->white_logo;
    $avatar_logo = $request->avatar_logo;

    try {
      $user = new User();
      $user->name  = $personal_name;
      $user->mobile = $personal_mobile;
      $user->acc_type = 'company';
      $user->registration_source = 'web';
      $user->email     = $personal_email;
      $user->password  = Hash::make($password);
      $user->account_status = 'approved';
      $user->status     = $request->has('status') ? 1 : 0;
      $user->save();

      $company            = new Company();
      $company->name      = $title;
      $company->email     = $email;

      $company->user_id   = $user->id;
      $company->status    = 1;

      $company->slug      = $company->prefix ?? 'BMT';

      $company->phone     = $phone;
      $company->whatsapp  = $whatsapp;
      $company->website    = $webiste;
      $company->address_line1   = $address_1;
      $company->address_line2   = $address_2;
      $company->city      = $city;
      $company->state     = $state;
      $company->country   = $country;
      $company->pincode   = $pincode;
      $company->timezone  = 'Asia/Kolkata';
      $company->date_format = 'd-M-Y';
      $company->currency  = 'INR';
      $company->plan_id   = 1;
      $company->is_active = 1;
      $company->save();



      $userID = $user->id;


      $favLogoPath = null;
      if ($request->hasFile('fav_logo')) {
        $favLogoPath = MediaHelper::uploadCompanyFile(
          $company->id,
          'company',
          $request->file('fav_logo'),
          'fav_logo',
          $userID
        );

        $company->favicon = $favLogoPath;
      }

      $blackLogoPath = null;
      if ($request->hasFile('black_logo')) {
        $blackLogoPath = MediaHelper::uploadCompanyFile(
          $company->id,
          'company',
          $request->file('black_logo'),
          'black_logo',
          $userID
        );

        $company->black_logo = $blackLogoPath;
      }

      $whiteLogoPath = null;
      if ($request->hasFile('white_logo')) {
        $whiteLogoPath = MediaHelper::uploadCompanyFile(
          $company->id,
          'company',
          $request->file('white_logo'),
          'white_logo',
          $userID
        );

        $company->white_logo = $whiteLogoPath;
      }



      $avatarPath = null;
      if ($request->hasFile('avatar_logo')) {
        $avatarPath = MediaHelper::uploadCompanyFile(
          $company->id,
          'avatars',
          $request->file('avatar_logo'),
          'avatar',
          $userID
        );
      }

      $company->save();
      $user->company_id = $company->id;
      $user->save();

      DB::commit();
      return redirect()->route('admin.companies.index')->with('success', 'Successfully Completed');
    } catch (Exception $e) {
      DB::rollBack();
      return redirect()->back()->with('error', $e->getMessage());
    }
  }


  public function edit($id)
  {
    $company = Company::with('user')->where('id', $id)->first() ?? abort(404);

    return view('super_admin.companies.form', compact('company'));
  }



  public function update(Request $request, $id)
  {

    DB::beginTransaction();

    $title = $request->title;
    $email = $request->email;
    $phone = $request->phone;
    $whatsapp = $request->whatsapp;
    $webiste = $request->website;
    $address_1 = $request->address_1;
    $address_2 = $request->address_2;
    $city = $request->city;
    $state = $request->state;
    $country = $request->country;
    $pincode = $request->pincode;
    $description = $request->description;
    $personal_name = $request->name;
    $personal_email = $request->personal_email;
    $personal_mobile = $request->personal_mobile;
    $password = $request->password;


    try {
      $user = User::where('id', $id)->first();
      $user->name  = $personal_name;
      $user->mobile = $personal_mobile;
      $user->acc_type = 'company';
      $user->registration_source = 'web';
      $user->email     = $personal_email;

      $user->account_status = 'approved';
      $user->status     = $request->has('status') ? 1 : 0;
      $user->save();

      if (Str::length($password) > 0) {
        $user->password  = Str::length($password) > 0  ? Hash::make($password) : '';
        $user->save();
      }

      $company            = Company::where('id', $id)->first();

      $black_logo = $company->black_logo;
      $white_logo = $company->white_logo;
      $avatar_logo = $company->user->avatar_url;
      $favicon_logo = $company->favicon;

      $company->name      = $title;
      $company->email     = $email;
      $company->user_id   = $user->id;
      $company->status    = $request->has('status') ? 1 : 0;
      $company->slug      = $company->prefix ?? 'BMT';
      $company->phone     = $phone;
      $company->whatsapp  = $whatsapp;
      $company->website    = $webiste;
      $company->address_line1   = $address_1;
      $company->address_line2   = $address_2;
      $company->city      = $city;
      $company->state     = $state;
      $company->country   = $country;
      $company->pincode   = $pincode;
      $company->timezone  = 'Asia/Kolkata';
      $company->date_format = 'd-M-Y';
      $company->currency  = 'INR';
      $company->plan_id   = 1;
      $company->is_active = $request->has('status') ? 1 : 0;
      $company->save();

      $userID = $user->id;


      $favLogoPath = null;
      if ($request->hasFile('fav_logo')) {

        if ($favicon_logo && Storage::disk('public')->exists($company->favicon_url))
          MediaHelper::removeCompanyFile($favicon_logo);

        $favLogoPath = MediaHelper::uploadCompanyFile(
          $company->id,
          'company',
          $request->file('fav_logo'),
          'fav_logo',
          $userID
        );

        $company->favicon = $favLogoPath;
      }

      $blackLogoPath = null;
      if ($request->hasFile('black_logo')) {
        if ($black_logo && Storage::disk('public')->exists($company->black_logo_url))
          MediaHelper::removeCompanyFile($black_logo);

        $blackLogoPath = MediaHelper::uploadCompanyFile(
          $company->id,
          'company',
          $request->file('black_logo'),
          'black_logo',
          $userID
        );

        $company->black_logo = $blackLogoPath;
      }

      $whiteLogoPath = null;
      if ($request->hasFile('white_logo')) {
        if ($white_logo && Storage::disk('public')->exists($company->white_logo_url))
          MediaHelper::removeCompanyFile($white_logo);

        $whiteLogoPath = MediaHelper::uploadCompanyFile(
          $company->id,
          'company',
          $request->file('white_logo'),
          'white_logo',
          $userID
        );

        $company->white_logo = $whiteLogoPath;
      }



      $avatarPath = null;
      // if ($request->hasFile('avatar_logo')) {
      //     MediaFile::where('company_id', $company->id)->where('user_id', $user->id)->where('file_type', 'avatar')->delete();

      //   if ($avatar_logo && Storage::disk('public')->exists($company->user->avatar_url)) {

      //     MediaHelper::removeCompanyFile($avatar_logo);
      //   }

      //   $avatarPath = MediaHelper::uploadCompanyFile(
      //     $company->id,
      //     'avatars',
      //     $request->file('avatar_logo'),
      //     'avatar',
      //     $userID
      //   );

      // }

      if ($request->hasFile('avatar_logo')) {

        MediaFile::where('company_id', $company->id)
          ->where('user_id', $user->id)
          ->where('file_type', 'avatar')
          ->delete();

        if ($avatar_logo && Storage::disk('public')->exists($company->user->avatar_url)) {
          MediaHelper::removeCompanyFile($avatar_logo);
        }

        $avatarPath = MediaHelper::uploadCompanyFile(
          $company->id,
          'avatars',
          $request->file('avatar_logo'),
          'avatar',
          $userID
        );
      }
      $company->save();
      $user->save();
      DB::commit();
      return redirect()->route('admin.companies.index')->with('success', 'Successfully Completed');
    } catch (Exception $e) {
      DB::rollBack();
      return redirect()->back()->with('error', $e->getMessage());
    }
  }
}
