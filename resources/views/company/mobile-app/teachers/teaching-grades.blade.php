<div class="max-w-5xl mx-auto p-6">

    <h2 class="text-xl font-bold mb-4">
        {{ $teacher->name }} Teaching Details
    </h2>

    <form method="POST" action="{{ route('company.app.teachers.grades.update', $teacher->id) }}">
        @csrf

        @foreach ($grades as $grade)
            <div class="border rounded-lg mb-4">

                {{-- Grade --}}
                <div class="bg-gray-100 px-4 py-2 font-semibold">
                    {{ $grade->name }}
                </div>

                <div class="p-4 space-y-4">
                    @php
                        $gradeSelected = $teacherDetails;
                    @endphp
                    @foreach ($grade->boards as $board)
                        <div class="border rounded p-3">

                            {{-- Board --}}
                            <div class="font-semibold text-blue-600 mb-2">
                                {{ $board->name }}
                            </div>

                            <div class="grid md:grid-cols-2 gap-2">

                                @foreach ($board->subjects as $index => $subject)
                                    @php
                                        $detail = $gradeSelected->where('grade_id', $grade->id)->where('board_id',$board->id)->where('subject_id', $subject->id)->first();

                                        $isChecked = $detail ? true : false;
                                        $onlineChecked = $detail && $detail->online ? true : false;
                                        $offlineChecked = $detail && $detail->offline ? true : false;
                                    @endphp

                                    <div class="border rounded p-2 flex justify-between items-center">

                                        <label role="button">
                                            <input type="checkbox" class="mr-2 subject-checkbox border"
                                                name="data[{{ $grade->id }}][{{ $board->id }}][subject][{{ $subject->id }}][id]"
                                                value="{{ $subject->id }}" {{ $isChecked ? 'checked' : '' }}>

                                            {{ $subject->name }}
                                        </label>

                                        {{-- Mode --}}
                                        <div class="text-xs flex gap-2">

                                            <label>
                                                <input type="checkbox" value="1" disabled
                                                    class="online-toggle border rounded-circle"
                                                    name="data[{{ $grade->id }}][{{ $board->id }}][subject][{{ $subject->id }}][online]"
                                                    {{ $onlineChecked ? 'checked' : '' }}>
                                                Online
                                            </label>

                                            <label>
                                                <input type="checkbox" value="1" disabled
                                                    class="offline-toggle border rounded-circle"
                                                    name="data[{{ $grade->id }}][{{ $board->id }}][subject][{{ $subject->id }}][offline]"
                                                    {{ $offlineChecked ? 'checked' : '' }}>
                                                Offline
                                            </label>

                                        </div>

                                    </div>
                                @endforeach

                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        @endforeach

        <button class="bg-blue-600 text-white text-center px-6 py-2 rounded-lg">
            Save Details
        </button>

    </form>
</div>
