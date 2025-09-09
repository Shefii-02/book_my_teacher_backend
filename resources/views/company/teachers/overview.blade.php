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
<div class="w-full px-6 py-6 mx-auto">
    <div class="bg-white dark:bg-slate-850 shadow-xl rounded-2xl p-6 mb-6">
        <h2 class="text-xl font-bold mb-4 dark:text-white">👤 Personal Information</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <p><span class="font-semibold">Full Name:</span> {{ $teacher->name }}</p>
            <p><span class="font-semibold">Email:</span> {{ $teacher->email }}</p>
            <p><span class="font-semibold">Phone:</span> {{ $teacher->mobile }}</p>
            <p><span class="font-semibold">Address:</span> {{ $teacher->address }}, {{ $teacher->city }}</p>
            <p><span class="font-semibold">Postal Code:</span> {{ $teacher->postal_code }}</p>
            <p><span class="font-semibold">District:</span> {{ $teacher->district }}</p>
            <p><span class="font-semibold">State:</span> {{ $teacher->state }}</p>
            <p><span class="font-semibold">Country:</span> {{ $teacher->country }}</p>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-850 shadow-xl rounded-2xl p-6 mb-6">
        <h2 class="text-xl font-bold mb-4 dark:text-white">🎓 Professional Information</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <p><span class="font-semibold">Mode of Interest:</span> {{ $teacher->professionalInfo->mode }}</p>
            <p><span class="font-semibold">Teaching Grades:</span> {{ implode(', ', $teacher->professionalInfo->grades ?? []) }}</p>
            {{-- <p><span class="font-semibold">Subjects:</span> {{ implode(', ', $teacherSubjects) }}</p> --}}
            <p><span class="font-semibold">Years of Exp (Offline):</span> {{ $teacher->professionalInfo->exp_offline }}</p>
            <p><span class="font-semibold">Years of Exp (Online):</span> {{ $teacher->professionalInfo->exp_online }}</p>
            <p><span class="font-semibold">Profession:</span> {{ $teacher->professionalInfo->profession }}</p>
            <p><span class="font-semibold">Preferred Days:</span> {{ implode(', ', $working_days ?? []) }}</p>
            <p><span class="font-semibold">Preferred Times:</span> {{ implode(', ', $working_hours ?? []) }}</p>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-850 shadow-xl rounded-2xl p-6 mb-6">
        <h2 class="text-xl font-bold mb-4 dark:text-white">📄 CV</h2>
        @if($teacher->cv)
            <a href="{{ asset('storage/'.$teacher->cv) }}" target="_blank" class="text-blue-500 underline">View CV</a>
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
