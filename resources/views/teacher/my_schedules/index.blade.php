@extends('layouts.teacher')

@section('nav-options')

<nav>

    <ol class="flex flex-wrap pt-1 bg-transparent rounded-lg">

        <li class="text-sm">
            <a class="text-white" href="#">Home</a>
        </li>

        <li class="text-sm pl-2 text-white before:content-['/'] before:pr-2">
            Dashboard
        </li>

        <li class="text-sm pl-2 font-bold text-white before:content-['/'] before:pr-2">
            My Schedules
        </li>

    </ol>

    <h6 class="mb-0 font-bold text-white capitalize">
        My Schedules
    </h6>

</nav>

@endsection


@section('content')

<div class="w-full px-6 py-6 mx-auto">

    {{-- =========================
        TOP CARDS
    ========================== --}}

    <div class="grid grid-cols-1 md:grid-cols-4 xl:grid-cols-5 gap-6 mb-8">

        {{-- TOTAL --}}
        <div class="rounded-2xl p-6 bg-gradient-to-br from-blue-700 toast-info text-white shadow-2xl">

            <div class="flex justify-between items-center">

                <div>

                    <p class="text-white/70 text-xs uppercase">
                        Total Schedules
                    </p>

                    <h2 class="text-4xl font-black mt-2">
                        {{ $data['total'] }}
                    </h2>

                </div>

                <i class="bi bi-calendar2-week text-4xl"></i>

            </div>

        </div>

        {{-- TODAY --}}
        <div class="rounded-2xl p-6 bg-gradient-to-br from-emerald-500 to-teal-400 text-white shadow-2xl">

            <div class="flex justify-between items-center">

                <div>

                    <p class="text-white/70 text-xs uppercase">
                        Today
                    </p>

                    <h2 class="text-4xl font-black mt-2">
                        {{ $data['today'] }}
                    </h2>

                </div>

                <i class="bi bi-calendar-day text-4xl"></i>

            </div>

        </div>

        {{-- UPCOMING --}}
        <div class="rounded-2xl p-6 bg-gradient-to-br from-orange-500 to-amber-400 text-white shadow-2xl">

            <div class="flex justify-between items-center">

                <div>

                    <p class="text-white/70 text-xs uppercase">
                        Upcoming/Live
                    </p>

                    <h2 class="text-4xl font-black mt-2">
                        {{ $data['upcoming'] + $data['live'] }}
                    </h2>

                </div>

                <i class="bi bi-clock-history text-4xl"></i>

            </div>

        </div>


        {{-- COMPLETED --}}
        <div class="rounded-2xl p-6 bg-gradient-to-br from-pink-500 to-rose-500 text-white shadow-2xl">

            <div class="flex justify-between items-center">

                <div>

                    <p class="text-white/70 text-xs uppercase">
                        Completed
                    </p>

                    <h2 class="text-4xl font-black mt-2">
                        {{ $data['completed'] }}
                    </h2>

                </div>

                <i class="bi bi-check-circle text-4xl"></i>

            </div>

        </div>

    </div>

    {{-- =========================
        TABLE SECTION
    ========================== --}}

    <div class="rounded-2xl overflow-hidden bg-white dark:bg-slate-900 shadow-2xl">

        {{-- HEADER --}}
        <div class="p-6 border-b border-slate-100 dark:border-slate-800">

            <div class="flex items-center justify-between flex-wrap gap-4">

                <div>

                    <h5 class="text-2xl font-black text-slate-800 dark:text-white">
                        Schedule Timeline
                    </h5>

                    <p class="text-slate-500 text-sm mt-1">
                        Upcoming webinars, classes, demos & workshops
                    </p>

                </div>

            </div>

        </div>

        {{-- TABLE --}}
        <div class="overflow-x-auto">

            <table class="w-full min-w-[1400px]">

                <thead class="bg-slate-50 dark:bg-slate-800">

                    <tr>

                        <th class="px-6 py-4 text-left text-xs font-black uppercase text-slate-500">
                            Schedule
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-black uppercase text-slate-500">
                            Event
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-black uppercase text-slate-500">
                            Type
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-black uppercase text-slate-500">
                            Time
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-black uppercase text-slate-500">
                            Students
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-black uppercase text-slate-500">
                            Mode
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-black uppercase text-slate-500">
                            Join
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($events as $event)

                    <tr class="border-b border-slate-100 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800/30 transition">

                        {{-- DATE --}}
                        <td class="px-6 py-5">

                            <div class="font-bold text-slate-800 dark:text-white">
                                {{ $event['schedule_date'] }}
                            </div>

                        </td>

                        {{-- EVENT --}}
                        <td class="px-6 py-5">

                            <div class="flex items-start gap-4">

                                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-500 to-cyan-400 flex items-center justify-center text-white shadow-lg">

                                    <i class="bi bi-play-circle text-xl"></i>

                                </div>

                                <div>

                                    <h4 class="font-bold text-slate-800 dark:text-white">
                                        {{ $event['title'] }}
                                    </h4>

                                    <p class="text-xs text-slate-500 mt-1 max-w-[280px]">
                                        {{ Str::limit($event['description'], 80) }}
                                    </p>

                                </div>

                            </div>

                        </td>

                        {{-- TYPE --}}
                        <td class="px-6 py-5">

                            <span class="px-4 py-2 rounded-full bg-blue-100 text-blue-600 text-xs font-bold">
                                {{ $event['type'] }}
                            </span>

                        </td>

                        {{-- TIME --}}
                        <td class="px-6 py-5">

                            <div class="text-sm font-bold text-slate-700 dark:text-white">
                                {{ $event['started_at'] }}
                            </div>

                            <div class="text-xs text-slate-500 mt-1">
                                To {{ $event['ended_at'] }}
                            </div>

                        </td>

                        {{-- STUDENTS --}}
                        <td class="px-6 py-5">

                            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl bg-emerald-50 text-emerald-600 font-bold">

                                <i class="bi bi-people-fill"></i>

                                {{ $event['students_count'] }}

                            </div>

                        </td>

                        {{-- MODE --}}
                        <td class="px-6 py-5">

                            <div class="font-semibold text-slate-700 dark:text-white capitalize">
                                {{ $event['mode'] }}
                            </div>

                            <div class="text-xs text-slate-500">
                                {{ $event['source'] }}
                            </div>

                        </td>

                        {{-- JOIN --}}
                        <td class="px-6 py-5">

                            @if($event['class_link'])

                            <div class="flex items-center gap-3">

                                <a href="{{ $event['class_link'] }}"
                                   target="_blank"
                                   class="px-5 py-3 rounded-2xl bg-gradient-to-r from-blue-500 to-cyan-400 text-white text-sm font-bold shadow-lg hover:scale-105 transition">

                                    Join Now

                                </a>

                                <button
                                    onclick="copyPageLink(`{{ $event['class_link'] }}`)"
                                    class="w-12 h-12 rounded-2xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center hover:scale-110 transition">

                                    <i class="bi bi-copy"></i>

                                </button>

                            </div>

                            @else

                            <span class="text-slate-400 text-sm">
                                No Link
                            </span>

                            @endif

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="7" class="py-5 text-center">

                            <div class="flex flex-col items-center">

                                <i class="bi bi-calendar2-x text-6xl text-slate-300"></i>

                                <h4 class="mt-4 text-2xl font-black text-slate-500">
                                    No Schedule Found
                                </h4>

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
