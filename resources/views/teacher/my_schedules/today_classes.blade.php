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
            Today's Sections
        </li>
    </ol>

    <h6 class="mb-0 font-bold text-white">
        Today's Sections
    </h6>
</nav>
@endsection

@section('content')

<div class="w-full px-6 py-6 mx-auto">

    {{-- TOP CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-4 xl:grid-cols-4 gap-6 mb-8">

        <div class="rounded-2xl p-6 bg-gradient-to-r from-blue-500 to-cyan-400 text-white shadow-xl">
            <p class="text-sm uppercase opacity-80">
                Total Sections
            </p>

            <h2 class="text-4xl font-black mt-3">
                {{ $data['total'] }}
            </h2>
        </div>

        <div class="rounded-2xl p-6 bg-gradient-to-r from-emerald-500 to-teal-400 text-white shadow-xl">
            <p class="text-sm uppercase opacity-80">
                Live Now
            </p>

            <h2 class="text-4xl font-black mt-3">
                {{ $data['live'] }}
            </h2>
        </div>

        <div class="rounded-2xl p-6 bg-gradient-to-r from-orange-500 to-yellow-400 text-white shadow-xl">
            <p class="text-sm uppercase opacity-80">
                Upcoming
            </p>

            <h2 class="text-4xl font-black mt-3">
                {{ $data['upcoming'] }}
            </h2>
        </div>

        <div class="rounded-2xl p-6 bg-gradient-to-r from-red-600 to-purple-500 text-white shadow-xl">
            <p class="text-sm uppercase opacity-80">
                Completed
            </p>

            <h2 class="text-4xl font-black mt-3">
                {{ $data['completed'] }}
            </h2>
        </div>

    </div>

    {{-- EVENTS --}}
    <div class="space-y-6">

        @forelse($events as $event)

            <div class="rounded-2xl bg-white dark:bg-slate-900 shadow-xl border border-slate-200/50 overflow-hidden">

                <div class="p-6">

                    <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-6">

                        {{-- LEFT --}}
                        <div class="flex gap-5 items-start">

                            <div class="w-16 h-16 rounded-2xl flex items-center justify-center
                                @if($event['status'] == 'live')
                                    bg-red-500
                                @elseif($event['status'] == 'upcoming')
                                    bg-orange-500
                                @else
                                    bg-emerald-500
                                @endif
                                text-white text-2xl">

                                <i class="bi bi-camera-video-fill"></i>

                            </div>

                            <div>

                                <div class="flex flex-wrap items-center gap-3">

                                    <h4 class="text-xl font-black text-slate-800 dark:text-white">
                                        {{ $event['title'] }}
                                    </h4>

                                    <span class="px-3 py-1 rounded-full text-xs font-bold
                                        @if($event['status'] == 'live')
                                            bg-red-500 text-white
                                        @elseif($event['status'] == 'upcoming')
                                            bg-orange-100 text-orange-600
                                        @else
                                            bg-emerald-100 text-emerald-600
                                        @endif">

                                        {{ strtoupper($event['status']) }}

                                    </span>

                                </div>

                                <p class="text-sm text-slate-500 mt-2">
                                    {{ $event['description'] }}
                                </p>

                                <div class="flex flex-wrap gap-5 mt-5 text-sm">

                                    <div>
                                        <span class="font-bold text-slate-700">
                                            Type :
                                        </span>

                                        <span class="text-blue-500 font-bold">
                                            {{ $event['type'] }}
                                        </span>
                                    </div>

                                    <div>
                                        <span class="font-bold text-slate-700">
                                            Students :
                                        </span>

                                        <span class="text-emerald-500 font-bold">
                                            {{ $event['students_count'] }}
                                        </span>
                                    </div>

                                </div>

                            </div>

                        </div>

                        {{-- RIGHT --}}
                        <div class="xl:text-right">

                            <div class="text-sm text-slate-500">
                                Start Time
                            </div>

                            <h5 class="font-black text-lg text-slate-800 dark:text-white">
                                {{ $event['start_time']->format('d M Y h:i A') }}
                            </h5>

                            <div class="text-sm text-slate-500 mt-3">
                                End Time
                            </div>

                            <h5 class="font-black text-lg text-slate-800 dark:text-white">
                                {{ $event['end_time']->format('d M Y h:i A') }}
                            </h5>

                            <div class="flex xl:justify-end gap-3 mt-5">

                                @if($event['meeting_link'])

                                <a href="{{ $event['meeting_link'] }}"
                                    target="_blank"
                                    class="px-5 py-2 rounded-2xl bg-blue-500 text-white text-sm font-bold">

                                    Join Class

                                </a>

                                @endif

                                @if($event['recording_url'])

                                <a href="{{ $event['recording_url'] }}"
                                    target="_blank"
                                    class="px-5 py-2 rounded-2xl bg-emerald-500 text-white text-sm font-bold">

                                    Recording

                                </a>

                                @endif

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        @empty

            <div class="rounded-2xl bg-white dark:bg-slate-900 py-5 text-center shadow-xl">

                <div class="text-7xl mb-5">
                    📅
                </div>

                <h3 class="text-2xl font-black text-slate-700 dark:text-white">
                    No Sections Today
                </h3>

                <p class="text-slate-500 mt-2">
                    No scheduled classes or webinars found for today.
                </p>

            </div>

        @endforelse

    </div>

</div>

@endsection
