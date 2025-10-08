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

        <div
            class="form-container relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">


            <ol
                class="flex items-center w-full text-sm font-medium text-center text-gray-500 dark:text-gray-400 sm:text-base">
                <li
                    class="flex md:w-full items-center text-blue-600 dark:text-blue-500 sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 dark:after:border-gray-700">
                    <span
                        class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200 dark:after:text-gray-500">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                        </svg>
                        Personal <span class="hidden sm:inline-flex sm:ms-2">Info</span>
                    </span>
                </li>
                <li
                    class="flex md:w-full items-center after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 dark:after:border-gray-700">
                    <span
                        class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200 dark:after:text-gray-500">
                        <span class="me-2">2</span>
                        Account <span class="hidden sm:inline-flex sm:ms-2">Info</span>
                    </span>
                </li>
                 <li
                    class="flex md:w-full items-center after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 dark:after:border-gray-700">
                    <span
                        class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200 dark:after:text-gray-500">
                        <span class="me-2">2</span>
                        Account <span class="hidden sm:inline-flex sm:ms-2">Info2</span>
                    </span>
                </li>
                <li class="flex items-center">
                    <span class="me-2">3</span>
                    Confirmation
                </li>
            </ol>


            <ol
                class="flex items-center w-full mb-6 text-sm font-medium text-center text-gray-500 dark:text-gray-400 sm:text-base">
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
                    <button type="submit" id="submitStep"
                        class="hidden px-4 py-2 bg-green-600 text-white rounded">Submit</button>
                </div>
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
