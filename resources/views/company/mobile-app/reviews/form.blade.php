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
                            <a href="{{ route('admin.app.reviews.index') }}"
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
                            action="{{ isset($review) ? route('admin.app.reviews.update', $review->id) : route('admin.app.reviews.store') }}">
                            @csrf
                            @if (isset($review))
                                @method('PUT')
                            @endif

                            <div class="grid grid-cols-2 gap-4 mb-4">

                                <!-- USER SEARCH -->
                                <div class="col-span-2">
                                    <label class="font-semibold">User</label>
                                    <input type="text" x-model="searchUser" @input.debounce.500="searchUsers"
                                        placeholder="Type user name or email..." class="w-full border rounded px-3 py-2">

                                    <template x-if="users.length">
                                        <ul class="border rounded mt-1 bg-white max-h-40 overflow-y-auto shadow">
                                            <template x-for="user in users" :key="user.id">
                                                <li class="px-3 py-1 hover:bg-gray-100 cursor-pointer"
                                                    @click="selectUser(user)">
                                                    <span x-text="user.name"></span> - <span x-text="user.email"></span>
                                                </li>
                                            </template>
                                        </ul>
                                    </template>
                                </div>

                                <!-- COURSES -->
                                <div>
                                    <label class="font-semibold">Course</label>
                                    <select name="subject_course_id" x-model="selectedCourse"
                                        @change="loadSubjectsAndTeachers" class="w-full border rounded px-3 py-2">
                                        <option value="">-- Select Course --</option>
                                        <template x-for="course in courses" :key="course.id">
                                            <option :value="course.id" x-text="course.title"></option>
                                        </template>
                                    </select>
                                </div>

                                <!-- SUBJECT -->
                                <div>
                                    <label class="font-semibold">Subject (Optional)</label>
                                    <select name="subject_id" x-model="selectedSubject"
                                        class="w-full border rounded px-3 py-2">
                                        <option value="">-- Select Subject --</option>
                                        <template x-for="subject in subjects" :key="subject.id">
                                            <option :value="subject.id" x-text="subject.name"></option>
                                        </template>
                                    </select>
                                </div>

                                <!-- TEACHERS -->
                                <div>
                                    <label class="font-semibold">Teacher</label>
                                    <select name="teacher_id" x-model="selectedTeacher"
                                        class="w-full border rounded px-3 py-2">
                                        <option value="">-- Select Teacher --</option>
                                        <template x-for="teacher in teachers" :key="teacher.id">
                                            <option :value="teacher.id" x-text="teacher.name"></option>
                                        </template>
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

    <script>
        function reviewForm() {
            return {
                searchUser: '',
                users: [],
                selectedUser: null,
                courses: [],
                selectedCourse: '{{ $review->subject_course_id ?? '' }}',
                subjects: [],
                selectedSubject: '{{ $review->subject_id ?? '' }}',
                teachers: [],
                selectedTeacher: '{{ $review->teacher_id ?? '' }}',

                searchUsers() {
                    if (this.searchUser.length < 2) {
                        this.users = [];
                        return;
                    }
                    fetch(`/admin/ajax/users/search?key=${this.searchUser}`)
                        .then(res => res.json())
                        .then(data => {
                            this.users = data;
                        });
                },

                selectUser(user) {
                    this.selectedUser = user;
                    this.searchUser = user.name;
                    this.users = [];

                    // Load user's enrolled courses
                    fetch(`/admin/users/${user.id}/courses`)
                        .then(res => res.json())
                        .then(data => {
                            this.courses = data;
                        });
                },

                loadSubjectsAndTeachers() {
                    if (!this.selectedCourse) {
                        this.subjects = [];
                        this.teachers = [];
                        return;
                    }

                    fetch(`/admin/courses/${this.selectedCourse}/subjects`)
                        .then(res => res.json())
                        .then(data => {
                            this.subjects = data;
                        });

                    fetch(`/admin/courses/${this.selectedCourse}/teachers`)
                        .then(res => res.json())
                        .then(data => {
                            this.teachers = data;
                        });
                }
            }
        }
    </script>
@endsection
