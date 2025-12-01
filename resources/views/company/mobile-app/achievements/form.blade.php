@extends('layouts.mobile-layout')
@section('content')
@php $editing = isset($level) && $level->id; @endphp
<div class="container mx-auto p-6">
  <div class="bg-white p-6 rounded shadow">
    <h2 class="text-lg font-bold mb-4">{{ $editing ? 'Edit Level' : 'Create Level' }}</h2>

    <form method="POST" action="{{ $editing ? route('admin.app.achievements.update', $level->id) : route('admin.app.achievements.store') }}">
      @csrf
      @if($editing) @method('PUT') @endif

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block">Role</label>
          <select name="role" class="border p-2 w-full">
            <option value="teacher" {{ old('role', $level->role ?? '') == 'teacher' ? 'selected' : '' }}>Teacher</option>
            <option value="student" {{ old('role', $level->role ?? '') == 'student' ? 'selected' : '' }}>Student</option>
            <option value="staff" {{ old('role', $level->role ?? '') == 'staff' ? 'selected' : '' }}>Staff</option>
          </select>
        </div>

        <div>
          <label class="block">Level Number</label>
          <input type="number" name="level_number" value="{{ old('level_number', $level->level_number ?? 1) }}" class="border p-2 w-full">
        </div>

        <div>
          <label class="block">Title</label>
          <input name="title" value="{{ old('title', $level->title ?? '') }}" class="border p-2 w-full">
        </div>

        <div>
          <label class="block">Position</label>
          <input name="position" value="{{ old('position', $level->position ?? 0) }}" class="border p-2 w-full">
        </div>

        <div class="md:col-span-2">
          <label class="block">Description</label>
          <textarea name="description" class="border p-2 w-full">{{ old('description', $level->description ?? '') }}</textarea>
        </div>
      </div>

      <div class="mt-4">
        <label class="inline-flex items-center">
          <input type="checkbox" name="is_active" value="1" {{ old('is_active', $level->is_active ?? true) ? 'checked' : '' }}>
          <span class="ml-2">Active</span>
        </label>
      </div>

      <div class="mt-4">
        <button class="px-4 py-2 bg-emerald-500 text-white rounded">{{ $editing ? 'Update Level' : 'Create Level' }}</button>
      </div>
    </form>
  </div>

  @if($editing)
  <div class="bg-white p-6 rounded shadow mt-6">
    <h3 class="font-semibold mb-3">Tasks for this level</h3>

    <form method="POST" action="{{ route('admin.app.achievements.tasks.store', $level->id) }}" class="grid grid-cols-1 md:grid-cols-2 gap-3">
      @csrf
      <input name="task_type" placeholder="task_type (referral_count)" class="border p-2">
      <input name="title" placeholder="Task title" class="border p-2">
      <input name="target_value" placeholder="Target value" type="number" class="border p-2">
      <input name="points" placeholder="Points" type="number" class="border p-2">
      <textarea name="description" placeholder="Description" class="border p-2 md:col-span-2"></textarea>
      <div class="md:col-span-2">
        <button class="px-3 py-2 bg-blue-600 text-white rounded">Add Task</button>
      </div>
    </form>

    <div class="mt-4">
      <ul>
        @foreach($level->tasks as $task)
          <li class="border p-3 rounded mb-2 flex justify-between items-center">
            <div>
              <div class="text-sm font-semibold">{{ $task->title }} ({{ $task->task_type }})</div>
              <div class="text-xs text-gray-500">Target: {{ $task->target_value }} • Points: {{ $task->points }}</div>
            </div>
            <form action="{{ route('admin.app.achievements.tasks.destroy', $task->id) }}" method="POST">
              @csrf @method('DELETE')
              <button class="px-2 py-1 bg-red-500 text-white rounded">Delete</button>
            </form>
          </li>
        @endforeach
      </ul>
    </div>
  </div>
  @endif

</div>
@endsection
