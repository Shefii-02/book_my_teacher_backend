<div class="form-container">
    <form method="POST" action="{{ isset($livestream) ? route('livestream_classes.update', $livestream->id) : route('livestream_classes.store') }}">
        @csrf
        @if(isset($livestream)) @method('PUT') @endif

        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control"
                   value="{{ old('title', $livestream->title ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control">{{ old('description', $livestream->description ?? '') }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Duration (minutes)</label>
            <input type="number" name="duration" class="form-control"
                   value="{{ old('duration', $livestream->duration ?? 60) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Teachers</label>
            <select name="teachers[]" class="form-control" multiple required>
                @foreach($teachers as $teacher)
                    <option value="{{ $teacher->id }}"
                        {{ (isset($livestream) && $livestream->teachers->contains($teacher->id)) || in_array($teacher->id, old('teachers', [])) ? 'selected' : '' }}>
                        {{ $teacher->name }}
                    </option>
                @endforeach
            </select>
            <small>Select multiple teachers (Ctrl+Click)</small>
        </div>

        <div class="mb-3">
            <label class="form-label">Student Permissions</label><br>
            <label><input type="checkbox" name="allow_voice" {{ old('allow_voice', $livestream->permissions->allow_voice ?? true) ? 'checked' : '' }}> Voice</label><br>
            <label><input type="checkbox" name="allow_video" {{ old('allow_video', $livestream->permissions->allow_video ?? false) ? 'checked' : '' }}> Video</label><br>
            <label><input type="checkbox" name="allow_screen_share" {{ old('allow_screen_share', $livestream->permissions->allow_screen_share ?? false) ? 'checked' : '' }}> Screen Share</label><br>
            <label><input type="checkbox" name="allow_chat" {{ old('allow_chat', $livestream->permissions->allow_chat ?? true) ? 'checked' : '' }}> Chat</label>
        </div>

        <button type="submit" class="btn btn-success">
            {{ isset($livestream) ? 'Update Livestream' : 'Create Livestream' }}
        </button>
    </form>
</div>
