@extends('layouts.mobile-layout')
@section('nav-options')
    <nav>
        <ol class="flex flex-wrap pt-1 mr-12 bg-transparent rounded-lg sm:mr-16">
            <li class="text-neutral-900 text-sm"><a class="text-white">Home</a></li>
            <li class="text-sm pl-2 text-white before:pr-2 before:content-['/']"><a class="text-white">Dashboard</a></li>
            <li class="text-sm pl-2 text-white font-bold before:pr-2 before:content-['/']">Subjects</li>
        </ol>
        <h6 class="mb-0 font-bold text-white capitalize">Subjects</h6>
    </nav>
@endsection

@section('content')
    <div class="w-full px-6 py-6 mx-auto">

        <div class="flex flex-wrap -mx-3 mt-4">
            <div class="flex-none w-full max-w-full px-3">
                <div class="bg-white shadow-xl rounded-2xl">

                    <div class="card-title p-3 my-3 rounded-t-2xl flex justify-between">
                        <h6 class="dark:text-white">Subjects List</h6>
                        <a href="{{ route('company.app.subjects.create') }}"
                            class="bg-emerald-500/50 rounded text-sm text-white px-4 fw-bold py-1">
                            <i class="bi bi-plus"></i> Create
                        </a>
                    </div>
                </div>
                <div class="bg-white shadow-xl rounded-2xl mt-4">

                    <div class="px-3 py-5 overflow-x-auto">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">

                            @foreach ($subjects as $sub)
                                <div class="border rounded-lg p-4 bg-white shadow">
                                    <div class="flex justify-between">
                                        <div class="flex items-center gap-3 mb-3">
                                            <img src="{{ $sub->icon_url }}"
                                                class="w-14 h-14 rounded object-cover border">

                                            <div>
                                                <h6 class="font-semibold text-lg">{{ $sub->name }}</h6>
                                                @if ($sub->published)
                                                    <span
                                                        class="bg-emerald-500/50 text-white text-xs px-3 py-1 rounded">Published</span>
                                                @else
                                                    <span
                                                        class="bg-red-500 text-white text-xs px-3 py-1 rounded">Hidden</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div>
                                            <button data-dropdown-toggle="dropdown_{{ $sub->id }}">
                                                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-width="2"
                                                        d="M12 6h.01M12 12h.01M12 18h.01" />
                                                </svg>
                                            </button>
                                            <div id="dropdown_{{ $sub->id }}"
                                                class="hidden z-10 bg-white rounded-lg shadow w-44">
                                                <ul class="py-2 text-sm text-gray-700 shadow-blur">
                                                    <li>
                                                        <a href="{{ route('company.app.subjects.edit', $sub->id) }}"
                                                            class="block px-4 py-2 hover:bg-gray-100">Edit</a>
                                                    </li>
                                                    <li>
                                                        <form id="form_{{ $sub->id }}" method="POST"
                                                            action="{{ route('company.app.subjects.destroy', $sub->id) }}">
                                                            @csrf @method('DELETE')
                                                        </form>
                                                        <a onclick="confirmDelete({{ $sub->id }})"
                                                            class="block px-4 py-2 hover:bg-gray-100"
                                                            role="button">Delete</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-2 flex gap-4 justify-between">
                                        <p class="text-sm flex item-center">
                                            <span class="font-semibold">Color:</span>
                                            <span class="inline-block w-5 h-5 rounded ml-2"
                                                style="background: {{ $sub->color_code }}"></span>
                                        </p>

                                        <p class="text-sm">
                                            <span class="font-semibold">Position:</span> {{ $sub->position }}
                                        </p>

                                        <p class="text-sm">
                                        <p class="text-sm text-gray-600">Difficulty: {{ $sub->difficulty_level ?? '---' }}
                                        </p>
                                        </p>
                                    </div>

                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
