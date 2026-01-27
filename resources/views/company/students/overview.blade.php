@extends('layouts.layout')
@php

    if (isset($$student)) {
        $profInfo = $$student->professionalInfo;
        $grades = $$student->teacherGrades->pluck('grade')->toArray();
        $studentSubjects = $$student->subjects->pluck('subject')->toArray();
        $working_days = $$student->workingDays->pluck('day')->toArray();
        $working_hours = $$student->workingHours->pluck('time_slot')->toArray();
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
            <li
                class="ltext-sm pl-2 capitalize text-neutral-900 text-white before:float-left before:pr-2 before:text-white before:content-['/']">
                <a class="text-white" href="javascript:;">Student Lisitng</a>
            </li>
            <li class="text-sm pl-2  font-bold capitalize  text-white before:float-left before:pr-2 before:text-white before:content-['/']"
                aria-current="page">Student Overview</li>
        </ol>
        <h6 class="mb-0 font-bold text-white capitalize">Student Overview</h6>
    </nav>
@endsection
@section('content')
    <div class="w-full px-6 py-6 mx-auto">
        <div class="bg-white dark:bg-slate-850 shadow-xl rounded-2xl p-6 mb-6">
            <h2 class="text-xl font-bold mb-4 dark:text-white">👤 Personal Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <p><span class="font-semibold">Full Name:</span> {{ $student->name }}</p>
                <p><span class="font-semibold">Email:</span> {{ $student->email }}</p>
                <p><span class="font-semibold">Phone:</span> {{ $student->mobile }}</p>
                <p><span class="font-semibold">Address:</span> {{ $student->address }}, {{ $student->city }}</p>
                <p><span class="font-semibold">Postal Code:</span> {{ $student->postal_code }}</p>
                <p><span class="font-semibold">District:</span> {{ $student->district }}</p>
                <p><span class="font-semibold">State:</span> {{ $student->state }}</p>
                <p><span class="font-semibold">Country:</span> {{ $student->country }}</p>
            </div>
        </div>

        {{-- <div class="bg-white dark:bg-slate-850 shadow-xl rounded-2xl p-6 mb-6">
            <h2 class="text-xl font-bold mb-4 dark:text-white">🎓 Professional Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <p><span class="font-semibold">Mode of Interest:</span> {{ $student->professionalInfo->mode }}</p>
                <p><span class="font-semibold">Teaching Grades:</span>
                    {{ implode(', ', $student->professionalInfo->grades ?? []) }}</p>
                <p><span class="font-semibold">Years of Exp (Offline):</span> {{ $student->professionalInfo->exp_offline }}
                </p>
                <p><span class="font-semibold">Years of Exp (Online):</span> {{ $student->professionalInfo->exp_online }}
                </p>
                <p><span class="font-semibold">Profession:</span> {{ $student->professionalInfo->profession }}</p>
                <p><span class="font-semibold">Preferred Days:</span> {{ implode(', ', $working_days ?? []) }}</p>
                <p><span class="font-semibold">Preferred Times:</span> {{ implode(', ', $working_hours ?? []) }}</p>
            </div>
        </div> --}}

        <div class="bg-white dark:bg-slate-850 shadow-xl rounded-2xl p-6">
            <h2 class="text-xl font-bold mb-4 dark:text-white">🔐 Login & Security</h2>
            <p><span class="font-semibold">Email:</span> {{ $student->email }}</p>
            <p><span class="font-semibold">Phone:</span> {{ $student->mobile }}</p>
            <p><span class="font-semibold">Password:</span> ********</p>
        </div>

    </div>
@endsection
