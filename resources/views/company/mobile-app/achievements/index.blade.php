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
                aria-current="page">Achievement Level List</li>
        </ol>
        <h6 class="mb-0 font-bold text-white capitalize">Achievement Level List</h6>
    </nav>
@endsection

@section('content')
    <div class="w-full px-6 py-6 mx-auto">

        <div class="flex flex-wrap -mx-3 mt-4">
            <div class="flex-none w-full max-w-full px-3">
                <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white shadow-xl rounded-2xl">

                    <div class="p-6 pb-0 mb-3 border-b border-transparent rounded-t-2xl">
                        <div class="flex justify-between">
                            <h6>Achievement Level List</h6>
                            <a href="{{ route('company.app.achievements.create') }}"
                                class="bg-emerald-500/50 rounded text-sm text-white px-4 fw-bold py-1">
                                <i class="bi bi-plus me-1 "></i>
                                Create
                            </a>
                        </div>
                    </div>
                </div>
                <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white shadow-xl rounded-2xl">

                    <div class="flex-auto px-3 pt-3 pb-2 overflow-x-auto">



                        <div class="grid gap-4">
                            @forelse ($levels ?? [] as $key => $lvl)
                                <div class="bg-white p-4 rounded shadow flex justify-between items-center">
                                    <div>
                                        <h6 class="font-semibold">{{ ucfirst($lvl->role) }} - Level {{ $lvl->level_number }}
                                            : {{ $lvl->title }}</h6>
                                        <p class="text-sm text-gray-600">{{ $lvl->description }}</p>
                                    </div>
                                    <div class="flex gap-2">
                                        <button id="dropdownBottomButton"
                                            data-dropdown-toggle="dropdownBottom_{{ $key }}"
                                            data-dropdown-placement="bottom" class="" type="button">
                                            <svg class="w-6 h-6 text-gray-800 dark:text-black" aria-hidden="true"
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
                                                    <a role="button"
                                                        data-url="{{ route('company.app.achievements.show', $lvl->id) }}"
                                                        class="block px-4 py-2 open-drawer hover:bg-gray-100 dark:hover:bg-white dark:hover:text-white">
                                                        View</a>
                                                </li>

                                                <li>
                                                    <a role="button" href="{{ route('company.app.achievements.edit', $lvl->id) }}"
                                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-white dark:hover:text-white">Edit</a>
                                                </li>

                                                <li>
                                                    <form id="form_{{ $lvl->id }}" class="m-0 p-0"
                                                        action="{{ route('company.app.achievements.destroy', $lvl->id) }}"
                                                        method="POST" class="inline-block">
                                                        @csrf @method('DELETE') </form>
                                                    <a role="button" href="javascript:;"
                                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-white dark:hover:text-white"
                                                        onclick="confirmDelete({{ $lvl->id }})">Delete</a>

                                                </li>
                                                <li>
                                                    <a role="button"
                                                        data-url="{{ route('company.app.achievements.tasks.create', $lvl->id) }}"
                                                        class="block px-4 py-2 open-drawer hover:bg-gray-100 dark:hover:bg-white dark:hover:text-white">Task Create</a>
                                                </li>
                                                <li>
                                                    <a role="button"
                                                        data-url="{{ route('company.app.achievements.tasks.show', $lvl->id) }}"
                                                        class="block px-4 py-2 open-drawer hover:bg-gray-100 dark:hover:bg-white dark:hover:text-white">Task List</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="bg-white p-4 rounded shadow flex justify-between items-center">
                                    <div>
                                        <h5 class="font-semibold text-center">No data found..</h5>
                                    </div>
                                </div>
                            @endforelse
                        </div>

                        <div class="mt-4">
                            {{ $levels->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
