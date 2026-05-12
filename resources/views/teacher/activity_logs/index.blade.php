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
            Activity Logs
        </li>

    </ol>

    <h6 class="mb-0 font-bold text-white capitalize">
        Activity Logs
    </h6>

</nav>

@endsection

@section('content')

<div class="w-full px-6 py-6 mx-auto">

    {{-- TOP CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-4 xl:grid-cols-4 gap-6 mb-8">

        {{-- TOTAL LOGS --}}
        <div class="rounded-2xl bg-gradient-to-br from-blue-500 to-cyan-400 p-6 shadow-2xl text-white">

            <div class="flex justify-between">

                <div>

                    <p class="uppercase text-xs opacity-70 tracking-wider">
                        Activity Logs
                    </p>

                    <h2 class="text-4xl font-black mt-3">
                        {{ $data['total_logs'] }}
                    </h2>

                </div>

                <div class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center">
                    <i class="ni ni-active-40 text-2xl"></i>
                </div>

            </div>

        </div>

        {{-- LOGIN --}}
        <div class="rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-400 p-6 shadow-2xl text-white">

            <div class="flex justify-between">

                <div>

                    <p class="uppercase text-xs opacity-70 tracking-wider">
                        Login Activities
                    </p>

                    <h2 class="text-4xl font-black mt-3">
                        {{ $data['total_logins'] }}
                    </h2>

                </div>

                <div class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center">
                    <i class="ni ni-key-25 text-2xl"></i>
                </div>

            </div>

        </div>

        {{-- EVENTS --}}
        <div class="rounded-2xl bg-gradient-to-br from-orange-500 to-yellow-400 p-6 shadow-2xl text-white">

            <div class="flex justify-between">

                <div>

                    <p class="uppercase text-xs opacity-70 tracking-wider">
                        Events
                    </p>

                    <h2 class="text-4xl font-black mt-3">
                        {{ $data['total_events'] }}
                    </h2>

                </div>

                <div class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center">
                    <i class="ni ni-world text-2xl"></i>
                </div>

            </div>

        </div>

        {{-- TODAY --}}
        <div class="rounded-2xl bg-gradient-to-br from-violet-500 to-purple-500 p-6 shadow-2xl text-white">

            <div class="flex justify-between">

                <div>

                    <p class="uppercase text-xs opacity-70 tracking-wider">
                        Today Activities
                    </p>

                    <h2 class="text-4xl font-black mt-3">
                        {{ $data['today_activities'] }}
                    </h2>

                </div>

                <div class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center">
                    <i class="ni ni-time-alarm text-2xl"></i>
                </div>

            </div>

        </div>

    </div>

    {{-- TIMELINE --}}
    <div class="rounded-3xl bg-white dark:bg-slate-900 shadow-2xl overflow-hidden">

        <div class="p-6 border-b border-slate-100 dark:border-slate-800">

            <h6 class="text-2xl font-black text-slate-800 dark:text-white">
                Activity Timeline
            </h6>

            <p class="text-slate-500 text-sm mt-1">
                User activity, login history & events
            </p>

        </div>

        <div class="p-6">

            @forelse($activities as $activity)

            <div class="relative pl-10 pb-10 border-l border-slate-200 dark:border-slate-700">

                {{-- ICON --}}
                <div class="absolute -left-5 top-0 w-10 h-10 rounded-2xl
                    @if($activity['color'] == 'blue')
                        bg-blue-500
                    @elseif($activity['color'] == 'emerald')
                        bg-emerald-500
                    @elseif($activity['color'] == 'orange')
                        bg-orange-500
                    @else
                        bg-violet-500
                    @endif
                    text-white flex items-center justify-center shadow-xl">

                    <i class="{{ $activity['icon'] }}"></i>

                </div>

                {{-- CONTENT --}}
                <div class="bg-slate-50 dark:bg-slate-800 rounded-2xl p-5 shadow-lg">

                    <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-4">

                        <div>

                            <h4 class="font-black text-lg text-slate-800 dark:text-white capitalize">
                                {{ $activity['title'] }}
                            </h4>

                            <p class="text-slate-500 text-sm mt-1">
                                {{ $activity['description'] ?? '-' }}
                            </p>

                        </div>

                        <div class="text-sm text-slate-500">

                            {{ \Carbon\Carbon::parse($activity['created_at'])->format('d M Y h:i A') }}

                        </div>

                    </div>

                    {{-- EXTRA --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 mt-5">

                        <div>

                            <p class="text-xs uppercase text-slate-400 mb-1">
                                Platform
                            </p>

                            <div class="font-bold text-slate-700 dark:text-white">
                                {{ $activity['platform'] ?? '-' }}
                            </div>

                        </div>

                        <div>

                            <p class="text-xs uppercase text-slate-400 mb-1">
                                Device
                            </p>

                            <div class="font-bold text-slate-700 dark:text-white break-all">
                                {{ $activity['device'] ?? '-' }}
                            </div>

                        </div>

                        <div>

                            <p class="text-xs uppercase text-slate-400 mb-1">
                                IP Address
                            </p>

                            <div class="font-bold text-slate-700 dark:text-white">
                                {{ $activity['ip_address'] ?? '-' }}
                            </div>

                        </div>

                        <div>

                            <p class="text-xs uppercase text-slate-400 mb-1">
                                Reference
                            </p>

                            @if($activity['reference_url'])

                            <a href="{{ $activity['reference_url'] }}"
                                target="_blank"
                                class="font-bold text-blue-500">

                                {{ $activity['reference_name'] }}

                            </a>

                            @else

                            <div class="font-bold text-slate-700 dark:text-white">
                                {{ $activity['reference_name'] ?? '-' }}
                            </div>

                            @endif

                        </div>

                    </div>

                </div>

            </div>

            @empty

            <div class="text-center py-5">

                <div class="text-7xl mb-4">
                    📜
                </div>

                <h3 class="text-2xl font-black text-slate-700 dark:text-white">
                    No Activity Found
                </h3>

                <p class="text-slate-500 mt-2">
                    Your recent activities will appear here.
                </p>

            </div>

            @endforelse

        </div>

    </div>

</div>

@endsection
