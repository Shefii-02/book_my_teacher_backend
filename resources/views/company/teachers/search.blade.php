@extends('layouts.layout')

@section('nav-options')
    <nav>
        <!-- breadcrumb -->
        <ol class="flex flex-wrap pt-1 mr-12 bg-transparent rounded-lg sm:mr-16">
            <li class="text-neutral-900 text-sm">
                <a class="text-white " href="javascript:;">Home</a>
            </li>
            <li
                class="ltext-sm pl-2 capitalize text-neutral-900 text-white before:float-left before:pr-2 before:text-white before:content-['/']">
                <a class="text-white" href="javascript:;">Dashboard</a>
            </li>
            <li class="text-sm pl-2  font-bold capitalize  text-white before:float-left before:pr-2 before:text-white before:content-['/']"
                aria-current="page">Teachers List</li>
        </ol>
        <h6 class="mb-0 font-bold text-white capitalize">Teacher List</h6>
    </nav>
@endsection

@push('styles')
    <style>
        /* TomSelect Badge Style */
        .ts-control {
            border-radius: 8px !important;
            padding: 6px !important;
            min-height: 42px;
        }

        /* Badge */
        .ts-control .item {
            background: #4f46e5;
            color: #fff;
            border-radius: 9px;
            padding: 4px 10px;
            margin: 3px;
            font-size: 13px;
        }

        /* Remove button */
        .ts-control .remove {
            color: #ff0000 !important;
            margin-left: 6px;
        }

        /* Hover */
        .ts-control .item:hover {
            background: #3730a3;
        }

        .badge {
            font-size: 13px;
            padding: 6px 10px;
            border-radius: 3px;
        }

        .card .badge {
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        }
    </style>
@endpush

