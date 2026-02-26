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



                    <div class="flex-auto px-0 pt-0 pb-2">
                        <div class="p-0 overflow-x-auto">
                            <form method="GET" class="card p-3 mb-3">

                                <div class="row g-2">

                                    <!-- Grade -->
                                    <div class="col-md-2">
                                        <select name="grade_id" id="gradeSelect" class="form-control border">
                                            <option value="">Grade</option>
                                            @foreach ($grades as $grade)
                                                <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Board -->
                                    <div class="col-md-2">
                                        <select name="board_id" id="boardSelect" class="form-control border">
                                            <option value="">Board</option>
                                        </select>
                                    </div>

                                    <!-- Subject -->
                                    <div class="col-md-2">
                                        <select name="subject_id" id="subjectSelect" class="form-control border">
                                            <option value="">Subject</option>
                                        </select>
                                    </div>

                                    <!-- Mode -->
                                    <div class="col-md-1">
                                        <select name="mode" class="form-control border">
                                            <option value="">Mode</option>
                                            <option value="online">Online</option>
                                            <option value="offline">Offline</option>
                                        </select>
                                    </div>

                                    <!-- District -->
                                    <div class="col-md-2">
                                        <input type="text" name="district" class="form-control border" placeholder="District">
                                    </div>

                                    <!-- Rating -->
                                    <div class="col-md-1">
                                        <select name="rating" class="form-control border">
                                            <option value="">⭐</option>
                                            @for ($i = 1; $i <= 5; $i++)
                                                <option value="{{ $i }}">{{ $i }}+</option>
                                            @endfor
                                        </select>
                                    </div>

                                    <!-- Status -->
                                    <div class="col-md-2">
                                        <select name="status" class="form-control border">
                                            <option value="">Status</option>
                                            <option value="pending">Pending</option>
                                            <option value="approved">Approved</option>
                                            <option value="rejected">Rejected</option>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        const grades = @json($grades);

        // Grade → Boards
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
            $('#subjectSelect').html('<option value="">Subject</option>');
        });

        // Board → Subjects
        $('#boardSelect').on('change', function() {
            const gradeId = $('#gradeSelect').val();
            const boardId = $(this).val();

            const grade = grades.find(g => g.id == gradeId);
            const board = grade?.boards.find(b => b.id == boardId);

            let subjects = '<option value="">Subject</option>';
            if (board) {
                board.subjects.forEach(s => {
                    subjects += `<option value="${s.id}">${s.name}</option>`;
                });
            }

            $('#subjectSelect').html(subjects);
        });
    </script>
@endpush
