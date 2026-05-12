@extends('layouts.teacher')

@section('nav-options')
    <nav>
        <ol class="flex flex-wrap pt-1 bg-transparent rounded-lg">
            <li class="text-sm">
                <a class="text-white" href="javascript:;">Home</a>
            </li>

            <li
                class="text-sm pl-2 text-white before:float-left before:pr-2 before:text-white before:content-['/']">
                <a class="text-white" href="{{ route('teacher.dashboard.index') }}">
                    Dashboard
                </a>
            </li>

            <li
                class="text-sm pl-2 font-bold text-white before:float-left before:pr-2 before:text-white before:content-['/']">
                Demo Scheduled Classes
            </li>
        </ol>

        <h6 class="mb-0 font-bold text-white">
            Demo Scheduled Classes
        </h6>
    </nav>
@endsection

@section('content')
    <div class="w-full px-6 py-6 mx-auto">

        {{-- ===================== STATS ===================== --}}
        <div class="grid grid-cols-1 md:grid-cols-4 xl:grid-cols-5 gap-5 mb-8">

            {{-- TOTAL --}}
            <div
                class="rounded-2xl p-3 bg-gradient-to-br from-blue-700 to-cyan-500 text-white shadow-xl">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-white/70 text-xs uppercase">
                            Total Classes
                        </p>

                        <h2 class="text-3xl font-black mt-2">
                            {{ $data['total'] }}
                        </h2>
                    </div>

                    <div
                        class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center">
                        <i class="bi bi-camera-video text-2xl"></i>
                    </div>
                </div>
            </div>

            {{-- COMPLETED --}}
            <div
                class="rounded-2xl p-3 bg-gradient-to-br from-emerald-500 to-teal-400 text-white shadow-xl">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-white/70 text-xs uppercase">
                            Completed
                        </p>

                        <h2 class="text-3xl font-black mt-2">
                            {{ $data['completed'] }}
                        </h2>
                    </div>

                    <div
                        class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center">
                        <i class="bi bi-check-circle text-2xl"></i>
                    </div>
                </div>
            </div>

            {{-- UPCOMING --}}
            <div
                class="rounded-2xl p-3 bg-gradient-to-br from-cyan-400 to-blue-500 text-white shadow-xl">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-white/70 text-xs uppercase">
                            Upcoming/Ongoing
                        </p>

                        <h2 class="text-3xl font-black mt-2">
                            {{ $data['upcoming'] + $data['ongoing'] }}
                        </h2>
                    </div>

                    <div
                        class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center">
                        <i class="bi bi-calendar-event text-2xl"></i>
                    </div>
                </div>
            </div>

            {{-- CANCELLED --}}
            <div
                class="rounded-2xl p-3 bg-gradient-to-br from-red-500 to-pink-500 text-white shadow-xl">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-white/70 text-xs uppercase">
                            Cancelled
                        </p>

                        <h2 class="text-3xl font-black mt-2">
                            {{ $data['cancelled'] }}
                        </h2>
                    </div>

                    <div
                        class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center">
                        <i class="bi bi-x-circle text-2xl"></i>
                    </div>
                </div>
            </div>

        </div>

        {{-- ===================== TABLE ===================== --}}
        <div
            class="rounded-2xl bg-white dark:bg-slate-900 shadow-2xl overflow-hidden border border-slate-100 dark:border-slate-800">

            <div class="p-6 border-b border-slate-100 dark:border-slate-800">

                <div class="flex justify-between items-center flex-wrap gap-4">

                    <div>
                        <h5 class="text-2xl font-black text-slate-800 dark:text-white">
                            Demo Class Listing
                        </h5>

                        <p class="text-slate-500 text-sm mt-1">
                            Manage your scheduled demo classes
                        </p>
                    </div>

                </div>

            </div>

            <div class="overflow-x-auto">

                <table class="w-full min-w-[1200px]">

                    <thead class="bg-slate-50 dark:bg-slate-800">

                        <tr>

                            <th class="px-6 py-4 text-left text-xs font-black text-slate-500 uppercase">
                                #
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-black text-slate-500 uppercase">
                                Class
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-black text-slate-500 uppercase">
                                Started
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-black text-slate-500 uppercase">
                                Ended
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-black text-slate-500 uppercase">
                                Price
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-black text-slate-500 uppercase">
                                Participants
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-black text-slate-500 uppercase">
                                Features
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-black text-slate-500 uppercase">
                                Status
                            </th>

                            <th class="px-6 py-4 text-center text-xs font-black text-slate-500 uppercase">
                                Action
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($demoClasses as $key => $class)

                            <tr
                                class="border-b border-slate-100 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800/40 transition">

                                {{-- ID --}}
                                <td class="px-6 py-5">
                                    <div
                                        class="w-10 h-10 rounded-2xl bg-gradient-to-br from-blue-500 to-cyan-400 text-white flex items-center justify-center font-bold">
                                        {{ $key + 1 }}
                                    </div>
                                </td>

                                {{-- CLASS --}}
                                <td class="px-6 py-5">

                                    <div class="flex items-center gap-4">

                                        <img src="{{ $class->thumbnail_image }}"
                                            class="w-20 h-16 rounded-2xl object-cover shadow-lg">

                                        <div>

                                            <h4
                                                class="font-bold text-slate-800 dark:text-white">
                                                {{ $class->title }}
                                            </h4>

                                            <p
                                                class="text-xs text-slate-500 mt-1 max-w-[250px]">
                                                {{ Str::limit($class->description, 80) }}
                                            </p>

                                        </div>

                                    </div>

                                </td>

                                {{-- START --}}
                                <td class="px-6 py-5">

                                    <div class="text-sm font-semibold text-slate-700 dark:text-white">
                                        {{ dateFormat($class->started_at) }}
                                    </div>

                                    <div class="text-xs text-slate-500">
                                        {{ TimeFormat($class->started_at) }}
                                    </div>

                                </td>

                                {{-- END --}}
                                <td class="px-6 py-5">

                                    <div class="text-sm font-semibold text-slate-700 dark:text-white">
                                        {{ dateFormat($class->ended_at) }}
                                    </div>

                                    <div class="text-xs text-slate-500">
                                        {{ TimeFormat($class->ended_at) }}
                                    </div>

                                </td>

                                {{-- PRICE --}}
                                <td class="px-6 py-5">

                                    <div class="space-y-1">

                                        @if ($class->discount_price)
                                            <div class="text-xs text-red-500 line-through">
                                                {{ getPrice($class->actual_price) }}
                                            </div>
                                        @endif

                                        <div
                                            class="text-lg font-black text-emerald-500">
                                            {{ getPrice($class->net_price) }}
                                        </div>

                                    </div>

                                </td>

                                {{-- PARTICIPANTS --}}
                                <td class="px-6 py-5">

                                    <div
                                        class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl bg-blue-50 text-blue-600 font-bold">

                                        <i class="bi bi-people-fill"></i>

                                        {{ $class->max_participants }}

                                    </div>

                                </td>

                                {{-- FEATURES --}}
                                <td class="px-6 py-5">

                                    <div class="flex flex-wrap gap-2">

                                        @if ($class->is_chat_enabled)
                                            <span
                                                class="px-3 py-1 rounded-full bg-cyan-100 text-cyan-700 text-xs font-bold">
                                                Chat
                                            </span>
                                        @endif

                                        @if ($class->is_screen_share_enabled)
                                            <span
                                                class="px-3 py-1 rounded-full bg-violet-100 text-violet-700 text-xs font-bold">
                                                Screen
                                            </span>
                                        @endif

                                        @if ($class->is_whiteboard_enabled)
                                            <span
                                                class="px-3 py-1 rounded-full bg-orange-100 text-orange-700 text-xs font-bold">
                                                Whiteboard
                                            </span>
                                        @endif

                                        @if ($class->is_record_enabled)
                                            <span
                                                class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold">
                                                Recording
                                            </span>
                                        @endif

                                    </div>

                                </td>

                                {{-- STATUS --}}
                                <td class="px-6 py-5">

                                    @if ($class->status == 'published')
                                        <span
                                            class="px-4 py-2 rounded-full bg-emerald-500 text-white text-xs font-bold">
                                            Published
                                        </span>
                                    @elseif($class->status == 'cancelled')
                                        <span
                                            class="px-4 py-2 rounded-full bg-red-500 text-white text-xs font-bold">
                                            Cancelled
                                        </span>
                                    @else
                                        <span
                                            class="px-4 py-2 rounded-full bg-slate-500 text-white text-xs font-bold">
                                            Draft
                                        </span>
                                    @endif

                                </td>

                                {{-- ACTION --}}
                                <td class="px-6 py-5 text-center">

                                    <div class="flex justify-center gap-2">

                                        <a href="{{ $class->meeting_url }}"
                                            target="_blank"
                                            class="w-10 h-10 rounded-2xl bg-blue-500 text-white flex items-center justify-center hover:scale-110 transition">
                                            <i class="bi bi-camera-video-fill"></i>
                                        </a>

                                        @if ($class->recording_url)
                                            <a href="{{ $class->recording_url }}"
                                                target="_blank"
                                                class="w-10 h-10 rounded-2xl bg-emerald-500 text-white flex items-center justify-center hover:scale-110 transition">
                                                <i class="bi bi-play-circle-fill"></i>
                                            </a>
                                        @endif

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="9" class="text-center py-5">

                                    <div class="flex flex-col items-center">

                                        <i class="bi bi-camera-video-off text-6xl text-slate-300"></i>

                                        <h4
                                            class="mt-4 text-xl font-bold text-slate-500">
                                            No Demo Classes Found
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
