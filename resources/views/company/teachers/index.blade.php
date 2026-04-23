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
                <a class="text-white" href="javascript:;">Dashboard</a>
            </li>
            <li class="text-sm pl-2  font-bold capitalize  text-white before:float-left before:pr-2 before:text-white before:content-['/']"
                aria-current="page">Teachers List</li>
        </ol>
        <h6 class="mb-0 font-bold text-white capitalize">Teacher List</h6>
    </nav>
@endsection

@section('content')
    <!-- cards -->
    <div class="w-full px-6 py-6 mx-auto">
        <!-- row 1 -->
        <div class="flex flex-wrap -mx-3">
            <!-- card1 -->
            <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
                <div
                    class="relative flex flex-col min-w-0 break-words bg-white shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                    <div class="flex-auto p-4">
                        <div class="flex flex-row -mx-3">
                            <div class="flex-none w-2/3 max-w-full px-3">
                                <div class="">
                                    <p
                                        class="mb-0 font-petro font-semibold text-neutral-900 uppercase dark:text-white dark:opacity-60 text-sm">
                                        Total Teachers</p>
                                    <h5 class="mb-2 font-bold dark:text-white">{{ $data['total']['teachers'] }}</h5>

                                </div>
                            </div>
                            <div class="px-3 text-right basis-1/3">
                                <div
                                    class="inline-block w-12 h-12 text-center rounded-circle bg-gradient-to-tl from-blue-500 to-violet-500">
                                    <i class="ni ni-money-coins text-lg relative top-3.5 text-white"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex gap-2 justify-between">
                            <p class="mb-0 dark:text-white dark:opacity-60">
                                <span
                                    class="font-bold text-neutral-900 dark:text-white text-sm text-emerald-500 mr-2">Online</span><br>
                                <span class="text-emerald-500">{{ $data['total']['online_teachers'] }}</span>
                            </p>
                            <p class="mb-0 dark:text-white dark:opacity-60">
                                <span
                                    class="font-bold text-neutral-900 dark:text-white text-sm text-emerald-500 mr-2">Offline</span><br>
                                <span class="text-emerald-500">{{ $data['total']['offline_teachers'] }}</span>
                            </p>
                            <p class="mb-0 dark:text-white dark:opacity-60">
                                <span class="font-bold text-neutral-900 dark:text-white text-sm text-emerald-500 mr-2">Both
                                </span><br>
                                <span class="text-emerald-500">{{ $data['total']['both_teachers'] }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- card2 -->
            <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
                <div
                    class="relative flex flex-col min-w-0 break-words bg-white shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                    <div class="flex-auto p-4">
                        <div class="flex flex-row -mx-3">
                            <div class="flex-none w-2/3 max-w-full px-3">
                                <div>
                                    <p
                                        class="mb-0 font-petro font-semibold text-neutral-900 uppercase dark:text-white dark:opacity-60 text-sm">
                                        Unverifed </p>
                                    <h5 class="mb-2 font-bold dark:text-white">{{ $data['unverified']['teachers'] }}</h5>

                                </div>
                            </div>
                            <div class="px-3 text-right basis-1/3">
                                <div
                                    class="inline-block w-12 h-12 text-center rounded-circle bg-gradient-to-tl from-red-600 to-orange-600">
                                    <i class="ni ni-world text-lg relative top-3.5 text-white"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex gap-2 justify-between">
                            <p class="mb-0 dark:text-white dark:opacity-60">
                                <span
                                    class="font-bold text-neutral-900 dark:text-white text-sm text-emerald-500 mr-2">Online</span><br>
                                <span class="text-emerald-500">{{ $data['unverified']['online_teachers'] }}</span>
                            </p>
                            <p class="mb-0 dark:text-white dark:opacity-60">
                                <span
                                    class="font-bold text-neutral-900 dark:text-white text-sm text-emerald-500 mr-2">Offline</span><br>
                                <span class="text-emerald-500">{{ $data['unverified']['offline_teachers'] }}</span>
                            </p>
                            <p class="mb-0 dark:text-white dark:opacity-60">
                                <span class="font-bold text-neutral-900 dark:text-white text-sm text-emerald-500 mr-2">Both
                                </span><br>
                                <span class="text-emerald-500">{{ $data['unverified']['both_teachers'] }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- card3 -->
            <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
                <div
                    class="relative flex flex-col min-w-0 break-words bg-white shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                    <div class="flex-auto p-4">
                        <div class="flex flex-row -mx-3">
                            <div class="flex-none w-2/3 max-w-full px-3">
                                <div>
                                    <p
                                        class="mb-0 font-petro font-semibold text-neutral-900 uppercase dark:text-white dark:opacity-60 text-sm">
                                        Verified </p>
                                    <h5 class="mb-2 font-bold dark:text-white">{{ $data['verified']['teachers'] }}</h5>

                                </div>
                            </div>
                            <div class="px-3 text-right basis-1/3">
                                <div
                                    class="inline-block w-12 h-12 text-center rounded-circle bg-gradient-to-tl from-emerald-500 to-teal-400">
                                    <i class="ni ni-paper-diploma text-lg relative top-3.5 text-white"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex gap-2 justify-between">
                            <p class="mb-0 dark:text-white dark:opacity-60">
                                <span
                                    class="font-bold text-neutral-900 dark:text-white text-sm text-emerald-500 mr-2">Online</span><br>
                                <span class="text-emerald-500">{{ $data['verified']['online_teachers'] }}</span>
                            </p>
                            <p class="mb-0 dark:text-white dark:opacity-60">
                                <span
                                    class="font-bold text-neutral-900 dark:text-white text-sm text-emerald-500 mr-2">Offline</span><br>
                                <span class="text-emerald-500">{{ $data['verified']['offline_teachers'] }}</span>
                            </p>
                            <p class="mb-0 dark:text-white dark:opacity-60">
                                <span class="font-bold text-neutral-900 dark:text-white text-sm text-emerald-500 mr-2">Both
                                </span><br>
                                <span class="text-emerald-500">{{ $data['verified']['both_teachers'] }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- card4 -->
            <div class="w-full max-w-full px-3 sm:w-1/2 sm:flex-none xl:w-1/4">
                <div
                    class="relative flex flex-col min-w-0 break-words bg-white shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                    <div class="flex-auto p-4">
                        <div class="flex flex-row -mx-3">
                            <div class="flex-none w-2/3 max-w-full px-3">
                                <div>
                                    <p
                                        class="mb-0 font-petro font-semibold text-neutral-900 uppercase dark:text-white dark:opacity-60 text-sm">
                                        Rejected </p>
                                    <h5 class="mb-2 font-bold dark:text-white">{{ $data['rejected']['teachers'] }}</h5>
                                </div>
                            </div>
                            <div class="px-3 text-right basis-1/3">
                                <div
                                    class="inline-block w-12 h-12 text-center rounded-circle bg-gradient-to-tl from-orange-500 to-yellow-500">
                                    <i class="bi bi-ban text-lg relative top-3.5 text-white"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex gap-2 justify-between">
                            <p class="mb-0 dark:text-white dark:opacity-60">
                                <span
                                    class="font-bold text-neutral-900 dark:text-white text-sm text-emerald-500 mr-2">Online</span><br>
                                <span class="text-emerald-500">{{ $data['rejected']['online_teachers'] }}</span>
                            </p>
                            <p class="mb-0 dark:text-white dark:opacity-60">
                                <span
                                    class="font-bold text-neutral-900 dark:text-white text-sm text-emerald-500 mr-2">Offline</span><br>
                                <span class="text-emerald-500">{{ $data['rejected']['offline_teachers'] }}</span>
                            </p>
                            <p class="mb-0 dark:text-white dark:opacity-60">
                                <span class="font-bold text-neutral-900 dark:text-white text-sm text-emerald-500 mr-2">Both
                                </span><br>
                                <span class="text-emerald-500">{{ $data['rejected']['both_teachers'] }}</span>
                            </p>
                        </div>
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
                        <div>
                            <div class="w-full max-w-full ">
                                <h6 class="dark:text-white">Teachers List</h6>
                            </div>
                            <div class="flex justify-between items-center">
                                @php
                                    $activeTab = request('tab', 'pending');
                                @endphp

                                <div class="flex mb-4 mt-2">
                                    <a href="{{ route('company.teachers.index', array_merge(request()->query(), ['tab' => 'pending'])) }}"
                                        class="px-4 py-2  text-sm font-semibold
                                    {{ $activeTab === 'pending' ? 'bg-yellow-500 text-white' : 'bg-gray-200' }}">
                                        Pending
                                    </a>

                                    <a href="{{ route('company.teachers.index', array_merge(request()->query(), ['tab' => 'approved'])) }}"
                                        class="px-4 py-2  text-sm font-semibold
                                    {{ $activeTab === 'approved' ? 'bg-emerald-500/50 text-white' : 'bg-gray-200' }}">
                                        Approved
                                    </a>

                                    <a href="{{ route('company.teachers.index', array_merge(request()->query(), ['tab' => 'rejected'])) }}"
                                        class="px-4 py-2  text-sm font-semibold
                                    {{ $activeTab === 'rejected' ? 'bg-red-500 text-white' : 'bg-gray-200' }}">
                                        Rejected
                                    </a>
                                </div>

                            </div>
                            <div class="w-full max-w-full ">
                                <form method="GET" action="{{ route('company.teachers.index') }}" id="filterForm"
                                    class="mb-4 flex flex-wrap gap-3 items-end">
                                    <input type="hidden" name="tab" value="{{ $activeTab }}" />
                                    <!-- 🔍 Search (name, email, mobile) -->
                                    <div>
                                        <label class="block text-sm font-medium mb-1">Search</label>
                                        <input type="text" name="search" value="{{ request('search') }}"
                                            placeholder="Search name, email, mobile" autocomplete="off"
                                            class="border rounded px-2 py-3 w-64">
                                    </div>

                                    <!-- 🎛 Teaching Mode -->
                                    <div>
                                        <label class="block text-sm font-medium mb-1">Teaching Mode</label>
                                        <select name="teaching_mode" class="border rounded px-2 py-3 w-32">
                                            <option value="">All</option>
                                            <option value="online"
                                                {{ request('teaching_mode') == 'online' ? 'selected' : '' }}>Online
                                            </option>
                                            <option value="offline"
                                                {{ request('teaching_mode') == 'offline' ? 'selected' : '' }}>Offline
                                            </option>
                                            <option value="both"
                                                {{ request('teaching_mode') == 'both' ? 'selected' : '' }}>Both</option>
                                        </select>
                                    </div>

                                    <!-- 🎛 Teaching Grade -->
                                    <div class="w-64">
                                        <label class="block text-sm font-medium mb-1">Teaching Grade</label>
                                        <select name="teaching_grade" id="teaching_grade"
                                            class="border rounded px-3 py-2 w-100">
                                            <option value="">All</option>
                                            @foreach ($grades as $grade)
                                                <option {{ request()->grade_id == $grade->name ? 'selected' : '' }}
                                                    value="{{ $grade->name }}">{{ $grade->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- 🎛 Teaching Boards -->
                                    {{-- <div class="w-64">
                                        <label class="block text-sm font-medium mb-1">Teaching Board</label>
                                        <select name="teaching_board" id="teaching_board"
                                            class="border rounded px-3 py-2 w-100">
                                            <option value="">All</option>
                                            @foreach ($boards as $board)
                                                <option {{ request()->board_id == $board->name ? 'selected' : '' }}
                                                    value="{{ $board->name }}">{{ $board->name }}</option>
                                            @endforeach
                                        </select>
                                    </div> --}}

                                    <!-- 🎛 Teaching Subjects -->
                                    <div class="w-64">
                                        <label class="block text-sm font-medium mb-1">Teaching Subjects</label>
                                        <select name="teaching_subject" id="teaching_subject"
                                            class="border rounded px-3 py-2 w-100">
                                            <option value="">All</option>
                                            @foreach ($subjects as $subject)
                                                <option value="{{ $subject->name }}">{{ $subject->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- 📌 Account Status -->
                                    {{-- <div>
                                        <label class="block text-sm font-medium mb-1">Account Status</label>
                                        <select name="account_status" class="border rounded px-3 py-2 w-32">
                                            <option value="">All</option>
                                            <option value="in progress"
                                                {{ request('account_status') == 'in progress' ? 'selected' : '' }}>In
                                                Progress</option>
                                            <option value="completed"
                                                {{ request('account_status') == 'completed' ? 'selected' : '' }}>Completed
                                            </option>
                                            <option value="rejected"
                                                {{ request('account_status') == 'rejected' ? 'selected' : '' }}>Rejected
                                            </option>
                                            <option value="scheduled"
                                                {{ request('account_status') == 'scheduled' ? 'selected' : '' }}>Scheduled
                                            </option>
                                        </select>
                                    </div> --}}

                                    <!-- 📍 Current Account Stage -->
                                    {{-- <div>
                                        <label class="block text-sm font-medium mb-1">Current Stage</label>
                                        <select name="current_account_stage" class="border rounded px-3 py-2 w-32">
                                            <option value="">All</option> --}}
                                    {{-- <option value="personal information"
                                                {{ request('current_account_stage') == 'personal information' ? 'selected' : '' }}>
                                                Personal Information</option>
                                            <option value="teaching information"
                                                {{ request('current_account_stage') == 'teaching information' ? 'selected' : '' }}>
                                                Teaching Information</option>
                                            <option value="cv upload"
                                                {{ request('current_account_stage') == 'cv upload' ? 'selected' : '' }}>CV --}}
                                    {{-- Upload</option> --}}
                                    {{-- <option value="verification process"
                                                {{ request('current_account_stage') == 'verification process' ? 'selected' : '' }}>
                                                Verification Process</option>
                                            <option value="schedule interview"
                                                {{ request('current_account_stage') == 'schedule interview' ? 'selected' : '' }}>
                                                Schedule Interview</option>
                                            <option value="upload demo class"
                                                {{ request('current_account_stage') == 'upload demo class' ? 'selected' : '' }}>
                                                Upload Demo Class</option> --}}
                                    {{-- </select>
                                    </div> --}}

                                    <!-- Submit + Reset -->
                                    <div class="flex gap-2">
                                        <button type="submit"
                                            class="px-4 py-2 bg-gradient-to-tl from-emerald-500 to-teal-400  text-white rounded text-sm"><i
                                                class="bi bi-search"></i> Apply</button>
                                        <a href="{{ route('company.teachers.index') }}"
                                            class="px-4 py-2 bg-gradient-to-tl from-emerald-500 to-teal-400  rounded text-white text-sm"><i
                                                class="bi bi-arrow-clockwise"></i> Reset </a>
                                        <a href="{{ route('company.teachers.export', request()->query()) }}"
                                            class="px-4 py-2 bg-gradient-to-tl from-emerald-500 to-teal-400  text-white rounded text-sm">
                                            <i class="bi bi-file-earmark-spreadsheet"></i>
                                            Export Excel
                                        </a>

                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                    @php
                        $activeFilters = collect(
                            request()->only([
                                'search',
                                'teaching_mode',
                                'account_status',
                                'teaching_board',
                                'teaching_grade',
                                'teaching_subject',
                            ]),
                        )->filter(fn($value) => filled($value)); // remove null/empty
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
                            <a href="{{ route('company.teachers.index') }}"
                                class="ml-3 mt-2.5 text-sm text-red-600">Clear
                                All</a>
                        </div>
                    @endif

                    <div id="teacherTable">
                        @include('company.teachers.table')
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        $(document).ready(function() {
            initInfiniteTable({
                container: '#teacherTable',
                form: '#filterForm',
                url: "{{ route('company.teachers.index') }}",
                tab : "{{ $activeTab }}",
                liveSearch: true,
            });
        });
    </script>
@endpush



{{--
@push('scripts')
    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
    <script>
        // Initialize TomSelect ONCE
        $(document).ready(function() {
            new TomSelect("#teaching_grade", {
                plugins: ['remove_button'],
                placeholder: "Select Grade",
                create: false,
                persist: false,
                closeAfterSelect: true,
                hideSelected: true,
                maxOptions: 1000
            });

            // new TomSelect("#teaching_board", {
            //     plugins: ['remove_button'],
            //     placeholder: "Select Board",
            //     create: false,
            //     persist: false,
            //     closeAfterSelect: true,
            //     hideSelected: true,
            //     maxOptions: 1000
            // });

            new TomSelect("#teaching_subject", {
                plugins: ['remove_button'],
                placeholder: "Select Subjects",
                create: false,
                persist: false,
                closeAfterSelect: true,
                hideSelected: true,
                maxOptions: 1000
            });
        });
    </script>
@endpush --}}
