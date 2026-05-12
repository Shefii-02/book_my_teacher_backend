@extends('layouts.teacher')

@section('nav-options')
    <nav>
        <ol class="flex flex-wrap pt-1 bg-transparent rounded-lg sm:mr-16">

            <li class="text-sm">
                <a class="text-white/80" href="javascript:;">
                    Home
                </a>
            </li>

            <li class="text-sm pl-2 text-white before:float-left before:pr-2 before:text-white before:content-['/']">
                <a class="text-white/80" href="{{ route('teacher.dashboard.index') }}">
                    Dashboard
                </a>
            </li>

            <li class="text-sm pl-2 text-white before:float-left before:pr-2 before:text-white before:content-['/']">
                <a class="text-white/80" href="{{ route('teacher.my-courses.index') }}">
                    My Courses
                </a>
            </li>

            <li class="text-sm pl-2 font-bold text-white before:float-left before:pr-2 before:text-white before:content-['/']"
                aria-current="page">
                Course Classes
            </li>

        </ol>

        <h6 class="mb-0 font-black text-white capitalize">
            Course Classes Listing
        </h6>
    </nav>
@endsection

@section('content')
    @php

        $totalClasses = $course->classes->count();

        $completedClasses = $course->classes->where('end_time', '<', now())->count();

        $upcomingClasses = $course->classes->where('start_time', '>', now())->count();

        $ongoingClasses = $course->classes->where('start_time', '<=', now())->where('end_time', '>=', now())->count();

        $cancelledClasses = $course->classes->where('status', 0)->count();

    @endphp
    <div class="flex flex-wrap gap-3 justify-end px-6">

        <a href="#" data-url="{{ route('teacher.my-courses.schedule-class.create', $course->course_identity) }}"
            class="open-drawer inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-dark text-white font-bold shadow-lg shadow-cyan-500/30 hover:scale-[1.03] transition-all duration-300">

            <i class="bi bi-plus-lg"></i>
            Create Class

        </a>

        <a href="{{ route('teacher.my-courses.index') }}"
            class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-dark backdrop-blur-xl border border-white/10 text-white font-bold hover:bg-white/20 transition-all duration-300">

            <i class="bi bi-arrow-left"></i>
            Back

        </a>

    </div>

    <div class="w-full px-6 py-6 mx-auto">

        {{-- ========================= HEADER ========================= --}}
        <div
            class="relative overflow-hidden rounded-[30px] bg-blue-900 rounded-[2rem]  p-8 shadow-[0_25px_80px_rgba(0,0,0,0.35)] mb-8">

            <div class="absolute top-0 right-0 w-72 h-72 bg-cyan-400/10 rounded-full blur-3xl"></div>

            <div class="absolute bottom-0 left-0 w-72 h-72 bg-indigo-500/10 rounded-full blur-3xl"></div>

            <div class="relative z-10">

                <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-6">

                    <div class="flex items-start gap-5">

                        <div
                            class="w-20 h-20 rounded-3xl overflow-hidden border border-white/20 bg-white/10 backdrop-blur-xl shadow-xl">

                            <img src="{{ $course->main_image_url }}" class="w-full h-full object-cover"
                                alt="{{ $course->title }}">

                        </div>

                        <div>

                            <div class="flex flex-wrap items-center gap-3 mb-3">

                                <span
                                    class="px-4 py-1.5 rounded-full text-xs font-bold bg-cyan-500/20 text-cyan-300 border border-cyan-400/20">
                                    {{ strtoupper($course->course_type) }}
                                </span>

                                <span
                                    class="px-4 py-1.5 rounded-full text-xs font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-400/20">
                                    {{ strtoupper($course->class_mode) }}
                                </span>

                                <span
                                    class="px-4 py-1.5 rounded-full text-xs font-bold {{ $course->status == 'published' ? 'bg-green-500/20 text-green-300 border border-green-400/20' : 'bg-red-500/20 text-red-300 border border-red-400/20' }}">
                                    {{ strtoupper($course->status) }}
                                </span>

                            </div>

                            <h2 class="text-3xl font-black text-white leading-tight">
                                {{ $course->title }}
                            </h2>

                            <p class="text-white/60 mt-2 max-w-3xl">
                                {{ Str::limit(strip_tags($course->description), 150) }}
                            </p>

                            <div class="flex flex-wrap gap-6 mt-5 text-sm text-white/70">

                                <div class="flex items-center gap-2">
                                    <i class="ni ni-watch-time"></i>
                                    {{ $course->duration }} {{ ucfirst($course->duration_type) }}
                                </div>

                                <div class="flex items-center gap-2">
                                    <i class="ni ni-calendar-grid-58"></i>
                                    {{ dateFormat($course->started_at) }}
                                </div>

                                <div class="flex items-center gap-2">
                                    <i class="ni ni-money-coins"></i>
                                    {{ getPrice($course->net_price) }}
                                </div>

                            </div>

                        </div>

                    </div>



                </div>

            </div>

        </div>

        {{-- ========================= STATS ========================= --}}
        <div class="grid grid-cols-1 md:grid-cols-4 xl:grid-cols-4 gap-3 ">

            {{-- TOTAL --}}
            <div
                class="relative overflow-hidden rounded-3xl p-6 bg-white/70 dark:bg-slate-900/70 backdrop-blur-2xl border border-white/20 shadow-xl">

                <div class="absolute right-0 top-0 w-24 h-24 bg-blue-500/10 rounded-full blur-2xl"></div>

                <div class="relative">

                    <div class="flex items-center justify-between">

                        <div>
                            <p class="text-slate-500 text-sm font-semibold">
                                Total Classes
                            </p>

                            <h2 class="text-4xl font-black mt-2 text-slate-800 dark:text-white">
                                {{ $totalClasses }}
                            </h2>
                        </div>

                        <div
                            class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-500 to-cyan-400 flex items-center justify-center shadow-lg shadow-blue-500/30">
                            <i class="ni ni-books text-white text-xl"></i>
                        </div>

                    </div>

                </div>

            </div>

            {{-- COMPLETED --}}
            <div
                class="relative overflow-hidden rounded-3xl p-6 bg-gradient-to-br from-emerald-500 to-teal-500 shadow-xl shadow-emerald-500/30 text-white">

                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-white/70 text-sm font-semibold">
                            Completed
                        </p>

                        <h2 class="text-4xl font-black mt-2">
                            {{ $completedClasses }}
                        </h2>
                    </div>

                    <div class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center">
                        <i class="ni ni-check-bold text-2xl"></i>
                    </div>

                </div>

            </div>

            {{-- UPCOMING --}}
            <div
                class="relative overflow-hidden rounded-3xl p-6 bg-gradient-to-br from-orange-500 to-amber-500 shadow-xl shadow-orange-500/30 text-white">

                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-white/70 text-sm font-semibold">
                            Upcoming/Ongoing
                        </p>

                        <h2 class="text-4xl font-black mt-2">
                            {{ $upcomingClasses + $ongoingClasses }}
                        </h2>
                    </div>

                    <div class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center">
                        <i class="ni ni-calendar-grid-58 text-2xl"></i>
                    </div>

                </div>

            </div>


            {{-- CANCELLED --}}
            <div
                class="relative overflow-hidden rounded-3xl p-6 bg-gradient-to-br from-red-500 to-rose-500 shadow-xl shadow-red-500/30 text-white">

                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-dark text-sm font-semibold">
                            Cancelled
                        </p>

                        <h2 class="text-4xl font-black mt-2">
                            {{ $cancelledClasses }}
                        </h2>
                    </div>

                    <div class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center">
                        <i class="ni ni-fat-remove text-2xl"></i>
                    </div>

                </div>

            </div>

        </div>

        {{-- ========================= CLASS CARDS ========================= --}}
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mt-3">

            @forelse($course->classes->sortByDesc('scheduled_at') as $key => $class)
                @php

                    $classLink = $class->recording_url ?: $class->meeting_link;

                    $isCompleted = $class->end_time < now();

                    $isUpcoming = $class->start_time > now();

                    $isOngoing = $class->start_time <= now() && $class->end_time >= now();

                @endphp

                <div
                    class="group relative overflow-hidden rounded-[30px] bg-white/70 dark:bg-slate-900/70 backdrop-blur-2xl border border-white/20 shadow-[0_20px_60px_rgba(0,0,0,0.08)] hover:-translate-y-1 transition-all duration-300">

                    {{-- TOP BAR --}}
                    <div
                        class="h-2 w-full
                            {{ $isCompleted ? 'bg-gradient-to-r from-emerald-500 to-teal-400' : '' }}
                            {{ $isUpcoming ? 'bg-gradient-to-r from-orange-500 to-yellow-400' : '' }}
                            {{ $isOngoing ? 'bg-gradient-to-r from-blue-500 to-cyan-400' : '' }}">
                    </div>

                    <div class="p-7">

                        {{-- HEADER --}}
                        <div class="flex justify-between items-start gap-5">

                            <div class="flex items-start gap-4">

                                <div
                                    class="w-16 h-16 rounded-3xl flex items-center justify-center text-white font-black text-xl shadow-lg
                                    {{ $isCompleted ? 'bg-gradient-to-br from-emerald-500 to-teal-400' : '' }}
                                    {{ $isUpcoming ? 'bg-gradient-to-br from-orange-500 to-amber-400' : '' }}
                                    {{ $isOngoing ? 'bg-gradient-to-br from-blue-500 to-cyan-400' : '' }}">

                                    {{ $key + 1 }}

                                </div>

                                <div>

                                    <h3 class="text-xl font-black text-slate-800 dark:text-white leading-tight">
                                        {{ $class->title }}
                                    </h3>

                                    <p class="text-sm text-slate-500 dark:text-white/60 mt-1">
                                        {{ Str::limit($class->description, 80) }}
                                    </p>

                                </div>

                            </div>

                            {{-- ACTIONS --}}
                            <div class="relative">

                                <button data-dropdown-toggle="dropdown_{{ $class->id }}"
                                    class="w-11 h-11 rounded-2xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center hover:scale-110 transition-all duration-300">

                                    <i class="bi bi-three-dots-vertical text-slate-700 dark:text-white"></i>

                                </button>

                                <div id="dropdown_{{ $class->id }}"
                                    class="hidden absolute right-0 mt-2 w-44 bg-white dark:bg-slate-900 rounded-2xl shadow-2xl z-50 overflow-hidden border border-slate-100 dark:border-slate-800">
                                    @if (strtotime($class->end_time) < now()->timestamp)
                                        <li>
                                            <a href="#"
                                                data-url="{{ route('teacher.my-courses.schedule-class.attendance.edit', ['identity' => $course->course_identity, 'schedule_class' => $class->id]) }}"
                                                class="flex open-drawer items-center gap-2 px-5 py-3 text-sm hover:bg-slate-100 dark:hover:bg-slate-800">

                                                <i class="bi bi-pencil"></i>
                                                {{ $class->attendance?->count() ? 'Edit' : 'Take' }} Attendance </a>
                                        </li>

                                        <li>
                                            <a href="#"
                                                data-url="{{ route('teacher.my-courses.schedule-class.duration.edit', ['identity' => $course->course_identity, 'schedule_class' => $class->id]) }}"
                                                class="flex open-drawer items-center gap-2 px-5 py-3 text-sm hover:bg-slate-100 dark:hover:bg-slate-800">

                                                <i class="bi bi-pencil"></i>
                                                {{ $class->classDuration?->count() ? 'Edit' : 'Mark' }} Duration </a>
                                        </li>
                                    @endif

                                    <a href="#"
                                        data-url="{{ route('teacher.my-courses.schedule-class.edit', ['identity' => $course->course_identity, 'schedule_class' => $class->id]) }}"
                                        class="open-drawer flex items-center gap-2 px-5 py-3 text-sm hover:bg-slate-100 dark:hover:bg-slate-800">

                                        <i class="bi bi-pencil"></i>
                                        Edit Class

                                    </a>

                                    <a href="{{ $classLink }}" target="_blank"
                                        class="flex items-center gap-2 px-5 py-3 text-sm hover:bg-slate-100 dark:hover:bg-slate-800">

                                        <i class="bi bi-camera-video"></i>
                                        Open Link

                                    </a>

                                </div>

                            </div>

                        </div>

                        {{-- STATUS --}}
                        <div class="flex flex-wrap gap-3 mt-6">

                            @if ($isCompleted)
                                <span class="px-4 py-1.5 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold">
                                    Completed
                                </span>
                            @elseif($isUpcoming)
                                <span class="px-4 py-1.5 rounded-full bg-orange-100 text-orange-700 text-xs font-bold">
                                    Upcoming
                                </span>
                            @elseif($isOngoing)
                                <span
                                    class="px-4 py-1.5 rounded-full bg-blue-100 text-blue-700 text-xs font-bold animate-pulse">
                                    Live Now
                                </span>
                            @endif

                            <span
                                class="px-4 py-1.5 rounded-full {{ $class->status ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} text-xs font-bold">
                                {{ $class->status ? 'Published' : 'Unpublished' }}
                            </span>

                            <span
                                class="px-4 py-1.5 rounded-full bg-violet-100 text-violet-700 text-xs font-bold uppercase">
                                {{ $class->type }} / {{ $class->class_mode }}
                            </span>

                        </div>

                        {{-- DETAILS --}}
                        <div class="grid grid-cols-4 gap-5 mt-7">

                            <div
                                class="rounded-2xl bg-slate-50 dark:bg-slate-800/60 p-4 border border-slate-100 dark:border-slate-700">

                                <p class="text-xs font-bold uppercase text-slate-400 mb-2">
                                    Scheduled Date
                                </p>

                                <h5 class="font-black text-slate-800 dark:text-white">
                                    {{ dateFormat($class->scheduled_at) }}
                                </h5>

                            </div>

                            <div
                                class="rounded-2xl bg-slate-50 dark:bg-slate-800/60 p-4 border border-slate-100 dark:border-slate-700">

                                <p class="text-xs font-bold uppercase text-slate-400 mb-2">
                                    Duration
                                </p>

                                <h5 class="font-black text-slate-800 dark:text-white">
                                    {{ TimeFormat($class->start_time) }}
                                    -
                                    {{ TimeFormat($class->end_time) }}
                                </h5>

                            </div>

                            <div
                                class="rounded-2xl bg-slate-50 dark:bg-slate-800/60 p-4 border border-slate-100 dark:border-slate-700">

                                <p class="text-xs font-bold uppercase text-slate-400 mb-2">
                                    Position
                                </p>

                                <h5 class="font-black text-slate-800 dark:text-white">
                                    #{{ $class->priority }}
                                </h5>

                            </div>

                            <div
                                class="rounded-2xl bg-slate-50 dark:bg-slate-800/60 p-4 border border-slate-100 dark:border-slate-700">

                                <p class="text-xs font-bold uppercase text-slate-400 mb-2">
                                    Created At
                                </p>

                                <h5 class="font-black text-slate-800 dark:text-white">
                                    {{ $class->created_at->format('d M Y') }}
                                </h5>

                            </div>

                        </div>

                        {{-- LINK --}}
                        <div
                            class="mt-6 rounded-2xl bg-slate-100 dark:bg-slate-800/60 p-4 flex items-center justify-between gap-4">

                            <div class="overflow-hidden">

                                <p class="text-xs uppercase font-bold text-slate-400 mb-1">
                                    Meeting / Recording Link
                                </p>

                                <a href="{{ $classLink }}" target="_blank"
                                    class="text-sm font-semibold text-blue-600 truncate block">
                                    {{ Str::limit($classLink, 50) }}
                                </a>

                            </div>

                            <button onclick="copyPageLink(`{{ $classLink }}`)"
                                class="w-12 h-12 rounded-2xl bg-emerald-500/50  text-white flex items-center justify-center shadow-lg shadow-blue-500/30 hover:scale-110 transition-all duration-300">

                                <i class="bi bi-copy"></i>

                            </button>

                        </div>

                    </div>

                </div>

            @empty

                <div class="col-span-12">

                    <div
                        class="rounded-[30px] bg-white dark:bg-slate-900 p-20 text-center shadow-xl border border-slate-100 dark:border-slate-800">

                        <div
                            class="w-24 h-24 rounded-full bg-gradient-to-br from-blue-500 to-cyan-400 mx-auto flex items-center justify-center text-white text-4xl mb-6 shadow-2xl shadow-blue-500/30">

                            <i class="ni ni-books"></i>

                        </div>

                        <h3 class="text-3xl font-black text-slate-800 dark:text-white">
                            No Classes Found
                        </h3>

                        <p class="text-slate-500 mt-3">
                            Start by creating your first course class schedule.
                        </p>

                        <a href="#"
                            data-url="{{ route('teacher.my-courses.schedule-class.create', $course->course_identity) }}"
                            class="open-drawer inline-flex items-center gap-2 mt-8 px-6 py-3 rounded-2xl bg-gradient-to-r from-blue-500 to-cyan-400 text-white font-bold shadow-xl shadow-blue-500/30">

                            <i class="bi bi-plus-lg"></i>
                            Create Class

                        </a>

                    </div>

                </div>
            @endforelse

        </div>

    </div>
@endsection

@push('scripts')
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.4.3/dist/css/tom-select.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.4.3/dist/js/tom-select.complete.min.js"></script>

    <script>
        new TomSelect("#select-tags", {
            plugins: ['remove_button'],
            create: true,
        });
    </script>
@endpush
