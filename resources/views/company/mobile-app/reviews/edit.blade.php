<div class="flex-auto p-5 overflow-x-auto">
    <form method="POST"
        action="{{ isset($review) ? route('company.app.reviews.update', $review->id) : route('company.app.reviews.store') }}">
        @csrf
        @if (isset($review))
            @method('PUT')
        @endif



        {{-- Student search (simple) --}}
        <div class="mb-4">
            <label class="block text-sm font-medium">Student</label>
            {{-- CUSTOMER DETAILS (AUTO-FILL OR MANUAL) --}}
            <div id="studentDetails">
                <div class="p-2 border-b cursor-pointer studentRow"><b>{{ $review->user->name }}</b><br>
                    <small>{{ $review->user->email || '' }}
                        {{ $review->user->mobile || '' }}</small>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-3 gap-4 mb-4">
            <!-- COURSES -->
            <div>
                <label class="font-semibold">Course : {{ $review->course->title }}</label>
            </div>

            <!-- TEACHERS -->
            <div>
                <label class="font-semibold">Teacher : {{ $review->teacher?->name }}</label>
            </div>

            <!-- SUBJECT -->
            <div>
                <label class="font-semibold">Subject : {{ $review->subject_id }}</label>
            </div>

            <!-- COMMENTS -->
            <div class="col-span-2">
                <label class="font-semibold">Comments</label>
                <textarea name="comments" class="w-full border rounded px-3 py-2">{{ old('comments', $review->comments ?? '') }}</textarea>
            </div>

            <!-- RATING -->
            <div>
                <label class="font-semibold">Rating</label>
                <input type="number" name="rating" min="1" max="5"
                    value="{{ old('rating', $review->rating ?? '') }}" class="w-full border rounded px-3 py-2">
            </div>
        </div>

        <button class="bg-blue-600 text-white px-6 py-2 rounded shadow hover:bg-blue-700">
            {{ isset($review) ? 'Update' : 'Create' }}
        </button>
    </form>
</div>
