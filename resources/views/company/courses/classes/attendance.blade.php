<style>
    .pal-toggle {
        display: inline-flex;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid #ddd;
    }

    .pal-toggle input {
        display: none;
    }

    .pal-toggle label {
        width: 36px;
        height: 32px;
        font-size: 13px;
        font-weight: 600;
        text-align: center;
        line-height: 32px;
        cursor: pointer;
        background: #f5f5f5;
        color: #999;
        border-right: 1px solid #ddd;
        transition: all 0.2s ease;
    }

    .pal-toggle label:last-child {
        border-right: none;
    }

    .pal-toggle input:checked+label.present {
        background: #e8f5e9;
        color: #2e7d32;
        font-weight: 700;
    }

    .pal-toggle input:checked+label.absent {
        background: #ffebee;
        color: #c62828;
        font-weight: 700;
    }

    .pal-toggle input:checked+label.late {
        background: #fff8e1;
        color: #f57f17;
        font-weight: 700;
    }

    .pal-toggle label:hover {
        opacity: 0.8;
    }
</style>

<div class="container">

    <h4 class="mb-2">Take Attendance</h4>
    <p class="text-muted">{{ $class->title }} · {{ $class->date }}</p>

    {{-- Toolbar --}}
    <div class="mb-3 d-flex flex-wrap gap-2">
        <span class="badge bg-warning text-dark">Pending: <span id="pendingCount">0</span></span>
        <span class="badge bg-success">Present: <span id="presentCount">0</span></span>
        <span class="badge bg-danger">Absent: <span id="absentCount">0</span></span>
        <span class="badge bg-info text-dark">Late: <span id="lateCount">0</span></span>
        <span class="ms-auto">{{ count($students) }} students</span>
    </div>

    {{-- Quick Actions --}}
    <div class="mb-3">
        <button class="btn btn-success btn-sm" onclick="markAll('present')">Mark All Present</button>
        <button class="btn btn-danger btn-sm" onclick="markAll('absent')">Mark All Absent</button>
        <button class="btn btn-secondary btn-sm" onclick="markAll('reset')">Reset</button>
    </div>

    {{-- Search + Filter --}}
    <div class="row mb-3">
        <div class="col-md-6">
            <input type="text" id="search" class="form-control border rounded" placeholder="Search...">
        </div>
        <div class="col-md-6">
            <select id="filter" class="form-select border rounded">
                <option value="">All</option>
                <option value="pending">Pending</option>
                <option value="present">Present</option>
                <option value="absent">Absent</option>
                <option value="late">Late</option>
            </select>
        </div>
    </div>

    {{-- Table --}}
    <form method="POST"
        action="{{ route('company.courses.schedule-class.attendance.update', ['identity' => $class->course->course_identity, 'schedule_class' => $class->id]) }}">
        @csrf
        <input type="hidden" name="class_id" value="{{ $class->id }}">

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody id="studentTable">
                @foreach ($students as $key => $s)
                    <tr data-name="{{ strtolower($s['name']) }}" data-roll="{{ strtolower($s['roll_number']) }}">
                        <td>{{ $s['name'] }}</td>
                        <td>
                            <div class="pal-toggle">
                                <input type="hidden" name="records[{{ $key }}][user_id]"
                                    value="{{ $s['student_id'] }}" />
                                <input type="hidden" id="n_{{ $s['id'] }}"
                                    name="records[{{ $key }}][status]" value="none"
                                    {{ $s['status'] == 'none' ? 'checked' : '' }}>
                                {{-- Present --}}
                                <input type="radio" id="p_{{ $s['id'] }}"
                                    name="records[{{ $key }}][status]" value="present"
                                    {{ $s['status'] == 'present' ? 'checked' : '' }}>
                                <label for="p_{{ $s['id'] }}" class="present">P</label>

                                {{-- Absent --}}
                                <input type="radio" id="a_{{ $s['id'] }}"
                                    name="records[{{ $key }}][status]" value="absent"
                                    {{ $s['status'] == 'absent' ? 'checked' : '' }}>
                                <label for="a_{{ $s['id'] }}" class="absent">A</label>

                                {{-- Late --}}
                                <input type="radio" id="l_{{ $s['id'] }}"
                                    name="records[{{ $key }}][status]" value="late"
                                    {{ $s['status'] == 'late' ? 'checked' : '' }}>
                                <label for="l_{{ $s['id'] }}" class="late">L</label>

                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <button class="btn btn-primary w-100">Save Attendance</button>
    </form>

</div>

{{-- JS --}}
<script>
    function updateCounts() {
        let present = 0,
            absent = 0,
            late = 0,
            pending = 0;

        document.querySelectorAll('#studentTable tr').forEach(row => {
            let checked = row.querySelector('input[type=radio]:checked');
            if (!checked) pending++;
            else if (checked.value === 'present') present++;
            else if (checked.value === 'absent') absent++;
            else if (checked.value === 'late') late++;
        });

        document.getElementById('presentCount').innerText = present;
        document.getElementById('absentCount').innerText = absent;
        document.getElementById('lateCount').innerText = late;
        document.getElementById('pendingCount').innerText = pending;
    }

    function markAll(status) {
        if (status === 'reset') {
            document.querySelectorAll('#studentTable input[type=radio]').forEach(el => {
                el.checked = false;
            });
        } else {
            document.querySelectorAll('#studentTable tr').forEach(row => {
                let input = row.querySelector(`input[value="${status}"]`);
                if (input) input.checked = true;
            });
        }
        updateCounts();
    }

    function applyFilters() {
        let search = document.getElementById('search').value.toLowerCase();
        let filter = document.getElementById('filter').value;

        document.querySelectorAll('#studentTable tr').forEach(row => {
            let name = row.dataset.name || '';
            let roll = row.dataset.roll || '';
            let nameMatch = name.includes(search) || roll.includes(search);

            let checked = row.querySelector('input[type=radio]:checked');
            let status = checked ? checked.value : 'pending';
            let filterMatch = filter === '' || filter === status;

            row.style.display = (nameMatch && filterMatch) ? '' : 'none';
        });
    }

    document.querySelectorAll('#studentTable input[type=radio]').forEach(el => {
        el.addEventListener('change', () => {
            updateCounts();
            applyFilters();
        });
    });

    document.getElementById('search').addEventListener('keyup', applyFilters);
    document.getElementById('filter').addEventListener('change', applyFilters);

    updateCounts();
</script>
