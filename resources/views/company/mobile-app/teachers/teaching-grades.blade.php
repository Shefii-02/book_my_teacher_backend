<div class="max-w-5xl mx-auto p-6">

    {{-- Header --}}
    <div class="flex justify-between items-center mb-4">

        <h2 class="text-xl font-bold">
            {{ $teacher->name }} Teaching Details
        </h2>

        {{-- Toggle Button --}}
        <button type="button"
            id="toggleAllBtn"
            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg text-sm transition">
            Check All
        </button>

    </div>

    <form method="POST"
        action="{{ route('company.app.teachers.grades.update', $teacher->id) }}">

        @csrf

        @foreach ($grades as $grade)

            <div class="border rounded-xl mb-5 overflow-hidden shadow-sm">

                {{-- Grade Header --}}
                <div class="bg-gray-100 px-4 py-3 font-semibold text-gray-700">
                    {{ $grade->name }}
                </div>

                <div class="p-4 space-y-4">

                    @php
                        $gradeSelected = $teacherDetails;
                    @endphp

                    @foreach ($grade->boards as $board)

                        <div class="border rounded-lg p-4">

                            {{-- Board --}}
                            <div class="font-semibold text-blue-600 mb-4">
                                {{ $board->name }}
                            </div>

                            <div class="grid md:grid-cols-2 gap-3">

                                @foreach ($board->subjects as $subject)

                                    @php
                                        $detail = $gradeSelected
                                            ->where('grade_id', $grade->id)
                                            ->where('board_id', $board->id)
                                            ->where('subject_id', $subject->id)
                                            ->first();

                                        $isChecked = $detail ? true : false;
                                        $onlineChecked = $detail && $detail->online ? true : false;
                                        $offlineChecked = $detail && $detail->offline ? true : false;
                                    @endphp

                                    <div
                                        class="border rounded-lg p-3 flex justify-between items-center bg-white hover:bg-gray-50 transition">

                                        {{-- Subject --}}
                                        <label class="flex items-center cursor-pointer">

                                            <input type="checkbox"
                                                class="mr-3 subject-checkbox w-4 h-4"
                                                name="data[{{ $grade->id }}][{{ $board->id }}][subject][{{ $subject->id }}][id]"
                                                value="{{ $subject->id }}"
                                                {{ $isChecked ? 'checked' : '' }}>

                                            <span class="font-medium text-gray-700">
                                                {{ $subject->name }}
                                            </span>

                                        </label>

                                        {{-- Mode --}}
                                        <div class="text-xs flex gap-4">

                                            <label class="flex items-center gap-1">

                                                <input type="checkbox"
                                                    value="1"
                                                    disabled
                                                    class="online-toggle"
                                                    name="data[{{ $grade->id }}][{{ $board->id }}][subject][{{ $subject->id }}][online]"
                                                    {{ $onlineChecked ? 'checked' : '' }}>

                                                <span>Online</span>

                                            </label>

                                            <label class="flex items-center gap-1">

                                                <input type="checkbox"
                                                    value="1"
                                                    disabled
                                                    class="offline-toggle"
                                                    name="data[{{ $grade->id }}][{{ $board->id }}][subject][{{ $subject->id }}][offline]"
                                                    {{ $offlineChecked ? 'checked' : '' }}>

                                                <span>Offline</span>

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

        {{-- Submit --}}
        <div class="mt-6">

            <button type="submit"
                class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg transition">

                Save Details

            </button>

        </div>

    </form>

</div>

<script>

    document.addEventListener("DOMContentLoaded", function () {

        const toggleBtn = document.getElementById('toggleAllBtn');

        // =========================
        // Toggle All
        // =========================
        toggleBtn.addEventListener('click', function () {

            let checkboxes = document.querySelectorAll('.subject-checkbox');

            // Check all already selected?
            let allChecked = [...checkboxes].every(cb => cb.checked);

            if (allChecked) {

                // Uncheck All
                checkboxes.forEach(function (checkbox) {
                    checkbox.checked = false;
                });

                toggleBtn.innerText = 'Check All';

            } else {

                // Check All
                checkboxes.forEach(function (checkbox) {
                    checkbox.checked = true;
                });

                toggleBtn.innerText = 'Uncheck All';
            }

        });

        // =========================
        // Update Button Text
        // =========================
        function updateToggleButton() {

            let checkboxes = document.querySelectorAll('.subject-checkbox');

            let allChecked = [...checkboxes].every(cb => cb.checked);

            if (allChecked) {

                toggleBtn.innerText = 'Uncheck All';

                toggleBtn.classList.remove('bg-blue-600', 'hover:bg-blue-700');

                toggleBtn.classList.add('bg-red-600', 'hover:bg-red-700');

            } else {

                toggleBtn.innerText = 'Check All';

                toggleBtn.classList.remove('bg-red-600', 'hover:bg-red-700');

                toggleBtn.classList.add('bg-blue-600', 'hover:bg-blue-700');
            }

        }

        // =========================
        // Listen Checkbox Changes
        // =========================
        document.querySelectorAll('.subject-checkbox').forEach(function (checkbox) {

            checkbox.addEventListener('change', function () {

                updateToggleButton();

            });

        });

        // Initial Check
        updateToggleButton();

    });

</script>
