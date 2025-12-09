@extends('layouts.layout')

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
                aria-current="page">Categories List</li>
        </ol>
        <h6 class="mb-0 font-bold text-white capitalize">Categories List</h6>
    </nav>
@endsection

@section('content')
    <!-- cards -->
    <div class="w-full px-6 py-6 mx-auto">
        <div class="flex flex-wrap -mx-3 mt-4">
            <div class="flex-none w-full max-w-full px-3">
                <div
                    class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                    <div class="p-6 pb-2 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                        <div class="flex">
                            <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
                                <h6 class="dark:text-white">Categories List</h6>
                            </div>
                            <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">

                            </div>
                            <div class="w-full text-right max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-2/4">

                                {{-- <a href="{{ route('admin.courses.subcategories.index') }}"
                                    class="px-4 py-2 bg-gradient-to-tl from-emerald-500 to-teal-400  text-white rounded-full text-sm">Sub
                                    Category List</a> --}}
                                <a href="#"
                                    class="px-4 py-2 bg-gradient-to-tl from-emerald-500 to-teal-400  create-step text-white rounded text-sm">
                                    <i class="bi bi-plus me-2"></i> Create Category</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="relative flex flex-col min-w-0 my-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">

                    <div class="flex-auto px-4 py-4 min-h-75">
                        <div class="p-0 overflow-x-auto">
                            <div class="grid grid-cols-3 gap-4">
                                @forelse ($categories as $category)
                                    <div
                                        class="flex justify-between gap-4 p-4 bg-white rounded-lg shadow-sm border border-gray-200 dark:bg-gray-800">
                                        <div class="flex items-start ">

                                            <div class=" flex flex-col ">
                                                <!-- LEFT: THUMBNAIL -->
                                                <img src="{{ $category->thumbnail_url }}"
                                                    class="w-20 h-20 rounded-lg object-cover shadow-sm" alt="Thumbnail">

                                                <!-- Position -->
                                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                                                    <span class="font-semibold">Position:</span>
                                                    {{ $category->position }}
                                                </div>

                                                <!-- Published -->
                                                <div>
                                                    @if ($category->status)
                                                        <span class="px-2 py-1 text-xxs rounded bg-green-100 text-green-700">
                                                            Published
                                                        </span>
                                                    @else
                                                        <span class="px-2 py-1 text-xxs rounded bg-red-100 text-red-700">
                                                            Unpublished
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- RIGHT SECTION -->
                                            <div class="flex flex-col ms-4">

                                                <!-- Title -->
                                                <h2
                                                    class="text-lg font-semibold text-gray-900 dark:text-white p-0 m-0 mb-1">
                                                    {{ $category->title }}
                                                </h2>

                                                <!-- Description -->
                                                <p class="text-sm text-gray-600 dark:text-gray-300 p-0 m-0">
                                                    {{ Str::limit($category->description, 50) }}
                                                </p>

                                                <div class="flex flex-col gap-2 mt-1">

                                                    <!-- Created At -->
                                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                                        <span class="font-semibold">Created At:</span>
                                                        {{ $category->created_at->format('d M Y') }}
                                                    </div>

                                                    <!-- Created By -->
                                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                                        <span class="font-semibold">Created By:</span>
                                                        {{ $category->creator->name ?? 'N/A' }}
                                                    </div>



                                                </div>
                                            </div>



                                        </div>
                                        <div class="">
                                            <!-- ACTIONS -->
                                            <div class="relative">
                                                <button data-dropdown-toggle="dropdown_{{ $category->id }}">
                                                    <svg class="w-6 h-6 text-gray-700 dark:text-white" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                                            d="M12 6h.01M12 12h.01M12 18h.01" />
                                                    </svg>
                                                </button>


                                            </div>
                                            <!-- Dropdown -->
                                            <div id="dropdown_{{ $category->id }}"
                                                class="hidden absolute right-0 mt-0 w-20 bg-white rounded-lg shadow-md ">

                                                <a href="#" class="edit-step block px-4 py-2  text-xxs"
                                                    data-url="{{ route('admin.categories.edit', $category->id) }}">
                                                    Edit
                                                </a>

                                                <form
                                                    action="{{ route('admin.categories.destroy', $category->id) }}"
                                                    method="POST" id="form_{{ $category->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" onclick="confirmDelete({{ $category->id }})"
                                                        class="w-full text-left px-4 py-2 text-xxs">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-center text-gray-500 py-5">No categories found</p>
                                @endforelse
                            </div>

                        </div>
                    </div>
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

                $.get(`{{ route('admin.categories.create') }}`, function(html) {
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
