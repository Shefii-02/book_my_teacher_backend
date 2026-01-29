@extends('layouts.layout')

@section('nav-options')
    <nav>
        <!-- breadcrumb -->
        <ol class="flex flex-wrap pt-1 mr-12 bg-transparent rounded-lg sm:mr-16">
            <li class="text-neutral-900 text-sm">
                <a class="text-white" href="/">Home</a>
            </li>
            <li
                class="text-sm pl-2 capitalize text-white before:float-left before:pr-2 before:text-white before:content-['/']">
                <a class="text-white" href="{{ route('company.dashboard') }}">Dashboard</a>
            </li>
            <li class="text-sm pl-2 font-bold capitalize text-white before:float-left before:pr-2 before:text-white before:content-['/']"
                aria-current="page">Webinars</li>
        </ol>
        <h6 class="mb-0 font-bold text-white capitalize">Webinars</h6>
    </nav>
@endsection

@section('content')
    <div class="w-full px-6 py-6 mx-auto">
        <!-- cards -->
        <div class="flex flex-wrap -mx-3 mb-6">

            @foreach ($statuses as $key => $label)
                <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
                    <div
                        class="relative flex flex-col min-w-0 break-words bg-white shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                        <div class="flex-auto p-4">
                            <div class="flex flex-row -mx-3">
                                <div class="flex-none w-2/3 max-w-full px-3">
                                    <div>
                                        <p
                                            class="mb-0 font-petro font-semibold text-neutral-900 uppercase leading-tight dark:text-white dark:opacity-80 text-slate-400 dark:opacity-60 text-sm">
                                            {{ $label }}</p>
                                        <h5
                                            class="mb-2 font-bold leading-tight dark:text-white dark:opacity-80 text-slate-400">
                                            {{ $data[$key] ?? 0 }}</h5>
                                    </div>
                                </div>
                                <div class="px-3 text-right basis-1/3">
                                    <div
                                        class="inline-block w-12 h-12 text-center rounded-circle bg-gradient-to-tl {{ $colors[$key] }}">
                                        <i class="{{ $icons[$key] }} text-lg relative top-3.5 text-white"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Webinars Table -->
        <div class="flex flex-wrap -mx-3 mt-4">
            <div class="flex-none w-full max-w-full px-3">
                <div
                    class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                    <div class="p-6 pb-0 mb-3 border-b border-b-transparent flex justify-between items-center">
                        <h6 class="leading-tight dark:text-white dark:opacity-80 text-slate-400">Webinars List</h6>
                        <a href="{{ route('company.webinars.create') }}"
                            class="px-4 py-2 bg-gradient-to-tl from-emerald-500 mb-4 to-teal-400  text-white rounded text-sm">
                            <i class="bi bi-plus"></i>
                            Create Webinar</a>
                    </div>

                    <div class="flex-auto px-0 pt-0 pb-2">
                        <div class="p-0 overflow-x-auto">
                            <table
                                class="items-center w-full mb-0 align-top border-collapse dark:border-white/40 text-slate-500">
                                <thead>
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-center font-bold text-xs uppercase align-middle bg-transparent border-b border-solid tracking-none text-slate-400 opacity-70">
                                            ID</th>
                                        <th
                                            class="px-6 py-3 text-left font-bold text-xs uppercase align-middle bg-transparent border-b border-solid tracking-none text-slate-400 opacity-70">
                                            Title</th>
                                        <th
                                            class="px-6 py-3 text-left font-bold text-xs uppercase align-middle bg-transparent border-b border-solid tracking-none text-slate-400 opacity-70">
                                            Host</th>
                                        <th
                                            class="px-6 py-3 text-left font-bold text-xs uppercase align-middle bg-transparent border-b border-solid tracking-none text-slate-400 opacity-70">
                                            Provider</th>
                                        <th
                                            class="px-6 py-3 text-center font-bold text-xs uppercase align-middle bg-transparent border-b border-solid tracking-none text-slate-400 opacity-70">
                                            Created At</th>
                                        <th
                                            class="px-6 py-3 text-center font-bold text-xs uppercase align-middle bg-transparent border-b border-solid tracking-none text-slate-400 opacity-70">
                                            Started At</th>
                                        <th
                                            class="px-6 py-3 text-center font-bold text-xs uppercase align-middle bg-transparent border-b border-solid tracking-none text-slate-400 opacity-70">
                                            Ended At</th>
                                        <th
                                            class="px-6 py-3 text-center font-bold text-xs uppercase align-middle bg-transparent border-b border-solid tracking-none text-slate-400 opacity-70">
                                            Max Participants</th>
                                        <th
                                            class="px-6 py-3 text-center font-bold text-xs uppercase align-middle bg-transparent border-b border-solid tracking-none text-slate-400 opacity-70">
                                            Status</th>
                                        <th
                                            class="px-6 py-3 text-center font-semibold capitalize align-middle bg-transparent border-b border-solid tracking-none text-slate-400 opacity-70">
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($webinars as $key => $webinar)
                                        <tr>
                                            <td
                                                class="px-6 py-3 text-center font-bold text-xs uppercase align-middle bg-transparent border-b border-solid tracking-none text-slate-400 opacity-70">
                                                {{ $key + 1 }}</td>
                                            <td
                                                class="px-6 py-3 text-center font-bold text-xs uppercase align-middle bg-transparent border-b border-solid tracking-none text-slate-400 opacity-70">
                                                <div class="flex items-center">
                                                    @if ($webinar->thumbnail_image)
                                                        <img src="{{ asset('storage/' . $webinar->thumbnail_image) }}"
                                                            class="h-9 w-9 rounded mr-2" alt="thumb">
                                                    @endif
                                                </div>
                                                <span
                                                    class="text-sm leading-tight dark:text-white dark:opacity-80 text-slate-400">{{ $webinar->title }}</span>
                                            </td>
                                            <td
                                                class="px-6 py-3 text-center font-bold text-xs uppercase align-middle bg-transparent border-b border-solid tracking-none text-slate-400 opacity-70">
                                                {{ $webinar->host?->name ?? 'N/A' }}</td>
                                            <td
                                                class="px-6 py-3 text-center font-bold text-xs uppercase align-middle bg-transparent border-b border-solid tracking-none text-slate-400 opacity-70">
                                                {{ $webinar->provider?->name ?? 'N/A' }}</td>
                                            <td
                                                class="px-6 py-3 text-center font-bold text-xs uppercase align-middle bg-transparent border-b border-solid tracking-none text-slate-400 opacity-70">
                                                {{ $webinar->created_at?->format('d M Y') }}</td>
                                            <td
                                                class="px-6 py-3 text-center font-bold text-xs uppercase align-middle bg-transparent border-b border-solid tracking-none text-slate-400 opacity-70">
                                                {{ $webinar->started_at?->format('d M Y H:i') ?? '-' }}</td>
                                            <td
                                                class="px-6 py-3 text-center font-bold text-xs uppercase align-middle bg-transparent border-b border-solid tracking-none text-slate-400 opacity-70">
                                                {{ $webinar->ended_at?->format('d M Y H:i') ?? '-' }}</td>
                                            <td
                                                class="px-6 py-3 text-center font-bold text-xs uppercase align-middle bg-transparent border-b border-solid tracking-none text-slate-400 opacity-70">
                                                {{ $webinar->max_participants ?? '-' }}</td>
                                            <td class="p-2 text-center">
                                                <span
                                                    class="{{ $statusColors[$webinar->status] ?? 'bg-emerald-500/50' }} px-2.5 py-1.5 text-xs rounded text-white">{{ ucfirst($webinar->status) }}</span>
                                            </td>
                                            <td
                                                class="p-2 align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
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
                                                            <a href="{{ route('company.webinars.show', $webinar->id) }}"
                                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-white dark:hover:text-white">View</a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ route('company.webinars.edit', $webinar->id) }}"
                                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-white dark:hover:text-white">Edit</a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ $webinar->meeting_url }}"
                                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-white dark:hover:text-white">Start
                                                                Streaming</a>
                                                        </li>
                                                        <li>
                                                            <form id="form_{{ $webinar->id }}" class="m-0 p-0"
                                                                action="{{ route('company.webinars.destroy', $webinar->id) }}"
                                                                method="POST" class="inline-block">
                                                                @csrf @method('DELETE') </form>
                                                            <a role="button" href="javascript:;"
                                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-white dark:hover:text-white"
                                                                onclick="confirmDelete({{ $webinar->id }})">Delete</a>

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
                        {!! $webinars->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
