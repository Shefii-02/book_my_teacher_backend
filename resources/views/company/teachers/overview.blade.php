@extends('layouts.layout')
@php

    if (isset($$teacher)) {
        $profInfo = $$teacher->professionalInfo;
        $grades = $$teacher->teacherGrades->pluck('grade')->toArray();
        $teacherSubjects = $$teacher->subjects->pluck('subject')->toArray();
        $working_days = $$teacher->workingDays->pluck('day')->toArray();
        $working_hours = $$teacher->workingHours->pluck('time_slot')->toArray();
    }

@endphp

@section('nav-options')
    <nav>
        <!-- breadcrumb -->
        <ol class="flex flex-wrap pt-1 mr-12 bg-transparent rounded-lg sm:mr-16">
            <li class="text-neutral-900 text-sm">
                <a class="text-white " href="javascript:;">Home</a>
            </li>
            <li
                class="ltext-sm pl-2 capitalize text-neutral-900 text-white before:float-left before:pr-2 before:text-white before:content-['/']">
                <a class="text-white" href="javascript:;">Dashboard</a>
            </li>
            <li class="text-sm pl-2  font-bold capitalize  text-white before:float-left before:pr-2 before:text-white before:content-['/']"
                aria-current="page">Teachers Overview</li>
        </ol>
        <h6 class="mb-0 font-bold text-white capitalize">Teacher Overview</h6>
    </nav>
@endsection
@section('content')
    <div class="container">

        <div class="card bg-white rounded-3 my-3">
            <div class="card-title p-3 my-3">
                <div class="flex justify-between">
                    <h5 class="font-bold">Teacher Overview</h5>
                    <a href="{{ route('admin.teachers') }}"
                        class="bg-emerald-500/50 rounded-1.8  text-white px-3 py-2">Back</a>
                </div>
            </div>
        </div>
    </div>

    <div class="w-full px-6 py-4 mx-auto">
        <div class="bg-white dark:bg-slate-850 shadow-xl rounded-2xl p-6 mb-6">
            <h2 class="text-xl font-bold mb-4 dark:text-white">👤 Personal Information</h2>
            <img src="{{ $teacher->avatar_url }}" class="w-20 rounded-lg mb-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <p><span class="font-semibold">Full Name:</span> <span
                        class="capitalize font-bold">{{ $teacher->name }}</span></p>
                <p><span class="font-semibold">Email:</span> <span class="capitalize font-bold">{{ $teacher->email }}</span>
                </p>
                <p><span class="font-semibold">Phone:</span> <span
                        class="capitalize font-bold">{{ $teacher->mobile }}</span></p>
                <p><span class="font-semibold">Address:</span> <span class="capitalize font-bold">{{ $teacher->address }},
                        {{ $teacher->city }}</span></p>
                <p><span class="font-semibold">Postal Code:</span> <span
                        class="capitalize font-bold">{{ $teacher->postal_code }}</span></p>
                <p><span class="font-semibold">District:</span> <span
                        class="capitalize font-bold">{{ $teacher->district }}</span></p>
                <p><span class="font-semibold">State:</span> <span class="capitalize font-bold">{{ $teacher->state }}</span>
                </p>
                <p><span class="font-semibold">Country:</span> <span
                        class="capitalize font-bold">{{ $teacher->country }}</span></p>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-850 shadow-xl rounded-2xl p-6 mb-6">
            <h2 class="text-xl font-bold mb-4 dark:text-white">🎓 Professional Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <p><span class="font-semibold">Mode of Interest:</span> <span
                        class="capitalize font-bold">{{ $teacher->professionalInfo->teaching_mode }}</span></p>
                <p><span class="font-semibold">Teaching Grades:</span> <span
                        class="capitalize font-bold">{{ implode(', ', $teacher->teacherGrades->pluck('grade')->toArray() ?? []) }}</span>
                </p>
                {{-- <p><span class="font-semibold">Subjects:</span> {{ implode(', ', $teacherSubjects) }}</p> --}}
                <p><span class="font-semibold">Years of Exp (Offline):</span> <span
                        class="capitalize font-bold">{{ $teacher->professionalInfo->offline_exp }}</span></p>
                <p><span class="font-semibold">Years of Exp (Online):</span> <span
                        class="capitalize font-bold">{{ $teacher->professionalInfo->online_exp }}</span></p>
                <p><span class="font-semibold ">Profession:</span> <span
                        class="capitalize font-bold">{{ $teacher->professionalInfo->profession }}</span></p>
                <p><span class="font-semibold">Preferred Days:</span> <span
                        class="capitalize font-bold">{{ implode(', ', $teacher->workingDays->pluck('day')->toArray() ?? []) }}</span>
                </p>
                <p><span class="font-semibold">Preferred Times:</span> <span
                        class="capitalize font-bold">{{ implode(', ', $teacher->workingHours->pluck('time_slot')->toArray() ?? []) }}</span>
                </p>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-850 shadow-xl rounded-2xl p-6 mb-6">
            <h2 class="text-xl font-bold mb-4 dark:text-white">📄 CV</h2>
            @if ($teacher->cv)
                <a href="{{ $teacher->cv_url }}" target="_blank" class="text-blue-500 underline">View CV</a>
            @else
                <p>No CV uploaded.</p>
            @endif
        </div>

        <div class="bg-white dark:bg-slate-850 shadow-xl rounded-2xl p-6">
            <h2 class="text-xl font-bold mb-4 dark:text-white">🔐 Login & Security</h2>
            <p><span class="font-semibold">Email:</span> {{ $teacher->email }}</p>
            <p><span class="font-semibold">Phone:</span> {{ $teacher->mobile }}</p>
            <p><span class="font-semibold">Password:</span> ********</p>
        </div>

    </div>
@endsection
