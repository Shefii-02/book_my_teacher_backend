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
                aria-current="page">Boad/University List</li>
        </ol>
        <h6 class="mb-0 font-bold text-white capitalize">Boad/University List</h6>
    </nav>
@endsection

@section('content')
    <div class="w-full px-6 py-6 mx-auto">

        <div class="flex flex-wrap -mx-3 mt-4">
            <div class="flex-none w-full max-w-full px-3">
                <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white shadow-xl rounded-2xl">

                    <div class="p-6 pb-0 mb-3 border-b border-transparent rounded-t-2xl">
                        <div class="flex justify-between">
                            <h6>Boad/University List</h6>
                            <a href="{{ route('company.app.boards.create') }}"
                                class="bg-emerald-500/50 rounded-full text-sm text-white px-4 fw-bold py-1">
                                <i class="bi bi-plus me-1 "></i>
                                Create
                            </a>
                        </div>
                    </div>
                </div>
                <div class="relative flex flex-col min-w-0 my-6 break-words bg-white shadow-xl rounded-2xl">
                    <div class="flex-auto px-3 pt-0 pb-2 overflow-x-auto">
                        <table class="items-center w-full my-4 text-slate-500 align-top border-collapse">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left text-xxs uppercase">Thumb</th>
                                    <th class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">Name</th>
                                    <th class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">Grades</th>
                                    <th class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">Subjects</th>
                                    <th class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">Status</th>
                                    <th class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($boards as $board)
                                    <tr class="border-b">
                                        <td class="p-2">
                                            <img src="{{ $board->icon_url }}" class="h-12 w-12 ms-2 object-cover rounded">
                                        </td>
                                        <td class="p-2">
                                          <span class="ms-2">{{ $board->name }}
                                            </span></td>

                                        <td class="p-2">
                                            @foreach ($board->grades as $g)
                                                <span
                                                    class="px-2 py-1 bg-blue-100 text-blue-700 ms-2 rounded text-xs">{{ $g->name }}</span>
                                            @endforeach
                                        </td>

                                        <td class="p-2">
                                            @foreach ($board->subjects as $s)
                                                <span
                                                    class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs">{{ $s->name }}</span>
                                            @endforeach
                                        </td>



                                        <td class="p-2 text-center align-middle">
                                            @if ($board->published)
                                                <span class="bg-emerald-500/50 text-white px-3 py-1 text-xs rounded-full">
                                                    Published
                                                </span>
                                            @else
                                                <span class="bg-red-500 text-white px-3 py-1 text-xs rounded-full">
                                                    Unpublished
                                                </span>
                                            @endif


                                        </td>

                                        <td class="p-2 align-middle">
                                            <button data-dropdown-toggle="dropdown_{{ $board->id }}">
                                                <svg class="w-6 h-6 ms-4 text-gray-700" fill="none" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-width="2"
                                                        d="M12 6h.01M12 12h.01M12 18h.01" />
                                                </svg>
                                            </button>
                                            <div id="dropdown_{{ $board->id }}"
                                                class="hidden z-10 bg-white rounded-lg shadow w-44">
                                                <ul class="py-2 text-sm text-gray-700 shadow-blur">
                                                    <li>
                                                        <a href="{{ route('company.app.boards.edit', $board->id) }}"
                                                            class="block px-4 py-2 hover:bg-gray-100">Edit</a>
                                                    </li>
                                                    <li>
                                                        <form id="form_{{ $board->id }}" method="POST"
                                                            action="{{ route('company.app.boards.destroy', $board->id) }}">
                                                            @csrf @method('DELETE')
                                                        </form>
                                                        <a onclick="confirmDelete({{ $board->id }})"
                                                            class="block px-4 py-2 hover:bg-gray-100"
                                                            role="button">Delete</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="mt-4">
                            {{ $boards->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
