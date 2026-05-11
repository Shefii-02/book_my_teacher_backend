<div class="container py-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <h4 class="fw-bold mb-0">
            Edit Working Hours
        </h4>

        {{-- Toggle All --}}
        <button type="button"
            id="toggleAllBtn"
            class="btn btn-primary px-4">
            Check All
        </button>

    </div>

    <div class="container-fluid">

        <div class="row">

            {{-- LEFT SIDE DAYS --}}
            <div class="col-md-3 border-end">

                <div class="nav flex-column nav-pills"
                    id="v-pills-tab"
                    role="tablist">

                    @foreach ($days as $key => $day)

                        <button class="nav-link {{ $loop->first ? 'active' : '' }}"
                            id="tab-{{ $key }}"
                            data-bs-toggle="pill"
                            data-bs-target="#content-{{ $key }}"
                            type="button">

                            {{ $day }}

                        </button>

                    @endforeach

                </div>

            </div>

            {{-- RIGHT SIDE SLOTS --}}
            <div class="col-md-9">

                <form method="POST"
                    action="{{ route('company.app.teachers.slots.update', $teacherId) }}">

                    @csrf

                    <div class="tab-content">

                        @foreach ($days as $key => $day)

                            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                id="content-{{ $key }}">

                                {{-- Day Header --}}
                                <div class="d-flex justify-content-between align-items-center mb-3">

                                    <h5 class="text-primary mb-0">
                                        {{ $day }} Slots
                                    </h5>

                                </div>

                                <div class="row">

                                    @foreach ($timeSlots as $slot)

                                        @php
                                            $checked =
                                                isset($selectedSlots[$day]) &&
                                                in_array($slot['label'], $selectedSlots[$day]);
                                        @endphp

                                        <div class="col-md-4 mb-3">

                                            <label class="slot-box text-xxs {{ $checked ? 'active' : '' }}">

                                                <input type="checkbox"
                                                    name="slots[{{ $day }}][]"
                                                    class="slot-checkbox border me-2"
                                                    value="{{ $slot['label'] }}"
                                                    {{ $checked ? 'checked' : '' }}>

                                                {{ $slot['label'] }}

                                            </label>

                                        </div>

                                    @endforeach

                                </div>

                            </div>

                        @endforeach

                    </div>

                    {{-- Submit --}}
                    <button class="btn btn-success mt-4 px-4">
                        Update Slots
                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

<style>
    .slot-box {
        display: block;
        border: 1px solid #ddd;
        padding: 10px;
        border-radius: 10px;
        text-align: center;
        cursor: pointer;
        font-size: 14px;
        transition: 0.2s;
        background: #f9f9f9;
    }

    .nav-link {
        text-align: left !important;
    }

    .slot-box:hover {
        border-color: #0d6efd;
        background: #eef5ff;
    }

    .slot-box.active {
        background: #0d6efd;
        color: white;
        border-color: #0d6efd;
    }

    .slot-box input {
        cursor: pointer;
    }
</style>

<script>

    document.addEventListener("DOMContentLoaded", function () {

        const toggleBtn = document.getElementById('toggleAllBtn');

        // ====================================
        // Toggle Active Class
        // ====================================
        function updateSlotUI() {

            document.querySelectorAll('.slot-checkbox').forEach(function (checkbox) {

                const box = checkbox.closest('.slot-box');

                if (checkbox.checked) {

                    box.classList.add('active');

                } else {

                    box.classList.remove('active');
                }

            });

        }

        // ====================================
        // Toggle Button Text + Color
        // ====================================
        function updateToggleButton() {

            const checkboxes = document.querySelectorAll('.slot-checkbox');

            const allChecked = [...checkboxes].every(cb => cb.checked);

            if (allChecked) {

                toggleBtn.innerText = 'Uncheck All';

                toggleBtn.classList.remove('btn-primary');

                toggleBtn.classList.add('btn-danger');

            } else {

                toggleBtn.innerText = 'Check All';

                toggleBtn.classList.remove('btn-danger');

                toggleBtn.classList.add('btn-primary');
            }

        }

        // ====================================
        // Main Toggle Button
        // ====================================
        toggleBtn.addEventListener('click', function () {

            const checkboxes = document.querySelectorAll('.slot-checkbox');

            const allChecked = [...checkboxes].every(cb => cb.checked);

            if (allChecked) {

                // Uncheck All
                checkboxes.forEach(function (checkbox) {
                    checkbox.checked = false;
                });

            } else {

                // Check All
                checkboxes.forEach(function (checkbox) {
                    checkbox.checked = true;
                });
            }

            updateSlotUI();

            updateToggleButton();

        });

        // ====================================
        // Checkbox Change
        // ====================================
        document.querySelectorAll('.slot-checkbox').forEach(function (checkbox) {

            checkbox.addEventListener('change', function () {

                updateSlotUI();

                updateToggleButton();

            });

        });

        // Initial State
        updateSlotUI();

        updateToggleButton();

    });

</script>
