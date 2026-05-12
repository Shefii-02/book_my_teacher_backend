@extends('layouts.teacher')

@section('nav-options')
    <nav>
        <div class="flex mt-4 items-center justify-between flex-wrap gap-3">
            <div>
                <h3 class="mb-0 font-black text-white capitalize text-2xl tracking-wide">
                    Welcome Back 👋
                </h3>

                <p class="text-white/70 text-sm mt-1">
                    Monitor your teaching performance & earnings.
                </p>
            </div>


        </div>
    </nav>
@endsection

@section('content')
    <div class="w-full px-6 py-1 mx-auto">

        @if ($profileCompletion['total_percentage'] < 100)
            {{-- PROFILE COMPLETION CARD --}}
            {{-- DROPDOWN PROFILE COMPLETION CARD --}}
            <div
                class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-purple-500 via-teal-500 to-cyan-500 shadow-[0_20px_60px_rgba(16,185,129,0.35)] p-6 text-white">

                {{-- glass body --}}
                <div class="relative">

                    {{-- glow --}}
                    <div class="absolute -top-20 -right-20 w-72 h-72 bg-emerald-400/20 rounded-full blur-3xl"></div>

                    <div class="absolute -bottom-20 -left-20 w-72 h-72 bg-cyan-400/20 rounded-full blur-3xl"></div>

                    <div class="relative text-white">

                        {{-- TOP --}}
                        <div class="flex items-center justify-between">

                            <div>
                                <p class="text-xs uppercase tracking-[4px] text-white/60 font-bold">
                                    Profile Completion
                                </p>

                                <div class="flex items-end gap-3 mt-4">

                                    <h3
                                        class="text-6xl font-black bg-gradient-to-r from-white via-emerald-200 to-cyan-200 bg-clip-text  leading-none">
                                        {{ $profileCompletion['total_percentage'] ?? 0 }}%
                                    </h3>


                                </div>

                                <p class="text-white/50 text-sm">
                                    Almost done. Complete remaining steps.
                                </p>
                            </div>

                            {{-- dropdown btn --}}
                            <a href="{{ route('teacher.settings.index') }}"
                                class="w-10 h-10 rounded-2xl bg-white/10 border border-white/10 backdrop-blur-xl flex items-center justify-center hover:bg-white/20 transition-all duration-300">

                                <i class="text-xs text-white transition-all duration-300 bi bi-pencil">
                                </i>
                            </a>
                        </div>


                    </div>

                </div>

            </div>
        @endif

        {{-- ================= TOP CARDS ================= --}}
        <div class="grid grid-cols-1 md:grid-cols-4 xl:grid-cols-4 gap-6 mt-3">

            {{-- CARD --}}
            <div
                class="relative overflow-hidden rounded-2xl  bg-gradient-to-br from-violet-600 via-indigo-600 to-blue-600 shadow-[0_20px_60px_rgba(79,70,229,0.4)]  dark:bg-slate-900/60 backdrop-blur-2xl border border-white/20 shadow-[0_20px_60px_rgba(0,0,0,0.12)] group hover:-translate-y-2 transition-all duration-500">

                <div
                    class="absolute -top-10 -right-10 w-32 h-32 bg-blue-500/20 rounded-full blur-3xl group-hover:scale-125 transition-all duration-500">
                </div>

                <div class="relative p-6">

                    <div class="flex items-center justify-between">

                        <div>
                            <p class="text-xs uppercase tracking-widest text-slate-500 dark:text-white/60 font-bold">
                                Total Courses
                            </p>

                            <h2 class="mt-4 text-4xl font-black text-slate-800 dark:text-white">
                                {{ $data['courses']['total'] ?? 0 }}
                            </h2>

                            <div
                                class="mt-4 inline-flex items-center px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-bold">
                                Your Courses
                            </div>
                        </div>

                        <div
                            class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-500 to-cyan-400 flex items-center justify-center shadow-xl shadow-blue-500/30">
                            <i class="ni ni-books text-2xl text-white"></i>
                        </div>

                    </div>

                </div>
            </div>

            {{-- CARD --}}
            <div
                class="relative overflow-hidden rounded-2xl  bg-gradient-to-br from-violet-600 via-indigo-600 to-blue-600 shadow-[0_20px_60px_rgba(79,70,229,0.4)] dark:bg-slate-900/60 backdrop-blur-2xl border border-white/20 shadow-[0_20px_60px_rgba(0,0,0,0.12)] group hover:-translate-y-2 transition-all duration-500">

                <div
                    class="absolute -top-10 -right-10 w-32 h-32 bg-pink-500/20 rounded-full blur-3xl group-hover:scale-125 transition-all duration-500">
                </div>

                <div class="relative p-6">

                    <div class="flex items-center justify-between">

                        <div>
                            <p class="text-xs uppercase tracking-widest text-slate-500 dark:text-white/60 font-bold">
                                Referrals
                            </p>

                            <h2 class="mt-4 text-4xl font-black text-slate-800 dark:text-white">
                                {{ $data['referral']['total'] ?? 0 }}
                            </h2>

                            <div
                                class="mt-4 inline-flex items-center px-3 py-1 rounded-full bg-pink-100 text-pink-700 text-xs font-bold">
                                Active Invites
                            </div>
                        </div>

                        <div
                            class="w-16 h-16 rounded-2xl bg-gradient-to-br from-pink-500 to-rose-400 flex items-center justify-center shadow-xl shadow-pink-500/30">
                            <i class="ni ni-single-02 text-2xl text-white"></i>
                        </div>

                    </div>

                </div>
            </div>

            {{-- CARD --}}
            <div
                class="relative overflow-hidden rounded-2xl  bg-gradient-to-br from-violet-600 via-indigo-600 to-blue-600 shadow-[0_20px_60px_rgba(79,70,229,0.4)] dark:bg-slate-900/60 backdrop-blur-2xl border border-white/20 shadow-[0_20px_60px_rgba(0,0,0,0.12)] group hover:-translate-y-2 transition-all duration-500">

                <div
                    class="absolute -top-10 -right-10 w-32 h-32 bg-emerald-500/20 rounded-full blur-3xl group-hover:scale-125 transition-all duration-500">
                </div>

                <div class="relative p-6">

                    <div class="flex items-center justify-between">

                        <div>
                            <p class="text-xs uppercase tracking-widest text-slate-500 dark:text-white/60 font-bold">
                                Total Coins
                            </p>

                            <h2 class="mt-4 text-4xl font-black text-slate-800 dark:text-white">
                                {{ $data['coins']['total'] ?? 0 }}
                            </h2>

                            <div
                                class="mt-4 inline-flex items-center px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-bold">
                                Reward Coins
                            </div>

                        </div>

                        <div
                            class="w-16 h-16 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-400 flex items-center justify-center shadow-xl shadow-emerald-500/30">
                            <i class="ni ni-diamond text-2xl text-white"></i>
                        </div>

                    </div>

                </div>
            </div>

            {{-- CARD --}}
            <div
                class="relative overflow-hidden rounded-2xl  bg-gradient-to-br from-violet-600 via-indigo-600 to-blue-600 shadow-[0_20px_60px_rgba(79,70,229,0.4)] dark:bg-slate-900/60 backdrop-blur-2xl border border-white/20 shadow-[0_20px_60px_rgba(0,0,0,0.12)] group hover:-translate-y-2 transition-all duration-500">

                <div
                    class="absolute -top-10 -right-10 w-32 h-32 bg-orange-500/20 rounded-full blur-3xl group-hover:scale-125 transition-all duration-500">
                </div>

                <div class="relative p-6">

                    <div class="flex items-center justify-between">

                        <div>
                            <p class="text-xs uppercase tracking-widest text-slate-500 dark:text-white/60 font-bold">
                                Total Earnings
                            </p>

                            <h2 class="mt-4 text-4xl font-black text-slate-800 dark:text-white">
                                ₹{{ number_format($data['earns']['total'] ?? 0) }}
                            </h2>

                            <div
                                class="mt-4 inline-flex items-center px-3 py-1 rounded-full bg-orange-100 text-orange-700 text-xs font-bold">
                                Revenue Growth
                            </div>
                        </div>

                        <div
                            class="w-16 h-16 rounded-2xl bg-gradient-to-br from-orange-500 to-yellow-400 flex items-center justify-center shadow-xl shadow-orange-500/30">
                            <i class="ni ni-money-coins text-2xl text-white"></i>
                        </div>

                    </div>

                </div>
            </div>

        </div>

        {{-- ================= CHART SECTION ================= --}}
        {{-- ================= CHART SECTION ================= --}}
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mt-8">

            {{-- MAIN CHART --}}
            <div
                class="xl:col-span-2 rounded-3xl overflow-hidden bg-white/30 dark:bg-slate-900/60 backdrop-blur-2xl border border-white/20 shadow-[0_20px_60px_rgba(0,0,0,0.12)]">

                <div class="p-6 border-b border-slate-200/20">

                    <div class="flex items-center justify-between flex-wrap gap-4">

                        <div>

                            <h3 class="text-xl font-black text-slate-800 dark:text-white">
                                Earnings Analytics
                            </h3>

                            <p class="text-sm text-slate-500 dark:text-white/60 mt-1">
                                Last 6 months & yearly earnings report
                            </p>

                        </div>

                        {{-- SWITCH BUTTONS --}}
                        <div class="flex gap-2">

                            <button id="monthlyBtn"
                                class="chart-btn px-4 py-2 rounded-xl bg-blue-500 text-white text-sm font-bold shadow-lg shadow-blue-500/30">

                                Last 6 Months

                            </button>

                            <button id="yearlyBtn"
                                class="chart-btn px-4 py-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-white text-sm font-bold">

                                Yearly

                            </button>

                        </div>

                    </div>

                </div>

                {{-- CHART --}}
                <div class="p-6">

                    <div id="teacherChart" class="w-full h-[350px]"></div>

                </div>

            </div>

            {{-- SIDE PROFILE CARD --}}
            <div
                class="rounded-3xl overflow-hidden bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900 shadow-[0_20px_60px_rgba(0,0,0,0.25)] relative">

                <div class="absolute inset-0 bg-dark/30 backdrop-blur-md"></div>

                <div class="relative p-7 text-white">

                    {{-- STATS --}}
                    <div class="grid grid-cols-4 gap-4">

                        <div
                            class="flex items-center justify-between p-4 rounded-2xl bg-gradient-to-r from-emerald-500 to-violet-500 border border-white/10">

                            <div>

                                <p class="text-white/60 text-xs uppercase">
                                    Rating
                                </p>

                                <h4 class="font-black text-xl mt-1">
                                    {{ $data['rating']['average'] }} ★
                                </h4>

                            </div>

                            <i class="ni ni-favourite-28 text-yellow-400 text-2xl"></i>

                        </div>

                        <div
                            class="flex items-center justify-between p-4 rounded-2xl bg-gradient-to-r from-blue-500 to-violet-500 border border-white/10">

                            <div>

                                <p class="text-white/60 text-xs uppercase">
                                    Students
                                </p>

                                <h4 class="font-black text-xl mt-1">
                                    {{ $data['students']['total'] }}
                                </h4>

                            </div>

                            <i class="ni ni-hat-3 text-white text-2xl"></i>

                        </div>

                        <div
                            class="flex items-center justify-between p-4 rounded-2xl bg-gradient-to-r from-slate-600 to-violet-500 border border-white/10">

                            <div>

                                <p class="text-white/60 text-xs uppercase">
                                    Courses
                                </p>

                                <h4 class="font-black text-xl mt-1">
                                    {{ $data['courses']['total'] }}
                                </h4>

                            </div>

                            <i class="ni ni-books text-white text-2xl"></i>

                        </div>

                        <div
                            class="flex items-center justify-between p-4 rounded-2xl bg-gradient-to-r from-orange-500 to-violet-500 border border-white/10">

                            <div>

                                <p class="text-white/60 text-xs uppercase">
                                    Referrals
                                </p>

                                <h4 class="font-black text-xl mt-1">
                                    {{ $data['referral']['total'] }}
                                </h4>

                            </div>

                            <i class="ni ni-single-02 text-white text-2xl"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>
        {{-- ================= LOWER SECTION ================= --}}

