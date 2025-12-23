<div class="flex-none w-full max-w-full px-3" x-data="{ type: '{{ old('type', $class->type ?? 'online') }}' }">
    <div class="form-title">
        <h2 id="drawer-right-label"
            class="text-gray-400 rounded-lg text-lg text-sm absolute top-2.5  inline-flex items-center justify-center">
            <svg class="w-4 h-4 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            {{ isset($class) ? 'Edit' : 'Create' }} a Workshop Class
        </h2>
    </div>
    <div class="relative flex flex-col min-w-0 my-4 break-words">

        <form method="POST"
            action="{{ isset($class)
                ? route('company.workshops.schedule-class.update', [
                    'id' => $workshop->id,
                    'schedule_class' => $class->id,
                ])
                : route('company.workshops.schedule-class.store', [
                    'id' => $workshop->id,
                ]) }}">

            @csrf
            @if (isset($class))
                @method('PUT')
            @endif

            {{-- TOP FIELDS --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 my-4">

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
                <textarea name="description" class="w-full border rounded p-2">{{ old('description', $class->description ?? '') }}</textarea>
            </div>

            {{-- DATE & TIME --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">

                <div>
                    <label class="font-medium">Class Date</label>
                    <input type="date" name="scheduled_at"
                        value="{{ old('scheduled_at', isset($class) ? date('Y-m-d', strtotime($class->scheduled_at)) : '' ?? '') }}"
                        class="w-full border rounded p-2" required>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="font-medium">Start Time</label>
                        <input type="time" name="start_time"
                            value="{{ old('start_time', isset($class) ? date('H:i',strtotime($class->start_time)) : '' ?? '') }}" class="w-full border rounded p-2"
                            required>
                    </div>

                    <div>
                        <label class="font-medium">End Time</label>
                        <input type="time" name="end_time" value="{{ old('end_time',isset($class) ? date('H:i',strtotime($class->end_time)) : '' ?? '') }}"
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
                                {{ old('class_mode', $class->class_mode ?? '') == 'youtube' ? 'selected' : '' }}>
                                YouTube
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
                        value="{{ old('recording_url', $class->recording_url ?? '') }}"
                        class="w-full border rounded p-2">
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                @php
                    $classTeacher = isset($class) ? $class->teachers?->pluck('id')->first() : '';
                @endphp


                {{-- PRIORITY --}}
                <div class="mb-4 w-50">
                    <label class="font-medium mb-1">Priority</label>
                    <select name="priority"
                        class="block w-full rounded-lg border border-gray-300 p-2.5 focus:ring-blue-500 focus:border-blue-500">
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
                <button class="bg-emerald-500/50 text-white px-6 py-2 rounded-md shadow">
                    {{ isset($class) ? 'Update' : 'Create' }}
                </button>
            </div>

        </form>
    </div>
</div>
