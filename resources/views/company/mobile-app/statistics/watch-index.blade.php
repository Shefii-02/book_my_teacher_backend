@extends('layouts.mobile-layout')

@section('content')
    <div class="w-full px-6 py-6 mx-auto">
        <div class="relative flex flex-col min-w-0 mb-6 p-4 break-words bg-white shadow-xl rounded-2xl">
            <div class="flex justify-between">
                <div class="flex p-3">
                    {{-- confused --}}
                    @php
                        $tabs = ['pending', 'approved'];
                    @endphp

                    @foreach ($tabs as $tab)
                        <a href="{{ route('company.app.statistics-watch.index', ['status' => $tab]) }}"
                            class="px-4 py-2  text-sm font-semibold
           {{ $status == $tab ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                            {{ ucfirst($tab) }}
                        </a>
                    @endforeach

                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-1 xl:grid-cols-1 gap-6">

                @forelse($classes as $class)
                    <div class="bg-white shadow-lg rounded-2xl overflow-hidden hover:shadow-2xl transition duration-300">
                        <div class="flex gap-2 align-items-center2 p-3 relative">
                            {{-- Class Image --}}
                            <div class="relative">
                                <img src="{{ $class['image'] ?? asset('default.jpg') }}"
                                    class=" object-cover border rounded" style="min-height: 150px;max-height:150px">

                                <span class="absolute top-2 end-2 bg-blue-600 text-white text-xs px-3 py-1 rounded-full">
                                    {{ ucfirst($class['type']) }}
                                </span>
                            </div>

                            <div class="space-y-3 w-100 relative">
                                <div class=" grid grid-cols-1 md:grid-cols-2 xl:grid-cols-1">
                                    <div>
                                        {{-- Title --}}
                                        <div class="flex gap-2 text-sm">
                                            <span class="font-semibold text-gray-600">Class Title:</span>
                                            <h3 class="text-lg font-bold text-gray-800">
                                                {{ $class['title'] }}
                                            </h3>
                                        </div>

                                        {{-- Parent Title --}}

                                        <div class="flex gap-3 text-sm">
                                            <span class="font-semibold text-gray-600">{{ ucfirst($class['type']) }}
                                                Title:</span>
                                            <p class="text-sm text-gray-500">
                                                {{ $class['parent_title'] ?? '-' }}
                                            </p>
                                        </div>
                                        {{-- Class Mode --}}
                                        <div class="flex gap-3  text-sm">
                                            <span class="font-semibold text-gray-600">Class mode:</span>
                                            <span class="text-gray-800">
                                                {{ ucfirst($class['class_mode']) }}
                                            </span>
                                        </div>
                                        {{-- Source --}}
                                        <div class="flex gap-3  text-sm">
                                            <span class="font-semibold text-gray-600">Source:</span>
                                            <span class="text-gray-800">
                                                {{ ucfirst($class['source']) }}
                                            </span>
                                        </div>
                                        <div class="flex gap-2">
                                            {{-- Links --}}
                                            <div class="flex gap-3 items-baseline justify-between text-sm">
                                                <span class="font-semibold text-gray-600">Class Link:</span>
                                                <span class="text-gray-800">
                                                    <a href="{{ $class['class_link'] }}" target="_blank"
                                                        class="block text-center text-success text-sm py-2 rounded-lg ">
                                                        Open
                                                    </a>
                                                </span>
                                            </div>
                                            <div class="flex gap-3 items-baseline text-sm">
                                                <span class="font-semibold text-gray-600">Record Link:</span>
                                                <span class="text-gray-800">
                                                    <a href="{{ $class['recorded_link'] }}" target="_blank"
                                                        class="block text-center text-success text-sm py-2 rounded-lg ">
                                                        Open
                                                    </a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        {{-- Teacher --}}
                                        <div class="flex flex-col  space-x-3 pt-2 ">
                                            <div class="flex gap-2 align-items-center pb-2">
                                                <img src="{{ $class->teacher->avatar ?? asset('default-avatar.png') }}"
                                                    class="w-10 h-10 rounded-full object-cover">

                                                <div>
                                                    <p class="text-sm m-0 p-0 font-semibold text-gray-800">
                                                        Name : {{ $class->teacher->name ?? '-' }}
                                                    </p>
                                                    <p class="text-sm m-0 p-0 font-semibold text-gray-800">
                                                        Email : {{ $class->teacher->name ?? '-' }}
                                                    </p>
                                                    <p class="text-sm m-0 p-0 font-semibold text-gray-800">
                                                        Mobile : {{ $class->teacher->name ?? '-' }}
                                                    </p>
                                                </div>
                                            </div>

                                            {{-- Date & Time --}}
                                            <div class="text-sm text-gray-600 border-t pt-2">
                                                <div class="flex gap-2 text-sm">
                                                    <div>
                                                        <strong>Date:</strong>
                                                        {{ \Carbon\Carbon::parse($class['class_date'])->format('d M Y') }}
                                                    </div>
                                                    <div>
                                                        <strong>Time:</strong> {{ $class['started_at'] }} -
                                                        {{ $class['ended_at'] }}
                                                    </div>
                                                </div>
                                                {{-- Duration --}}
                                                <div class="flex gap-2 text-sm">
                                                    <span class="font-semibold text-gray-600">Spend Duration:</span>
                                                    <span class="text-gray-800">
                                                        {{ $class['spend_duration'] ?? 0 }} Mins
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <div class="absolute top-0 end-0 z-990">
                                @php
                                    $class_id = $class['id'];
                                    $class_type = $class['id'];
                                @endphp
                                <button
                                    onclick="document.getElementById('dropdown_{{ $class_id }}').classList.toggle('hidden')"
                                    class="p-2 bg-yellow-50  hover:bg-gray-100 dark:hover:bg-slate-700">
                                    <i class="bi bi-three-dots-vertical text-dark"></i>
                                </button>

                                <div id="dropdown_{{ $class_id }}"
                                    class="hidden absolute right-0 mt-2 w-28 bg-white dark:bg-slate-800 border dark:border-slate-700 rounded-lg shadow-lg text-sm">
                                    {{-- <a href="{{ route('company.courses.show', $class_id) }}"
                                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-slate-700">
                                    View
                                </a> --}}
                                    <a data-url="{{ route('company.app.statistics-watch.edit-with-type', ['statistics_watch' => $class_id, 'type' => $class['type']]) }}"
                                        href="#"
                                        class="open-drawer block px-4 py-2 hover:bg-gray-100 dark:hover:bg-slate-700">
                                        Edit
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>

                @empty
                    <div class="col-span-3 text-center text-gray-500">
                        No classes found.
                    </div>
                @endforelse

            </div>



        </div>
    @endsection
