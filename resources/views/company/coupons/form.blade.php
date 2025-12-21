@extends('layouts.layout')

@section('nav-options')
    <nav>
        <ol class="flex flex-wrap pt-1 mr-12 bg-transparent rounded-lg sm:mr-16">
            <li class="text-neutral-900 text-sm">
                <a class="text-white" href="javascript:;">Home</a>
            </li>
            <li class="ltext-sm pl-2 capitalize text-white before:float-left before:pr-2 before:content-['/']">
                <a class="text-white" href="{{ route('company.dashboard') }}">Dashboard</a>
            </li>
            <li class="text-sm pl-2 font-bold capitalize text-white before:float-left before:pr-2 before:content-['/']"
                aria-current="page">
                Coupon {{ isset($coupon) ? 'Edit' : 'Create' }}
            </li>
        </ol>
        <h6 class="mb-0 font-bold text-white capitalize">Coupon {{ isset($coupon) ? 'Edit' : 'Create' }}</h6>
    </nav>
@endsection

@section('content')
    <div class="container">
        <div class="card bg-white dark:bg-slate-850 dark:shadow-dark-xl rounded-3 my-3">
            <div class="card-title p-3 my-3 flex justify-between">
                <h5 class="font-bold dark:text-white">{{ isset($coupon) ? 'Edit' : 'Create' }} Coupon</h5>
                <a href="{{ route('company.coupons.index') }}"
                    class="px-4 py-2 bg-gradient-to-tl from-emerald-500 to-teal-400 text-white rounded-full text-sm">Back</a>
            </div>
        </div>

        <div class="form-container relative flex flex-col min-w-0 mb-6 break-words bg-white shadow-xl rounded-2xl p-6">
            <form action="{{ isset($coupon) ? route('company.coupons.update', $coupon->id) : route('company.coupons.store') }}"
                method="POST">
                @csrf

                @if (isset($coupon))
                    @method('PUT')
                @endif

                <div class="grid gap-6 mb-6 md:grid-cols-2">
                    <div>
                        <label class="block mb-2 text-sm font-medium">Offer Name</label>
                        <input type="text" name="offer_name" required
                            class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow"
                            value="{{ old('offer_name', $coupon->offer_name ?? '') }}"
                            class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium">Offer Code</label>
                        <input type="text" name="offer_code" required
                            class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow"
                            value="{{ old('offer_code', $coupon->offer_code ?? '') }}"
                            class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow">
                    </div>
                </div>

                <!-- Coupon & Discount Type -->
                <div class="grid gap-6 mb-6 md:grid-cols-2">
                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <div>
                            <label class="block mb-2 text-sm font-medium">Coupon Type</label>
                            <div class="flex gap-6">
                                <label><input type="radio" name="coupon_type" value="public"
                                        class="bg-gray-100 border-gray-300 focus:ring-blue-500"
                                        {{ old('coupon_type', $coupon->coupon_type ?? 'public') == 'public' ? 'checked' : '' }}>
                                    Public</label>
                                <label><input type="radio" name="coupon_type" value="private"
                                        class="bg-gray-100 border-gray-300 focus:ring-blue-500"
                                        {{ old('coupon_type', $coupon->coupon_type ?? '') == 'private' ? 'checked' : '' }}>
                                    Private</label>
                            </div>
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-medium">Discount Type</label>
                            <div class="flex gap-6">
                                <label><input type="radio" name="discount_type" value="flat"
                                        class="bg-gray-100 border-gray-300 focus:ring-blue-500"
                                        {{ old('discount_type', $coupon->discount_type ?? 'flat') == 'flat' ? 'checked' : '' }}>
                                    Flat</label>
                                <label><input type="radio" name="discount_type" value="percentage"
                                        class="bg-gray-100 border-gray-300 focus:ring-blue-500"
                                        {{ old('discount_type', $coupon->discount_type ?? '') == 'percentage' ? 'checked' : '' }}>
                                    Percentage</label>
                            </div>
                        </div>
                    </div>
                    <div class="grid gap-6 mb-6 md:grid-cols-1">
                        <!-- Discount Inputs -->
                        <div id="flat-fields" class="mb-6">
                            <label class="block mb-2 text-sm font-medium">Flat Discount Value (₹)</label>
                            <input type="number" step="0.01" name="discount_value"
                                class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow"
                                value="{{ old('discount_value', $coupon->discount_value ?? '') }}">
                        </div>

                        <div id="percentage-fields" class="hidden mb-6">
                            <div class="grid gap-6 md:grid-cols-2">
                                <div>
                                    <label class="block mb-2 text-sm font-medium">Discount Percentage (%)</label>
                                    <input type="number" step="0.01" name="discount_percentage"
                                        class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow"
                                        value="{{ old('discount_percentage', $coupon->discount_percentage ?? '') }}">
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-medium">Max Discount Up To (₹)</label>
                                    <input type="number" step="0.01" name="max_discount"
                                        value="{{ old('max_discount', $coupon->max_discount ?? '') }}"
                                        class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <!-- Dates -->
                <div class="grid gap-6 mb-6 md:grid-cols-2">
                    <div>
                        <label class="block mb-2 text-sm font-medium">Start Date & Time</label>
                        <input type="datetime-local" name="start_date_time"
                            value="{{ old('start_date_time', isset($coupon->start_date_time) ? \Carbon\Carbon::parse($coupon->start_date_time)->format('Y-m-d\TH:i') : '') }}"
                            class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow">
                    </div>
                    <div>
                        <div class="flex gap-2 justify-between">
                            <label class="block mb-2 text-sm font-medium">End Date & Time </label>
                            <!-- Unlimited Duration -->
                            <div class="flex items-center mb-2">
                                <input type="checkbox" id="is_unlimited" name="is_unlimited"
                                    class="bg-gray-100 border-gray-300 focus:ring-blue-500"
                                    {{ old('is_unlimited', $coupon->is_unlimited ?? false) ? 'checked' : '' }}>
                                <label for="is_unlimited" class="ml-2 text-sm text-gray-700">Unlimited Duration</label>
                            </div>
                        </div>

                        <input type="datetime-local" name="end_date_time"
                            value="{{ old('end_date_time', isset($coupon->end_date_time) ? \Carbon\Carbon::parse($coupon->end_date_time)->format('Y-m-d\TH:i') : '') }}"
                            class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow">
                    </div>
                </div>
                <div class="grid gap-6 mb-6 md:grid-cols-2">

                    <!-- Minimum Order -->
                    <div class="">
                        <label class="block mb-2 text-sm font-medium">Minimum Order Value</label>
                        <input type="number" step="0.01" name="minimum_order_value"
                            value="{{ old('minimum_order_value', $coupon->minimum_order_value ?? '') }}"
                            class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow">
                    </div>

                    <div class="">

                        <label class="block mb-2 text-sm font-medium">Course Selection Type</label>
                        <div class="grid gap-6  md:grid-cols-2">
                            <!-- Course Selection -->
                            <div class="flex items-center">
                                <input type="radio" id="assign_all" name="course_selection_type" value="all"
                                    class="bg-gray-100 border-gray-300 focus:ring-blue-500"
                                    {{ old('course_selection_type', $coupon->course_selection_type ?? 'all') == 'all' ? 'checked' : '' }}>
                                <label for="assign_all" class="ml-2 text-sm text-gray-700">Assign All Courses</label>
                            </div>

                            <!-- Course Selection -->
                            <div class="flex items-center">
                                <input type="radio" id="assign_specific" name="course_selection_type" value="specific"
                                    class="bg-gray-100 border-gray-300 focus:ring-blue-500"
                                    {{ old('course_selection_type', $coupon->course_selection_type ?? '') == 'specific' ? 'checked' : '' }}>
                                <label for="assign_specific" class="ml-2 text-sm text-gray-700">Assign to Specific
                                    Courses</label>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="grid gap-6 mb-3 md:grid-cols-3">
                    <div id="course-list" class="hidden">
                        <label class="block mb-2 text-sm font-medium">Select Courses</label>
                        <div class="flex flex-wrap gap-4">
                            @foreach ($courses as $course)
                                <label class="flex items-center space-x-2">
                                    <input type="checkbox" name="course_ids[]" value="{{ $course->id }}"
                                        class="bg-gray-100 border-gray-300 focus:ring-blue-500"
                                        {{ isset($couponCourses) && in_array($course->id, $couponCourses) ? 'checked' : '' }}>
                                    <span>{{ $course->title }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="grid gap-6 mb-3 md:grid-cols-2">

                    <!-- Show inside course -->
                    <div class="flex items-center mb-6">
                        <input type="checkbox" id="show_inside_courses" name="show_inside_courses"
                            class="bg-gray-100 border-gray-300 focus:ring-blue-500"
                            {{ old('show_inside_courses', $coupon->show_inside_courses ?? false) ? 'checked' : '' }}>
                        <label for="show_inside_courses" class="ml-2 text-sm text-gray-700">Show inside course
                            page</label>
                    </div>

                    <div class="flex flex-row justify-between gap-2">
                        <!-- Max usage -->
                        <div class="mb-6">
                            <label class="block mb-2 text-sm font-medium">Number of Times Used per Student</label>
                            <input type="number" name="max_usage_per_student"
                                value="{{ old('max_usage_per_student', $coupon->max_usage_per_student ?? '') }}"
                                class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow">
                        </div>
                        <!-- Unlimited usage -->
                        <div class="flex items-center mb-6">
                            <input type="checkbox" id="is_unlimited_usage" name="is_unlimited_usage"
                                class="bg-gray-100 border-gray-300 focus:ring-blue-500"
                                {{ old('is_unlimited_usage', $coupon->is_unlimited_usage ?? false) ? 'checked' : '' }}>
                            <label for="is_unlimited_usage" class="ml-2 text-sm text-gray-700">Unlimited Usage per
                                Student</label>
                        </div>
                    </div>

                </div>



                <div class="my-4 text-center">
                    <button type="submit"
                        class="px-5 py-2.5 text-sm font-medium text-white bg-green-700 hover:bg-green-800 rounded-lg">
                        {{ isset($coupon) ? 'Update Coupon' : 'Create Coupon' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

{{-- @push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const flatFields = document.getElementById('flat-fields');
            const percentageFields = document.getElementById('percentage-fields');
            const discountRadios = document.querySelectorAll('input[name="discount_type"]');
            const assignSpecific = document.getElementById('assign_specific');
            const courseList = document.getElementById('course-list');

            function toggleDiscountFields() {
                const selected = document.querySelector('input[name="discount_type"]:checked')?.value;
                if (selected === 'percentage') {
                    flatFields.classList.add('hidden');
                    percentageFields.classList.remove('hidden');
                } else {
                    flatFields.classList.remove('hidden');
                    percentageFields.classList.add('hidden');
                }
            }

            function toggleCourseList() {
                if (assignSpecific.checked) {
                    courseList.classList.remove('hidden');
                } else {
                    courseList.classList.add('hidden');
                }
            }

            discountRadios.forEach(radio => radio.addEventListener('change', toggleDiscountFields));
            assignSpecific.addEventListener('change', toggleCourseList);

            // On page load
            toggleDiscountFields();
            toggleCourseList();
        });
    </script>

    <style>
        .input-field {
            @apply pl-3 text-sm border border-gray-300 rounded-lg w-full py-2 pr-3 focus:border-blue-500 focus:outline-none;
        }

        .hidden {
            display: none;
        }
    </style>
@endpush --}}

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
    const flatFields = document.getElementById('flat-fields');
    const percentageFields = document.getElementById('percentage-fields');
    const discountRadios = document.querySelectorAll('input[name="discount_type"]');
    const assignSpecific = document.getElementById('assign_specific');
    const courseList = document.getElementById('course-list');
    const unlimitedCheckbox = document.getElementById('is_unlimited');
    const endDateInput = document.querySelector('input[name="end_date_time"]');
    const unlimitedUsageCheckbox = document.getElementById('is_unlimited_usage');
    const maxUsageInput = document.querySelector('input[name="max_usage_per_student"]');

    function toggleDiscountFields() {
        const selected = document.querySelector('input[name="discount_type"]:checked')?.value;
        if (selected === 'percentage') {
            flatFields.classList.add('hidden');
            percentageFields.classList.remove('hidden');
        } else {
            flatFields.classList.remove('hidden');
            percentageFields.classList.add('hidden');
        }
    }

    function toggleCourseList() {
        if (assignSpecific.checked) {
            courseList.classList.remove('hidden');
        } else {
            courseList.classList.add('hidden');
        }
    }

    function toggleEndDate() {
        if (unlimitedCheckbox.checked) {
            endDateInput.value = '';
            endDateInput.readOnly = true;
            endDateInput.classList.add('bg-gray-100', 'cursor-not-allowed');
        } else {
            endDateInput.readOnly = false;
            endDateInput.classList.remove('bg-gray-100', 'cursor-not-allowed');
        }
    }

    function toggleMaxUsage() {
        if (unlimitedUsageCheckbox.checked) {
            maxUsageInput.value = '';
            maxUsageInput.readOnly = true;
            maxUsageInput.classList.add('bg-gray-100', 'cursor-not-allowed');
        } else {
            maxUsageInput.readOnly = false;
            maxUsageInput.classList.remove('bg-gray-100', 'cursor-not-allowed');
        }
    }

    // Event listeners
    discountRadios.forEach(radio => radio.addEventListener('change', toggleDiscountFields));
    assignSpecific.addEventListener('change', toggleCourseList);
    unlimitedCheckbox.addEventListener('change', toggleEndDate);
    unlimitedUsageCheckbox.addEventListener('change', toggleMaxUsage);

    // Initialize on load
    toggleDiscountFields();
    toggleCourseList();
    toggleEndDate();
    toggleMaxUsage();
});
</script>
@endpush
