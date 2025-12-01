@extends('layouts.mobile-layout')

@section('nav-options')
    <nav>
        <ol class="flex flex-wrap pt-1 mr-12 bg-transparent rounded-lg sm:mr-16">
            <li class="text-neutral-900 text-sm"><a class="text-white">Home</a></li>
            <li class="text-sm pl-2 text-white before:pr-2 before:content-['/']"><a class="text-white">Dashboard</a></li>
            <li class="text-sm pl-2 text-white font-bold before:pr-2 before:content-['/']">Grades</li>
        </ol>
        <h6 class="mb-0 font-bold text-white capitalize">Grades</h6>
    </nav>
@endsection

@section('content')
    <div class="w-full px-6 py-6 mx-auto">

        <div class="flex flex-wrap -mx-3 mt-4">
            <div class="flex-none w-full max-w-full px-3">
                <div class="bg-white shadow-xl rounded-2xl">

                    <div class="card-title p-3 my-3  rounded-t-2xl flex justify-between">
                        <h6 class="dark:text-white">Grades List</h6>
                        <a href="{{ route('admin.app.grades.create') }}"
                            class="bg-emerald-500/50 rounded-full text-sm text-white px-4 fw-bold py-1">
                            <i class="bi bi-plus"></i> Create
                        </a>
                    </div>
                </div>
                <div class="bg-white shadow-xl rounded-2xl mt-4">

                    <div class="px-3 pt-0 pb-2 overflow-x-auto">
                        <table class="w-full text-slate-500 mt-4">
                            <thead class="border-b">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xxs uppercase">Thumb</th>
                                    <th class="px-6 py-3 text-left text-xxs uppercase">Title</th>
                                    <th class="px-6 py-3 text-center text-xxs uppercase">Position</th>
                                    <th class="px-6 py-3 text-center text-xxs uppercase">Status</th>
                                    <th class="px-6 py-3 text-center text-xxs uppercase">Created</th>
                                    <th class="px-6 py-3"></th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($grades as $key => $grade)
                                    <tr class="border-b">
                                        <td class="p-2">
                                            <img src="{{ $grade->thumbnail_url }}" class="h-12 w-12 object-cover rounded">
                                        </td>

                                        <td class="p-2">{{ $grade->name }}</td>

                                        <td class="p-2 text-center">{{ $grade->position }}</td>

                                        <td class="p-2 text-center">
                                            @if ($grade->published)
                                                <span
                                                    class="bg-emerald-500/50 text-white text-xs px-3 py-1 rounded-full">Published</span>
                                            @else
                                                <span
                                                    class="bg-red-500 text-white text-xs px-3 py-1 rounded-full">Hidden</span>
                                            @endif
                                        </td>

                                        <td class="p-2 text-center text-xs">{{ $grade->created_at }}</td>

                                        <td class="p-2 align-middle">
                                            <button data-dropdown-toggle="dropdown_{{ $grade->id }}">
                                                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-width="2"
                                                        d="M12 6h.01M12 12h.01M12 18h.01" />
                                                </svg>
                                            </button>
                                            <div id="dropdown_{{ $grade->id }}"
                                                class="hidden z-10 bg-white rounded-lg shadow w-44">
                                                <ul class="py-2 text-sm text-gray-700 shadow-blur">
                                                    <li>
                                                        <a href="{{ route('admin.app.grades.edit', $grade->id) }}"
                                                            class="block px-4 py-2 hover:bg-gray-100">Edit</a>
                                                    </li>
                                                    <li>
                                                        <form id="form_{{ $grade->id }}" method="POST"
                                                            action="{{ route('admin.app.grades.destroy', $grade->id) }}">
                                                            @csrf @method('DELETE')
                                                        </form>
                                                        <a onclick="confirmDelete({{ $grade->id }})"
                                                            class="block px-4 py-2 hover:bg-gray-100"
                                                            role="button">Delete</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>


                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5">No Grades Found</td>
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
