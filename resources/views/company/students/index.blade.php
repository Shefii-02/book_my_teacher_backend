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
                aria-current="page">Students List</li>
        </ol>
        <h6 class="mb-0 font-bold text-white capitalize">Students List</h6>
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
                                        Total Students</p>
                                    <h5 class="mb-2 font-bold dark:text-white">{{ $data['total']['students'] }}</h5>

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
                                <span class="text-emerald-500">{{ $data['total']['online_students'] }}</span>
                            </p>
                            <p class="mb-0 dark:text-white dark:opacity-60">
                                <span
                                    class="font-bold text-neutral-900 dark:text-white text-sm text-emerald-500 mr-2">Offline</span><br>
                                <span class="text-emerald-500">{{ $data['total']['offline_students'] }}</span>
                            </p>
                            <p class="mb-0 dark:text-white dark:opacity-60">
                                <span class="font-bold text-neutral-900 dark:text-white text-sm text-emerald-500 mr-2">Both
                                </span><br>
                                <span class="text-emerald-500">{{ $data['total']['both_students'] }}</span>
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
                                        Course Joined </p>
                                    <h5 class="mb-2 font-bold dark:text-white">{{ $data['joined']['students'] }}</h5>

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
                                <span class="text-emerald-500">{{ $data['joined']['online_students'] }}</span>
                            </p>
                            <p class="mb-0 dark:text-white dark:opacity-60">
                                <span
                                    class="font-bold text-neutral-900 dark:text-white text-sm text-emerald-500 mr-2">Offline</span><br>
                                <span class="text-emerald-500">{{ $data['joined']['offline_students'] }}</span>
                            </p>
                            <p class="mb-0 dark:text-white dark:opacity-60">
                                <span class="font-bold text-neutral-900 dark:text-white text-sm text-emerald-500 mr-2">Both
                                </span><br>
                                <span class="text-emerald-500">{{ $data['joined']['both_students'] }}</span>
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
                                        Course UnJoined </p>
                                    <h5 class="mb-2 font-bold dark:text-white">{{ $data['unjoined']['students'] }}</h5>

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
                                <span class="text-emerald-500">{{ $data['unjoined']['online_students'] }}</span>
                            </p>
                            <p class="mb-0 dark:text-white dark:opacity-60">
                                <span
                                    class="font-bold text-neutral-900 dark:text-white text-sm text-emerald-500 mr-2">Offline</span><br>
                                <span class="text-emerald-500">{{ $data['unjoined']['offline_students'] }}</span>
                            </p>
                            <p class="mb-0 dark:text-white dark:opacity-60">
                                <span class="font-bold text-neutral-900 dark:text-white text-sm text-emerald-500 mr-2">Both
                                </span><br>
                                <span class="text-emerald-500">{{ $data['unjoined']['both_students'] }}</span>
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
                                        Non Active </p>
                                    <h5 class="mb-2 font-bold dark:text-white">{{ $data['unactive']['students'] }}</h5>
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
                                <span class="text-emerald-500">{{ $data['unactive']['online_students'] }}</span>
                            </p>
                            <p class="mb-0 dark:text-white dark:opacity-60">
                                <span
                                    class="font-bold text-neutral-900 dark:text-white text-sm text-emerald-500 mr-2">Offline</span><br>
                                <span class="text-emerald-500">{{ $data['unactive']['offline_students'] }}</span>
                            </p>
                            <p class="mb-0 dark:text-white dark:opacity-60">
                                <span class="font-bold text-neutral-900 dark:text-white text-sm text-emerald-500 mr-2">Both
                                </span><br>
                                <span class="text-emerald-500">{{ $data['unactive']['both_students'] }}</span>
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
                        <div class="flex">
                            <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
                                <h6 class="dark:text-white">Students List</h6>
                            </div>


                        </div>
                        <div class="w-full max-w-full ">
                            @php
                                $activeTab = request('tab', 'pending');
                            @endphp

                            <!-- Filters -->
                            <form method="GET" action="{{ route('company.students.index') }}"
                                class="flex flex-wrap gap-4 mb-6 items-end">

                                <!-- Search -->
                                <div>
                                    <label class="text-sm block mb-1">Search</label>
                                    <input type="text" name="search" value="{{ request('search') }}"
                                        placeholder="Name / Email / Mobile" class="border rounded-lg px-3 py-2 w-60">
                                </div>

                                <!-- Study Mode -->
                                <div>
                                    <label class="text-sm block mb-1">Class Mode</label>
                                    <select name="class_mode" class="border rounded-lg px-3 py-2">
                                        <option value="">All</option>
                                        <option value="online" {{ request('class_mode') == 'online' ? 'selected' : '' }}>
                                            Online
                                        </option>
                                        <option value="offline"
                                            {{ request('class_mode') == 'offline' ? 'selected' : '' }}>
                                            Offline</option>
                                        <option value="both" {{ request('teaching_mode') == 'both' ? 'selected' : '' }}>
                                            Both
                                        </option>
                                    </select>
                                </div>

                                <!-- Grade -->
                                <div>
                                    <label class="text-sm block mb-1">Grade</label>
                                    <select name="learn_grade" class="border rounded-lg px-3 py-2">
                                        <option value="">All</option>
                                        @foreach ($grades ?? [] as $grade)
                                            <option value="{{ $grade->name }}"
                                                {{ request('learn_grade') == $grade->name ? 'selected' : '' }}>
                                                {{ $grade->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Subject -->
                                <div>
                                    <label class="text-sm block mb-1">Subject</label>
                                    <select name="learn_subject" class="border rounded-lg px-3 py-2">
                                        <option value="">All</option>
                                        @foreach ($subjects ?? [] as $subject)
                                            <option value="{{ $subject->name }}"
                                                {{ request('learn_subject') == $subject->name ? 'selected' : '' }}>
                                                {{ $subject->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Admission Status -->
                                {{-- <div>
                                    <label class="text-sm block mb-1">Admission</label>
                                    <select name="admisison_status" class="border rounded-lg px-3 py-2">
                                        <option value="">All</option>
                                        <option value="on-going"
                                            {{ request('admisison_status') == 'on-going' ? 'selected' : '' }}>
                                            On Going</option>
                                        <option value="compelted-expried"
                                            {{ request('admisison_status') == 'compelted-expried' ? 'selected' : '' }}>
                                            Completed
                                        </option>
                                        <option value="un-purchased"
                                            {{ request('admisison_status') == 'un-purchased' ? 'selected' : '' }}>
                                            Unpurchased
                                        </option>
                                    </select>
                                </div> --}}

                                <!-- Submit + Reset -->
                                <div class="flex gap-2 items-baseline ">
                                  <div class="flex gap-2">
                                    <button type="submit"
                                        class="px-4 py-2 bg-gradient-to-tl from-emerald-500 to-teal-400  text-white rounded text-sm"><i
                                            class="bi bi-search"></i> Apply</button>
                                    <a href="{{ route('company.students.index') }}"
                                        class="px-4 py-2 bg-gradient-to-tl from-emerald-500 to-teal-400  rounded text-white text-sm"><i
                                            class="bi bi-arrow-clockwise"></i> Reset </a>
                                    {{-- <a href="{{ route('company.students.export', request()->query()) }}"
                                        class="px-4 py-2 bg-gradient-to-tl from-emerald-500 to-teal-400  text-white rounded text-sm">
                                        <i class="bi bi-file-earmark-spreadsheet"></i>
                                        Export Excel
                                    </a> --}}

                                  </div>
                                    @php
                                        $activeFilters = collect(
                                            request()->only([
                                                'search',
                                                'class_mode',
                                                'learn_grade',
                                                'learn_subject',
                                                'teaching_grade',
                                                'teaching_subject',
                                            ]),
                                        )->filter(fn($value) => filled($value)); // remove null/empty
                                    @endphp

                                    @if ($activeFilters->isNotEmpty())
                                        <div class="mb-4 pl-9 flex flex-wrap gap-2">
                                            @foreach ($activeFilters as $key => $value)
                                                <div
                                                    class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full flex items-center">
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
                                </div>

                            </form>


                        </div>
                    </div>
                    <div class="p-6">


                        <!-- Table -->
                        <div class="overflow-x-auto">

                            <table class="w-full text-sm">

                                <thead class="bg-gray-100 text-gray-600">
                                    <tr>
                                        <th class="p-3 text-left">Student</th>
                                        <th class="p-3 text-left">Parent</th>
                                        <th class="p-3 text-left">Grade</th>
                                        <th class="p-3 text-left">Mode</th>
                                        <th class="p-3 text-center">Status</th>
                                        <th class="p-3 text-center">Created</th>
                                        <th class="p-3 text-center">Action</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @forelse($students as $key => $student)
                                        @php
                                            $subjects = $student->recommendedSubjects->pluck('subject')->toArray();
                                            $grades = $student->studentGrades->pluck('grade')->toArray();
                                            $grades_val = implode(',', $grades);
                                            $sub_val = implode(',', $subjects);
                                            $mode = $student->studentPersonalInfo?->study_mode;
                                        @endphp

                                        <tr class="border-b">

                                            <!-- Student -->
                                            <td class="p-3">
                                                <div class="flex items-center gap-3">

                                                    <img src="{{ $student->avatar_url }}" class="w-10 h-10 rounded-lg">

                                                    <div>
                                                        <p class="font-semibold">{{ $student->name }}</p>
                                                        <p class="text-xs text-gray-500">{{ $student->email }}</p>
                                                        <p class="text-xs text-gray-500">{{ $student->mobile }}</p>
                                                    </div>

                                                </div>
                                            </td>


                                            <!-- Address -->
                                            <td class="p-3 text-xs text-gray-600">
                                                {{ $student->studentPersonalInfo->parent_name }}
                                            </td>


                                            <!-- Grade -->
                                            <td class="p-3 capitalize" role="button"
                                                title="{{ $grades_val . '(' . $sub_val . ')' }}">
                                                <p class="text-sm">
                                                    @if ($grades_val)
                                                        {{ Str::limit($grades_val, 20) }}<br>
                                                        ({{ Str::limit($sub_val, 20) }})
                                                    @else
                                                        Please update
                                                    @endif
                                                </p>
                                            </td>


                                            <!-- Subjects -->
                                            <td class="p-3">

                                                @if ($mode == 'online')
                                                    <span class="bg-primary text-white px-2 py-1 text-xs rounded">
                                                        Online
                                                    </span>
                                                @elseif($mode == 'offline')
                                                    <span class="bg-info text-white px-2 py-1 text-xs rounded">
                                                        Offline
                                                    </span>
                                                @elseif($mode == 'both')
                                                    <span class="bg-blue-500 text-white px-2 py-1 text-xs rounded">
                                                        Both
                                                    </span>
                                                @else
                                                @endif
                                            </td>

                                            <!-- Status -->
                                            <td class="p-3 text-center">

                                                @if ($student->status == '1')
                                                    <span class="bg-success text-white px-2 py-1 text-xs rounded">
                                                        Active
                                                    </span>
                                                @elseif($student->status == '0')
                                                    <span class="bg-gray-500 text-white px-2 py-1 text-xs rounded">
                                                        In Active
                                                    </span>
                                                @else
                                                    <span class="bg-blue-500 text-white px-2 py-1 text-xs rounded">
                                                        --
                                                    </span>
                                                @endif

                                            </td>


                                            <!-- Created -->
                                            <td class="p-3 text-center text-xs">
                                                {{ $student->created_at->format('d M Y') }}
                                            </td>


                                            <!-- Actions -->
                                            <td class="p-3 ">
                                                <button id="dropdownBottomButton"
                                                    data-dropdown-toggle="dropdownBottom_{{ $key }}"
                                                    data-dropdown-placement="bottom" class="" type="button"> <svg
                                                        class="w-6 h-6 text-gray-800 dark:text-white text-right"
                                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                        width="24" height="24" fill="none"
                                                        viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-width="2" d="M12 6h.01M12 12h.01M12 18h.01" />
                                                    </svg> </button> <!-- Dropdown menu -->
                                                <div id="dropdownBottom_{{ $key }}"
                                                    class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700">
                                                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                                        aria-labelledby="dropdownBottomButton">
                                                        <li> <a href="{{ route('company.students.overview', $student->id) }}"
                                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-white dark:hover:text-white">View</a>
                                                        </li>
                                                        <li> <a href="{{ route('company.students.edit', $student->id) }}"
                                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-white dark:hover:text-white">Edit</a>
                                                        </li> {{-- <li> <a href="{{ route('company.students.login-security', $student->id) }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-white dark:hover:text-white">Login Security</a> </li> --}} <li>
                                                            <form id="form_{{ $student->id }}" class="m-0 p-0"
                                                                action="{{ route('company.students.destroy', $student->id) }}"
                                                                method="POST" class="inline-block"> @csrf
                                                                @method('DELETE') </form> <a role="button"
                                                                href="javascript:;"
                                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-white dark:hover:text-white"
                                                                onclick="confirmDelete({{ $student->id }})">Delete</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>



                                        </tr>

                                    @empty

                                        <tr>
                                            <td colspan="7" class="text-center p-6 text-gray-500">
                                                No students found
                                            </td>
                                        </tr>
                                    @endforelse

                                </tbody>

                            </table>

                        </div>


                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $students->links() }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
