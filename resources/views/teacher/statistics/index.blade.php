@extends('layouts.teacher')

@section('nav-options')

<nav>

    <ol class="flex flex-wrap pt-1 bg-transparent rounded-lg sm:mr-16">

        <li class="text-sm">
            <a class="text-white" href="javascript:;">
                Home
            </a>
        </li>

        <li class="text-sm pl-2 text-white before:content-['/'] before:pr-2">
            Dashboard
        </li>

        <li class="text-sm pl-2 font-bold text-white before:content-['/'] before:pr-2">
            Statistics
        </li>

    </ol>

    <h6 class="mb-0 font-bold text-white capitalize">
        Statistics
    </h6>

</nav>

@endsection

@section('content')

<div class="w-full px-6 py-6 mx-auto">

    {{-- OVERVIEW CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-4 xl:grid-cols-4 gap-6 mb-8">

        {{-- TOTAL COURSES --}}
        <div class="rounded-2xl bg-gradient-to-br from-blue-500 to-cyan-400 p-6 shadow-2xl text-white">

            <div class="flex justify-between">

                <div>

                    <p class="uppercase text-xs opacity-70">
                        Total Courses
                    </p>

                    <h2 class="text-4xl font-black mt-3">
                        {{ $data['total_courses'] }}
                    </h2>

                </div>

                <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center">
                    <i class="ni ni-books text-2xl"></i>
                </div>

            </div>

        </div>

        {{-- TOTAL STUDENTS --}}
        <div class="rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-400 p-6 shadow-2xl text-white">

            <div class="flex justify-between">

                <div>

                    <p class="uppercase text-xs opacity-70">
                        Total Students
                    </p>

                    <h2 class="text-4xl font-black mt-3">
                        {{ $data['total_students'] }}
                    </h2>

                </div>

                <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center">
                    <i class="ni ni-single-02 text-2xl"></i>
                </div>

            </div>

        </div>

        {{-- TOTAL CLASSES --}}
        <div class="rounded-2xl bg-gradient-to-br from-violet-500 to-purple-500 p-6 shadow-2xl text-white">

            <div class="flex justify-between">

                <div>

                    <p class="uppercase text-xs opacity-70">
                        Total Classes
                    </p>

                    <h2 class="text-4xl font-black mt-3">
                        {{ $data['total_classes'] }}
                    </h2>

                </div>

                <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center">
                    <i class="ni ni-tv-2 text-2xl"></i>
                </div>

            </div>

        </div>

        {{-- TOTAL EARNINGS --}}
        <div class="rounded-2xl bg-gradient-to-br from-orange-500 to-yellow-400 p-6 shadow-2xl text-white">

            <div class="flex justify-between">

                <div>

                    <p class="uppercase text-xs opacity-70">
                        Total Earnings
                    </p>

                    <h2 class="text-4xl font-black mt-3">
                        ₹{{ number_format($data['total_earnings'],2) }}
                    </h2>

                </div>

                <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center">
                    <i class="ni ni-money-coins text-2xl"></i>
                </div>

            </div>

        </div>

    </div>

    {{-- SECOND ROW --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mb-8">

        {{-- COURSE STATUS --}}
        <div class="rounded-2xl bg-gradient-to-br from-blue-500 to-cyan-500 shadow-2xl p-6">

            <h3 class="text-xl font-black mb-6 dark:text-white">
                Course Statistics
            </h3>

            <div class="space-y-5">

                <div class="flex items-center justify-between">

                    <div class="flex items-center gap-3">

                        <div class="w-4 h-4 rounded-full bg-emerald-500/30"></div>

                        <span class="font-semibold dark:text-white">
                            Published Courses
                        </span>

                    </div>

                    <span class="font-black text-emerald-500">
                        {{ $data['published_courses'] }}
                    </span>

                </div>

                <div class="flex items-center justify-between">

                    <div class="flex items-center gap-3">

                        <div class="w-4 h-4 rounded-full bg-orange-500"></div>

                        <span class="font-semibold dark:text-white">
                            Draft Courses
                        </span>

                    </div>

                    <span class="font-black text-orange-500">
                        {{ $data['draft_courses'] }}
                    </span>

                </div>

            </div>

        </div>

        {{-- LIVE SESSION --}}
        <div class="rounded-2xl bg-gradient-to-br from-blue-500 to-cyan-500 shadow-2xl p-6">

            <h3 class="text-xl font-black mb-6 dark:text-white">
                Live Sessions
            </h3>

            <div class="space-y-5">

                <div class="flex justify-between">

                    <span class="dark:text-white font-semibold">
                        Webinars
                    </span>

                    <span class="font-black text-blue-500">
                        {{ $data['total_webinars'] }}
                    </span>

                </div>

                <div class="flex justify-between">

                    <span class="dark:text-white font-semibold">
                        Workshops
                    </span>

                    <span class="font-black text-violet-500">
                        {{ $data['total_workshops'] }}
                    </span>

                </div>

                <div class="flex justify-between">

                    <span class="dark:text-white font-semibold">
                        Demo Classes
                    </span>

                    <span class="font-black text-emerald-500">
                        {{ $data['total_demo_classes'] }}
                    </span>

                </div>

            </div>

        </div>

        {{-- QUICK SUMMARY --}}
        <div class="rounded-2xl bg-gradient-to-br from-blue-500 to-cyan-500 shadow-2xl p-6 text-white">

            <h3 class="text-xl font-black mb-6">
                Quick Summary
            </h3>

            <div class="space-y-6">

                <div>

                    <p class="text-sm opacity-70">
                        Average Students Per Course
                    </p>

                    <h2 class="text-3xl font-black mt-2">

                        {{ $data['total_courses'] > 0
                            ? round($data['total_students'] / $data['total_courses'])
                            : 0 }}

                    </h2>

                </div>

                <div>

                    <p class="text-sm opacity-70">
                        Average Earnings Per Course
                    </p>

                    <h2 class="text-3xl font-black mt-2">

                        ₹{{ $data['total_courses'] > 0
                            ? number_format($data['total_earnings'] / $data['total_courses'],2)
                            : 0 }}

                    </h2>

                </div>

            </div>

        </div>

    </div>

    {{-- RECENT EARNINGS --}}
    <div class="rounded-2xl bg-white dark:bg-slate-900 shadow-2xl overflow-hidden">

        <div class="p-6 border-b border-slate-100 dark:border-slate-800">

            <h3 class="text-2xl font-black dark:text-white">
                Recent Earnings
            </h3>

        </div>

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-slate-50 dark:bg-slate-800">

                    <tr>

                        <th class="px-6 py-4 text-left text-xs font-black uppercase">
                            #
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-black uppercase">
                            Title
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-black uppercase">
                            Type
                        </th>

                        <th class="px-6 py-4 text-center text-xs font-black uppercase">
                            Amount
                        </th>

                        <th class="px-6 py-4 text-center text-xs font-black uppercase">
                            Status
                        </th>

                        <th class="px-6 py-4 text-center text-xs font-black uppercase">
                            Earned At
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($recentEarnings as $key => $earning)

                    <tr>

                        <td class="px-6 py-5 border-b dark:border-slate-800">
                            {{ $key + 1 }}
                        </td>

                        <td class="px-6 py-5 border-b dark:border-slate-800">

                            <div class="font-bold dark:text-white">
                                {{ $earning->title }}
                            </div>

                            <div class="text-xs text-slate-500 mt-1">
                                {{ $earning->remarks }}
                            </div>

                        </td>

                        <td class="px-6 py-5 border-b dark:border-slate-800 capitalize">
                            {{ $earning->type }}
                        </td>

                        <td class="px-6 py-5 text-center border-b dark:border-slate-800">

                            <span class="font-black text-emerald-500">
                                ₹{{ number_format($earning->amount,2) }}
                            </span>

                        </td>

                        <td class="px-6 py-5 text-center border-b dark:border-slate-800">

                            @php

                                $statusColor = match($earning->status) {
                                    'approved' => 'bg-emerald-500',
                                    'pending' => 'bg-orange-500',
                                    'rejected' => 'bg-red-500',
                                    default => 'bg-slate-500'
                                };

                            @endphp

                            <span class="px-3 py-1 rounded-full text-white text-xs font-bold {{ $statusColor }}">

                                {{ ucfirst($earning->status) }}

                            </span>

                        </td>

                        <td class="px-6 py-5 text-center border-b dark:border-slate-800 text-sm">

                            {{ \Carbon\Carbon::parse($earning->earned_at)->format('d M Y h:i A') }}

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="6">

                            <div class="text-center py-5">

                                <div class="text-7xl mb-4">
                                    📊
                                </div>

                                <h3 class="text-2xl font-black text-slate-700 dark:text-white">
                                    No Statistics Data
                                </h3>

                                <p class="text-slate-500 mt-2">
                                    No earning history available.
                                </p>

                            </div>

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection
