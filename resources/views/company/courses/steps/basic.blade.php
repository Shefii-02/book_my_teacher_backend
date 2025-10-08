
                <div class="mb-3">
                    <label class="form-label">Category</label>
                    <select name="category_id" class="form-control" required>
                        <option value="">-- Select Category --</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}"
                                {{ isset($course) && $course->category_id == $cat->id ? 'selected' : '' }}>
                                {{ $cat->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" value="{{ old('title', $course->title ?? '') }}"
                        class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description', $course->description ?? '') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Duration</label>
                    <div class="flex space-x-2">
                        <input type="number" name="duration" value="{{ old('duration', $course->duration ?? '') }}"
                            class="form-control" style="width: 100px;">
                        <select name="duration_type" class="form-control">
                            <option value="minutes"
                                {{ isset($course) && $course->duration_type == 'minutes' ? 'selected' : '' }}>Minutes
                            </option>
                            <option value="hours"
                                {{ isset($course) && $course->duration_type == 'hours' ? 'selected' : '' }}>Hours</option>
                            <option value="days"
                                {{ isset($course) && $course->duration_type == 'days' ? 'selected' : '' }}>Days</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Start Date</label>
                    <input type="datetime-local" name="stated_at" value="{{ old('stated_at', $course->stated_at ?? '') }}"
                        class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">End Date</label>
                    <input type="datetime-local" name="ended_at" value="{{ old('ended_at', $course->ended_at ?? '') }}"
                        class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Thumbnail</label>
                    <input type="file" name="thumbnail" class="form-control">
                    @if (isset($course) && $course->thumbnail)
                        <img src="{{ asset('storage/' . $course->thumbnail) }}" class="h-16 mt-2">
                    @endif
                </div>

