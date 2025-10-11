@extends('layouts.layout')

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
                <a class="text-white " href="/">Home</a>
            </li>
            <li
                class="ltext-sm pl-2 capitalize text-neutral-900 text-white before:float-left before:pr-2 before:text-white before:content-['/']">
                <a class="text-white" href="{{ route('admin.dashboard') }}">Dashboard</a>
            </li>
            <li
                class="ltext-sm pl-2 capitalize text-neutral-900 text-white before:float-left before:pr-2 before:text-white before:content-['/']">
                <a class="text-white" href="{{ route('admin.teachers') }}">Teachers List</a>
            </li>
            <li class="text-sm pl-2  font-bold capitalize  text-white before:float-left before:pr-2 before:text-white before:content-['/']"
                aria-current="page">Teachers Create</li>
        </ol>
        <h6 class="mb-0 font-bold text-white capitalize">Teacher Create</h6>
    </nav>
@endsection

@section('content')
    <div class="container">
        <div class="card bg-white rounded-3 my-3">
            <div class="card-title p-3 my-3">
                <div class="flex justify-between">
                    <h5 class="font-bold">Create a Teacher</h5>
                    <a href="{{ route('admin.teachers') }}"
                        class="bg-emerald-500/50 rounded-1.8  text-white px-3 py-2">Back</a>
                </div>

            </div>
        </div>
        <div
            class="form-container relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">

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
                        <div>

                        </div>

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

                    @php
                        $dataGrade = \App\Models\Grade::all();
                        $dataSubject = \App\Models\Subject::all();

                        $grades = old('teaching_grades', $grades ?? []);
                        $subjects = old('teaching_subjects', $subjects ?? []);
                    @endphp

                    <!-- Teaching Grades -->
                    <div class="mb-4">
                        <p class="mb-2 text-sm font-medium">Teaching Grades</p>
                        <div class="flex gap-2 flex-wrap">
                            @foreach ($dataGrade as $gradeItem)
                                <label class="block mb-1">
                                    <input type="checkbox" name="teaching_grades[]" value="{{ $gradeItem['value'] }}"
                                        class="mr-2 w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:border-gray-600"
                                        {{ in_array($gradeItem['value'], $grades) ? 'checked' : '' }}>
                                    {{ $gradeItem['name'] }}
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Teaching Subjects -->
                    <div class="mb-4" x-data="{ otherSubject: '{{ old('other_subject', $profInfo->other_subject ?? '') }}' }">
                        <p class="mb-2 text-sm font-medium">Teaching Subjects</p>
                        <div class="flex gap-2 flex-wrap">
                            @foreach ($dataSubject as $subjectItem)
                                <label class="block mb-1">
                                    <input type="checkbox" name="teaching_subjects[]"
                                        value="{{ $subjectItem['value'] }}"
                                        class="mr-2 w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:border-gray-600"
                                        {{ in_array($subjectItem['value'], $subjects) ? 'checked' : '' }}>
                                    {{ $subjectItem['name'] }}
                                </label>
                            @endforeach
                        </div>
                        <div class="mt-3">
                            <label class="block mb-2 text-sm font-medium">Other Subject</label>

                            <input type="text" name="other_subject" x-model="otherSubject"
                                placeholder="Other subject..."
                                class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow"
                                value="{{ old('other_subject', $profInfo->other_subject ?? '') }}">
                        </div>

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
                        <label><input type="radio" name="profession" value="teacher" required
                                class="mr-2 w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:border-gray-600"
                                {{ $profession == 'teacher' ? 'checked' : '' }}> Teacher</label>
                        <label class="ml-4"><input type="radio" name="profession" required value="student"
                                class="mr-2 w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:border-gray-600"
                                {{ $profession == 'student' ? 'checked' : '' }}> Student</label>
                        <label class="ml-4"><input type="radio" name="profession" required value="jobseeker"
                                class="mr-2 w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:border-gray-600"
                                {{ $profession == 'jobseeker' ? 'checked' : '' }}> Seeking Job</label>
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