@section('content')
    <!-- cards -->
    <div class="w-full px-6 py-6 mx-auto">
        <!-- table 1 -->
        <div class="flex flex-wrap -mx-3 mt-4">
            <div class="flex-none w-full max-w-full px-3">
                <div
                    class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                    <div class="p-6 pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                        <div>
                            <div class="w-full max-w-full ">
                                <h6 class="dark:text-white">Teachers List</h6>
                            </div>
                        </div>
                    </div>

                    <div class="flex-auto px-0 pt-0 ">
                        <div class="p-0 overflow-x-auto">
                            <form method="GET" class="card p-3">

                                <div class="row g-2">
                                    <!-- Grade -->
                                    <div class="col-md-6">
                                        <select name="grade_id" id="gradeSelect" class="form-control border">
                                            <option value="">Grade</option>
                                            @foreach ($grades as $grade)
                                                <option {{ request()->grade_id == $grade->id ? 'selected' : '' }}
                                                    value="{{ $grade->id }}">{{ $grade->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Board -->
                                    <div class="col-md-6">
                                        <select name="board_id" id="boardSelect" class="form-control border">
                                            <option value="">Board</option>
                                            @foreach ($boards as $board)
                                                <option {{ request()->board_id == $board->id ? 'selected' : '' }}
                                                    value="{{ $board->id }}">{{ $board->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Subject -->
                                    <div class="col-md-12">
                                        <select name="subject_id[]" id="subjectSelect" multiple class="form-control border">
                                            <option value="">Subject</option>
                                            @foreach ($subjects as $subject)
                                                <option
                                                    {{ isset(request()->subject_id) && in_array(request()->subject_id, $subject->id) ? 'selected' : '' }}
                                                    value="{{ $board->id }}">{{ $board->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Mode -->
                                    <div class="col-md-3">
                                        <select name="mode" class="form-control border">
                                            <option value="">Mode</option>
                                            <option {{ request()->mode == 'online' ? 'selected' : '' }} value="online">
                                                Online</option>
                                            <option {{ request()->mode == 'offline' ? 'selected' : '' }} value="offline">
                                                Offline</option>
                                        </select>
                                    </div>

                                    <!-- Rating -->
                                    <div class="col-md-3">
                                        <select name="rating" class="form-control border">
                                            <option value="">All ⭐</option>
                                            @for ($i = 1; $i <= 5; $i++)
                                                <option {{ request()->rating == $i ? 'selected' : '' }}
                                                    value="{{ $i }}">{{ $i }} ⭐+</option>
                                            @endfor
                                        </select>
                                    </div>



                                    <!-- District -->
                                    <div class="col-md-3">
                                        <input type="text" name="district" class="form-control border"
                                            placeholder="District">
                                    </div>

                                    <!-- Status -->
                                    <div class="col-md-3">
                                        <select name="status" class="form-control border">

                                            <option {{ request()->status == 'approved' ? 'selected' : '' }}
                                                value="approved">Approved</option>
                                            <option {{ request()->status == 'pending' ? 'selected' : '' }} value="pending">
                                                Pending</option>
                                            <option {{ request()->status == 'rejected' ? 'selected' : '' }}
                                                value="rejected">Rejected</option>
                                        </select>
                                    </div>

                                </div>
                                <br>

                                <div class=" text-center my-3">
                                    <button class="btn btn-primary btn-sm">Search</button>
                                    <a href="" class="btn btn-danger text-light btn-sm">Reset</a>
                                </div>
                            </form>
                        </div>

                        @if (request()->anyFilled(['grade_id', 'board_id', 'subject_id', 'mode', 'rating', 'status', 'district']))
                            <div class="card px-3 ">
                                        <h6>Searching by :</h6>
                                <div class="d-flex flex-wrap gap-2">

                                    {{-- Grade --}}
                                    @if (request('grade_id'))
                                        <span class="badge bg-primary">
                                            Grade: {{ $grades->firstWhere('id', request('grade_id'))?->name }}
                                        </span>
                                    @endif

                                    {{-- Board --}}
                                    @if (request('board_id'))
                                        @php
                                            $board = collect($grades)
                                                ->pluck('boards')
                                                ->flatten()
                                                ->firstWhere('id', request('board_id'));
                                        @endphp
                                        <span class="badge bg-info text-dark">
                                            Board: {{ $board?->name }}
                                        </span>
                                    @endif

                                    {{-- Subjects (MULTI) --}}
                                    @if (request()->filled('subject_id'))
                                        @php
                                            $allSubjects = collect($grades)
                                                ->pluck('boards')
                                                ->flatten()
                                                ->pluck('subjects')
                                                ->flatten();
                                        @endphp
                                         Subjects:
                                        @foreach (request('subject_id') as $sid)
                                            <span class="badge bg-success">
                                                {{ $allSubjects->firstWhere('id', $sid)?->name }}
                                            </span>
                                        @endforeach
                                    @endif

                                    {{-- Mode --}}
                                    @if (request('mode'))
                                        <span class="badge bg-warning text-dark">
                                            Mode: {{ ucfirst(request('mode')) }}
                                        </span>
                                    @endif

                                    {{-- Rating --}}
                                    @if (request('rating'))
                                        <span class="badge bg-dark">
                                            Rating: ⭐ {{ request('rating') }}+
                                        </span>
                                    @endif

                                    {{-- Status --}}
                                    @if (request('status'))
                                        <span class="badge bg-success">
                                          Acccount Status :   {{ ucfirst(request('status')) }}
                                        </span>
                                    @endif

                                    {{-- District --}}
                                    @if (request('district'))
                                        <span class="badge bg-danger">
                                           District : 📍 {{ ucfirst(request('district')) }}
                                        </span>
                                    @endif

                                </div>
                            </div>
                        @endif


                        {{-- ================= TEACHER CARDS ================= --}}
                        <div class="space-y-4 p-3">

                            @forelse ($teachers as $t)
                                <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition p-4 relative border">
                                    <a href="">
                                        {{-- Main Content --}}
                                        <div class="flex items-start gap-4">
                                            <div class="flex flex-col gap-2 ">

                                                {{-- Profile --}}
                                                <img src="{{ $t->thumbnail_url }}"
                                                    class="h-16 w-16 rounded-xl object-cover shadow" />
                                                @if ($t->status == 1)
                                                    <span
                                                        class="bg-success text-center text-light px-2 py-0.5 rounded text-xxs font-semibold">
                                                        Active
                                                    </span>
                                                @else
                                                    <span
                                                        class="bg-danger text-center text-light px-2 py-0.5 rounded text-xxs font-semibold">
                                                        Disabled
                                                    </span>
                                                @endif

                                            </div>
                                            {{-- Details --}}
                                            <div class="flex">

                                                {{-- Name + Status --}}
                                                <div class="flex items-center gap-3 me-3">
                                                    <div class="text-base font-semibold text-gray-900">
                                                        {{ $t->name }} <p class="text-xxs">
                                                            {{ $t->email }}<br>{{ $t->mobile }}</p>
                                                    </div>


                                                </div>


                                                {{-- Info Row --}}
                                                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-3 text-xs">
                                                    <div class="flex flex-col">
                                                        <div class="flex gap-2">
                                                            <p class="text-gray-400">Grades</p>
                                                            <p class="font-medium text-gray-700">
                                                                {{ implodeComma($t->teachingGrades?->pluck('name')) ?: '-' }}
                                                            </p>
                                                        </div>
                                                        <div class="flex gap-2">
                                                            <p class="text-gray-400">Boards</p>
                                                            <p class="font-medium text-gray-700">
                                                                {{ implodeComma($t->teachingBoards?->pluck('name')) ?: '-' }}
                                                            </p>
                                                        </div>
                                                        <div class="flex gap-2">
                                                            <p class="text-gray-400">Subjects</p>
                                                            <p class="font-medium text-gray-700">
                                                                {{ implodeComma($t->teachingSubjects?->pluck('name')) ?: '-' }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <p class="text-gray-400">Courses</p>
                                                        <p class="font-medium text-gray-700">
                                                            {{ $t->courses()->count() }} Total
                                                            •
                                                            {{ $t->courses->where('ended_at', '>=', date('Y-m-d'))->count() }}
                                                            Ongoing
                                                        </p>
                                                    </div>

                                                    <div>
                                                        <p class="text-gray-400">Earnings</p>
                                                        <p class="font-semibold text-gray-900">
                                                            ₹{{ number_format($t->earnings_total, 0) }}
                                                        </p>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </a>
                                </div>

                            @empty
                                <div class="text-center py-10 text-gray-400 bg-white rounded-xl shadow">
                                    No teachers found
                                </div>
                            @endforelse

                        </div>

                        <div class="d-flex justify-content-center m-4">
                            {!! $teachers->links() !!}
                        </div>
                        <p class="p-3">Showing {{ $teachers->firstItem() }} to {{ $teachers->lastItem() }} of
                            {{ $teachers->total() }} users.</p>

                    </div>



                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>

    <script>
        const grades = @json($grades);

        let subjectSelect;

        // Initialize TomSelect ONCE
        $(document).ready(function() {
            subjectSelect = new TomSelect("#subjectSelect", {
                plugins: ['remove_button'],
                placeholder: "Select Subjects",
                create: false,
                persist: false,
                closeAfterSelect: true,
                hideSelected: true,
                maxOptions: 1000
            });
        });


        // ================= GRADE → BOARDS =================
        $('#gradeSelect').on('change', function() {

            const gradeId = $(this).val();
            const grade = grades.find(g => g.id == gradeId);

            let boards = '<option value="">Board</option>';
            if (grade) {
                grade.boards.forEach(b => {
                    boards += `<option value="${b.id}">${b.name}</option>`;
                });
            }

            $('#boardSelect').html(boards);

            // Reset subjects safely
            subjectSelect.clearOptions();
            subjectSelect.clear();
        });


        // ================= BOARD → SUBJECTS =================
        $('#boardSelect').on('change', function() {

            const gradeId = $('#gradeSelect').val();
            const boardId = $(this).val();

            const grade = grades.find(g => g.id == gradeId);
            const board = grade?.boards.find(b => b.id == boardId);

            // Reset first
            subjectSelect.clearOptions();
            subjectSelect.clear();

            if (board) {
                board.subjects.forEach(s => {
                    subjectSelect.addOption({
                        value: s.id,
                        text: s.name
                    });
                });
            }

            subjectSelect.refreshOptions(false);
        });
    </script>
@endpush
