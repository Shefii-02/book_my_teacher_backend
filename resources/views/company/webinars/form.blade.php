@extends('layouts.layout')

@php
    $isEdit = isset($webinar);
@endphp

@section('title', $isEdit ? 'Edit Webinar' : 'Create Webinar')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        .select2-container .select2-selection--single {
            padding-top: 6px !important;
            height: 40px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            border: 1px solid #dee2e6 !important;
            border-radius: 5px !important;
        }

        span.select2-results__option[aria-selected=true] {
            background-color: #e9ecef !important;
        }

        .select2-container--default .select2-search--dropdown .select2-search__field {
            background: #d8d8d8 !important;
            border: 1px solid #dee2e6 !important;
            border-radius: 5px !important;
        }

        .select2-container .select2-selection--single {
            padding-top: 0px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {

            line-height: 40px;
        }
    </style>
@endpush
@section('nav-options')
    <nav>
        <ol class="flex flex-wrap pt-1 mr-12 bg-transparent rounded-lg sm:mr-16">
            <li><a class="text-white" href="/">Home</a></li>
            <li class="pl-2 text-white before:content-['/']"><a class="text-white"
                    href="{{ route('company.dashboard') }}">Dashboard</a></li>
            <li class="pl-2 text-white before:content-['/']"><a class="text-white"
                    href="{{ route('company.webinars.index') }}">Webinars</a></li>
            <li class="pl-2 font-bold text-white before:content-['/']" aria-current="page">{{ $isEdit ? 'Edit' : 'Create' }}
            </li>
        </ol>
        <h6 class="mb-0 font-bold text-white capitalize">{{ $isEdit ? 'Edit Webinar' : 'Create Webinar' }}</h6>
    </nav>
@endsection

@section('content')
    <div class="container">
        <div class="card bg-white rounded-3 my-3 p-4">
            <div class="flex justify-between">
                <h5 class="font-bold">{{ $isEdit ? 'Edit Webinar' : 'Create Webinar' }}</h5>
                <a href="{{ route('company.webinars.index') }}"
                    class="px-4 py-2 bg-gradient-to-tl from-emerald-500 to-teal-400  text-white rounded text-sm">
                    <i class="bi bi-arrow-left"></i> Back</a>
            </div>
        </div>

        <div class="form-container mt-4">
            <form action="{{ $isEdit ? route('company.webinars.update', $webinar->id) : route('company.webinars.store') }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                @if ($isEdit)
                    @method('PUT')
                @endif

                <div class="grid gap-6 mb-6 md:grid-cols-2">

                    <!-- Thumbnail -->
                    <div>
                        <label class="block mb-1 font-semibold">Thumbnail Image</label>
                        <img id="thumbnailPreview"
                            src="{{ $isEdit && $webinar->thumbnail_image ? asset('storage/' . $webinar->thumbnail_image) : '' }}"
                            class="w-20 h-20 mt-2 rounded">
                        <input type="file" id="thumbnailInput" name="thumbnail_image" accept="image/*"
                            class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow @error('thumbnail_image') border-red-500 @enderror">
                        @error('thumbnail_image')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Main Image -->
                    <div>
                        <label class="block mb-1 font-semibold">Main Image</label>
                        <img id="mainImagePreview"
                            src="{{ $isEdit && $webinar->main_image ? asset('storage/' . $webinar->main_image) : '' }}"
                            class="w-20 h-20 mt-2 rounded">
                        <input type="file" id="mainImageInput" name="main_image" accept="image/*"
                            class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow @error('main_image') border-red-500 @enderror">
                        @error('main_image')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Title -->
                <div>
                    <label class="block mb-1 font-semibold">Title</label>
                    <input type="text" name="title" value="{{ old('title', $isEdit ? $webinar->title : '') }}"
                        required
                        class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow @error('title') border-red-500 @enderror">
                    @error('title')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mt-2 mb-4">
                    <label class="block mb-1 font-semibold">Description</label>
                    <textarea class="form-control border p-3" name="description">{{ old('description', $isEdit ? $webinar->description : '') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="grid gap-6 mb-6 md:grid-cols-2">
                    <!-- Host -->
                    <div>
                        <label class="block mb-1 font-semibold">Host</label>
                        <select name="host_id" id="hostSelect"
                            class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow @error('host_id') border-red-500 @enderror">
                            <option value="">-- Select Host --</option>
                            @foreach ($users ?? [] as $user)
                                <option value="{{ $user['user_id'] }}"
                                    {{ old('host_id', $isEdit ? $webinar->host_id : '') == $user['user_id'] ? 'selected' : '' }}>
                                    {{ $user['name'] . '(' . $user['type'] . ')' }}</option>
                            @endforeach
                        </select>
                        @error('host_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Stream Provider -->
                    <div>
                        <label class="block mb-1 font-semibold">Stream Provider</label>
                        <select name="stream_provider_id"
                            class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow @error('stream_provider_id') border-red-500 @enderror">
                            <option value="">-- Select Provider --</option>
                            @foreach ($providers as $provider)
                                <option value="{{ $provider->id }}"
                                    {{ old('stream_provider_id', $isEdit ? $webinar->stream_provider_id : '') == $provider->id ? 'selected' : '' }}>
                                    {{ $provider->name }}</option>
                            @endforeach
                        </select>
                        @error('stream_provider_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Start At -->
                    <div>
                        <label class="block mb-1 font-semibold">Start At</label>
                        <input type="datetime-local" name="started_at"
                            value="{{ old('started_at', $isEdit && $webinar->started_at ? $webinar->started_at->format('Y-m-d\TH:i') : '') }}"
                            class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow @error('started_at') border-red-500 @enderror">
                        @error('started_at')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- End At -->
                    <div>
                        <label class="block mb-1 font-semibold">End At</label>
                        <input type="datetime-local" name="ended_at"
                            value="{{ old('ended_at', $isEdit && $webinar->ended_at ? $webinar->ended_at->format('Y-m-d\TH:i') : '') }}"
                            class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow @error('ended_at') border-red-500 @enderror">
                        @error('ended_at')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Registration End At -->
                    <div>
                        <label class="block mb-1 font-semibold">Registration End At</label>
                        <input type="datetime-local" name="registration_end_at"
                            value="{{ old('registration_end_at', $isEdit && $webinar->registration_end_at ? $webinar->registration_end_at->format('Y-m-d\TH:i') : '') }}"
                            class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow @error('registration_end_at') border-red-500 @enderror">
                        @error('registration_end_at')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Who can join -->
                    {{-- <div>
                        <label class="block mb-1 font-semibold">Who can Join</label>
                        <div class="flex space-x-4">
                            @foreach (['teacher', 'student', 'guest'] as $role)
                                <label class="flex gap-2 items-center">
                                    <input type="checkbox" name="is_{{ $role }}_allowed" value="1"
                                        {{ old('is_' . $role . '_allowed', $isEdit ? $webinar->{'is_' . $role . '_allowed'} : ($role != 'guest' ? 1 : 0)) ? 'checked' : '' }}
                                        class="pl-2 text-sm focus:shadow-primary-outline ease leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow">
                                    {{ ucfirst($role) }}
                                </label>
                            @endforeach
                        </div>
                        @error('is_teacher_allowed')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        @error('is_student_allowed')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        @error('is_guest_allowed')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div> --}}

                    <!-- Max Participants -->
                    {{-- <div>
                        <label class="block mb-1 font-semibold">Max Participants</label>
                        <select name="max_participants"
                            class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow @error('max_participants') border-red-500 @enderror">
                            @foreach ([10, 25, 50, 100, 250, 500, 1000] as $number)
                                <option value="{{ $number }}"
                                    {{ old('max_participants', $isEdit ? $webinar->max_participants : '') == $number ? 'selected' : '' }}>
                                    {{ $number }}</option>
                            @endforeach
                        </select>
                        @error('max_participants')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div> --}}

                    <!-- Features -->
                    {{-- <div>
                        <label class="block mb-1 font-semibold">Enable Features</label>
                        <div class="flex flex-wrap space-x-4">
                            @foreach (['record', 'chat', 'screen_share', 'whiteboard', 'camera', 'audio_only'] as $feature)
                                <label class="flex gap-2 items-center mb-2">
                                    <input type="checkbox" name="is_{{ $feature }}_enabled" value="1"
                                        {{ old('is_' . $feature . '_enabled', $isEdit ? $webinar->{'is_' . $feature . '_enabled'} : ($feature != 'audio_only' ? 1 : 0)) ? 'checked' : '' }}
                                        class="pl-2 text-sm focus:shadow-primary-outline ease leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow">
                                    {{ ucwords(str_replace('_', ' ', $feature)) }}
                                </label>
                                @error('is_' . $feature . '_enabled')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            @endforeach
                        </div>
                    </div> --}}



                    <!-- Tags -->
                    <div class="md:col-span-2">
                        <label class="block mb-1 font-semibold">Meeting url</label>
                        <input type="text" name="meeting_url"
                            value="{{ old('meeting_url', $isEdit ? $webinar->meeting_url : '') }}"
                            class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow @error('tags') border-red-500 @enderror">
                        @error('meeting_url')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>



                    <!-- Tags -->
                    <div class="md:col-span-2">
                        <label class="block mb-1 font-semibold">Recording url</label>
                        <input type="text" name="recording_url"
                            value="{{ old('recording_url', $isEdit ? $webinar->recording_url : '') }}"
                            class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow @error('tags') border-red-500 @enderror">
                        @error('recording_url')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    {{-- 'live', 'ended' --}}
                    <div>
                        <label class="block mb-1 font-semibold">Status</label>
                        <select name="status"
                            class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow @error('status') border-red-500 @enderror">
                            @foreach (['draft', 'scheduled'] as $status)
                                <option value="{{ $status }}"
                                    {{ old('status', $isEdit ? $webinar->status : '') == $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}</option>
                            @endforeach
                        </select>
                        @error('status')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tags -->
                    {{-- <div class="md:col-span-2">
                        <label class="block mb-1 font-semibold">Tags (comma separated)</label>
                        <input type="text" name="tags" value="{{ old('tags', $isEdit ? $webinar->tags : '') }}"
                            class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow @error('tags') border-red-500 @enderror">
                        @error('tags')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div> --}}

                    <!-- Meta -->
                    {{-- <div class="md:col-span-2">
                        <label class="block mb-1 font-semibold">Meta</label>
                        <textarea name="meta"
                            class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow @error('meta') border-red-500 @enderror">{{ old('meta', $isEdit ? $webinar->meta : '') }}</textarea>
                        @error('meta')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div> --}}

                </div>
                <div class="text-center">
                    <button type="submit"
                        class="bg-success text-white px-4 py-2 rounded hover:bg-blue-700">{{ $isEdit ? 'Update Webinar' : 'Create Webinar' }}</button>

                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {

            $('#hostSelect').select2({
                placeholder: "-- Select Host --",
                width: '100%',
            });

        });
    </script>
    <script>
        $(document).ready(function() {
            function readURL(input, previewId) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $(previewId).attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }

            $('#thumbnailInput').change(function() {
                readURL(this, '#thumbnailPreview');
            });

            $('#mainImageInput').change(function() {
                readURL(this, '#mainImagePreview');
            });
        });
    </script>
@endpush
