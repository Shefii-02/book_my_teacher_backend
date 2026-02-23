<div class="mt-4">
    <h4 class="font-bold mb-3">Tasks level List</h4>

    <ul>
        @foreach ($tasks as $task)
            <li class="border p-3 rounded mb-2 flex justify-between items-center">
                <div>
                    <div class="text-sm font-semibold">{{ $task->title }}
                        ({{ $task->task_type }})
                    </div>
                    <div class="text-xs text-gray-500">Target: {{ $task->target_value }} •
                        Points: {{ $task->points }}</div>
                </div>
                <form id="form_{{ $task->id }}" class="m-0 p-0"
                    action="{{ route('company.app.achievements.tasks.destroy', $task->id) }}" method="POST"
                    class="inline-block">
                    @csrf @method('DELETE') </form>
                <a role="button" href="javascript:;" class="block px-4 py-2 text-danger"
                    onclick="confirmDelete({{ $task->id }})"><i class="bi bi-trash"></i></a>

            </li>
        @endforeach
    </ul>
</div>
