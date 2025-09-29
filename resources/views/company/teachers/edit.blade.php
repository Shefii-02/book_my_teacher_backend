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

@php
    if (isset($user)) {
        $profInfo = $user->professionalInfo;
        $grades = $user->teacherGrades->pluck('grade')->toArray();
        $subjects = $user->subjects->pluck('subject')->toArray();
        $working_days = $user->workingDays->pluck('day')->toArray();
        $working_hours = $user->workingHours->pluck('time_slot')->toArray();
    }

    $timeSlot = [
        '06.00-07.00 AM',
        '07.00-08.00 AM',
        '08.00-09.00 AM',
        '09.00-10.00 AM',
        '10.00-11.00 AM',
        '11.00-12.00 PM',
        '12.00-01.00 PM',
        '01.00-02.00 PM',
        '02.00-03.00 PM',
        '03.00-04.00 PM',
        '04.00-05.00 PM',
        '05.00-06.00 PM',
        '06.00-07.00 PM',
        '07.00-08.00 PM',
        '08.00-09.00 PM',
        '09.00-10.00 PM',
        '10.00-11.00 PM',
    ];
@endphp

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
                aria-current="page">Teachers Edit</li>
        </ol>
        <h6 class="mb-0 font-bold text-white capitalize">Teacher Edit</h6>
    </nav>
@endsection


@section('nav-options')
    <nav>
        <!-- breadcrumb -->
        <ol class="flex flex-wrap pt-1 mr-12 bg-transparent rounded-lg sm:mr-16">
            <li class="leading-normal text-sm">
                <a class="text-white opacity-50" href="javascript:;">Home</a>
            </li>
            <li class="text-sm pl-2 capitalize leading-normal text-white before:float-left before:pr-2 before:text-white before:content-['/']"
                aria-current="page">Dashboard</li>
        </ol>
        <h6 class="mb-0 font-bold text-white capitalize">Dashboard</h6>
    </nav>
@endsection