<!--
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-8">

            {{-- VISIT ANALYTICS --}}
            <div
                class="rounded-3xl bg-white/30 dark:bg-slate-900/60 backdrop-blur-2xl border border-white/20 shadow-[0_20px_60px_rgba(0,0,0,0.12)] p-6">

                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-black text-slate-800 dark:text-white">
                        Visit Analytics
                    </h3>

                    <div
                        class="w-10 h-10 rounded-2xl bg-gradient-to-br from-blue-500 to-cyan-400 flex items-center justify-center">
                        <i class="ni ni-chart-bar-32 text-white"></i>
                    </div>
                </div>

                <div class="space-y-5">

                    <div>
                        <div class="flex justify-between mb-2">
                            <span class="text-sm font-semibold text-slate-700 dark:text-white">
                                Profile Visits
                            </span>

                            <span class="text-sm font-black text-blue-500">
                                82%
                            </span>
                        </div>

                        <div class="w-full h-3 rounded-full bg-slate-200 dark:bg-slate-700 overflow-hidden">
                            <div class="h-full w-[82%] rounded-full bg-gradient-to-r from-blue-500 to-cyan-400"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between mb-2">
                            <span class="text-sm font-semibold text-slate-700 dark:text-white">
                                Course Views
                            </span>

                            <span class="text-sm font-black text-pink-500">
                                65%
                            </span>
                        </div>

                        <div class="w-full h-3 rounded-full bg-slate-200 dark:bg-slate-700 overflow-hidden">
                            <div class="h-full w-[65%] rounded-full bg-gradient-to-r from-pink-500 to-rose-400"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between mb-2">
                            <span class="text-sm font-semibold text-slate-700 dark:text-white">
                                Demo Bookings
                            </span>

                            <span class="text-sm font-black text-emerald-500">
                                92%
                            </span>
                        </div>

                        <div class="w-full h-3 rounded-full bg-slate-200 dark:bg-slate-700 overflow-hidden">
                            <div class="h-full w-[92%] rounded-full bg-gradient-to-r from-emerald-500 to-teal-400">
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            {{-- Recent Courses --}}
            <div
                class="rounded-3xl bg-white/30 dark:bg-slate-900/60 backdrop-blur-2xl border border-white/20 shadow-[0_20px_60px_rgba(0,0,0,0.12)] p-6">

                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-black text-slate-800 dark:text-white">
                        My Recent Courses
                    </h3>

                    <i class="ni ni-zoom-split-in text-xl text-blue-500"></i>
                </div>

                <div class="space-y-4">

                    @foreach (['Mathematics', 'English', 'Science', 'Programming'] as $subject)
                        <div
                            class="flex items-center justify-between  rounded-2xl bg-slate-50 dark:bg-slate-800/50 hover:scale-[1.02] transition-all duration-300">

                            <div class="flex items-center gap-3">

                                <div
                                    class="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-500 to-cyan-400 flex items-center justify-center text-white font-black">
                                    {{ substr($subject, 0, 1) }}
                                </div>

                                <div>
                                    <h6 class="font-bold text-slate-800 dark:text-white">
                                        {{ $subject }}
                                    </h6>

                                    <p class="text-xs text-slate-500 dark:text-white/60">
                                        Trending Subject
                                    </p>
                                </div>

                            </div>

                            <i class="ni ni-bold-right text-slate-400"></i>

                        </div>
                    @endforeach

                </div>

            </div>

            {{-- PERFORMANCE --}}
            <div
                class="rounded-3xl bg-gradient-to-br from-violet-600 via-indigo-600 to-blue-600 shadow-[0_20px_60px_rgba(79,70,229,0.4)] p-6 text-white relative overflow-hidden">

                <div class="absolute -top-20 -right-20 w-60 h-60 rounded-full bg-white/10"></div>

                <div class="relative">

                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-black">
                            Performance
                        </h3>

                        <i class="ni ni-trophy text-3xl text-yellow-300"></i>
                    </div>

                    <div class="mt-8">

                        <h1 class="text-6xl font-black">
                            98%
                        </h1>

                        <p class="mt-2 text-white/70">
                            Excellent teaching performance this month
                        </p>

                    </div>

                    <div class="mt-10 space-y-4">

                        <div class="flex justify-between">
                            <span class="text-white/70">
                                Student Satisfaction
                            </span>

                            <span class="font-bold">
                                95%
                            </span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-white/70">
                                Course Completion
                            </span>

                            <span class="font-bold">
                                91%
                            </span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-white/70">
                                Attendance
                            </span>

                            <span class="font-bold">
                                99%
                            </span>
                        </div>

                    </div>

                </div>

            </div>

        </div>
