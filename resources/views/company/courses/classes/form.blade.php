@extends('layouts.layout')

@section('content')
    <div class="max-w-3xl mx-auto bg-white p-6 rounded-xl shadow" x-data="{ type: '{{ old('type', $class->type ?? 'online') }}' }">

        <h2 class="text-xl font-semibold mb-5">
            {{ isset($class) ? 'Edit Class' : 'Create Class' }}
        </h2>

        <form method="POST"
            action="{{ isset($class)
                ? route('admin.courses.schedule-class.update', [
                    'identity' => $course->course_identity,
                    'schedule_class' => $class->id,
                ])
                : route('admin.courses.schedule-class.store', [
                    'identity' => $course->course_identity,
                ]) }}">

            @csrf
            @if (isset($class))
                @method('PUT')
            @endif

            {{-- TOP FIELDS --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">

                <div>
                    <label class="font-medium">Class Title</label>
                    <input type="text" name="title" value="{{ old('title', $class->title ?? '') }}"
                        class="w-full border rounded p-2">
                </div>

                <div>
                    <label class="font-medium">Class Type</label>
                    <select name="type" x-model="type" class="w-full border rounded p-2">
                        <option value="online">Online</option>
                        <option value="offline">Offline</option>
                        <option value="recorded">Recorded</option>
                    </select>
                </div>

            </div>

            {{-- DESCRIPTION --}}
            <div class="mb-4">
                <label class="font-medium">Description</label>
                <textarea name="description" class="w-full border rounded p-2">{{ old('description', $class->description ?? '') }}
            </textarea>
            </div>

            {{-- DATE & TIME --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">

                <div>
                    <label class="font-medium">Class Date</label>
                    <input type="date" name="scheduled_at"
                        value="{{ old('scheduled_at', date('Y-m-d', strtotime($class->scheduled_at)) ?? '') }}"
                        class="w-full border rounded p-2" required>
                </div>

                <div class="grid grid-cols-2 gap-4">

                    <div>
                        <label class="font-medium">Start Time</label>
                        <input type="time" name="start_time" value="{{ old('start_time', $class->start_time ?? '') }}"
                            class="w-full border rounded p-2" required>
                    </div>

                    <div>
                        <label class="font-medium">End Time</label>
                        <input type="time" name="end_time" value="{{ old('end_time', $class->end_time ?? '') }}"
                            class="w-full border rounded p-2" required>
                    </div>

                </div>

            </div>

            {{-- ONLINE SECTION --}}
            <div x-show="type === 'online'">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">

                    <div>
                        <label class="font-medium">Class Mode</label>
                        <select name="class_mode" class="w-full border rounded p-2">
                            <option value="gmeet"
                                {{ old('class_mode', $class->class_mode ?? '') == 'gmeet' ? 'selected' : '' }}>
                                Google Meet</option>
                            <option value="youtube"
                                {{ old('class_mode', $class->class_mode ?? '') == 'youtube' ? 'selected' : '' }}>YouTube
                            </option>
                        </select>
                    </div>

                    <div>
                        <label class="font-medium">Class Link</label>
                        <input type="text" name="meeting_link"
                            value="{{ old('meeting_link', $class->meeting_link ?? '') }}"
                            class="w-full border rounded p-2">
                    </div>

                </div>

            </div>

            {{-- RECORDED SECTION --}}
            <div x-show="type === 'recorded' || type === 'online'">
                <div class="mb-4">
                    <label class="font-medium">Recording URL</label>
                    <input type="text" name="recording_url"
                        value="{{ old('recording_url', $class->recording_url ?? '') }}" class="w-full border rounded p-2">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <!-- Teacher -->
                <div class="mb-4"> <label class="block mb-1 font-medium text-gray-700">Teacher</label>
                   <select
                        name="teacher_id"
                        class="block w-full rounded-lg border border-gray-300 p-2.5 focus:ring-blue-500 focus:border-blue-500"
                        required>
                        <option value="">-- Select Teacher --</option>
                        @foreach ($teachers as $teacher)
                            <option value="{{ $teacher->id }}"
                                {{ old('teacher_id', $class->teacher_id ?? '') == $teacher->id ? 'selected' : '' }}>
                                {{ $teacher->name }} </option>
                        @endforeach
                    </select> </div>
                {{-- PRIORITY --}}
                <div class="mb-4 w-50">
                    <label class="font-medium mb-1">Priority</label>
                    <select name="priority" class="block w-full rounded-lg border border-gray-300 p-2.5 focus:ring-blue-500 focus:border-blue-500">
                        @for ($i = 1; $i <= 20; $i++)
                            <option value="{{ $i }}"
                                {{ old('priority', $class->priority ?? 1) == $i ? 'selected' : '' }}>
                                {{ $i }}
                            </option>
                        @endfor
                    </select>
                </div>






            </div>
            {{-- STATUS --}}
            <div class="mb-4">
                <label class="font-medium flex items-center">
                    <input type="checkbox" name="status" value="1"
                        {{ old('status', $class->status ?? true) ? 'checked' : '' }}>
                    <span class="ml-2">Published?</span>
                </label>
            </div>

            {{-- SUBMIT --}}
            <div class="text-center">
                <button class="bg-emerald-500 text-white px-6 py-2 rounded-md shadow">
                    {{ isset($class) ? 'Update' : 'Create' }}
                </button>
            </div>

        </form>
    </div>
@endsection
