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

                               <a href="#"
                                    class="px-4 py-2 bg-gradient-to-tl from-emerald-500 to-teal-400  create-step text-white rounded text-sm">
                                    <i class="bi bi-plus me-2"></i> Create Company</a>
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
                                        Logo</th>
                                    <th
                                        class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                        Name</th>
                                    <th
                                        class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                        Contact Person</th>
                                    <th
                                        class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                        City/State</th>
                                    <th
                                        class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                        Subscription</th>
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
                                      {{-- logo --}}
                                        <td class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                            <img src="{{ asset('storage/' . $company ? $company->black_logo_url : '') }}"
                                                class="inline-flex items-center justify-center mr-4 text-sm text-white transition-all duration-200 ease-in-out h-9 w-9 rounded-xl"
                                                alt="user1" />
                                        </td>
                                        {{-- //company name --}}
                                         <td
                                            class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                            <div class="flex px-2 py-1">

                                                <div class="flex flex-col justify-center">
                                                    <h6 class="mb-0 text-sm text-neutral-900 dark:text-white">
                                                        {{ $company->name }}</h6>

                                                    <div class="flex gap-3">
                                                        <a target="_blank"
                                                            href="https://web.whatsapp.com/send/?text=&type=custom_url&app_absent=0&utm_campaign=wa_api_send_v1&phone{{ $company->user->mobile }}"
                                                            class="mb-0 text-sm text-neutral-900 dark:text-white">
                                                            <i class="bi bi-whatsapp text-green-400"></i></a>
                                                        <a target="_blank" href="tel://{{ $company->mobile }}"
                                                            class="mb-0 text-sm text-neutral-900 dark:text-white">
                                                            <i class="bi bi-telephone text-blue-400"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        {{-- contactperson --}}
                                        <td
                                            class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                            <div class="flex px-2 py-1">

                                                <div>
                                                    <img src="{{ $company->user ? $company->user->avatar_url : '' }}"
                                                        class="inline-flex items-center justify-center mr-4 text-sm text-white transition-all duration-200 ease-in-out h-9 w-9 rounded-xl"
                                                        alt="user1" />
                                                </div>
                                                <div class="flex flex-col justify-center">
                                                    <h6 class="mb-0 text-sm text-neutral-900 dark:text-white">
                                                        {{ $company->user->name }}</h6>
                                                    <p
                                                        class="my-1 text-xs leading-tight dark:text-white dark:opacity-80 text-slate-400">
                                                        <a href="#" class="__cf_email__" title="{{ $company->user->email }}">{{ Str::limit($company->user->email, 10, '...')  }}</a>
                                                    </p>
                                                    <p
                                                        class="mb-0 text-xs leading-tight dark:text-white dark:opacity-80 text-slate-400">
                                                        <a href="#" class="__cf_email__">{{ $company->user->mobile }}</a>
                                                    </p>
                                                    <div class="flex gap-3">
                                                        <a target="_blank"
                                                            href="https://web.whatsapp.com/send/?text=&type=custom_url&app_absent=0&utm_campaign=wa_api_send_v1&phone{{ $company->user->mobile }}"
                                                            class="mb-0 text-sm text-neutral-900 dark:text-white">
                                                            <i class="bi bi-whatsapp text-green-400"></i></a>
                                                        <a target="_blank" href="tel://{{ $company->user->mobile }}"
                                                            class="mb-0 text-sm text-neutral-900 dark:text-white">
                                                            <i class="bi bi-telephone text-blue-400"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        {{-- city/state --}}
                                        <td
                                            class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                            <p
                                                class="mb-0 text-xs font-semibold capitalize leading-tight dark:text-white dark:opacity-80 text-slate-400">
                                                {{ $company?->city }}/{{ $company?->state }}
                                            </p>
                                        </td>
                                        {{-- subscription --}}
                                        <td
                                            class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                            <p
                                                class="mb-0 capitalize text-xs font-semibold text-center leading-tight dark:text-white dark:opacity-80 text-slate-400">
                                                --
                                            </p>
                                        </td>
                                        {{-- created_at --}}
                                        <td
                                            class="p-2 text-center align-middle bg-transparent border-b dark:border-white/40  shadow-transparent">
                                            <span
                                                class="text-xs font-semibold leading-tight dark:text-white dark:opacity-80 text-slate-400">{{ $company?->created_at }}</span>
                                        </td>
                                          {{-- status --}}
                                        <td
                                            class="p-2 text-center align-middle bg-transparent border-b dark:border-white/40  shadow-transparent capitalize">
                                            @if ($company->user->account_status == 'under review')
                                                <span
                                                    class="bg-gradient-to-tl capitalize from-lime-200 to-lime-400 px-2.5 text-xs rounded-1.8 py-1.4 inline-block  text-center align-baseline font-bold  leading-none text-white">Account under review</span>
                                            @elseif($company->user->account_status == 'policy violation')
                                                <span
                                                    class="bg-gradient-to-tl capitalize from-slate-600 to-slate-300 px-2.5 text-xs rounded-1.8 py-1.4 inline-block  text-center align-baseline font-bold  leading-none text-white">Policy Violation</span>
                                            @elseif($company->user->account_status == 'approved')
                                                <span
                                                    class="bg-gradient-to-tl capitalize from-emerald-500 to-teal-400 px-2.5 text-xs rounded-1.8 py-1.4 inline-block  text-center align-baseline font-bold  leading-none text-white">Approved</span>
                                            @elseif($company->user->account_status == 'suspended')
                                                <span
                                                    class="bg-gradient-to-tl capitalize bg-red-900 px-2.5 text-xs rounded-1.8 py-1.4 inline-block  text-center align-baseline font-bold  leading-none text-white">Suspended</span>
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
                                                        <a href="{{ route('admin.companies.show', $company->id) }}"
                                                            class="block px-4 py-2 capitalize hover:bg-gray-100 dark:hover:bg-white dark:hover:text-white">View</a>
                                                    </li>
                                                    <li>
                                                        <a data-url="{{ route('admin.companies.edit', $company->id) }}"
                                                            class="block edit-step px-4 py-2 capitalize hover:bg-gray-100 dark:hover:bg-white dark:hover:text-white">Edit</a>
                                                    </li>
                                                    <li>
                                                        <a href="{{-- route('admin.teachers.login-security', $company->id) --}}"
                                                            class="block px-4 py-2 capitalize hover:bg-gray-100 dark:hover:bg-white dark:hover:text-white">Login
                                                            Security</a>
                                                    </li>
                                                    <li>
                                                        <form id="form_{{ $company->id }}" class="m-0 p-0"
                                                            action="{{ route('admin.companies.destroy', $company->id) }}"
                                                            method="POST" class="inline-block">
                                                            @csrf @method('DELETE') </form>
                                                        <a role="button" href="javascript:;"
                                                            class="block px-4 py-2 capitalize hover:bg-gray-100 dark:hover:bg-white dark:hover:text-white"
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



@push('scripts')
    <script>
        $(document).ready(function() {
            $(document).on('click', '.create-step', function(e) {
                e.preventDefault();
                $('#drawerContent').html('<div class="text-center text-gray-400 p-5">Loading...</div>');

                $.get(`{{ route('admin.companies.create') }}`, function(html) {
                    $('#drawerContent').html(html);
                    openDrawer(); // will work now
                }).fail(function() {
                    $('#drawerContent').html(
                        '<div class="text-center text-red-500 p-5">Failed to load.</div>');
                });

            });
            $(document).on('click', '.edit-step', function(e) {
                e.preventDefault();

                let url = $(this).data('url');

                $('#drawerContent').html('<div class="text-center text-gray-400 p-5">Loading...</div>');

                $.get(url, function(html) {
                    $('#drawerContent').html(html);
                    openDrawer();
                }).fail(function() {
                    $('#drawerContent').html(
                        '<div class="text-center text-red-500 p-5">Failed to load.</div>'
                    );
                });
            });

        });
    </script>
@endpush
