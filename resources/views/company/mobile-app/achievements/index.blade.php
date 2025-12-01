@extends('layouts.mobile-layout')
@section('content')
<div class="container mx-auto p-6">
  <div class="flex justify-between items-center mb-4">
    <h2 class="text-xl font-bold">Achievement Levels</h2>
    <a href="{{ route('admin.app.achievements.create') }}" class="px-3 py-2 bg-emerald-500 text-white rounded">Create Level</a>
  </div>

  <div class="grid gap-4">
    @foreach($levels as $lvl)
      <div class="bg-white p-4 rounded shadow flex justify-between items-center">
        <div>
          <h3 class="font-semibold">{{ ucfirst($lvl->role) }} - Level {{ $lvl->level_number }} : {{ $lvl->title }}</h3>
          <p class="text-sm text-gray-600">{{ $lvl->description }}</p>
        </div>
        <div class="flex gap-2">
          <a href="{{ route('admin.app.achievements.edit', $lvl->id) }}" class="px-2 py-1 bg-blue-500 text-white rounded">Edit</a>
          <a href="{{ route('admin.app.achievements.index', ['show'=>$lvl->id]) }}" class="px-2 py-1 bg-gray-200 rounded">View Tasks</a>
        </div>
      </div>
    @endforeach
  </div>

  <div class="mt-4">
    {{ $levels->links() }}
  </div>
</div>
@endsection
