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
        $profInfo = $user->studentPersonalInfo;
        $grades = $user->studentGrades->pluck('grade')->toArray();
        $subjects = $user->recommendedSubjects->pluck('subject')->toArray();
        $preferred_days = $user->preferredDays->pluck('day')->toArray();
        $preferred_hours = $user->preferredHours->pluck('time_slot')->toArray();
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
                aria-current="page">Student {{ isset($user) ? 'Edit' : 'Create' }}</li>
        </ol>
        <h6 class="mb-0 font-bold text-white capitalize">Student {{ isset($user) ? 'Edit' : 'Create' }}</h6>
    </nav>
@endsection

@section('content')
    <div class="container">
        <div class="card bg-white rounded-3 mb-3">
            <div class="card-title p-2 m-2">
                <h5 class="font-bold">
                    {{ isset($user) ? 'Edit' : 'Create' }} a Student</h5>
            </div>
        </div>
        <div class="form-container relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">

            <!-- ✅ Form -->
            <form action="{{ isset($user) ? route('company.students.update', $user->id) : route('company.students.store') }}"
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
                            <input type="text" name="name" placeholder="" required
                                value="{{ old('name', $user->name ?? '') }}"
                                class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow">
                            @error('name')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Parent Name -->
                        <div>
                            <label class="block mb-2 text-sm font-medium">Parent Name</label>
                            <input type="text" name="parent_name" placeholder="" required
                                value="{{ old('parent_name', $user->studentPersonalInfo ? $user->studentPersonalInfo->parent_name : '' ?? '') }}"
                                class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow">
                            @error('parent_name')
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


                @php
                    $dataGrade = \App\Models\Grade::all();
                    $dataSubject = \App\Models\Subject::all();

                    $grades = old('leaning_grades', $grades ?? []);
                    $subjects = old('leaning_subjects', $subjects ?? []);
                @endphp

                <!-- Step 2: Professional Information -->
                {{-- <div class="form-step">
                    <h2 class="text-lg font-bold mb-4">Study Details</h2>

                    <!-- Mode of Interest -->
                    <div class="mb-4">
                        <p class="mb-2 text-sm font-medium">Mode of Learning Interest</p>
                        @php $mode = old('mode', $profInfo->study_mode ?? 'online') @endphp
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

                    <!-- Learning Grades -->
                    <div class="mb-4">
                        <p class="mb-2 text-sm font-medium">Preferable Learning Grades</p>
                        <div class="flex gap-2 flex-wrap">
                            @foreach ($dataGrade ?? [] as $gradeItem)
                                <label class="block mb-1">
                                    <input type="checkbox" name="preferable_grades[]" value="{{ $gradeItem['value'] }}"
                                        class="mr-2 w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:border-gray-600"
                                        {{ in_array($gradeItem['value'], $grades) ? 'checked' : '' }}>
                                    {{ $gradeItem['name'] }}
                                </label>
                            @endforeach
                        </div>
                    </div>



                    <!-- Learning Subjects -->
                    <div class="mb-4" x-data="{ otherSubject: '{{ old('other_subject', $profInfo->other_subject ?? '') }}' }">
                        <p class="mb-2 text-sm font-medium">Preferable Learning Subjects</p>
                        <div class="flex gap-2 flex-wrap">
                            @foreach ($dataSubject ?? [] as $subjectItem)
                                <label class="block mb-1">
                                    <input type="checkbox" name="preferable_subjects[]"
                                        value="{{ $subjectItem['value'] }}"
                                        class="mr-2 w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:border-gray-600"
                                        {{ in_array($subjectItem['value'], $subjects) ? 'checked' : '' }}>
                                    {{ $subjectItem['name'] }}
                                </label>
                            @endforeach
                        </div>
                        @php
                            if (isset($user)) {
                                $allSubjects = $dataSubject->pluck('value')->toArray(); // DB list
                                $selectedSubjects = $subjects; // user selected (from form)
                                $otherSubjects = implode(',',array_diff($selectedSubjects, $allSubjects) ?? []);

                            }
                            else{
                              $otherSubjects = '';
                            }
                        @endphp


                        <div class="mt-3">
                            <label class="block mb-2 text-sm font-medium">Other Subject</label>

                            <input type="text" name="other_subject"
                                placeholder="Other subject..."
                                class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow"
                                value="{{ old('other_subject', $otherSubjects ?? '') }}">
                        </div>
                    </div>

                    <!-- Working Days -->
                    <div class="mb-4">
                        <p class="mb-2 text-sm font-medium">Preferred Working Days</p>
                        @php $working_days = old('preferred_days', $preferred_days ?? []) @endphp
                        @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                            <label class="ml-4">
                                <input type="checkbox" name="preferred_days[]" value="{{ $day }}"
                                    class="mr-2 w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:border-gray-600"
                                    {{ in_array($day, $preferred_days) ? 'checked' : '' }}> {{ substr($day, 0, 3) }}
                            </label>
                        @endforeach
                    </div>
                    <!-- Working Hours -->
                    <div class="mb-4">
                        <p class="mb-2 text-sm font-medium">Preferred Working Hours</p>
                        @php $preferred_hours = old('preferred_hours', $preferred_hours ?? []) @endphp



                        @foreach ($timeSlot as $slot)
                            <label class="ml-4">
                                <input type="checkbox" name="preferred_hours[]" value="{{ $slot }}"
                                    class="mr-2 w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:border-gray-600"
                                    {{ in_array($slot, $preferred_hours) ? 'checked' : '' }}> {{ $slot }}
                            </label>
                        @endforeach
                    </div>
                </div> --}}

                <!-- Buttons -->
                <div class="button-group mt-4 flex justify-center">
                    <button type="submit"
                        class="px-5 py-2.5 text-sm font-medium text-white bg-green-700 hover:bg-green-800 rounded-lg">
                        {{ isset($user) ? 'Update' : 'Submit' }}
                    </button>
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
