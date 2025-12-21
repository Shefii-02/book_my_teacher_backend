@extends('layouts.mobile-layout')

@section('nav-options')
    <nav>
        <ol class="flex flex-wrap pt-1 mr-12 bg-transparent rounded-lg sm:mr-16">
            <li class="text-neutral-900 text-sm">
                <a class="text-white" href="javascript:;">Home</a>
            </li>
            <li class="text-sm pl-2 text-white before:float-left before:pr-2 before:text-white before:content-['/']">
                <a class="text-white" href="{{ route('company.app.course-banners.index') }}">Course Banners List</a>
            </li>
            <li
                class="text-sm pl-2 font-bold text-white before:float-left before:pr-2 before:text-white before:content-['/']">
                Course Banners {{ isset($banner) ? 'Edit' : 'Create' }}
            </li>
        </ol>
        <h6 class="mb-0 font-bold text-white capitalize">
            Course Banners {{ isset($banner) ? 'Edit' : 'Create' }}
        </h6>
    </nav>
@endsection

@section('content')
    <div class="container">
        <div class="card bg-white rounded-3 my-3">
            <div class="card-title p-3 my-3">
                <div class="flex justify-between">
                    <h6 class="font-bold">{{ isset($banner) ? 'Edit' : 'Create' }} Course Banner</h6>

                    <a href="{{ route('company.app.course-banners.index') }}"
                        class="bg-emerald-500/50 rounded-full text-sm text-white px-4 fw-bold py-1">
                        <i class="bi bi-arrow-left me-1 "></i>
                        Back</a>
                </div>
            </div>
        </div>

        <div class="form-container bg-white shadow-xl rounded-2xl p-6">
            <form
                action="{{ isset($banner) ? route('company.app.course-banners.update', $banner->id) : route('company.app.course-banners.store') }}"
                method="POST" enctype="multipart/form-data">

                @csrf
                @if (isset($banner))
                    @method('PUT')
                @endif

                <div class="form-step active p-6">

                    <div class="grid gap-6 mb-6 md:grid-cols-2">

                        {{-- THUMB IMAGE --}}
                        <div class="flex flex-col">
                            <label class="block mb-2 text-sm font-medium">Thumb Image</label>

                            <img id="thumbPreview"
                                src="{{ old('thumb_preview', isset($banner) ? $banner->thumbnail_url : '') }}"
                                class="rounded-lg w-28 h-28 object-cover mb-2 border" />

                            <input type="file" id="thumbSelect" name="thumb_id" accept="image/*"
                                class="block text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer p-1">

                            @error('thumb')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- MAIN IMAGE --}}
                        <div class="flex flex-col">
                            <label class="block mb-2 text-sm font-medium">Main Image</label>

                            <img id="mainPreview" src="{{ old('main_preview', isset($banner) ? $banner->main_image_url : '') }}"
                                class="rounded-lg w-28 h-28 object-cover mb-2 border" />

                            <input type="file" id="mainSelect" name="main_id" accept="image/*"
                                class="block text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer p-1">

                            @error('main')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- TITLE --}}
                        <div>
                            <label class="block mb-2 text-sm font-medium">Title</label>
                            <input type="text" name="title" value="{{ old('title', $banner->title ?? '') }}"
                                placeholder="Enter Banner Title"
                                class="pl-3 text-sm w-full rounded-lg border border-gray-300 py-2">
                            @error('title')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- PRIORITY --}}
                        <div>
                            <label class="block mb-2 text-sm font-medium">Priority</label>
                            <input type="number" name="priority" value="{{ old('priority', $banner->priority ?? '') }}"
                                placeholder="Showing position like: 1,2,3"
                                class="pl-3 text-sm w-full rounded-lg border border-gray-300 py-2">
                            @error('priority')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="flex flex-col">
                        {{-- DESCRIPTION --}}
                        <div class="md:col-span-2">
                            <label class="block mb-2 text-sm font-medium">Description</label>
                            <textarea name="description" rows="3" placeholder="Detailed information here..."
                                class="pl-3 text-sm w-full rounded-lg border border-gray-300 py-2">{{ old('description', $banner->description ?? '') }}</textarea>
                            @error('description')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        {{-- CTA LABEL --}}

                        <div>
                            <label class="block mb-2 text-sm font-medium">CTA Label</label>
                            <input type="text" name="ct_label" value="{{ old('ct_label', $banner->ct_label ?? '') }}"
                                placeholder="Ex: Buy Now/Join Now, Book Now"
                                class="pl-3 text-sm w-full rounded-lg border border-gray-300 py-2">
                            @error('ct_label')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- CTA ACTION --}}
                        <div>
                            <label class="block mb-2 text-sm font-medium">CTA Action</label>
                            <select name="ct_action" class="pl-3 text-sm w-full rounded-lg border border-gray-300 py-2">

                                <option value="">Select Action</option>

                                <option value="book_now"
                                    {{ old('cta_action', $banner->ct_action ?? '') == 'book_now' ? 'selected' : '' }}>
                                    Book Now
                                </option>

                                <option value="buy_now"
                                    {{ old('cta_action', $banner->ct_action ?? '') == 'buy_now' ? 'selected' : '' }}>
                                    Buy Now/Join Now
                                </option>

                                <option value="connect_with_whatsapp"
                                    {{ old('cta_action', $banner->ct_action ?? '') == 'connect_with_whatsapp' ? 'selected' : '' }}>
                                    Connect With WhatsApp
                                </option>

                            </select>
                            @error('cta_action')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- PUBLISH SWITCH --}}
                        <div class="md:col-span-2">
                            {{-- <label class="block mb-2 text-sm font-medium">Publish</label> --}}

                            <div class="flex flex-row gap-3">
                                <label class="flex items-center space-x-2 cursor-pointer">
                                    <input type="radio" name="status" value="1" class="text-emerald-500 border"
                                        {{ old('status', $banner->status ?? false) ? 'checked' : '' }}>
                                    <span class="text-sm">Publish</span>
                                </label>

                                <label class="flex items-center space-x-2 cursor-pointer">
                                    <input type="radio" name="status" value="0" class="text-red-500 border"
                                        {{ !old('status', $banner->status ?? false) ? 'checked' : '' }}>
                                    <span class="text-sm">Unpublish</span>
                                </label>
                            </div>








                            @error('status')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror

                        </div>

                    </div>
                    <div class="flex justify-center">
                        {{-- SUBMIT BUTTON --}}
                        <button type="submit" class="bg-emerald-500/50 rounded-full text-white  px-4 py-2 mt-3">
                            {{ isset($banner) ? 'Update Banner' : 'Create Banner' }}
                        </button>
                    </div>

                </div>
            </form>

        </div>
    </div>

    <!-- =======================
                        JS IMAGE PREVIEW
                    ======================== -->
    <script>
        // Thumb Preview
        document.getElementById('thumbSelect')?.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file) document.getElementById('thumbPreview').src = URL.createObjectURL(file);
        });

        // Main Preview
        document.getElementById('mainSelect')?.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file) document.getElementById('mainPreview').src = URL.createObjectURL(file);
        });
    </script>
@endsection
