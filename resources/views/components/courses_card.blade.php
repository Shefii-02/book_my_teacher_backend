@php
    $courseCategories = $course->categories->pluck('title')->toArray();
    $totalDays =
        $course->started_at && $course->ended_at
            ? \Carbon\Carbon::parse($course->started_at)->diffInDays(\Carbon\Carbon::parse($course->ended_at))
            : '--';
@endphp

<div class="bg-white dark:bg-slate-800 border rounded-xl shadow hover:shadow-xl transform transition duration-300 hover:-translate-y-1 overflow-hidden"
    style="min-height: 230px;">
    {{-- image with lazy loading --}}
    <div class=" overflow-hidden relative">
        <img
            src="{{ !empty($course->thumbnail_url)
                ? $course->thumbnail_url
                : (!empty($course->main_image_url)
                    ? $course->main_image_url
                    : asset('images/placeholder.png')) }}"
        alt="{{ $course->title }}" class="w-full" loading="lazy">
        <div class=" absolute end-0 position-absolute top-0">
            @if ($course->status == 'published')
                <span class="text-xs px-3 py-1 rounded bg-green-500 my-1 text-2.8 text-white">Published</span>
            @elseif($course->status == 'unpublished')
                <span class="text-xs px-3 py-1 rounded bg-red-600 my-1 text-2.8 text-white">Unpublished</span>
            @else
                <span class="text-xs px-3 py-1 rounded bg-[#F7BE38] my-1 text-2.8 text-white">Draft</span>
            @endif
        </div>
    </div>

    <div class="p-4 flex flex-col">
        <h3 class="text-lg font-semibold text-gray-800  m-0 p-0 dark:text-white line-clamp-2">
            {{ $course->title }}
        </h3>


        <p class="text-sm text-gray-600 dark:text-gray-300 m-0 p-0 line-clamp-2">
            {{ $course->description }}
        </p>

        <div class="mt-1 text-xs text-gray-500 dark:text-gray-400 space-y-2">
            <div>
                🗓 <strong>Total Days:</strong>{{ $totalDays }}/⏱ Hours:{{ $course->total_hours ?? '--' }}
            </div>
            <div><strong>📅</strong> {{ date('d-M-Y', strtotime($course->started_at)) }} →
                {{ $course->ended_at == null ? 'Unlimited' : date('d-M-Y', strtotime($course->ended_at)) }}</div>
            {{-- @if ($courseCategories)
                <div><strong>Categories:</strong> <span
                        class="bg-blue-300 px-2 py-1 text-white rounded">{{ implode(', ', $courseCategories) }}</span>
                </div>
            @endif --}}
        </div>


        <div class="mt-auto flex items-center justify-between gap-3">
            <div class="flex gap-2 items-center align-center">
                ₹
                @if ($course->actual_price > 0)
                    <div class="text-sm text-gray-500 line-through">{{ $course->actual_price }}</div>
                @endif
                <div class="text-lg font-semibold text-emerald-600">{{ $course->net_price }}</div>

            </div>



            <div class="flex items-center gap-2">
                {{-- ac
                tions dropdown toggle (works with JS toggleDropdown or Alpine) --}}
                <div class="">
                    <!-- ACTIONS -->
                    <div class="relative">
                        <button data-dropdown-toggle="dropdown_{{ $course->id }}">
                            <svg class="w-6 h-6 text-gray-700 dark:text-white" fill="none"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                    d="M12 6h.01M12 12h.01M12 18h.01" />
                            </svg>
                        </button>


                    </div>
                    <!-- Dropdown -->
                    <div id="dropdown_{{ $course->id }}"
                        class="hidden absolute right-0 mt-0 w-20 bg-white rounded-lg shadow-md ">


                        @if ($course->status == 'published')
                            <a class="edit-step block px-4 py-2  text-xxs"
                                href="{{ route('company.courses.show', $course->course_identity) }}">
                                View
                            </a>
                        @endif

                        <a class="edit-step block px-4 py-2  text-xxs"
                            href="{{ route('company.courses.create', ['draft' => $course->course_identity]) }}">
                            Edit
                        </a>

                        <form action="{{ route('company.courses.destroy', $course->id) }}" method="POST"
                            id="form_{{ $course->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="confirmDelete({{ $course->id }})"
                                class="w-full text-left px-4 py-2 text-xxs">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
