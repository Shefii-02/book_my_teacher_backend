@extends('layouts.mobile-layout')

@section('nav-options')
    <nav>
        <ol class="flex flex-wrap pt-1 mr-12 bg-transparent rounded-lg sm:mr-16">
            <li class="text-neutral-900 text-sm">
                <a class="text-white" href="javascript:;">Home</a>
            </li>
            <li class="text-sm pl-2 text-white before:float-left before:pr-2 before:text-white before:content-['/']">
                <a class="text-white" href="javascript:;">Dashboard</a>
            </li>
            <li class="text-sm pl-2 font-bold text-white capitalize before:float-left before:pr-2 before:text-white before:content-['/']"
                aria-current="page">Course Banners List</li>
        </ol>
        <h6 class="mb-0 font-bold text-white capitalize">Course Banners List</h6>
    </nav>
@endsection

@section('content')
    <div class="w-full px-6 py-6 mx-auto">

        <div class="flex flex-wrap -mx-3 mt-4">
            <div class="flex-none w-full max-w-full px-3">
                <div
                    class="relative flex flex-col min-w-0 mb-6 break-words bg-white shadow-xl rounded-2xl dark:bg-slate-850 dark:shadow-dark-xl">

                    <div class="p-6 pb-0 mb-3 border-b border-transparent rounded-t-2xl">
                        <div class="flex justify-between">
                            <h6 class="dark:text-white">Course Banners List</h6>
                            <a href="{{ route('company.app.course-banners.create') }}"
                                class="bg-emerald-500/50 rounded-full text-sm text-white px-4 fw-bold py-1">
                                <i class="bi bi-plus me-1 "></i>
                                Create</a>
                        </div>
                    </div>

                    <div class="flex-auto px-3 pt-0 pb-2 overflow-x-auto">
                        <table class="items-center w-full mb-0 text-slate-500 align-top border-collapse">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 font-bold text-left text-xxs uppercase text-slate-400 opacity-70">
                                        Thumb</th>
                                    <th class="px-6 py-3 font-bold text-left text-xxs uppercase text-slate-400 opacity-70">
                                        Main</th>
                                    <th class="px-6 py-3 font-bold text-left text-xxs uppercase text-slate-400 opacity-70">
                                        Title</th>
                                    <th
                                        class="px-6 py-3 font-bold text-center text-xxs uppercase text-slate-400 opacity-70">
                                        Priority</th>
                                    <th
                                        class="px-6 py-3 font-bold text-center text-xxs uppercase text-slate-400 opacity-70">
                                        Created At</th>
                                    <th
                                        class="px-6 py-3 font-bold text-center text-xxs uppercase text-slate-400 opacity-70">
                                        Status</th>
                                    <th class="px-6 py-3"></th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($banners as $key => $banner)
                                    <tr class="border-b dark:border-white/40">

                                        <!-- Thumb -->
                                        <td class="p-2 align-middle">
                                            <img src="{{ $banner->thumbnail_url }}"
                                                class="h-12  rounded-xl object-cover shadow-sm" alt="thumb">
                                        </td>

                                        <!-- Main Image -->
                                        <td class="p-2 align-middle">
                                            <img src="{{ $banner->main_image_url }}"
                                                class="h-20 w-20 rounded-xl object-cover shadow-sm" alt="main">
                                        </td>

                                        <!-- Title -->
                                        <td class="p-2 align-middle">
                                            <p class="text-sm font-semibold text-neutral-900 dark:text-white">
                                                {{ $banner->title }}
                                            </p>
                                        </td>

                                        <!-- Priority -->
                                        <td class="p-2 align-middle text-center ">
                                            <span class="text-sm text-neutral-900 dark:text-white">
                                                {{ $banner->priority }}
                                            </span>
                                        </td>

                                        <!-- Created At -->
                                        <td class="p-2 text-center align-middle">
                                            <span class="text-xs text-slate-500 dark:text-white">
                                                {{ $banner->created_at->format('d M Y') }}
                                            </span>
                                        </td>

                                        <!-- Status -->
                                        <td class="p-2 text-center align-middle">
                                            @if ($banner->status)
                                                <span
                                                    class="bg-emerald-500/50 text-white px-3 py-1 text-xs rounded-full">Published</span>
                                            @else
                                                <span
                                                    class="bg-red-500 text-white px-3 py-1 text-xs rounded-full">Hidden</span>
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
                                                        <a href="{{ route('company.app.course-banners.edit', $banner->id) }}"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-white dark:hover:text-white">Edit</a>
                                                    </li>
                                                    <li>
                                                        <form id="form_{{ $banner->id }}" class="m-0 p-0"
                                                            action="{{ route('company.app.course-banners.destroy', $banner->id) }}"
                                                            method="POST" class="inline-block">
                                                            @csrf @method('DELETE') </form>
                                                        <a role="button" href="javascript:;"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-white dark:hover:text-white"
                                                            onclick="confirmDelete({{ $banner->id }})">Delete</a>

                                                    </li>
                                                </ul>
                                            </div>

                                        </td>

                                    </tr>
                                @empty
                                    <tr class="border-b dark:border-white/40">
                                        <td colspan="7" align="center">
                                            <h6 class="py-5">No Data Found..</h6>
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
