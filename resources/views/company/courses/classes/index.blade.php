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
                <a class="text-white" href="{{ route('admin.dashboard') }}">Dashboard</a>
            </li>
            <li class="text-sm pl-2  font-bold capitalize  text-white before:float-left before:pr-2 before:text-white before:content-['/']"
                aria-current="page">Course Class's Listing</li>
        </ol>
        <h6 class="mb-0 font-bold text-white capitalize">Course Class's Listing</h6>
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
                                <h6 class="dark:text-white">Course : {{ $course->title }}</h6>
                            </div>
                            <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">

                            </div>
                            <div class="w-full text-right max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-2/4 mb-3">

                                <a href="#" data-url="{{ route('admin.courses.schedule-class.create', $course->course_identity) }}"
                                    class="px-4 py-2 open-drawer bg-gradient-to-tl from-emerald-500 to-teal-400  text-white rounded text-sm">
                                    <i class=" bi bi-plus me-1"></i>
                                    Create Class</a>
                                <a href="{{ route('admin.courses.index') }}"
                                    class="px-4 py-2 bg-gradient-to-tl from-emerald-500 to-teal-400  text-white rounded text-sm"><i
                                        class="bi bi-arrow-left me-2"></i>Back</a>
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
                                    </div>
                                    <div class="w-full max-w-full ">
                                        {{-- <form method="GET" action="{{ route('admin.teachers') }}"
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
                                                <a href="{{ route('admin.teachers') }}"
                                                    class="px-4 py-2 bg-gradient-to-tl from-emerald-500 to-teal-400  rounded-full text-white text-sm"><i
                                                        class="bi bi-arrow-clockwise"></i> Reset </a>


                                            </div>
                                        </form> --}}

                                    </div>
                                </div>
                            </div>
                            <table
                                class="items-center w-full mb-0 align-top border-collapse dark:border-white/40 text-slate-500">
                                <thead class="align-bottom">
                                    <tr>
                                        <th
                                            class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                            #</th>
                                        <th
                                            class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                            Title</th>
                                        <th
                                            class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                            Teacher</th>
                                        <th
                                            class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                            Scheduled at</th>
                                        <th
                                            class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                            Type/Mode</th>
                                        <th
                                            class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                            Class Link/Record Link</th>
                                        <th
                                            class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                            Status</th>
                                        <th
                                            class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                            Position</th>
                                        <th
                                            class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                            Created At</th>
                                        <th
                                            class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                            Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($course->classes ?? [] as $key => $class)
                                        @php
                                            $classLink =
                                                $class->recording_url == ''
                                                    ? $class->meeting_link
                                                    : $class->recording_url;
                                        @endphp
                                        <tr>
                                            <td
                                                class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                                {{ $key + 1 }}</td>
                                            <td
                                                class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                                <span title="{{ $class->title }}">
                                                    {{ Str::limit($class->title, 20) }}</span>
                                            </td>
                                            <td
                                                class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                                {{ $class->teacher?->name }}</td>
                                            <td
                                                class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                                {{ date('d-M-Y', strtotime($class->scheduled_at)) }}<br>{{ $class->start_time }}/{{ $class->end_time }}
                                            </td>

                                            <td
                                                class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                                {{ $class->type }}/{{ $class->class_mode }}</td>
                                            <td
                                                class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                                <a href="{{ $classLink }}" target="_blank"
                                                    title="{{ $classLink }}">{{ Str::limit($classLink, 20) }}</a> <i
                                                    class="bi bi-copy mx-2"
                                                    onclick="copyPageLink(`{{ $classLink }}`)"></i>
                                            </td>
                                            <td
                                                class="px-6 py-3 font-bold text-center capitalize align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                                @if ($class->status)
                                                    <span
                                                        class="bg-emerald-500/50 text-white px-3 py-1 text-xxs rounded-full">
                                                        Published
                                                    </span>
                                                @else
                                                    <span class="bg-red-500 text-white px-3 py-1 text-xxs rounded-full">
                                                        Unpublished
                                                    </span>
                                                @endif
                                            </td>
                                            <td
                                                class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                                {{ $class->priority }}
                                            </td>
                                            <td
                                                class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                                {{ $class->created_at->format('d M Y') }}</td>
                                            <td
                                                class="px-6 flex  gap-1 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                                <a href="#" data-url="{{ route('admin.courses.schedule-class.edit', ['identity' => $course->course_identity, 'schedule_class' => $class->id]) }}"
                                                    class="open-drawer px-3 py-1 text-blue rounded text-xs">
                                                    <i class="bi bi-pencil"></i>
                                                </a>

                                                <form
                                                    action="{{ route('admin.courses.schedule-class.destroy', ['identity' => $course->course_identity, 'schedule_class' => $class->id]) }}"
                                                    method="POST" class="inline-block"
                                                    onsubmit="return confirm('Are you sure?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-3 py-1  text-red rounded text-xs">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>

                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="text-center p-5">No course classes found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')

<link href="https://cdn.jsdelivr.net/npm/tom-select@2.4.3/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.4.3/dist/js/tom-select.complete.min.js"></script>
<script>
    new TomSelect("#select-tags", {
        plugins: ['remove_button'],
        create: true,
        onItemAdd: function() {
            this.setTextboxValue('');
            this.refreshOptions();
        },
        render: {
            option: function(data, escape) {
                return `<div class="d-flex"><img src="` + escape(data.date) +
                    `" class="ms-auto text-muted"><span>` + escape(data.name) +
                    `</span></div>`;
            },
            item: function(data, escape) {
                return '<div>' + escape(data.name) + '</div>';
            }
        }
    });
</script>


@endpush
