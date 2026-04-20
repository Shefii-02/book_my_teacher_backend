@extends('layouts.layout')

@section('nav-options')
    <nav>
        <!-- breadcrumb -->
        <ol class="flex flex-wrap pt-1 mr-12 bg-transparent rounded-lg sm:mr-16">
            <li class="leading-normal text-sm">
                <a class="text-white " href="javascript:;">Home</a>
            </li>
            <li class="text-sm pl-2 capitalize font-bold text-white before:float-left before:pr-2 before:text-white before:content-['/']"
                aria-current="page">Dashboard</li>
        </ol>
        <h6 class="mb-0 font-bold text-white capitalize">Dashboard</h6>
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
                                <div>
                                    <p
                                        class="mb-0 font-petro font-semibold leading-normal uppercase text-neutral-900 dark:text-white dark:opacity-60 text-sm">
                                        Total Students</p>
                                    <h5 class="mb-2 font-bold dark:text-white">{{ $data['students']['total'] }}</h5>
                                    <p class="mb-0 dark:text-white text-neutral-900 dark:opacity-60">
                                        <span class="font-bold leading-normal text-sm text-emerald-500">
                                            Last Week Reg :
                                        </span>
                                        <span class="font-bold">{{ $data['students']['last_week'] }}</span>
                                    </p>
                                </div>
                            </div>
                            <div class="px-3 text-right basis-1/3">
                                <div
                                    class="inline-block w-12 h-12 text-center rounded-circle bg-gradient-to-tl from-blue-500 to-violet-500">
                                    <i class="ni ni-single-02 text-lg relative mt-2 text-white"></i>
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
                                        class="mb-0 font-petro font-semibold leading-normal text-neutral-900 uppercase dark:text-white dark:opacity-60 text-sm">
                                        Total Teachers</p>
                                    <h5 class="mb-2 font-bold dark:text-white">{{ $data['teachers']['total'] }}</h5>
                                    <p class="mb-0 dark:text-white text-neutral-900 dark:opacity-60">
                                        <span class="font-bold leading-normal text-sm text-emerald-500">Last Week
                                            Reg:</span>
                                        <span class="font-bold">{{ $data['teachers']['total'] }}</span>
                                    </p>
                                </div>
                            </div>
                            <div class="px-3 text-right basis-1/3">
                                <div
                                    class="inline-block w-12 h-12 text-center rounded-circle bg-gradient-to-tl from-red-600 to-orange-600">
                                    <i class="ni ni-hat-3 text-lg relative mt-2 text-white"></i>
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
                                        class="mb-0 text-neutral-900 font-petro font-semibold leading-normal uppercase dark:text-white dark:opacity-60 text-sm">
                                        Total Class's</p>
                                    <h5 class="mb-2 font-bold dark:text-white">{{ $data['classes']['total'] }}</h5>
                                    <p class="mb-0 dark:text-white dark:opacity-60">
                                        <span class="font-bold leading-normal  text-sm text-emerald-500">
                                            Last Week Created :</span>
                                        <span class="font-bold text-neutral-900">{{ $data['classes']['total'] }}</span>
                                    </p>
                                </div>
                            </div>
                            <div class="px-3 text-right basis-1/3">
                                <div
                                    class="inline-block w-12 h-12 text-center rounded-circle bg-gradient-to-tl from-emerald-500 to-teal-400">
                                    <i class="ni ni-tv-2 text-lg relative mt-2 text-white"></i>
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
                                        class="mb-0 text-neutral-900 font-petro font-semibold leading-normal uppercase dark:text-white dark:opacity-60 text-sm">
                                        Total Revenue</p>
                                    <h5 class="mb-2 font-bold dark:text-white">₹{{ $data['revenue']['total'] }}</h5>
                                    <p class="mb-0 text-neutral-900 dark:text-white dark:opacity-60">
                                        <span class="font-bold leading-normal text-sm text-emerald-500">Last Week Revenue :
                                        </span>
                                        <span class="font-bold">{{ $data['revenue']['total'] }}</span>
                                    </p>
                                </div>
                            </div>
                            <div class="px-3 text-right basis-1/3">
                                <div
                                    class="inline-block w-12 h-12 text-center rounded-circle bg-gradient-to-tl from-orange-500 to-yellow-500">
                                    <i class="ni ni-money-coins text-lg relative mt-2 text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- cards row 2 -->
        <div class="flex flex-wrap mt-6 -mx-3">
            <div class="w-full max-w-full px-3 mt-0 mb-6 lg:mb-0  lg:flex-none">
                <div
                    class="border-black/12.5 dark:bg-slate-850 dark:shadow-dark-xl shadow-xl relative z-20 flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid bg-white bg-clip-border">
                    <div
                        class="border-black/12.5 mb-0 rounded-t-2xl border-b-0 border-solid p-6 pt-4 pb-0 flex justify-between">
                        <h6 class="capitalize dark:text-white">Overall overview</h6>
                        <div class="mb-0 leading-normal dark:text-white dark:opacity-60 text-sm">
                            <select id="analyticsFilter" class="border rounded text-dark px-2 py-1 text-sm">
                                <option value="7_days" selected>Last 7 Days</option>
                                <option value="5_weeks">Last 5 Weeks</option>
                                <option value="5_months">Last 5 Months</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex-auto p-4">
                        <div>
                            <canvas id="overallAnalyticsChart" height="300">
                                  No data available
                            </canvas>

                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full max-w-full px-3 my-5 lg:w-7/12 lg:flex-none">
                <div
                    class="relative flex flex-col min-w-0 break-words bg-white border-0 border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl dark:bg-gray-950 border-black-125 rounded-2xl bg-clip-border">
                    <div class="flex p-3 justify-between items-center">
                        <h6 class="mb-2 dark:text-white">Analytics</h6>

                        <select id="tableFilter" class="border rounded px-2 py-1 text-sm">
                            <option value="7_days" selected>Last 7 Days</option>
                            <option value="5_weeks">Last 5 Weeks</option>
                            <option value="5_months">Last 5 Months</option>
                        </select>
                    </div>
                    <div class="overflow-x-auto">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-2 mx-3">
                                <thead>
                                    <tr>
                                        <th>Metric</th>
                                        <th class="text-capitalize font-monospace">Web</th>
                                        <th class="text-capitalize font-monospace">Android</th>
                                        <th class="text-capitalize font-monospace">iOS</th>
                                    </tr>
                                </thead>

                                <tbody class="p-3 border">
                                    <tr>
                                        <td class="font-weight-bold">Visitors</td>
                                        <td id="web_visitors"></td>
                                        <td id="android_visitors"></td>
                                        <td id="ios_visitors"></td>
                                    </tr>

                                    <tr>
                                        <td class="font-weight-bold">Buy Now Clicks</td>
                                        <td id="web_buy"></td>
                                        <td id="android_buy"></td>
                                        <td id="ios_buy"></td>
                                    </tr>

                                    <tr>
                                        <td class="font-weight-bold">New Students</td>
                                        <td id="web_students"></td>
                                        <td id="android_students"></td>
                                        <td id="ios_students"></td>
                                    </tr>

                                    <tr>
                                        <td class="font-weight-bold">New Teachers</td>
                                        <td id="web_teachers"></td>
                                        <td id="android_teachers"></td>
                                        <td id="ios_teachers"></td>
                                    </tr>

                                    <tr>
                                        <td class="font-weight-bold">Purchases</td>
                                        <td id="web_purchases"></td>
                                        <td id="android_purchases"></td>
                                        <td id="ios_purchases"></td>
                                    </tr>

                                    <tr>
                                        <td class="font-weight-bold">Total Revenue (₹)</td>
                                        <td id="web_revenue" class="text-success font-weight-bold"></td>
                                        <td id="android_revenue" class="text-success font-weight-bold"></td>
                                        <td id="ios_revenue" class="text-success font-weight-bold"></td>
                                    </tr>
                                    {{-- <tr>
                                        <td class="font-weight-bold">Visitors</td>
                                        <td>{{ $analytics['web']['visitors_count'] }}</td>
                                        <td>{{ $analytics['android']['visitors_count'] }}</td>
                                        <td>{{ $analytics['ios']['visitors_count'] }}</td>
                                    </tr>

                                    <tr>
                                        <td class="font-weight-bold">Buy Now Clicks</td>
                                        <td>{{ $analytics['web']['buy_now_click_count'] }}</td>
                                        <td>{{ $analytics['android']['buy_now_click_count'] }}</td>
                                        <td>{{ $analytics['ios']['buy_now_click_count'] }}</td>
                                    </tr>

                                    <tr>
                                        <td class="font-weight-bold">New Students</td>
                                        <td>{{ $analytics['web']['new_students_count'] }}</td>
                                        <td>{{ $analytics['android']['new_students_count'] }}</td>
                                        <td>{{ $analytics['ios']['new_students_count'] }}</td>
                                    </tr>

                                    <tr>
                                        <td class="font-weight-bold">New Teachers</td>
                                        <td>{{ $analytics['web']['new_teachers_count'] }}</td>
                                        <td>{{ $analytics['android']['new_teachers_count'] }}</td>
                                        <td>{{ $analytics['ios']['new_teachers_count'] }}</td>
                                    </tr>

                                    <tr>
                                        <td class="font-weight-bold">Purchases</td>
                                        <td>{{ $analytics['web']['total_purchases_count'] }}</td>
                                        <td>{{ $analytics['android']['total_purchases_count'] }}</td>
                                        <td>{{ $analytics['ios']['total_purchases_count'] }}</td>
                                    </tr>

                                    <tr>
                                        <td class="font-weight-bold">Total Revenue (₹)</td>
                                        <td class="text-success font-weight-bold">
                                            ₹{{ number_format($analytics['web']['total_revenue']) }}
                                        </td>
                                        <td class="text-success font-weight-bold">
                                            ₹{{ number_format($analytics['android']['total_revenue']) }}
                                        </td>
                                        <td class="text-success font-weight-bold">
                                            ₹{{ number_format($analytics['ios']['total_revenue']) }}
                                        </td>
                                    </tr> --}}

                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>

            <div
                class="w-full max-w-full px-3 lg:w-5/12 my-5 lg:flex-none bg-white  border-black/12.5 dark:bg-slate-850 dark:shadow-dark-xl shadow-xl relative z-20 flex min-w-0 flex-col break-words rounded-2xl border-solid bg-white bg-clip-border">
                <div
                    class="border-black/12.5 dark:bg-slate-850  relative z-20 flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid  bg-clip-border">
                    <div class="border-black/12.5 mb-0 rounded-t-2xl border-b-0 border-solid p-4 pb-0">
                        <h6 class="capitalize dark:text-white">Lead Requests</h6>

                    </div>
                    <div class="flex-auto">
                        <div class="relative w-full h-full overflow-hidden rounded-2xl">
                            <div class="max-w-5xl mx-auto mx-2">

                                <!-- Tabs -->
                                <div class="flex  border-b bg-black justify-content-between">
                                    <button onclick="openTab('general')"
                                        class="tab-btn px-4 py-2 font-semibold text-light bg-emerald-500/50">
                                        General <span
                                            class="bg-blue-600 text-white text-xs px-2 py-1 rounded-full ml-1">{{ $generalRequests->count() }}</span>
                                    </button>

                                    <button onclick="openTab('teacher')"
                                        class="tab-btn px-4 py-2 font-semibold text-light">
                                        Teacher Class
                                        <span
                                            class="bg-blue-600 text-white text-xs px-2 py-1 rounded-full ml-1">{{ $teacherRequests->count() }}</span>
                                    </button>

                                    <button onclick="openTab('course')"
                                        class="tab-btn px-4 py-2 font-semibold text-light">
                                        Course
                                        <span
                                            class="bg-blue-600 text-white text-xs px-2 py-1 rounded-full ml-1">{{ $courseRequests->count() }}</span>
                                    </button>
                                </div>

                                <!-- GENERAL TAB -->
                                <div id="general" class="tab-content">
                                    <div class="">
                                        <table
                                            class="items-center w-full mb-0 align-top border-collapse dark:border-white/40 text-slate-500">

                                            <thead class="align-bottom">
                                                <tr>
                                                    <th
                                                        class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                                        Student</th>
                                                    <th
                                                        class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                                        Grade</th>
                                                    <th
                                                        class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                                        Status</th>
                                                    <th
                                                        class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                                        Created At</th>
                                                    <th
                                                        class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                                        Action</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @forelse ($generalRequests ?? [] as $key => $lead)
                                                    <tr class="border-b">
                                                        <td class="p-3">
                                                            <div class="font-semibold">
                                                                <a href="{{ route('company.student-details', $lead->user->id) }}"
                                                                    target="user-details">
                                                                    {{ $lead->user->name ?? '—' }}</a>
                                                            </div>
                                                            <div class="text-xs text-gray-500">
                                                                {{ $lead->user->mobile ?? '' }}</div>
                                                        </td>
                                                        <td>{{ $lead->grade }}</td>
                                                        <td>
                                                            {!! $lead->status_badge !!}
                                                        </td>

                                                        <td class="max-w-xs text-xs">
                                                            {{ $lead->created_at ?? '—' }}
                                                        </td>
                                                        <td
                                                            class="p-2 align-middle bg-transparent border-b dark:border-white/40  shadow-transparent">
                                                            <button id="dropdownBottomButton"
                                                                data-dropdown-toggle="dropdownBottom_{{ $key }}001"
                                                                data-dropdown-placement="bottom" class=""
                                                                type="button">
                                                                <svg class="w-6 h-6 text-gray-800 dark:text-white"
                                                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                                    width="24" height="24" fill="none"
                                                                    viewBox="0 0 24 24">
                                                                    <path stroke="currentColor" stroke-linecap="round"
                                                                        stroke-width="2"
                                                                        d="M12 6h.01M12 12h.01M12 18h.01" />
                                                                </svg>
                                                            </button>

                                                            <!-- Dropdown menu -->
                                                            <div id="dropdownBottom_{{ $key }}001"
                                                                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700">
                                                                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                                                    aria-labelledby="dropdownBottomButton">
                                                                    <li>
                                                                        <a target="_new"
                                                                            href="{{ route('company.student-details', $lead->user->id) }}"
                                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-white dark:hover:text-white">Student
                                                                            View</a>
                                                                    </li>
                                                                    <li>
                                                                        <a role="button"
                                                                            data-url="{{ route('company.requests.form-class.show', $lead->id) }}"
                                                                            class="block px-4 py-2 open-drawer hover:bg-gray-100 dark:hover:bg-white dark:hover:text-white">Lead
                                                                            View</a>
                                                                    </li>

                                                                    <li>
                                                                        <a role="button"
                                                                            data-url="{{ route('company.requests.form-class.edit', $lead->id) }}"
                                                                            class="block px-4 py-2 open-drawer hover:bg-gray-100 dark:hover:bg-white dark:hover:text-white">Edit</a>
                                                                    </li>
                                                                    @if ($lead->status == 'closed')
                                                                        <li>
                                                                            <form id="form_{{ $lead->id }}"
                                                                                class="m-0 p-0"
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
                                                @empty
                                                    <tr>
                                                        <td colspan="5">
                                                            <h6 class="text-center py-4">No Lead Found</h6>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- TEACHER REQUESTS -->
                                <div id="teacher" class="tab-content hidden">

                                    <div class=" ">
                                        <table
                                            class="items-center w-full mb-0 align-top border-collapse dark:border-white/40 text-slate-500">

                                            <thead class="align-bottom">
                                                <tr>
                                                    <th
                                                        class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                                        Student</th>
                                                    <th
                                                        class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                                        Teacher</th>
                                                    <th
                                                        class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                                        Status</th>
                                                    <th
                                                        class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                                        Created At</th>
                                                    <th
                                                        class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                                        Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($teacherRequests ?? [] as $key2 => $lead)
                                                    <tr class="border-b">
                                                        <td class="p-3">
                                                            <div class="font-semibold">
                                                                <a href="{{ route('company.student-details', $lead->user->id) }}"
                                                                    target="user-details">
                                                                    {{ $lead->user->name ?? '—' }}</a>
                                                            </div>
                                                            <div class="text-xs text-gray-500">
                                                                {{ $lead->user->mobile ?? '' }}</div>
                                                        </td>
                                                        <td>{{ $lead->grade }}</td>
                                                        <td>
                                                            {!! $lead->status_badge !!}
                                                        </td>

                                                        <td class="max-w-xs text-xs">
                                                            {{ $lead->created_at ?? '—' }}
                                                        </td>
                                                        <td
                                                            class="p-2 align-middle bg-transparent border-b dark:border-white/40  shadow-transparent">
                                                            <button id="dropdownBottomButton"
                                                                data-dropdown-toggle="dropdownBottom_{{ $key2 }}002"
                                                                data-dropdown-placement="bottom" class=""
                                                                type="button">
                                                                <svg class="w-6 h-6 text-gray-800 dark:text-white"
                                                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                                    width="24" height="24" fill="none"
                                                                    viewBox="0 0 24 24">
                                                                    <path stroke="currentColor" stroke-linecap="round"
                                                                        stroke-width="2"
                                                                        d="M12 6h.01M12 12h.01M12 18h.01" />
                                                                </svg>
                                                            </button>

                                                            <!-- Dropdown menu -->
                                                            <div id="dropdownBottom_{{ $key2 }}002"
                                                                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700">
                                                                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                                                    aria-labelledby="dropdownBottomButton">
                                                                    <li>
                                                                        <a target="_new"
                                                                            href="{{ route('company.student-details', $lead->user->id) }}"
                                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-white dark:hover:text-white">Student
                                                                            View</a>
                                                                    </li>
                                                                    <li>
                                                                        <a role="button"
                                                                            data-url="{{ route('company.requests.form-class.show', $lead->id) }}"
                                                                            class="block px-4 py-2 open-drawer hover:bg-gray-100 dark:hover:bg-white dark:hover:text-white">Lead
                                                                            View</a>
                                                                    </li>

                                                                    <li>
                                                                        <a role="button"
                                                                            data-url="{{ route('company.requests.form-class.edit', $lead->id) }}"
                                                                            class="block px-4 py-2 open-drawer hover:bg-gray-100 dark:hover:bg-white dark:hover:text-white">Edit</a>
                                                                    </li>
                                                                    @if ($lead->status == 'closed')
                                                                        <li>
                                                                            <form id="form_{{ $lead->id }}"
                                                                                class="m-0 p-0"
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
                                                @empty
                                                    <tr>
                                                        <td colspan="5">
                                                            <h6 class="text-center py-4">No Lead Found</h6>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- COURSE REQUESTS -->
                                <div id="course" class="tab-content hidden">

                                    <div class="">
                                        <table
                                            class="items-center w-full mb-0 align-top border-collapse dark:border-white/40 text-slate-500">

                                            <thead class="align-bottom">
                                                <tr>
                                                    <th
                                                        class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                                        Student</th>
                                                    <th
                                                        class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                                        Course/Section</th>
                                                    <th
                                                        class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                                        Status</th>
                                                    <th
                                                        class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                                        Created At</th>
                                                    <th
                                                        class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                                        Action</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @forelse ($courseRequests ?? [] as $key3 => $lead)
                                                    <tr class="border-b">
                                                        <td class="p-3">
                                                            <div class="font-semibold">
                                                                <a href="{{ route('company.student-details', $lead->user->id) }}"
                                                                    target="user-details">
                                                                    {{ $lead->user->name ?? '—' }}</a>
                                                            </div>
                                                            <div class="text-xs text-gray-500">
                                                                {{ $lead->user->mobile ?? '' }}</div>
                                                        </td>
                                                        <td>{{ $lead->grade }}</td>
                                                        <td>
                                                            {!! $lead->status_badge !!}
                                                        </td>

                                                        <td class="max-w-xs text-xs">
                                                            {{ $lead->created_at ?? '—' }}
                                                        </td>
                                                        <td
                                                            class="p-2 align-middle bg-transparent border-b dark:border-white/40  shadow-transparent">
                                                            <button id="dropdownBottomButton"
                                                                data-dropdown-toggle="dropdownBottom_{{ $key3 }}003"
                                                                data-dropdown-placement="bottom" class=""
                                                                type="button">
                                                                <svg class="w-6 h-6 text-gray-800 dark:text-white"
                                                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                                    width="24" height="24" fill="none"
                                                                    viewBox="0 0 24 24">
                                                                    <path stroke="currentColor" stroke-linecap="round"
                                                                        stroke-width="2"
                                                                        d="M12 6h.01M12 12h.01M12 18h.01" />
                                                                </svg>
                                                            </button>

                                                            <!-- Dropdown menu -->
                                                            <div id="dropdownBottom_{{ $key3 }}003"
                                                                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700">
                                                                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                                                    aria-labelledby="dropdownBottomButton">
                                                                    <li>
                                                                        <a target="_new"
                                                                            href="{{ route('company.student-details', $lead->user->id) }}"
                                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-white dark:hover:text-white">Student
                                                                            View</a>
                                                                    </li>
                                                                    <li>
                                                                        <a role="button"
                                                                            data-url="{{ route('company.requests.form-class.show', $lead->id) }}"
                                                                            class="block px-4 py-2 open-drawer hover:bg-gray-100 dark:hover:bg-white dark:hover:text-white">Lead
                                                                            View</a>
                                                                    </li>

                                                                    <li>
                                                                        <a role="button"
                                                                            data-url="{{ route('company.requests.form-class.edit', $lead->id) }}"
                                                                            class="block px-4 py-2 open-drawer hover:bg-gray-100 dark:hover:bg-white dark:hover:text-white">Edit</a>
                                                                    </li>
                                                                    @if ($lead->status == 'closed')
                                                                        <li>
                                                                            <form id="form_{{ $lead->id }}"
                                                                                class="m-0 p-0"
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
                                                @empty
                                                    <tr>
                                                        <td colspan="5">
                                                            <h6 class="text-center py-4">No Lead Found</h6>
                                                        </td>
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
            </div>
        </div>


        <div class="flex flex-wrap mt-6 -mx-3">

            <div class="w-full max-w-full px-3 mt-3 w-1/2 lg:flex-none">
                <div
                    class="border-black/12.5 shadow-xl dark:bg-slate-850 dark:shadow-dark-xl relative flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid bg-white bg-clip-border">
                    <div class="p-4 pb-0 rounded-t-4">
                        <h6 class="mb-0 dark:text-white">Top Teachers</h6>
                    </div>

                    {{--  Teacher ,no:of courses no:of classes, total spend time, total watch time  --}}
                    <div class="flex-auto p-4">
                        <ul class="flex flex-col pl-0 mb-0 rounded-lg">

                            @foreach ($data['top_teachers'] as $teacher)
                                <li
                                    class="relative flex justify-between py-3 pr-4 mb-2 rounded-xl bg-gray-50 dark:bg-slate-800">
                                    <div class="flex items-center">
                                        <div
                                            class="inline-flex items-center justify-center w-10 h-10 mr-4 text-white bg-gradient-to-tl from-indigo-600 to-purple-600 rounded-xl">
                                            <i class="ni ni-hat-3 text-sm"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 text-sm font-semibold dark:text-white">
                                                {{ $teacher['name'] }}
                                            </h6>
                                            <p class="mb-0 text-xs text-gray-500 dark:text-gray-300">
                                                {{ $teacher['courses'] }} Courses • {{ $teacher['classes'] }} Classes
                                            </p>
                                        </div>
                                    </div>

                                    <div class="text-right">
                                        <p class="mb-0 text-xs text-gray-500 dark:text-gray-300">Revenue</p>
                                        <h6 class="mb-0 text-sm font-bold text-emerald-500">
                                            ₹{{ number_format($teacher['revenue']) }}
                                        </h6>
                                    </div>
                                </li>
                            @endforeach
                        </ul>

                    </div>
                </div>
            </div>
            <div class="w-full max-w-full px-3 mt-3 mb-6 w-1/2 lg:flex-none">
                <div
                    class="border-black/12.5 shadow-xl dark:bg-slate-850 dark:shadow-dark-xl relative flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid bg-white bg-clip-border">
                    <div class="p-4 pb-0 rounded-t-4 flex items-center justify-between">
                        <h6 class="mb-0 dark:text-white">Active Devices</h6>
                        <select id="activeDevicesFilter" class="border rounded px-2 py-1 text-sm">
                            <option value="7_days" selected>Last 7 Days</option>
                            <option value="5_weeks">Last 5 Weeks</option>
                            <option value="5_months">Last 5 Months</option>
                        </select>
                    </div>
                    {{-- device details  depending count --}}
                    <div class="p-4">
                        <canvas id="activeDevicesChart" ></canvas>
                    </div>
                </div>
            </div>
            <div class="w-full max-w-full px-3 mt-3 w-1/2 lg:flex-none">
                <div
                    class="border-black/12.5 shadow-xl dark:bg-slate-850 dark:shadow-dark-xl relative flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid bg-white bg-clip-border">
                    <div class="p-4 pb-0 rounded-t-4">
                        <h6 class="mb-0 dark:text-white">Top Sources</h6>
                    </div>
                    {{-- show visites form where  --}}
                    <div class="flex-auto p-4">
                        <ul class="flex flex-col pl-0 mb-0 rounded-lg">
                            @foreach ($data['sources'] as $source)
                                <li class="flex justify-between py-3 pr-4 mb-2 rounded-xl bg-gray-50 dark:bg-slate-800">
                                    <div class="flex items-center">
                                        <div
                                            class="inline-flex items-center justify-center w-9 h-9 mr-4 text-white bg-gradient-to-tl from-orange-500 to-yellow-500 rounded-xl">
                                            <i class="ni ni-world text-xs"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 text-sm dark:text-white">
                                                {{ $source['name'] }}
                                            </h6>
                                            <p class="mb-0 text-xs text-gray-500 dark:text-gray-300">
                                                {{ number_format($source['visits']) }} Visits
                                            </p>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>

                    </div>
                </div>
            </div>
            <div class="w-full max-w-full px-3 mt-3 w-1/2 lg:flex-none">
                <div
                    class="border-black/12.5 shadow-xl dark:bg-slate-850 dark:shadow-dark-xl relative flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid bg-white bg-clip-border">
                    <div class="p-4 pb-0 rounded-t-4">
                        <h6 class="mb-0 dark:text-white">Top Cities</h6>
                    </div>
                    {{-- use cities or any other use i need fill this section --}}
                    <div class="flex-auto p-4">
                        <ul class="flex flex-col pl-0 mb-0 rounded-lg">
                            @foreach ($data['cities'] as $city)
                                <li class="flex justify-between py-3 pr-4 mb-2 rounded-xl bg-gray-50 dark:bg-slate-800">
                                    <div class="flex items-center">
                                        <div
                                            class="inline-flex items-center justify-center w-9 h-9 mr-4 text-white bg-gradient-to-tl from-emerald-500 to-teal-400 rounded-xl">
                                            <i class="ni ni-pin-3 text-xs"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 text-sm dark:text-white">
                                                {{ $city['name'] }}
                                            </h6>
                                            <p class="mb-0 text-xs text-gray-500 dark:text-gray-300">
                                                {{ number_format($city['users']) }} Active Users
                                            </p>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>

                    </div>
                </div>
            </div>
        </div>


    </div>
    <!-- end cards -->
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        let chartInstance = null;

        function loadChart(filter = '7_days') {
            $.ajax({
                url: "{{ route('company.dashboard.overall-analytics') }}",
                type: "GET",
                data: {
                    filter: filter
                },
                success: function(res) {
                    const chartData = res.chart;

                    const ctx = document.getElementById('overallAnalyticsChart').getContext('2d');

                    // Destroy old chart before redraw
                    if (chartInstance) {
                        chartInstance.destroy();
                    }

                    chartInstance = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: chartData.labels,
                            datasets: [{
                                    label: 'New Students',
                                    data: chartData.students,
                                },
                                {
                                    label: 'New Teachers',
                                    data: chartData.teachers,
                                },
                                {
                                    label: 'Revenue',
                                    data: chartData.revenue,
                                    yAxisID: 'y1'
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Count'
                                    }
                                },
                                y1: {
                                    beginAtZero: true,
                                    position: 'right',
                                    title: {
                                        display: true,
                                        text: 'Revenue (₹)'
                                    },
                                    grid: {
                                        drawOnChartArea: false
                                    }
                                }
                            }
                        }
                    });
                }
            });
        }

        // Initial load
        loadChart();

        // On dropdown change
        $('#analyticsFilter').on('change', function() {
            let filter = $(this).val();
            loadChart(filter);
        });
    </script>


    <script>
        function openTab(tabName) {

            const tabs = document.querySelectorAll(".tab-content");
            tabs.forEach(tab => tab.classList.add("hidden"));

            document.getElementById(tabName).classList.remove("hidden");

            const buttons = document.querySelectorAll(".tab-btn");
            buttons.forEach(btn => {
                btn.classList.remove("bg-emerald-500/50");
            });

            event.target.classList.add("bg-emerald-500/50");
        }
    </script>
    <script>
        function loadTable(filter = '7_days') {
            $.ajax({
                url: "{{ route('company.dashboard.table-analytics') }}",
                type: "GET",
                data: {
                    filter: filter
                },
                success: function(res) {

                    let data = res.analytics;

                    // WEB
                    $('#web_visitors').text(data.web.visitors_count);
                    $('#web_buy').text(data.web.buy_now_click_count);
                    $('#web_students').text(data.web.new_students_count);
                    $('#web_teachers').text(data.web.new_teachers_count);
                    $('#web_purchases').text(data.web.total_purchases_count);
                    $('#web_revenue').text('₹' + numberFormat(data.web.total_revenue));

                    // ANDROID
                    $('#android_visitors').text(data.android.visitors_count);
                    $('#android_buy').text(data.android.buy_now_click_count);
                    $('#android_students').text(data.android.new_students_count);
                    $('#android_teachers').text(data.android.new_teachers_count);
                    $('#android_purchases').text(data.android.total_purchases_count);
                    $('#android_revenue').text('₹' + numberFormat(data.android.total_revenue));

                    // IOS
                    $('#ios_visitors').text(data.ios.visitors_count);
                    $('#ios_buy').text(data.ios.buy_now_click_count);
                    $('#ios_students').text(data.ios.new_students_count);
                    $('#ios_teachers').text(data.ios.new_teachers_count);
                    $('#ios_purchases').text(data.ios.total_purchases_count);
                    $('#ios_revenue').text('₹' + numberFormat(data.ios.total_revenue));
                }
            });
        }

        function numberFormat(num) {
            return new Intl.NumberFormat('en-IN').format(num);
        }

        // Load initially
        loadTable();

        // On filter change
        $('#tableFilter').on('change', function() {
            loadTable($(this).val());
        });
    </script>

  <script>
    let deviceChart = null;

    function loadDevicesChart(filter = '7_days') {
        $.ajax({
            url: "{{ route('company.dashboard.devices-analytics') }}",
            type: "GET",
            data: { filter: filter },
            success: function(res) {

                let labels = res.chart.labels;
                let data = res.chart.data;

                const ctx = document.getElementById('activeDevicesChart').getContext('2d');

                if (deviceChart) {
                    deviceChart.destroy();
                }

                deviceChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: data,
                            backgroundColor: [
                                '#4F46E5', // web
                                '#10B981', // android
                                '#F59E0B', // ios
                                '#EF4444', // windows
                                '#3B82F6', // macos
                                '#6B7280'  // others
                            ]
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        let value = context.raw;
                                        let total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        let percent = ((value / total) * 100).toFixed(1);
                                        return context.label + ': ' + value + ' (' + percent + '%)';
                                    }
                                }
                            }
                        }
                    }
                });
            }
        });
    }

    loadDevicesChart();

    $('#activeDevicesFilter').on('change', function() {
        loadDevicesChart($(this).val());
    });
</script>
@endpush
