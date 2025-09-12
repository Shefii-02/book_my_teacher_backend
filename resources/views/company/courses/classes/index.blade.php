@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="card bg-white rounded-3 mb-3">
        <div class="card-title p-2 m-2 flex justify-between items-center">
            <h5 class="font-bold">Course Classes</h5>
            <a href="{{ route('company.courses.classes.create') }}" class="btn btn-primary">+ Add Class</a>
        </div>
    </div>

    <div class="card p-3">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Course</th>
                    <th>Teacher</th>
                    <th>Created</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($classes as $class)
                    <tr>
                        <td>{{ $class->course?->title }}</td>
                        <td>{{ $class->teacher?->name }}</td>
                        <td>{{ $class->created_at->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('company.courses.classes.edit', $class->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('company.courses.classes.destroy', $class->id) }}" method="POST" class="inline-block"
                                  onsubmit="return confirm('Are you sure?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center">No course classes found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
