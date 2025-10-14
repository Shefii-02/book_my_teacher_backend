@extends('layouts.hrms-layout')

@section('nav-options')
    <nav>
        <ol class="flex flex-wrap pt-1 mr-12 bg-transparent rounded-lg sm:mr-16">
            <li class="text-neutral-900 text-sm">
                <a class="text-white " href="javascript:;">Home</a>
            </li>
            <li
                class="text-sm pl-2 capitalize text-neutral-900 text-white before:float-left before:pr-2 before:text-white before:content-['/']">
                <a class="text-white" href="{{ route('admin.dashboard') }}">Dashboard</a>
            </li>
            <li class="text-sm pl-2 font-bold capitalize text-white before:float-left before:pr-2 before:text-white before:content-['/']"
                aria-current="page">Team</li>
        </ol>
        <h6 class="mb-0 font-bold text-white capitalize">Team Members</h6>
    </nav>
@endsection

@section('content')
    <div class="flex flex-wrap -mx-3 mt-4">
        <div class="flex-none w-full max-w-full px-3">
            <div
                class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                <div class="p-3 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">

                    <div class="w-full max-w-full flex justify-between">
                        <h6 class="dark:text-white">Teachers List</h6>
                        <a href="{{ route('admin.hrms.teams.create') }}"
                            class="px-4 py-2 bg-gradient-to-tl from-emerald-500 to-teal-400 text-white rounded-full text-sm">
                            + Add New Staff
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- cards -->
    <div class="w-full px-6 py-6 mx-auto">
        <!-- row 1 -->
        <div class="flex flex-wrap -mx-3 justify-left">
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
                                    <h5 class="mb-2 font-bold dark:text-white">
                                        {{ $staffs->where('acc_type', 'teacher')->count() }}</h5>

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
                                        Total Staffs </p>
                                    <h5 class="mb-2 font-bold dark:text-white">
                                        {{ $staffs->where('acc_type', 'staff')->count() }}</h5>

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

        </div>
    </div>



    <div class="flex flex-wrap -mx-3 mt-4">
        <div class="flex-none w-full max-w-full px-3">
            <div
                class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                <div class="p-6 pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                    <div class="flex1">

                        <div class="w-full max-w-full ">
                            <form method="GET" action="{{ route('admin.hrms.teams.index') }}"
                                class="mb-4 flex flex-wrap gap-3 items-end">

                                <!-- 🔍 Search (name, email, mobile) -->
                                <div>
                                    <label class="block text-sm font-medium mb-1">Search</label>
                                    <input type="text" name="search" value="{{ request('search') }}"
                                        placeholder="Search name, email, mobile" class="border rounded px-3 py-2 w-64">
                                </div>

                                <!-- 🎛 Teaching Mode -->
                                <div>
                                    <label class="block text-sm font-medium mb-1">Payroll Type</label>
                                    <select name="payroll_type" class="border rounded px-3 py-2 w-32">
                                        <option value="">All</option>
                                        <option value="monthly"
                                            {{ request('payroll_type') == 'monthly' ? 'selected' : '' }}>
                                            Monthly
                                        </option>
                                        <option value="hourly" {{ request('payroll_type') == 'hourly' ? 'selected' : '' }}>
                                            Hourly
                                        </option>

                                    </select>
                                </div>

                                <!-- 📌 Account Status -->
                                <div>
                                    <label class="block text-sm font-medium mb-1">Account Status</label>
                                    <select name="status" class="border rounded px-3 py-2 w-32">
                                        <option value="">All</option>
                                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>
                                            Inactive
                                        </option>
                                    </select>
                                </div>


                                <!-- Submit + Reset -->
                                <div class="flex gap-2">
                                    <button type="submit"
                                        class="px-4 py-2 bg-gradient-to-tl from-emerald-500 to-teal-400  text-white rounded-full text-sm"><i
                                            class="bi bi-search"></i> Apply</button>
                                    <a href="{{ route('admin.hrms.teams.index') }}"
                                        class="px-4 py-2 bg-gradient-to-tl from-emerald-500 to-teal-400  rounded-full text-white text-sm"><i
                                            class="bi bi-arrow-clockwise"></i> Reset </a>
                                    {{-- <a href="{{ route('admin.hrms.teams.export', request()->query()) }}"
                                        class="px-4 py-2 bg-gradient-to-tl from-emerald-500 to-teal-400  text-white rounded-full text-sm">
                                        <i class="bi bi-file-earmark-spreadsheet"></i>
                                        Export Excel
                                    </a> --}}

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
                        <a href="{{ route('admin.teachers') }}" class="ml-3 mt-2.5 text-sm text-red-600">Clear
                            All</a>
                    </div>
                @endif

                <div class="flex-auto px-0 pt-0 pb-2">
                    <div class="p-0 overflow-x-auto">
                        <table
                            class="items-center w-full mb-0 align-top border-collapse dark:border-white/40 text-slate-500">
                            <thead class="align-bottom">

                                <tr>
                                    <th
                                        class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                        #</th>
                                    <th
                                        class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                        Name</th>
                                    <th
                                        class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                        Email</th>
                                    <th
                                        class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                        Phone</th>
                                    <th
                                        class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                        Role</th>
                                    <th
                                        class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                        Join Date
                                    </th>
                                    <th
                                        class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                        Status
                                    </th>
                                    <th
                                        class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($staffs as $key => $user)
                                    <tr>
                                        <td
                                            class="px-6 py-3 align-middle  bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                            <p
                                                class="mb-0 text-xs font-semibold capitalize leading-tight dark:text-white dark:opacity-80 text-slate-400">
                                                {{ $key + 1 }}</p>
                                        </td>
                                        <td
                                            class="px-6 py-3 align-middle  bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                            <img src="{{ $user->avatar_url }}" class="w-10 rounded-10 mb-1" />
                                            <p
                                                class="mb-0 text-xs font-semibold capitalize leading-tight dark:text-white dark:opacity-80 text-slate-400">
                                                {{ $user->name }}
                                            </p>
                                        </td>
                                        <td
                                            class="px-6 py-3 align-middle  bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                            <p
                                                class="mb-0 text-xs font-semibold capitalize leading-tight dark:text-white dark:opacity-80 text-slate-400">
                                                {{ $user->email }}
                                            </p>
                                        </td>
                                        <td
                                            class="px-6 py-3 align-middle  bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                            <p
                                                class="mb-0 text-xs font-semibold capitalize leading-tight dark:text-white dark:opacity-80 text-slate-400">
                                                {{ $user->mobile }}</p>
                                        </td>

                                        <td
                                            class="px-6 py-3 align-middle  bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent {{ $user->acc_type == 'teacher' ? 'bg-info' : 'bg-primary' }}">
                                            @if ($user->acc_type == 'teacher')
                                                <span
                                                    class="bg-gradient-to-tl from-emerald-500 to-teal-400 px-2.5 text-xs rounded-1.8 py-1.4 inline-block  text-center align-baseline font-bold capitalize leading-none text-white">{{ ucfirst($user->acc_type ?? '-') }}</span>
                                            @else
                                                <span
                                                    class="bg-gradient-to-tl from-blue-700 to-teal-400 px-2.5 text-xs rounded-1.8 py-1.4 inline-block  text-center align-baseline font-bold capitalize leading-none text-white">{{ ucfirst($user->acc_type ?? '-') }}</span>
                                            @endif
                                        </td>
                                        <td
                                            class="px-6 py-3 align-middle  bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                            <p
                                                class="mb-0 text-xs font-semibold capitalize leading-tight dark:text-white dark:opacity-80 text-slate-400">
                                                {{ $user->payrollDetails ? $user->payrollDetails->joining_date : '--' }}
                                            </p>
                                        </td>
                                        <td
                                            class="px-6 py-3 align-middle capitalize  bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                            {{ $user->status == 1 ? 'active' : 'inactive' }}
                                        </td>
                                        <td
                                            class="px-6 py-3 align-middle  bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent bg-info">
                                            <button id="dropdownBottomButton"
                                                data-dropdown-toggle="dropdownBottom_{{ $key }}"
                                                data-dropdown-placement="bottom" class="" type="button">
                                                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                                        d="M12 6h.01M12 12h.01M12 18h.01" />
                                                </svg>


                                            </button>

                                            <!-- Dropdown menu -->
                                            <div id="dropdownBottom_{{ $key }}"
                                                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700">
                                                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                                    aria-labelledby="dropdownBottomButton">
                                                    <li>
                                                        <a href="{{ route('admin.hrms.teams.show', $user->id) }}"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-white dark:hover:text-white">Login
                                                            & Security</a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('admin.hrms.teams.show', $user->id) }}"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-white dark:hover:text-white">View</a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('admin.hrms.teams.edit', $user->id) }}"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-white dark:hover:text-white">Edit</a>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('admin.hrms.teams.destroy', $user->id) }}"
                                                            id="form_{{ $user->id }}" method="POST"
                                                            class="d-inline-block  w-full">
                                                            @csrf @method('DELETE')
                                                            <a role="button" href="javascript:;"
                                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-white dark:hover:text-white"
                                                                onclick="confirmDelete({{ $user->id }})">Delete</a>
                                                        </form>

                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">No staff members
                                            found.
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
@endsection
