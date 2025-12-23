@extends('layouts.mobile-layout')

@section('nav-options')
    <nav>
        <ol class="flex flex-wrap pt-1 mr-12 bg-transparent rounded-lg sm:mr-16">
            <li class="text-neutral-900 text-sm">
                <a class="text-white" href="javascript:;">Home</a>
            </li>
            <li class="text-sm pl-2 text-white before:float-left before:pr-2 before:text-white before:content-['/']">
                <a class="text-white" href="{{ route('company.app.grades.index') }}">Grades List</a>
            </li>
            <li
                class="text-sm pl-2 font-bold text-white before:float-left before:pr-2 before:text-white before:content-['/']">
                Grade {{ isset($grade) ? 'Edit' : 'Create' }}
            </li>
        </ol>
        <h6 class="mb-0 font-bold text-white capitalize">
            Grade {{ isset($grade) ? 'Edit' : 'Create' }}
        </h6>
    </nav>
@endsection

@section('content')
    <div class="container">
        <div class="card bg-white rounded-3 my-3">
            <div class="card-title p-3 my-3">
                <div class="flex justify-between">
                    <h6 class="font-bold">{{ isset($grade) ? 'Edit' : 'Create' }} Grade</h6>
                    <a href="{{ route('company.app.grades.index') }}"
                        class="bg-emerald-500/50 rounded text-sm text-white px-4 fw-bold py-1">
                        <i class="bi bi-arrow-left me-1 "></i>
                        Back</a>
                </div>
            </div>
        </div>

        <div class="form-container bg-white shadow-xl rounded-2xl p-6">
            @php
                // If edit mode, get model values, else fallback to old()
                $isEdit = isset($grade);
                $thumbPreview = $isEdit && $grade->thumbnail_url ? $grade->thumbnail_url : null;
            @endphp
            <form
                action="{{ $isEdit ? route('company.app.grades.update', $grade->id) : route('company.app.grades.store') }}"
                method="POST" enctype="multipart/form-data" class="space-y-6"> @csrf @if ($isEdit)
                    @method('PUT')
                @endif <!-- THUMBNAIL -->
                <div> <label class="block font-semibold mb-1">Thumbnail</label>

                    <img id="iconPreview" src="{{ $thumbPreview }}"
                        class="w-32 h-32 rounded object-cover mb-3 border {{ $thumbPreview ? '' : 'hidden' }}"> <input
                        type="file" name="thumb" class="block w-full text-sm border rounded p-2">
                    @error('thumb')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div> <!-- TITLE -->
                <div> <label class="block font-semibold mb-1">Title</label> <input type="text" name="name"
                        value="{{ $isEdit ? $grade->name : old('name') }}" class="w-full border rounded p-2"
                        placeholder="Enter grade name"> @error('name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div> <!-- DESCRIPTION -->
                <div> <label class="block font-semibold mb-1">Description</label>
                    <textarea name="description" rows="4" class="w-full border rounded p-2" placeholder="Enter description">{{ $isEdit ? $grade->description : old('description') }}</textarea> @error('description')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <!-- POSITION -->
                <div> <label class="block font-semibold mb-1">Position</label> <input type="number" name="position"
                        value="{{ $isEdit ? $grade->position : old('position') }}" class="w-full border rounded p-2"
                        placeholder="Enter display position"> @error('position')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div> <!-- PUBLISHED TOGGLE -->

                <div>
                    <div class="flex items-center gap-3">
                        <label class="font-medium">
                            <input type="checkbox" class="border pe-3" name="published" value="1"
                                @checked(old('published', $grade->published ?? false))> Publish</label>
                    </div>
                </div>
                @if (isset($grade) && $grade->category()->exists())
                @else
                    <div>
                        <div class="flex items-center gap-3">
                            <label class="font-medium">
                                <input type="checkbox" class="border pe-3" name="attach_category" value="1"
                                    @checked(old('attach_category', $grade->category()->exists() ?? false))> Attach to Category aslo</label>
                        </div>
                    </div>
                @endif



                {{-- SUBMIT --}}
                <div class="flex justify-center">
                    <button type="submit"
                        class="bg-emerald-500/50 text-white px-6 py-2 rounded-lg">{{ $isEdit ? 'Update Grade' : 'Create Grade' }}
                    </button>
                </div>

            </form>
        </div>
    </div>
    {{-- JS for Live Image Preview --}}
    <script>
        function previewIcon(event) {
            let output = document.getElementById('iconPreview');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.classList.remove('hidden');
        }
    </script>
@endsection
