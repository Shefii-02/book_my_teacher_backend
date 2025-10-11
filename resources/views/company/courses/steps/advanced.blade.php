<form action="{{ route('admin.courses.store') }}" method="POST" id="advancedSettingsForm" class="space-y-6">
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

            {{-- Streaming Type (only if video_type = live or hybrid) --}}
            <div id="streaming_type_wrapper" >
                <label for="streaming_type" class="block text-sm font-medium text-gray-700">Streaming Type</label>

                <select name="streaming_type" id="streaming_type"
                    class="border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option value="">-- Select Streaming Type --</option>
                    <option {{ $course && $course->streaming_type == 'zego_cloud' ? 'selected' : '' }} value="zego_cloud">Zego Cloud</option>
                    <option {{ $course && $course->streaming_type == 'agora' ? 'selected' : '' }} value="agora">Agora</option>
                    <option {{ $course && $course->streaming_type == 'zoom' ? 'selected' : '' }} value="zoom">Zoom</option>
                    <option {{ $course && $course->streaming_type == 'youtube' ? 'selected' : '' }} value="youtube">YouTube</option>
                    <option {{ $course && $course->streaming_type == 'custom' ? 'selected' : '' }} value="custom">Custom Player</option>
                </select>
            </div>

              {{-- Video Type (only if video_type = live or hybrid) --}}
            <div id="video_type_wrapper" >
                <label for="video_type" class="block text-sm font-medium text-gray-700">Video Type</label>
                <select name="video_type" id="video_type"
                    class="border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option value="">-- Select Video Type --</option>
                    <option {{ $course && $course->video_type == 'one-on-one' ? 'selected' : '' }}  value="one-on-one">One-on-One</option>
                    <option {{ $course && $course->video_type == 'livestream' ? 'selected' : '' }}  value="livestream">Livestream</option>
                    <option {{ $course && $course->video_type == 'pre-recorded' ? 'selected' : '' }}  value="pre-recorded">Pre-recorded</option>
                    <option {{ $course && $course->video_type == 'hybrid' ? 'selected' : '' }}  value="hybrid">Hybrid</option>
                </select>
            </div>

            {{-- Has Material --}}
            <div>
                <label class="block text-sm font-medium text-gray-700">Has Material?</label>
                <select name="has_material" id="has_material"
                    class="border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option {{ $course && $course->has_material == 0 ? 'selected' : '' }} value="0">No</option>
                    <option {{ $course && $course->has_material == 1 ? 'selected' : '' }} value="1">Yes</option>
                </select>
            </div>

            {{-- Has Material Download (only if has_material = 1) --}}
            <div id="material_download_wrapper" class="hidden">
                <label class="block text-sm font-medium text-gray-700">Allow Material Download?</label>
                <select name="has_material_download" id="has_material_download"
                    class="border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option {{ $course && $course->has_material_download == 0 ? 'selected' : '' }} value="0">No</option>
                    <option {{ $course && $course->has_material_download == 1 ? 'selected' : '' }} value="1">Yes</option>
                </select>
            </div>

            {{-- Has Exam --}}
            <div>
                <label class="block text-sm font-medium text-gray-700">Has Exam?</label>
                <select name="has_exam" id="has_exam"
                    class="border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option  {{ $course && $course->has_exam == 0 ? 'selected' : '' }} value="0">No</option>
                    <option  {{ $course && $course->has_exam == 1 ? 'selected' : '' }} value="1">Yes</option>
                </select>
            </div>

            {{-- Counselling --}}
            <div>
                <label class="block text-sm font-medium text-gray-700">Counselling Session Available?</label>
                <select name="is_counselling" id="is_counselling"
                    class="border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option {{ $course && $course->is_counselling == 0 ? 'selected' : '' }} value="0">No</option>
                    <option {{ $course && $course->is_counselling == 1 ? 'selected' : '' }} value="1">Yes</option>
                </select>
            </div>

            {{-- Career Guidance --}}
            <div>
                <label class="block text-sm font-medium text-gray-700">Career Guidance Included?</label>
                <select name="is_career_guidance" id="is_career_guidance"
                    class="border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option {{ $course && $course->is_career_guidance == 0 ? 'selected' : '' }} value="0">No</option>
                    <option {{ $course && $course->is_career_guidance == 1 ? 'selected' : '' }} value="1">Yes</option>
                </select>
            </div>
            {{-- Course Type --}}
            <div>
                <label class="block text-sm font-medium text-gray-700">Class Type</label>
                <select name="type" id="type"
                    class="border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option value="">-- Select Type --</option>
                    <option {{ $course && $course->type == 'offline' ? 'selected' : '' }} value="offline">Offline</option>
                    <option {{ $course && $course->type == 'online' ? 'selected' : '' }} value="online">Online</option>
                    <option {{ $course && $course->type == 'recorded' ? 'selected' : '' }} value="recorded">Recorded</option>
                    <option {{ $course && $course->type == 'hybrid' ? 'selected' : '' }} value="hybrid">Hybrid</option>
                </select>
            </div>
        </div>

        <!-- Submit -->
        <div class="my-2 text-center md:col-span-2">
            <input type="submit"
                class="px-5 py-2.5 text-sm font-medium text-white bg-green-700 hover:bg-green-800 rounded-lg"
                name="advanced_form" value="{{ $course->step_completed >= 4 ? 'Update' : 'Create' }}">
        </div>
    </div>
</form>
