@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="card bg-white rounded-3 mb-3">
        <div class="card-title p-2 m-2 flex justify-between items-center">
            <h5 class="font-bold">Livestream Classes</h5>
            <a href="{{ route('livestream_classes.create') }}" class="btn btn-primary">+ Add Livestream</a>
        </div>
    </div>

    <div class="card p-3">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Duration</th>
                    <th>Teachers</th>
                    <th>Permissions</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($livestreams as $stream)
                    <tr>
                        <td>{{ $stream->title }}</td>
                        <td>{{ $stream->duration }} min</td>
                        <td>
                            @foreach($stream->teachers as $t)
                                <span class="badge bg-info">{{ $t->name }}</span>
                            @endforeach
                        </td>
                        <td>
                            <small>
                                Voice: {{ $stream->permissions?->allow_voice ? 'Yes' : 'No' }},
                                Video: {{ $stream->permissions?->allow_video ? 'Yes' : 'No' }},
                                Share: {{ $stream->permissions?->allow_screen_share ? 'Yes' : 'No' }},
                                Chat: {{ $stream->permissions?->allow_chat ? 'Yes' : 'No' }}
                            </small>
                        </td>
                        <td>
                            <a href="{{ route('livestream_classes.edit', $stream->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('livestream_classes.destroy', $stream->id) }}" method="POST" class="inline-block"
                                  onsubmit="return confirm('Are you sure?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center">No livestream classes found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
