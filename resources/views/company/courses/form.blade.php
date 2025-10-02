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
    <ol class="flex items-center w-full mb-6 text-sm font-medium text-center text-gray-500 dark:text-gray-400 sm:text-base">
        <li
            class="flex items-center text-blue-600 dark:text-blue-500 sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 sm:after:inline-block after:mx-6">
            <span class="flex items-center">1. Course Details</span>
        </li>
        <li
            class="flex items-center sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 sm:after:inline-block after:mx-6">
            <span class="flex items-center">2. Payments</span>
        </li>
        <li
            class="flex items-center sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 sm:after:inline-block after:mx-6">
            <span class="flex items-center">3. Advanced</span>
        </li>
        <li class="flex items-center">
            <span class="flex items-center">4. Overview</span>
        </li>
    </ol>

    <!-- Stepper Form -->
    <form id="courseStepperForm">
        <div id="step1" class="step">
            @include('company.courses.steps.basic')
        </div>
        <div id="step2" class="hidden step">
            @include('company.courses.steps.payments')
        </div>
        <div id="step3" class="hidden step">
            @include('company.courses.steps.advanced')
        </div>
        <div id="step4" class="hidden step">
            @include('company.courses.steps.overview')
        </div>

        <div class="flex justify-between mt-4">
            <button type="button" id="prevStep" class="px-4 py-2 bg-gray-500 text-white rounded">Previous</button>
            <button type="button" id="nextStep" class="px-4 py-2 bg-blue-600 text-white rounded">Next</button>
            <button type="submit" id="submitStep" class="hidden px-4 py-2 bg-green-600 text-white rounded">Submit</button>
        </div>
    </form>

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

@push('scripts')
    <script>
        let currentStep = {{ session('step', 1) }}; // get from backend validation redirect
        const totalSteps = 4;

        function showStep(step) {
            document.querySelectorAll('.step').forEach((s) => s.classList.add('hidden'));
            document.getElementById('step' + step).classList.remove('hidden');

            document.getElementById('prevStep').style.display = step === 1 ? 'none' : 'inline-block';
            document.getElementById('nextStep').style.display = step === totalSteps ? 'none' : 'inline-block';
            document.getElementById('submitStep').style.display = step === totalSteps ? 'inline-block' : 'none';
        }

        document.getElementById('prevStep').addEventListener('click', () => {
            if (currentStep > 1) {
                currentStep--;
                showStep(currentStep);
            }
        });
        document.getElementById('nextStep').addEventListener('click', () => {
            if (currentStep < totalSteps) {
                currentStep++;
                showStep(currentStep);
            }
        });

        // On load
        showStep(currentStep);
    </script>
@endpush
