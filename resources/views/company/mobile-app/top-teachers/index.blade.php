@extends('layouts.mobile-layout')

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
                aria-current="page">Top Teachers</li>
        </ol>
        <h6 class="mb-0 font-bold text-white capitalize">Top Teachers List</h6>
    </nav>
@endsection


@section('content')
    <div class="w-full px-6 py-6 mx-auto">

        <div class="flex flex-wrap -mx-3 mt-4">
            <div class="flex-none w-full max-w-full px-3">
                <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white shadow-xl rounded-2xl">

                    <div class="p-6 pb-0 mb-3 border-b border-transparent rounded-t-2xl">
                        <div class="flex justify-between">
                            <h6>Top Teachers Setup</h6>

                        </div>
                    </div>

                    <div class="flex-auto px-3 pt-0 pb-2 mb-6 overflow-x-auto">
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4" id="teacherGrid">
                            @foreach ($teachers as $t)
                                <div class="bg-emerald-500/50 shadow rounded-lg p-3 cursor-move teacher-card"
                                    data-id="{{ $t->id }}">
                                    <div class="mb-2 flex justify-end justify-between">
                                        <label class="flex items-center gap-2 mt-2">
                                            <input type="checkbox" class="topToggle border" data-id="{{ $t->id }}"
                                                @if ($t->position) checked @endif>
                                            <span class="text-sm">Mark Top Teacher</span>
                                        </label>

                                        <i class="bi bi-arrows-move text-xl" title="Drag and Drop Showing Position"></i>
                                    </div>
                                    <div class="mb-2 flex gap-3">
                                        <img src="{{ $t->thumbnail_url ?? '/default.jpg' }}"
                                            class="w-16 mt-3 object-cover rounded">
                                        <div class="flex flex-col">
                                            <h6 class="font-semibold mt-2 capitalize">{{ $t->name }}</h6>
                                            <p class="text-gray-500 text-sm">Subject: {{ $t->subject }}</p>
                                        </div>

                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

    <script>
        // Enable Drag & Drop
        new Sortable(document.getElementById('teacherGrid'), {
            animation: 150,
            onEnd: function() {
                let order = [];
                document.querySelectorAll('.teacher-card').forEach((el) => {
                    order.push(el.dataset.id);
                });

                fetch('/company/app/top-teachers/reorder', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        positions: order
                    })
                });
            }
        });

        // Toggle select/unselect top teacher
        document.querySelectorAll('.topToggle').forEach((checkbox) => {
            checkbox.addEventListener('change', function() {
                fetch('/company/app/top-teachers/toggle', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        teacher_id: this.dataset.id
                    })
                });
            });
        });
    </script>
@endsection
