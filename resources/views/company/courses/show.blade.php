@extends('layouts.layout')

@push('styles')
    <style>
        .form-container {
            margin: 0 auto;
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 24px;
        }
    </style>
@endpush

@section('nav-options')
    <nav>
        <!-- breadcrumb -->
        <ol class="flex flex-wrap pt-1 mr-12 bg-transparent rounded-lg sm:mr-16">
            <li class="text-neutral-900 text-sm">
                <a class="text-white " href="javascript:;">Home</a>
            </li>
            <li
                class="ltext-sm pl-2 capitalize text-neutral-900 text-white before:float-left before:pr-2 before:text-white before:content-['/']">
                <a class="text-white" href="{{ route('admin.dashboard') }}">Dashboard</a>
            </li>
            <li class="text-sm pl-2  font-bold capitalize  text-white before:float-left before:pr-2 before:text-white before:content-['/']"
                aria-current="page">Course Overview</li>
        </ol>
        <h6 class="mb-0 font-bold text-white capitalize">Course Overview</h6>
    </nav>
@endsection

@section('content')
    <!-- cards -->
    <div class="w-full px-6 py-6 mx-auto">
        <div class="flex flex-wrap -mx-3 mt-4">
            <div class="flex-none w-full max-w-full px-3">
                <div
                    class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                    <div class="p-3 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                        <div class="flex justify-between items-center">
                            <div
                                class="w-full max-w-full px-3  item-center flex gap-3 items-center">
                                <h6 class="dark:text-white">Course Overview : {{ $course->title ?? '—' }}</h6>
                                <a href="{{ route('admin.courses.edit', $course->course_identity) }}"
                                    class="px-4 py-2 bg-gradient-to-tl from-emerald-500 to-teal-400  text-white rounded text-xxs">
                                    <i class="bi bi-pencil me-2"></i>
                                    Edit</a>
                            </div>

                            <div class="w-full text-right max-w-full px-3  ">
                                <a href="{{ route('admin.courses.schedule-class.index', $course->course_identity) }}"
                                    class="px-4 py-2 bg-gradient-to-tl from-emerald-500 to-teal-400  text-white rounded text-sm">
                                    <i class="bi bi-calendar-date-fill me-2"></i> Scheduled Class's</a>
                                <a href="{{ route('admin.courses.materials.index', $course->course_identity) }}"
                                    class="px-4 py-2 bg-gradient-to-tl from-emerald-500 to-teal-400  text-white rounded text-sm">
                                    <i class="bi bi-files me-2"></i> Materials</a>

                                <a href="{{ route('admin.courses.index') }}"
                                    class="px-4 py-2 bg-gradient-to-tl from-emerald-500 to-teal-400  text-white rounded text-sm">
                                    <i class="bi bi-arrow-left me-2"></i>
                                    Back</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex-auto px-0 pt-0 pb-2 min-h-75">
                    <div class="p-4 overflow-x-auto form-container">
                        {{-- ////// --}}
                        {{-- Section 1: Basic Details --}}
                        <div class="mx-3">
                            <h2 class="text-xl font-semibold text-indigo-600 mb-4 flex items-center gap-2">
                                <i class="ri-book-2-line text-indigo-500 text-2xl"></i> Basic Information
                            </h2>
                            <div class="grid gap-6 mb-6 md:grid-cols-2 mt-5">
                                <!-- Images -->
                                <div class="flex justify-center flex-col">
                                    <label for="imgSelect" class="mb-2">Thumbnail</label>
                                    <p>
                                        <img id="imgPreview" alt="#"
                                            src="{{ old('thumbnail', $course->thumbnail_url ?? asset('assets/images/bg/dummy_image.webp')) }}"
                                            class="rounded w-1/2 border ">
                                    </p>
                                </div>
                                <div>
                                    <label for="imgSelect" class="mb-2">Main Image</label>
                                    <p>
                                        <img id="imgPreview" alt="#"
                                            src="{{ old('main_image', $course->main_image_url ?? asset('assets/images/bg/dummy_image.webp')) }}"
                                            class="rounded border w-1/2">
                                    </p>
                                </div>
                            </div>

                            <div class="grid md:grid-cols-2 gap-2 text-sm">
                                <div>
                                    <p class="text-gray-500">Title</p>
                                    <p class="font-medium text-gray-900">{{ $course->title ?? '—' }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Description</p>
                                    <p class="font-medium text-gray-900">{{ $course->description ?? '—' }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Total Days</p>
                                    <p class="font-medium text-gray-900">{{ $course->duration ?? '—' }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Total Hours</p>
                                    <p class="font-medium text-gray-900">{{ $course->total_hours ?? '—' }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Started at</p>
                                    <p class="font-medium text-gray-900">{{ $course->started_at ?? '—' }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Ended at</p>
                                    <p class="font-medium text-gray-900">{{ $course->ended_at ?? '—' }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Categories</p>
                                    <p class="font-medium text-gray-900">
                                        {{ implode(',', $course->categories->pluck('title')->toArray()) ?? '—' }}</p>
                                </div>


                            </div>
                        </div>

                        <hr class="border-gray-200">

                        {{-- Section 2: Pricing --}}
                        <div>
                            <h2 class="text-xl font-semibold text-green-600 mb-4 flex items-center gap-2">
                                <i class="ri-currency-line text-green-500 text-2xl"></i> Pricing Details
                            </h2>

                            <div class="grid md:grid-cols-2 gap-2 text-sm">
                                <div>
                                    <p class="text-gray-500">Actual Price</p>
                                    <p class="font-medium text-gray-900">₹{{ number_format($course->actual_price, 2) }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Discount Type</p>
                                    <p class="font-medium text-gray-900">
                                        {{ ucfirst($course->discount_type ?? 'None') }}</p>
                                </div>
                                @if ($course->discount_amount)
                                    <div>
                                        <p class="text-gray-500">Discount Amount</p>
                                        <p class="font-medium text-gray-900">
                                            @if ($course->discount_type === 'percentage')
                                                {{ $course->discount_amount }}%
                                                {{-- tax_percentage --}}
                                            @else
                                                ₹{{ number_format($course->discount_amount, 2) }}
                                            @endif
                                        </p>
                                    </div>
                                @endif

                                <div>
                                    <p class="text-gray-500">Discount Validity : <span
                                            class="font-medium text-gray-900 text-green-700">{{ $course->discount_validity }}</span>
                                    </p>
                                    @if ($course->discount_validity != 'unlimited')
                                        <p class="text-gray-500">Discount Validity End :
                                            {{ $course->discount_validity_end }}</p>
                                    @endif
                                </div>

                                {{-- discount_price --}}
                                <div>
                                    <p class="text-gray-500">Net Price</p>
                                    <p class="font-medium text-gray-900 text-green-700">
                                        ₹{{ number_format($course->net_price, 2) }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Gross Price</p>
                                    <p class="font-medium text-gray-900 text-green-700">
                                        ₹{{ number_format($course->gross_price, 2) }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Tax Included</p>
                                    <p class="font-medium text-gray-900">{{ $course->is_tax == 1 ? 'Yes' : 'No' }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Coupon Available</p>
                                    <p class="font-medium text-gray-900">
                                        {{ $course->coupon_available == 1 ? 'Yes' : 'No' }}</p>
                                </div>

                            </div>
                        </div>

                        <hr class="border-gray-200">

                        {{-- Section 3: Advanced Settings --}}
                        <div>
                            <h2 class="text-xl font-semibold text-blue-600  flex items-center gap-2">
                                <i class="ri-settings-3-line text-blue-500 text-2xl"></i> Advanced Settings
                            </h2>

                            <div class="grid md:grid-cols-2 gap-2 text-sm">
                                <div>
                                    <p class="text-gray-500">Video Type</p>
                                    <p class="font-medium text-gray-900">{{ ucfirst($course->video_type ?? '—') }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Streaming Type</p>
                                    <p class="font-medium text-gray-900">{{ ucfirst($course->streaming_type ?? '—') }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Has Material</p>
                                    <p class="font-medium text-gray-900">{{ $course->has_material ? 'Yes' : 'No' }}</p>
                                </div>
                                @if ($course->has_material)
                                    <div>
                                        <p class="text-gray-500">Material Download</p>
                                        <p class="font-medium text-gray-900">
                                            {{ $course->has_material_download ? 'Allowed' : 'Not Allowed' }}</p>
                                    </div>
                                @endif
                                <div>
                                    <p class="text-gray-500">Has Exam</p>
                                    <p class="font-medium text-gray-900">{{ $course->has_exam ? 'Yes' : 'No' }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Career Guidance</p>
                                    <p class="font-medium text-gray-900">
                                        {{ $course->is_career_guidance ? 'Yes' : 'No' }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Counselling</p>
                                    <p class="font-medium text-gray-900">{{ $course->is_counselling ? 'Yes' : 'No' }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Course Type</p>
                                    <p class="font-medium text-gray-900">{{ ucfirst($course->type ?? '—') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
