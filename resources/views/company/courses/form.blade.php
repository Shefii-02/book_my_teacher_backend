@extends('layouts.layout')

@push('styles')
    <style>
        .form-container {
            margin: 0 auto;
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 24px;
        }
    </style>
@endpush

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
                aria-current="page">Course {{ isset($course) ? 'Edit' : 'Create' }}</li>
        </ol>
        <h6 class="mb-0 font-bold text-white capitalize">Course {{ isset($course) ? 'Edit' : 'Create' }}</h6>
    </nav>
@endsection

@section('content')
    <div class="container">
        <div class="card bg-white rounded-3 mb-3">
            <div class="card-title p-2 m-2">
                <h5 class="font-bold">{{ isset($course) ? 'Edit' : 'Create' }} a Course</h5>
            </div>
        </div>

        <div class="form-container">
            <form method="POST" enctype="multipart/form-data"
                action="{{ isset($course) ? route('admin.courses.update', $course->id) : route('admin.courses.store') }}">
                @csrf
                @if (isset($course))
                    @method('PUT')
                @endif

                <div class="mb-3">
                    <label class="form-label">Category</label>
                    <select name="category_id" class="form-control" required>
                        <option value="">-- Select Category --</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}"
                                {{ isset($course) && $course->category_id == $cat->id ? 'selected' : '' }}>
                                {{ $cat->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" value="{{ old('title', $course->title ?? '') }}"
                        class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description', $course->description ?? '') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Duration</label>
                    <div class="flex space-x-2">
                        <input type="number" name="duration" value="{{ old('duration', $course->duration ?? '') }}"
                            class="form-control" style="width: 100px;">
                        <select name="duration_type" class="form-control">
                            <option value="minutes"
                                {{ isset($course) && $course->duration_type == 'minutes' ? 'selected' : '' }}>Minutes
                            </option>
                            <option value="hours"
                                {{ isset($course) && $course->duration_type == 'hours' ? 'selected' : '' }}>Hours</option>
                            <option value="days"
                                {{ isset($course) && $course->duration_type == 'days' ? 'selected' : '' }}>Days</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Start Date</label>
                    <input type="datetime-local" name="stated_at" value="{{ old('stated_at', $course->stated_at ?? '') }}"
                        class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">End Date</label>
                    <input type="datetime-local" name="ended_at" value="{{ old('ended_at', $course->ended_at ?? '') }}"
                        class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Thumbnail</label>
                    <input type="file" name="thumbnail" class="form-control">
                    @if (isset($course) && $course->thumbnail)
                        <img src="{{ asset('storage/' . $course->thumbnail) }}" class="h-16 mt-2">
                    @endif
                </div>

                <button type="submit" class="btn btn-success">
                    {{ isset($course) ? 'Update' : 'Create' }}
                </button>
            </form>
        </div>
    </div>

@endsection