-->
{{-- ================= LOWER SECTION ================= --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-8">

    {{-- VISIT ANALYTICS --}}
    <div
        class="rounded-3xl bg-white/30 dark:bg-slate-900/60 backdrop-blur-2xl border border-white/20 shadow-[0_20px_60px_rgba(0,0,0,0.12)] p-6">

        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-black text-slate-800 dark:text-white">
                Visit Analytics
            </h3>

            <div
                class="w-10 h-10 rounded-2xl bg-gradient-to-br from-blue-500 to-cyan-400 flex items-center justify-center">
                <i class="ni ni-chart-bar-32 text-white"></i>
            </div>
        </div>

        <div class="space-y-5">

            {{-- Profile Completion --}}
            <div>

                <div class="flex justify-between mb-2">

                    <span class="text-sm font-semibold text-slate-700 dark:text-white">
                        Profile Completion
                    </span>

                    <span class="text-sm font-black text-blue-500">
                        {{ $profileCompletion['total_percentage'] }}%
                    </span>

                </div>

                <div class="w-full h-3 rounded-full bg-slate-200 dark:bg-slate-700 overflow-hidden">

                    <div class="h-full rounded-full bg-gradient-to-r from-blue-500 to-cyan-400"
                        style="width: {{ $profileCompletion['total_percentage'] }}%">
                    </div>

                </div>

            </div>

            {{-- Students --}}
            <div>

                <div class="flex justify-between mb-2">

                    <span class="text-sm font-semibold text-slate-700 dark:text-white">
                        Student Engagement
                    </span>

                    <span class="text-sm font-black text-pink-500">
                        {{ min($data['students']['total'], 100) }}%
                    </span>

                </div>

                <div class="w-full h-3 rounded-full bg-slate-200 dark:bg-slate-700 overflow-hidden">

                    <div class="h-full rounded-full bg-gradient-to-r from-pink-500 to-rose-400"
                        style="width: {{ min($data['students']['total'], 100) }}%">
                    </div>

                </div>

            </div>

            {{-- Earnings --}}
            <div>

                <div class="flex justify-between mb-2">

                    <span class="text-sm font-semibold text-slate-700 dark:text-white">
                        Earnings Growth
                    </span>

                    <span class="text-sm font-black text-emerald-500">
                        {{ $data['earns']['total'] > 0 ? '92' : '10' }}%
                    </span>

                </div>

                <div class="w-full h-3 rounded-full bg-slate-200 dark:bg-slate-700 overflow-hidden">

                    <div class="h-full rounded-full bg-gradient-to-r from-emerald-500 to-teal-400"
                        style="width: {{ $data['earns']['total'] > 0 ? '92' : '10' }}%">
                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- Recent Courses --}}
    <div
        class="rounded-3xl bg-white/30 dark:bg-slate-900/60 backdrop-blur-2xl border border-white/20 shadow-[0_20px_60px_rgba(0,0,0,0.12)] p-6">

        <div class="flex items-center justify-between mb-6">

            <h3 class="text-lg font-black text-slate-800 dark:text-white">
                My Recent Courses
            </h3>

            <i class="ni ni-collection text-xl text-blue-500"></i>

        </div>

        <div class="space-y-4">

            @forelse ($topCourses as $course)
                <div
                    class="flex items-center justify-between p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/50 hover:scale-[1.02] transition-all duration-300">

                    <div class="flex items-center gap-3">

                        <div
                            class="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-500 to-cyan-400 flex items-center justify-center text-white font-black">

                            {{ strtoupper(substr($course->title, 0, 1)) }}

                        </div>

                        <div>

                            <h6 class="font-bold text-slate-800 dark:text-white">
                                {{ $course->title }}
                            </h6>

                            <p class="text-xs text-slate-500 dark:text-white/60">

                                {{ $course->enrollments_count ?? 0 }}
                                Students

                            </p>

                        </div>

                    </div>

                    <i class="ni ni-bold-right text-slate-400"></i>

                </div>

            @empty

                <div class="text-center py-10">

                    <i class="ni ni-books text-5xl text-slate-300"></i>

                    <p class="mt-3 text-sm text-slate-500 dark:text-white/50">
                        No courses found
                    </p>

                </div>

            @endforelse

        </div>

    </div>

    {{-- PERFORMANCE --}}
    <div
        class="rounded-3xl bg-gradient-to-br from-violet-600 via-indigo-600 to-blue-600 shadow-[0_20px_60px_rgba(79,70,229,0.4)] p-6 text-white relative overflow-hidden">

        <div class="absolute -top-20 -right-20 w-60 h-60 rounded-full bg-white/10"></div>

        <div class="relative">

            <div class="flex items-center justify-between">

                <h3 class="text-xl font-black">
                    Performance
                </h3>

                <i class="ni ni-trophy text-3xl text-yellow-300"></i>

            </div>

            <div class="mt-8">

                <h1 class="text-6xl font-black">

                    {{ $profileCompletion['total_percentage'] }}%

                </h1>

                <p class="mt-2 text-white/70">

                    Teacher profile & activity performance

                </p>

            </div>

            <div class="mt-10 space-y-4">

                <div class="flex justify-between">

                    <span class="text-white/70">
                        Student Satisfaction
                    </span>

                    <span class="font-bold">
                        {{ $data['rating']['average'] }}/5
                    </span>

                </div>

                <div class="flex justify-between">

                    <span class="text-white/70">
                        Total Courses
                    </span>

                    <span class="font-bold">
                        {{ $data['courses']['total'] }}
                    </span>

                </div>

                <div class="flex justify-between">

                    <span class="text-white/70">
                        Total Students
                    </span>

                    <span class="font-bold">
                        {{ $data['students']['total'] }}
                    </span>

                </div>

                <div class="flex justify-between">

                    <span class="text-white/70">
                        Total Earnings
                    </span>

                    <span class="font-bold">
                        ₹{{ number_format($data['earns']['total'], 2) }}
                    </span>

                </div>

            </div>

        </div>

    </div>