@section('content')
    <div class="container">
        <div class="card bg-white rounded-3 my-3">
            <div class="card-title p-3 my-3">
                <div class="flex justify-between">
                    <h5 class="font-bold">Edit a Teacher</h5>
                    <a href="{{ route('admin.teachers') }}"
                        class="bg-emerald-500/50 rounded-1.8  text-white px-3 py-2">Back</a>
                </div>

            </div>
        </div>
        <div class="form-container">

            <!-- ✅ Form -->
            <form action="{{ isset($user) ? route('admin.teachers.update', $user->id) : route('admin.teachers.store') }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                @if (isset($user))
                    @method('PUT')
                @endif


                <!-- Step 1: Personal Information -->
                <div class="form-step active">
                    <h2 class="text-lg font-bold mb-4">Personal Information</h2>

                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <!-- Avatar -->
                        <div class="flex justify-center flex-col">

                            <p>
                                <img id="imgPreview" src="{{ old('avatar', $user->avatar_url ?? '') }}"
                                    class="rounded-circle w-16 h-16 ms-5">
                            </p>
                            <label for="imgSelect" class="mb-2">Select an Avatar</label>
                            <input type="file" id="imgSelect" name="avatar" accept="image/*"
                                {{ isset($user) ? '' : 'required' }} ?>
                            @error('avatar')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div></div>

                        <!-- Full Name -->
                        <div>
                            <label class="block mb-2 text-sm font-medium">Full Name</label>
                            <input type="text" name="name" placeholder="John Doe" required
                                value="{{ old('name', $user->name ?? '') }}"
                                class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow">
                            @error('name')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block mb-2 text-sm font-medium">Email</label>
                            <input type="email" name="email" placeholder="john@example.com" required
                                value="{{ old('email', $user->email ?? '') }}"
                                class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow">
                            @error('email')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div>
                            <label class="block mb-2 text-sm font-medium">Phone</label>
                            <input type="tel" name="phone" placeholder="9876543210" required
                                value="{{ old('phone', $user->mobile ?? '') }}"
                                class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow">
                            @error('phone')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div>
                            <label class="block mb-2 text-sm font-medium">Address</label>
                            <input type="text" name="address" placeholder="Street, Area" required
                                value="{{ old('address', $user->address ?? '') }}"
                                class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow">
                        </div>

                        <!-- City -->
                        <div>
                            <label class="block mb-2 text-sm font-medium">City</label>
                            <input type="text" name="city" placeholder="City" required
                                value="{{ old('city', $user->city ?? '') }}"
                                class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow">
                        </div>

                        <!-- Postal Code -->
                        <div>
                            <label class="block mb-2 text-sm font-medium">Postal Code</label>
                            <input type="text" name="postal_code" placeholder="123456" required
                                value="{{ old('postal_code', $user->postal_code ?? '') }}"
                                class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow">
                        </div>

                        <!-- District -->
                        <div>
                            <label class="block mb-2 text-sm font-medium">District</label>
                            <input type="text" name="district" value="{{ old('district', $user->district ?? '') }}"
                                required
                                class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow">
                        </div>

                        <!-- State -->
                        <div>
                            <label class="block mb-2 text-sm font-medium">State</label>
                            <input type="text" name="state" value="{{ old('state', $user->state ?? '') }}" required
                                class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow">
                        </div>

                        <!-- Country -->
                        <div>
                            <label class="block mb-2 text-sm font-medium">Country</label>
                            <input type="text" name="country" value="{{ old('country', $user->country ?? '') }}"
                                required
                                class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow">
                        </div>
                    </div>
                </div>

                <!-- Step 2: Professional Information -->
                <div class="form-step">
                    <h2 class="text-lg font-bold mb-4">Professional Information</h2>

                    <!-- Mode of Interest -->
                    <div class="mb-4">
                        <p class="mb-2 text-sm font-medium">Mode of Interest</p>
                        @php $mode = old('mode', $profInfo->teaching_mode ?? 'online') @endphp
                        <label><input type="radio" name="mode" value="online" required
                                class="mr-2 w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:border-gray-600"
                                {{ $mode == 'online' ? 'checked' : '' }}> Online</label>
                        <label class="ml-4"><input type="radio" name="mode" required value="offline"
                                class="mr-2 w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:border-gray-600"
                                {{ $mode == 'offline' ? 'checked' : '' }}> Offline</label>
                        <label class="ml-4"><input type="radio" name="mode" required value="both"
                                class="mr-2 w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:border-gray-600"
                                {{ $mode == 'both' ? 'checked' : '' }}> Both</label>
                    </div>

                    <!-- Teaching Grades -->
                    <div class="mb-4">
                        <p class="mb-2 text-sm font-medium">Teaching Grades</p>
                        @php $grades = old('teaching_grades', $grades ?? []) @endphp

                        <label><input type="checkbox" name="teaching_grades[]" value="Lower Primary"
                                class="mr-2 w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:border-gray-600"
                                {{ in_array('Lower Primary', $grades) ? 'checked' : '' }}> Lower Primary</label>
                        <label class="ml-4"><input type="checkbox" name="teaching_grades[]" value="Upto 10th"
                                class="mr-2 w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:border-gray-600"
                                {{ in_array('Upto 10th', $grades) ? 'checked' : '' }}> Upto 10th</label>
                        <label class="ml-4"><input type="checkbox" name="teaching_grades[]" value="Higher Secondary"
                                class="mr-2 w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:border-gray-600"
                                {{ in_array('Higher Secondary', $grades) ? 'checked' : '' }}> Higher Secondary</label>
                    </div>

                    <!-- Teaching Subjects -->
                    <div class="mb-4">
                        <p class="mb-2 text-sm font-medium">Teaching Subjects</p>
                        @php $subjects = old('teaching_subjects', $subjects ?? []) @endphp
                        <label><input type="checkbox" name="teaching_subjects[]" value="All Subjects"
                                class="mr-2 w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:border-gray-600"
                                {{ in_array('all subjects', $subjects) ? 'checked' : '' }}> All Subjects</label>
                        <label class="ml-4"><input type="checkbox" name="teaching_subjects[]" value="Mathematics"
                                class="mr-2 w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:border-gray-600"
                                {{ in_array('mathematics', $subjects) ? 'checked' : '' }}> Mathematics</label>
                        <label class="ml-4"><input type="checkbox" name="teaching_subjects[]" value="Science"
                                class="mr-2 w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:border-gray-600"
                                {{ in_array('science', $subjects) ? 'checked' : '' }}> Science</label>
                        <input type="text" name="other_subject" placeholder="Other subject..."
                            value="{{ old('other_subject', $profInfo->other_subject ?? '') }}"
                            class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow mt-4">
                    </div>

                    <!-- Experience -->
                    <div class="grid gap-6 mb-6 md:grid-cols-3">
                        <div>
                            <label class="block mb-2 text-sm font-medium">Years of Exp. (Offline)</label>
                            <input type="number" name="offline_exp"
                                value="{{ old('offline_exp', $profInfo->offline_exp ?? '0') }}" required
                                class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow">
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium">Years of Exp. (Online)</label>
                            <input type="number" name="online_exp"
                                value="{{ old('online_exp', $profInfo->online_exp ?? '0') }}" required
                                class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow">
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium">Years of Exp. (Home Tuition)</label>
                            <input type="number" name="home_exp"
                                value="{{ old('home_exp', $profInfo->home_exp ?? '0') }}" required
                                class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow">
                        </div>
                    </div>

                    <!-- Profession -->
                    <div class="mb-4">
                        <p class="mb-2 text-sm font-medium">Currently Working As</p>
                        @php $profession = old('profession', $profInfo->profession ?? '') @endphp
                        <label><input type="radio" name="profession" value="Teacher" required
                                class="mr-2 w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:border-gray-600"
                                {{ $profession == 'Teacher' ? 'checked' : '' }}> Teacher</label>
                        <label class="ml-4"><input type="radio" name="profession" required value="Student"
                                class="mr-2 w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:border-gray-600"
                                {{ $profession == 'Student' ? 'checked' : '' }}> Student</label>
                        <label class="ml-4"><input type="radio" name="profession" required value="Jobseeker"
                                class="mr-2 w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:border-gray-600"
                                {{ $profession == 'Jobseeker' ? 'checked' : '' }}> Seeking Job</label>
                    </div>

                    <!-- Ready to Work -->
                    <div class="mb-4">
                        <p class="mb-2 text-sm font-medium">Ready to Work</p>
                        @php $ready = old('ready_to_work', $profInfo->ready_to_work ?? '') @endphp
                        <label><input type="radio" name="ready_to_work" value="Yes" required
                                class="mr-2 w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:border-gray-600"
                                {{ $ready == 'Yes' ? 'checked' : '' }}> Yes</label>
                        <label class="ml-4"><input type="radio" name="ready_to_work" required value="No"
                                class="mr-2 w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:border-gray-600"
                                {{ $ready == 'No' ? 'checked' : '' }}> No</label>
                    </div>

                    <!-- Working Days -->
                    <div class="mb-4">
                        <p class="mb-2 text-sm font-medium">Preferred Working Days</p>
                        @php $working_days = old('working_days', $working_days ?? []) @endphp
                        @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                            <label class="ml-4">
                                <input type="checkbox" name="working_days[]" value="{{ $day }}"
                                    class="mr-2 w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:border-gray-600"
                                    {{ in_array($day, $working_days) ? 'checked' : '' }}> {{ substr($day, 0, 3) }}
                            </label>
                        @endforeach
                    </div>

                    <!-- Working Hours -->
                    <div class="mb-4">
                        <p class="mb-2 text-sm font-medium">Preferred Working Hours</p>
                        @php $working_hours = old('working_hours', $working_hours ?? []) @endphp
                        @foreach ($timeSlot as $slot)
                            <label class="ml-4">
                                <input type="checkbox" name="working_hours[]" value="{{ $slot }}"
                                    class="mr-2 w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:border-gray-600"
                                    {{ in_array($slot, $working_hours) ? 'checked' : '' }}> {{ $slot }}
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Step 3: CV Upload -->
                <div class="form-step">
                    <h2 class="text-lg font-bold mb-4">Upload CV</h2>
                    <a class="text-red-500 mb-2 text-sm" target="_blank"
                        href="{{ old('avatar', $user->cv_url ?? '') }}">
                        <p>Existing CV</p>
                    </a>
                    <input type="file" name="cv_file" {{ isset($user) ? '' : 'required' }}
                        class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow">
                    @error('cv_file')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                    {{-- <!-- Account Status -->
                    <div class="mb-4 mt-4">
                        <p class="mb-2 text-sm font-medium">Account Status</p>
                        <strong class="capitalize text-blue-800 text-lg fw-bold">{{ $user->current_account_stage  }}</strong>
                        <br>
                        @php $account_status = old('account_status', $user->account_status ?? '') @endphp
                        <label><input type="radio" name="account_status" value="in progress" required
                                class="mr-2 w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:border-gray-600"
                                {{ $account_status == 'in progress' ? 'checked' : '' }}> In Progress</label>
                        <label class="ml-4"><input type="radio" name="account_status" required
                                value="completed"
                                class="mr-2 w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:border-gray-600"
                                {{ $account_status == 'completed' ? 'checked' : '' }}>Completed</label>

                        <label class="ml-4"><input type="radio" name="account_status" required value="rejected"
                                class="mr-2 w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:border-gray-600"
                                {{ $account_status == 'rejected' ? 'checked' : '' }}>Rejected</label>

                        <label class="ml-4"><input type="radio" name="account_status" required value="scheduled"
                                class="mr-2 w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:border-gray-600"
                                {{ $account_status == 'scheduled' ? 'checked' : '' }}>Scheduled</label>
                    </div> --}}
                    <!-- Account Status -->
                    @php $account_status = old('account_status', $user->account_status ?? '') @endphp

                    <div class="mb-4 mt-4" x-data="{ status: '{{ $account_status }}' }">
                        <p class="mb-2 text-sm font-medium">Account Status</p>
                        <strong
                            class="capitalize text-blue-800 text-lg fw-bold mb-5">{{ $user->current_account_stage }}</strong>
                        <br>
                        @if ($current_account_stage == 'account verified')
                        @else
                            <label class="mt-3">
                                <input type="radio" name="account_status" value="in progress" required
                                    x-model="status"
                                    class="mr-2 w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500"
                                    {{ $account_status == 'in progress' ? 'checked' : '' }}> In Progress
                            </label>

                            <label class="ml-4">
                                <input type="radio" name="account_status" value="completed" required x-model="status"
                                    class="mr-2 w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500"
                                    {{ $account_status == 'completed' ? 'checked' : '' }}> Completed
                            </label>

                            <label class="ml-4">
                                <input type="radio" name="account_status" value="rejected" required x-model="status"
                                    class="mr-2 w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500"
                                    {{ $account_status == 'rejected' ? 'checked' : '' }}> Rejected
                            </label>
                            @if ($user->current_account_stage == 'schedule interview')
                                <label class="ml-4">
                                    <input type="radio" name="account_status" value="scheduled" required
                                        x-model="status"
                                        class="mr-2 w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500"
                                        {{ $account_status == 'scheduled' ? 'checked' : '' }}> Scheduled
                                </label>
                            @endif
                        @endif
                        <!-- Extra fields for Scheduled -->
                        <div class="mt-4 space-y-3" x-show="status === 'scheduled'" x-cloak>
                            <!-- Interview DateTime -->
                            <label class="block">
                                <span class="text-sm font-medium">Interview Date & Time</span>
                                <input type="datetime-local" name="interview_at"
                                    value="{{ old('interview_at', $user->interview_at ?? '') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </label>


                        </div>
                    </div>

                    <!-- Notes -->
                    <label class="block mt-3">
                        <span class="text-sm font-medium">Account Notes (Followup Information)</span>
                        <textarea name="acccount_notes" rows="3" placeholder="Please note rejection reason or followup information..."
                            class="mt-4 block w-full  rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('acccount_notes', $user->notes ?? '') }}</textarea>
                    </label>

                    <!-- Buttons -->
                    <div class="button-group mt-4 flex justify-center">
                        <button type="submit"
                            class="px-5 py-2.5 text-sm font-medium text-white bg-green-700 hover:bg-green-800 rounded-lg">
                            {{ isset($user) ? 'Update' : 'Submit' }}
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $("#imgSelect").change(function() {
                if (this.files && this.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#imgPreview').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            });
        });
    </script>
@endpush
