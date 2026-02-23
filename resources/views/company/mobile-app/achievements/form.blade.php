@extends('layouts.mobile-layout')
@php $editing = isset($level) && $level->id; @endphp
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
                aria-current="page"> {{ $editing ? 'Edit Level' : 'Create Level' }}</li>
        </ol>
        <h6 class="mb-0 font-bold text-white capitalize"> {{ $editing ? 'Edit Achievements Level' : 'Create Achievements Level' }}</h6>
    </nav>
@endsection

@section('content')
    <div class="w-full px-6 py-6 mx-auto">

        <div class="flex flex-wrap -mx-3 mt-4">
            <div class="flex-none w-full max-w-full px-3">
                <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white shadow-xl rounded-2xl">

                    <div class="p-6 pb-2 mb-3 border-b border-transparent rounded-t-2xl">
                        <div class="flex justify-between">
                            <h6>{{ $editing ? 'Edit Achievements Level' : 'Create Achievements Level' }}</h6>
                            <a href="{{ route('company.app.achievements.index') }}"
                                class="bg-emerald-500/50 rounded text-sm text-white px-4 fw-bold py-1">
                                <i class="bi bi-arrow-left me-1 "></i>
                                Back
                            </a>
                        </div>
                    </div>
                </div>
                <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white shadow-xl rounded-2xl">

                    <div class="flex-auto px-5 overflow-x-auto">
                        <div class="bg-white p-6 rounded shadow mt-6">
                            <form method="POST"
                                action="{{ $editing ? route('company.app.achievements.update', $level->id) : route('company.app.achievements.store') }}">
                                @csrf
                                @if ($editing)
                                    @method('PUT')
                                @endif

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block">Role</label>
                                        <select name="role" class="border p-2 w-full">
                                            <option value="teacher"
                                                {{ old('role', $level->role ?? '') == 'teacher' ? 'selected' : '' }}>Teacher
                                            </option>
                                            <option value="student"
                                                {{ old('role', $level->role ?? '') == 'student' ? 'selected' : '' }}>Student
                                            </option>
                                            <option value="staff"
                                                {{ old('role', $level->role ?? '') == 'staff' ? 'selected' : '' }}>Staff
                                            </option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block">Level Number</label>
                                        <input type="number" name="level_number"
                                            value="{{ old('level_number', $level->level_number ?? 1) }}"
                                            class="border p-2 w-full">
                                    </div>

                                    <div>
                                        <label class="block">Title</label>
                                        <input name="title" value="{{ old('title', $level->title ?? '') }}"
                                            class="border p-2 w-full">
                                    </div>

                                    <div>
                                        <label class="block">Position</label>
                                        <input name="position" value="{{ old('position', $level->position ?? 0) }}"
                                            class="border p-2 w-full">
                                    </div>

                                    <div class="md:col-span-2">
                                        <label class="block">Description</label>
                                        <textarea name="description" class="border p-2 w-full">{{ old('description', $level->description ?? '') }}</textarea>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="is_active" value="1"
                                            {{ old('is_active', $level->is_active ?? true) ? 'checked' : '' }}>
                                        <span class="ml-2">Active</span>
                                    </label>
                                </div>

                                <div class="mt-4 text-center">
                                    <button
                                        class="px-4 py-2 bg-success text-white rounded">{{ $editing ? 'Update Level' : 'Create Level' }}</button>
                                </div>
                            </form>
                        </div>
                        @if ($editing)
                            <div class="bg-white p-6 rounded shadow mt-6">
                                @include('company.mobile-app.achievements.task-level-form',['level' => $level])

                            </div>
                            <div class="bg-white p-6 rounded shadow mt-6">

                                {{-- ------------Task List--------------- --}}
                                @include('company.mobile-app.achievements.task-list', [
                                    'tasks' => $level->tasks,
                                ])
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
