@extends('layouts.teacher')
@section('nav-options')
    <nav>
        <!-- breadcrumb -->
        <ol class="flex flex-wrap pt-1 mr-12 bg-transparent rounded-lg sm:mr-16">
            <li class="text-neutral-900 text-sm">
                <a class="text-white " href="javascript:;">Home</a>
            </li>
            <li
                class="ltext-sm pl-2 capitalize text-neutral-900 text-white before:float-left before:pr-2 before:text-white before:content-['/']">
                <a class="text-white" href="{{ route('teacher.dashboard.index') }}">Dashboard</a>
            </li>
            <li class="text-sm pl-2  font-bold capitalize  text-white before:float-left before:pr-2 before:text-white before:content-['/']"
                aria-current="page">My Course Listing</li>
        </ol>
        <h6 class="mb-0 font-bold text-white capitalize">My Course Listing</h6>
    </nav>
@endsection
@section('content')
    <!-- cards -->
    <div class="w-full px-6 py-6 mx-auto">
        <div class="flex flex-wrap -mx-3 mt-4">
            <div class="flex-none w-full max-w-full px-3">
                <div
                    class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                    <div class="p-4 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                        <div class="flex">
                            <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
                                <h6 class="dark:text-white">My Course List</h6>
                            </div>
                            <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">

                            </div>
                            <div class="w-full text-right max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-2/4 mb-3">


                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex-auto px-0 pt-0 pb-2 min-h-75">
                    <div class="p-4 overflow-x-auto form-container">
                        <div class="max-w-7xl mx-auto p-4 md:p-6">
                            @forelse ($my_courses ?? [] as $course)
                                <!-- CARD -->
                                <div
                                    class=" mb-4 rounded-2xl bg-blue-500/13 shadow-2xl border-black rounded-3xl p-5 md:p-8 relative">

                                    <!-- ACTION MENU -->
                                    <div class="absolute top-4 right-4">
                                        <div class="">
                                            <!-- ACTIONS -->
                                            <div class="relative">
                                                <button data-dropdown-toggle="dropdown_{{ $course->id }}">
                                                    <svg class="w-6 h-6 text-gray-700 dark:text-white" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                                            d="M12 6h.01M12 12h.01M12 18h.01" />
                                                    </svg>
                                                </button>


                                            </div>
                                            <!-- Dropdown -->
                                            <div id="dropdown_{{ $course->id }}"
                                                class="hidden absolute right-0 mt-0 w-30 bg-white rounded-lg shadow-md ">
                                                <a class="block px-4 py-2 text-xxs"
                                                    href="{{ route('teacher.my-courses.show', $course->course_identity) }}">
                                                    View
                                                </a>
                                                @if($course->status == 'published')
                                                <a class="edit-step block px-4 py-2  text-xxs"
                                                    href="{{ route('teacher.my-courses.schedule-class.create', $course->course_identity) }}">
                                                    Add Class
                                                </a>
                                                <a class="edit-step block px-4 py-2  text-xxs"
                                                    href="{{ route('teacher.my-courses.materials.create', $course->course_identity) }}">
                                                    Add Material
                                                </a>
                                                @endif
                                            </div>
                                        </div>

                                    </div>

                                    <!-- CONTENT -->
                                    <div class="flex flex-col lg:flex-row gap-8 items-stretch">

                                        <!-- IMAGE + PRICE -->
                                        <div class="lg:w-1/4">
                                            <div class="rounded-3xl overflow-hidden  h-20 sm:h-80">
                                                <img src="{{ $course->main_image_url }}" class=" h-full mx-auto rounded-5"
                                                    alt="Course">
                                            </div>

                                            <!-- PRICE -->
                                            <div class="mt-6 flex align-items-center gap-2  items-center">
                                                <p class="text-md font-bold p-0 m-0">Price</p>

                                                <div class="gap-1 flex">
                                                    @if ($course->net_price != $course->actual_price && $course->net_price != null)
                                                        <span class="relative text-gray-600 text-sm">
                                                            <strike
                                                                class="text-danger">{{ getPrice($course->actual_price) }}</strike>
                                                        </span>
                                                    @endif
                                                    <span
                                                        class="text-md font-semibold">{{ getPrice($course->net_price) }}</span>
                                                </div>
                                            </div>

                                            <!-- STATUS -->
                                            <div class="flex gap-3 mt-2 mb-2">
                                                <span
                                                    class="px-3 text-small py-1 text-sm text-white {{ $course->is_public == '1' ? 'bg-info' : 'bg-primary' }}    rounded-full">{{ $course->is_public ? 'Public' : 'Private' }}</span>
                                                <span
                                                    class="px-3 text-small py-1 text-sm text-white {{ $course->status == 'published' ? 'bg-success' : 'bg-red-500' }} rounded-full capitalize">{{ $course->status }}</span>
                                            </div>
                                            @if ($course->coupon_available == 1)
                                                <span
                                                    class="px-3 text-small py-1 mb-2 text-sm text-white bg-primary   rounded-full">Coupon
                                                    Available</span>
                                            @endif
                                            @if ($course->allow_installment == 1)
                                                <span
                                                    class="px-3 text-small py-1 mb-2 text-sm text-white bg-primary   rounded-full">Installment
                                                    Available</span>
                                            @endif
                                        </div>

                                        <!-- DETAILS -->
                                        <div class="lg:w-3/4">
                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">

                                                <!-- LEFT -->
                                                <div class="space-y-2">
                                                    <p class="text-sm">Title : {{ $course->title }}</p>
                                                    <p class="text-sm" title="{{ $course->description }}">Description :
                                                        {{ Str::limit($course->description, '10', '..') }}</p>
                                                    <p class="text-sm">Type / Mode : <span
                                                            class="capitalize text-success">{{ $course->course_type }} /
                                                            {{ $course->class_mode }}</span> </p>
                                                    <p class="text-sm">Class Type : <span
                                                            class="capitalize text-success">{{ $course->class_type }}</span>
                                                    </p>
                                                    <p class="text-sm">Created At : <span
                                                            class="text-success">{{ dateFormat($course->created_at) }}</span>
                                                    </p>
                                                </div>

                                                <!-- CENTER -->
                                                <div class="space-y-2">

                                                    <p class="text-sm">Scheduled Classes : <span
                                                            class="text-success text-bold">{{ $course->classes->count() }}</span>
                                                    </p>
                                                    <p class="text-sm">Materials : <span
                                                            class="text-success text-bold">{{ $course->materials->count() }}</span>
                                                    </p>
                                                    <p class="text-sm">Completed Classes : <span
                                                            class="text-success text-bold">{{ $course->classes->count() }}</span>
                                                    </p>
                                                    <p class="text-sm">Exams : 0</p>
                                                    <p class="text-sm">Enrolled Students : <span
                                                            class="text-success text-bold">{{ $course->registrations->count() }}</span>
                                                    </p>
                                                </div>

                                                <!-- RIGHT -->
                                                <div class="space-y-2">
                                                    <p class="text-sm">Duration : <span
                                                            class="text-success capitalize text-bold">{{ $course->duration }}/{{ $course->duration_type }}
                                                        </span></p>
                                                    <p class="text-sm">Total Hours : <span
                                                            class="text-success capitalize text-bold">{{ $course->total_hours }}</span>
                                                    </p>
                                                    <p class="text-sm">Started At : <span
                                                            class="text-success capitalize text-bold">{{ dateFormat($course->started_at) }}</span>
                                                    </p>
                                                    <p class="text-sm">Ended At : <span
                                                            class="text-success capitalize text-bold">{{ dateFormat($course->ended_at) }}</span>
                                                    </p>

                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @empty
                                <div class="text-center">
                                    <h6>No course found..</h6>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
