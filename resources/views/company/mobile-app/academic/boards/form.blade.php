@extends('layouts.mobile-layout')

@section('nav-options')
    <nav>
        <ol class="flex flex-wrap pt-1 mr-12 bg-transparent rounded-lg sm:mr-16">
            <li class="text-neutral-900 text-sm">
                <a class="text-white" href="javascript:;">Home</a>
            </li>
            <li class="text-sm pl-2 text-white before:float-left before:pr-2 before:text-white before:content-['/']">
                <a class="text-white" href="{{ route('admin.app.boards.index') }}">Boards List</a>
            </li>
            <li
                class="text-sm pl-2 font-bold text-white before:float-left before:pr-2 before:text-white before:content-['/']">
                Board {{ isset($board) ? 'Edit' : 'Create' }}
            </li>
        </ol>
        <h6 class="mb-0 font-bold text-white capitalize">
            Board {{ isset($board) ? 'Edit' : 'Create' }}
        </h6>
    </nav>
@endsection

@section('content')
    <div class="container">

        <div class="card bg-white rounded-3 my-3">
            <div class="card-title p-3 my-3">
                <div class="flex justify-between">
                    <h6 class="font-bold">{{ $board->id ? 'Edit Board' : 'Create Board' }}</h6>
                    <a href="{{ route('admin.app.boards.index') }}"
                        class="bg-emerald-500/50 rounded-full text-sm text-white px-4 fw-bold py-1">
                        <i class="bi bi-arrow-left me-1"></i>
                        Back
                    </a>
                </div>
            </div>
        </div>

        <div class="form-container bg-white shadow-xl rounded-2xl p-6">

            @php
                $isEdit = isset($board) && $board->id;
                $thumbPreview = $isEdit ? $board->icon_url : null;
            @endphp

            <form method="POST" enctype="multipart/form-data"
                action="{{ $isEdit ? route('admin.app.boards.update', $board->id) : route('admin.app.boards.store') }}"
                class="space-y-6">

                @csrf

                {{-- ICON PREVIEW + FILE INPUT --}}
                <div>
                    <label class="block font-semibold mb-1">Icon</label>

                    <img id="iconPreview" src="{{ $thumbPreview }}"
                        class="w-32 h-32 rounded object-cover mb-3 border {{ $thumbPreview ? '' : 'hidden' }}">

                    <input type="file" name="icon" accept="image/*" class="block w-full text-sm border rounded p-2"
                        onchange="previewIcon(event)">

                    @error('icon')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid md:grid-cols-2 gap-6">

                    {{-- Name --}}
                    <div>
                        <label class="font-semibold">Name</label>
                        <input type="text" name="name" value="{{ old('name', $board->name) }}"
                            class="w-full border rounded p-2" required>
                        @error('name')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>


                    {{-- Position --}}
                    <div>
                        <label class="font-semibold">Position</label>
                        <input type="number" name="position" value="{{ old('position', $board->position) }}"
                            class="w-full border rounded p-2">
                    </div>
                </div>

                {{-- Description --}}
                <div>
                    <label class="font-semibold">Description</label>
                    <textarea name="description" class="w-full border rounded p-2" rows="3">{{ old('description', $board->description) }}</textarea>
                </div>

                {{-- Published --}}
                <div>
                    <label class="font-semibold flex items-center space-x-2">
                        <input type="checkbox" name="published" value="1" class="border"
                            {{ old('published', $board->published) ? 'checked' : '' }}>
                        <span>Published</span>
                    </label>
                </div>

                <hr class="border">

                {{-- GRADES CHECKBOX --}}
                <div>
                    <label class="font-bold">Grades</label>
                    <div class="grid grid-cols-2 gap-3 mt-2">

                        @foreach ($grades as $g)
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" name="grade_ids[]" value="{{ $g->id }}" class="border"
                                    {{ in_array($g->id, old('grade_ids', $board->grades->pluck('id')->toArray())) ? 'checked' : '' }}>
                                <span>{{ $g->name }}</span>
                            </label>
                        @endforeach

                    </div>
                </div>

                {{-- SUBJECTS CHECKBOX --}}
                <div>
                    <label class="font-bold">Subjects</label>
                    <div class="grid grid-cols-2 gap-3 mt-2">
                        @foreach ($subjects as $s)
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" name="subject_ids[]" value="{{ $s->id }}" class="border"
                                    {{ in_array($s->id, old('subject_ids', $board->subjects->pluck('id')->toArray())) ? 'checked' : '' }}>
                                <span>{{ $s->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- SUBMIT --}}
                <div class="flex justify-center">
                    <button type="submit" class="bg-emerald-500/50 text-white px-6 py-2 rounded-lg">
                        {{ $isEdit ? 'Update Board' : 'Create Board' }}
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
