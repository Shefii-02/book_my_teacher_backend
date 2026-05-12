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
            Reviews & Ratings
        </li>

    </ol>

    <h6 class="mb-0 font-bold text-white capitalize">
        Reviews & Ratings
    </h6>

</nav>

@endsection

@section('content')

<div class="w-full px-6 py-6 mx-auto">

    {{-- TOP CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-4 xl:grid-cols-4 gap-6 mb-8">

        {{-- TOTAL REVIEWS --}}
        <div class="rounded-2xl bg-gradient-to-br from-blue-500 to-cyan-400 p-6 shadow-2xl text-white">

            <div class="flex justify-between items-start">

                <div>

                    <p class="uppercase text-xs opacity-70 tracking-wider">
                        Total Reviews
                    </p>

                    <h2 class="text-4xl font-black mt-3">
                        {{ $data['total_reviews'] }}
                    </h2>

                </div>

                <div class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center">
                    <i class="ni ni-chat-round text-2xl"></i>
                </div>

            </div>

        </div>

        {{-- AVG RATING --}}
        <div class="rounded-2xl bg-gradient-to-br from-yellow-400 to-orange-500 p-6 shadow-2xl text-white">

            <div class="flex justify-between items-start">

                <div>

                    <p class="uppercase text-xs opacity-70 tracking-wider">
                        Average Rating
                    </p>

                    <h2 class="text-4xl font-black mt-3">
                        {{ $data['average_rating'] }}/5
                    </h2>

                </div>

                <div class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center">
                    <i class="ni ni-favourite-28 text-2xl"></i>
                </div>

            </div>

        </div>

        {{-- 5 STAR --}}
        <div class="rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-400 p-6 shadow-2xl text-white">

            <div class="flex justify-between items-start">

                <div>

                    <p class="uppercase text-xs opacity-70 tracking-wider">
                        5 Star Reviews
                    </p>

                    <h2 class="text-4xl font-black mt-3">
                        {{ $data['five_star'] }}
                    </h2>

                </div>

                <div class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center">
                    ⭐
                </div>

            </div>

        </div>

        {{-- LOW RATINGS --}}
        <div class="rounded-2xl bg-gradient-to-br from-red-500 to-pink-500 p-6 shadow-2xl text-white">

            <div class="flex justify-between items-start">

                <div>

                    <p class="uppercase text-xs opacity-70 tracking-wider">
                        Low Ratings
                    </p>

                    <h2 class="text-4xl font-black mt-3">
                        {{ $data['one_star'] + $data['two_star'] }}
                    </h2>

                </div>

                <div class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center">
                    <i class="ni ni-support-16 text-2xl"></i>
                </div>

            </div>

        </div>

    </div>

    {{-- RATING BREAKDOWN --}}
    <div class="grid grid-cols-5 md:grid-cols-5 xl:grid-cols-5 gap-1 mb-8">

        @php

            $ratingData = [
                ['star' => '5 Star', 'count' => $data['five_star'], 'color' => 'bg-emerald-500/30'],
                ['star' => '4 Star', 'count' => $data['four_star'], 'color' => 'bg-blue-500'],
                ['star' => '3 Star', 'count' => $data['three_star'], 'color' => 'bg-yellow-500'],
                ['star' => '2 Star', 'count' => $data['two_star'], 'color' => 'bg-orange-500'],
                ['star' => '1 Star', 'count' => $data['one_star'], 'color' => 'bg-red-500'],

            ];

        @endphp

        @foreach($ratingData as $rating)

        <div class="rounded bg-white dark:bg-slate-900 shadow-xl p-2">

          <div class="flex gap-2 items-center justify-between">

            <div class="flex items-center justify-between mb-1 gap-2">
                <span class="w-4 h-4 rounded-full {{ $rating['color'] }}"></span>

                <h5 class="font-black dark:text-white">
                    {{ $rating['star'] }}
                </h5>


            </div>

            <h4 class=" font-black dark:text-white">
                {{ $rating['count'] }}
            </h4>

          </div>
        </div>

        @endforeach

    </div>

    {{-- REVIEW TABLE --}}
    <div class="rounded-2xl bg-white dark:bg-slate-900 shadow-2xl overflow-hidden">

        <div class="p-6 border-b border-slate-100 dark:border-slate-800">

            <div class="flex items-center justify-between">

                <div>

                    <h5 class="text-2xl font-black dark:text-white">
                        Student Reviews
                    </h5>

                    <p class="text-slate-500 text-sm mt-1">
                        Student feedback and ratings
                    </p>

                </div>

            </div>

        </div>

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-slate-50 dark:bg-slate-800">

                    <tr>

                        <th class="px-6 py-4 text-left text-xs font-black uppercase">
                            Student
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-black uppercase">
                            Course
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-black uppercase">
                            Subject
                        </th>

                        <th class="px-6 py-4 text-center text-xs font-black uppercase">
                            Rating
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-black uppercase">
                            Comment
                        </th>

                        <th class="px-6 py-4 text-center text-xs font-black uppercase">
                            Date
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($reviews as $review)

                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800 transition">

                        {{-- STUDENT --}}
                        <td class="px-6 py-5 border-b dark:border-slate-800">

                            <div class="flex items-center gap-3">

                                <img
                                    src="{{ getImage($review->user?->image) }}"
                                    class="w-12 h-12 rounded-2xl object-cover border border-slate-200"
                                >

                                <div>

                                    <h4 class="font-bold dark:text-white">
                                        {{ $review->user?->name ?? 'Student' }}
                                    </h4>

                                </div>

                            </div>

                        </td>

                        {{-- COURSE --}}
                        <td class="px-6 py-5 border-b dark:border-slate-800">

                            <div class="font-semibold dark:text-white">
                                {{ $review->course?->title ?? '-' }}
                            </div>

                        </td>

                        {{-- SUBJECT --}}
                        <td class="px-6 py-5 border-b dark:border-slate-800">

                            <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-600 text-xs font-bold">

                                {{ $review->subject?->name ?? '-' }}

                            </span>

                        </td>

                        {{-- RATING --}}
                        <td class="px-6 py-5 text-center border-b dark:border-slate-800">

                            <div class="flex justify-center">

                                @for($i = 1; $i <= 5; $i++)

                                    @if($i <= $review->rating)

                                        <span class="text-yellow-400 text-lg">★</span>

                                    @else

                                        <span class="text-slate-300 text-lg">★</span>

                                    @endif

                                @endfor

                            </div>

                            <div class="text-xs font-bold mt-1 text-slate-500">
                                {{ $review->rating }}/5
                            </div>

                        </td>

                        {{-- COMMENT --}}
                        <td class="px-6 py-5 border-b dark:border-slate-800">

                            <p class="text-sm text-slate-600 dark:text-slate-300 leading-6">

                                {{ $review->comments ?? '-' }}

                            </p>

                        </td>

                        {{-- DATE --}}
                        <td class="px-6 py-5 text-center border-b dark:border-slate-800 text-sm">

                            {{ \Carbon\Carbon::parse($review->created_at)->format('d M Y') }}

                            <div class="text-xs text-slate-500 mt-1">
                                {{ \Carbon\Carbon::parse($review->created_at)->format('h:i A') }}
                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="6">

                            <div class="text-center py-5">

                                <div class="text-7xl mb-4">
                                    ⭐
                                </div>

                                <h3 class="text-2xl font-black text-slate-700 dark:text-white">
                                    No Reviews Found
                                </h3>

                                <p class="text-slate-500 mt-2">
                                    No student reviews available.
                                </p>

                            </div>

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- PAGINATION --}}
        <div class="p-6">

            {{ $reviews->links() }}

        </div>

    </div>

</div>

@endsection
