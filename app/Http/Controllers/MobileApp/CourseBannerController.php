<?php

namespace App\Http\Controllers\MobileApp;

use App\Helpers\MediaHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\TopBanner\StoreTopBannerRequest;
use App\Http\Requests\TopBanner\UpdateTopBannerRequest;
use App\Models\TopBanner;

class CourseBannerController extends Controller
{
  public function index()
  {
    $company_id= auth()->user()->company_id;
    $banners = TopBanner::where('banner_type','course-banner')->where('company_id',$company_id)->orderBy('priority')->get();
    return view('company.mobile-app.course_banner.index', compact('banners'));
  }

  public function create()
  {
    return view('company.mobile-app.course_banner.form');
  }

  public function store(StoreTopBannerRequest $request)
  {
    $data = $request->validated();

    $company_id = auth()->user()->company_id;
    $data['company_id']  =  $company_id;
    $data['banner_type']  = 'course-banner';

    // Upload Thumbnail
    $thumbnailPath = null;
    if ($request->hasFile('thumb_id')) {
      $thumbnailPath = MediaHelper::uploadCompanyFile(
        $company_id,
        'course-banners/thumbnails',
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
        'course-banners/main_images',
        $request->file('main_id'),
        'courses'
      );
      $data['main_id'] = $mainImagePath;
    }


    TopBanner::create($data);

    return redirect()->route('company.app.course-banners.index')
      ->with('success', 'Banner created successfully!');
  }

  public function edit(TopBanner $course_banner)
  {
    return view('company.mobile-app.course_banner.form', ['banner' => $course_banner]);
  }

  public function update(UpdateTopBannerRequest $request, TopBanner $course_banner)
  {
    $data = $request->validated();

    $company_id = auth()->user()->company_id;

    // Upload Thumbnail
    if ($request->hasFile('thumb_id')) {
      MediaHelper::removeCompanyFile($course_banner->thumb_id);
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
      MediaHelper::removeCompanyFile($course_banner->main_id);
      $mainImagePath = MediaHelper::uploadCompanyFile(
        $company_id,
        'top-banners/main_images',
        $request->file('main_id'),
        'courses'
      );
      $data['main_id'] = $mainImagePath;
    }

    $course_banner->update($data);

    return redirect()->route('company.app.course-banners.index')
      ->with('success', 'Banner updated successfully!');
  }

  public function destroy(TopBanner $course_banner)
  {
    MediaHelper::removeCompanyFile($course_banner->thumb_id);
    MediaHelper::removeCompanyFile($course_banner->main_id);

    $course_banner->delete();

    return back()->with('success', 'Banner deleted successfully!');
  }
}
