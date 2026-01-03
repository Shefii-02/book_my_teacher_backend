@php
    $selectedTeachers = old(
        'teachers',
        isset($course) && $course->teachers ? $course->teachers?->pluck('id')->toArray() : [],
    );
@endphp


<form action="{{ route('company.courses.store') }}" method="POST" id="advancedSettingsForm" class="space-y-6">
    @csrf
    <div class="form-title">
        <h2 id="drawer-right-label"
            class="text-gray-400 rounded-lg text-lg text-sm absolute top-2.5  inline-flex items-center justify-center">
            <svg class="w-4 h-4 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            Advance Settings
        </h2>
    </div>
    <div class="form-body mt-3">
        <div class="grid md:grid-cols-2 gap-6">
            <input type="hidden" class="d-none" value="{{ $course->course_identity }}" name="course_identity" />

            {{-- Streaming Type (only if course_type = live or hybrid) --}}
            <div id="course_type_wrapper">
                <label for="course_type" class="block text-sm font-medium text-gray-700">Course Type</label>
                <select name="course_type" id="course_type"
                    class="border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option value="">-- Select Course Type --</option>
                    <option {{ $course && $course->course_type == 'individual' ? 'selected' : '' }} value="individual">
                        Individual</option>
                    <option {{ $course && $course->course_type == 'common' ? 'selected' : '' }} value="common">Common
                    </option>
                </select>
            </div>

            {{-- Level --}}
            <div id="course_type_wrapper">
                <label for="course_level" class="block text-sm font-medium text-gray-700">Course Level</label>
                <select name="course_level" id="course_level"
                    class="border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option value="">-- Select Course Level --</option>
                    <option {{ $course && $course->level == 'newbie' ? 'selected' : '' }} value="newbie">Newbie</option>
                    <option {{ $course && $course->level == 'beginner' ? 'selected' : '' }} value="beginner">Beginner
                    </option>
                    <option {{ $course && $course->level == 'intermediate' ? 'selected' : '' }} value="intermediate">
                        Intermediate</option>
                    <option {{ $course && $course->level == 'advanced' ? 'selected' : '' }} value="advanced"> Advanced
                    </option>
                    <option {{ $course && $course->level == 'beginner_to_advanced' ? 'selected' : '' }}
                        value="beginner_to_advanced">Beginner to Advanced</option>
                </select>
            </div>

            {{-- Video Type (only if class_mode = live or hybrid) --}}
            <div id="class_mode_wrapper">
                <label for="class_mode" class="block text-sm font-medium text-gray-700">Class Mode</label>
                <select name="class_mode" id="class_mode"
                    class="border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option value="">-- Select Class Mode --</option>
                    <option {{ $course && $course->class_mode == 'online' ? 'selected' : '' }} value="online">
                        Online</option>
                    <option {{ $course && $course->class_mode == 'offline' ? 'selected' : '' }} value="offline">
                        Offline</option>
                    <option {{ $course && $course->class_mode == 'hybrid' ? 'selected' : '' }} value="hybrid">
                        Hybrid</option>
                </select>
            </div>

            {{-- Class Type (only if class_type = live or hybrid) --}}
            <div id="class_type_wrapper">
                <label for="class_type" class="block text-sm font-medium text-gray-700">Class Type</label>
                <select name="class_type" id="class_type"
                    class="border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option value="">-- Select Class Type --</option>
                    <option {{ $course && $course->class_type == 'live classes' ? 'selected' : '' }}
                        value="live classes">
                        Live Classes</option>
                    <option {{ $course && $course->class_type == 'recorded classes' ? 'selected' : '' }}
                        value="recorded classes">
                        Recorded Classes</option>
                    <option {{ $course && $course->class_type == 'live and recorded classes' ? 'selected' : '' }}
                        value="live and recorded classes">Live and Recorded Classes</option>
                    <option {{ $course && $course->class_type == 'offline office' ? 'selected' : '' }}
                        value="offline office">Offline Office</option>
                    <option {{ $course && $course->class_type == 'offline home' ? 'selected' : '' }}
                        value="offline home">
                        Offline Home
                    </option>
                </select>
            </div>



            {{-- Has Material --}}
            <div>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" {{ $course && $course->has_material == 1 ? 'checked' : '' }}
                        type="checkbox" name="has_material" id="isMaterialCheckBox" checked>
                    <label class="form-check-label" for="isMaterialCheckBox">Has Material?</label>
                </div>
            </div>
            {{-- <div>
                <label class="block text-sm font-medium text-gray-700">Has Material?</label>
                <select name="has_material" id="has_material"
                    class="border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option {{ $course && $course->has_material == 0 ? 'selected' : '' }} value="0">No</option>
                    <option {{ $course && $course->has_material == 1 ? 'selected' : '' }} value="1">Yes</option>
                </select>
            </div> --}}

            {{-- Has Material Download (only if has_material = 1) --}}

            <div id="material_download_wrapper" class="hidden">
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input"
                        {{ $course && $course->has_material_download == 1 ? 'checked' : '' }} type="checkbox"
                        name="has_material_download" id="isMaterialDownloadCheckBox" checked>
                    <label class="form-check-label" for="isMaterialDownloadCheckBox">Allow Material Download?</label>
                </div>
            </div>

            {{-- <div >
                <label class="block text-sm font-medium text-gray-700">Allow Material Download?</label>
                <select name="has_material_download" id="has_material_download"
                    class="border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option {{ $course && $course->has_material_download == 0 ? 'selected' : '' }} value="0">No
                    </option>
                    <option {{ $course && $course->has_material_download == 1 ? 'selected' : '' }} value="1">Yes
                    </option>
                </select>
            </div> --}}

            {{-- Has Exam --}}
            <div>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" {{ $course && $course->has_exam == 1 ? 'checked' : '' }}
                        type="checkbox" name="has_exam" id="HasExamCheckBox" checked>
                    <label class="form-check-label" for="HasExamCheckBox">Has Exam?</label>
                </div>

                {{-- <label class="block text-sm font-medium text-gray-700"></label>
                <select name="has_exam" id="has_exam"
                    class="border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option {{ $course && $course->has_exam == 0 ? 'selected' : '' }} value="0">No</option>
                    <option {{ $course && $course->has_exam == 1 ? 'selected' : '' }} value="1">Yes</option>
                </select> --}}
            </div>

            {{-- Counselling --}}
            <div>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" {{ $course && $course->is_counselling == 1 ? 'checked' : '' }}
                        type="checkbox" name="is_counselling" id="HasCounsellingCheckBox" checked>
                    <label class="form-check-label" for="HasCounsellingCheckBox">Counselling Session Available?</label>
                </div>

                {{-- <label class="block text-sm font-medium text-gray-700">Counselling Session Available?</label>
                <select name="is_counselling" id="is_counselling"
                    class="border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option {{ $course && $course->is_counselling == 0 ? 'selected' : '' }} value="0">No</option>
                    <option {{ $course && $course->is_counselling == 1 ? 'selected' : '' }} value="1">Yes</option>
                </select> --}}
            </div>

            {{-- Career Guidance --}}
            <div>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" {{ $course && $course->is_career_guidance == 1 ? 'checked' : '' }}
                        type="checkbox" name="is_career_guidance" id="HasCareerCheckBox" checked>
                    <label class="form-check-label" for="HasCareerCheckBox">Career Guidance Included?</label>
                </div>

                {{-- <label class="block text-sm font-medium text-gray-700">Career Guidance Included?</label>
                <select name="is_career_guidance" id="is_career_guidance"
                    class="border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option {{ $course && $course->is_career_guidance == 0 ? 'selected' : '' }} value="0">No
                    </option>
                    <option {{ $course && $course->is_career_guidance == 1 ? 'selected' : '' }} value="1">Yes
                    </option>
                </select> --}}
            </div>
            {{-- Course Type --}}
        </div>

        @php
            $teacherIds = $course->teacherCourses->pluck('teacher_id')->first();
        @endphp

        <div class="grid md:grid-cols-2 gap-6 items-center">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 my-2">Teachers <span
                        class="text-red-500">*</span></label>
                <div class="pb-1">
                    <select name="teachers" class="form-control border w-full">
                        <option value="">Select Teacher</option>
                        @foreach ($teachers as $teacher)
                            <option value="{{ $teacher->id }}" @selected(old('teachers', $teacherIds ?? '') == $teacher->id)>
                                {{ $teacher->name }}
                            </option>
                        @endforeach
                    </select>

                </div>
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-6 items-center">
            <!-- Commission Based -->
            <div class="mb-4">
                <label class="flex items-center gap-1">
                    <input type="checkbox" class="border" id="is_commission" name="is_commission"
                        {{ old('is_commission', $course->commission_percentage ?? false) ? 'checked' : '' }}>
                    <span class="text-sm">Commission Based</span>
                </label>
            </div>

            <!-- Commission Percentage -->
            <div id="commission_box" class="mb-4 hidden">
                <label class="block mb-2 text-sm font-medium">Commission Percentage</label>
                <input type="number" name="commission_percentage"
                    value="{{ old('commission_percentage', $course->commission_percentage ?? '') }}"
                    class="w-full border rounded-lg p-2 text-sm">
            </div>

        </div>

        <div class="grid md:grid-cols-2 gap-6 items-center">
            <!-- Institute Based -->

            <div class="mb-4">
                <label class="flex items-center gap-1">
                    <input type="checkbox" class="border" id="is_institute" name="is_institute"
                        {{ old('is_institute', $course->institute_id ?? false) ? 'checked' : '' }}>
                    <span class="text-sm">Institute Based</span>
                </label>
            </div>

            <!-- Institute Dropdown -->
            <div id="institute_box" class="mb-4 hidden">
                <label class="block text-sm font-medium my-2">
                    Institute
                </label>
                <select id="select2-teachers" name="institute_id" class="form-control border w-full">
                    <option value="">Select one</option>
                    @foreach ($institutes ?? [] as $institute)
                        <option value="{{ $institute->user_id }}" @selected(old('institute_id', $course->institute_id ?? '') == $institute->user_id)>
                            {{ $institute->user->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-check form-switch mb-3">
            <input class="form-check-input" type="checkbox" name="is_public" {{ old('is_public', $course->is_public ?? false) ? 'checked' : '' }} id="isPublicCheckBox" >
            <label class="form-check-label" for="isPublicCheckBox">Show on Public</label>
        </div>

        <!-- Submit -->
        <div class="my-2 text-center md:col-span-2">
            <input type="submit"
                class="px-5 py-2.5 text-sm font-medium text-white bg-green-700 hover:bg-green-800 rounded-lg"
                name="advanced_form" value="{{ $course->step_completed >= 4 ? 'Update' : 'Create' }}">
        </div>
    </div>
</form>


{{-- @push('scripts') --}}

<link href="https://cdn.jsdelivr.net/npm/tom-select@2.4.3/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.4.3/dist/js/tom-select.complete.min.js"></script>
<script>
    $(document).ready(function() {
        new TomSelect("#select-tags", {
            plugins: ['remove_button'],
            create: true,
            onItemAdd: function() {
                this.setTextboxValue('');
                this.refreshOptions();
            },
            render: {
                option: function(data, escape) {
                    return `<div class="d-flex"><img src="` + escape(data.date) +
                        `" class="ms-auto text-muted"><span>` + escape(data.name) +
                        `</span></div>`;
                },
                item: function(data, escape) {
                    return '<div>' + escape(data.name) + '</div>';
                }
            }
        });
    });
</script>
{{-- @endpush --}}


<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {

        // function formatTeacher(option) {
        //     if (!option.id) return option.text;

        //     let img = $(option.element).data('img');
        //     return $(`
        //     <div class="flex items-center gap-2">
        //         <img src="${img}" class="teacher-img" />
        //         <span>${option.text}</span>
        //     </div>
        // `);
        // }

        // function formatSelected(option) {
        //     let img = $(option.element).data('img');
        //     return $(`
        //     <span class="flex items-center gap-1">
        //         <img src="${img}" class="teacher-img" />
        //         ${option.text}
        //     </span>
        // `);
        // }

        // $('#teachersSelect').select2({
        //     placeholder: "",
        //     allowClear: true,
        //     templateResult: formatTeacher,
        //     templateSelection: formatSelected,
        //     closeOnSelect: false,
        //     width: '100%'
        // });
    });

    $(document).ready(function() {

        // INITIAL LOAD — Show/hide based on existing values
        toggleCommission();
        toggleInstitute();

        // WHEN COMMISSION CHECKBOX CHANGES
        $("#is_commission").on("change", function() {
            toggleCommission();
        });

        // WHEN INSTITUTE CHECKBOX CHANGES
        $("#is_institute").on("change", function() {
            toggleInstitute();
        });

        function toggleCommission() {
            if ($("#is_commission").is(":checked")) {
                $("#commission_box").removeClass("hidden");
            } else {
                $("#commission_box").addClass("hidden");
            }
        }

        function toggleInstitute() {
            if ($("#is_institute").is(":checked")) {
                $("#institute_box").removeClass("hidden");
            } else {
                $("#institute_box").addClass("hidden");
            }
        }

        // SELECT2 INITIALIZE
        $('#select2-teachers').select2({
            placeholder: "Select institute teacher",
            allowClear: true,
            width: "100%"
        });

        $('.select2.select2-container').addClass('border p-1.5 rounded');


    });
</script>
