@extends('layouts.layout')

@section('content')
<div class="p-6">

    <div class="flex justify-between mb-4">
        <h2 class="text-xl font-bold">
            Course Materials — {{ $course->title }}
        </h2>

        <a href="{{ route('admin.courses.materials.create', $course->course_identity) }}"
           class="px-4 py-2 bg-blue-600 text-white rounded">
           + Add Material
        </a>
    </div>

    <div class="bg-white shadow rounded p-4">

        <table class="w-full border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 text-left w-16">#</th>
                    <th class="p-2 text-left">Title</th>
                    <th class="p-2 text-left">File</th>
                    <th class="p-2 text-left">Type</th>
                    <th class="p-2 text-left">Status</th>
                    <th class="p-2 text-left w-40">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($materials as $material)
                    <tr class="border-b">

                        <td class="p-2">{{ $material->position }}</td>

                        <td class="p-2">{{ $material->title }}</td>

                        <td class="p-2">
                            <a href="{{ asset('storage/'.$material->file_path) }}"
                               target="_blank" class="text-blue-500 underline">
                                View
                            </a>
                        </td>

                        <td class="p-2">{{ $material->file_type }} </td>

                        <td class="p-2 capitalize">
                            <span class="{{ $material->status == 'published'
                                    ? 'text-green-600'
                                    : 'text-gray-600' }}">
                                {{ $material->status }}
                            </span>
                        </td>

                        <td class="p-2">
                            {{-- Edit --}}
                            <a href="{{ route('admin.courses.materials.edit', [$course->id, $material->id]) }}"
                               class="text-green-600">Edit</a>

                            {{-- Delete --}}
                            <form action="{{ route('admin.courses.materials.destroy', [$course->id, $material->id]) }}"
                                  method="POST" class="inline-block ml-3"
                                  onsubmit="return confirm('Delete this material?');">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600">Delete</button>
                            </form>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-3 text-center text-gray-500">
                            No materials found.
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>
    </div>
</div>
@endsection
