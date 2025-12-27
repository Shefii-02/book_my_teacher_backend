<?php

namespace App\Http\Controllers\MobileApp;

use App\Helpers\MediaHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\TopBanner\StoreTopBannerRequest;
use App\Http\Requests\TopBanner\UpdateTopBannerRequest;
use App\Models\Course;
use App\Models\TopBanner;
use App\Models\Webinar;
use App\Models\Workshop;
use Illuminate\Support\Facades\Storage;


class BannerController extends Controller
{
  public function index()
  {

    $company_id = auth()->user()->company_id;
    $banners = TopBanner::where('banner_type', 'top-banner')->where('company_id', $company_id)->orderBy('priority')->get();
    return view('company.mobile-app.top_banner.index', compact('banners'));
  }

  public function create()
  {
    $company_id = auth()->user()->company_id;
    $courses = Course::where('company_id', $company_id)->get();
    $webinars = Webinar::where('company_id', $company_id)->get();
    $workshops = Workshop::where('company_id', $company_id)->get();
    return view('company.mobile-app.top_banner.form', compact('courses', 'webinars', 'workshops'));
  }

  public function store(StoreTopBannerRequest $request)
  {


    $data = $request->validated();
    $company_id = auth()->user()->company_id;
    $data['company_id']  =  $company_id;

    $data['title'] = $request->title ?? '';

    $data['section_id'] = match ($request->type) {
      'course'   => $request->course_id,
      'workshop' => $request->workshop_id,
      'webinar'  => $request->webinar_id,
      default    => null,
    };

    // Upload Thumbnail
    $thumbnailPath = null;
    if ($request->hasFile('thumb_id')) {
      $thumbnailPath = MediaHelper::uploadCompanyFile(
        $company_id,
        'top-banners/thumbnails',
        $request->file('thumb_id'),
        'courses'
      );
      $data['thumb_id'] = $thumbnailPath;
    }

    // Upload Main Image
    $mainImagePath = null;
    if ($request->hasFile('main_id')) {
      $mainImagePath = MediaHelper::uploadCompanyFile(
        $company_id,
        'top-banners/main_images',
        $request->file('main_id'),
        'courses'
      );
      $data['main_id'] = $mainImagePath;
    }


    TopBanner::create($data);

    return redirect()->route('company.app.top-banners.index')
      ->with('success', 'Banner created successfully!');
  }

  public function edit(TopBanner $top_banner)
  {
    $company_id = auth()->user()->company_id;
    $courses = Course::where('company_id', $company_id)->get();
    $webinars = Webinar::where('company_id', $company_id)->get();
    $workshops = Workshop::where('company_id', $company_id)->get();
    $banner = $top_banner;
    return view('company.mobile-app.top_banner.form', compact('courses', 'webinars', 'workshops', 'banner'));
  }

  public function update(UpdateTopBannerRequest $request, TopBanner $top_banner)
  {
    $data = $request->validated();

    $company_id = auth()->user()->company_id;

    // Upload Thumbnail
    if ($request->hasFile('thumb_id')) {
      MediaHelper::removeCompanyFile($top_banner->thumb_id);
      $thumbnailPath = MediaHelper::uploadCompanyFile(
        $company_id,
        'top-banners/thumbnails',
        $request->file('thumb_id'),
        'courses'
      );
      $data['thumb_id'] = $thumbnailPath;
    }

    // Upload Main Image
    if ($request->hasFile('main_id')) {
      MediaHelper::removeCompanyFile($top_banner->main_id);
      $mainImagePath = MediaHelper::uploadCompanyFile(
        $company_id,
        'top-banners/main_images',
        $request->file('main_id'),
        'courses'
      );
      $data['main_id'] = $mainImagePath;
    }

    $data['title'] = $request->title ?? '';

    $data['section_id'] = match ($request->type) {
      'course'   => $request->course_id,
      'workshop' => $request->workshop_id,
      'webinar'  => $request->webinar_id,
      default    => null,
    };

    $top_banner->update($data);

    return redirect()->route('company.app.top-banners.index')
      ->with('success', 'Banner updated successfully!');
  }

  public function destroy(TopBanner $top_banner)
  {
    MediaHelper::removeCompanyFile($top_banner->thumb_id);
    MediaHelper::removeCompanyFile($top_banner->main_id);

    $top_banner->delete();

    return back()->with('success', 'Banner deleted successfully!');
  }
}