</div>
    </div>


@endsection


@push('scripts')

{{-- ================= APEX CHART ================= --}}
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>

    document.addEventListener("DOMContentLoaded", function () {

        // =========================================
        // DATA
        // =========================================

        let monthlyLabels = @json($last6MonthLabels);

        let monthlyData = @json($last6MonthData);

        let yearlyLabels = @json($yearLabels);

        let yearlyData = @json($yearData);

        // =========================================
        // CHART OPTIONS
        // =========================================

        let options = {

            series: [{
                name: 'Earnings',
                data: monthlyData
            }],

            chart: {
                type: 'area',
                height: 350,
                toolbar: {
                    show: false
                }
            },

            colors: ['#3b82f6'],

            stroke: {
                curve: 'smooth',
                width: 4
            },

            dataLabels: {
                enabled: false
            },

            xaxis: {
                categories: monthlyLabels
            },

            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.45,
                    opacityTo: 0.05,
                }
            },

            grid: {
                borderColor: '#e5e7eb',
                strokeDashArray: 5
            },

            tooltip: {
                y: {
                    formatter: function (val) {
                        return "₹ " + val;
                    }
                }
            }

        };

        // =========================================
        // INIT CHART
        // =========================================

        let chart = new ApexCharts(
            document.querySelector("#teacherChart"),
            options
        );

        chart.render();

        // =========================================
        // MONTHLY BUTTON
        // =========================================

        $('#monthlyBtn').click(function () {

            chart.updateOptions({

                xaxis: {
                    categories: monthlyLabels
                },

                series: [{
                    data: monthlyData
                }]

            });

            $('.chart-btn')
                .removeClass('bg-blue-500 text-white shadow-lg shadow-blue-500/30')
                .addClass('bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-white');

            $(this)
                .removeClass('bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-white')
                .addClass('bg-blue-500 text-white shadow-lg shadow-blue-500/30');

        });

        // =========================================
        // YEARLY BUTTON
        // =========================================

        $('#yearlyBtn').click(function () {

            chart.updateOptions({

                xaxis: {
                    categories: yearlyLabels
                },

                series: [{
                    data: yearlyData
                }]

            });

            $('.chart-btn')
                .removeClass('bg-blue-500 text-white shadow-lg shadow-blue-500/30')
                .addClass('bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-white');

            $(this)
                .removeClass('bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-white')
                .addClass('bg-blue-500 text-white shadow-lg shadow-blue-500/30');

        });

    });

</script>

@endpush
