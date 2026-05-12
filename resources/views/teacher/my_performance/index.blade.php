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
            Performance
        </li>

    </ol>

    <h6 class="mb-0 font-black text-white text-2xl">
        Performance Analytics
    </h6>

</nav>
@endsection

@section('content')

<div class="w-full px-6 py-6 mx-auto">

    {{-- TOP CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-4 xl:grid-cols-4 gap-6 mb-8">

        {{-- TOTAL TIME --}}
        <div class="rounded-2xl overflow-hidden bg-gradient-to-br from-blue-500 to-cyan-400 p-6 shadow-2xl text-white">

            <div class="flex items-start justify-between">

                <div>

                    <p class="uppercase text-xs tracking-widest opacity-70">
                        Total Spend Time
                    </p>

                    <h2 class="text-4xl font-black mt-4">
                        {{ $data['total_time'] }}
                    </h2>

                </div>

                <div class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center">
                    <i class="ni ni-watch-time text-2xl"></i>
                </div>

            </div>

        </div>

        {{-- TOTAL SESSIONS --}}
        <div class="rounded-2xl overflow-hidden bg-gradient-to-br from-emerald-500 to-teal-400 p-6 shadow-2xl text-white">

            <div class="flex items-start justify-between">

                <div>

                    <p class="uppercase text-xs tracking-widest opacity-70">
                        Total Sessions
                    </p>

                    <h2 class="text-4xl font-black mt-4">
                        {{ number_format($data['total_sessions']) }}
                    </h2>

                </div>

                <div class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center">
                    <i class="ni ni-books text-2xl"></i>
                </div>

            </div>

        </div>

        {{-- RATING --}}
        <div class="rounded-2xl overflow-hidden bg-gradient-to-br from-orange-500 to-yellow-400 p-6 shadow-2xl text-white">

            <div class="flex items-start justify-between">

                <div>

                    <p class="uppercase text-xs tracking-widest opacity-70">
                        Average Rating
                    </p>

                    <h2 class="text-4xl font-black mt-4">
                        {{ $data['average_rating'] }}/5
                    </h2>

                </div>

                <div class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center">
                    <i class="ni ni-favourite-28 text-2xl"></i>
                </div>

            </div>

        </div>

        {{-- EARNING --}}
        <div class="rounded-2xl overflow-hidden bg-gradient-to-br from-violet-500 to-purple-500 p-6 shadow-2xl text-white">

            <div class="flex items-start justify-between">

                <div>

                    <p class="uppercase text-xs tracking-widest opacity-70">
                        Total Growth
                    </p>

                    <h2 class="text-4xl font-black mt-4">
                        ₹{{ number_format($data['total_growth'], 2) }}
                    </h2>

                </div>

                <div class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center">
                    <i class="ni ni-chart-bar-32 text-2xl"></i>
                </div>

            </div>

        </div>

    </div>

    {{-- TABLE --}}
    <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-2xl overflow-hidden">

        <div class="p-6 border-b border-slate-100 dark:border-slate-800">

            <div class="flex items-center justify-between">

                <div>

                    <h3 class="text-2xl font-black text-slate-800 dark:text-white">
                        Monthly Performance
                    </h3>

                    <p class="text-sm text-slate-500 mt-1">
                        Last 6 months performance analytics
                    </p>

                </div>

            </div>

        </div>

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-slate-50 dark:bg-slate-800">

                    <tr>

                        <th class="px-6 py-2 text-left text-xs font-black uppercase">
                            #
                        </th>

                        <th class="px-6 py-2 text-left text-xs font-black uppercase">
                            Month
                        </th>

                        <th class="px-6 py-2 text-center text-xs font-black uppercase">
                            Total Courses
                        </th>

                        <th class="px-6 py-2 text-center text-xs font-black uppercase">
                            Total Sessions
                        </th>

                        <th class="px-6 py-2 text-center text-xs font-black uppercase">
                            Earnings
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($performances as $key => $performance)

                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-all">

                        <td class="px-6 py-2 border-b dark:border-slate-800">
                            {{ $key + 1 }}
                        </td>

                        <td class="px-6 py-2 border-b dark:border-slate-800">

                            <div class="font-bold text-slate-800 dark:text-white">
                                {{ $performance['month'] }}
                            </div>

                        </td>

                        <td class="px-6 py-2 text-center border-b dark:border-slate-800">

                            <span class="px-4 py-2 rounded-full bg-blue-100 text-blue-600 text-xs font-black">
                                {{ $performance['courses'] }}
                            </span>

                        </td>

                        <td class="px-6 py-2 text-center border-b dark:border-slate-800">

                            <span class="px-4 py-2 rounded-full bg-emerald-100 text-emerald-600 text-xs font-black">
                                {{ $performance['sessions'] }}
                            </span>

                        </td>

                        <td class="px-6 py-2 text-center border-b dark:border-slate-800">

                            <span class="font-black text-violet-600 text-lg">
                                ₹{{ number_format($performance['earning'], 2) }}
                            </span>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="5">

                            <div class="py-20 text-center">

                                <div class="text-7xl mb-5">
                                    📈
                                </div>

                                <h3 class="text-2xl font-black text-slate-700 dark:text-white">
                                    No Performance Data
                                </h3>

                                <p class="text-slate-500 mt-2">
                                    No analytics available yet.
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
