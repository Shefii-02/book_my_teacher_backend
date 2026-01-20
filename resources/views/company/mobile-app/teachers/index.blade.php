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
                aria-current="page">Teachers</li>
        </ol>
        <h6 class="mb-0 font-bold text-white capitalize">Teachers List</h6>
    </nav>
@endsection

@section('content')
    <div class="w-full px-6 py-6 mx-auto">

        <div class="flex flex-wrap -mx-3 mt-4">
            <div class="flex-none w-full max-w-full px-3">
                <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white shadow-xl rounded-2xl">

                    <div class="p-6 pb-0 mb-3 border-b border-transparent rounded-t-2xl">
                        <div class="flex justify-between">
                            <h6>Teachers List</h6>
                            <a href="{{ route('company.app.teachers.create') }}"
                                class="bg-emerald-500/50 rounded text-sm text-white px-4 fw-bold py-1">
                                <i class="bi bi-plus me-1 "></i>
                                Create
                            </a>
                        </div>
                    </div>

                    <div class="flex-auto px-3 pt-0 pb-2 overflow-x-auto">
                        <table class="items-center w-full mb-0 text-slate-500 align-top border-collapse">
                            <thead class="align-bottom">
                                <tr>
                                    <th class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">Photo</th>
                                    <th class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">Name</th>
                                    <th class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">Subjects</th>
                                    <th class="px-6 py-3 font-bold text-center text-xxs uppercase opacity-70">Rates</th>
                                    <th class="px-6 py-3 font-bold text-center text-xxs uppercase opacity-70">Earnings</th>
                                    <th class="px-6 py-3 font-bold text-center text-xxs uppercase opacity-70">Status</th>
                                    <th class="px-6 py-3"></th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($teachers as $t)
                                    <tr class="border-b">
                                        <td class="p-2 align-middle">
                                            <img src="{{ $t->thumbnail_url }}"
                                                class="h-12 rounded-xl object-cover shadow-sm  ms-4" />
                                        </td>

                                        <td class="p-2 align-middle">
                                            <p class="text-sm font-semibold text-neutral-900  ms-4">
                                                {{ $t->name }}
                                            </p>
                                            <p class="text-xs text-gray-500">{{ $t->email }}</p>
                                        </td>

                                        <td class="p-2 align-middle">
                                            <p class="text-xs">

                                                @foreach ($t->subjectRates as $s)
                                                    <span class="bg-gray-200 text-xs px-2 py-1 rounded-md mr-1">
                                                        {{ $s->subject ? $s->subject->name : '' }}
                                                    </span>
                                                @endforeach
                                            </p>
                                        </td>

                                        <!-- Short summary: average rate -->
                                        <td class="p-2 text-center align-middle">
                                            <span class="text-xs">
                                                Avg: ₹{{ $t->avg_rate }}/hr
                                            </span>
                                        </td>

                                        <!-- Earnings -->
                                        <td class="p-2 text-center align-middle">
                                            <span
                                                class="text-xs font-semibold">₹{{ number_format($t->earnings_total, 0) }}</span>
                                        </td>

                                        <td class="p-2 text-center align-middle">
                                            @if ($t->published == '1')
                                                <span class="bg-emerald-500/50 text-white px-3 py-1 text-xs rounded-full">
                                                    Active
                                                </span>
                                            @else
                                                <span class="bg-red-500 text-white px-3 py-1 text-xs rounded-full">
                                                    Disabled
                                                </span>
                                            @endif
                                        </td>

                                        <td class="p-2 align-middle">
                                            <button data-dropdown-toggle="dropdown_{{ $t->id }}">
                                                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-width="2"
                                                        d="M12 6h.01M12 12h.01M12 18h.01" />
                                                </svg>
                                            </button>
                                            <div id="dropdown_{{ $t->id }}"
                                                class="hidden z-10 bg-white rounded-lg shadow w-44">
                                                <ul class="py-2 text-sm text-gray-700 shadow-blur">
                                                    <li>
                                                        <a href="{{ route('company.app.teachers.edit', $t->id) }}"
                                                            class="block px-4 py-2 hover:bg-gray-100">Edit</a>
                                                    </li>
                                                    <li>
                                                        <a data-url="{{ route('company.app.teachers.login-security', $t->id) }}"
                                                            class="block px-4 py-2 hover:bg-gray-100 open-drawer dark:hover:bg-white dark:hover:text-white">Login
                                                            Security</a>
                                                    </li>
                                                    <li>
                                                        <form id="form_{{ $t->id }}" method="POST"
                                                            action="{{ route('company.app.teachers.destroy', $t->id) }}">
                                                            @csrf @method('DELETE')
                                                        </form>
                                                        <a onclick="confirmDelete({{ $t->id }})"
                                                            class="block px-4 py-2 hover:bg-gray-100"
                                                            role="button">Delete</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5">No teachers found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{-- <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach ($teachers as $t)
                                <div class="bg-white p-4 rounded-xl shadow-md">
                                    <div class="flex items-center gap-4">
                                        <img src="{{ $t->photo_url }}" class="h-16 w-16 rounded-xl object-cover shadow" />
                                        <div>
                                            <h3 class="text-lg font-semibold">{{ $t->name }}</h3>
                                            <p class="text-xs text-gray-500">{{ $t->email }}</p>
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <p class="text-xs font-bold">Subjects</p>
                                        <div class="flex flex-wrap gap-1 mt-1">

                                            @foreach ($t->subjectRates as $s)
                                                <span
                                                    class="bg-gray-200 text-xs px-2 py-1 rounded-md">{{ $s->subject ? $s->subject->name : '' }}</span>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="mt-3 text-xs">
                                        <p><b>Avg Rate:</b> ₹{{ $t->avg_rate }}/hr</p>
                                        <p><b>Total Earnings:</b> ₹{{ $t->earnings_total }}</p>
                                    </div>

                                    <div class="mt-4 flex justify-between items-center">
                                        @if ($t->status)
                                            <span
                                                class="bg-emerald-500/50 px-3 py-1 text-xs rounded-full text-white">Active</span>
                                        @else
                                            <span
                                                class="bg-red-500 px-3 py-1 text-xs rounded-full text-white">Disabled</span>
                                        @endif

                                        <a href="{{ route('company.teachers.edit', $t->id) }}"
                                            class="text-sm text-blue-600 hover:underline">
                                            Edit →
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div> --}}

                    </div>

                </div>
            </div>
        </div>

    </div>
@endsection
