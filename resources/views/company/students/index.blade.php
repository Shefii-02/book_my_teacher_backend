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
                            <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">

                            </div>
                            <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">

                            </div>
                            <div class="w-full text-right max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">

                            </div>
                        </div>
                    </div>
                    <div class="flex-auto px-0 pt-0 pb-2">
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
                                            Address</th>
                                        <th
                                            class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                            Grades</th>
                                        <th
                                            class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                            Subject</th>
                                        <th
                                            class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                            Mode</th>
                                        <th
                                            class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                            Created At</th>
                                        {{-- <th
                                            class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                            Account Status</th> --}}
                                        <th
                                            class="px-6 py-3 font-semibold capitalize align-middle bg-transparent border-b border-collapse border-solid shadow-none dark:border-white/40 dark:text-white tracking-none  text-slate-400 opacity-70">
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($students ?? [] as $key => $student)
                                        @php
                                            $studentsubjects = $student->recommendedSubjects
                                                ->pluck('subject')
                                                ->toArray();
                                            $studentGrades = $student->studentGrades->pluck('grade')->toArray();
                                            $studentPersonalInfo = $student->studentPersonalInfo;
                                        @endphp

                                        <tr>
                                            <td
                                                class="p-2 align-middle bg-transparent border-b dark:border-white/40  shadow-transparent">
                                                <div class="flex px-2 py-1">
                                                    <div>
                                                        <img src="{{ $student->avatar_url }}"
                                                            class="inline-flex items-center justify-center mr-4 text-sm text-white transition-all duration-200 ease-in-out h-9 w-9 rounded-xl"
                                                            alt="user1" />
                                                    </div>
                                                    <div class="flex flex-col justify-center">
                                                        <h6 class="mb-0 text-sm text-neutral-900 dark:text-white">
                                                            {{ $student->name }}</h6>
                                                        <p
                                                            class="my-1 text-xs leading-tight dark:text-white dark:opacity-80 text-slate-400">
                                                            <a href="#"
                                                                class="__cf_email__">{{ $student->email }}</a>
                                                        </p>
                                                        <p
                                                            class="mb-0 text-xs leading-tight dark:text-white dark:opacity-80 text-slate-400">
                                                            <a href="#"
                                                                class="__cf_email__">{{ $student->mobile }}</a>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>

                                            <td
                                                class="p-2 align-middle bg-transparent border-b dark:border-white/40  shadow-transparent">
                                                <p
                                                    class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-80 text-slate-400">
                                                    {{ Str::limit($student->address . ', ' . $student->city . ', ' . $student->postal_code . ', ' . $student->district . ', ' . $student->state . ', ' . $student->country, 20) }}

                                                </p>
                                            </td>
                                            <td
                                                class="p-2 align-middle bg-transparent border-b dark:border-white/40  shadow-transparent">
                                                <p
                                                    class="mb-0 capitalize text-xs font-semibold leading-tight dark:text-white dark:opacity-80 text-slate-400">
                                                    {{ implode(',', $studentGrades) }}
                                                </p>
                                            </td>
                                            <td
                                                class="p-2 align-middle bg-transparent border-b dark:border-white/40  shadow-transparent">
                                                <p
                                                    class="mb-0 capitalize text-xs font-semibold leading-tight dark:text-white dark:opacity-80 text-slate-400">
                                                    {{ implode(',', $studentsubjects) }}
                                                </p>
                                            </td>
                                            <td
                                                class="p-2 text-sm text-neutral-900 text-center align-middle bg-transparent border-b dark:border-white/40  shadow-transparent">
                                                @if ($studentPersonalInfo)
                                                    @if ($studentPersonalInfo->study_mode == 'online')
                                                        <span
                                                            class="bg-gradient-to-tl from-emerald-500 to-teal-400 px-2.5 text-xs rounded-1.8 py-1.4 inline-block  text-center align-baseline font-bold uppercase leading-none text-white">Online</span>
                                                    @elseif($studentPersonalInfo->study_mode == 'offline')
                                                        <span
                                                            class="bg-gradient-to-tl from-slate-600 to-slate-300 px-2.5 text-xs rounded-1.8 py-1.4 inline-block  text-center align-baseline font-bold uppercase leading-none text-white">Offline</span>
                                                    @elseif($studentPersonalInfo->study_mode == 'both')
                                                        <span
                                                            class="bg-gradient-to-tl from-blue-700 to-teal-400 px-2.5 text-xs rounded-1.8 py-1.4 inline-block  text-center align-baseline font-bold uppercase leading-none text-white">Both</span>
                                                    @endif
                                                @endif
                                            </td>
                                            <td
                                                class="p-2 text-center align-middle bg-transparent border-b dark:border-white/40  shadow-transparent">
                                                <span
                                                    class="text-xs font-semibold leading-tight dark:text-white dark:opacity-80 text-slate-400">{{ $student->created_at }}</span>
                                            </td>
                                            {{-- <td
                                                class="p-2 text-center align-middle bg-transparent border-b dark:border-white/40  shadow-transparent">
                                                @if ($student->account_status == 'in progress')
                                                    <span
                                                        class="bg-gradient-to-tl from-lime-200 to-lime-400 px-2.5 text-xs rounded-1.8 py-1.4 inline-block  text-center align-baseline font-bold uppercase leading-none text-white">In
                                                        progress</span>
                                                @elseif($student->account_status == 'verified')
                                                    <span
                                                        class="bg-gradient-to-tl from-emerald-500 to-teal-400 px-2.5 text-xs rounded-1.8 py-1.4 inline-block  text-center align-baseline font-bold uppercase leading-none text-white">Verified</span>
                                                @endif
                                            </td> --}}
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
                                                            <a href="{{ route('company.students.overview', $student->id) }}"
                                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-white dark:hover:text-white">View</a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ route('company.students.edit', $student->id) }}"
                                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-white dark:hover:text-white">Edit</a>
                                                        </li>
                                                        {{-- <li>
                                                            <a href="{{ route('company.students.login-security', $student->id) }}"
                                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-white dark:hover:text-white">Login
                                                                Security</a>
                                                        </li> --}}
                                                        <li>
                                                          <form id="form_{{ $student->id }}" class="m-0 p-0"
                                                                action="{{ route('company.students.destroy', $student->id) }}"
                                                                method="POST" class="inline-block">
                                                                @csrf @method('DELETE') </form>
                                                                <a role="button" href="javascript:;"
                                                                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-white dark:hover:text-white"
                                                                    onclick="confirmDelete({{ $student->id }})">Delete</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center m-4">
                            {!! $students->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
