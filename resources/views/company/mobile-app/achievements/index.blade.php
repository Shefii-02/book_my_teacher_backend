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
                            <a href="{{ route('admin.app.achievements.create') }}"
                                class="bg-emerald-500/50 rounded-full text-sm text-white px-4 fw-bold py-1">
                                <i class="bi bi-plus me-1 "></i>
                                Create
                            </a>
                        </div>
                    </div>
                </div>
                <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white shadow-xl rounded-2xl">

                    <div class="flex-auto px-3 pt-3 pb-2 overflow-x-auto">



                        <div class="grid gap-4">
                            @forelse ($levels as $lvl)
                                <div class="bg-white p-4 rounded shadow flex justify-between items-center">
                                    <div>
                                        <h6 class="font-semibold">{{ ucfirst($lvl->role) }} - Level {{ $lvl->level_number }}
                                            : {{ $lvl->title }}</h6>
                                        <p class="text-sm text-gray-600">{{ $lvl->description }}</p>
                                    </div>
                                    <div class="flex gap-2">
                                        <a href="{{ route('admin.app.achievements.edit', $lvl->id) }}"
                                            class="px-2 py-1 bg-blue-500 text-white rounded">Edit</a>
                                        <a href="{{ route('admin.app.achievements.index', ['show' => $lvl->id]) }}"
                                            class="px-2 py-1 bg-gray-200 rounded">View Tasks</a>
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
