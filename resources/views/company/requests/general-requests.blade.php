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
                aria-current="page">Request Form Lead List</li>
        </ol>
        <h6 class="mb-0 font-bold text-white capitalize">Request Form Lead List</h6>
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
                                        Total Leads</p>
                                    <h5 class="mb-2 font-bold dark:text-white">{{ $data['total']['teachers'] ?? 0 }}</h5>

                                </div>
                            </div>
                            <div class="px-3 text-right basis-1/3">
                                <div
                                    class="inline-block w-12 h-12 text-center rounded-circle bg-gradient-to-tl from-blue-500 to-violet-500">
                                    <i class="ni ni-money-coins text-lg relative top-3.5 text-white"></i>
                                </div>
                            </div>
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
                                        Pending </p>
                                    <h5 class="mb-2 font-bold dark:text-white">{{ $data['unverified']['teachers'] ?? 0 }}
                                    </h5>

                                </div>
                            </div>
                            <div class="px-3 text-right basis-1/3">
                                <div
                                    class="inline-block w-12 h-12 text-center rounded-circle bg-gradient-to-tl from-red-600 to-orange-600">
                                    <i class="ni ni-world text-lg relative top-3.5 text-white"></i>
                                </div>
                            </div>
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
                                        Converted </p>
                                    <h5 class="mb-2 font-bold dark:text-white">{{ $data['verified']['teachers'] ?? 0 }}</h5>

                                </div>
                            </div>
                            <div class="px-3 text-right basis-1/3">
                                <div
                                    class="inline-block w-12 h-12 text-center rounded-circle bg-gradient-to-tl from-emerald-500 to-teal-400">
                                    <i class="ni ni-paper-diploma text-lg relative top-3.5 text-white"></i>
                                </div>
                            </div>
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
                                    <h5 class="mb-2 font-bold dark:text-white">{{ $data['rejected']['teachers'] ?? 0 }}</h5>
                                </div>
                            </div>
                            <div class="px-3 text-right basis-1/3">
                                <div
                                    class="inline-block w-12 h-12 text-center rounded-circle bg-gradient-to-tl from-orange-500 to-yellow-500">
                                    <i class="bi bi-ban text-lg relative top-3.5 text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- cards -->
    <div class="w-full px-6  mx-auto">

        <div class="flex flex-wrap -mx-3 mt-4">
            <div class="flex-none w-full max-w-full px-3">
                <div
                    class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">


                    <div class="p-6 pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                        <div class="flex flex-col border-bottom mb-2">
                            <div class="w-full max-w-full mb-3 flex justify-between">
                                <h6 class="dark:text-white">Request From Class Requests (Leads)</h6>
                                <button class="btn bg-gradient-to-tl from-emerald-500 to-teal-400 text-light btn-sm"><i
                                        class="bi bi-plus"></i> Create</button>
                            </div>
                        </div>

                        <div class="flex flex-col">
                            @php
                                $activeTab = request('tab', 'pending');
                            @endphp
                        </div>
                        <div class="flex justify-between items-end">
                            <div class="flex mb-4 mt-2">
                                <a href="{{ route('company.requests.form-class.index', array_merge(request()->query(), ['tab' => 'pending'])) }}"
                                    class="px-4 py-2  text-sm font-semibold
                                    {{ $activeTab === 'pending' ? 'bg-yellow-500 text-white' : 'bg-gray-200' }}">
                                    Pending
                                </a>

                                <a href="{{ route('company.requests.form-class.index', array_merge(request()->query(), ['tab' => 'approved'])) }}"
                                    class="px-4 py-2  text-sm font-semibold
                                    {{ $activeTab === 'approved' ? 'bg-emerald-500/50 text-white' : 'bg-gray-200' }}">
                                    Converted
                                </a>

                                <a href="{{ route('company.requests.form-class.index', array_merge(request()->query(), ['tab' => 'rejected'])) }}"
                                    class="px-4 py-2  text-sm font-semibold
                                    {{ $activeTab === 'rejected' ? 'bg-red-500 text-white' : 'bg-gray-200' }}">
                                    Rejected
                                </a>
                            </div>
                            <div class="">
                                <form method="GET" action="{{ route('company.requests.form-class.index') }}"
                                    class="mb-4 flex flex-wrap gap-3 items-end">
                                    <input type="hidden" name="tab" value="{{ $activeTab }}" />
                                    <!-- 🔍 Search (name, email, mobile) -->
                                    <div class="flex gap-2 items-center">
                                        <label class="block text-sm font-medium mb-1">Search</label>
                                        <input type="text" name="search" value="{{ request('search') }}"
                                            placeholder="Search name, email, mobile" class="border rounded px-3 py-2 w-64">
                                    </div>

                                    <!-- Submit + Reset -->
                                    <div class="flex gap-2">
                                        <button type="submit"
                                            class="px-4 py-2 bg-gradient-to-tl from-emerald-500 to-teal-400  text-white rounded text-sm"><i
                                                class="bi bi-search"></i> Apply</button>
                                        <a href="{{ route('company.requests.form-class.index') }}"
                                            class="px-4 py-2 bg-gradient-to-tl from-emerald-500 to-teal-400  rounded text-white text-sm"><i
                                                class="bi bi-arrow-clockwise"></i> Reset </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @php
                        $activeFilters = collect(
                            request()->only(['search', 'teaching_mode', 'account_status', 'current_account_stage']),
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


                    <div class="flex-auto px-0 pt-0 pb-2">
                        <div class="p-4 overflow-x-auto">
                            <table
                                class="items-center w-full mb-0 align-top border-collapse dark:border-white/40 text-slate-500">

                                <thead class="align-bottom">
                                    <tr>
                                        <th
                                            class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                            Student</th>
                                        <th
                                            class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                            Location</th>
                                        <th
                                            class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                            Grade</th>
                                        <th
                                            class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                            Board</th>
                                        <th
                                            class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                            Subject</th>
                                        <th
                                            class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                            Status</th>
                                        <th
                                            class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                            Note</th>
                                        <th
                                            class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                            Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($requests as $key => $lead)
                                        <tr class="border-b">
                                            <td class="p-3">
                                                <div class="font-semibold">
                                                    <a href="{{ route('company.student-details', $lead->user->id) }}"
                                                        target="user-details">
                                                        {{ $lead->user->name ?? '—' }}</a>
                                                </div>
                                                <div class="text-xs text-gray-500">{{ $lead->user->mobile ?? '' }}</div>
                                            </td>

                                            <td>{{ $lead->from_location }}</td>
                                            <td>{{ $lead->grade }}</td>
                                            <td>{{ $lead->board }}</td>
                                            <td>{{ $lead->subject }}</td>

                                            <td>

                                                {!! $lead->status_badge !!}
                                            </td>

                                            <td class="max-w-xs text-xs">
                                                {{ $lead->note ?? '—' }}
                                            </td>
                                            <td
                                                class="p-2 align-middle bg-transparent border-b dark:border-white/40  shadow-transparent">
                                                <button id="dropdownBottomButton"
                                                    data-dropdown-toggle="dropdownBottom_{{ $key }}"
                                                    data-dropdown-placement="bottom" class="" type="button">
                                                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        fill="none" viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-width="2" d="M12 6h.01M12 12h.01M12 18h.01" />
                                                    </svg>
                                                </button>

                                                <!-- Dropdown menu -->
                                                <div id="dropdownBottom_{{ $key }}"
                                                    class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700">
                                                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                                        aria-labelledby="dropdownBottomButton">
                                                        <li>
                                                            <a target="_new" href="{{ route('company.student-details', $lead->user->id) }}"
                                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-white dark:hover:text-white">Student
                                                                View</a>
                                                        </li>
                                                        <li>
                                                            <a role="button" data-url="{{ route('company.requests.form-class.show', $lead->id) }}"
                                                                class="block px-4 py-2 open-drawer hover:bg-gray-100 dark:hover:bg-white dark:hover:text-white">Lead View</a>
                                                        </li>

                                                        <li>
                                                            <a role="button" data-url="{{ route('company.requests.form-class.edit', $lead->id) }}"
                                                                class="block px-4 py-2 open-drawer hover:bg-gray-100 dark:hover:bg-white dark:hover:text-white">Edit</a>
                                                        </li>
                                                        @if($lead->status == 'closed')
                                                        <li>
                                                            <form id="form_{{ $lead->id }}" class="m-0 p-0"
                                                                action="{{ route('company.requests.form-class.destroy', $lead->id) }}"
                                                                method="POST" class="inline-block">
                                                                @csrf @method('DELETE') </form>
                                                            <a role="button" href="javascript:;"
                                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-white dark:hover:text-white"
                                                                onclick="confirmDelete({{ $lead->id }})">Delete</a>

                                                        </li>
                                                        @endif
                                                    </ul>
                                                </div>

                                            </td>

                                        </tr>


                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="p-4">
                            {{ $requests->links() }}
                        </div>
                    </div>

                </div>

            @endsection
