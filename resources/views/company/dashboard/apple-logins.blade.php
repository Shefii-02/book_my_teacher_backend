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
                aria-current="page">Apple Sign In List</li>
        </ol>
        <h6 class="mb-0 font-bold text-white capitalize">Apple Sign In List</h6>
    </nav>
@endsection

@section('content')
    <!-- cards -->
    <div class="w-full px-6 py-6 mx-auto">
        <!-- row 1 -->
        <div class="flex flex-wrap justify-center -mx-3">
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
                                        Total Attempt</p>
                                    <h5 class="mb-2 font-bold dark:text-white">{{ $data['total_otp'] }}</h5>
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
                                        Verified </p>
                                    <h5 class="mb-2 font-bold dark:text-white">{{ $data['verified'] }}</h5>

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
                                      unverified </p>
                                    <h5 class="mb-2 font-bold dark:text-white">{{ $data['unverified'] }}</h5>

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

        </div>

        <!-- table 1 -->

        <div class="flex flex-wrap -mx-3 mt-4">
            <div class="flex-none w-full max-w-full px-3">
                <div
                    class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                    <div class="p-6 pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                        <div class="flex">
                            <div class="w-full max-w-full px-3 mb-2 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
                                <h5 class="dark:text-white">Apple Sign In List</h5>
                            </div>
                            <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">

                            </div>
                            <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">

                            </div>
                            <div class="w-full text-right max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">

                            </div>
                        </div>
                    </div>
                    <div class="p-6 pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">

                        <div class="w-full max-w-full ">
                            <form method="GET" action="{{ route('company.otp-list') }}"
                                class="mb-4 flex flex-wrap gap-4 items-end">

                                {{-- 🔍 Search Mobile --}}
                                <div class="w-1/4">
                                    <label class="block text-sm font-medium mb-1">Email Id</label>
                                    <input type="text" name="email" value="{{ request('email') }}"
                                        placeholder="Enter email id" class="border rounded w-100 px-3 py-2 w-48">
                                </div>

                                {{-- 📌 Status --}}
                                <div>
                                    <label class="block text-sm font-medium mb-1">Status</label>
                                    <select name="status" class="border rounded px-3 py-2 w-40">
                                        <option value="">All</option>
                                        <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>
                                            Verified</option>
                                        <option value="unverified"
                                            {{ request('status') == 'unverified' ? 'selected' : '' }}>Unverified</option>
                                    </select>
                                </div>

                                {{-- 📅 Created From --}}
                                <div>
                                    <label class="block text-sm font-medium mb-1">From Date</label>
                                    <input type="date" name="start_date" value="{{ request('start_date') }}"
                                        class="border rounded px-3 py-2">
                                </div>

                                {{-- 📅 Created To --}}
                                <div>
                                    <label class="block text-sm font-medium mb-1">To Date</label>
                                    <input type="date" name="end_date" value="{{ request('end_date') }}"
                                        class="border rounded px-3 py-2">
                                </div>

                                {{-- Buttons --}}
                                <div class="flex gap-2">
                                    <button type="submit"
                                        class="px-4 py-2 bg-gradient-to-tl from-emerald-500 to-teal-400 text-white rounded text-sm">
                                        <i class="bi bi-search"></i> Apply
                                    </button>

                                    <a href="{{ route('company.otp-list') }}"
                                        class="px-4 py-2 bg-slate-500 text-white rounded text-sm">
                                        <i class="bi bi-arrow-clockwise"></i> Reset
                                    </a>
                                </div>
                            </form>


                        </div>
                    </div>
                @php
                    $activeFilters = collect(
                        request()->only(['mobile', 'status', 'start_date', 'end_date'])
                    )->filter(fn ($value) => filled($value));
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
                            <a href="{{ route('company.otp-list') }}" class="ml-3 mt-2.5 text-sm text-red-600">Clear
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
                                            Email id</th>
                                        <th
                                            class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                            Source</th>
                                        <th
                                            class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                           Logged in At</th>
                                        <th
                                            class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                             Created At</th>
                                        <th
                                            class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                            Account Status</th>
                                        <th
                                            class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                            Status
                                        </th>
                                        <th
                                            class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                            Action
                                        </th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($logins ?? [] as $key => $login)
                                        <tr>
                                            <td
                                                class="p-2 align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                                <div class="flex px-2 py-1">
                                                    <div class="flex flex-col justify-center">
                                                        <h6 class="mb-0 text-sm text-neutral-900 dark:text-white">
                                                            {{ $login->mobile }}</h6>
                                                        <div class="flex gap-3">
                                                            <a target="_blank"
                                                                href="https://web.whatsapp.com/send/?text=&type=custom_url&app_absent=0&utm_campaign=wa_api_send_v1&phone{{ $login->mobile }}"
                                                                class="mb-0 text-sm text-neutral-900 dark:text-white">
                                                                <i class="bi bi-whatsapp text-green-400"></i></a>
                                                            <a target="_blank" href="tel://{{ $login->mobile }}"
                                                                class="mb-0 text-sm text-neutral-900 dark:text-white">
                                                                <i class="bi bi-telephone text-blue-400"></i></a>
                                                        </div>
                                                        @if (in_array($login->mobile, $duplicates))
                                                            <span
                                                                class="bg-red-800 mt-2 px-2.5 text-xs rounded-1.8 py-1.4 inline-block whitespace-nowrap text-center align-baseline font-bold capitalize leading-none text-white">
                                                                Repeated
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td
                                                class="p-2 align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                                <p
                                                    class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-80 text-slate-400">
                                                    {{ $login->otp }}
                                                </p>
                                            </td>
                                            <td
                                                class="p-2 align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                                <p
                                                    class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-80 text-slate-400">
                                                    {{ $login->created_at }}
                                                </p>
                                            </td>
                                            <td
                                                class="p-2 align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                                <p
                                                    class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-80 text-slate-400">
                                                    {{ $login->expires_at }}
                                                </p>
                                            </td>
                                            <td
                                                class="p-2 text-sm text-neutral-900 text-center align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                                @if ($login->user)
                                                    <span
                                                        class="bg-gradient-to-tl from-emerald-500 to-teal-400 px-2.5 text-xs rounded-1.8 py-1.4 inline-block whitespace-nowrap text-center align-baseline font-bold capitalize leading-none text-white">Created</span>
                                                @else
                                                    <span
                                                        class="bg-red-600 px-2.5 text-xs rounded-1.8 py-1.4 inline-block whitespace-nowrap text-center align-baseline font-bold capitalize leading-none text-white">Not
                                                        Created</span>
                                                @endif
                                            </td>
                                            <td
                                                class="p-2 text-sm text-neutral-900 text-center align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                                @if ($login->verified == '1')
                                                    <span
                                                        class="bg-gradient-to-tl from-emerald-500 to-teal-400 px-2.5 text-xs rounded-1.8 py-1.4 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white">Verified</span>
                                                @elseif($login->verified == '0')
                                                    <span
                                                        class="bg-gradient-to-tl from-slate-600 to-slate-300 px-2.5 text-xs rounded-1.8 py-1.4 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white">Unverifed</span>
                                                @endif
                                            </td>
                                            <td
                                                class="p-2 text-sm text-neutral-900 text-center align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                                <button type="button" data-drawer-target="drawer-right-example"
                                                    data-drawer-show="drawer-right-example" data-drawer-placement="right"
                                                    aria-controls="drawer-right-example"
                                                    class="editOtpBtn px-3 py-1 text-xs font-bold text-white bg-orange-300 rounded-full hover:bg-blue-600"
                                                    data-id="{{ $login->id }}">
                                                    <i class="bi bi-pencil" </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center m-4">
                            {!! $logins->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- drawer component -->
    <div id="drawer-right-example"
        class="fixed top-0 right-0 z-40 h-screen p-4 overflow-y-auto transition-transform translate-x-full bg-white w-80 dark:bg-gray-800"
        tabindex="-1" aria-labelledby="drawer-right-label">
        <h5 id="drawer-right-label"
            class="inline-flex items-center mb-4 text-base font-semibold text-gray-500 dark:text-gray-400"><svg
                class="w-4 h-4 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>Edit a OTP</h5>
        <button type="button" data-drawer-hide="drawer-right-example" aria-controls="drawer-right-example"
            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 absolute top-2.5 end-2.5 inline-flex items-center justify-center dark:hover:bg-gray-600 dark:hover:text-white">
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
            </svg>
            <span class="sr-only">Close menu</span>
        </button>

        <div class="grid grid-cols-1 gap-4">
            <!-- Ajax Content will load here -->
            <div id="editOtpContent">
                <p class="text-gray-400">Loading...</p>
            </div>
        </div>
    </div>


    <!-- Single Offcanvas Drawer -->
    {{-- <div id="editOtpDrawer"
        class="fixed top-0 right-0 z-40 h-screen p-4 overflow-y-auto transition-transform translate-x-full bg-white w-96 dark:bg-gray-800"
        tabindex="-1">

        <h5 class="mb-4 text-base font-semibold text-gray-500 dark:text-gray-400">Edit OTP</h5>

        <!-- Close Button -->
        <button type="button" data-drawer-hide="editOtpDrawer" aria-controls="editOtpDrawer"
            class="absolute top-2.5 right-2.5 p-1.5 rounded-lg text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white">
            ✕
        </button>

        <!-- Ajax Content will load here -->
        <div id="editOtpContent">
            <p class="text-gray-400">Loading...</p>
        </div>
    </div> --}}
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $(".editOtpBtn").click(function() {
                let otpId = $(this).data("id");

                // show drawer
                const drawer = document.getElementById("drawer-right-example");
                drawer.classList.remove("translate-x-full");

                // load content
                $("#editOtpContent").html("<p class='text-gray-400'>Loading...</p>");

                $.ajax({
                    url: "/company/otp/" + otpId + "/edit", // route
                    type: "GET",
                    success: function(response) {
                        $("#editOtpContent").html(response);
                    },
                    error: function() {
                        $("#editOtpContent").html(
                            "<p class='text-red-500'>Failed to load form</p>");
                    }
                });
            });
        });
    </script>
@endpush
