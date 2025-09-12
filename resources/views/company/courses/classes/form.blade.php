<div class="form-container">
    <form method="POST" action="{{ isset($class) ? route('company.courses.classes.update', $class->id) : route('company.courses.classes.store') }}">
        @csrf
        @if(isset($class))
            @method('PUT')
        @endif

        <div class="mb-3">
            <label class="form-label">Course</label>
            <select name="course_id" class="form-control" required>
                <option value="">-- Select Course --</option>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}"
                        {{ old('course_id', $class->course_id ?? '') == $course->id ? 'selected' : '' }}>
                        {{ $course->title }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Teacher</label>
            <select name="teacher_id" class="form-control" required>
                <option value="">-- Select Teacher --</option>
                @foreach($teachers as $teacher)
                    <option value="{{ $teacher->id }}"
                        {{ old('teacher_id', $class->teacher_id ?? '') == $teacher->id ? 'selected' : '' }}>
                        {{ $teacher->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">
            {{ isset($class) ? 'Update Class' : 'Create Class' }}
        </button>
    </form>
</div>
