@extends('layouts.mobile-layout')

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
              <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white shadow-xl rounded-2xl">

                            <div class="p-6 pb-0 mb-3 border-b border-transparent rounded-t-2xl">
                                <div class="flex justify-between">
                                    <div>
                                        <h6>Filter Teachers </h6>
                                    </div>
                                    <div class="flex gap-3 items-center">
                                        <a href="{{ route('company.app.teachers.index') }}"
                                            class="bg-emerald-500/50 rounded text-sm text-white px-4 fw-bold py-1">
                                            <i class="bi bi-arrow-left me-1 "></i>
                                            Back
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div>


                <div
                    class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">


                    <div class="flex-auto px-0 pt-0 ">

                        <div class="p-0 overflow-x-auto">
                            <form method="GET" class="card p-3" id="filterForm" action="{{ route('company.app.teachers.search') }}">

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
                                                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
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
                                            Acccount Status : {{ ucfirst(request('status')) }}
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
                        <div class="space-y-4 p-3 mt-3" id="teacherTable">

                        @include('company.mobile-app.teachers.search-table')

                        </div>


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
        $(document).ready(function() {
            initInfiniteTable({
                container: '#teacherTable',
                form: '#filterForm',
                url: "{{ route('company.app.teachers.index') }}",

                liveSearch: true,
            });
        });
    </script>

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
