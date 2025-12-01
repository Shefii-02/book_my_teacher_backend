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
                aria-current="page">Providing Subjects</li>
        </ol>
        <h6 class="mb-0 font-bold text-white capitalize">Providing Subjects List</h6>
    </nav>
@endsection

@section('content')
    <div class="w-full px-6 py-6 mx-auto">

        <div class="flex flex-wrap -mx-3 mt-4">
            <div class="flex-none w-full max-w-full px-3">
                <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white shadow-xl rounded-2xl">

                    <div class="p-6 pb-0 mb-3 border-b border-transparent rounded-t-2xl">
                        <div class="flex justify-between">
                            <h6>Providing Subjects Setup</h6>
                        </div>
                    </div>

                    <div class="flex-auto px-3 pt-0 pb-2 mb-6 overflow-x-auto">

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4" id="subjectGrid">

                            @foreach ($subjects as $subject)
                                @php
                                    $provide = $providings[$subject->id] ?? null;
                                @endphp

                                <div class="bg-emerald-500/50 shadow rounded-lg p-3 cursor-move subject-card"
                                    data-id="{{ $subject->id }}">

                                    <div class="mb-2 flex justify-between">
                                        <label class="flex items-center gap-2 mt-2">
                                            <input type="checkbox" class="topToggle border" data-id="{{ $subject->id }}"
                                              @if ($subject->position) checked @endif >
                                            <span class="text-sm">Mark Providing Subject</span>
                                        </label>

                                        <i class="bi bi-arrows-move text-xl" title="Drag and Drop Position"></i>
                                    </div>

                                    <div class="mb-2 flex gap-3">
                                        <img src="{{ $subject->icon_url ?? '/default.jpg' }}"
                                            class="w-16 mt-3 object-cover rounded">
                                        <div class="flex flex-col">
                                            <h6 class="font-semibold mt-2 capitalize">{{ $subject->name }}</h6>
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
        // Enable sorting
        new Sortable(document.getElementById('subjectGrid'), {
            animation: 150,
            onEnd: function() {
                let order = [];

                document.querySelectorAll('.subject-card').forEach((el) => {
                    let checkbox = el.querySelector('.topToggle');

                    if (checkbox.checked) {
                        order.push(el.dataset.id);
                    }
                });

                fetch("{{ route('admin.app.providing.reorder') }}", {
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

        // Toggle providing subject
        document.querySelectorAll('.topToggle').forEach((checkbox) => {
            checkbox.addEventListener('change', function() {
                fetch("{{ route('admin.app.providing.toggle') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        subject_id: this.dataset.id,
                        checked: this.checked
                    })
                });
            });
        });
    </script>
@endsection
