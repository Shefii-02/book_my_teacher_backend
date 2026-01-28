@php
    $totalDays =
        $course->started_at && $course->ended_at
            ? \Carbon\Carbon::parse($course->started_at)->diffInDays(\Carbon\Carbon::parse($course->ended_at))
            : '--';
@endphp

<div
    class="group bg-white dark:bg-slate-800 relative border border-gray-200 dark:border-slate-700 rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300">

    {{-- IMAGE --}}
    <div class="relative h-40 overflow-hidden">
        <img src="{{ $course->thumbnail_url ?? ($course->main_image_url ?? asset('images/placeholder.png')) }}"
            alt="{{ $course->title }}" loading="lazy"
            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">

        {{-- STATUS BADGE --}}
        <span
            class="absolute top-3 right-3 text-xs px-3 py-1 rounded-full text-white
            {{ $course->status === 'published'
                ? 'bg-green-600'
                : ($course->status === 'unpublished'
                    ? 'bg-red-600'
                    : 'bg-yellow-500') }}">
            {{ ucfirst($course->status) }}
        </span>

    </div>
 {{-- ACTIONS --}}
        <div class="absolute top-0 end-0 z-990 ">
            <button onclick="document.getElementById('dropdown_{{ $course->id }}').classList.toggle('hidden')"
                class="p-2 bg-yellow-50  hover:bg-gray-100 dark:hover:bg-slate-700">
                <i class="bi bi-three-dots-vertical text-dark"></i>
            </button>

            <div id="dropdown_{{ $course->id }}"
                class="hidden absolute right-0 mt-2 w-28 bg-white dark:bg-slate-800 border dark:border-slate-700 rounded-lg shadow-lg text-sm">

                @if ($course->status === 'published')
                    <a href="{{ route('company.courses.show', $course->course_identity) }}"
                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-slate-700">
                        View
                    </a>
                    <a href="{{ route('company.courses.show', $course->course_identity) }}"
                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-slate-700">
                        Classes
                    </a>
                      <a href="{{ route('company.courses.show', $course->course_identity) }}"
                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-slate-700">
                        Materials
                    </a>
                @endif

                <a href="{{ route('company.courses.create', ['draft' => $course->course_identity]) }}"
                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-slate-700">
                    Edit
                </a>

                <button onclick="confirmDelete({{ $course->id }})"
                    class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20">
                    Delete
                </button>
            </div>
        </div>
    {{-- CONTENT --}}
    <div class="p-4 flex flex-col h-[230px]">

        {{-- TITLE --}}
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white leading-tight line-clamp-2">
            {{ $course->title }}
        </h3>

        {{-- DESCRIPTION --}}
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-300 line-clamp-2">
            {{ Str::limit($course->description,20,'...') ?? 'No description available' }}
        </p>

        {{-- META INFO --}}
        <div class="mt-3 grid grid-cols-2 gap-2 text-xs text-gray-500 dark:text-gray-400">
            <div class="flex items-center gap-1">
                🗓 <span>{{ $totalDays }} Days</span>
            </div>
            <div class="flex items-center gap-1">
                ⏱ <span>{{ $course->total_hours ?? '--' }} Hours</span>
            </div>
            <div class="col-span-2 flex items-center gap-1">
                📅
                <span>
                    {{ date('d M Y', strtotime($course->started_at)) }}
                    →
                    {{ $course->ended_at ? date('d M Y', strtotime($course->ended_at)) : 'Unlimited' }}
                </span>
            </div>
        </div>

        {{-- FOOTER --}}
        <div class="mt-auto flex items-center justify-between pt-4">

            {{-- PRICE --}}
            <div class="flex items-center gap-2">
                @if ($course->actual_price > 0)
                    <span class="text-sm text-gray-400 line-through">₹{{ $course->actual_price }}</span>
                @endif
                <span class="text-xl font-bold text-emerald-600">
                    ₹{{ $course->net_price }}
                </span>
            </div>



        </div>
    </div>
</div>
