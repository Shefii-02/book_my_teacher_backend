@extends('layouts.sp-layout')

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
                aria-current="page">Company List</li>
        </ol>
        <h6 class="mb-0 font-bold text-white capitalize">Company List</h6>
    </nav>
@endsection

@section('content')
    <!-- cards -->
    <div class="w-full px-6 py-6 mx-auto">

        <!-- table 1 -->

        <div class="flex flex-wrap -mx-3 mt-4">
            <div class="flex-none w-full max-w-full px-3">
                <div
                    class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                    <div class="px-6 pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                        <div class="justify-between flex py-3 items-center">
                            <h6 class="dark:text-white">Company List</h6>
                            <a href="{{ route('admin.companies.create') }}"
                                class="px-4 py-2 bg-gradient-to-tl  from-emerald-500 to-teal-400  text-white  text-sm">
                                <i class="bi bi-plus me-1"></i> Create</a>
                        </div>
                    </div>
                </div>
                <div
                    class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">

                    <div class="p-0 overflow-x-auto">
                        <table
                            class="items-center w-full mb-0 align-top border-collapse dark:border-white/40 text-slate-500">
                            <thead class="align-bottom">
                                <tr>
                                    <th
                                        class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                        Name</th>
                                    <th
                                        class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                        Profession</th>
                                    <th
                                        class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                        Subject</th>
                                    <th
                                        class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                        Grade</th>
                                    <th
                                        class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                        Mode</th>
                                    <th
                                        class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                        Created At</th>
                                    <th
                                        class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                        Account Status</th>
                                    <th
                                        class="px-6 py-3 font-semibold capitalize align-middle bg-transparent border-b border-collapse border-solid shadow-none dark:border-white/40 dark:text-white tracking-none  text-slate-400 opacity-70">
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($companies ?? [] as $key => $company)
                                    <tr>
                                        <td
                                            class="p-2 align-middle bg-transparent border-b dark:border-white/40  shadow-transparent">
                                            <div class="flex px-2 py-1">
                                                <div>
                                                    <img src="{{ asset('storage/' . $company ? $company->avatar_url : '') }}"
                                                        class="inline-flex items-center justify-center mr-4 text-sm text-white transition-all duration-200 ease-in-out h-9 w-9 rounded-xl"
                                                        alt="user1" />
                                                </div>
                                                <div class="flex flex-col justify-center">
                                                    <h6 class="mb-0 text-sm text-neutral-900 dark:text-white">
                                                        {{ $company->name }}</h6>
                                                    <p
                                                        class="my-1 text-xs leading-tight dark:text-white dark:opacity-80 text-slate-400">
                                                        <a href="#" class="__cf_email__">{{ $company->email }}</a>
                                                    </p>
                                                    <p
                                                        class="mb-0 text-xs leading-tight dark:text-white dark:opacity-80 text-slate-400">
                                                        <a href="#" class="__cf_email__">{{ $company->mobile }}</a>
                                                    </p>
                                                    <div class="flex gap-3">
                                                        <a target="_blank"
                                                            href="https://web.whatsapp.com/send/?text=&type=custom_url&app_absent=0&utm_campaign=wa_api_send_v1&phone{{ $company->mobile }}"
                                                            class="mb-0 text-sm text-neutral-900 dark:text-white">
                                                            <i class="bi bi-whatsapp text-green-400"></i></a>
                                                        <a target="_blank" href="tel://{{ $company->mobile }}"
                                                            class="mb-0 text-sm text-neutral-900 dark:text-white">
                                                            <i class="bi bi-telephone text-blue-400"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td
                                            class="p-2 align-middle bg-transparent border-b dark:border-white/40  shadow-transparent">
                                            <p
                                                class="mb-0 text-xs font-semibold capitalize leading-tight dark:text-white dark:opacity-80 text-slate-400">

                                            </p>
                                        </td>
                                        <td
                                            class="p-2 align-middle bg-transparent border-b dark:border-white/40  shadow-transparent">
                                            <p
                                                class="mb-0 capitalize text-xs font-semibold leading-tight dark:text-white dark:opacity-80 text-slate-400">
                                            </p>
                                        </td>
                                        <td
                                            class="p-2 align-middle bg-transparent border-b dark:border-white/40  shadow-transparent">
                                            <p
                                                class="mb-0 capitalize text-xs font-semibold leading-tight dark:text-white dark:opacity-80 text-slate-400">
                                            </p>
                                        </td>
                                        <td
                                            class="p-2 text-sm text-neutral-900 text-center align-middle bg-transparent border-b dark:border-white/40  shadow-transparent">
                                            {{-- @if ($company->professionalInfo)
                                                    @if ($company->professionalInfo->teaching_mode == 'online')
                                                        <span
                                                            class="bg-gradient-to-tl from-emerald-500 to-teal-400 px-2.5 text-xs rounded-1.8 py-1.4 inline-block  text-center align-baseline font-bold capitalize leading-none text-white">Online</span>
                                                    @elseif($company->professionalInfo->teaching_mode == 'offline')
                                                        <span
                                                            class="bg-gradient-to-tl from-slate-600 to-slate-300 px-2.5 text-xs rounded-1.8 py-1.4 inline-block  text-center align-baseline font-bold capitalize leading-none text-white">Offline</span>
                                                    @elseif($company->professionalInfo->teaching_mode == 'both')
                                                        <span
                                                            class="bg-gradient-to-tl from-blue-700 to-teal-400 px-2.5 text-xs rounded-1.8 py-1.4 inline-block  text-center align-baseline font-bold capitalize leading-none text-white">Both</span>
                                                    @endif
                                                @endif --}}
                                        </td>
                                        <td
                                            class="p-2 text-center align-middle bg-transparent border-b dark:border-white/40  shadow-transparent">
                                            <span
                                                class="text-xs font-semibold leading-tight dark:text-white dark:opacity-80 text-slate-400">{{ $company->created_at }}</span>
                                        </td>
                                        <td
                                            class="p-2 text-center align-middle bg-transparent border-b dark:border-white/40  shadow-transparent capitalize">
                                            <span class="text-sm mb-1">{{ $company->current_account_stage }}</span><br>
                                            @if ($company->account_status == 'in progress')
                                                <span
                                                    class="bg-gradient-to-tl capitalize from-lime-200 to-lime-400 px-2.5 text-xs rounded-1.8 py-1.4 inline-block  text-center align-baseline font-bold  leading-none text-white">In
                                                    progress</span>
                                            @elseif($company->account_status == 'ready for interview')
                                                <span
                                                    class="bg-gradient-to-tl capitalize from-slate-600 to-slate-300 px-2.5 text-xs rounded-1.8 py-1.4 inline-block  text-center align-baseline font-bold  leading-none text-white">Ready
                                                    for interview</span>
                                            @elseif($company->account_status == 'scheduled')
                                                <span
                                                    class="bg-gradient-to-tl capitalize from-emerald-500 to-teal-400 px-2.5 text-xs rounded-1.8 py-1.4 inline-block  text-center align-baseline font-bold  leading-none text-white">Scheduled</span>
                                            @elseif($company->account_status == 'completed')
                                                <span
                                                    class="bg-gradient-to-tl capitalize from-emerald-500 to-teal-400 px-2.5 text-xs rounded-1.8 py-1.4 inline-block  text-center align-baseline font-bold  leading-none text-white">Completed</span>
                                            @elseif($company->account_status == 'rejected')
                                                <span
                                                    class="bg-gradient-to-tl capitalize bg-red-900 px-2.5 text-xs rounded-1.8 py-1.4 inline-block  text-center align-baseline font-bold  leading-none text-white">Rejected</span>
                                            @endif
                                        </td>
                                        <td
                                            class="p-2 align-middle bg-transparent border-b dark:border-white/40  shadow-transparent">
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
                                                        <a href="{{-- route('admin.companies.overview', $company->id) --}}"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-white dark:hover:text-white">View</a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('admin.companies.edit', $company->id) }}"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-white dark:hover:text-white">Edit</a>
                                                    </li>
                                                    <li>
                                                        <a href="{{-- route('admin.teachers.login-security', $company->id) --}}"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-white dark:hover:text-white">Login
                                                            Security</a>
                                                    </li>
                                                    <li>
                                                        <form id="form_{{ $company->id }}" class="m-0 p-0"
                                                            action="{{ route('admin.companies.destroy', $company->id) }}"
                                                            method="POST" class="inline-block">
                                                            @csrf @method('DELETE') </form>
                                                        <a role="button" href="javascript:;"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-white dark:hover:text-white"
                                                            onclick="confirmDelete({{ $company->id }})">Delete</a>

                                                    </li>
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
                    {!! $companies->links() !!}
                </div>
                <p class="p-3">Showing {{ $companies->firstItem() }} to {{ $companies->lastItem() }} of
                    {{ $companies->total() }} users.</p>

            </div>
        </div>
    </div>
    </div>
@endsection
