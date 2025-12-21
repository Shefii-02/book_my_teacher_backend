@extends('layouts.mobile-layout')

@section('nav-options')
    <nav>
        <ol class="flex flex-wrap pt-1 mr-12 bg-transparent rounded-lg sm:mr-16">
            <li class="text-neutral-900 text-sm">
                <a class="text-white" href="javascript:;">Home</a>
            </li>
            <li class="text-sm pl-2 text-white before:float-left before:pr-2 before:text-white before:content-['/']">
                <a class="text-white" href="{{ route('company.app.subjects.index') }}">Subjects List</a>
            </li>
            <li
                class="text-sm pl-2 font-bold text-white before:float-left before:pr-2 before:text-white before:content-['/']">
                Subject {{ isset($banner) ? 'Edit' : 'Create' }}
            </li>
        </ol>
        <h6 class="mb-0 font-bold text-white capitalize">
            Subject {{ isset($banner) ? 'Edit' : 'Create' }}
        </h6>
    </nav>
@endsection

@section('content')
    <div class="container">
        <div class="card bg-white rounded-3 my-3">
            <div class="card-title p-3 my-3">
                <div class="flex justify-between">
                    <h6 class="font-bold">{{ isset($banner) ? 'Edit' : 'Create' }} Subject</h6>

                    <a href="{{ route('company.app.subjects.index') }}"
                        class="bg-emerald-500/50 rounded-full text-sm text-white px-4 fw-bold py-1">
                        <i class="bi bi-arrow-left me-1 "></i>
                        Back</a>
                </div>
            </div>
        </div>

        <div class="form-container bg-white shadow-xl rounded-2xl p-6">
            @php
                $isEdit = isset($subject);
                $iconPreview = $isEdit && $subject->icon_url ?  $subject->icon_url : null;
                $difficultyLevels = "'Easy', 'Medium', 'Hard'";
            @endphp
            <form
                action="{{ $isEdit ? route('company.app.subjects.update', $subject->id) : route('company.app.subjects.store') }}"
                method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @if ($isEdit)
                    @method('PUT')
                @endif
                <!-- ICON -->
                <div>
                    <label class="block font-semibold mb-1">Icon</label>
                    @if ($iconPreview)
                        <img src="{{ $iconPreview }}" class="w-16 h-16 rounded object-cover border mb-3">
                    @endif <input type="file" name="icon"
                        class="block w-full border rounded p-2"> @error('icon')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <!-- TITLE -->
                <div>
                    <label class="block font-semibold mb-1">Name</label> <input type="text" name="name"
                        value="{{ $isEdit ? $subject->name : old('name') }}" class="w-full border rounded p-2"
                        placeholder="Enter subject name"> @error('name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid md:grid-cols-3 gap-6">
                    <!-- COLOR CODE -->
                    <div>
                        <label class="block font-semibold mb-1">Color Code</label> <input type="color" name="color_code"
                            value="{{ $isEdit ? $subject->color_code : old('color_code') ?? '#2d6cdf' }}"
                            class="w-full h-10 border rounded cursor-pointer"> @error('color_code')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- DIFFICULTY LEVEL -->
                    <div>
                        <label class="block font-semibold mb-1">Difficulty Level</label>

                        <input type="text" name="difficulty_level"
                            value="{{ $isEdit ? $subject->difficulty_level : old('difficulty_level') }}"
                            class="w-full border rounded p-2" placeholder="{{ $difficultyLevels }}">
                        @error('difficulty_level')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror

                    </div>
                    <!-- POSITION -->
                    <div>
                        <label class="block font-semibold mb-1">Position</label> <input type="number" name="position"
                            value="{{ $isEdit ? $subject->position : old('position') }}" class="w-full border rounded p-2"
                            placeholder="Display order"> @error('position')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                </div>
                <!-- PUBLISHED TOGGLE -->

                <div>
                    <div class="flex items-center gap-3">
                        <label class="font-medium">
                            <input type="checkbox" class="border pe-3" name="published" value="1"
                                @checked(old('published', $subject->published ?? false))> Publish</label>
                    </div>
                </div>

                <!-- SAVE BUTTON -->
                <div class="flex justify-center">
                    <button type="submit"
                        class="bg-emerald-500/50 text-white px-6 py-2 rounded-lg">{{ $isEdit ? 'Update Subject' : 'Create Subject' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
