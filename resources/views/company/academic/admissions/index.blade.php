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
                aria-current="page">Admission Transactions List</li>
        </ol>
        <h6 class="mb-0 font-bold text-white capitalize">Admission Transactions List</h6>
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
                                        Transaltions</p>
                                    <h5 class="mb-2 font-bold dark:text-white">{{ $stats['total']['count'] }}</h5>

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
                                <span class="text-emerald-500">{{ $stats['total']['online'] }}</span>
                            </p>
                            <p class="mb-0 dark:text-white dark:opacity-60">
                                <span
                                    class="font-bold text-neutral-900 dark:text-white text-sm text-emerald-500 mr-2">Manually</span><br>
                                <span class="text-emerald-500">{{ $stats['total']['manual'] }}</span>
                            </p>
                            <p class="mb-0 dark:text-white dark:opacity-60">
                                <span
                                    class="font-bold text-neutral-900 dark:text-white text-sm text-emerald-500 mr-2">In-Cash
                                </span><br>
                                <span class="text-emerald-500">{{ $stats['total']['cash'] }}</span>
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
                                        Paid </p>
                                    <h5 class="mb-2 font-bold dark:text-white">{{ $stats['paid']['count'] }}</h5>

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
                                <span class="text-emerald-500">{{ $stats['paid']['online'] }}</span>
                            </p>
                            <p class="mb-0 dark:text-white dark:opacity-60">
                                <span
                                    class="font-bold text-neutral-900 dark:text-white text-sm text-emerald-500 mr-2">Manually</span><br>
                                <span class="text-emerald-500">{{ $stats['paid']['manual'] }}</span>
                            </p>
                            <p class="mb-0 dark:text-white dark:opacity-60">
                                <span
                                    class="font-bold text-neutral-900 dark:text-white text-sm text-emerald-500 mr-2">In-Cash
                                </span><br>
                                <span class="text-emerald-500">{{ $stats['paid']['cash'] }}</span>
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
                                        Unpaid </p>
                                    <h5 class="mb-2 font-bold dark:text-white">{{ $stats['pending']['count'] }}</h5>

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
                                <span class="text-emerald-500">{{ $stats['pending']['online'] }}</span>
                            </p>
                            <p class="mb-0 dark:text-white dark:opacity-60">
                                <span
                                    class="font-bold text-neutral-900 dark:text-white text-sm text-emerald-500 mr-2">Manually</span><br>
                                <span class="text-emerald-500">{{ $stats['pending']['manual'] }}</span>
                            </p>
                            <p class="mb-0 dark:text-white dark:opacity-60">
                                <span
                                    class="font-bold text-neutral-900 dark:text-white text-sm text-emerald-500 mr-2">In-Cash
                                </span><br>
                                <span class="text-emerald-500">{{ $stats['pending']['cash'] }}</span>
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
                                    <h5 class="mb-2 font-bold dark:text-white">{{ $stats['rejected']['count'] }}</h5>
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
                                <span class="text-emerald-500">{{ $stats['rejected']['online'] }}</span>
                            </p>
                            <p class="mb-0 dark:text-white dark:opacity-60">
                                <span
                                    class="font-bold text-neutral-900 dark:text-white text-sm text-emerald-500 mr-2">Manually</span><br>
                                <span class="text-emerald-500">{{ $stats['rejected']['manual'] }}</span>
                            </p>
                            <p class="mb-0 dark:text-white dark:opacity-60">
                                <span
                                    class="font-bold text-neutral-900 dark:text-white text-sm text-emerald-500 mr-2">In-Cash
                                </span><br>
                                <span class="text-emerald-500">{{ $stats['rejected']['cash'] }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div
            class="relative flex flex-col min-w-0 my-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
            <div class="p-4 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                <div class="flex">
                    <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
                        <h6 class="dark:text-white">Transaltion List</h6>
                    </div>
                    <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">

                    </div>
                    <div class="w-full text-right max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-2/4 mb-3">

                        <a href="{{ route('admin.admissions.create') }}"
                            class="px-4 py-2 bg-gradient-to-tl  from-emerald-500 to-teal-400  text-white  text-sm">
                            <i class="bi bi-plus me-1"></i> Create</a>
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
                                {{--                   <form method="GET" action="{{ route('admin.transactions') }}"
                                    class="mb-4 flex flex-wrap gap-3 items-end"> --}}

                                <!-- 🔍 Search (name, email, mobile) -->
                                {{-- <div>
                                    <label class="block text-sm font-medium mb-1">Search</label>
                                    <input type="text" name="search" value="{{ request('search') }}"
                                        placeholder="Search name, email, mobile" class="border rounded px-3 py-2 w-64">
                                </div> --}}

                                <!-- 🎛 Teaching Mode -->
                                {{-- <div>
                                    <label class="block text-sm font-medium mb-1">Transaction Type</label>
                                    <select name="teaching_mode" class="border rounded px-3 py-2 w-32">
                                        <option value="">All</option>
                                        <option value="online"
                                            {{ request('teaching_mode') == 'online' ? 'selected' : '' }}>Online
                                        </option>
                                        <option value="offline"
                                            {{ request('teaching_mode') == 'offline' ? 'selected' : '' }}>Offline
                                        </option>
                                        <option value="both" {{ request('teaching_mode') == 'both' ? 'selected' : '' }}>
                                            Both</option>
                                    </select>
                                </div> --}}

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
                                        <option value="">All</option>
                                        <option value="verification process"
                                            {{ request('current_account_stage') == 'verification process' ? 'selected' : '' }}>
                                            Verification Process</option>
                                        <option value="schedule interview"
                                            {{ request('current_account_stage') == 'schedule interview' ? 'selected' : '' }}>
                                            Schedule Interview</option>
                                        <option value="upload demo class"
                                            {{ request('current_account_stage') == 'upload demo class' ? 'selected' : '' }}>
                                            Upload Demo Class</option>
                                    </select>
                                </div> --}}

                                <!-- Submit + Reset -->
                                {{--  <div class="flex gap-2">
                                        <button type="submit"
                                            class="px-4 py-2 bg-gradient-to-tl from-emerald-500 to-teal-400  text-white rounded text-sm"><i
                                                class="bi bi-search"></i> Apply</button>
                                        <a href="{{ route('admin.transactions') }}"
                                            class="px-4 py-2 bg-gradient-to-tl from-emerald-500 to-teal-400  rounded text-white text-sm"><i
                                                class="bi bi-arrow-clockwise"></i> Reset </a>
                                        <a href="{{ route('admin.transactions.export', request()->query()) }}"
                                            class="px-4 py-2 bg-gradient-to-tl from-emerald-500 to-teal-400  text-white rounded text-sm">
                                            <i class="bi bi-file-earmark-spreadsheet"></i>
                                            Export Excel
                                        </a>

                                    </div>
                                </form> --}}

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
                            <a href="" class="ml-3 mt-2.5 text-sm text-red-600">Clear
                                All</a>
                        </div>
                    @endif


                    <div class="flex-auto px-0 pt-5 pb-2">
                        <div class="p-0 overflow-x-auto">
                            <table
                                class="items-center w-full mb-0 align-top border-collapse dark:border-white/40 text-slate-500">
                                <thead class="align-bottom">
                                    <tr>
                                        <th
                                            class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                            #</th>
                                        <th
                                            class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                            Student</th>
                                        <th
                                            class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                            Course</th>
                                        <th
                                            class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                            Amount</th>
                                        <th
                                            class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                            Payment</th>
                                        <th
                                            class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                            Created</th>
                                        <th
                                            class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                            Status</th>
                                        <th
                                            class="px-6 py-3 font-semibold capitalize align-middle bg-transparent border-b border-collapse border-solid shadow-none dark:border-white/40 dark:text-white tracking-none  text-slate-400 opacity-70">
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transactions ?? [] as $key => $transaction)
                                        <tr>
                                            <td
                                                class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                                {{ $key + 1 }}
                                            </td>
                                            <td
                                                class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                                <div class="flex px-2 py-1">
                                                    <div>
                                                        <img src="{{ asset('storage/' . $transaction ? $transaction->student->avatar_url : '') }}"
                                                            class="inline-flex items-center justify-center mr-4 text-sm text-white transition-all duration-200 ease-in-out h-9 w-9 rounded-xl"
                                                            alt="user1" />
                                                    </div>
                                                    <div class="flex flex-col justify-center">
                                                        <h6 class="mb-0 text-sm text-neutral-900 dark:text-white">
                                                            {{ $transaction->student->name }}</h6>
                                                        <p
                                                            class="my-1 text-xs leading-tight dark:text-white dark:opacity-80 text-slate-400">
                                                            <a href="#" class="__cf_email__ lowercase"
                                                                title="{{ $transaction->student->email }}">{{ Str::limit($transaction->student->email, 12, '..') }}</a>
                                                        </p>
                                                        <p
                                                            class="mb-0 text-xs leading-tight dark:text-white dark:opacity-80 text-slate-400">
                                                            <a href="#" class="__cf_email__"
                                                                title="{{ $transaction->student->mobile }}">{{ Str::limit($transaction->student->mobile, 12, '..') }}</a>
                                                        </p>
                                                        <div class="flex gap-3">
                                                            <a target="_blank"
                                                                href="https://web.whatsapp.com/send/?text=&type=custom_url&app_absent=0&utm_campaign=wa_api_send_v1&phone{{ $transaction->student->mobile }}"
                                                                class="mb-0 text-sm text-neutral-900 dark:text-white">
                                                                <i class="bi bi-whatsapp text-green-400"></i></a>
                                                            <a target="_blank"
                                                                href="tel://{{ $transaction->student->mobile }}"
                                                                class="mb-0 text-sm text-neutral-900 dark:text-white">
                                                                <i class="bi bi-telephone text-blue-400"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td
                                                class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                                <span>{{ $transaction->course->title }}</span>
                                            </td>
                                            <td
                                                class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                                Price : <span>{{ $transaction->price }} </span><br>
                                                Discount : <span>{{ $transaction->discount_amount }} </span><br>
                                                Tax : <span>{{ $transaction->tax_percent }}%
                                                    {{ $transaction->grand_total }}</span><br>
                                                Grand Total : <span>{{ $transaction->grand_total }} </span>
                                            </td>
                                            <td
                                                class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                                Method : <span>{{ $transaction->payment_method }} </span><br>
                                                Source : <span>{{ $transaction->payment_source }} </span>
                                            </td>
                                            <td
                                                class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                                Created By : <span>{{ $transaction->created_by }} </span><br>
                                                Created At : <span>{{ $transaction->created_at }} </span>
                                            </td>
                                            <td
                                                class="p-2 text-center align-middle bg-transparent border-b dark:border-white/40  shadow-transparent capitalize">

                                                @if ($transaction->status == 'pending')
                                                    <span
                                                        class="bg-gradient-to-tl capitalize  from-slate-600 to-slate-300  px-2.5 text-xs rounded-1.8 py-1.4 inline-block  text-center align-baseline font-bold  leading-none text-white">
                                                        Unpaid</span>
                                                @elseif($transaction->status == 'paid')
                                                    <span
                                                        class="bg-gradient-to-tl capitalize from-emerald-500 to-teal-400 px-2.5 text-xs rounded-1.8 py-1.4 inline-block  text-center align-baseline font-bold  leading-none text-white">Paid</span>
                                                @elseif($transaction->status == 'rejected')
                                                    <span
                                                        class="bg-gradient-to-tl capitalize from-red-200 to-red-600 px-2.5 text-xs rounded-1.8 py-1.4 inline-block  text-center align-baseline font-bold  leading-none text-white">Rejected</span>
                                                @endif
                                            </td>
                                            <td
                                                class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
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
                                                        @if ($transaction->status === 'pending')
                                                            <li>
                                                                <a href="{{ route('admin.payments.init', $transaction->payments->order_id) }}"
                                                                    class="block px-4 py-2 capitalize hover:bg-gray-100 dark:hover:bg-white dark:hover:text-white">
                                                                    Pay Now</a>
                                                            </li>
                                                            <li>
                                                                <a href="#"
                                                                    onclick="openRejectModal({{ $transaction->id }})"
                                                                    class="block px-4 py-2 capitalize hover:bg-gray-100 dark:hover:bg-white dark:hover:text-white">
                                                                    Reject</a>
                                                            </li>
                                                        @elseif($transaction->status === 'paid')
                                                            <li>
                                                                <a href="{{ route('admin.payments.invoice.download', $transaction->id) }}"
                                                                    class="block px-4 py-2 capitalize hover:bg-gray-100 dark:hover:bg-white dark:hover:text-white">Download
                                                                    Invoice</a>
                                                            </li>
                                                        @elseif($transaction->status === 'rejected')
                                                            <li class="text-center">
                                                                <span
                                                                    class="text-red-500  capitalize font-bold">Rejected</span>

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
                    </div>
                    <div class="d-flex justify-content-center m-4">
                        {!! $transactions->links() !!}
                    </div>
                    <p class="p-3">Showing {{ $transactions->firstItem() }} to {{ $transactions->lastItem() }} of
                        {{ $transactions->total() }} transations.</p>

                </div>
            </div>
        </div>
    </div>

    <div id="rejectModal" class="hidden fixed inset-0 bg-black opacity-80 flex items-center justify-center">
        <form method="POST" action="{{ route('admin.payments.reject') }}" class="bg-white p-6 rounded w-96">
            @csrf
            <input type="hidden" name="purchase_id" id="reject_purchase_id">

            <label class="block mb-2 font-bold">Reject Reason</label>
            <textarea name="notes" required class="w-full border rounded p-2"></textarea>

            <div class="mt-4 flex justify-end gap-2">
                <button type="button" onclick="closeRejectModal()">Close</button>
                <button class="bg-red-600 text-white px-4 py-2 rounded">Reject</button>
            </div>
        </form>
    </div>
@endsection





@push('scripts')
    <script>
        function openRejectModal(id) {
            document.getElementById('reject_purchase_id').value = id;
            document.getElementById('rejectModal').classList.remove('hidden');
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
        }
    </script>
@endpush
