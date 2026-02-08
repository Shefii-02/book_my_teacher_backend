@extends('layouts.mobile-layout')

@section('nav-options')
    <nav>
        <ol class="flex flex-wrap pt-1 mr-12 bg-transparent rounded-lg sm:mr-16">
            <li class="text-neutral-900 text-sm">
                <a class="text-white" href="javascript:;">Home</a>
            </li>
            <li class="text-sm pl-2 text-white before:float-left before:pr-2 before:text-white before:content-['/']">
                <a class="text-white" href="javascript:;">Dashboard</a>
            </li>
            <li class="text-sm pl-2 font-bold text-white capitalize before:float-left before:pr-2 before:text-white before:content-['/']"
                aria-current="page"> {{ isset($review) ? 'Edit Review' : 'Add Review' }}</li>
        </ol>
        <h6 class="mb-0 font-bold text-white capitalize"> {{ isset($review) ? 'Edit Review' : 'Add Review' }}</h6>
    </nav>
@endsection

@section('content')
    <div class="w-full px-6 py-6 mx-auto">

        <div class="flex flex-wrap -mx-3 mt-4">
            <div class="flex-none w-full max-w-full px-3">
                <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white shadow-xl rounded-2xl">

                    <div class="p-6 pb-2 mb-3 border-b border-transparent rounded-t-2xl">
                        <div class="flex justify-between">
                            <h6>{{ isset($review) ? 'Edit Review' : 'Add Review' }}</h6>
                            <a href="{{ route('company.app.reviews.index') }}"
                                class="bg-emerald-500/50 rounded-full text-sm text-white px-4 fw-bold py-1">
                                <i class="bi bi-arrow-left me-1 "></i>
                                Back
                            </a>
                        </div>
                    </div>
                </div>
                <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white shadow-xl rounded-2xl">

                    <div class="flex-auto p-5 overflow-x-auto">
                        <form method="POST"
                            action="{{ isset($review) ? route('company.app.reviews.update', $review->id) : route('company.app.reviews.store') }}">
                            @csrf
                            @if (isset($review))
                                @method('PUT')
                            @endif

                            <div class="grid grid-cols-2 gap-4 mb-4">

                                {{-- Student search (simple) --}}
                                <div class="mb-4">
                                    <label class="block text-sm font-medium">Student</label>
                                    <input type="text" id="studentSearch" value="{{ old('student_display') }}"
                                        placeholder="Search name/email/mobile" class="border p-2 rounded w-full"
                                        autocomplete="off">
                                    <input type="hidden" name="user_id" id="student_id" value="{{ old('student_id') }}">
                                    <div id="studentResults" class="hidden mt-1 bg-white border rounded overflow-auto"
                                        style="max-height:200px"></div>
                                    @error('student_id')
                                        <p class="text-red-600 text-sm">{{ $message }}</p>
                                    @enderror


                                    {{-- CUSTOMER DETAILS (AUTO-FILL OR MANUAL) --}}
                                    <div id="studentDetails" style="display: none">

                                    </div>
                                </div>
                                <!-- COURSES -->
                                <div>
                                    <label class="font-semibold">Course</label>
                                    <select name="subject_course_id" id="courseSelect"
                                        class="w-full border rounded px-3 py-2">
                                        <option value="">-- Select Course --</option>
                                    </select>
                                </div>



                                <!-- TEACHERS -->
                                <div>
                                    <label class="font-semibold">Teacher</label>
                                    <select name="teacher_id" id="teacherSelect" class="w-full border rounded px-3 py-2">
                                        <option value="">-- Select Teacher --</option>
                                    </select>
                                </div>

                                <!-- SUBJECT -->
                                <div>

                                    <label class="font-semibold">Subject (Optional)</label>
                                    <select name="subject_id" id="subjectSelect" class="w-full border rounded px-3 py-2">
                                        <option value="">-- Select Subject --</option>
                                    </select>
                                </div>

                                <!-- COMMENTS -->
                                <div class="col-span-2">
                                    <label class="font-semibold">Comments</label>
                                    <textarea name="comments" class="w-full border rounded px-3 py-2">{{ old('comments', $review->comments ?? '') }}</textarea>
                                </div>

                                <!-- RATING -->
                                <div>
                                    <label class="font-semibold">Rating</label>
                                    <input type="number" name="rating" min="1" max="5"
                                        value="{{ old('rating', $review->rating ?? '') }}"
                                        class="w-full border rounded px-3 py-2">
                                </div>

                            </div>

                            <button class="bg-blue-600 text-white px-6 py-2 rounded shadow hover:bg-blue-700">
                                {{ isset($review) ? 'Update' : 'Create' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {

            /* ---------- student inline search (no select2) ---------- */
            let timer = null;
            $('#studentSearch').on('keyup', function() {
                const q = $(this).val().trim();
                $('#studentDetails').hide();
                clearTimeout(timer);
                if (q.length < 1) {
                    $('#studentResults').addClass('hidden').html('');
                    $('#student_id').val('');
                    return;
                }
                timer = setTimeout(() => {
                    $.get('{{ route('company.admissions.student.search') }}', {
                        q
                    }, function(data) {
                        let html = '';
                        if (data.length === 0) html = '<div class="p-2">No results</div>';
                        data.forEach(u => {
                            html +=
                                `<div class="p-2 border-b cursor-pointer studentRow" data-id="${u.id}" data-name="${u.name}" data-email="${u.email}" data-mobile="${u.mobile}"><b>${u.name}</b><br><small>${u.email||''} ${u.mobile||''}</small></div>`;
                        });
                        $('#studentResults').removeClass('hidden').html(html);
                    }, 'json');
                }, 300);
            });

            $(document).on('click', '.studentRow', function() {
                $('#studentDetails').show();
                $('#studentSearch').val($(this).data('name'));
                $('#student_id').val($(this).data('id'));
                $('#studentResults').addClass('hidden');
                const name = $(this).data('name');
                const mobile = $(this).data('mobile') || '—';
                const email = $(this).data('email') || '—';
                const studentId = $(this).data('id');

                const details = `
                        <div class="p-4 mt-3 rounded-xl border bg-slate-50 shadow-sm">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="h-10 w-10 rounded-full bg-emerald-500/30 flex items-center justify-center text-white font-bold">
                                    ${name.charAt(0)}
                                </div>
                                <div>
                                    <p class="font-semibold text-slate-800 p-0 m-0">${name}</p>
                                    <p class="text-xs text-slate-500 p-0 m-0">Selected Student</p>
                                </div>
                            </div>

                            <div class="text-sm text-slate-700 space-y-1">
                                <p class="flex items-center gap-2 p-0 m-0">
                                    <i class="bi bi-telephone text-blue-500"></i>
                                    <span>${mobile}</span>
                                </p>
                                <p class="flex items-center gap-2 p-0 m-0">
                                    <i class="bi bi-envelope text-emerald-500"></i>
                                    <span>${email}</span>
                                </p>
                            </div>
                        </div>
                    `;

                $('#studentDetails').html(details);

                // 🔄 Load courses + review
                $.get(
                    '{{ route('company.app.reviews.student.details', '') }}/' + studentId,
                    function(res) {

                        /* ---------- courses ---------- */
                        let courseOptions = '<option value="">-- Select Course --</option>';
                        res.courses.forEach(c => {
                            courseOptions += `<option value="${c.id}">${c.name}</option>`;
                        });
                        $('#courseSelect').html(courseOptions);

                        /* ---------- review autofill ---------- */
                        if (res.review) {
                            $('#courseSelect').val(res.review.subject_course_id);
                            $('#teacherSelect').val(res.review.teacher_id);
                            $('#commentsBox').val(res.review.comments);
                            $('#ratingInput').val(res.review.rating);
                            $('input[name="subject"]').val(res.review.subject);
                        } else {
                            $('#commentsBox').val('');
                            $('#ratingInput').val('');
                            $('input[name="subject"]').val('');
                        }
                    }
                );
            });

            $('#courseSelect').on('change', function() {
                const courseId = $(this).val();
                if (!courseId) return;
                $.get(
                    '{{ route('company.app.reviews.course.details', '') }}/' + courseId,
                    function(teacher_courses) {
                        let html = '<option value="">-- Select Teacher --</option>';
                        teacher_courses.teachers.forEach(t => {
                            html += `<option value="${t.id}">${t.name}</option>`;
                        });

                        $('#teacherSelect').html(html);
                    });


                $.get(
                    `{{ route('company.app.reviews.course.subject.details', '') }}/${courseId}`,
                    function(response) {

                        let html = `<option value="">-- Select Subject --</option>`;

                        Object.values(response.subjects).forEach(s => {
                            html += `<option value="${s.id}">${s.title}</option>`;
                        });

                        $('#subjectSelect')
                            .html(html)
                            .prop('disabled', false);
                    }
                ).fail(function() {
                    $('#subjectSelect')
                        .html('<option value="">Failed to load subjects</option>')
                        .prop('disabled', true);
                });


            });

        });
    </script>
@endpush
