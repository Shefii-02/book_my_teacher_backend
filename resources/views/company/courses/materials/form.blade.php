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
                <a class="text-white" href="{{ route('admin.dashboard') }}">Dashboard</a>
            </li>
            <li class="text-sm pl-2  font-bold capitalize  text-white before:float-left before:pr-2 before:text-white before:content-['/']"
                aria-current="page"> {{ isset($class) ? 'Edit Course Class' : 'Create Course Class' }}</li>
        </ol>
        <h6 class="mb-0 font-bold text-white capitalize">{{ isset($class) ? 'Edit Course Class' : 'Create Course Class' }}
        </h6>
    </nav>
@endsection

@php
    $isEdit = isset($material);
@endphp
@section('content')
    <div class="container mx-auto">
        <div
            class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
            <div class="p-4 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                <div class="flex">
                    <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
                        <h6 class="dark:text-white">{{ isset($class) ? 'Edit Class' : 'Create Class' }}</h6>
                    </div>
                    <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">

                    </div>
                    <div class="w-full text-right max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-2/4 mb-3">
                        <a href="{{ route('admin.courses.schedule-class.index', $course->course_identity) }}"
                            class="px-4 py-2 bg-gradient-to-tl from-emerald-500 to-teal-400  text-white rounded-full text-sm"><i
                                class="bi bi-arrow-left me-2"></i>Back</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow mx-3 mt-4">
            <div class="flex-none w-full max-w-full px-3">
                <div class="relative flex flex-col min-w-0 mb-6 break-words">
                    <form method="POST" enctype="multipart/form-data"
                        action="{{ $isEdit
                            ? route('admin.courses.materials.update', [$course->course_identity, $material->id])
                            : route('admin.courses.materials.store', $course->course_identity) }}">

                        @csrf
                        @if ($isEdit)
                            @method('PUT')
                        @endif

                        {{-- Title --}}
                        <label class="block mb-2 font-medium">Title</label>
                        <input type="text" name="title" value="{{ old('title', $material->title ?? '') }}"
                            class="w-full border p-2 rounded" required />

                        {{-- File --}}
                        <label class="block mt-4 mb-2 font-medium">
                            Upload File @if ($isEdit)
                                <small class="text-gray-500">(Optional)</small>
                            @endif
                        </label>

                        <input type="file" name="file" class="w-full border p-2 rounded"
                            @if (!$isEdit) required @endif />

                        @if ($isEdit && $material->file_path)
                            <p class="text-sm mt-1">
                                Current: <a href="{{ asset('storage/' . $material->file_path) }}" target="_blank"
                                    class="text-blue-500 underline">View File</a>
                            </p>
                        @endif

                        {{-- Position --}}
                        <label class="block mt-4 mb-2 font-medium">Position</label>
                        <input type="number" name="position" value="{{ old('position', $material->position ?? 1) }}"
                            class="w-full border p-2 rounded" required />

                        {{-- Status --}}
                        <label class="block mt-4 mb-2 font-medium">Status</label>
                        <select name="status" class="w-full border p-2 rounded">
                            <option value="published" @selected(old('status', $material->status ?? '') === 'published')>
                                Published
                            </option>

                            <option value="draft" @selected(old('status', $material->status ?? '') === 'draft')>
                                Draft
                            </option>
                        </select>

                        {{-- Submit --}}
                        <button class="mt-6 px-4 py-2 bg-blue-600 text-white rounded">
                            {{ $isEdit ? 'Update Material' : 'Create Material' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
