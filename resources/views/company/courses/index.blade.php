@extends('layouts.layout')
@section('nav-options')
    <nav>
        <!-- breadcrumb -->
        <ol class="flex flex-wrap pt-1 mr-12 bg-transparent rounded-lg sm:mr-16">
            <li class="text-neutral-900 text-sm">
                <a class="text-white " href="javascript:;">Home</a>
            </li>
            <li
                class="ltext-sm pl-2 capitalize text-neutral-900 text-white before:float-left before:pr-2 before:text-white before:content-['/']">
                <a class="text-white" href="{{ route('company.dashboard') }}">Dashboard</a>
            </li>
            <li class="text-sm pl-2  font-bold capitalize  text-white before:float-left before:pr-2 before:text-white before:content-['/']"
                aria-current="page">Course Listing</li>
        </ol>
        <h6 class="mb-0 font-bold text-white capitalize">Course Listing</h6>
    </nav>
@endsection
@section('content')
    <!-- cards -->
    <div class="w-full px-6 py-6 mx-auto">
        <div class="flex flex-wrap -mx-3 mt-4">
            <div class="flex-none w-full max-w-full px-3">
                <div
                    class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                    <div class="p-4 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                        <div class="flex">
                            <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
                                <h6 class="dark:text-white">Course List</h6>
                            </div>
                            <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">

                            </div>
                            <div class="w-full text-right max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-2/4 mb-3">

                                <a href="{{ route('company.courses.create') }}"
                                    class="px-4 py-2 bg-gradient-to-tl  from-emerald-500 to-teal-400  text-white  text-sm">
                                    <i class="bi bi-plus me-1"></i> Create Course</a>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- table 1 -->

                <div class="flex flex-wrap -mx-3 mt-4">
                    <div class="flex-none w-full max-w-full px-3">
                        <div
                            class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                            <div class="p-6 pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                                <div class="flex1">
                                    <div class="w-full max-w-full ">
                                        {{-- <h6 class="dark:text-white">Course List</h6> --}}
                                    </div>
                                    {{-- <div class="w-full max-w-full ">
                                        <form method="GET" action="{{ route('company.teachers') }}"
                                            class="mb-4 flex flex-wrap gap-3 items-end">

                                            <!-- 🔍 Search (name, email, mobile) -->
                                            <div>
                                                <label class="block text-sm font-medium mb-1">Search</label>
                                                <input type="text" name="search" value="{{ request('search') }}"
                                                    placeholder="Search name, email, mobile"
                                                    class="border rounded px-3 py-2 w-64">
                                            </div>

                                            <!-- 🎛 Teaching Mode -->
                                            <div>
                                                <label class="block text-sm font-medium mb-1">Video Mode</label>
                                                <select name="teaching_mode" class="border rounded px-3 py-2 w-32">
                                                    <option value="">All</option>
                                                    <option value="online"
                                                        {{ request('teaching_mode') == 'online' ? 'selected' : '' }}>
                                                        Online
                                                    </option>
                                                    <option value="offline"
                                                        {{ request('teaching_mode') == 'offline' ? 'selected' : '' }}>
                                                        Offline
                                                    </option>
                                                    <option value="both"
                                                        {{ request('teaching_mode') == 'both' ? 'selected' : '' }}>Both
                                                    </option>
                                                </select>
                                            </div>

                                            <!-- 📌 Account Status -->
                                            <div>
                                                <label class="block text-sm font-medium mb-1">Status</label>
                                                <select name="account_status" class="border rounded px-3 py-2 w-32">
                                                    <option value="">All</option>
                                                    <option value="draft"
                                                        {{ request('status') == 'draft' ? 'selected' : '' }}>
                                                        Draft</option>
                                                    <option value="unpublished"
                                                        {{ request('status') == 'unpublished' ? 'selected' : '' }}>
                                                        Unpublished
                                                    </option>
                                                    <option value="published"
                                                        {{ request('status') == 'published' ? 'selected' : '' }}>
                                                        Published
                                                    </option>
                                                </select>
                                            </div>

                                            <!-- Submit + Reset -->
                                            <div class="flex gap-2">
                                                <button type="submit"
                                                    class="px-4 py-2 bg-gradient-to-tl from-emerald-500 to-teal-400  text-white rounded-full text-sm"><i
                                                        class="bi bi-search"></i> Apply</button>
                                                <a href="{{ route('company.teachers') }}"
                                                    class="px-4 py-2 bg-gradient-to-tl from-emerald-500 to-teal-400  rounded-full text-white text-sm"><i
                                                        class="bi bi-arrow-clockwise"></i> Reset </a>


                                            </div>
                                        </form>

                                    </div> --}}
                                </div>
                            </div>
                            @php
                                $activeFilters = collect(request()->only(['search', 'class_mode', 'status']))->filter(
                                    fn($value) => filled($value),
                                ); // remove null/empty
                            @endphp

                            @if ($activeFilters->isNotEmpty())
                                <div class="mb-4 pl-9 flex flex-wrap gap-2">
                                    @foreach ($activeFilters as $key => $value)
                                        <div class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full flex items-center">
                                            <span class="mr-2 capitalize">{{ str_replace('_', ' ', $key) }}:
                                                {{ $value }}</span>
                                            <a href="{{ request()->fullUrlWithQuery([$key => null]) }}"
                                                class="text-red-500 hover:text-red-700 font-bold">×</a>
                                        </div>
                                    @endforeach
                                    <a href="{{ route('company.teachers') }}" class="ml-3 mt-2.5 text-sm text-red-600">Clear
                                        All</a>
                                </div>
                            @endif

                            <div class="flex-auto px-0 pt-0 pb-2">
                                <div class="p-0 overflow-x-auto">
                                    {{-- <table
                                        class="items-center w-full mb-0 align-top border-collapse dark:border-white/40 text-slate-500">
                                        <thead class="align-bottom">
                                            <tr>
                                                <th
                                                    class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                                    #</th>
                                                <th
                                                    class="px-6 py-3 pl-2 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                                    Image</th>
                                                <th
                                                    class="px-6 py-3 pl-2 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                                    Started-Ended at</th>
                                                <th
                                                    class="px-6 py-3 pl-2 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                                    Categories</th>
                                                <th
                                                    class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                                    Price</th>
                                                <th
                                                    class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                                    Streaming Type</th>
                                                <th
                                                    class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                                    Course Type</th>
                                                <th
                                                    class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                                    Created at</th>
                                                <th
                                                    class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                                    Status</th>
                                                <th
                                                    class="px-6 py-3 font-semibold capitalize align-middle bg-transparent border-b border-collapse border-solid shadow-none dark:border-white/40 dark:text-white tracking-none  text-slate-400 opacity-70">
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($courses ?? [] as $key => $course)
                                                @php
                                                    $courseCategories = $course->categories->pluck('title')->toArray();
                                                @endphp
                                                <tr>
                                                    <td
                                                        class="p-2 text-center align-middle bg-transparent border-b dark:border-white/40  shadow-transparent">
                                                        {{ $key + 1 }}
                                                    </td>
                                                    <td
                                                        class="p-2 align-middle bg-transparent border-b dark:border-white/40  shadow-transparent">
                                                        <div class="flex px-2 py-1">
                                                            <div>
                                                                <img src="{{ asset('storage/' . $course ? $course->thumbnail_url : '') }}"
                                                                    class="inline-flex items-center justify-center mr-4 text-sm text-white transition-all duration-200 ease-in-out w-32 rounded"
                                                                    alt="user1" />
                                                                <h6
                                                                    class="mt-3 capitalize text-sm text-neutral-900 dark:text-white">
                                                                    {{ $course->title }}</h6>
                                                            </div>
                                                        </div>
                                                    </td>

                                                    <td
                                                        class="p-2 align-middle bg-transparent border-b dark:border-white/40  shadow-transparent">
                                                        <p
                                                            class="mb-0 text-xs font-semibold capitalize leading-tight dark:text-white dark:opacity-80 text-slate-400">
                                                            {{ $course->started_at }} - {{ $course->ended_at }}
                                                        </p>
                                                    </td>
                                                    <td
                                                        class="p-2 align-middle bg-transparent border-b dark:border-white/40  shadow-transparent">
                                                        <p
                                                            class="mb-0 capitalize text-xs font-semibold leading-tight dark:text-white dark:opacity-80 text-slate-400">
                                                            {{ implode(', ', $courseCategories) }}
                                                        </p>
                                                    </td>
                                                    <td
                                                        class="p-2 align-middle bg-transparent border-b dark:border-white/40  shadow-transparent">
                                                        <p
                                                            class="mb-0 capitalize text-xs font-semibold leading-tight dark:text-white dark:opacity-80 text-slate-400">
                                                            <strike>{{ $course->actual_price }}</strike>
                                                            {{ $course->net_price }}
                                                        </p>
                                                    </td>
                                                    <td
                                                        class="p-2 text-sm text-neutral-900 text-center align-middle bg-transparent border-b dark:border-white/40  shadow-transparent">
                                                        <p
                                                            class="mb-0 capitalize text-xs font-semibold leading-tight dark:text-white dark:opacity-80 text-slate-400">
                                                            {{ $course->streaming_type }}
                                                        </p>
                                                    </td>
                                                    <td
                                                        class="p-2 text-center align-middle bg-transparent border-b dark:border-white/40  shadow-transparent">
                                                        <span
                                                            class="text-xs font-semibold leading-tight dark:text-white dark:opacity-80 text-slate-400">{{ $course->type }}</span>
                                                    </td>
                                                    <td
                                                        class="p-2 text-center align-middle bg-transparent border-b dark:border-white/40  shadow-transparent">
                                                        <span
                                                            class="text-xs font-semibold leading-tight dark:text-white dark:opacity-80 text-slate-400">{{ $course->created_at }}</span>
                                                    </td>
                                                    <td
                                                        class="p-2 text-center align-middle bg-transparent border-b dark:border-white/40  shadow-transparent capitalize">
                                                        @if ($course->status == 'draft')
                                                            <span
                                                                class="bg-gradient-to-tl capitalize from-zinc-800 to-teal-400 px-2.5 text-xs rounded-1.8 py-1.4 inline-block  text-center align-baseline font-bold  leading-none text-white">Draft</span>
                                                        @elseif($course->status == 'unpublished')
                                                            <span
                                                                class="bg-gradient-to-tl capitalize from-slate-600 to-slate-300 px-2.5 text-xs rounded-1.8 py-1.4 inline-block  text-center align-baseline font-bold  leading-none text-white">Un
                                                                Published</span>
                                                        @elseif($course->status == 'published')
                                                            <span
                                                                class="bg-gradient-to-tl capitalize from-emerald-500 to-teal-400 px-2.5 text-xs rounded-1.8 py-1.4 inline-block  text-center align-baseline font-bold  leading-none text-white">Published</span>
                                                        @endif
                                                    </td>
                                                    <td
                                                        class="p-2 align-middle bg-transparent border-b dark:border-white/40  shadow-transparent">
                                                        <button id="dropdownBottomButton"
                                                            data-dropdown-toggle="dropdownBottom_{{ $key }}"
                                                            data-dropdown-placement="bottom" class=""
                                                            type="button">
                                                            <svg class="w-6 h-6 text-gray-800 dark:text-white"
                                                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                                width="24" height="24" fill="none"
                                                                viewBox="0 0 24 24">
                                                                <path stroke="currentColor" stroke-linecap="round"
                                                                    stroke-width="2" d="M12 6h.01M12 12h.01M12 18h.01" />
                                                            </svg>
                                                        </button>

                                                        <!-- Dropdown menu -->
                                                        <div id="dropdownBottom_{{ $key }}"
                                                            class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700">
                                                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                                                aria-labelledby="dropdownBottomButton">
                                                                @if ($course->status == 'published')
                                                                    <li>
                                                                        <a href="{{ route('company.courses.show', $course->course_identity) }}"
                                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-white dark:hover:text-white">View</a>
                                                                    </li>
                                                                @endif

                                                                <li>
                                                                    <a href="{{ route('company.courses.create', ['draft' => $course->course_identity]) }}"
                                                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-white dark:hover:text-white">Edit</a>
                                                                </li>
                                                                <li>
                                                                    <form id="form_{{ $course->id }}" class="m-0 p-0"
                                                                        action="{{ route('company.courses.destroy', $course->id) }}"
                                                                        method="POST" class="inline-block">
                                                                        @csrf @method('DELETE') </form>
                                                                    <a role="button" href="javascript:;"
                                                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-white dark:hover:text-white"
                                                                        onclick="confirmDelete({{ $course->id }})">Delete</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table> --}}
                                    <div class="min-h-screen  transition-colors">
                                        <div class="p-6">

                                            {{-- Header: title + dark mode toggle + search/filters --}}
                                            {{-- <div class="flex items-center justify-between mb-6">
                                                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Courses</h1>

                                                <div class="flex items-center gap-3">
                                                    <!-- Search -->
                                                    <input x-model="filters.search" @keydown.enter.prevent="reload()"
                                                        type="text" placeholder="Search courses..."
                                                        class="px-3 py-2 rounded-lg border bg-white dark:bg-slate-800 text-sm focus:ring focus:ring-indigo-200">

                                                    <!-- Category filter (simple example) -->
                                                    <select x-model="filters.category" @change="reload()"
                                                        class="px-3 py-2 rounded-lg border bg-white dark:bg-slate-800 text-sm">
                                                        <option value="">All Categories</option>
                                                        @foreach ($allCategories as $cat)
                                                            <option value="{{ $cat->id }}">{{ $cat->title }}</option>
                                                        @endforeach
                                                    </select>

                                                    <!-- Dark / Light toggle -->
                                                    <button @click="toggleDark()" :aria-pressed="darkMode.toString()"
                                                        class="flex items-center gap-2 px-3 py-2 rounded-lg border bg-white dark:bg-slate-800">
                                                        <template x-if="!darkMode">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-width="2" stroke-linecap="round"
                                                                    stroke-linejoin="round"
                                                                    d="M12 3v2m0 14v2m9-9h-2M5 12H3m15.36 6.36-1.42-1.42M7.05 7.05 5.64 5.64m12.02 0-1.41 1.41M7.05 16.95l-1.41 1.41" />
                                                            </svg>
                                                        </template>
                                                        <template x-if="darkMode">
                                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                                <path
                                                                    d="M17.293 13.293a8 8 0 11-10.586-10.586 8 8 0 0010.586 10.586z" />
                                                            </svg>
                                                        </template>
                                                        <span x-text="darkMode ? 'Dark' : 'Light' " class="text-sm"></span>
                                                    </button>
                                                </div>
                                            </div> --}}

                                            {{-- Grid container --}}
                                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6"
                                                id="courses-grid" >
                                                {{-- initial cards rendered from server --}}
                                                @forelse ($courses as $course)
                                                    @include('components.courses_card', ['course' => $course])
                                                @empty
                                                    <h6>No Course Founded</h6>
                                                @endforelse
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center m-4">
                                {!! $courses->links() !!}
                            </div>
                            <p class="p-3">Showing {{ $courses->firstItem() }} to {{ $courses->lastItem() }} of
                                {{ $courses->total() }} courses.</p>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
