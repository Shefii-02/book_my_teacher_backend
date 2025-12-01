<?php

namespace App\Http\Controllers\MobileApp;

use App\Helpers\MediaHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\TopBanner\StoreTopBannerRequest;
use App\Http\Requests\TopBanner\UpdateTopBannerRequest;
use App\Models\TopBanner;
use Illuminate\Support\Facades\Storage;


class BannerController extends Controller
{
  public function index()
  {

    $company_id = 1;
    $banners = TopBanner::where('banner_type','top-banner')->where('company_id',$company_id)->orderBy('priority')->get();
    return view('company.mobile-app.top_banner.index', compact('banners'));
  }

  public function create()
  {
    return view('company.mobile-app.top_banner.form');
  }

  public function store(StoreTopBannerRequest $request)
  {
    $data = $request->validated();

    $company_id = 1;
    $data['company_id']  =  $company_id;

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

    return redirect()->route('admin.app.top-banners.index')
      ->with('success', 'Banner created successfully!');
  }

  public function edit(TopBanner $top_banner)
  {
    return view('company.mobile-app.top_banner.form', ['banner' => $top_banner]);
  }

  public function update(UpdateTopBannerRequest $request, TopBanner $top_banner)
  {
    $data = $request->validated();

    $company_id = 1;

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

    $top_banner->update($data);

    return redirect()->route('admin.app.top-banners.index')
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
