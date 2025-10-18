<form action="{{ route('admin.courses.store') }}" method="POST">
    @csrf
    <div class="form-title mb-3">
        <h2 id="drawer-right-label"
            class="text-gray-400 rounded-lg text-lg text-sm absolute top-2.5  inline-flex items-center justify-center">
            <svg class="w-4 h-4 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            Overview Confirmation
        </h2>
        <p class="text-gray-500">Please review all course details carefully before final submission.</p>

    </div>
    <div class="form-body mt-3">

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
                    <p class="font-medium text-gray-900">₹{{ number_format($course->actual_price, 2) }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Discount Type</p>
                    <p class="font-medium text-gray-900">{{ ucfirst($course->discount_type ?? 'None') }}</p>
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
                        <p class="text-gray-500">Discount Validity End : {{ $course->discount_validity_end }}</p>
                    @endif
                </div>

                {{-- discount_price --}}
                <div>
                    <p class="text-gray-500">Net Price</p>
                    <p class="font-medium text-gray-900 text-green-700">₹{{ number_format($course->net_price, 2) }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Gross Price</p>
                    <p class="font-medium text-gray-900 text-green-700">₹{{ number_format($course->gross_price, 2) }}
                    </p>
                </div>
                <div>
                    <p class="text-gray-500">Tax Included</p>
                    <p class="font-medium text-gray-900">{{ $course->is_tax == 1 ? 'Yes' : 'No' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Coupon Available</p>
                    <p class="font-medium text-gray-900">{{ $course->coupon_available == 1 ? 'Yes' : 'No' }}</p>
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
                    <p class="font-medium text-gray-900">{{ ucfirst($course->streaming_type ?? '—') }}</p>
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
                    <p class="font-medium text-gray-900">{{ $course->is_career_guidance ? 'Yes' : 'No' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Counselling</p>
                    <p class="font-medium text-gray-900">{{ $course->is_counselling ? 'Yes' : 'No' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Course Type</p>
                    <p class="font-medium text-gray-900">{{ ucfirst($course->type ?? '—') }}</p>
                </div>
            </div>
        </div>


        <hr class="border-gray-200">

        <div>
            <label class="block mb-2 text-sm font-medium">Status</label>
            <div class="flex items-center gap-4">
                <label class="flex items-center gap-1">
                    <input type="radio" class="bg-gray-100 border-gray-300 focus:ring-blue-500" name="status"
                        value="draft" {{ old('status', $course->status ?? 'Draft') == 'draft' ? 'checked' : '' }}>
                    <span class="text-sm">draft</span>
                </label>
                <label class="flex items-center gap-1">
                    <input type="radio" class="bg-gray-100 border-gray-300 focus:ring-blue-500" name="status"
                        value="unpublished"
                        {{ old('status', $course->status ?? '') == 'unpublished' ? 'checked' : '' }}>
                    <span class="text-sm">Unpublished</span>
                </label>
                 <label class="flex items-center gap-1">
                    <input type="radio" class="bg-gray-100 border-gray-300 focus:ring-blue-500" name="status"
                        value="published"
                        {{ old('status', $course->status ?? '') == 'published' ? 'checked' : '' }}>
                    <span class="text-sm">Published</span>
                </label>
            </div>
        </div>
    </div>
    <!-- Submit -->
    <div class="my-2 text-center md:col-span-2">
        <input type="hidden" class="d-none" value="{{ $course->course_identity }}" name="course_identity" />

        <input type="submit"
            class="px-5 py-2.5 text-sm font-medium text-white bg-green-700 hover:bg-green-800 rounded-lg"
            name="overview_form" value="{{ $course ? 'Update' : 'Create' }}">
    </div>

</form>
