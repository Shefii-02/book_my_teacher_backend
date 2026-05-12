@extends('layouts.teacher')

@section('nav-options')
    <nav>
        <ol class="flex flex-wrap pt-1 bg-transparent rounded-lg">
            <li class="text-sm">
                <a class="text-white" href="javascript:;">Home</a>
            </li>

            <li class="text-sm pl-2 capitalize before:float-left before:pr-2 before:text-white before:content-['/']">
                <a class="text-white" href="{{ route('teacher.dashboard.index') }}">
                    Dashboard
                </a>
            </li>

            <li class="text-sm pl-2 font-bold capitalize text-white before:float-left before:pr-2 before:text-white before:content-['/']"
                aria-current="page">
                My Course Listing
            </li>
        </ol>

        <h6 class="mb-0 font-bold text-white capitalize">
            My Course Listing
        </h6>
    </nav>
@endsection

@section('content')
    <div class="w-full px-6 py-6 mx-auto">

        {{-- ===================== TOP ANALYTICS ===================== --}}
        <div class="grid grid-cols-1 md:grid-cols-4 xl:grid-cols-4 gap-3 mb-8">

            {{-- TOTAL COURSES --}}
            <div
                class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-blue-600 via-cyan-500 to-sky-400 p-4 shadow-[0_20px_60px_rgba(59,130,246,0.35)]">

                <div class="absolute top-0 right-0 w-40 h-40 bg-white/10 rounded-full blur-3xl"></div>

                <div class="relative flex items-center justify-between">

                    <div>
                        <p class="text-white/70 text-sm font-semibold uppercase tracking-wider">
                            Total Courses
                        </p>

                        <h2 class="text-4xl font-black text-white mt-3">
                            {{ $data['courses']['total'] ?? 0 }}
                        </h2>

                        <p class="text-white/70 mt-3 text-sm">
                            Active learning programs
                        </p>
                    </div>

                    <div
                        class="w-16 h-16 rounded-2xl bg-white/20 backdrop-blur-xl flex items-center justify-center border border-white/20">
                        <i class="ni ni-books text-white text-3xl"></i>
                    </div>

                </div>
            </div>

            {{-- STUDENTS --}}
            <div
                class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-violet-600 via-fuchsia-500 to-pink-500 p-4 shadow-[0_20px_60px_rgba(168,85,247,0.35)]">

                <div class="absolute bottom-0 left-0 w-40 h-40 bg-white/10 rounded-full blur-3xl"></div>

                <div class="relative flex items-center justify-between">

                    <div>
                        <p class="text-white/70 text-sm font-semibold uppercase tracking-wider">
                            Students
                        </p>

                        <h2 class="text-4xl font-black text-white mt-3">
                            {{ $data['students']['total'] ?? 0 }}
                        </h2>

                        <p class="text-white/70 mt-3 text-sm">
                            Total enrollments
                        </p>
                    </div>

                    <div
                        class="w-16 h-16 rounded-2xl bg-white/20 backdrop-blur-xl flex items-center justify-center border border-white/20">
                        <i class="ni ni-hat-3 text-white text-3xl"></i>
                    </div>

                </div>
            </div>

            {{-- EARNINGS --}}
            <div
                class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-emerald-500 via-teal-500 to-cyan-500 p-4 shadow-[0_20px_60px_rgba(16,185,129,0.35)]">

                <div class="absolute top-0 left-0 w-40 h-40 bg-white/10 rounded-full blur-3xl"></div>

                <div class="relative flex items-center justify-between">

                    <div>
                        <p class="text-white/70 text-sm font-semibold uppercase tracking-wider">
                            Total Earnings
                        </p>

                        <h2 class="text-4xl font-black text-white mt-3">
                            ₹{{ number_format($data['earnings']['total'] ?? 0) }}
                        </h2>

                        <p class="text-white/70 mt-3 text-sm">
                            Lifetime income
                        </p>
                    </div>

                    <div
                        class="w-16 h-16 rounded-2xl bg-white/20 backdrop-blur-xl flex items-center justify-center border border-white/20">
                        <i class="ni ni-money-coins text-white text-3xl"></i>
                    </div>

                </div>
            </div>

            {{-- COMPLETION --}}
            <div
                class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-orange-500 via-amber-500 to-yellow-400 p-4 shadow-[0_20px_60px_rgba(249,115,22,0.35)]">

                <div class="absolute bottom-0 right-0 w-40 h-40 bg-white/10 rounded-full blur-3xl"></div>

                <div class="relative">

                    <div class="flex items-center justify-between">

                        <div>
                            <p class="text-white/70 text-sm font-semibold uppercase tracking-wider">
                                Completion
                            </p>

                            <h2 class="text-4xl font-black text-white mt-3">
                                96%
                            </h2>
                        </div>

                        <div
                            class="w-16 h-16 rounded-2xl bg-white/20 backdrop-blur-xl flex items-center justify-center border border-white/20">
                            <i class="ni ni-check-bold text-white text-3xl"></i>
                        </div>

                    </div>

                    <div class="mt-6">

                        <div class="w-full h-3 rounded-full bg-white/20 overflow-hidden">

                            <div class="h-full w-[96%] rounded-full bg-white shadow-[0_0_20px_rgba(255,255,255,0.8)]">
                            </div>

                        </div>

                    </div>

                </div>
            </div>

        </div>

        {{-- ===================== COURSE LIST ===================== --}}
        <div class="space-y-8">

            @forelse ($my_courses ?? [] as $course)
                <div
                    class="group relative rounded-2xl overflow-hidden rounded-[32px] border border-white/20 bg-white/40 dark:bg-slate-900/60 backdrop-blur-2xl shadow-[0_20px_80px_rgba(0,0,0,0.15)] hover:shadow-[0_30px_100px_rgba(59,130,246,0.25)] transition-all duration-500 p-5 md:p-8">

                    {{-- glowing bg --}}
                    <div
                        class="absolute -top-24 -right-24 w-72 h-72 bg-blue-500/10 rounded-full blur-3xl group-hover:bg-cyan-400/20 transition-all duration-500">
                    </div>

                    <div
                        class="absolute -bottom-24 -left-24 w-72 h-72 bg-violet-500/10 rounded-full blur-3xl group-hover:bg-fuchsia-400/20 transition-all duration-500">
                    </div>

                    {{-- ACTIONS --}}
                    <div class="absolute top-6 right-6 z-20">

                        <button data-dropdown-toggle="dropdown_{{ $course->id }}"
                            class="w-12 h-12 rounded-2xl bg-white/20 backdrop-blur-xl border border-white/20 flex items-center justify-center hover:scale-110 transition-all">

                            <i class="ni ni-bold-down text-slate-700 dark:text-white"></i>

                        </button>

                        {{-- DROPDOWN --}}
                        <div id="dropdown_{{ $course->id }}"
                            class="hidden absolute right-0 mt-3 w-52 rounded-2xl overflow-hidden border border-white/20 bg-white dark:bg-slate-900/95 backdrop-blur-2xl shadow-2xl z-50">

                            <a href="{{ route('teacher.my-courses.show', $course->course_identity) }}"
                                class="flex items-center gap-3 px-5 py-4 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all">

                                <i class="ni ni-zoom-split-in text-blue-500"></i>

                                <span class="text-sm font-semibold">
                                    View Course
                                </span>

                            </a>

                            @if ($course->status == 'published')
                                <a href="{{ route('teacher.my-courses.schedule-class.index', $course->course_identity) }}"
                                    class=" flex items-center gap-3 px-5 py-4 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all">

                                    <i class="ni ni-calendar-grid-58 text-emerald-500"></i>

                                    <span class="text-sm font-semibold">
                                        Class List
                                    </span>

                                </a>

                                <a href="#"
                                    data-url="{{ route('teacher.my-courses.schedule-class.create', $course->course_identity) }}"
                                    class="open-drawer flex items-center gap-3 px-5 py-4 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all">

                                    <i class="ni ni-calendar-grid-58 text-emerald-500"></i>

                                    <span class="text-sm font-semibold">
                                        Add Class
                                    </span>

                                </a>
                                <a href="{{ route('teacher.my-courses.materials.index', $course->course_identity) }}"
                                    class=" flex items-center gap-3 px-5 py-4 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all">

                                    <i class="ni ni-books text-pink-500"></i>

                                    <span class="text-sm font-semibold">
                                        Material List
                                    </span>

                                </a>
                                <a href="#"
                                    data-url="{{ route('teacher.my-courses.materials.create', $course->course_identity) }}"
                                    class="open-drawer flex items-center gap-3 px-5 py-4 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all">

                                    <i class="ni ni-books text-pink-500"></i>

                                    <span class="text-sm font-semibold">
                                        Add Material
                                    </span>

                                </a>
                            @endif

                        </div>

                    </div>

                    {{-- CONTENT --}}
                    <div class="relative flex flex-col lg:flex-row gap-8">

                        {{-- IMAGE --}}
                        <div class="lg:w-1/4">

                            <div class="relative overflow-hidden rounded-[28px]  sm:h-72 shadow-2xl">

                                <img src="{{ $course->main_image_url }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-all duration-700"
                                    alt="Course">

                                {{-- overlay --}}
                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-transparent">
                                </div>

                                {{-- top badges --}}
                                <div class="absolute top-4 left-4 flex flex-wrap gap-2">

                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-bold backdrop-blur-xl border border-white/20 text-white bg-black/30">
                                        {{ ucfirst($course->course_type) }}
                                    </span>

                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-bold {{ $course->status == 'published' ? 'bg-emerald-500/90' : 'bg-rose-500/90' }} text-white">

                                        {{ ucfirst($course->status) }}

                                    </span>

                                </div>

                                {{-- earnings --}}
                                <div class="absolute bottom-4 left-4 right-4">

                                    <div class="rounded-2xl bg-white/10 backdrop-blur-xl border border-white/10 px-4 py-3">

                                        <p class="text-white/60 text-xs uppercase">
                                            Total Earnings
                                        </p>

                                        <h4 class="text-white font-black text-2xl mt-1">
                                            ₹{{ number_format($course->teacher_earnings_sum_amount ?? 0) }}
                                        </h4>

                                    </div>

                                </div>

                            </div>

                        </div>

                        {{-- DETAILS --}}
                        <div class="lg:w-3/4">

                            {{-- TITLE --}}
                            <div class="mb-6">

                                <h6 class="text-3xl font-black text-slate-800 dark:text-white leading-tight">

                                    {{ $course->title }}

                                </h6>

                                <p class="mt-3 text-slate-600 dark:text-white/60 leading-relaxed text-xxs">

                                    {{ Str::limit(strip_tags($course->description), 160) }}

                                </p>

                            </div>

                            {{-- STATS --}}
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-2">

                                {{-- CARD --}}
                                <div
                                    class="rounded-2xl bg-gradient-to-br from-blue-500/10 to-cyan-500/10 border border-blue-200/30 p-2">

                                    <div class="flex items-center justify-between">

                                        <div>
                                            <p class="text-slate-500 dark:text-white/60 text-xs uppercase">
                                                Classes
                                            </p>

                                            <h4 class="text-3xl font-black text-slate-800 dark:text-white mt-2">
                                                {{ $course->classes->count() }}
                                            </h4>
                                        </div>

                                        <div
                                            class="w-14 h-14 rounded-2xl bg-blue-500 flex items-center justify-center shadow-lg shadow-blue-500/30">

                                            <i class="ni ni-calendar-grid-58 text-white text-xl"></i>

                                        </div>

                                    </div>

                                </div>

                                {{-- CARD --}}
                                <div
                                    class="rounded-2xl bg-gradient-to-br from-emerald-500/10 to-teal-500/10 border border-emerald-200/30 p-2">

                                    <div class="flex items-center justify-between">

                                        <div>
                                            <p class="text-slate-500 dark:text-white/60 text-xs uppercase">
                                                Students
                                            </p>

                                            <h4 class="text-3xl font-black text-slate-800 dark:text-white mt-2">
                                                {{ $course->registrations->count() }}
                                            </h4>
                                        </div>

                                        <div
                                            class="w-14 h-14 rounded-2xl bg-emerald-500 flex items-center justify-center shadow-lg bg-emerald-500/30">

                                            <i class="ni ni-hat-3 text-white text-xl"></i>

                                        </div>

                                    </div>

                                </div>

                                {{-- CARD --}}
                                <div
                                    class="rounded-2xl bg-gradient-to-br from-pink-500/10 to-rose-500/10 border border-pink-200/30 p-2">

                                    <div class="flex items-center justify-between">

                                        <div>
                                            <p class="text-slate-500 dark:text-white/60 text-xs uppercase">
                                                Materials
                                            </p>

                                            <h4 class="text-3xl font-black text-slate-800 dark:text-white mt-2">
                                                {{ $course->materials->count() }}
                                            </h4>
                                        </div>

                                        <div
                                            class="w-14 h-14 rounded-2xl bg-pink-500 flex items-center justify-center shadow-lg shadow-pink-500/30">

                                            <i class="ni ni-books text-white text-xl"></i>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <!-- PRICE -->
                            <div class="mt-6 flex align-items-center gap-2 items-center">
                                <p class="text-md font-bold p-0 m-0">Price</p>
                                <div class="gap-1 flex">
                                    @if ($course->net_price != $course->actual_price && $course->net_price != null)
                                        <span class="relative text-gray-600 text-sm"> <strike
                                                class="text-danger">{{ getPrice($course->actual_price) }}</strike> </span>
                                    @endif <span
                                        class="text-md font-semibold">{{ getPrice($course->net_price) }}</span>
                                </div>
                            </div> <!-- STATUS -->
                            <div class="flex gap-3 mt-2 mb-2"> <span
                                    class="px-3 text-small py-1 text-sm text-white {{ $course->is_public == '1' ? 'bg-info' : 'bg-primary' }} rounded-full">{{ $course->is_public ? 'Public' : 'Private' }}</span>
                                <span
                                    class="px-3 text-small py-1 text-sm text-white {{ $course->status == 'published' ? 'bg-success' : 'bg-red-500' }} rounded-full capitalize">{{ $course->status }}</span>
                            </div>
                            @if ($course->coupon_available == 1)
                                <span class="px-3 text-small py-1 mb-2 text-sm text-white bg-primary rounded-full">Coupon
                                    Available</span>
                            @endif
                            @if ($course->allow_installment == 1)
                                <span
                                    class="px-3 text-small py-1 mb-2 text-sm text-white bg-primary rounded-full">Installment
                                    Available</span>
                            @endif

                        </div> <!-- DETAILS -->
                        <div class="lg:w-3/4">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start"> <!-- LEFT -->
                                <div class="space-y-2">
                                    <p class="text-sm">Title : {{ $course->title }}</p>
                                    <p class="text-sm" title="{{ $course->description }}">Description :
                                        {{ Str::limit($course->description, '10', '..') }}</p>
                                    <p class="text-sm">Type / Mode : <span
                                            class="capitalize text-success">{{ $course->course_type }} /
                                            {{ $course->class_mode }}</span> </p>
                                    <p class="text-sm">Class Type : <span
                                            class="capitalize text-success">{{ $course->class_type }}</span> </p>
                                    <p class="text-sm">Created At : <span
                                            class="text-success">{{ dateFormat($course->created_at) }}</span> </p>
                                </div> <!-- CENTER -->
                                <div class="space-y-2">
                                    <p class="text-sm">Scheduled Classes : <span
                                            class="text-success text-bold">{{ $course->classes->count() }}</span> </p>
                                    <p class="text-sm">Materials : <span
                                            class="text-success text-bold">{{ $course->materials->count() }}</span> </p>
                                    <p class="text-sm">Completed Classes : <span
                                            class="text-success text-bold">{{ $course->classes->count() }}</span> </p>
                                    <p class="text-sm">Exams : 0</p>
                                    <p class="text-sm">Enrolled Students : <span
                                            class="text-success text-bold">{{ $course->registrations->count() }}</span>
                                    </p>
                                </div> <!-- RIGHT -->
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

                <div
                    class="rounded-2xl bg-white/40 dark:bg-slate-900/50 backdrop-blur-2xl border border-white/20 p-16 text-center shadow-xl">

                    <div
                        class="w-24 h-24 mx-auto rounded-full bg-gradient-to-br from-blue-500 to-cyan-400 flex items-center justify-center shadow-2xl">

                        <i class="ni ni-books text-white text-4xl"></i>

                    </div>

                    <h2 class="text-3xl font-black text-slate-800 dark:text-white mt-8">
                        No Courses Found
                    </h2>

                    <p class="text-slate-500 dark:text-white/60 mt-3">
                        Start creating your first course and grow your teaching business.
                    </p>

                </div>
            @endforelse

        </div>

    </div>
@endsection
